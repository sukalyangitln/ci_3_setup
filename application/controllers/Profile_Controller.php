<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Profile_Controller extends AD_Controller {
	function __construct(){
		parent::__construct();
	}
	public function index(){
		$user = $this->Admin->check(['id'=>UL_ID]);
		$Data = [
			'PageTitle' => 'Profile settings',
			'PageName' 	=> 'Profile settings',
			'user'		=> $user
		];
		$this->admin_view('admin-profile',$Data);
	}
	public function Profile_Save(){
		$EXIST=$this->Admin->check(['id !='=>UL_ID,'username'=>$this->input->post('Admin_Email')]);
		if($EXIST==TRUE):
			$this->session->set_flashdata('error', 'The Email field must contain a unique value.');
			redirect($this->agent->referrer());
		endif;
		$EXIST=$this->Admin->check(['id'=>UL_ID]);
		$config=[
			'upload_path'	=>'assets/uploads/admin/',
			'allowed_types'	=>'jpeg|jpg|png',
			'file_name'		=>random_string(20),
		];
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		if($this->upload->do_upload('admin_profile_image')):
			$Admin_Profile_Image = $this->upload->data('file_name');
			if(file_exists($EXIST->Admin_Profile_Image_Path.$EXIST->Admin_Profile_Image)):
			   unlink($EXIST->Admin_Profile_Image_Path.$EXIST->Admin_Profile_Image);
			endif;
		else:
			$Admin_Profile_Image = $this->input->post('Admin_Profile_Image');
		endif;
		
		$user = [
			'Admin_Name'			=>$this->input->post('Admin_Name'),
			'username'				=>$this->input->post('Admin_Email'),
			'Admin_Email'			=>$this->input->post('Admin_Email'),
			'Admin_Phone'			=>$this->input->post('Admin_Phone'),
			'Admin_Whatsapp'		=>$this->input->post('Admin_Whatsapp'),
			'Admin_Address'			=>$this->input->post('Admin_Address'),
			'Admin_Profile_Image'	=>$Admin_Profile_Image,
		];
		$this->Admin->updateWhere($user,['id'=>UL_ID]);
		$this->session->set_flashdata('success', 'Profile update successfull.');
		redirect($this->agent->referrer());
	}
	public function Change_Password_Save(){
		// dd($this->input->post()); die;
		$old_password = $this->input->post('old_password');
		$new_password = $this->input->post('new_password');
		$confirm_password = $this->input->post('confirm_password');
		if($old_password==TRUE AND $new_password==TRUE AND $confirm_password==TRUE):
			$check = $this->Admin->check(['id'=>UL_ID]);
			if($check == TRUE):
				if($check->password === $old_password):
					if($new_password === $confirm_password):
						$update = [
							'password'		=>$new_password,
						];
						$this->Admin->updateWhere($update,['id'=>UL_ID]);
						flash('success','Password has been successfully updated.');
						redirect('admin-profile');
					else:
						flash('error','Retype your confirm password.');
						redirect('admin-profile');
					endif;
				else:
					flash('error','Old password do not match.');
					redirect('admin-profile');
				endif;
			else:
				flash('error','User not found please try again.');
				redirect('admin-profile');
			endif;
		else:
			flash('error','Please fill up all form field.');
			redirect('admin-profile');
		endif;
	}
}