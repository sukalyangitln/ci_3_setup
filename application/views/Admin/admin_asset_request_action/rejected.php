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
                                        <div class="row">
                                            <div class="col-md-12 table-responsive">
                                                <table id="datatable-buttons" class="table table-bordered">
                                                    <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Reference Id</th>
                                                        <th>Request From</th>
                                                        <th>Product Info.</th>
                                                        <th>Qty</th>
                                                        <th>Additional Note</th>
                                                        <th>Admin Note</th>
                                                        <th>Current Status</th>
                                                        <th>Rejection Datetime</th>
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
                                                            <td><?=$list->ar_admin_remarks;?></td>
                                                            <td>
                                                                <?php
                                                                    if($list->ar_status == 'P'):
                                                                        echo '<span class="badge bg-warning">PROCESSING</span>';
                                                                    elseif($list->ar_status == 'R'):
                                                                        echo '<span class="badge bg-danger">REJECTED</span>';
                                                                    endif;
                                                                ?>
                                                            </td>
                                                            <td><?=$list->ar_admin_rejected_datetime;?></td>
                                                            <td>
                                                                <div style="min-width:170px;">
                                                                    <a href="javascript:void(0);" onclick="delete_this('<?=encr($list->ar_id);?>')" class="btn btn-danger btn-sm br-0"><i class="fa fa-close"></i> Delete?</a>
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
        <?php 
        $this->load->view('Admin/inc/script');
        ?>
        <script src="<?=base_url('assets/backend');?>/js/app.js"></script>
        <!-- Sweet Alerts js -->
        <script src="<?=base_url('assets/backend');?>/libs/sweetalert2/sweetalert2.min.js"></script>
        <!-- Sweet alert init js-->
        <script src="<?=base_url('assets/backend');?>/js/pages/sweet-alerts.init.js"></script>
        <script>
            function delete_this(encr_category_id){
                alert('Under development');
                // Swal.fire({
                //   title: "Are you sure?",
                //   text: "You won't be able to revert this!",
                //   icon: "warning",
                //   showCancelButton: true,
                //   confirmButtonColor: "#34c38f",
                //   cancelButtonColor: "#f46a6a",
                //   confirmButtonText: "Yes, delete it!"
                // }).then(function(result) {
                //   if (result.isConfirmed) {
                //     $('input[name="encr_category_id"]').val(encr_category_id);
                //     $('form[name="delete_form"]').submit();
                //   } else {
                //     Swal.fire(
                //           "Cancelled",
                //           "Your file deletion has been cancelled.",
                //           "info"
                //         );
                //   }
                // });
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