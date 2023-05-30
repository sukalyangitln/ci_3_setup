<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Admin_SubCategoryCrud extends AD_Controller {
	function __construct(){
		parent::__construct();
		if(AUTH_USER_TYPE != 'ADMIN'):
			redirect('unauthorise-access-detected');
		endif;
		$this->load->model('Tbl_category');
		$this->load->model('Tbl_subcategory');
	}
	public function index(){
		$Data = [
			'PageTitle' => 'Sub Categories',
			'PageName' => 'Sub Categories',
			'all_list' => $this->Tbl_subcategory->get_sub_categories(),
		];
		$this->admin_view('sub_categories',$Data);
	}
	public function store(){
		$this->form_validation->set_rules('cid', 'Main Category', 'required');
		$this->form_validation->set_rules('scname', 'Sub Category Name', 'required');
		$this->form_validation->set_error_delimiters('','');
		if($this->form_validation->run() == FALSE):
			flash('error', validation_errors());
			redirect('admin/sub-categories');
		else:
			$InsertData = [
				'cid' => single_sanitize($this->input->post('cid')),
				'scname' => single_sanitize($this->input->post('scname')),
			];
			// dd($InsertData); die;
			$this->Tbl_subcategory->insert($InsertData);
			flash('swal_success', 'New sub category has been successfully registered.');
			redirect('admin/sub-categories');
		endif;
	}
	public function delete(){
		// dd($this->input->get()); die;
		$scid = decr($this->input->get('encr_sub_category_id'));
		$Data = $this->Tbl_subcategory->check(['scid' => $scid]);
		// dd($Data); die;
		if($Data):
			$this->Tbl_subcategory->deleteWhere(['scid' => $scid]);
			flash('swal_success', 'Sub category successfully deleted!');
			redirect('admin/sub-categories');
		else:
			flash('error', 'Sub category not found!');
			redirect('admin/sub-categories');
		endif;
	}
	public function edit(){
		// dd($this->input->get()); die;
		$scid = decr($this->input->get('edt_encr_sub_category_id'));
		$subcategoryData = $this->Tbl_subcategory->check(['scid' => $scid]);
		// dd($subcategoryData); die;
		if($subcategoryData):
			$Data = [
				'PageTitle' => 'Sub Category | Edit',
				'PageName' => 'Sub Category | Edit',
				'subcategoryData' => $subcategoryData,
			];
			$this->admin_view('sub_category_edit',$Data);
		else:
			flash('error', 'category not found!');
			redirect('admin/sub-categories');
		endif;
	}
	public function update(){
		// dd($this->input->post()); die;
		$this->form_validation->set_rules('scid', 'Sub Category ID', 'required');
		$this->form_validation->set_rules('cid', 'Main Category ID', 'required');
		$this->form_validation->set_rules('scname', 'Category Name', 'required');
		$this->form_validation->set_error_delimiters('','');
		if($this->form_validation->run() == FALSE):
			flash('error', validation_errors());
			back();
		else:
			$scid = decr($this->input->post('scid'));
			$Data = $this->Tbl_subcategory->check(['scid' => $scid]);
			// dd($Data); die;
			if($Data):
				$updateCond = ['scid' => $scid];
				$updateData = [
					'cid' => single_sanitize($this->input->post('cid')),
					'scname' => single_sanitize($this->input->post('scname')),
				];
				$this->Tbl_subcategory->updateWhere($updateData,$updateCond);
				flash('swal_success','Sub category data has been successfully updated.');
				back();			
			else:
				flash('error', 'category not found!');
				back();
			endif;
		endif;
	}
}
