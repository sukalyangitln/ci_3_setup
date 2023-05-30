<?php
class Outgoing_assets extends DB_Model
{
	public function get_approved_data(){
		$this->db->select('admin.id AS Store_Id,admin.admin_type,admin.store AS Store_Name,admin.store_address,admin.store_mng_name,admin.store_m_phone, outgoing_assets.*, admin.*, tbl_category.*, tbl_subcategory.*, product_incomming_general_information.*');
		$this->db->from('outgoing_assets');
		$this->db->join('admin','admin.id=outgoing_assets.oa_FK_store_id','LEFT');
		$this->db->join('tbl_category','tbl_category.cid=outgoing_assets.oa_FK_main_category_id','LEFT');
		$this->db->join('tbl_subcategory','tbl_subcategory.scid=outgoing_assets.oa_FK_sub_category_id','LEFT');
		$this->db->join('product_incomming_general_information','product_incomming_general_information.pigi_id=outgoing_assets.oa_FK_asset_id','LEFT');
		$data = $this->db->get()->result();
		return $data;
	}
}