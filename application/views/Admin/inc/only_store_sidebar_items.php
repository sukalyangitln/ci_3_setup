<?php if(AUTH_USER_TYPE == 'STORE'): ?>
<li class="<?=(AdminMenuActive()['ul']=='request-for-asset')?'menu-active':''; ?>">
    <a href="<?=base_url('request-for-asset');?>" class="waves-effect text-dark">
        <img src="<?=base_url('assets/icons/dashboard.png');?>" alt="">
        <span key="" style="margin-left: 15px;">Request Asset</span>
    </a>
</li>
<li class="<?=(AdminMenuActive()['ul']=='store-asset-requests-approved')?'menu-active':''; ?>">
    <a href="<?=base_url('store/asset-requests/approved');?>" class="waves-effect text-dark">
        <img src="<?=base_url('assets/icons/dashboard.png');?>" alt="">
        <span key="" style="margin-left: 15px;">Approved Requests</span>
    </a>
</li>
<li class="<?=(AdminMenuActive()['ul']=='store-asset-requests-processing')?'menu-active':''; ?>">
    <a href="<?=base_url('store/asset-requests/processing');?>" class="waves-effect text-dark">
        <img src="<?=base_url('assets/icons/dashboard.png');?>" alt="">
        <span key="" style="margin-left: 15px;">Processing Requests</span>
    </a>
</li>
<li class="<?=(AdminMenuActive()['ul']=='store-asset-requests-rejected')?'menu-active':''; ?>">
    <a href="<?=base_url('store/asset-requests/rejected');?>" class="waves-effect text-dark">
        <img src="<?=base_url('assets/icons/dashboard.png');?>" alt="">
        <span key="" style="margin-left: 15px;">Rejected Requests</span>
    </a>
</li>
<?php endif; ?>