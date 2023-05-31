<?php if(AUTH_USER_TYPE == 'ADMIN'): ?>
<li class="<?=(AdminMenuActive()['ul']=='admin-stores')?'menu-active':''; ?>">
    <a href="<?=base_url('admin/stores');?>" class="waves-effect text-dark">
        <img src="<?=base_url('assets/icons/store.png');?>" alt="">
        <span class="badge rounded-pill bg-info float-end"><?=get_nos_of_stores();?></span>
        <span key="" style="margin-left: 15px;">Stores</span>
    </a>
</li>
<li class="<?=(AdminMenuActive()['ul']=='admin-categories')?'menu-active':''; ?>">
    <a href="<?=base_url('admin/categories');?>" class="waves-effect text-dark">
        <img src="<?=base_url('assets/icons/categories.png');?>" alt="">
        <span class="badge rounded-pill bg-info float-end"><?=get_nos_of_categories();?></span>
        <span key="" style="margin-left: 15px;">Categories</span>
    </a>
</li>
<li class="<?=(AdminMenuActive()['ul']=='admin-sub-categories')?'menu-active':''; ?>">
    <a href="<?=base_url('admin/sub-categories');?>" class="waves-effect text-dark">
        <img src="<?=base_url('assets/icons/folder.png');?>" alt="">
        <span class="badge rounded-pill bg-info float-end"><?=get_nos_of_subcategories();?></span>
        <span key="" style="margin-left: 15px;">Sub Categories</span>
    </a>
</li>
<li class="">
    <a href="javascript: void(0);" class="has-arrow waves-effect text-dark <?=(AdminMenuActive()['ul']=='admin-asset-movement-logs')?'menu-active':''; ?>" aria-expanded="false">
        <img src="<?=base_url('assets/icons/cubes.png');?>" alt="">
        <span key="" style="margin-left: 15px;">Logs</span>
    </a>
    <ul class="sub-menu mm-collapse" aria-expanded="false" >
        <li><a href="<?=base_url('admin/asset-movement-logs');?>" >All</a></li>
        <li><a href="<?=base_url('admin/date-wise-asset-movement-logs/show-form');?>" >Date Wise</a></li>
    </ul>
</li>
<li class="">
    <a href="javascript: void(0);" class="has-arrow waves-effect text-dark <?=(AdminMenuActive()['ul']=='admin-product-add')?'menu-active':''; ?>" aria-expanded="false">
        <img src="<?=base_url('assets/icons/cubes.png');?>" alt="">
        <span key="" style="margin-left: 15px;">Products</span>
    </a>
    <ul class="sub-menu mm-collapse" aria-expanded="false" >
        <li><a href="<?=base_url('admin/product/add');?>" >Add Product</a></li>
        <li><a href="<?=base_url('admin/product/list');?>" >Product List <span class="badge rounded-pill bg-info float-end"><?=get_nos_of_products();?></span></a></li>
    </ul>
</li>
<li class="">
    <a href="javascript: void(0);" class="has-arrow waves-effect text-dark <?=(AdminMenuActive()['ul']=='admin-asset-requests')?'menu-active':''; ?>" aria-expanded="false">
        <img src="<?=base_url('assets/icons/cubes.png');?>" alt="">
        <span key="" style="margin-left: 15px;">Asset Requests</span>
    </a>
    <ul class="sub-menu mm-collapse" aria-expanded="false" >
        <li><a href="<?=base_url('admin/asset-requests/processing');?>">Processing <span class="badge rounded-pill bg-warning float-end"><?=get_nos_of_pending_requests();?></span></a> </li>
        <li><a href="<?=base_url('admin/asset-requests/approved');?>">Approved <span class="badge rounded-pill bg-success float-end"><?=get_nos_of_approved_requests();?></span></a></li>
        <li><a href="<?=base_url('admin/asset-requests/rejected');?>">Rejected <span class="badge rounded-pill bg-danger float-end"><?=get_nos_of_rejected_request();?></span></a></li>
    </ul>
</li>
<li class="<?=(AdminMenuActive()['ul']=='admin-company-profile')?'menu-active':''; ?>">
    <a href="<?=base_url('admin-company-profile');?>" class="waves-effect text-dark">
        <img src="<?=base_url('assets/icons/folder.png');?>" alt="">
        <span key="" style="margin-left: 15px;">Company Profile</span>
    </a>
</li>
<!-- <li class="<?=(AdminMenuActive()['ul']=='admin-asset-requests-processing')?'menu-active':''; ?>">
    <a href="<?=base_url('admin/asset-requests/processing');?>" class="waves-effect text-dark">
        <img src="<?=base_url('assets/icons/folder.png');?>" alt="">
        <span key="" style="margin-left: 15px;">Processing Asset Request</span>
    </a>
</li>
<li class="<?=(AdminMenuActive()['ul']=='admin-asset-requests-approved')?'menu-active':''; ?>">
    <a href="<?=base_url('admin/asset-requests/approved');?>" class="waves-effect text-dark">
        <img src="<?=base_url('assets/icons/folder.png');?>" alt="">
        <span key="" style="margin-left: 15px;">Processing Asset Request</span>
    </a>
</li>
<li class="<?=(AdminMenuActive()['ul']=='admin-asset-requests-rejected')?'menu-active':''; ?>">
    <a href="<?=base_url('admin/asset-requests/rejected');?>" class="waves-effect text-dark">
        <img src="<?=base_url('assets/icons/folder.png');?>" alt="">
        <span key="" style="margin-left: 15px;">Processing Asset Request</span>
    </a>
</li> -->
<?php endif; ?>