<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Web_Application_Maintainance_Controller extends DBCI_Controller {
	function __construct(){
		parent::__construct();
		date_default_timezone_set('Asia/Kolkata');
	}
	public function unauthorised_access(){
		$Data = [
			'PageTitle' => 'Unauthorised Access'
		];
		$this->load->view('Admin/do_not_have_permission_to _enetr_this_area',$Data);
	}
}
