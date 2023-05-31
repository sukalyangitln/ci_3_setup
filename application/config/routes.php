<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
*/
$route['default_controller'] = 'AdminBeforeAuth';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

/*
| -------------------------------------------------------------------------
| ADMIN ROUTING LOGIN
| -------------------------------------------------------------------------
*/
$route['admin-test']['GET'] = 'TestController';
$route['admin-login']['POST'] = 'AdminBeforeAuth/login';
$route['admin-dashboard']['GET'] = 'AdminDashboardController';
$route['admin-logout']['GET'] = 'AdminDashboardController/logout';
$route['admin-profile']['GET'] = 'Profile_Controller';
$route['admin-profile']['POST'] = 'Profile_Controller/Profile_Save';
$route['admin-change-password']['POST'] = 'Profile_Controller/Change_Password_Save';
/*
| -------------------------------------------------------------------------
| ADMIN SETTINGS 
| -------------------------------------------------------------------------
*/
$route['admin-company-profile']['GET'] = 'settings/Admin_Settings/Company_Profile';
$route['admin-company-profile']['POST'] = 'settings/Admin_Settings/CompanyProfileSave';
/*
| -------------------------------------------------------------------------
| ADMIN STORE CRUD 
| -------------------------------------------------------------------------
*/
$route['admin/stores']['GET'] = 'Admin_StoreCrud';
$route['admin/stores/add']['POST'] = 'Admin_StoreCrud/store';
$route['admin/stores/validate-username']['GET'] = 'Admin_StoreCrud/validate_username';
$route['admin/stores/delete']['GET'] = 'Admin_StoreCrud/delete';
$route['admin/stores/edit']['GET'] = 'Admin_StoreCrud/edit';
$route['admin/stores/update']['POST'] = 'Admin_StoreCrud/update';
$route['admin/stores/validate-username-update-time']['GET'] = 'Admin_StoreCrud/validate_username_update_time';

/*
| -------------------------------------------------------------------------
| ADMIN CATEGORY CRUD 
| -------------------------------------------------------------------------
*/
$route['admin/categories']['GET'] = 'Admin_CategoryCrud';
$route['admin/categories/add']['POST'] = 'Admin_CategoryCrud/store';
$route['admin/categories/delete']['GET'] = 'Admin_CategoryCrud/delete';
$route['admin/categories/edit']['GET'] = 'Admin_CategoryCrud/edit';
$route['admin/categories/update']['POST'] = 'Admin_CategoryCrud/update';
/*
| -------------------------------------------------------------------------
| ADMIN LIVE RESULTS (setInterval)
| -------------------------------------------------------------------------
*/
$route['admin/product/get-live-stock']['GET'] = 'Admin_ProductCrud/get_live_stock'; //hitting by setInterval function from application/views/Admin/product_details.php
$route['admin/dashboard-live-counts']['GET'] = 'Admin_setInterval_Controller/get_dashboard_live_counts'; //hitting by setInterval function from application/views/Admin/dashboard.php
/*
| -------------------------------------------------------------------------
| ADMIN SUB CATEGORY CRUD 
| -------------------------------------------------------------------------
*/
$route['admin/sub-categories']['GET'] = 'Admin_SubCategoryCrud';
$route['admin/sub-categories/add']['POST'] = 'Admin_SubCategoryCrud/store';
$route['admin/sub-categories/delete']['GET'] = 'Admin_SubCategoryCrud/delete';
$route['admin/sub-categories/edit']['GET'] = 'Admin_SubCategoryCrud/edit';
$route['admin/sub-categories/update']['POST'] = 'Admin_SubCategoryCrud/update';

