<?php
class DBCI_Controller extends CI_Controller{
	function __construct(){
		parent::__construct();
		date_default_timezone_set('Asia/Kolkata');
		$site_dtls=GetCompanyDetails();
		define('SITE_NAME',$site_dtls->comp_show_name);
		define('SITE_LOGO',$site_dtls->comp_logo_path.$site_dtls->comp_logo);
		define('SITE_FAV',$site_dtls->comp_logo_path.$site_dtls->comp_favicon);
		define('SITE_COPYRIGHT',$site_dtls->comp_copyright);
		define('SITE_DEV_BY',$site_dtls->comp_develop_by);
		define('SITE_DEV_BY_URL',$site_dtls->comp_develop_by_link);
	}	
}
class AD_Controller extends DBCI_Controller{
	public function __construct(){	
		parent::__construct();
		if($this->session->userdata('Efbe_ast_trk_Admin_key_token')!= true):
			redirect('/');
		endif;
		define('UL_ID',$this->session->userdata('Efbe_ast_trk_Admin_key_token')['id']);
		define('AUTH_USER_TYPE',$this->session->userdata('Efbe_ast_trk_Admin_key_token')['Auth_Type']);
	}	
	public function admin_view($main,$data = null){
		$data['sData'] = $this->session->userdata('Efbe_ast_trk_Admin_key_token');
		$this->load->view('Admin/'.$main,$data);
	}
}
class FR_Controller extends DBCI_Controller{
	public function __construct(){	
		parent::__construct();
		if($this->session->userdata('FR_Key_DNS_USER') != true){
			redirect('user/login?data=fundraiser');	
		}
		$this->load->model('User_logins');
		define('FR_ID',$this->session->userdata('FR_Key_DNS_USER')['id']);
	}	
}
class NU_Controller extends DBCI_Controller{
	public function __construct(){	
		parent::__construct();
		if($this->session->userdata('NU_Key_DNS_USER') != true){
			redirect('login?data=user');	
		}
		$this->load->model('User_logins');
		define('NU_ID',$this->session->userdata('NU_Key_DNS_USER')['id']);
		$user=$this->User_logins->check(['ul_id'=>NU_ID]);
		if($user==TRUE):
			define('NU_TYPE',$user->ul_type);
		else:
			redirect('user/logout');
		endif;
	}	
}





