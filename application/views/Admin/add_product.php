<!doctype html>
<html lang="en">
    <?php
    $this->load->view('Admin/inc/stylesheet');
    ?>
    <link href="<?=base_url('assets/backend');?>/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="<?=base_url('assets/backend/css/custom_css/ajax_loader.css');?>">
    <style>
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
    </style>
    <body data-sidebar="dark">
        <div id="ajax-loader"></div>
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
                        <?=form_open_multipart('admin/product/add','name="insert-form" method="post"');?>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="card border border-primary">
                                    <div class="card-body">
                                        <h4 class="card-title">Product information</h4>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">Main Category <span class="text-danger">*</span></label>
                                                    <select name="cid" onchange="fetch_sub_category(this.value)" class="form-control">
                                                        <option value="">-Select Main Category-</option>
                                                        <?php
                                                        $categories = get_all_categories();
                                                        foreach($categories as $category):
                                                            echo '<option value="'.$category->cid.'">'.$category->cname.'</option>';
                                                        endforeach;
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">Sub Category <span class="text-danger">*</span></label>
                                                    <select name="scid" class="form-control">
                                                        <option value="">-Select Sub Category-</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>  
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="">Product Name <span class="text-danger">*</span></label>
                                                    <input type="text" name="pname" class="form-control" placeholder="Enter product name">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="">Product Quantity <span class="text-danger">*</span></label>
                                                    <input type="number" name="pqty" class="form-control numeric-input" placeholder="Enter QTY">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="">Original Cost <span class="text-danger">*</span></label>
                                                    <input type="number" id="pointspossible" name="original_cost" class="form-control" placeholder="Enter original cost">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="">Description</label>
                                                    <textarea rows="1" name="pdesc" class="form-control br-0" placeholder="Description here.."></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card border border-primary">
                                    <div class="card-body">
                                        <h4 class="card-title">Auto Generateable Fields</h4>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">BAR code (Auto generated) <span class="text-danger">*</span></label>
                                                    <input type="text" name="barcode" value="<?=$Barcode;?>" readonly class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
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
                            </div>
                            <!-- end col -->
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
                                            <input type="text" id="pointsperc" name="closing_value" readonly class="form-control" placeholder="This field is auto generated">
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
                            <!-- end col -->
                        </div>
                        <!-- end row -->
                        <?=form_close();?>
                    </div>
                </div>
                <?php 
                $this->load->view('Admin/inc/footer');
                ?>
            </div>
        </div>
        <?php 
        $this->load->view('Admin/inc/script');
        ?>
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
        <script src="<?=base_url('assets/backend');?>/js/app.js"></script>
        <!-- Sweet Alerts js -->
        <script src="<?=base_url('assets/backend');?>/libs/sweetalert2/sweetalert2.min.js"></script>
        <!-- Sweet alert init js-->
        <script src="<?=base_url('assets/backend');?>/js/pages/sweet-alerts.init.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfobject/2.2.4/pdfobject.min.js"></script>
        <script src="<?=base_url('assets/backend/js/custom/add_product.js?token='.date('YmdHis'));?>"></script>
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