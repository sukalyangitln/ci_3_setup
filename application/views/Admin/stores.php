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
                            <div class="col-md-12">
                                <div class="card border border-primary">
                                    <div class="card-body">
                                        <ul class="nav nav-pills nav-justified" role="tablist" style="background-color: #ccc;">
                                            <li class="nav-item waves-effect waves-light">
                                                <a class="nav-link active" data-bs-toggle="tab" href="#add_form" role="tab">
                                                    <span class="d-block d-sm-none"><i class="fa fa-plus"></i></span>
                                                    <span class="d-none d-sm-block"><i class="fa fa-plus"></i> Add New</span> 
                                                </a>
                                            </li>
                                            <li class="nav-item waves-effect waves-light">
                                                <a class="nav-link" data-bs-toggle="tab" href="#show_list_datatable" role="tab">
                                                    <span class="d-block d-sm-none"><i class="fa fa-users"></i></span>
                                                    <span class="d-none d-sm-block"><i class="fa fa-users"></i> Store List</span> 
                                                </a>
                                            </li>
                                        </ul>
                                        <!-- Tab panes -->
                                        <div class="tab-content p-3 text-muted">
                                            <div class="tab-pane active" id="add_form" role="tabpanel">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <h4 class="card-title mb-4">General Information</h4>
                                                        <?=form_open('admin/stores/add','name="insert-form" method="post"');?>
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="">Store Name <span class="text-danger">*</span></label>
                                                                    <input type="text" name="store" class="form-control" placeholder="Enter store name">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="">Store manager Name <span class="text-danger">*</span></label>
                                                                    <input type="text" name="store_mng_name" class="form-control" placeholder="Manager Name">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="">Store manager Phone <span class="text-danger">*</span></label>
                                                                    <input type="text" name="store_m_phone" class="form-control" placeholder="Manager Phone">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="">Store Address</label>
                                                                    <textarea name="store_address" class="form-control" placeholder="Enter address"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <h4 class="card-title mb-4">Account Credentials</h4>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="username">Username <span class="text-danger">*</span></label>
                                                                    <input type="text" name="username" onkeyup="validate_username(this.value)" class="form-control" placeholder="Enter username">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="">Password <span class="text-danger">*</span></label>
                                                                    <input type="text" name="password" class="form-control" placeholder="Enter password">
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
                                            </div>
                                            <div class="tab-pane" id="show_list_datatable" role="tabpanel">
                                                <table id="datatable-buttons" class="table table-bordered">
                                                    <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Store Name</th>
                                                        <th>Address</th>
                                                        <th>Manager Name</th>
                                                        <th>Manager Phone</th>
                                                        <th>Username</th>
                                                        <th>Password</th>
                                                        <th>Action</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            $st = 1;
                                                            foreach($all_stores as $list):
                                                        ?>
                                                        <tr>
                                                            <td><?=$st;?></td>
                                                            <td><?=$list->store;?></td>
                                                            <td><?=$list->store_address;?></td>
                                                            <td><?=$list->store_mng_name;?></td>
                                                            <td><?=$list->store_m_phone;?></td>
                                                            <td><?=$list->username;?></td>
                                                            <td><?=$list->password;?></td>
                                                            <td>
                                                                <div style="min-width:130px;">
                                                                    <a href="#" class="btn btn-info btn-sm br-0"><i class="fa fa-eye"></i></a>
                                                                    <a href="javascript:void(0);" onclick="edit_this('<?=encr($list->id);?>');" class="btn btn-primary btn-sm br-0"><i class="fa fa-edit"></i></a>
                                                                    <a href="javascript:void(0);" onclick="delete_this('<?=encr($list->id);?>');" class="btn btn-danger btn-sm br-0"><i class="fa fa-trash"></i></a>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <?php $st++; endforeach; ?>
                                                    </tbody>
                                                </table>
                                                <?=form_open('admin/stores/delete','method="get" name="delete_form"');?>
                                                <input type="hidden" name="encr_store_id">
                                                <?=form_close();?>
                                                <?=form_open('admin/stores/edit','method="get" name="edit_form"');?>
                                                <input type="hidden" name="edt_encr_store_id">
                                                <?=form_close();?>
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
                $("form[name='insert-form']").validate({
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
            function delete_this(encr_store_id){
                Swal.fire({
                  title: "Are you sure?",
                  text: "You won't be able to revert this!",
                  icon: "warning",
                  showCancelButton: true,
                  confirmButtonColor: "#34c38f",
                  cancelButtonColor: "#f46a6a",
                  confirmButtonText: "Yes, delete it!"
                }).then(function(result) {
                  if (result.isConfirmed) {
                    $('input[name="encr_store_id"]').val(encr_store_id);
                    $('form[name="delete_form"]').submit();
                  } else {
                    Swal.fire(
                          "Cancelled",
                          "Your file deletion has been cancelled.",
                          "info"
                        );
                  }
                });
            }
            function edit_this(encr_store_id){
                $('input[name="edt_encr_store_id"]').val(encr_store_id);
                $('form[name="edit_form"]').submit();
            }
            function validate_username(username){
                $.ajax({
                    type: 'GET',
                    url: BASE_URL+'admin/stores/validate-username',
                    data: {'username' : username},
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