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
			insert_log_to_asset_movement_timeline_table('REQUEST',$amt_log_paragraph,$ar_FK_main_category_id,$ar_FK_sub_category_id,$ar_FK_asset_id,UL_ID);
			
			$res = [
				'status' => 1,
				'msg' => '<div class="alert alert-success" role="alert">Your request has been successfully submitted and is currently awaiting approval. Please note that your reference ID is <strong>'.$ar_serial_number.'</strong>. Kindly keep this reference ID for any future inquiries or updates regarding your request.</div>',
			];
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
	public function check_before_proceeding(){
		$ar_id = decr($this->input->get('encr_ar_id'));
		$arData = $this->Asset_requests->check(['ar_id' => $ar_id]);
		if($arData):
			if($arData->ar_status == 'P'):
				$res = [
					'status' => 1,
					'msg' => 'Cancellation Possible.',
				];
			else:
				$res = [
					'status' => 0,
					'msg' => '<div class="alert alert-danger" role="alert">The administrative team has already taken action regarding your request. The reference ID assigned to your request is <strong>'.$arData->ar_serial_number.'</strong>. Unfortunately, the cancellation operation cannot be carried out at this time. We kindly request you to refresh the page to ensure you have the most up-to-date information.</div>',
				];
			endif;
		else:
			$res = [
				'status' => 0,
				'msg' => '<div class="alert alert-danger" role="alert">Invalid Operation</div>',
			];
		endif;
		echo json_encode($res);
	}
	public function make_request_cancellation(){
		$ar_id = decr($this->input->get('cancel_encr_ar_id'));
		$arData = $this->Asset_requests->check_req_full_possible_joining($ar_id);
		if($arData):
			if($arData->ar_status == 'P'):
				$datetime = new DateTime($arData->ar_requested_datetime);
				$Currentdatetime = new DateTime();
				$amt_log_paragraph = 'The store "'.$arData->Store_Name.'" has submitted a request for '.$arData->ar_requested_qty.' '.$arData->pigi_product_name.' categorized under "'.$arData->cname.'" with a subcategory of "'.$arData->scname.'" on '.$datetime->format('jS F Y').', at '.$datetime->format('h:i A').'. And the reference no. was '.$arData->ar_serial_number.'. However, it appears that this order was either placed in error or is no longer required. Therefore, as of '.$Currentdatetime->format('jS F Y').', at '.$Currentdatetime->format('h:i A').', the store has taken the initiative to cancel the procurement request themselves. Rendering further inquiries via the reference ID unattainable.';
				insert_log_to_asset_movement_timeline_table('REQUEST_CANCELLATION',$amt_log_paragraph,$arData->cid,$arData->scid,$arData->pigi_id,UL_ID);
				$this->Asset_requests->deleteWhere(['ar_id' => $ar_id]);
				flash('swal_success','The procurement request has been effectively canceled.');
				back();
			else:
				$err_msg = 'The administrative team has already taken action regarding your request. The reference ID assigned to your request is <strong>'.$arData->ar_serial_number.'</strong>. Unfortunately, the cancellation operation cannot be carried out at this time. We kindly request you to refresh the page to ensure you have the most up-to-date information.';
				flash('error',$err_msg);
				back();
			endif;
		else:
			flash('error','Invalid Operation');
			back();
		endif;
	}
	public function update_quantity(){
		$ar_id = decr($this->input->post('edt_qty_encr_ar_id'));
		$updated_qty = $this->input->post('updated_qty');
		$arData = $this->Asset_requests->check_req_full_possible_joining($ar_id);
		if($arData):
			if($arData->ar_status == 'P'):
				if($updated_qty == $arData->ar_requested_qty):
					flash('warning','It appears that you have not made any changes to the quantity to proceed. The requested quantity and the updated quantity are identical.');
					back();
				else:
					$datetime = new DateTime($arData->ar_requested_datetime);
					$Currentdatetime = new DateTime();

					$amt_log_paragraph = 'The requested quantity is updated by '.$arData->Store_Name.' for the procurement fererence no. '.$arData->ar_serial_number.'. The updated quantity is now '.$updated_qty.' and the action was taken on the date of '.$Currentdatetime->format('jS F Y').' at '.$Currentdatetime->format('h:i A');
					insert_log_to_asset_movement_timeline_table('REQUESTED_QTY_UPDATE',$amt_log_paragraph,$arData->cid,$arData->scid,$arData->pigi_id,UL_ID);

					$this->Asset_requests->updateWhere(['ar_requested_qty' => $updated_qty],['ar_id' => $ar_id]);
					flash('swal_success','The procurement quantity has been effectively updated to '.$updated_qty);
					back();
				endif;
			else:
				$err_msg = 'The administrative team has already taken action regarding your request. The reference ID assigned to your request is <strong>'.$arData->ar_serial_number.'</strong>. Unfortunately, the cancellation operation cannot be carried out at this time. We kindly request you to refresh the page to ensure you have the most up-to-date information.';
				flash('error',$err_msg);
				back();
			endif;
		else:
			flash('error','Invalid Operation');
			back();
		endif;
	}
	public function view_asset_movement_log_form(){
		$Data = [
			'PageTitle' => 'Procurement Logs',
			'PageName' => 'Procurement Logs',
		];
		$this->admin_view('store_asset_movement_log_form',$Data);
	}
	public function fetch_asset_movement_log(){
		$start = convertDate($this->input->get('start')); //function is available at core_helper.php
		$end = convertDate($this->input->get('end'));
		$MovementData = $this->Asset_movement_timeline->get_filtered_data($start,$end,$criteria=UL_ID);
		$Data = [
			'PageTitle' => 'Procurement Logs',
			'PageName' => 'Procurement Logs',
			'MovementData' => $MovementData,
		];
		$this->admin_view('store_asset_movement_log',$Data);

	}
}
