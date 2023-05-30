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
                                        <?=form_open('admin/stores/update','name="update_form" method="post"');?>
                                        <input type="hidden" name="store_id" value="<?=encr($StoreData->id);?>">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="">Store Name <span class="text-danger">*</span></label>
                                                    <input type="text" value="<?=$StoreData->store;?>" name="store" class="form-control" placeholder="Enter store name">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="">Store manager Name <span class="text-danger">*</span></label>
                                                    <input type="text" value="<?=$StoreData->store_mng_name;?>" name="store_mng_name" class="form-control" placeholder="Manager Name">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="">Store manager Phone <span class="text-danger">*</span></label>
                                                    <input type="text" value="<?=$StoreData->store_m_phone;?>" name="store_m_phone" class="form-control" placeholder="Manager Phone">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="">Store Address</label>
                                                    <textarea name="store_address" class="form-control" placeholder="Enter address"><?=$StoreData->store_address;?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <h4 class="card-title mb-4">Account Credentials</h4>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="username">Username <span class="text-danger">*</span></label>
                                                    <input type="text" name="username" value="<?=$StoreData->username;?>" onkeyup="validate_username(this.value)" class="form-control" placeholder="Enter username">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">Password <span class="text-danger">*</span></label>
                                                    <input type="text" name="password" value="<?=$StoreData->password;?>" class="form-control" placeholder="Enter password">
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
                $("form[name='update_form']").validate({
                  rules: {
                    store: {
                      required: true,
                    },
                    username: {
                      required: true,
                    },
                    password: {
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
             $(document).ready(function() {
              $('#thumbnail_image').on('mousedown mouseup mouseleave', function(event) {
                 if (event.type === 'mousedown') {
                   $(this).css('transform', 'scale(0.95)');
                 } else {
                   $(this).css('transform', 'scale(1)');
                 }
               });
              $('#thumbnail_image').click(function(){
                $('input[name="sh_thumbnail"]').click();
              });
             });
             $('input[name="sh_thumbnail"]').on('change', function() {
                 var fileInput = $(this)[0];
                 var thumbnailImage = $('#thumbnail_image');

                 if (fileInput.files && fileInput.files[0]) {
                   var reader = new FileReader();

                   reader.onload = function(e) {
                     thumbnailImage.attr('src', e.target.result);
                   };

                   reader.readAsDataURL(fileInput.files[0]);
                 }
               });
             function validate_username(username){
                 $.ajax({
                     type: 'GET',
                     url: BASE_URL+'admin/stores/validate-username-update-time',
                     data: {
                        'username' : username,
                        'encr_store_id' : $('input[name="store_id"]').val(),
                    },
                     dataType: 'json',
                     success: function(result){
                         if(result.response == 0){
                             $('label[for="username"]').text(result.msg).css('color','red');
                         }
                         else{
                             $('label[for="username"]').html('Username <span class="text-danger">*</span>').css('color','#495057');
                         }
                     }
                 });
             }
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