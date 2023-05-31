<!doctype html>
<html lang="en">
    <?php
    $this->load->view('Admin/inc/stylesheet');
    ?>
    <link href="<?=base_url('assets/backend');?>/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
    <link href="<?=base_url('assets/backend');?>/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="<?=base_url('assets/backend');?>/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css">
    <style>
        .main-content{
            overflow: visible !important;
        }
    </style>
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
                                        <?=form_open('store/procurement-logs','autocomplete="off" name="asset-movement-timeline-fetch" method="get"');?>
                                            <div class="mb-4">
                                                <label>Date Range</label>
                                                <div class="input-daterange input-group" id="datepicker6" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
                                                    <input type="text" class="form-control" name="start" placeholder="Start Date" />
                                                    <input type="text" class="form-control" name="end" placeholder="End Date" />
                                                </div>
                                            </div>
                                            <div class="mb-4">
                                                <button type="submit" class="btn btn-primary"> <i class="fa fa-eye"></i> View Logs</button>
                                            </div>
                                        <?=form_close();?>
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
        <script src="<?=base_url('assets/backend');?>/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
        <script src="<?=base_url('assets/backend');?>/js/pages/form-advanced.init.js"></script>
        <script>
            $(function() {
                $("form[name='asset-movement-timeline-fetch']").validate({
                  rules: {
                    start: {
                      required: true,
                      date: true,
                    },
                    end: {
                      required: true,
                      date: true,
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
    </body>
</html>