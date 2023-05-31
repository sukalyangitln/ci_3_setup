<!doctype html>
<html lang="en">
    <head>        
        <meta charset="utf-8" />
        <title>Admin | Product Information | EFF N BEE MARKETING</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Asset Tracking System" />
        <meta content="Themesbrand" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="http://localhost/asset_tracking/assets/uploads/dynamic_page/company_profile/xt8ik4u4q7d5nydhhyj61.png">
        <!-- Bootstrap Css -->
        <link href="<?=base_url('assets/backend');?>/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="<?=base_url('assets/backend');?>/css/icons.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="<?=base_url('assets/backend');?>/css/app.min.css?sdhfisdh=20230529150408" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="<?=base_url('assets/backend');?>/css/custom.css?id=030408" rel="stylesheet" type="text/css" />
        <!-- DataTables -->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.bootstrap5.min.css">
        <link rel="stylesheet" type="text/css" href="<?=base_url('assets/backend');?>/libs/toastr/build/toastr.min.css">
        <style>
           .vertical-menu{
            background-color: #ffffff !important;
            color: green !important;
           }
           .no-hover:hover {
             color: inherit;
             background-color: inherit;
             /* Add any other properties that may be affected by the hover effect */
           }
           .menu-active{
            background-color: #cdd5f9 !important;
           }
           .image-clickable {
             transition: transform 0.2s;
           }
           .img-thumb{
               height: 272px;
               width: 262px;
           }
           .disabled-field {
             background-color: #f2f2f2;
             color: #777;
           }
           .thmb-image {
               width: 100%;
               border: 1px solid #2a3042;
               cursor: pointer;
               height: 200px;
           }
           .modal-content{
            border-radius: 0 !important;
           }
        </style>
    </head>
    <script type="text/javascript">
        const BASE_URL='<?=BASE_URL;?>';
    </script>
    <link href="<?=base_url('assets/backend');?>/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
    <body data-sidebar="dark">
        <!-- Begin page -->
        <div id="layout-wrapper">
            <?php
            $this->load->view('Admin/inc/header');
            $this->load->view('Admin/inc/sidebar');
            ?>
            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">
                <div class="page-content">
                    <div class="container-fluid">
                        <!-- start page title -->
                        <?php
                        $this->load->view('Admin/inc/page_section');
                        ?>
                        <!-- end page title -->
                        <div class="row">
                            <div class="col-12">
                                <?=notification_message();?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card border border-primary">
                                    <div class="card-body">
                                        <div class="card-body">
                                            <!-- Nav tabs -->
                                            <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active" data-bs-toggle="tab" href="#ast_general_info" role="tab">
                                                        <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                                        <span class="d-none d-sm-block">General Information</span> 
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-bs-toggle="tab" href="#ast_movement_timeline" role="tab">
                                                        <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                                        <span class="d-none d-sm-block">Movement Timeline</span> 
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-bs-toggle="tab" href="#ast_more_info" role="tab">
                                                        <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                                        <span class="d-none d-sm-block">More Information</span>   
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-bs-toggle="tab" href="#ast_more_qty" role="tab">
                                                        <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                                        <span class="d-none d-sm-block">Add quantity</span>   
                                                    </a>
                                                </li>
                                            </ul>
                                            <!-- Tab panes -->
                                            <div class="tab-content p-3 text-muted">
                                                <div class="tab-pane active" id="ast_general_info" role="tabpanel">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th>Product Name</th>
                                                                    <th>Product Description</th>
                                                                    <th>Main Category</th>
                                                                    <th>Sub Category</th>
                                                                    <th>Barcode</th>
                                                                    <th>Created Datetime</th>
                                                                    <th>Current Stock</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td><?=$ProductGeneral_info->pigi_product_name;?></td>
                                                                    <td><?=$ProductGeneral_info->pigi_product_description;?></td>
                                                                    <td><?=get_category_name($ProductGeneral_info->pigi_main_cat_id);?></td>
                                                                    <td><?=get_subcategory_name($ProductGeneral_info->pigi_sub_cat_id);?></td>
                                                                    <td><?=$ProductGeneral_info->pigi_product_barcode;?></td>
                                                                    <td><?=$ProductGeneral_info->pigi_created_datetime;?></td>
                                                                    <td>
                                                                        <span id="LiveStock_count"><?=get_asset_current_stock($ProductGeneral_info->pigi_id); ?></span>            
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="ast_movement_timeline" role="tabpanel">
                                                    <div class="table-responsive">
                                                        <table id="example" class="table table-bordered table-sm">
                                                            <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Date</th>
                                                                <th>Notification</th>
                                                                <th>Type</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                    $mt = 1;
                                                                    foreach($ProductAssetMovement_timeline as $timelineData):
                                                                ?>
                                                                <tr>
                                                                    <td><?=$mt++?></td>
                                                                    <td><?=$timelineData->amt_dateTime;?></td>
                                                                    <td><?=$timelineData->amt_log_paragraph;?></td>
                                                                    <td><?=$timelineData->amt_type;?></td>
                                                                </tr>
                                                            <?php endforeach; ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="ast_more_info" role="tabpanel">
                                                    <div class="table-responsive">
                                                        <table id="example_two" class="table table-bordered">
                                                            <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>QR Code</th>
                                                                <th>Qty</th>
                                                                <th>Original Cost</th>
                                                                <th>Serial No.</th>
                                                                <th>Purchase Date</th>
                                                                <th>Retired Possible?</th>
                                                                <th>Retired Date</th>
                                                                <th>Depriciation Rate</th>
                                                                <th>Vendor Name</th>
                                                                <th>Vendor Phone</th>
                                                                <th>Vendor Address</th>
                                                                <th>Invoice</th>
                                                                <th>Closing Asset Value</th>
                                                                <th>Remarks</th>
                                                                <th>Datetime</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                    $stkinfo = 1;
                                                                    foreach($Productstock_info as $stockdata):
                                                                ?>
                                                                <tr>
                                                                    <td><?=$stkinfo++?></td>
                                                                    <td>
                                                                        <?php if($stockdata->pis_is_generate_qr): ?>
                                                                        <img src="<?=$stockdata->pis_generated_qr_path;?>" alt="" style="height: 100px; cursor: pointer;" onclick="show_qr_in_modal('<?=$stockdata->pis_generated_qr_path;?>')">
                                                                    <?php endif; ?>
                                                                    </td>
                                                                    <td><?=$stockdata->pis_qty;?></td>
                                                                    <td><?=$stockdata->pis_product_original_cost;?></td>
                                                                    <td><?=$stockdata->pis_serial_number;?></td>
                                                                    <td><?=$stockdata->pis_purchase_date;?></td>
                                                                    <td><?=($stockdata->pis_is_retired == 'Y')?'Yes':'No';?></td>
                                                                    <td><?=$stockdata->pis_retired_date;?></td>
                                                                    <td><?=$stockdata->pis_depriciation_rate;?></td>
                                                                    <td><?=$stockdata->pis_vendor_name;?></td>
                                                                    <td><?=$stockdata->pis_vendor_phone;?></td>
                                                                    <td><?=$stockdata->pis_vendor_address;?></td>
                                                                    <td>
                                                                        <a class="btn btn-info btn-sm" href="<?=$stockdata->pis_invoice_uploaded_path;?>" target="_ "><i class="fas fa-file-invoice"></i> View</a>
                                                                    </td>
                                                                    <td><?=$stockdata->pis_closing_asset_value;?></td>
                                                                    <td><?=$stockdata->pis_remarks;?></td>
                                                                    <td><?=$stockdata->pis_added_datetime;?></td>
                                                                </tr>
                                                            <?php endforeach; ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="ast_more_qty" role="tabpanel">
                                                    <?=form_open_multipart('admin/product/add-qty','name="insert-form" method="post"');?>
                                                    <input type="hidden" name="Hidden_product_id" value="<?=encr($ProductGeneral_info->pigi_id);?>">
                                                    <div class="row">
                                                        <div class="col-md-8">
                                                            <div class="card border border-primary">
                                                                <div class="card-body">
                                                                    <h4 class="card-title">Product information</h4>
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label for="">Product Quantity</label>
                                                                                <input type="number" name="pqty" class="form-control numeric-input" placeholder="Enter QTY">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label for="">Original Cost </label>
                                                                                <input type="number" id="pointspossible" name="original_cost" class="form-control" placeholder="Enter original cost">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <div class="form-group">
                                                                                <label for="">Description</label>
                                                                                <textarea rows="7" name="pdesc" class="form-control br-0" placeholder="Description here.."></textarea>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="card border border-primary">
                                                                <div class="card-body">
                                                                    <h4 class="card-title">Auto Generateable Fields</h4>
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <div class="form-group">
                                                                                <label for="">Serial Number (Auto generated) <input type="checkbox" name="generate_serial_number"></label>
                                                                                <input type="hidden" name="hiddenSrNumber" value="<?=$serialNo;?>">
                                                                                <input type="text" name="serial_no" class="form-control br-0" placeholder="Enter serial no..">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="card border border-primary">
                                                                <div class="card-body">
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label for="">Purchase Date <span class="text-danger">*</span></label>
                                                                                <input type="date" name="purchase_date" class="form-control" placeholder="Enter product name">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label for="">Retired?</label>
                                                                                <select name="retired" class="form-control" style="width: 100%;">
                                                                                    <option value="Yes">Yes</option>
                                                                                    <option value="No">No</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label for="">Retired Date</label>
                                                                                <input type="date" id="retired_date_field_date" name="retired_date" class="form-control br-0" placeholder="Short Description here..">
                                                                                <input id="retired_date_field_null" class="form-control br-0" style="display: none;">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label for="">Depriciation %</label>
                                                                                <input type="text" id="pointsgiven" name="depriciation" class="float-input form-control br-0" placeholder="%">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                            <!-- <div class="card border border-primary">
                                                                <div class="card-body">
                                                                    asdassda
                                                                </div>
                                                            </div> -->
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="card border border-primary">
                                                                <div class="card-body">
                                                                    <h4 class="card-title">Category Informations</h4>
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label for="">Vendor Name <span class="text-danger">*</span></label>
                                                                                <input type="text" name="vendor_name" class="form-control" placeholder="Enter vendor name">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label for="">Vendor Phone</label>
                                                                                <input type="text" name="vendor_phone" class="form-control" placeholder="Enter vendor name">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <div class="form-group">
                                                                                <label for="">Vendor Address <span class="text-danger">*</span></label>
                                                                                <textarea name="vendor_address" class="form-control" placeholder="Enter vendor address"></textarea>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="card border border-primary">
                                                                <div class="card-body">
                                                                    <h4 class="card-title">Invoice</h4>
                                                                    <div class="form-group">
                                                                        <label>Invoice Image </label>
                                                                        <input type="hidden" name="invoice_file_extension">
                                                                        <input type="file" name="uimg" id="uimg" class="form-control" accept="image/*, .pdf">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="card border border-primary">
                                                                <div class="card-body">
                                                                    <div class="form-group">
                                                                        <label>Closing asset value</label>
                                                                        <input type="text" id="pointsperc" name="closing_value" readonly="" class="form-control" placeholder="This field is auto generated">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Remarks</label>
                                                                        <textarea name="pis_remarks" rows="1" class="form-control" placeholder="Enter remarks if any..."></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="card border border-primary br-0">
                                                                <div class="card-body">
                                                                    <div class="form-group text-right mb-0">
                                                                        <button type="submit" class="btn btn-primary btn-block btn-lg br-0">SAVE <i class="fa fa-save"></i></button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?=form_close();?>
                                                </div>
                                            </div>
                                        
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php 
                $this->load->view('Admin/inc/footer');
                ?>
            </div>
        </div>
        <!-- sample modal content -->
        <div id="QR_view_modal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="myModalLabel">QR Code</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <img src="" class="img-fluid" id="qr_view">
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <div id="pdfviewmodal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="myModalLabel">Invoice Preview</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="Height: 350px;">
                        <div id="pdfViewer" style="Height: 300px;"></div>
                        <div id="imagepreview" style="Height: 300px;">
                            <img src="" class="thmb-image" id="thummb_image" alt="">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close preview</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <script src="<?=base_url('assets/backend');?>/libs/jquery/jquery.min.js"></script>
        <script src="<?=base_url('assets/backend');?>/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="<?=base_url('assets/backend');?>/libs/metismenu/metisMenu.min.js"></script>
        <script src="<?=base_url('assets/backend');?>/libs/simplebar/simplebar.min.js"></script>
        <script src="<?=base_url('assets/backend');?>/libs/node-waves/waves.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>

        <!-- Required datatable js -->

        <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.bootstrap5.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.colVis.min.js"></script>

        <!-- Datatable init js -->
        <script src="<?=base_url('assets/backend');?>/libs/toastr/build/toastr.min.js"></script>
        <script src="<?=base_url('assets/backend');?>/js/app.js"></script>
        <!-- Sweet Alerts js -->
        <script src="<?=base_url('assets/backend');?>/libs/sweetalert2/sweetalert2.min.js"></script>
        <!-- Sweet alert init js-->
        <script src="<?=base_url('assets/backend');?>/js/pages/sweet-alerts.init.js"></script>
        <script>
            $(document).ready(function() {
              var table1 = $('#example').DataTable({
                lengthChange: false,
                buttons: ['copy', 'excel', 'pdf', 'colvis']
              });
              table1.buttons().container().appendTo('#example_wrapper .col-md-6:eq(0)');

              var table2 = $('#example_two').DataTable({
                lengthChange: false,
                buttons: ['copy', 'excel', 'pdf', 'colvis']
              });
              table2.buttons().container().appendTo('#example_two_wrapper .col-md-6:eq(0)');
              setInterval(liveData, 5000); // Call myFunction every 5 seconds
              function liveData() {
                  $.ajax({
                    type: 'get',
                    url: BASE_URL+'admin/product/get-live-stock',
                    data: {'asset_id' : '<?=$ProductGeneral_info->pigi_id;?>'},
                    dataType: 'json',
                    success: function(response){
                        $('#LiveStock_count').html(response.LiveStock_count);
                        // console.log(response);
                    }
                  });
              }
            });
            function show_qr_in_modal(pis_generated_qr_path){
                $('#qr_view').attr('src',pis_generated_qr_path);
                $('#QR_view_modal').modal('show');
            }
            $('input[name="generate_serial_number"]').change(function(){
                if ($(this).prop('checked')) {
                  var hiddenSrNumber = $('input[name="hiddenSrNumber"]').val(); 
                  $('input[name="serial_no"]').val(hiddenSrNumber);
                } else {
                  $('input[name="serial_no"]').val('');
                }
            });
            $('select[name="retired"]').change(function(){
                if($(this).val() == 'Yes'){
                    $('input[name="retired_date"]').removeAttr('readonly');
                    $('#retired_date_field_null').css('display','none');
                    $('#retired_date_field_date').css('display','block');
                }
                else{
                    $('input[name="retired_date"]').prop('readonly', true).val('');
                    $('#retired_date_field_null').css('display','block').prop('readonly', true);
                    $('#retired_date_field_date').css('display','none');
                }
            });
            $('input[name="uimg"]').on('change', function(e) {
                var fileName = $(this).val().split('\\').pop();
                var fileExtension = fileName.split('.').pop();
                $('input[name="invoice_file_extension"]').val(fileExtension);

                var imagePreview = $('#imagepreview');
                var pdfViewer = $('#pdfViewer');
                var fileInput = $(this)[0];
                var thumbnailImage = $('#thummb_image');

                if (fileExtension == 'pdf') {
                    imagePreview.hide();
                    pdfViewer.show();
                    
                    var file = e.target.files[0];
                    var reader = new FileReader();
                    reader.onload = function(e) {
                    pdfViewer.empty(); // Clear previous content
                    // Create an <embed> element to display the PDF file
                    var embedElement = $('<embed src="' + e.target.result + '" type="application/pdf" width="100%" height="100%">');
                    pdfViewer.append(embedElement);
                    };
                    reader.readAsDataURL(file);
                } else {
                    imagePreview.show();
                    pdfViewer.hide();
                    
                    if (fileInput.files && fileInput.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        thumbnailImage.attr('src', e.target.result);
                    };
                    reader.readAsDataURL(fileInput.files[0]);
                    }
                }

                $('#pdfviewmodal').modal('show');
            });

            $(function() {
               $("form[name='insert-form']").validate({
                 rules: {
                   pqty: {
                     required: true,
                   },
                   pqty: {
                     required: true,
                   },
                   original_cost: {
                     required: true,
                   },
                   serial_no: {
                     required: true,
                   },
                 },
                 messages: {
                 },
                 submitHandler: function(form) {
                   form.submit();
                 }
               });
             });
            // SOFIK FUNCTIONS
            $('#pointspossible').on('input', function() {
              calculate();
            });
            $('#pointsgiven').on('input', function() {
             calculate();
            });
            function isNumeric(n) {
                return !isNaN(parseFloat(n)) && isFinite(n);
            }
            function calculate() {
                var a = $('#pointspossible').val().replace(/ +/g, "");
                var b = $('#pointsgiven').val().replace(/ +/g, "");
                var perc = "0";
                if (a.length > 0 && b.length > 0) {
                    if (isNumeric(a) && isNumeric(b)) {
                        perc = a-(a / 100 * b);
                    }
                }    
                // console.log(a,b);
                $('#pointsperc').val(perc);
            }
        </script>
        <?php if($this->session->flashdata('swal_success')): ?>
            <script>
            Swal.fire(
                  "Success!",
                  "<?=$this->session->flashdata('swal_success');?>",
                  "success"
                );
            </script>
        <?php unset($_SESSION['swal_success']); endif;  ?>
    </body>
</html>