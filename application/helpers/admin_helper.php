<?php
function get_admin_name($UL_ID){
	$CI =& get_instance();
	$CI->db->select('store');
	$CI->db->from('admin');
	$CI->db->where('id',$UL_ID); 
	$Data = $CI->db->get()->row();
	return $Data->store;
}
function get_admin_img($UL_ID){
	$CI =& get_instance();
	$CI->db->select('*');
	$CI->db->from('admin');
	$CI->db->where('id',$UL_ID); 
	$Data = $CI->db->get()->row();
	return $Data->Admin_Profile_Image_Path.$Data->Admin_Profile_Image;
}
function get_all_car_join_with_category_and_brands_table(){
	$CI =& get_instance();
	$CI->db->select('*');
	$CI->db->from('cars');
	$CI->db->join('categories','cars.car_FK_category = categories.cat_id','LEFT');
	$CI->db->join('brands','cars.car_FK_brand = brands.brand_id','LEFT');
	$CI->db->order_by('cars.car_id','DESC');
	return $CI->db->get()->result();
}