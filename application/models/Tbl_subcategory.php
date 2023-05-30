<?php
class Tbl_subcategory extends DB_Model
{
	public function get_sub_categories(){
		$this->db->select('*');
		$this->db->from('tbl_subcategory');
		$this->db->join('tbl_category','tbl_subcategory.cid = tbl_category.cid','LEFT');
		$this->db->order_by('tbl_subcategory.scid','DESC');
		return $this->db->get()->result();
	}
}