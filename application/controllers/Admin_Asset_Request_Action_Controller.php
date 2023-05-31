<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Admin_Asset_Request_Action_Controller extends AD_Controller {
	function __construct(){
		parent::__construct();
		if(AUTH_USER_TYPE != 'ADMIN'):
			redirect('unauthorise-access-detected');
		endif;
		$this->load->model('Tbl_category');
		$this->load->model('Tbl_subcategory');
		$this->load->model('Asset_requests');
		$this->load->model('Asset_movement_timeline');
		$this->load->model('Product_incomming_stock');
		$this->load->model('Outgoing_assets');
	}
	public function approved_requests(){
		$Approved_Data = $this->Outgoing_assets->get_approved_data();
		// dd($Approved_Data); die;
		$Data = [
			'PageTitle' => 'Asset Request Lists | Approved',
			'PageName' => 'Asset Request Lists | Approved',
			'Approved_Data' => $Approved_Data,
		];
		$this->admin_view('admin_asset_request_action/approved',$Data);
	}
	public function processing_requests(){
		$requestData = $this->Asset_requests->get_request_for_show_to_admin($ar_status = 'P');
		// dd($requestData); die;
		$Data = [
			'PageTitle' => 'Asset Request Lists | Processing',
			'PageName' => 'Asset Request Lists | Processing',
			'requestData' => $requestData,
		];
		$this->admin_view('admin_asset_request_action/processing',$Data);
	}
	public function rejected_requests(){
		$requestData = $this->Asset_requests->get_request_for_show_to_admin($ar_status = 'R');
		$Data = [
			'PageTitle' => 'Asset Request Lists | Rejected',
			'PageName' => 'Asset Request Lists | Rejected',
			'requestData' => $requestData,
		];
		$this->admin_view('admin_asset_request_action/rejected',$Data);
	}
	public function make_rejection(){
		if($this->input->get('reject_encr_ar_id') != ''):
			$ar_id = decr($this->input->get('reject_encr_ar_id'));
			$AssetReq_Data = $this->Asset_requests->check_req($ar_id, $ar_status = 'P');
			// dd($AssetReq_Data ); die;
			if($AssetReq_Data):
				$UpdateCond = [
					'ar_id' => $ar_id, 
					'ar_status' => 'P'
				];
				$UpdateData = [
					'ar_status' => 'R', 
					'ar_admin_remarks' => '', //WILL BE ADDED IF ANY UPGRADATION NEEDED IN THIS SYSTEM
					'ar_admin_rejected_datetime' => date('Y-m-d H:i:s'),
				];
				$this->Asset_requests->updateWhere($UpdateData,$UpdateCond);
				$amt_log_paragraph = 'Asset request reference no. '.$AssetReq_Data->ar_serial_number.' has been rejected at '.date('Y-m-d H:i:s').' for the quantity of '.$AssetReq_Data->ar_requested_qty.' of '.$AssetReq_Data->pigi_product_name;
				insert_log_to_asset_movement_timeline_table('REQUEST_REJECTION',$amt_log_paragraph,$AssetReq_Data->ar_FK_main_category_id,$AssetReq_Data->ar_FK_sub_category_id,$AssetReq_Data->pigi_id,$AssetReq_Data->ar_FK_store_id);
				flash('swal_success','Request has been successfully rejected!');
				back();
			else:
				flash('error','Data not found in database for this operation!');
				back();
			endif;
		else:
			flash('error','Invalid operation detected.');
			back();
		endif;
	}
	public function get_data_before_approving_the_request(){
		$ar_id = decr($this->input->get('encr_ar_id'));
		$Req_data = $this->Asset_requests->check(['ar_id' => $ar_id]);
		if($Req_data):
			$current_asset_stock = get_asset_current_stock($Req_data->ar_FK_asset_id);
			if($Req_data->ar_requested_qty > $current_asset_stock):
				$res = [
					'encr_ar_id' 		=> encr($ar_id), //Asset_request Id
					'status'			 => 2, //Product out of stock
					'current_asset_stock' => $current_asset_stock,
					'ar_requested_qty' => $Req_data->ar_requested_qty,
					'msg' => '<div class="alert alert-warning" role="alert"><strong>Please be advised that the current stock quantity stands at '.$current_asset_stock.' units. However, we regret to inform you that the requested quantity is currently unavailable in our inventory. We kindly request you to consider adding additional units to fulfill your requirements and proceed accordingly.</strong></div>',
				];
			else:
				$res = [
					'encr_ar_id' => encr($ar_id), //Asset_request Id
					'status' => 1, //All okay!
					'current_asset_stock' => $current_asset_stock,
					'ar_requested_qty' => $Req_data->ar_requested_qty,
					'msg' => '<div class="alert alert-success" role="alert"><strong>Product Current Stock : '.$current_asset_stock.'</strong></div>',
				];
			endif;
		else:
			$res = [
				'status' => 0, //Product not found!
				'msg' => '<div class="alert alert-danger" role="alert"><strong>No data found!</strong></div>',
			];
		endif;
		echo json_encode($res);
	}
	public function make_approve(){
		$this->form_validation->set_rules('approve_encr_ar_id', 'Asset Request ID', 'required');
		$this->form_validation->set_rules('releasing_qty', 'Releasing Quantity', 'required');
		$this->form_validation->set_error_delimiters('','');
		if($this->form_validation->run() == FALSE):
			flash('error', validation_errors());
			back();
		else:
			$ar_id = decr($this->input->post('approve_encr_ar_id'));
			$AssetReq_Data = $this->Asset_requests->check(['ar_id' => $ar_id]);
			if($AssetReq_Data):
				//-------start Needed only for generating the movement log paragraph
				$StoreData = $this->Admin->check(['id' => $AssetReq_Data->ar_FK_store_id]);
				$CategoryData = $this->Tbl_category->check(['cid' => $AssetReq_Data->ar_FK_main_category_id]);
				$Sub_CategoryData = $this->Tbl_subcategory->check(['scid' => $AssetReq_Data->ar_FK_sub_category_id]);
				//--------end Needed only for generating the movement log paragraph
				$DateTime = date('Y-m-d H:i:s');
				$Outgoing_asset_insert = [
					'oa_FK_asset_id' => $AssetReq_Data->ar_FK_asset_id,
					'oa_FK_store_id' => $AssetReq_Data->ar_FK_store_id,
					'oa_FK_main_category_id' => $AssetReq_Data->ar_FK_main_category_id,
					'oa_FK_sub_category_id' => $AssetReq_Data->ar_FK_sub_category_id,
					'oa_FK_reference_id' => $AssetReq_Data->ar_serial_number,
					'oa_requested_qty' => $this->input->post('actual_requested_qty'),
					'oa_provided_qty' => $this->input->post('releasing_qty'),
					'oa_admin_remarks' => $this->input->post('remarks'),
					'oa_approved_datetime' => $DateTime,
					'oa_operaional_status' => 'OPS',
				];
				$this->Outgoing_assets->insert($Outgoing_asset_insert);
				$this->Asset_requests->deleteWhere(['ar_id' => $ar_id]);
				$amt_log_paragraph = strval('The store named '.$StoreData->store.' requested '.$this->input->post('actual_requested_qty').'  laptops belonging to the category "'.$CategoryData->cname.'"" and subcategory "'.$Sub_CategoryData->scname.'" on '.$AssetReq_Data->ar_requested_datetime.'. The approval for '.$this->input->post('releasing_qty').' units of the requested item was granted on '.$DateTime);
				insert_log_to_asset_movement_timeline_table('OUTGOING',$amt_log_paragraph,$AssetReq_Data->ar_FK_main_category_id,$AssetReq_Data->ar_FK_sub_category_id,$AssetReq_Data->ar_FK_asset_id,$AssetReq_Data->ar_FK_asset_id);
				flash('success',$amt_log_paragraph);
				back();
			else:
				flash('error','Invalid operation!');
				back();
			endif;
			// flash('swal_success', 'New category has been successfully registered.');
			// back();
		endif;
	}
	public function delete_rejected_request(){
		$ar_id = decr($this->input->get('dlt_encr_ar_id'));
		$arData = $this->Asset_requests->check_req_full_possible_joining($ar_id);
		if($arData):

			//-------start ASSET MOVEMENT TIMELINE INSERT
			$amt_log_paragraph = 'A store named "'.$arData->Store_Name.'" was submitted a request for "'.$arData->ar_requested_qty.'" units of product named "'.$arData->pigi_product_name.'", falling under the category of "'.$arData->cname.'" with a specific subcategory of "'.$arData->scname.'". The reference ID associated with this request is "'.$arData->ar_serial_number.'". However, this request has been rejected and deleted. Rendering further inquiries via the reference ID unattainable.';
			insert_log_to_asset_movement_timeline_table('REQUEST_DELETE',$amt_log_paragraph,$arData->cid,$arData->scid,$arData->pigi_id,$arData->ar_FK_store_id);
			//-------end ASSET MOVEMENT TIMELINE INSERT
			
			$this->Asset_requests->deleteWhere(['ar_id' => $ar_id]);
			flash('success',$amt_log_paragraph);
			back();
		endif;
	}
}