<?php
function insert_log_to_asset_movement_timeline_table($amt_type,$amt_log_paragraph,$amt_FK_main_category_id,$amt_FK_sub_category_id,$amt_FK_asset_id,$amt_FK_Store_id=NULL){
	$CI =& get_instance();
	$CI->load->model('Asset_movement_timeline');
	$LogData = [
		'amt_type' => $amt_type,
		'amt_log_paragraph' => $amt_log_paragraph,
		'amt_log_paragraph' => $amt_log_paragraph,
		'amt_FK_main_category_id' => $amt_FK_main_category_id,
		'amt_FK_sub_category_id' => $amt_FK_sub_category_id,
		'amt_FK_asset_id' => $amt_FK_asset_id,
		'amt_FK_Store_id' => $amt_FK_Store_id,
		'amt_dateTime' => date('Y-m-d H:i:s'),
	];
	$CI->Asset_movement_timeline->insert($LogData);
}
function get_log_data($limit){
	$CI =& get_instance();
	$CI->db->select('*');
	$CI->db->from('asset_movement_timeline');
	$CI->db->order_by('amt_id', 'DESC');
	$CI->db->limit($limit);
	$CI->db->join('tbl_category', 'tbl_category.cid = asset_movement_timeline.amt_FK_main_category_id', 'left');
	$CI->db->join('tbl_subcategory', 'tbl_subcategory.scid = asset_movement_timeline.amt_FK_sub_category_id', 'left');

	// Scenario 1: Join with incoming_assets table
	$CI->db->join('incomming_assets', 'incomming_assets.ia_id = asset_movement_timeline.amt_FK_table_id AND asset_movement_timeline.amt_table_name = "incomming_assets"', 'left');

	// Scenario 2: Join with outgoing_assets table
	$CI->db->join('asset_requests', 'asset_requests.ar_id = asset_movement_timeline.amt_FK_table_id AND asset_movement_timeline.amt_table_name = "asset_requests"', 'left');

	$result = $CI->db->get()->result();
	return $result;
}