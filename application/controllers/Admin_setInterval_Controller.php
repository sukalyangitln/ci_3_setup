<?php
    class Admin_setInterval_Controller extends AD_Controller{
        function __construct(){
            parent::__construct();
            if(AUTH_USER_TYPE != 'ADMIN'):
                redirect('unauthorise-access-detected');
            endif;
        }
        public function get_dashboard_live_counts(){
            $Total_Store = get_nos_of_stores();
            $Total_Product = get_nos_of_products();
            $Total_Approved_Requests = get_nos_of_approved_requests();
            $Total_Pending_Requests = get_nos_of_pending_requests();
            $Total_Rejected_Requests = get_nos_of_rejected_request();
            $res = [
                'Total_Store' => $Total_Store,
                'Total_Product' => $Total_Product,
                'Total_Approved_Requests' => $Total_Approved_Requests,
                'Total_Pending_Requests' => $Total_Pending_Requests,
                'Total_Rejected_Requests' => $Total_Rejected_Requests,
            ];
            echo json_encode($res);
        }
    }
?>