/*
| -------------------------------------------------------------------------
| ADMIN PRODUCT CRUD 
| -------------------------------------------------------------------------
*/
$route['admin/product/add']['GET'] = 'Admin_ProductCrud';
$route['admin/product/add']['POST'] = 'Admin_ProductCrud/store';
$route['admin/product/add-qty']['POST'] = 'Admin_ProductCrud/store_more_qty';
$route['admin/product/fetch-sub-category']['GET'] = 'Admin_ProductCrud/fetch_sub_category';
$route['admin/product/list']['GET'] = 'Admin_ProductCrud/show_list';
$route['admin/product/serverside-list']['POST'] = 'Admin_ProductCrud/ajax_show_list';
$route['admin/product/view-details']['GET'] = 'Admin_ProductCrud/show_product_details';
 
/*
| -------------------------------------------------------------------------
| ASSET REQUEST ROUTES FOR ADMIN
| -------------------------------------------------------------------------
*/
// VIEW LIST
$route['admin/asset-requests/processing']['GET'] = 'Admin_Asset_Request_Action_Controller/processing_requests';
$route['admin/asset-requests/approved']['GET'] = 'Admin_Asset_Request_Action_Controller/approved_requests';
$route['admin/asset-requests/rejected']['GET'] = 'Admin_Asset_Request_Action_Controller/rejected_requests';
// TAKE ACTION
$route['admin/asset-requests/reject-a-request']['GET'] = 'Admin_Asset_Request_Action_Controller/make_rejection';
$route['admin/asset-requests/approve-a-request']['POST'] = 'Admin_Asset_Request_Action_Controller/make_approve';
$route['admin/asset-requests/get-data-before-approving-the-request']['GET'] = 'Admin_Asset_Request_Action_Controller/get_data_before_approving_the_request';
$route['admin/asset-requests/delete-rejected-request']['GET'] = 'Admin_Asset_Request_Action_Controller/delete_rejected_request';
/*
| -------------------------------------------------------------------------
| ADMIN ASSET MOVEMENT LOGS 
| -------------------------------------------------------------------------
*/
$route['admin/asset-movement-logs']['GET'] = 'Admin_AssetMovement_logs';
$route['admin/asset-movement-logs/serverside-list']['POST'] = 'Admin_AssetMovement_logs/serverside_list';
$route['admin/date-wise-asset-movement-logs/show-form']['GET'] = 'Admin_AssetMovement_logs/datewise_form_show';
$route['admin/procurement-logs']['GET'] = 'Admin_AssetMovement_logs/datewise_procurement_logs';
/*
| -------------------------------------------------------------------------
| Unauthorise access detecting 
| -------------------------------------------------------------------------
*/
$route['unauthorise-access-detected']['GET'] = 'Web_Application_Maintainance_Controller/unauthorised_access';
/*
| -------------------------------------------------------------------------
| ASSET REQUEST ROUTES FOR STORES
| -------------------------------------------------------------------------
*/
$route['request-for-asset']['GET'] = 'Asset_Request_Controller';
$route['request-for-asset']['POST'] = 'Asset_Request_Controller/store_request';
$route['request-for-asset/get-sub-category-by-main-category-id']['GET'] = 'Asset_Request_Controller/get_sub_category_by_main_category_id';
$route['request-for-asset/get-assets-by-sub-category']['GET'] = 'Asset_Request_Controller/get_assets_by_sub_category';
$route['store/asset-requests/approved']['GET'] = 'Asset_Request_Controller/approved_requests';
$route['store/asset-requests/processing']['GET'] = 'Asset_Request_Controller/processing_requests';
$route['store/asset-requests/rejected']['GET'] = 'Asset_Request_Controller/rejected_requests';
//Edit QTY and request cancellation
$route['store/asset-requests/check-before-proceeding']['GET'] = 'Asset_Request_Controller/check_before_proceeding';
$route['store/asset-requests/make-request-cancellation']['GET'] = 'Asset_Request_Controller/make_request_cancellation';
$route['store/asset-requests/update-quantity']['POST'] = 'Asset_Request_Controller/update_quantity';
$route['store/asset-movement-logs']['GET'] = 'Asset_Request_Controller/view_asset_movement_log_form';
$route['store/procurement-logs']['GET'] = 'Asset_Request_Controller/fetch_asset_movement_log';

