<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class TestController extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model('Tbl_subcategory');
	}
	public function index(){
		

	}
}