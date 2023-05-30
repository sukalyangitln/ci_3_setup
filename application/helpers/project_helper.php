<?php
function get_asset_current_stock($pis_FK_asset_id){
	$CI =& get_instance();
	// INCOMMING ASSET QUERY
	$CI->db->select('SUM(pis_qty) as Total_Incomming_Quantity');
	$CI->db->from('product_incomming_stock');
	$CI->db->where('pis_FK_asset_id',$pis_FK_asset_id);
	$Incomming = $CI->db->get()->row();
	$Incomming_asset_qty = $Incomming->Total_Incomming_Quantity;
	//OUTGOING ASSET QUERY
	$CI->db->select('SUM(oa_provided_qty) as Total_Outgoing_Quantity');
	$CI->db->from('outgoing_assets');
	$CI->db->where('oa_FK_asset_id',$pis_FK_asset_id);
	$Outgoing = $CI->db->get()->row();
	$Outgoing_asset_qty = $Outgoing->Total_Outgoing_Quantity;
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
function get_nos_of_stores(){
	$CI =& get_instance();
	return $CI->Admin->rowFieldCountWhere(['admin_type' => 'STORE']);
}
function get_nos_of_products(){
	$CI =& get_instance();
	$CI->load->model('Product_incomming_general_information');
	return $CI->Product_incomming_general_information->rowCount();
}
function get_nos_of_approved_requests(){
	$CI =& get_instance();
	$CI->load->model('Outgoing_assets');
	return $CI->Outgoing_assets->rowCount();
}
function get_nos_of_pending_requests(){
	$CI =& get_instance();
	$CI->load->model('Asset_requests');
	return $CI->Asset_requests->rowFieldCountWhere(['ar_status' => 'P']);
}
function get_nos_of_rejected_request(){
	$CI =& get_instance();
	$CI->load->model('Asset_requests');
	return $CI->Asset_requests->rowFieldCountWhere(['ar_status' => 'R']);
}
function get_nos_of_categories(){
	$CI =& get_instance();
	$CI->load->model('Tbl_category');
	return $CI->Tbl_category->rowCount();
}
function get_nos_of_subcategories(){
	$CI =& get_instance();
	$CI->load->model('Tbl_subcategory');
	return $CI->Tbl_subcategory->rowCount();
}