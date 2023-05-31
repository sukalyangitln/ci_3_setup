<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Admin_AssetMovement_logs extends AD_Controller {
	function __construct(){
		parent::__construct();
		if(AUTH_USER_TYPE != 'ADMIN'):
			redirect('unauthorise-access-detected');
		endif;
		$this->load->model('Asset_movement_timeline');
		$this->load->model('Serverside_asset_movement_timeline');
		$this->load->model('Tbl_subcategory');
		$this->load->model('Tbl_category');
		// $this->load->model('Incomming_assets');
		$this->load->helper('asset_movement');
	}
	public function index(){
		$Data = [
			'PageTitle' => 'Admin | Asset Movement Logs',
			'PageName' => 'Admin | Asset Movement Logs',
		];
		$this->admin_view('asset_movement_logs',$Data);
	}
	public function serverside_list(){
		$data = $row = array(); 
   		$movementLogs = $this->Serverside_asset_movement_timeline->getRows($_POST);
       	$i = $_POST['start'];
       	foreach($movementLogs as $list){

           $data[] = [
			           	$i, 
			           	$list->amt_dateTime, 
			           	$list->amt_log_paragraph, 
			           	$list->amt_type, 
			        ];
					$i++;
       	}
       	$output = [
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->Serverside_asset_movement_timeline->countAll(),
			"recordsFiltered" => $this->Serverside_asset_movement_timeline->countFiltered($_POST),
			"data" => $data,
		];
       	echo json_encode($output);
	}
	public function datewise_form_show(){
		$Data = [
			'PageTitle' => 'Admin | Date Wise Asset Movement Logs',
			'PageName' => 'Admin | Date Wise Asset Movement Logs',
		];
		$this->admin_view('admin_date_wise_asset_movement_logs_form',$Data);
	}
	public function datewise_procurement_logs(){
		$start = convertDate($this->input->get('start')); //function is available at core_helper.php
		$end = convertDate($this->input->get('end'));
		$store_ids = $this->input->get('store');
		// dd($store_ids); die;
		$MovementData = $this->Asset_movement_timeline->get_filtered_data_store_wise($start,$end,$store_ids);
		$Data = [
			'PageTitle' => 'Procurement Logs',
			'PageName' => 'Procurement Logs',
			'MovementData' => $MovementData,
		];
		$this->admin_view('admin_view_store_asset_movement_log',$Data);
	}
}