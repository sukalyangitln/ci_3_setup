<!doctype html>
<html lang="en">
    <?php
    $this->load->view('Admin/inc/stylesheet');
    ?>
    <body data-sidebar="dark" class="admin-profile">
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
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-body">
                                        <?=notification_message();?>
                                        <div class="card border border-primary">
                                            <div class="card-body">
                                                <?=form_open('admin-change-password',['method'=>'POST','class'=>'admin-change-password','name'=>"admin-change-password"]);?>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Old Password *</label>
                                                            <input type="password" class="form-control" name="old_password" placeholder="Enter old password">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>New Password *</label>
                                                            <input type="password" class="form-control" id="new_password" name="new_password" placeholder="Enter new password">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Confirm Password *</label>
                                                            <input type="password" class="form-control" name="confirm_password" placeholder="Confirm new password">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <button type="submit" class="btn btn-primary">Save Password <i class="fa fa-save"></i></button>
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
    </body>
    <script>
        $(function() {
            $("form[name='admin-change-password']").validate({
                rules: {
                    old_password: {
                        required: true,
                    },
                    new_password: {
                        required: true,
                    },
                    confirm_password: {
                        required: true,
                        equalTo: "#new_password",
                    },
                },
                messages: {},
                submitHandler: function(form) {
                    form.submit();
                }
            });
        }); 
    </script>
</html>