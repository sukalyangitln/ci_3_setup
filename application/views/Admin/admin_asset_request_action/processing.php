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
                                        <div class="row">
                                            <div class="col-md-12 table-responsive">
                                                <?php //dd($requestData); ?>
                                                <table id="datatable-buttons" class="table table-bordered">
                                                    <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Reference Id</th>
                                                        <th>Request From</th>
                                                        <th>Product Info.</th>
                                                        <th>Qty</th>
                                                        <th>Additional Note</th>
                                                        <th>Current Status</th>
                                                        <th>Date Time</th>
                                                        <th>Action</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            $st = 1;
                                                            foreach($requestData as $list):
                                                        ?>
                                                        <tr>
                                                            <td><?=$st;?></td>
                                                            <td><strong><span class="badge bg-dark"><?=$list->ar_serial_number;?></span></strong></td>
                                                            <td><?=$list->Store_Name;?></td>
                                                            <td><?=$list->pigi_product_name;?></td>
                                                            <td><?=$list->ar_requested_qty;?></td>
                                                            <td><?=$list->ar_remarks;?></td>
                                                            <td>
                                                                <?php
                                                                    if($list->ar_status == 'P'):
                                                                        echo '<span class="badge bg-warning">PROCESSING</span>';
                                                                    elseif($list->ar_status == 'R'):
                                                                        echo '<span class="badge bg-danger">REJECTED</span>';
                                                                    endif;
                                                                ?>
                                                            </td>
                                                            <td><?=$list->ar_requested_datetime;?></td>
                                                            <td>
                                                                <div style="min-width:170px;">
                                                                    <a href="javascript:void(0);" onclick="reject_asset_request('<?=encr($list->ar_id);?>')" class="btn btn-danger btn-sm br-0"><i class="fa fa-close"></i> Reject?</a>
                                                                    <a href="javascript:void(0);" onclick="approve_asset_request('<?=encr($list->ar_id);?>')" class="btn btn-primary btn-sm br-0"><i class="fa fa-edit"></i> Approve?</a>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <?php $st++; endforeach; ?>
                                                    </tbody>
                                                </table>
                                                <?=form_open('admin/asset-requests/reject-a-request','name="reject_form" method="get"');?>
                                                <input type="hidden" name="reject_encr_ar_id">
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
        <!-- sample modal content -->
        <div id="request_approve_action" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="myModalLabel">Approve asset request?</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div id="msg_before_approve"></div>
                            </div>
                        </div>
                        <?=form_open('admin/asset-requests/approve-a-request','name="aprove_asset_request" method="post"');?>
                        <input type="hidden" name="approve_encr_ar_id">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Asset in stock</label>
                                    <input type="number" name="asset_in_stock" class="form-control" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Requested Qty</label>
                                    <input type="number" name="actual_requested_qty" class="form-control" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Releasing Qty</label>
                                    <input type="number" name="releasing_qty" class="form-control" placeholder="Enter the quantity you want-to-release.">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Remarks</label>
                                    <textarea name="remarks" class="form-control" placeholder="Enter remarks if any..."></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light btn-block">Approve the request</button>
                                </div>
                            </div>
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
            function reject_asset_request(encr_ar_id){
                Swal.fire({
                  title: "Are you sure to reject?",
                  text: "If you reject this asset request, you will not be able to accept or approve this particular request in the future.",
                  icon: "warning",
                  showCancelButton: true,
                  confirmButtonColor: "#34c38f",
                  cancelButtonColor: "#f46a6a",
                  confirmButtonText: "Yes, Reject it!"
                }).then(function(result) {
                  if (result.isConfirmed) {
                    $('input[name="reject_encr_ar_id"]').val(encr_ar_id);
                    $('form[name="reject_form"]').submit();
                  } else {
                    Swal.fire(
                          "Cancelled",
                          "Your asset request cancellation has been revoked.",
                          "info"
                        );
                  }
                });
            }
            function approve_asset_request(encr_ar_id){
                $('#ajax-loader').append("<div class='page-loader-overlay'></div><div class='page-loader'></div>");
                $.ajax({
                    type: 'GET',
                    url: BASE_URL+'admin/asset-requests/get-data-before-approving-the-request',
                    data: {'encr_ar_id' : encr_ar_id},
                    dataType: 'json',
                    success: function(result){
                        $('.page-loader-overlay, .page-loader').fadeOut(100, function() {
                            $(this).remove();
                        });
                        console.log(result);
                        $('#msg_before_approve').html(result.msg);
                        if(result.status == 1 || result.status == 2){
                            $('input[name="approve_encr_ar_id"]').val(result.encr_ar_id);
                            $('input[name="asset_in_stock"]').val(result.current_asset_stock);
                            $('input[name="actual_requested_qty"]').val(result.ar_requested_qty);
                            $('input[name="releasing_qty"]').val(result.ar_requested_qty);
                            setTimeout(function() {
                              $('input[name="releasing_qty"]').focus();
                            }, 500);
                        }
                        else{
                            
                            Swal.fire(
                                  "Invalid operation",
                                  "No data found!",
                                  "info"
                                );
                        }
                        $('#request_approve_action').modal('show');
                        
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
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