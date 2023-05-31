<!doctype html>
<html lang="en">
    <?php
    $this->load->view('Admin/inc/stylesheet');
    ?>
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
                        <?php if(AUTH_USER_TYPE == 'ADMIN'): ?>
                            <div class="row">
                            <div class="col-md-3">
                                <div class="card mini-stats-wid border border-primary " style="box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); cursor: pointer;" onclick="view_stores()">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-muted fw-medium">Total Store</p>
                                                <h4 class="mb-0" id="Total_Store"></h4>
                                            </div>

                                            <div class="flex-shrink-0 align-self-center">
                                                <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                                    <span class="avatar-title">
                                                        <i class="fas fa-store"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card mini-stats-wid border border-primary " style="box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); cursor: pointer;" onclick="view_product_master()">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-muted fw-medium">Total Product</p>
                                                <h4 class="mb-0" id="Total_Product"></h4>
                                            </div>

                                            <div class="flex-shrink-0 align-self-center">
                                                <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                                    <span class="avatar-title">
                                                        <i class="fa fa-list-ul"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card mini-stats-wid border border-primary " style="box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); cursor: pointer;" onclick="view_approved_asset_requests()">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-muted fw-medium">Approved Requests</p>
                                                <h4 class="mb-0" id="Total_Approved_Requests"></h4>
                                            </div>

                                            <div class="flex-shrink-0 align-self-center">
                                                <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                                    <span class="avatar-title">
                                                        <i class="fa fa-list-ul"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card mini-stats-wid border border-primary " style="box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); cursor: pointer;" onclick="view_pending_asset_requests()">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-muted fw-medium">Pending Requests</p>
                                                <h4 class="mb-0" id="Total_Pending_Requests"></h4>
                                            </div>

                                            <div class="flex-shrink-0 align-self-center">
                                                <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                                    <span class="avatar-title">
                                                        <i class="fa fa-list-ul"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->
                        <div class="row">
                            <div class="col-md-3">
                                <div class="card mini-stats-wid border border-primary " style="box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); cursor: pointer;" onclick="view_rejected_asset_requests()">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-muted fw-medium">Rejected Requests</p>
                                                <h4 class="mb-0" id="Total_Rejected_Requests"></h4>
                                            </div>

                                            <div class="flex-shrink-0 align-self-center">
                                                <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                                    <span class="avatar-title">
                                                        <i class="fa fa-list-ul"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->
                        <?php endif; ?>
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
        <?php if(AUTH_USER_TYPE == 'ADMIN'): ?>
            <script>
                function live_counts() {
                    $.ajax({
                        type: 'get',
                        url: BASE_URL+'admin/dashboard-live-counts',
                        dataType: 'json',
                        success: function(result){
                            $('#Total_Store').text(result.Total_Store);
                            $('#Total_Product').text(result.Total_Product);
                            $('#Total_Approved_Requests').text(result.Total_Approved_Requests);
                            $('#Total_Pending_Requests').text(result.Total_Pending_Requests);
                            $('#Total_Rejected_Requests').text(result.Total_Rejected_Requests);
                        }
                    });
                    setTimeout(live_counts, 2000); // 2000 milliseconds = 2 seconds
                }
                // Start the timeout function
                live_counts();
                function view_stores(){
                    window.location.href=BASE_URL+'admin/stores';
                }
                function view_product_master(){
                    window.location.href=BASE_URL+'admin/product/list';
                }
                function view_approved_asset_requests(){
                    window.location.href=BASE_URL+'admin/asset-requests/approved';
                }
                function view_pending_asset_requests(){
                    window.location.href=BASE_URL+'admin/asset-requests/processing';
                }
                function view_rejected_asset_requests(){
                    window.location.href=BASE_URL+'admin/asset-requests/rejected';
                }
            </script>
        <?php endif; ?>
        
    </body>
</html>