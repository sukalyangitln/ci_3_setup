<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <div id="sidebar-menu">
            <ul class="metismenu list-unstyled text-uppercase" id="side-menu">
                <li class="menu-title text-dark" key="t-menu"><?=SITE_NAME;?></li>
                <li class="<?=(AdminMenuActive()['ul']=='admin-dashboard')?'menu-active':''; ?>">
                    <a href="<?=base_url('admin-dashboard');?>" class="waves-effect text-dark">
                        <img src="<?=base_url('assets/icons/dashboard.png');?>" alt="">
                        <span key="" style="margin-left: 15px;">Dashboard</span>
                    </a>
                </li>
                <!-- ONLY FOR ADMIN SIDEBAR MENU ITEMS START -->
                    <?php $this->load->view('Admin/inc/only_admin_sidebar_items'); ?>
                <!-- ONLY FOR ADMIN SIDEBAR MENU ITEMS END -->
                
                <!-- ONLY FOR STORES SIDEBAR MENU ITEMS START -->
                    <?php $this->load->view('Admin/inc/only_store_sidebar_items'); ?>
                <!-- ONLY FOR STORES SIDEBAR MENU ITEMS END -->
            </ul>
        </div>
    </div>
</div>