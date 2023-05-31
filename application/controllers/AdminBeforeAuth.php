<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class AdminBeforeAuth extends CI_Controller {
	function __construct(){
		parent::__construct();
		date_default_timezone_set('Asia/Kolkata');
		if($this->session->userdata('Efbe_ast_trk_Admin_key_token') == true){			
			return redirect('admin-dashboard');		
		}
		$site_dtls=GetCompanyDetails();
		define('SITE_NAME',$site_dtls->comp_show_name);
		define('SITE_LOGO',$site_dtls->comp_logo_path.$site_dtls->comp_logo);
		define('SITE_FAV',$site_dtls->comp_logo_path.$site_dtls->comp_favicon);
		define('SITE_COPYRIGHT',$site_dtls->comp_copyright);
		define('SITE_DEV_BY',$site_dtls->comp_develop_by);
		define('SITE_DEV_BY_URL',$site_dtls->comp_develop_by_link);
	}
	public function index(){
		$this->load->view('Admin/login');
	}
	public function login(){
		$formData = [
			'username' => $this->input->post('username'),
			'password' => $this->input->post('password')
		];	
		$AdminData = $this->Admin->check($formData);
		if($AdminData == TRUE):
			$this->session->set_userdata(['Efbe_ast_trk_Admin_key_token'=>[
				'login'		=>	true,
				'id'		=>	$AdminData->id,
				'Username'	=>	$AdminData->username,
				'Auth_Type'	=>	$AdminData->admin_type
			]]);
			redirect('admin-dashboard');
		else:
			$this->session->set_flashdata('error','Invalid Login');
			redirect('/');
		endif;
	}
}
