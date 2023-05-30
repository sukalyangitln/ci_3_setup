<?php
/*
|
| -------------------------------------------------------------------------
| PRINTR_DATA
| -------------------------------------------------------------------------
*/
function dd($data){
	echo '<pre>';
	print_r($data);
	echo '</pre>';
}
/*
| -------------------------------------------------------------------------
| INVALID CSRF REQUEST PROTECTION
| -------------------------------------------------------------------------
*/
function generate_url($url){	
	$url = str_replace('http://','',$url);	
	$url = str_replace('https://','',$url);	
	$url = explode('/',$url);	
	$url = current($url);	
	return $url; 
}
function csrf_request($redirect){	
	if(isset($_SERVER['HTTP_REFERER'])){		
		$ActionUrl = generate_url($_SERVER['HTTP_REFERER']);	
	}else{		
		$ActionUrl = generate_url(base_url(uri_string()));	
	}		
	$MainUrl = generate_url(base_url(uri_string()));	
	
	if($ActionUrl != $MainUrl){		
		redirect($redirect);	
	}
}
/*
| -------------------------------------------------------------------------
| CREATE POST SLUG
| -------------------------------------------------------------------------
*/
function create_slug($string,$table,$field='Slug',$key=NULL,$value=NULL){
	
    $CI =& get_instance();
    $slug = url_title($string);
    $slug = strtolower($slug);
    $i = 0;
    $params = array ();
    $params[$field] = $slug;
 
    if($key)$params["$key !="] = $value;
 
    while ($CI->db->where($params)->get($table)->num_rows())
    {  
        if (!preg_match ('/-{1}[0-9]+$/', $slug ))
            $slug .= '-' . ++$i;
        else
            $slug = preg_replace ('/[0-9]+$/', ++$i, $slug );
         
        $params [$field] = $slug;
    }  
    return $slug;  
}


/*
| -------------------------------------------------------------------------
| BOOTSTRAP NOTIFICATION MESSAGE
| 'SECCESS'
| 'ERROR'
| -------------------------------------------------------------------------
*/
function notification_message(){	
	$SD = & get_instance();	
	if($SD->session->flashdata('success')!= ''){		
		$display ='<div class="alert alert-success" role="alert">'.$SD->session->flashdata('success').'</div>';
		unset($_SESSION['success']);
		return  $display;
	}
	if($SD->session->flashdata('info')!= ''){		
		$display ='<div class="alert alert-info" role="alert">'.$SD->session->flashdata('info').'</div>';
		unset($_SESSION['info']);
		return  $display;
	}	
	if($SD->session->flashdata('error')!= ''){	
		$display ='<div class="alert alert-danger" role="alert">'.$SD->session->flashdata('error').'</div>';
		unset($_SESSION['error']);
		return  $display;
	}

	if($SD->session->flashdata('warning')!= ''){	
		$display ='<div class="alert alert-warning" role="alert">'.$SD->session->flashdata('warning').'</div>';
		unset($_SESSION['warning']);
		return  $display;
	}
	
}

/*
| -------------------------------------------------------------------------
| SESSION DESTROY DURING IDEAL TIME
| -------------------------------------------------------------------------
*/
function ideal_session_destroy($sKey,$dsKey,$time){
	$CI =& get_instance();
	if((time() - $CI->session->$sKey) > $time ){
		$CI->session->unset_userdata($dsKey);
		$CI->session->unset_userdata($sKey);
	}else{
		$CI->session->set_userdata($sKey,time());
	}
}

