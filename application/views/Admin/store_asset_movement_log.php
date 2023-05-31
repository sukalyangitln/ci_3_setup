<!doctype html>
<html lang="en">
    <head>        
        <meta charset="utf-8" />
        <title><?=$PageTitle;?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Looking to rent a car? Visit CarRental.com and book your rental car today! We offer a wide range of vehicles at competitive prices. Whether you're traveling for business or pleasure, our easy-to-use website makes booking a car rental simple and hassle-free. Book now and hit the road with CarRental.com." name="description" />
        <meta content="Themesbrand" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="http://localhost/asset_tracking/assets/uploads/dynamic_page/company_profile/xt8ik4u4q7d5nydhhyj61.png">
        <!-- Bootstrap Css -->
        <link href="<?=base_url('assets/backend');?>/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="<?=base_url('assets/backend');?>/css/icons.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="<?=base_url('assets/backend');?>/css/app.min.css?sdhfisdh=20230529150408" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="<?=base_url('assets/backend');?>/css/custom.css?id=030408" rel="stylesheet" type="text/css" />
        <!-- DataTables -->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.bootstrap5.min.css">
        <link rel="stylesheet" type="text/css" href="<?=base_url('assets/backend');?>/libs/toastr/build/toastr.min.css">
        <style>
           .vertical-menu{
            background-color: #ffffff !important;
            color: green !important;
           }
           .no-hover:hover {
             color: inherit;
             background-color: inherit;
             /* Add any other properties that may be affected by the hover effect */
           }
           .menu-active{
            background-color: #cdd5f9 !important;
           }
           .image-clickable {
             transition: transform 0.2s;
           }
           .img-thumb{
               height: 272px;
               width: 262px;
           }
           .disabled-field {
             background-color: #f2f2f2;
             color: #777;
           }
           .thmb-image {
               width: 100%;
               border: 1px solid #2a3042;
               cursor: pointer;
               height: 200px;
           }
        </style>
    </head>
    <script type="text/javascript">
        const BASE_URL='<?=BASE_URL;?>';
    </script>
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
                                        <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="example" class="table table-bordered table-sm">
                                                <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Date</th>
                                                    <th>Notification</th>
                                                    <th>Type</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $mt = 1;
                                                        foreach($MovementData as $timelineData):
                                                    ?>
                                                    <tr>
                                                        <td><?=$mt++?></td>
                                                        <td><?=$timelineData->amt_dateTime;?></td>
                                                        <td><?=$timelineData->amt_log_paragraph;?></td>
                                                        <td><?=$timelineData->amt_type;?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                                </tbody>
                                            </table>
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
        <div id="QR_view_modal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="myModalLabel">QR Code</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <img src="" class="img-fluid" id="qr_view">
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <div id="pdfviewmodal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="myModalLabel">Invoice Preview</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="Height: 350px;">
                        <div id="pdfViewer" style="Height: 300px;"></div>
                        <div id="imagepreview" style="Height: 300px;">
                            <img src="" class="thmb-image" id="thummb_image" alt="">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close preview</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <script src="<?=base_url('assets/backend');?>/libs/jquery/jquery.min.js"></script>
        <script src="<?=base_url('assets/backend');?>/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="<?=base_url('assets/backend');?>/libs/metismenu/metisMenu.min.js"></script>
        <script src="<?=base_url('assets/backend');?>/libs/simplebar/simplebar.min.js"></script>
        <script src="<?=base_url('assets/backend');?>/libs/node-waves/waves.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>

        <!-- Required datatable js -->

        <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.bootstrap5.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.colVis.min.js"></script>

        <!-- Datatable init js -->
        <script src="<?=base_url('assets/backend');?>/libs/toastr/build/toastr.min.js"></script>
        <script src="<?=base_url('assets/backend');?>/js/app.js"></script>
        <!-- Sweet Alerts js -->
        <script src="<?=base_url('assets/backend');?>/libs/sweetalert2/sweetalert2.min.js"></script>
        <!-- Sweet alert init js-->
        <script src="<?=base_url('assets/backend');?>/js/pages/sweet-alerts.init.js"></script>
        <script>
            $(document).ready(function() {
              var table1 = $('#example').DataTable({
                lengthChange: false,
                buttons: ['copy', 'excel', 'pdf', 'colvis']
              });
              table1.buttons().container().appendTo('#example_wrapper .col-md-6:eq(0)');

              var table2 = $('#example_two').DataTable({
                lengthChange: false,
                buttons: ['copy', 'excel', 'pdf', 'colvis']
              });
              table2.buttons().container().appendTo('#example_two_wrapper .col-md-6:eq(0)');
              
            });
        </script>
    </body>
</html>