<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Admin_StoreCrud extends AD_Controller {
	function __construct(){
		parent::__construct();
		if(AUTH_USER_TYPE != 'ADMIN'):
			redirect('unauthorise-access-detected');
		endif;
	}
	public function index(){
		$Data = [
			'PageTitle' => 'Stores',
			'PageName' => 'Stores',
			'all_stores' => $this->Admin->get(['status' => 1],'id','DESC'),
		];
		$this->admin_view('stores',$Data);
	}
	public function store(){
		$this->form_validation->set_rules('store', 'Store Name', 'required');
		$this->form_validation->set_rules('username', 'Username', 'required|is_unique[admin.username]',[
			'is_unique' => "This username already exist.",
		]);
		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_error_delimiters('','');
		if($this->form_validation->run() == FALSE):
			flash('error', validation_errors());
			redirect('admin/stores');
		else:
			$InsertData = [
				'store' => single_sanitize($this->input->post('store')),
				'store_address' => single_sanitize($this->input->post('store_address')),
				'store_mng_name' => single_sanitize($this->input->post('store_mng_name')),
				'store_m_phone' => single_sanitize($this->input->post('store_m_phone')),
				'username' => single_sanitize($this->input->post('username')),
				'password' => $this->input->post('password'),
				'status' => 1,
			];
			$this->Admin->insert($InsertData);
			flash('swal_success', 'New store has been successfully registered.');
			redirect('admin/stores');
		endif;
	}
	public function delete(){
		// dd($this->input->get()); die;
		$id = decr($this->input->get('encr_store_id'));
		$Data = $this->Admin->check(['id' => $id]);
		if($Data):
			$this->Admin->deleteWhere(['id' => $id]);
			flash('swal_success', 'Store successfully deleted!');
			redirect('admin/stores');
		else:
			flash('error', 'Store not found!');
			redirect('admin/stores');
		endif;
	}
	public function edit(){
		$id = decr($this->input->get('edt_encr_store_id'));
		$StoreData = $this->Admin->check(['id' => $id]);
		if($StoreData):
			$Data = [
				'PageTitle' => 'Store | Edit',
				'PageName' => 'Store | Edit',
				'StoreData' => $StoreData,
			];
			$this->admin_view('store_edit',$Data);
		else:
			flash('error', 'Store not found!');
			redirect('admin/stores');
		endif;
	}
	public function validate_username(){
		$username = $this->input->get('username');
		$Data = $this->Admin->check(['username' => $username]);
		if($Data):
			$res = [
				'response' => 0,
				'msg' => "Username exist. Please try another",
			];
		else:
			$res = [
				'response' => 1,
				'msg' => "",
			];
		endif;
		echo json_encode($res);
	}
	public function validate_username_update_time(){
		$username = $this->input->get('username');
		$id = decr($this->input->get('encr_store_id'));
		$Data = $this->Admin->check(['username' => $username]);
		if($Data):
			if($Data->id == $id):
				$res = [
					'response' => 1,
					'msg' => "",
				];
			else:
				$res = [
					'response' => 0,
					'msg' => "Username exist. Please try another",
				];
			endif;			
		else:
			$res = [
				'response' => 1,
				'msg' => "",
			];
		endif;
		echo json_encode($res);
	}
	public function update(){
		// dd($this->input->post()); die;
		$this->form_validation->set_rules('store_id', 'Store ID', 'required');
		$this->form_validation->set_rules('store', 'Store Name', 'required');
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_error_delimiters('','');
		if($this->form_validation->run() == FALSE):
			flash('error', validation_errors());
			back();
		else:
			// dd($this->input->post()); die;
			$id = decr($this->input->post('store_id'));
			$Data = $this->Admin->check(['id' => $id]);
			// dd($Data); die;
			if($Data):
				$username_check = $this->Admin->check(['username' => $this->input->post('username')]);
				if($username_check):
					if($username_check->id == $id):
						$possibility = 1;
					else:
						$possibility = 0;
					endif;
				else:
					$possibility = 1;
				endif;
				if($possibility == 1):
					$updateCond = ['id' => $id];
					$updateData = [
						'store' => single_sanitize($this->input->post('store')),
						'store_address' => single_sanitize($this->input->post('store_address')),
						'store_mng_name' => single_sanitize($this->input->post('store_mng_name')),
						'store_m_phone' => single_sanitize($this->input->post('store_m_phone')),
						'username' => single_sanitize($this->input->post('username')),
						'password' => $this->input->post('password'),
					];
					$this->Admin->updateWhere($updateData,$updateCond);
					flash('swal_success','Store data has been successfully updated.');
					back();
				else:
					flash('error', 'Username already exists. Please try another.');
					back();
				endif;				
			else:
				flash('error', 'Store not found!');
				back();
			endif;
		endif;
	}
}
