<!doctype html>
<html lang="en">
    <?php
    $this->load->view('Admin/inc/stylesheet');
    ?>
    <link href="<?=base_url('assets/backend');?>/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
    <link href="<?=base_url('assets/backend');?>/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
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
                                                    <span class="d-none d-sm-block"><i class="fa fa-users"></i> Sub Category List</span> 
                                                </a>
                                            </li>
                                        </ul>
                                        <!-- Tab panes -->
                                        <div class="tab-content p-3 text-muted">
                                            <div class="tab-pane active" id="add_form" role="tabpanel">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <?=form_open('admin/sub-categories/add','name="insert-form" method="post"');?>
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
                                                                        <option value="<?=$cat_list->cid;?>"><?=$cat_list->cname;?></option>
                                                                        <?php endforeach; ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="">Sub Category Name <span class="text-danger">*</span></label>
                                                                    <input type="text" name="scname" class="form-control" placeholder="Enter sub category name">
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
                                                <?php //dd($all_list); ?>
                                                <table id="datatable-buttons" class="table table-bordered">
                                                    <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Sub Category</th>
                                                        <th>Main Category</th>
                                                        <th>Action</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            $st = 1;
                                                            foreach($all_list as $list):
                                                        ?>
                                                        <tr>
                                                            <td><?=$st;?></td>
                                                            <td><?=$list->scname;?></td>
                                                            <td><?=$list->cname;?></td>                                                            
                                                            <td>
                                                                <div style="min-width:130px;">
                                                                    <a href="#" class="btn btn-info btn-sm br-0"><i class="fa fa-eye"></i></a>
                                                                    <a href="javascript:void(0);" onclick="edit_this('<?=encr($list->scid);?>');" class="btn btn-primary btn-sm br-0"><i class="fa fa-edit"></i></a>
                                                                    <a href="javascript:void(0);" onclick="delete_this('<?=encr($list->scid);?>');" class="btn btn-danger btn-sm br-0"><i class="fa fa-trash"></i></a>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <?php $st++; endforeach; ?>
                                                    </tbody>
                                                </table>
                                                <?=form_open('admin/sub-categories/delete','method="get" name="delete_form"');?>
                                                <input type="hidden" name="encr_sub_category_id">
                                                <?=form_close();?>
                                                <?=form_open('admin/sub-categories/edit','method="get" name="edit_form"');?>
                                                <input type="hidden" name="edt_encr_sub_category_id">
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
        <script src="<?=base_url('assets/backend');?>/libs/select2/js/select2.min.js"></script>
        <script>
            $(document).ready(function() {
              $('.select2').select2();
            });
             $(function() {
                $("form[name='insert-form']").validate({
                  rules: {
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
            function delete_this(encr_sub_category_id){
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
                    $('input[name="encr_sub_category_id"]').val(encr_sub_category_id);
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
            function edit_this(encr_sub_category_id){
                $('input[name="edt_encr_sub_category_id"]').val(encr_sub_category_id);
                $('form[name="edit_form"]').submit();
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