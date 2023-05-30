<?php
function get_asset_current_stock($pis_FK_asset_id){
	$CI =& get_instance();
	$CI->db->select('SUM(pis_qty) as Total_Incomming_Quantity');
	$CI->db->from('product_incomming_stock');
	$CI->db->where('pis_FK_asset_id',$pis_FK_asset_id);
	$Incomming = $CI->db->get()->row();
	$Incomming_asset_qty = $Incomming->Total_Incomming_Quantity;
	$Outgoing_asset_qty = 0; //This should be taken as per outgoing asset
	$Current_stock = ($Incomming_asset_qty-$Outgoing_asset_qty);
	return $Current_stock;
}
function get_all_categories(){
	$CI =& get_instance();
	$CI->db->select('*');
	$CI->db->from('tbl_category');
	$CI->db->order_by('cid','DESC');
	return $CI->db->get()->result();
}
function get_subcategory_name($scid){
	$CI =& get_instance();
	$CI->load->model('Tbl_subcategory');
	$data = $CI->Tbl_subcategory->check(['scid' => $scid]);
	if($data):
		return $data->scname;
	else:
		return null;
	endif;
}
function get_category_name($cid){
	$CI =& get_instance();
	$CI->load->model('Tbl_category');
	$data = $CI->Tbl_category->check(['cid' => $cid]);
	if($data):
		return $data->cname;
	else:
		return null;
	endif;
}
function get_country_list(){
	$CI =& get_instance();
	$CI->db->select('*');
	$CI->db->from('countries');
	$CI->db->order_by('country_name','ASC');
	return $CI->db->get()->result();
}
function get_state_list($country_id){
	$CI =& get_instance();
	$CI->db->select('*');
	$CI->db->from('states');
	$CI->db->where('state_country_id',$country_id);
	$CI->db->order_by('state_name','ASC');
	return $CI->db->get()->result();
}
function get_city_list($state_id){
	$CI =& get_instance();
	$CI->db->select('*');
	$CI->db->from('cities');
	$CI->db->where('city_state_id',$state_id);
	$CI->db->order_by('city_name','ASC');
	return $CI->db->get()->result();
}
function get_country_name($country_id){
	$CI =& get_instance();
	$CI->db->select('*');
	$CI->db->from('countries');
	$CI->db->where('country_id',$country_id);
	$row = $CI->db->get()->row();
	if($row==TRUE):
		return $row->country_name;
	else:
		return '';
	endif;
}
function gen_barcode(){
	$CI =& get_instance();
	$CI->load->model('Product_incomming_general_information');
	$length = strlen('CHAIGRAM');
	$last_row = $CI->Product_incomming_general_information->lastRow('pigi_id');
	if($last_row):
		$barCode = $last_row->pigi_product_barcode;
		$barCode = substr($barCode, $length);
		$barCode = $barCode+1;
		$barCode = 'CHAIGRAM00'.$barCode;
	else:
		$barCode = 'CHAIGRAM00'.'1';
	endif;
	return $barCode;
}
function gen_serial(){
	$CI =& get_instance();
	$CI->load->model('Product_incomming_stock');
	$length = strlen('CHISR00');
	$last_row = $CI->Product_incomming_stock->lastRow('pis_id');
	if($last_row):
		$pid = $last_row->pis_id;
		$pid = $pid+1;
		$pid = 'CHISR00'.$pid;
	else:
		$pid = 'CHISR00'.'1';
	endif;
	return $pid;
}
function get_user_generate_id(){
	$CI =& get_instance();
	$CI->load->model('User_logins');
	$length = strlen(USER_PREFIX);
	$last_row = $CI->User_logins->lastRow('ul_id');
	if($last_row):
		$MEMBER_ID = $last_row->ul_generate_id;
		$MEMBER_ID = substr($MEMBER_ID, $length);
		$MEMBER_ID = $MEMBER_ID+1;
		$MEMBER_ID = USER_PREFIX.$MEMBER_ID;
	else:
		$MEMBER_ID = USER_PREFIX.'5200158';
	endif;
	return $MEMBER_ID;
}
function get_setting(){
	$CI =& get_instance();
	$CI->db->select('*');
	$CI->db->from('settings');
	$CI->db->where('setting_id',1);
	return $CI->db->get()->row();
}
function get_all_salesheads(){
	$CI =& get_instance();
	$CI->db->select('*');
	$CI->db->from('tbl_sales_head');
	return $CI->db->get()->result();
	
}