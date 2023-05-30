<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Admin_Settings extends AD_Controller {
	function __construct(){
		parent::__construct();
		if(AUTH_USER_TYPE != 'ADMIN'):
			redirect('unauthorise-access-detected');
		endif;
		$this->load->model('Company_profile');
		$this->load->model('Settings');
	}
	public function Company_Profile(){
		$profile=$this->Company_profile->check(['comp_id !='=>0]);
		$Data = [
			'PageTitle' => 'Company profile',
			'PageName' 	=> 'Company profile settings',
			'profile'	=> $profile,
		];
		$this->admin_view('settings/admin-company-profile',$Data);
	}
	public function CompanyProfileSave(){
		$profile=$this->Company_profile->check(['comp_id !='=>0]);
		$config=[
			'upload_path'	=>'assets/uploads/dynamic_page/company_profile/',
			'allowed_types'	=>'jpeg|jpg|png',
			'file_name'		=>random_string(20),
		];
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		if($this->upload->do_upload('comp_logo')):
			$comp_logo = $this->upload->data('file_name');
			if(file_exists($profile->comp_logo_path.$profile->comp_logo)):
			   unlink($profile->comp_logo_path.$profile->comp_logo);
			endif;
		else:
			$comp_logo = $profile->comp_logo;
		endif;
		if($this->upload->do_upload('comp_favicon')):
			$comp_favicon = $this->upload->data('file_name');
			if(file_exists($profile->comp_logo_path.$profile->comp_favicon)):
			   unlink($profile->comp_logo_path.$profile->comp_favicon);
			endif;
		else:
			$comp_favicon = $profile->comp_favicon;
		endif;
		$comp_id = $this->input->post('comp_id');
		$update=[
			'comp_name'			=>$this->input->post('comp_name'),
			'comp_show_name'	=>$this->input->post('comp_show_name'),
			'comp_contact_no'	=>$this->input->post('comp_contact_no'),
			'comp_whats_app_no'	=>$this->input->post('comp_whats_app_no'),
			'comp_email'		=>$this->input->post('comp_email'),
			'comp_logo'			=>$comp_logo,
			'comp_favicon'		=>$comp_favicon,
			'comp_copyright'	=>$this->input->post('comp_copyright'),
			'comp_develop_by'	=>$this->input->post('comp_develop_by'),
			'comp_develop_by_link'=>$this->input->post('comp_develop_by_link'),
		];
		$this->Company_profile->updateWhere($update,['comp_id'=>$comp_id]);
		$this->session->set_flashdata('success', 'Update successful');
		redirect($this->agent->referrer());
	}
}