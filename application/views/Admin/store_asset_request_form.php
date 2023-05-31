<!doctype html>
<html lang="en">
    <?php
    $this->load->view('Admin/inc/stylesheet');
    ?>
    <link href="<?=base_url('assets/backend');?>/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="<?=base_url('assets/backend/css/custom_css/ajax_loader.css');?>">
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
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card border border-primary">
                                    <div class="card-body">
                                        <div class="response_msg"></div>
                                        <?=form_open('request-for-asset','name="request-for-asset" method="post"');?>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="">Main Category <span class="text-danger">*</span></label>
                                                    <select name="ar_FK_main_category_id" class="form-control" onchange="fetch_sub_category(this.value)">
                                                        <option value="">-Select Category-</option>
                                                        <?php
                                                        foreach($category_list as $cat_list):
                                                            echo '<option value="'.encr($cat_list->cid).'">'.$cat_list->cname.'</option>';
                                                        endforeach;
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="">Sub Category <span class="text-danger">*</span></label>
                                                    <select name="ar_FK_sub_category_id" class="form-control" onchange="get_asset_description(this.value)">
                                                        <option value="">-Select Sub Category-</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="">Asset Description <span class="text-danger">*</span></label>
                                                    <select name="ar_FK_asset_id" class="form-control">
                                                        <option value="">-Select Asset-</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="">Quantity <span class="text-danger">*</span></label>
                                                    <input type="number" name="ar_requested_qty" class="form-control" placeholder="Enter quantity">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="">Additional Note.</label>
                                                    <textarea name="ar_remarks" class="form-control" placeholder="Enter remarks if any...."></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-primary w-lg waves-effect waves-light"><i class="fa fa-send-o"></i> Submit Request</button>
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
                <?php 
                $this->load->view('Admin/inc/footer');
                ?>
            </div>
        </div>
        <?php 
        $this->load->view('Admin/inc/script');
        ?>
        <script src="<?=base_url('assets/backend');?>/js/app.js"></script>
        <!-- Sweet Alerts js -->
        <script src="<?=base_url('assets/backend');?>/libs/sweetalert2/sweetalert2.min.js"></script>
        <!-- Sweet alert init js-->
        <script src="<?=base_url('assets/backend');?>/js/pages/sweet-alerts.init.js"></script>
        <script>
            function fetch_sub_category(main_category_id){
                if(main_category_id != ''){
                    $('#ajax-loader').append("<div class='page-loader-overlay'></div><div class='page-loader'></div>");
                    $.ajax({
                        type: 'GET',
                        url: BASE_URL+'request-for-asset/get-sub-category-by-main-category-id',
                        data: {'main_category_id' : main_category_id},
                        dataType: 'json',
                        success: function(result){
                            $('.page-loader-overlay, .page-loader').fadeOut(100, function() {
                                $(this).remove();
                            });
                            $('select[name="ar_FK_sub_category_id"]').html(result.sub_cat_design);
                            $('select[name="ar_FK_asset_id"]').html('<option value="">-Select Asset-</option>');
                        },
                        error: function(xhr, status, error) {
                            console.log(error);
                        }
                    });
                }
            }
            function get_asset_description(sub_category_id){
                if(sub_category_id != ''){
                    $('#ajax-loader').append("<div class='page-loader-overlay'></div><div class='page-loader'></div>");
                    $.ajax({
                        type: 'GET',
                        url: BASE_URL+'request-for-asset/get-assets-by-sub-category',
                        data: {'sub_category_id' : sub_category_id},
                        dataType: 'json',
                        success: function(result){
                            // console.log(result);
                            $('.page-loader-overlay, .page-loader').fadeOut(100, function() {
                                $(this).remove();
                            });
                            $('select[name="ar_FK_asset_id"]').html(result.asset_design);
                        },
                        error: function(xhr, status, error) {
                            console.log(error);
                        }
                    });
                }
            }
             $(function() {
                $("form[name='request-for-asset']").validate({
                  rules: {
                    ar_FK_main_category_id: {
                      required: true,
                    },
                    ar_FK_sub_category_id: {
                      required: true,
                    },
                    ar_FK_asset_id: {
                      required: true,
                    },
                    ar_requested_qty: {
                      required: true,
                    },
                  },
                  messages: {
                  },
                  submitHandler: function(form) {
                    $('#ajax-loader').append("<div class='page-loader-overlay'></div><div class='page-loader'></div>");
                    $.ajax({
                      url: BASE_URL+'request-for-asset',
                      type: "POST",
                      data: $(form).serialize(),
                      dataType: 'json',
                      success: function(res) {
                        $('.page-loader-overlay, .page-loader').fadeOut(100, function() {
                            $(this).remove();
                        });
                        console.log(res);
                        $('.response_msg').html(res.msg);
                        $("form[name='request-for-asset']")[0].reset();
                      }
                    });
                    return false;
                  }
                });
              });
        </script>
        <script>
            <?php if($this->session->flashdata('swal_success')): ?>
                Swal.fire(
                      "Success!",
                      "<?=$this->session->flashdata('swal_success');?>",
                      "success"
                    );
            <?php unset($_SESSION['swal_success']); endif;  ?>
        </script>
    </body>
</html>