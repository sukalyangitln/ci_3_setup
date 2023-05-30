<!doctype html>
<html lang="en">
    <?php
    $this->load->view('Admin/inc/stylesheet');
    ?>
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
                                        <?=form_open('admin/sub-categories/update','name="update-form" method="post"');?>
                                        <input type="hidden" name="scid" value="<?=encr($subcategoryData->scid);?>">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">Main Category <span class="text-danger">*</span></label>
                                                    <select name="cid" class="form-control">
                                                        <option value="">- Select Main Category -</option>
                                                        <?php
                                                            $MainCategories = get_all_categories();
                                                            foreach($MainCategories as $cat_list):
                                                        ?>
                                                        <option <?=($subcategoryData->cid == $cat_list->cid)?'selected':'';?> value="<?=$cat_list->cid;?>"><?=$cat_list->cname;?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">Sub Category Name <span class="text-danger">*</span></label>
                                                    <input type="text" value="<?=$subcategoryData->scname;?>" name="scname" class="form-control" placeholder="Enter sub category name">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-success w-lg waves-effect waves-light"><i class="fa fa-save"></i> Save</button>
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
                    scid: {
                      required: true,
                    },
                    cid: {
                      required: true,
                    },
                    scname: {
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