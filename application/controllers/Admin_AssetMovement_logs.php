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
}