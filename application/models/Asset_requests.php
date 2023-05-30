<?php
class Asset_requests extends DB_Model
{
	public function get_request_for_show_to_store($ar_status){
		$this->db->select('*');
		$this->db->from('asset_requests');
		$this->db->where('ar_FK_store_id',UL_ID);
		$this->db->where('ar_status',$ar_status);
		$this->db->join('tbl_category','tbl_category.cid = asset_requests.ar_FK_main_category_id','LEFT');
		$this->db->join('tbl_subcategory','tbl_subcategory.scid = asset_requests.ar_FK_sub_category_id','LEFT');
		$this->db->join('product_incomming_general_information','product_incomming_general_information.pigi_id  = asset_requests.ar_FK_asset_id','LEFT');
		$sql = $this->db->get()->result();
		return $sql;
	}
	public function get_request_for_show_to_admin($ar_status){
		$this->db->select('admin.id AS Store_Id,admin.admin_type,admin.store AS Store_Name,admin.store_address,admin.store_mng_name,admin.store_m_phone, asset_requests.*, admin.*, tbl_category.*, tbl_subcategory.*, product_incomming_general_information.*');
		$this->db->from('asset_requests');
		$this->db->where('ar_status',$ar_status);
		$this->db->join('admin','admin.id = asset_requests.ar_FK_store_id','LEFT');
		$this->db->join('tbl_category','tbl_category.cid = asset_requests.ar_FK_main_category_id','LEFT');
		$this->db->join('tbl_subcategory','tbl_subcategory.scid = asset_requests.ar_FK_sub_category_id','LEFT');
		$this->db->join('product_incomming_general_information','product_incomming_general_information.pigi_id  = asset_requests.ar_FK_asset_id','LEFT');
		$sql = $this->db->get()->result();
		return $sql;
	}
	public function check_req($ar_id, $ar_status){
		$this->db->select('*');
		$this->db->from('asset_requests');
		$this->db->where('ar_id',$ar_id);
		$this->db->where('ar_status',$ar_status);
		$this->db->join('product_incomming_general_information','product_incomming_general_information.pigi_id  = asset_requests.ar_FK_asset_id','LEFT');
		$sql = $this->db->get()->row();
		return $sql;
	}
	public function check_req_full_possible_joining($ar_id){
		$this->db->select('admin.id AS Store_Id,admin.admin_type,admin.store AS Store_Name,admin.store_address,admin.store_mng_name,admin.store_m_phone, asset_requests.*, admin.*, tbl_category.*, tbl_subcategory.*, product_incomming_general_information.*');
		$this->db->from('asset_requests');
		$this->db->where('ar_id',$ar_id);
		$this->db->join('admin','admin.id = asset_requests.ar_FK_store_id','LEFT');
		$this->db->join('tbl_category','tbl_category.cid = asset_requests.ar_FK_main_category_id','LEFT');
		$this->db->join('tbl_subcategory','tbl_subcategory.scid = asset_requests.ar_FK_sub_category_id','LEFT');
		$this->db->join('product_incomming_general_information','product_incomming_general_information.pigi_id  = asset_requests.ar_FK_asset_id','LEFT');
		$sql = $this->db->get()->row();
		return $sql;
	}
}