<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class AdminDashboardController extends AD_Controller {
	function __construct(){
		parent::__construct();
	}
	public function index(){
		$Data = [
			'PageTitle' => 'Dashboard',
			'PageName' 	=> 'Dashboard',
		];
		$this->admin_view('dashboard',$Data);
	}
	public function logout(){
		$this->session->set_flashdata('info', 'Successfully Logged Out.');
		$this->session->unset_userdata('Efbe_ast_trk_Admin_key_token');
		return redirect('/');
	}
}
