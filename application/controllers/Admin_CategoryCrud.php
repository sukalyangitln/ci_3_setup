<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Admin_CategoryCrud extends AD_Controller {
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
			'PageTitle' => 'Categories',
			'PageName' => 'Categories',
			'all_list' => $this->Tbl_category->get([],'cid','DESC'),
		];
		$this->admin_view('categories',$Data);
	}
	public function store(){
		$this->form_validation->set_rules('cname', 'Category Name', 'required');
		$this->form_validation->set_error_delimiters('','');
		if($this->form_validation->run() == FALSE):
			flash('error', validation_errors());
			redirect('admin/categories');
		else:
			$InsertData = [
				'cname' => single_sanitize($this->input->post('cname')),
			];
			$this->Tbl_category->insert($InsertData);
			flash('swal_success', 'New category has been successfully registered.');
			redirect('admin/categories');
		endif;
	}
	public function delete(){
		// dd($this->input->get()); die;
		$cid = decr($this->input->get('encr_category_id'));
		$Data = $this->Tbl_category->check(['cid' => $cid]);
		if($Data):
			$this->Tbl_category->deleteWhere(['cid' => $cid]);
			$this->Tbl_subcategory->deleteWhere(['cid' => $cid]);
			flash('swal_success', 'category successfully deleted!');
			redirect('admin/categories');
		else:
			flash('error', 'category not found!');
			redirect('admin/categories');
		endif;
	}
	public function edit(){
		// dd($this->input->get()); die;
		$cid = decr($this->input->get('edt_encr_category_id'));
		$categoryData = $this->Tbl_category->check(['cid' => $cid]);
		if($categoryData):
			$Data = [
				'PageTitle' => 'Category | Edit',
				'PageName' => 'Category | Edit',
				'categoryData' => $categoryData,
			];
			$this->admin_view('category_edit',$Data);
		else:
			flash('error', 'category not found!');
			redirect('admin/categories');
		endif;
	}
	public function update(){
		// dd($this->input->post()); die;
		$this->form_validation->set_rules('category_id', 'category ID', 'required');
		$this->form_validation->set_rules('cname', 'category Name', 'required');
		$this->form_validation->set_error_delimiters('','');
		if($this->form_validation->run() == FALSE):
			flash('error', validation_errors());
			back();
		else:
			$cid = decr($this->input->post('category_id'));
			$Data = $this->Tbl_category->check(['cid' => $cid]);
			if($Data):
				$updateCond = ['cid' => $cid];
				$updateData = [
					'cname' => single_sanitize($this->input->post('cname')),
				];
				$this->Tbl_category->updateWhere($updateData,$updateCond);
				flash('swal_success','category data has been successfully updated.');
				back();			
			else:
				flash('error', 'category not found!');
				back();
			endif;
		endif;
	}
}
