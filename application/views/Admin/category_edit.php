<!doctype html>
<html lang="en">
    <?php
    $this->load->view('Admin/inc/stylesheet');
    ?>
    <style>
        .image-clickable {
          transition: transform 0.2s;
        }
        .img-thumb{
            height: 272px;
            width: 262px;
        }
    </style>
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
                            <div class="col-12">
                                <div class="card border border-primary">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">General Information</h4>
                                        <?=form_open('admin/categories/update','name="update-form" method="post"');?>
                                        <input type="hidden" name="category_id" value="<?=encr($categoryData->cid);?>">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="">Category Name <span class="text-danger">*</span></label>
                                                    <input type="text" name="cname" value="<?=$categoryData->cname;?>" class="form-control" placeholder="Enter category name">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-success w-lg waves-effect waves-light"><i class="fa fa-save"></i> Update</button>
                                                </div>
                                            </div>
                                        </div>
                                        <?=form_close();?>
                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->
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
             $(function() {
                $("form[name='update-form']").validate({
                  rules: {
                    cname: {
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