<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Admin_ProductCrud extends AD_Controller {
	function __construct(){
		parent::__construct();
		if(AUTH_USER_TYPE != 'ADMIN'):
			redirect('unauthorise-access-detected');
		endif;
		$this->load->model('Tbl_category');
		$this->load->model('Tbl_subcategory');
		$this->load->model('Tbl_product');
		$this->load->model('Product_incomming_general_information');		
		$this->load->model('Product_incomming_stock');
		$this->load->model('Serverside_product_incomming_general_information');
		$this->load->model('Asset_movement_timeline');		
		$this->load->library('ci_qr_code');
		$this->config->load('qr_code');
	}
	public function index(){
		$Data = [
			'PageTitle' => 'Admin | Add Product',
			'PageName' => 'Admin | Add Product',
			'Barcode' => gen_barcode(),
			'serialNo' => gen_serial(),
		];
		$this->admin_view('add_product',$Data);
	}
	public function fetch_sub_category(){
		$main_category_id = $this->input->get('main_category_id');
		$Main_catData = $this->Tbl_category->check(['cid' => $main_category_id]);
		$subCategories = $this->Tbl_subcategory->get(['cid' => $main_category_id],'scid','DESC');
		if($subCategories == true):
			$design = '<option value="">-Select Sub Category-</option>';
			foreach($subCategories as $sub):
				$design .= '<option value="'.$sub->scid.'">'.$sub->scname.'</option>';
			endforeach;
		else:
			$design = '<option value="">-No Sub Category Found-</option>';
		endif;
		$response = [
			'sub_cat_design' => $design,
			'cat_has_barcode' => $Main_catData->cat_has_barcode,
			'TheBarcode' => gen_barcode(),
			'cat_has_closing_asset_value' => $Main_catData->cat_has_closing_asset_value,
			'cat_has_depriciation' => $Main_catData->cat_has_depriciation,
		];
		echo json_encode($response);	
	}
	public function store(){
		// dd($this->input->post()); die;
		$this->form_validation->set_rules('cid', 'Main Category', 'required');
		$this->form_validation->set_rules('scid', 'Sub Category', 'required');
		$this->form_validation->set_rules('pname', 'Product Name', 'required');
		$this->form_validation->set_rules('pqty', 'Product Quantity', 'required');
		$this->form_validation->set_rules('original_cost', 'Original Cost', 'required');
		$this->form_validation->set_error_delimiters('','');
		if($this->form_validation->run() == FALSE):
			flash('error', validation_errors());
			redirect('admin/product/add');
		else:
			$category_data = $this->Tbl_category->check(['cid' => $this->input->post('cid')]);
			if($category_data):
				$sub_category_data = $this->Tbl_subcategory->check(['scid' => $this->input->post('scid')]);
				if($sub_category_data):
					$pigi_product_barcode = $this->get_barcode($category_data);
					$closing_asset_value = $this->get_closing_asset_value($category_data);
					$pis_depriciation_rate = $this->get_depriciation_value($category_data);
					$pigi_main_cat_id = $category_data->cid; 
					$pigi_sub_cat_id = $sub_category_data->scid;
					$pigi_product_name = $this->input->post('pname');
					$pigi_product_description = $this->input->post('pdesc');
					$pis_qty = $this->input->post('pqty');
					$pis_product_original_cost = $this->input->post('original_cost');
					$pis_retired_date = $this->input->post('retired_date');
					$pis_serial_number = $this->input->post('serial_no');
					if($this->input->post('purchase_date') == true):
						$pis_purchase_date = $this->input->post('purchase_date');
					else:
						$pis_purchase_date = null;
					endif;
					if($this->input->post('retired') == 'Yes'):
						$pis_is_retired = 'Y';
						$pis_retired_date = $this->input->post('retired_date');
					else:
						$pis_is_retired = 'N';
						$pis_retired_date = null;
					endif;

					//START VENDOR INFORMARIONS------
					$pis_vendor_name = $this->input->post('vendor_name');
					$pis_vendor_phone = $this->input->post('vendor_phone');
					$pis_vendor_address = $this->input->post('vendor_address');
					//END VENDOR INFORMARIONS------

					$Invoice_file = $this->upload_invoice_file();
					$pis_invoice_type = $this->input->post('invoice_file_extension');
					$pis_closing_asset_value = $this->input->post('closing_value');
					$pis_remarks = $this->input->post('pis_remarks');
					// This is the main contexts wchich the QR code have and all the contents are dynamic.

					$Qrcode_context = strval(
						'Barcode: '.$pigi_product_barcode.", ".
						'Category Name: '.$category_data->cname.", ".
						'Sub-Category Name: '.$sub_category_data->scname.", ".
						'Product Name: '.$pigi_product_name.", ".
						'Product Desc: '.$pigi_product_description.", ".
						'Product qty: '.$pis_qty.", ".
						'Serial No.: '.$pis_serial_number.", ".
						'Purchase Date: '.$pis_purchase_date.", ".
						'Original Cost: '.$pis_product_original_cost.", ".
						'Retired: '.$this->input->post('retired').", ".
						'Retired Date: '.$pis_retired_date.", ".
						'Depriciation: '.$pis_depriciation_rate.", ".
						'Closing Value: '.$pis_closing_asset_value.", ".
						'Vendor Name: '.$pis_vendor_name.", ".
						'Vendor Phone: '.$pis_vendor_phone.", ".
						'Vendor Address: '.$pis_vendor_address.", ".
						'Remarks: '.$pis_remarks
					);
					// echo $Qrcode_context; die;
					$QRCODE = $this->generate_qr_code($category_data,$Qrcode_context); //If the main category table field `cat_has_qr_code` == 'Y' then This function returns an array which contains qr code full path and the file name of the generated QR code. Otherwise the QR code will not be generated.
					$Product_General_Info = [
						'pigi_main_cat_id' => $pigi_main_cat_id,
						'pigi_sub_cat_id' => $pigi_sub_cat_id,
						'pigi_product_name' => $pigi_product_name,
						'pigi_product_description' => $pigi_product_description,
						'pigi_product_barcode' => $pigi_product_barcode,
						'pigi_created_datetime' => date('Y-m-d H:i:s'),
					];
					$pigi_id = $this->Product_incomming_general_information->insert($Product_General_Info);
					if($pigi_id == true):
						// -----------start ADDING STOCK TO `product_incomming_stock` TABLE--------
						$product_incomming_stock_INSERT = [
							'pis_FK_asset_id' => $pigi_id,
							'pis_FK_main_category_id' => $pigi_main_cat_id,
							'pis_FK_sub_category_id' => $pigi_sub_cat_id,
							'pis_qty' => $pis_qty,
							'pis_product_original_cost' => $pis_product_original_cost,
							'pis_serial_number' => $pis_serial_number,
							'pis_purchase_date' => $pis_purchase_date,
							'pis_is_retired' => $pis_is_retired,
							'pis_retired_date' => $pis_retired_date,
							'pis_depriciation_rate' => $pis_depriciation_rate,
							'pis_vendor_name' => $pis_vendor_name,
							'pis_vendor_phone' => $pis_vendor_phone,
							'pis_vendor_address' => $pis_vendor_address,
							'pis_invoice_type' => $pis_invoice_type,
							'pis_invoice_file_name' => $Invoice_file['file_name'],
							'pis_invoice_uploaded_path' => $Invoice_file['full_file_path'],
							'pis_is_generate_qr' => $category_data->cat_has_qr_code,
							'pis_generated_qr_filename' => $QRCODE['qr_code_file_name'],
							'pis_generated_qr_path' => $QRCODE['full_qr_code_path'],
							'pis_closing_asset_value' => $pis_closing_asset_value,
							'pis_remarks' => $pis_remarks,
							'pis_added_datetime' => date('Y-m-d H:i:s'),
						];
						$this->Product_incomming_stock->insert($product_incomming_stock_INSERT);
						//  -----------end ADDING STOCK TO `product_incomming_stock` TABLE -----------

						//  -----------start ADDING ASSET MOVEMENT TIMELINE TO `asset_movement_timeline` TABLE -----------
						$amt_log_paragraph = 'A new asset referred to as the '.$pigi_product_name.' with a total quantity of '.$pis_qty.' units was successfully incorporated into the system on '.date('jS F Y', strtotime(date('Y-m-d'))).' at precisely '.date('h:i a', strtotime(date('H:i:s'))).'. This asset falls under the main category of '.$category_data->cname.', specifically classified as a '.$sub_category_data->scname.' within the subcategory hierarchy.';
						insert_log_to_asset_movement_timeline_table('INCOMMING',$amt_log_paragraph,$pigi_main_cat_id,$pigi_sub_cat_id,$pigi_id); //This function is available at application/helpers/asset_movement_helper.php
						//  -----------end ADDING ASSET MOVEMENT TIMELINE TO `asset_movement_timeline` TABLE -----------

						flash('swal_success','Asset has been successfully added.');
						redirect('admin/product/add');
					else:
						flash('error','Something went wrong!');
						redirect('admin/product/add');
					endif;
				else:
					flash('error', 'Sub category not found!');
					redirect('admin/product/add');
				endif;
			else:
				flash('error', 'Category not found!');
				redirect('admin/product/add');
			endif;
		endif;
	}
	public function store_more_qty(){
		// dd($this->input->post()); die;
		$this->form_validation->set_rules('Hidden_product_id', 'Product', 'required');
		$this->form_validation->set_rules('pqty', 'Product Quantity', 'required');
		$this->form_validation->set_rules('original_cost', 'Original Cost', 'required');
		$this->form_validation->set_error_delimiters('','');
		if($this->form_validation->run() == FALSE):
			flash('error', validation_errors());
			back();
		else:
			$pigi_id = decr($this->input->post('Hidden_product_id'));
			$ProductData = $this->Product_incomming_general_information->check(['pigi_id' => $pigi_id]);
			$category_data = $this->Tbl_category->check(['cid' => $ProductData->pigi_main_cat_id]);
			$sub_category_data = $this->Tbl_subcategory->check(['scid' => $ProductData->pigi_sub_cat_id]);
			
			$closing_asset_value = $this->get_closing_asset_value($category_data);
			$pis_depriciation_rate = $this->get_depriciation_value($category_data);
			$pis_qty = $this->input->post('pqty');
			$pis_product_original_cost = $this->input->post('original_cost');
			$pis_retired_date = $this->input->post('retired_date');
			$pis_serial_number = $this->input->post('serial_no');
			if($this->input->post('purchase_date') == true):
				$pis_purchase_date = $this->input->post('purchase_date');
			else:
				$pis_purchase_date = null;
			endif;
			if($this->input->post('retired') == 'Yes'):
				$pis_is_retired = 'Y';
				$pis_retired_date = $this->input->post('retired_date');
			else:
				$pis_is_retired = 'N';
				$pis_retired_date = null;
			endif;
			//START VENDOR INFORMARIONS------
			$pis_vendor_name = $this->input->post('vendor_name');
			$pis_vendor_phone = $this->input->post('vendor_phone');
			$pis_vendor_address = $this->input->post('vendor_address');
			//END VENDOR INFORMARIONS------

			$Invoice_file = $this->upload_invoice_file();
			$pis_invoice_type = $this->input->post('invoice_file_extension');
			$pis_closing_asset_value = $this->input->post('closing_value');
			$pis_remarks = $this->input->post('pis_remarks');

			// This is the main contexts wchich the QR code have and all the contents are dynamic.
			$Qrcode_context = strval(
				'Barcode: '.$ProductData->pigi_product_barcode.", ".
				'Category Name: '.$category_data->cname.", ".
				'Sub-Category Name: '.$sub_category_data->scname.", ".
				'Product Name: '.$ProductData->pigi_product_name.", ".
				'Product Desc: '.$ProductData->pigi_product_description.", ".
				'Product qty: '.$pis_qty.", ".
				'Serial No.: '.$pis_serial_number.", ".
				'Purchase Date: '.$pis_purchase_date.", ".
				'Original Cost: '.$pis_product_original_cost.", ".
				'Retired: '.$this->input->post('retired').", ".
				'Retired Date: '.$pis_retired_date.", ".
				'Depriciation: '.$pis_depriciation_rate.", ".
				'Closing Value: '.$pis_closing_asset_value.", ".
				'Vendor Name: '.$pis_vendor_name.", ".
				'Vendor Phone: '.$pis_vendor_phone.", ".
				'Vendor Address: '.$pis_vendor_address.", ".
				'Remarks: '.$pis_remarks
			);
			$QRCODE = $this->generate_qr_code($category_data,$Qrcode_context); //If the main category table field `cat_has_qr_code` == 'Y' then This function returns an array which contains qr code full path and the file name of the generated QR code. Otherwise the QR code will not be generated.
			// -----------start ADDING STOCK TO `product_incomming_stock` TABLE--------
			$product_incomming_stock_INSERT = [
				'pis_FK_asset_id' => $pigi_id,
				'pis_FK_main_category_id' => $ProductData->pigi_main_cat_id,
				'pis_FK_sub_category_id' => $ProductData->pigi_sub_cat_id,
				'pis_qty' => $pis_qty,
				'pis_product_original_cost' => $pis_product_original_cost,
				'pis_serial_number' => $pis_serial_number,
				'pis_purchase_date' => $pis_purchase_date,
				'pis_is_retired' => $pis_is_retired,
				'pis_retired_date' => $pis_retired_date,
				'pis_depriciation_rate' => $pis_depriciation_rate,
				'pis_vendor_name' => $pis_vendor_name,
				'pis_vendor_phone' => $pis_vendor_phone,
				'pis_vendor_address' => $pis_vendor_address,
				'pis_invoice_type' => $pis_invoice_type,
				'pis_invoice_file_name' => $Invoice_file['file_name'],
				'pis_invoice_uploaded_path' => $Invoice_file['full_file_path'],
				'pis_is_generate_qr' => $category_data->cat_has_qr_code,
				'pis_generated_qr_filename' => $QRCODE['qr_code_file_name'],
				'pis_generated_qr_path' => $QRCODE['full_qr_code_path'],
				'pis_closing_asset_value' => $pis_closing_asset_value,
				'pis_remarks' => $pis_remarks,
				'pis_added_datetime' => date('Y-m-d H:i:s'),
			];
			$this->Product_incomming_stock->insert($product_incomming_stock_INSERT);
			//  -----------end ADDING STOCK TO `product_incomming_stock` TABLE -----------

			//  -----------start ADDING ASSET MOVEMENT TIMELINE TO `asset_movement_timeline` TABLE -----------
			// $amt_log_paragraph = 'New asset named '.$pigi_product_name.' of '.$pis_qty.' no/nos of quantity has been added to system at '.date('Y-m-d H:i:s').' and the main category name is '.$category_data->cname.', and the sub category name is '.$sub_category_data->scname;
			$amt_log_paragraph = $pis_qty.' more units of the product named '.$ProductData->pigi_product_name.'  were added to the stock on '.date('Y-m-d H:i:s').'. The product belongs to the main category of '.$category_data->cname.', specifically the subcategory of '.$sub_category_data->scname;
			insert_log_to_asset_movement_timeline_table('INCOMMING',$amt_log_paragraph,$ProductData->pigi_main_cat_id,$ProductData->pigi_sub_cat_id,$pigi_id); //This function is available at application/helpers/asset_movement_helper.php
			//  -----------end ADDING ASSET MOVEMENT TIMELINE TO `asset_movement_timeline` TABLE -----------
			flash('swal_success','Asset has been successfully added.');
			back();
		endif;
	}
	public function generate_qr_code($category_data, $qr_context){
		if($category_data->cat_has_qr_code == 'Y'):
			//GENERATING QR CODE
			// QR code upload file path is set at config/qr_code.php
			$image_name = rand(100000, 999999).date('YmdHis').'.png';
			$qr_code_config = [
				'cacheable' => $this->config->item('cacheable'),
				'cachedir' => $this->config->item('cachedir'),
				'imagedir' => $this->config->item('imagedir'),
				'errorlog' => $this->config->item('errorlog'),
				'ciqrcodelib' => $this->config->item('ciqrcodelib'),
				'quality' => $this->config->item('quality'),
				'size' => $this->config->item('size'),
				'black' => $this->config->item('black'),
				'white' => $this->config->item('white'),
			];
			$this->ci_qr_code->initialize($qr_code_config);
			$params['data'] = $qr_context;
			$params['level'] = 'H';
			$params['size'] = 5;
			$params['savename'] = FCPATH . $qr_code_config['imagedir'] . $image_name;
			$this->ci_qr_code->generate($params);
			$full_qr_code_path = $this->data['qr_code_image_url'] = base_url() . $qr_code_config['imagedir'] . $image_name;
			$responce = [
				'full_qr_code_path' => $full_qr_code_path,
				'qr_code_file_name' => $image_name,
			];
		else:
			$responce = [
				'full_qr_code_path' => null,
				'qr_code_file_name' => null,
			];
		endif;
		return $responce;
		
	}
	public function upload_invoice_file(){
		if($_FILES['uimg']['name'] == ""):
			$uimg = '';
			$full_file_path = '';
		else:
			$config = [
				'upload_path'	=> 'assets/vimg',
				'allowed_types'	=> 'pdf|jpeg|jpg|png',
				'max_size'		=> '2000',
				'file_name'		=> rand(100000, 999999).date('Ymdhis'),
			];
	        $this->load->library('upload', $config);
	        $this->upload->initialize($config);
	        if(!$this->upload->do_upload('uimg')):
	            $error = $this->upload->display_errors();
	            echo $error;
	            flash('error', $error);
	            back();
	        else:
	            $data = $this->upload->data();
	            $uimg = $data['file_name'];
	            $full_file_path = BASE_URL.'assets/vimg/'.$uimg;
	        endif;
		endif;
		$img_data = [
			'file_name' => $uimg,
			'full_file_path' => $full_file_path,
		];
		return $img_data;
	}
	public function get_barcode($category_data){
		if($category_data->cat_has_barcode == 'Y'):
			return $this->input->post('barcode');
		else:
			return null;
		endif;
	}
	public function get_closing_asset_value($category_data){
		if($category_data->cat_has_closing_asset_value == 'Y'):
			return $this->input->post('closing_value');
		else:
			return null;
		endif;
	}
	public function get_depriciation_value($category_data){
		if($category_data->cat_has_depriciation == 'Y'):
			return $this->input->post('depriciation');
		else:
			return null;
		endif;
	}
	public function show_list(){
		$Data = [
			'PageTitle' => 'Admin | Poduct Added Master',
			'PageName' => 'Admin | Poduct Added Master',
		];
		$this->admin_view('product_incomming_master_list',$Data);
	}
	public function ajax_show_list(){
		$data = $row = array();
   		// Fetch member's records
   		$IncommingData = $this->Serverside_product_incomming_general_information->getRows($_POST);
   
       	$i = $_POST['start'];
       	foreach($IncommingData as $list){
       	   	$details_button = '<button type="button" onclick="view_asset_details(\''.encr($list->pigi_id).'\')" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> Details</button>';
           	$i++;
           	$data[] = [
			           	$i, 
			           	$list->pigi_product_name, 
			           	$list->pigi_product_description, 
			           	get_category_name($list->pigi_main_cat_id), 
			           	get_subcategory_name($list->pigi_sub_cat_id), 
			           	$list->pigi_product_barcode, 
			           	$list->pigi_created_datetime, 
			           	get_asset_current_stock($list->pigi_id).' Units', 
			           	$details_button
			        ];
       	}
       
       	$output = array(
           "draw" => $_POST['draw'],
           "recordsTotal" => $this->Serverside_product_incomming_general_information->countAll(),
           "recordsFiltered" => $this->Serverside_product_incomming_general_information->countFiltered($_POST),
           "data" => $data,
       	);
       
       	// Output to JSON format
       	echo json_encode($output);
	}
	public function show_product_details(){
		$pigi_id = decr($this->input->get('encrdtls_pigi_id'));
		$ProductGeneral_info = $this->Product_incomming_general_information->check(['pigi_id' => $pigi_id]);
		$Productstock_info = $this->Product_incomming_stock->get(['pis_FK_asset_id' => $pigi_id],'pis_id','DESC');
		$ProductAssetMovement_timeline = $this->Asset_movement_timeline->get(['amt_FK_asset_id' => $pigi_id],'amt_id','DESC');
		$Data = [
			'PageTitle' => 'Admin | Product Information',
			'PageName' => 'Admin | Product Information',
			'Asset_Id' =>  $pigi_id,
			'ProductGeneral_info' =>  $ProductGeneral_info,
			'Productstock_info' =>  $Productstock_info,
			'ProductAssetMovement_timeline' =>  $ProductAssetMovement_timeline,
			'serialNo' => gen_serial()
		];
		$this->admin_view('product_details',$Data);
	}
	public function get_live_stock(){
		$asset_id = $this->input->get('asset_id');
		$live_stock = get_asset_current_stock($asset_id);
		$res = [
			'LiveStock_count' =>  $live_stock,
		];
		echo json_encode($res);
	}
}