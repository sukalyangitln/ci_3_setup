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
                            <div class="col-12" id="ajax_response_message"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card border border-primary">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12 table-responsive">
                                                <table id="datatable-buttons" class="table table-bordered">
                                                    <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Reference Id</th>
                                                        <th>Product Info.</th>
                                                        <th>Qty</th>
                                                        <th>Additional Note</th>
                                                        <th>Current Status</th>
                                                        <th>Date Time</th>
                                                        <th>Cancel Request</th>
                                                        <th>Add QTY</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            $st = 1;
                                                            foreach($requestData as $list):
                                                        ?>
                                                        <tr>
                                                            <td><?=$st;?></td>
                                                            <td><?=$list->ar_serial_number;?></td>
                                                            <td><?=$list->pigi_product_name;?></td>
                                                            <td><?=$list->ar_requested_qty;?></td>
                                                            <td><?=$list->ar_remarks;?></td>
                                                            <td>
                                                                <?php
                                                                    if($list->ar_status == 'P'):
                                                                        echo 'PROCESSING';
                                                                    elseif($list->ar_status == 'R'):
                                                                        echo 'REJECTED';
                                                                    endif;
                                                                ?>
                                                            </td>
                                                            <td><?=$list->ar_requested_datetime;?></td>
                                                            <td><button onclick="cancel_asset_request('<?=encr($list->ar_id);?>')" class="btn btn-danger btn-sm"> <i class="fa fa-close"></i> Cancel Request</button></td>
                                                            <td><button onclick="edit_qty_form_open('<?=encr($list->ar_id);?>','<?=$list->ar_requested_qty;?>')" class="btn btn-info btn-sm"> <i class="fa fa-edit"></i> Edit Qty</button></td>
                                                        </tr>
                                                        <?php $st++; endforeach; ?>
                                                    </tbody>
                                                </table>
                                                <?=form_open('store/asset-requests/make-request-cancellation','name="request_cancel_form" method="get"');?>
                                                <input type="hidden" name="cancel_encr_ar_id">
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
        <div class="modal fade bs-example-modal-center" id="qty_edit_modal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <?=form_open('store/asset-requests/update-quantity','name="update_qty_form" method="post"');?>
                        <input type="hidden" name="edt_qty_encr_ar_id">
                            <div class="form-group">
                                <label for="">QTY <span class="text-danger">*</span> </label>
                                <input type="text" name="updated_qty" class="form-control" placeholder="Change your quantity..">
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary btn-block">Update</button>
                            </div>
                        <?=form_close();?>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
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
                $("form[name='update_qty_form']").validate({
                  rules: {
                    edt_qty_encr_ar_id: {
                      required: true,
                    },
                    updated_qty: {
                      required: true,
                      number: true,
                    },
                    
                  },
                  messages: {
                  },
                  submitHandler: function(form) {
                    form.submit();
                  }
                });
              });
                function edit_qty_form_open(edt_qty_encr_ar_id,ar_requested_qty) {
                    check_before_proceeding(edt_qty_encr_ar_id).then(function(response) {
                        if(response.status == 1){
                            $('#qty_edit_modal').on('shown.bs.modal', function () {
                                $('input[name="updated_qty"]').val(ar_requested_qty).focus();
                                $('input[name="edt_qty_encr_ar_id"]').val(edt_qty_encr_ar_id);
                            });
                            setTimeout(function() {
                                $('#qty_edit_modal').modal('show');
                            }, 200);
                        }
                        else{
                            $('#ajax_response_message').html(response.msg);
                        }
                    });
                }

                function check_before_proceeding(encr_ar_id) {
                    return new Promise(function(resolve, reject) {
                    $.ajax({
                        type: 'get',
                        url: BASE_URL + 'store/asset-requests/check-before-proceeding',
                        data: { 'encr_ar_id': encr_ar_id },
                        dataType: 'json',
                        success: function(result) {
                            resolve(result);
                        },
                        error: function(error) {
                            reject(error);
                        }
                    });
                });
                }

            function cancel_asset_request(cancel_encr_ar_id){
                Swal.fire({
                  title: "Are you sure?",
                  text: "You won't be able to revert this!",
                  icon: "warning",
                  showCancelButton: true,
                  confirmButtonColor: "#34c38f",
                  cancelButtonColor: "#f46a6a",
                  confirmButtonText: "Yes, cancel my request."
                }).then(function(result) {
                  if (result.isConfirmed) {
                    check_before_proceeding(edt_qty_encr_ar_id).then(function(response) {
                        // console.log(response);
                        if(response.status == 1){
                            $('input[name="cancel_encr_ar_id"]').val(cancel_encr_ar_id);
                            $('form[name="request_cancel_form"]').submit();
                        }
                        else{
                            $('#ajax_response_message').html(response.msg);
                        }
                    });
                    
                  } else {
                    Swal.fire(
                          "Cancelled",
                          "Your asset request cancellation has been cancelled.",
                          "info"
                        );
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