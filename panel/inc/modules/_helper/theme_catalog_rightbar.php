<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<!-- Left Bar !-->
<div class="col-md-3 d-none d-md-inline-block ">
    <div class="list-group ">
    <a href="pages.php?page=theme_product_box" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'productbox'  ) { ?>active<?php }?>"><?=$diller['adminpanel-text-288']?></a>
    <a href="pages.php?page=theme_product_detail" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'productdetail'  ) { ?>active<?php }?>"><?=$diller['adminpanel-text-290']?></a>
    <a href="pages.php?page=theme_cat_detail" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'catdetail'  ) { ?>active<?php }?>"><?=$diller['adminpanel-text-292']?></a>
    <a href="pages.php?page=theme_brand" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'brand'  ) { ?>active<?php }?>"><?=$diller['adminpanel-text-309']?></a>
    <a href="pages.php?page=theme_tbox" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'tbox'  ) { ?>active<?php }?>"><?=$diller['adminpanel-text-296']?></a>
    <a href="pages.php?page=theme_showcase_tab" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'tab'  ) { ?>active<?php }?>"><?=$diller['adminpanel-text-298']?></a>
    <a href="pages.php?page=theme_showcase_bannerproduct" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'probanner'  ) { ?>active<?php }?>"><?=$diller['adminpanel-text-300']?></a>
    <a href="pages.php?page=theme_showcase_banner1" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'banner1'  ) { ?>active<?php }?>"><?=$diller['adminpanel-text-302']?></a>
    <a href="pages.php?page=theme_showcase_banner2" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'banner2'  ) { ?>active<?php }?>"><?=$diller['adminpanel-text-304']?></a>
    <a href="pages.php?page=theme_showcase_countdown" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'countdown'  ) { ?>active<?php }?>"><?=$diller['adminpanel-text-306']?></a>
    </div>
</div>
<!--  <========SON=========>>> Left Bar SON !-->


<!-- Mobile !-->
<div class="col-md-3 d-md-none d-sm-inline-block ">
    <a class="btn btn-pink mo-mb-2 btn-block d-flex align-items-center justify-content-between" data-toggle="collapse" href="#assadasdasd" aria-expanded="false" aria-controls="collapseExample">
        <?=$diller['adminpanel-menu-text-103']?> <i class="fa fa-plus"></i>
    </a>
    <div class="collapse" id="assadasdasd">
        <a href="pages.php?page=theme_product_box" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'productbox'  ) { ?>active<?php }?>"><?=$diller['adminpanel-text-288']?></a>
        <a href="pages.php?page=theme_product_detail" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'productdetail'  ) { ?>active<?php }?>"><?=$diller['adminpanel-text-290']?></a>
        <a href="pages.php?page=theme_cat_detail" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'catdetail'  ) { ?>active<?php }?>"><?=$diller['adminpanel-text-292']?></a>
        <a href="pages.php?page=theme_brand" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'brand'  ) { ?>active<?php }?>"><?=$diller['adminpanel-text-309']?></a>
        <a href="pages.php?page=theme_tbox" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'tbox'  ) { ?>active<?php }?>"><?=$diller['adminpanel-text-296']?></a>
        <a href="pages.php?page=theme_showcase_tab" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'tab'  ) { ?>active<?php }?>"><?=$diller['adminpanel-text-298']?></a>
        <a href="pages.php?page=theme_showcase_bannerproduct" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'probanner'  ) { ?>active<?php }?>"><?=$diller['adminpanel-text-300']?></a>
        <a href="pages.php?page=theme_showcase_banner1" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'banner1'  ) { ?>active<?php }?>"><?=$diller['adminpanel-text-302']?></a>
        <a href="pages.php?page=theme_showcase_banner2" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'banner2'  ) { ?>active<?php }?>"><?=$diller['adminpanel-text-304']?></a>
        <a href="pages.php?page=theme_showcase_countdown" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'countdown'  ) { ?>active<?php }?>"><?=$diller['adminpanel-text-306']?></a>
    </div>
</div>
<!--  <========SON=========>>> Mobile SON !-->