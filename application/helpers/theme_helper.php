<?php
function AdminMenuActive(){
	$CI =& get_instance();
	$first = $CI->uri->segment(1);
	$second = $CI->uri->segment(2);
	$third = $CI->uri->segment(3);
	$arr['ul'] = ''; $arr['li'] = '';
	if($first == 'admin-dashboard'){
		$arr['ul'] = 'admin-dashboard';
		$arr['li'] = $first;
	}
	if($first == 'admin' && $second == 'stores' ){
		$arr['ul'] = 'admin-stores';
		$arr['li'] = $first;
	}
	if($first == 'admin' && $second == 'sub-categories' ){
		$arr['ul'] = 'admin-sub-categories';
		$arr['li'] = $first;
	}
	if($first == 'admin' && $second == 'categories' ){
		$arr['ul'] = 'admin-categories';
		$arr['li'] = $first;
	}
	if($first == 'admin' && $second == 'asset-movement-logs' ){
		$arr['ul'] = 'admin-asset-movement-logs';
		$arr['li'] = $first;
	}
	if($first == 'admin' && $second == 'product' && $third == 'add' ){
		$arr['ul'] = 'admin-product-add';
		$arr['li'] = $first;
	}
	if($first == 'admin' && $second == 'product' && $third == 'list' ){
		$arr['ul'] = 'admin-product-add';
		$arr['li'] = $first;
	}
	if($first == 'store' && $second == 'asset-requests' && $third == 'processing' ){
		$arr['ul'] = 'store-asset-requests-processing';
		$arr['li'] = $first;
	}
	if($first == 'store' && $second == 'asset-requests' && $third == 'approved' ){
		$arr['ul'] = 'store-asset-requests-approved';
		$arr['li'] = $first;
	}
	if($first == 'store' && $second == 'asset-requests' && $third == 'rejected' ){
		$arr['ul'] = 'store-asset-requests-rejected';
		$arr['li'] = $first;
	}
	if($first == 'request-for-asset'){
		$arr['ul'] = 'request-for-asset';
		$arr['li'] = $first;
	}
	return $arr;
}
function FundRMenuActive(){
	$CI =& get_instance();
	$first = $CI->uri->segment(1);
	$second = $CI->uri->segment(2);
	$arr['ul'] = ''; $arr['li'] = '';
	if($first == 'fundraiser' AND $second=='dashboard'){
		$arr['ul'] = 'fundraiser/dashboard';
		$arr['li'] = $first;
	}elseif($first == 'fundraiser' AND $second=='add-campaign'){
		$arr['ul'] = 'Campaign';
		$arr['li'] = 'fundraiser/add-campaign';
	}elseif($first == 'fundraiser' AND $second=='edit-campaign'){
		$arr['ul'] = 'Campaign';
		$arr['li'] = 'fundraiser/edit-campaign';
	}elseif($first == 'fundraiser' AND $second=='view-campaign'){
		$arr['ul'] = 'Campaign';
		$arr['li'] = 'fundraiser/view-campaign';
	}
	return $arr;
}

function FrontMenuActive(){
	$CI =& get_instance();
	$first = $CI->uri->segment(1);
	$second = $CI->uri->segment(2);
	$arr['ul'] = ''; $arr['li'] = '';
	if($first == ''){
		$arr['ul'] = '';
		$arr['li'] = $first;
	}
	return $arr;
}
function UserMenuActive(){
	$CI =& get_instance();
	$first = $CI->uri->segment(1);
	$second = $CI->uri->segment(2);
	$arr['ul'] = ''; $arr['li'] = '';
	return $arr;
}
function GetCompanyDetails(){
	$CI =& get_instance();
	$CI->db->select('*');
	$CI->db->from('company_profile');
	$CI->db->where('comp_id !=',0);
	return $CI->db->get()->row();
}