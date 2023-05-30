<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Asset_Request_Controller extends AD_Controller {
	function __construct(){
		parent::__construct();
		if(AUTH_USER_TYPE != 'STORE'):
			redirect('unauthorise-access-detected');
		endif;
		$this->load->model('Tbl_category');
		$this->load->model('Tbl_subcategory');
		// $this->load->model('Incomming_assets');
		$this->load->model('Asset_requests');
		$this->load->model('Asset_movement_timeline');
		$this->load->model('Product_incomming_general_information');
		$this->load->model('Outgoing_assets');
	}
	public function index(){
		$Data = [
			'PageTitle' => 'Request For Asset',
			'PageName' => 'Request For Asset',
			'category_list' => $this->Tbl_category->get([],'cname','ASC'),
		];
		$this->admin_view('store_asset_request_form',$Data);
	}
	public function get_sub_category_by_main_category_id(){
		$main_category_id = decr($this->input->get('main_category_id'));
		$Main_catData = $this->Tbl_category->check(['cid' => $main_category_id]);
		$subCategories = $this->Tbl_subcategory->get(['cid' => $main_category_id],'scid','DESC');
		if($subCategories == true):
			$design = '<option value="">-Select Sub Category-</option>';
			foreach($subCategories as $sub):
				$design .= '<option value="'.encr($sub->scid).'">'.$sub->scname.'</option>';
			endforeach;
		else:
			$design = '<option value="">-No Sub Category Found-</option>';
		endif;
		$response = [
			'sub_cat_design' => $design,
			'cat_has_barcode' => $Main_catData->cat_has_barcode,
			'TheBarcode' => gen_barcode(),
			'cat_has_closing_asset_value' => $Main_catData->cat_has_closing_asset_value,
			'cat_has_depriciation' => $Main_catData->cat_has_depriciation,
		];
		echo json_encode($response);
	}
	public function get_assets_by_sub_category(){
		$pigi_sub_cat_id = decr($this->input->get('sub_category_id'));
		$assets = $this->Product_incomming_general_information->get(['pigi_sub_cat_id' => $pigi_sub_cat_id],'pigi_product_name','ASC');
		if($assets == true):
			$design = '<option value="">-Select Asset-</option>';
			foreach($assets as $asset_list):
				$design .= '<option value="'.encr($asset_list->pigi_id).'">'.$asset_list->pigi_product_name.'</option>';
			endforeach;
		else:
			$design = '<option value="">-No assets are available-</option>';
		endif;
		$response = [
			'asset_design' => $design,
		];
		echo json_encode($response);
	}
	public function store_request(){
		$this->form_validation->set_rules('ar_FK_main_category_id', 'Main Category', 'required');
		$this->form_validation->set_rules('ar_FK_sub_category_id', 'Sub Category', 'required');
		$this->form_validation->set_rules('ar_FK_asset_id', 'Asset Name', 'required');
		$this->form_validation->set_rules('ar_requested_qty', 'Quantity', 'required');
		$this->form_validation->set_error_delimiters('','');
		if($this->form_validation->run() == FALSE):
			$res = [
				'status' => 0,
				'msg' => '<div class="alert alert-danger" role="alert">'.validation_errors().'</div>',
			];
		else:			
			$DATE_TIME = date('Y-m-d H:i:s');
			$ar_serial_number = $this->generate_ar_serial_number();
			$ar_FK_main_category_id = decr($this->input->post('ar_FK_main_category_id'));
			$ar_FK_sub_category_id = decr($this->input->post('ar_FK_sub_category_id'));
			$ar_FK_asset_id = decr($this->input->post('ar_FK_asset_id'));
			$ar_requested_qty = $this->input->post('ar_requested_qty');
			$ar_remarks = $this->input->post('ar_remarks');
			$StoreData = $this->Admin->check(['id' => UL_ID]);			
			$AssetData = $this->Product_incomming_general_information->check(['pigi_id' => $ar_FK_asset_id]);			
			$check_qty = get_asset_current_stock($ar_FK_asset_id);
			if($ar_requested_qty <= $check_qty):
				$InsertData = [
					'ar_FK_store_id' => UL_ID,
					'ar_serial_number' => $ar_serial_number,
					'ar_FK_main_category_id' => $ar_FK_main_category_id,
					'ar_FK_sub_category_id' => $ar_FK_sub_category_id,
					'ar_FK_asset_id' => $ar_FK_asset_id,
					'ar_requested_qty' => $ar_requested_qty,
					'ar_remarks' => $ar_remarks,
					'ar_requested_datetime' => $DATE_TIME,
					'ar_status' => 'P', //{P=Processing, R=Rejected [Once it approved it will be inserted to the outgoing_assets table]}
				];				
				$ar_id = $this->Asset_requests->insert($InsertData);
				$amt_log_paragraph = $StoreData->store.' submitted a request to provide '.$ar_requested_qty.' '.$AssetData->pigi_product_name.' on '.$DATE_TIME.', and is currently awaiting approval from the administration.';
				insert_log_to_asset_movement_timeline_table('REQUEST',$amt_log_paragraph,$ar_FK_main_category_id,$ar_FK_sub_category_id,$ar_FK_asset_id);
				
				$res = [
					'status' => 1,
					'msg' => '<div class="alert alert-success" role="alert">Your request has been successfully submitted and is currently awaiting approval. Please note that your reference ID is <strong>'.$ar_serial_number.'</strong>. Kindly keep this reference ID for any future inquiries or updates regarding your request.</div>',
				];
			else:
				$res = [
					'status' => 0,
					'msg' => '<div class="alert alert-warning" role="alert">We regret to inform you that the system cannot process your request due to insufficient quantity available to fulfill your desired quantity. Please try requesting a lower quantity.</div>',
				];
			endif;
		endif;
		echo json_encode($res);
	}
	public function generate_ar_serial_number(){
		$last_row = $this->Asset_requests->lastRow('ar_id');
		if($last_row == true):
			$new_num = $last_row->ar_id+1;
			$ar_serial_number = 'ASREQ'.$new_num;
		else:
			$ar_serial_number = 'ASREQ1';
		endif;
		return $ar_serial_number;
	}
	public function approved_requests(){
		$Approved_Data = $this->Outgoing_assets->get_approved_requests_for_store(UL_ID);
		$Data = [
			'PageTitle' => 'Asset Request Lists | Approved',
			'PageName' => 'Asset Request Lists | Approved',
			'Approved_Data' => $Approved_Data,
		];
		$this->admin_view('asset_request_approved',$Data);
	}
	public function processing_requests(){
		$requestData = $this->Asset_requests->get_request_for_show_to_store($ar_status = 'P');
		$Data = [
			'PageTitle' => 'Asset Request Lists | Processing',
			'PageName' => 'Asset Request Lists | Processing',
			'requestData' => $requestData,
		];
		$this->admin_view('asset_request_processing',$Data);
	}
	public function rejected_requests(){
		$requestData = $this->Asset_requests->get_request_for_show_to_store($ar_status = 'R');
		$Data = [
			'PageTitle' => 'Asset Request Lists | Rejected',
			'PageName' => 'Asset Request Lists | Rejected',
			'requestData' => $requestData,
		];
		$this->admin_view('asset_request_rejected',$Data);
	}
}