/*
| -------------------------------------------------------------------------
| SECURITY SANITIZE FILENAME
| -------------------------------------------------------------------------
*/
function sanitize($FormData){
	$CI =& get_instance();
	$arr = [];
	foreach($FormData as $key=>$value){
		$arr[$key] = $CI->security->sanitize_filename($value);
	}
	return $arr;
}
function single_sanitize($post_data){
	$CI =& get_instance();
	$SanitizedVal = $CI->security->sanitize_filename($post_data);
	return $SanitizedVal;
	
}
function date_differ($date1,$date2){
	$diff = abs(strtotime($date2) - strtotime($date1));
	$years = floor($diff / (365*60*60*24));
	$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
	$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
	$hours = abs(floor(($diff-($years * 31536000)-($days * 86400))/3600));
	$mins = abs(floor(($diff-($years * 31536000)-($days * 86400)-($hours * 3600))/60));
	$data = [
		'years' 	=> $years,
		'months' 	=> $months,
		'days' 		=> $days,
		'hours'		=> $hours,
		'mins'		=> $mins,
	];
	return $data;
}
function get_singular_or_plural($number){
	if($number>1){
		return "'s";
	}else{
		return "";
	}
}
function DateDiffer($date1,$date2){
	$date1 = new DateTime($date1);
	$date2 = new DateTime($date2);
	return $date1->diff($date2)->days;
}
function tagJson($type='decode',$array=NULL){
	if($type == 'decode'):
		return json_decode($array);
	elseif($type == 'encode'):
		return json_encode($array);
	else:
		return false;
	endif;
}
function tag_json_TO_string($json){
	$array = json_decode($json);
	if($array == TRUE):
		$string = '';
		foreach($array as $val):
			$string = $val.', '.$string;
		endforeach;
		return $string;
	else:
		return '';
	endif;
}
/*
|
| -------------------------------------------------------------------------
| RANDOM NUMBER GENERATE
| -------------------------------------------------------------------------
*/
function random_string($length) {
    $key = '';
    $keys = array_merge(range(0, 9), range('a', 'z'));

    for ($i = 0; $i < $length; $i++) {
        $key .= $keys[array_rand($keys)];
    }

    return $key;
}
/*
|
| -------------------------------------------------------------------------
| CHANGE DATE FORMAT 
| -------------------------------------------------------------------------
*/
function dmy_To_Ymd($dmy){
	$date_in_dmy = str_replace('/', '-', $dmy);
	$date_in_Ymd = date("Y-m-d", strtotime($date_in_dmy));	
	return $date_in_Ymd;
}
function Ymd_To_dmy($Ymd){
	$date_in_Ymd = str_replace('-', '/', $Ymd);
	$date_in_Dmy = date("d/m/Y", strtotime($date_in_Ymd));	
	return $date_in_Dmy;
}
function random_number($min,$max){
	return rand($min,$max);
}

function flash($type,$msg){
	$CI =& get_instance();
	$CI->session->set_flashdata($type,$msg);
}
function back(){
	$CI =& get_instance();
	redirect($CI->agent->referrer());
}
function encr($string){
	$CI =& get_instance();
	return $CI->encryption->encrypt($string);
}
function decr($encrypted_string){
	$CI =& get_instance();
	return $CI->encryption->decrypt($encrypted_string);
}
function get_country_data($country_id){
    $CI =& get_instance();
	$CI->db->select('*');
	$CI->db->from('countries');
	$CI->db->where('country_id',$country_id);
	$Data = $CI->db->get()->row();
	return $Data;
}function get_state_data($state_id){
    $CI =& get_instance();
	$CI->db->select('*');
	$CI->db->from('states');
	$CI->db->where('state_id',$state_id);
	$Data = $CI->db->get()->row();
	return $Data;
}function get_city_data($city_id){
    $CI =& get_instance();
	$CI->db->select('*');
	$CI->db->from('cities');
	$CI->db->where('city_id',$city_id);
	$Data = $CI->db->get()->row();
	return $Data;
}
function randomWithLength($length){
    $number = '';
    for ($i = 0; $i < $length; $i++):
        $number .= rand(1,9);
    endfor;
    return $number;
}
function send_mail_smtp($email,$body,$subject,$type){
	// REGISTRATION_OTP
}
function get_current_url(){
    $currentProtocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? 'https://' : 'http://';
	$currentDomain = $_SERVER['HTTP_HOST'];
	$currentUri = uri_string();
	$queryString = $_SERVER['QUERY_STRING'];
	$currentUrl = $currentProtocol . $currentDomain . '/' . $currentUri . $queryString;
	return $currentUrl;
}



