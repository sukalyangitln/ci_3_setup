<!doctype html>
<html lang="en">
    <?php
    $this->load->view('Admin/inc/stylesheet');
    ?>
    <body data-sidebar="dark" class="admin-company-profile">
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
                                        <?=form_open_multipart('admin-company-profile',['method'=>'POST','name'=>'admin-company-profile']);?>
                                        <input type="hidden" name="comp_id" value="<?=$profile->comp_id;?>">
                                        <div class="form-group">
                                            <label>Website name <span class="required">*</span></label>
                                            <input type="text" name="comp_name" class="form-control" value="<?=$profile->comp_name;?>" placeholder="Company Name">
                                        </div>
                                        <div class="form-group">
                                            <label>Website show name <span class="required">*</span></label>
                                            <input type="text" name="comp_show_name" class="form-control" value="<?=$profile->comp_show_name;?>" placeholder="Company show name">
                                        </div>
                                        <div class="form-group">
                                            <label>Contact No <span class="required">*</span></label>
                                            <input type="text" name="comp_contact_no" class="form-control" value="<?=$profile->comp_contact_no;?>" placeholder="XXXXXXXXXX">
                                        </div>
                                        <div class="form-group">
                                            <label>WhatsApp No <span class="required">*</span> <span class="error">(With country code)</span></label>
                                            <input type="text" name="comp_whats_app_no" class="form-control" value="<?=$profile->comp_whats_app_no;?>" placeholder="Whatsapp no (with country code)">
                                        </div>
                                        <div class="form-group">
                                            <label>Email <span class="required">*</span></label>
                                            <input type="text" name="comp_email" class="form-control" value="<?=$profile->comp_email;?>" placeholder="Company email">
                                        </div>

                                        <div class="form-group">
                                            <label>Copyright <span class="required">*</span></label>
                                            <input type="text" name="comp_copyright" class="form-control" value="<?=$profile->comp_copyright;?>" placeholder="Copyright">
                                        </div>
                                        <div class="form-group">
                                            <label>Developed By <span class="required">*</span></label>
                                            <input type="text" name="comp_develop_by" class="form-control" value="<?=$profile->comp_develop_by;?>" placeholder="Develop by">
                                            <input type="text" name="comp_develop_by_link" class="form-control" value="<?=$profile->comp_develop_by_link;?>" placeholder="Link">
                                        </div>
                                        <div class="form-group">
                                            <label>Company Logo <span class="required">*</span></label>
                                            <br><img src="<?=base_url().$profile->comp_logo_path.$profile->comp_logo;?>" class="comp_logo_img" id="comp_logo_img">
                                            <input type="file" name="comp_logo" class="comp_logo form-control d-none" id="comp_logo" accept="image/png, image/jpeg, image/jpg" />
                                        </div>
                                        <div class="form-group">
                                            <label>Favicon icon <span class="required">*</span></label>
                                            <br><img src="<?=base_url().$profile->comp_logo_path.$profile->comp_favicon;?>" class="comp_favicon_img" id="comp_favicon_img">
                                            <input type="file" name="comp_favicon" class="comp_favicon form-control d-none" id="comp_favicon" accept="image/png, image/jpeg, image/jpg" />
                                        </div>
                                        <div class="form-group d-grid gap-2">
                                            <button type="submit" class="btn btn-outline-primary has-ripple btn-block">SAVE <i class="fa fa-save"></i></button>
                                        </div>
                                        <?=form_close();?>  
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
        $(".comp_logo_img").on('click', function(event){
            $('.comp_logo').click();
        });
        comp_logo.onchange = evt => {
          const [file] = comp_logo.files
          if (file) {
            comp_logo_img.src = URL.createObjectURL(file)
          }
        }

        $(".comp_favicon_img").on('click', function(event){
            $('.comp_favicon').click();
        });
        comp_favicon.onchange = evt => {
          const [file] = comp_favicon.files
          if (file) {
            comp_favicon_img.src = URL.createObjectURL(file)
          }
        }

        $(function(){
           $("form[name='admin-company-profile']").validate({
                rules :{
                    comp_name:{
                        required: true,
                    },
                    comp_show_name:{
                        required: true,
                    },
                    comp_email:{
                        required: true,
                        email:true,
                    },
                    comp_contact_no:{
                        required: true,
                        number:true,
                    },
                    comp_whats_app_no:{
                        required: true,
                        number:true,
                    },
                },
                messages :{},
                submitHandler: function(form){
                    form.submit();
                }
            });
        });
    </script>
</html>