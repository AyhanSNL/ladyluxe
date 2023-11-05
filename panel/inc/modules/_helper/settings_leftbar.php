<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<!-- Left Bar !-->
<?php if($panelayar['panel_nav'] == '1' ) {?>
<div class="col-md-3 d-none d-md-inline-block ">
    <?php if($yetki['site_ayarlar'] == '1' &&  $yetki['ayar_yonet'] == '1'  ) {?>
        <a href="pages.php?page=settings" class="btn  w-100 mb-2 text-left p-3   <?php if($currentMenu == 'site_settings'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-152']?></a>
        <a href="pages.php?page=panel_settings" class="btn  w-100 mb-2 text-left p-3 <?php if($currentMenu == 'panel_settings'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-154']?></a>
    <?php }?>
    <?php if($yetki['site_ayarlar'] == '1' &&  $yetki['yonetici'] == '1'  ) {?>
        <a href="pages.php?page=admin_list" class="btn  w-100 mb-2 text-left p-3  <?php if($currentMenu == 'admin'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-156']?></a>
        <a href="pages.php?page=admin_permission" class="btn  w-100 mb-2 text-left p-3  <?php if($currentMenu == 'admin_per'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-158']?></a>
        <a href="pages.php?page=login_log" class="btn  w-100 mb-2 text-left p-3  <?php if($currentMenu == 'login_log'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-160']?></a>
    <?php }?>
    <?php if($yetki['site_ayarlar'] == '1' &&  $yetki['dil_yonet'] == '1'  ) {?>
        <a href="pages.php?page=languages" class="btn  w-100 mb-2 text-left p-3  <?php if($currentMenu == 'lang'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-162']?></a>
    <?php }?>
    <?php if($yetki['site_ayarlar'] == '1' &&  $yetki['ayar_diger'] == '1'  ) {?>
        <a href="pages.php?page=maintenance" class="btn  w-100 mb-2 text-left p-3  <?php if($currentMenu == 'bakim'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-164']?></a>
        <a href="pages.php?page=popup" class="btn  w-100 mb-2 text-left p-3  <?php if($currentMenu == 'popup'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-168']?></a>
        <a href="pages.php?page=code" class="btn  w-100 mb-2 text-left p-3  <?php if($currentMenu == 'code'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-170']?></a>
        <a href="pages.php?page=cache_settings" class="btn  w-100 mb-2 text-left p-3  <?php if($currentMenu == 'cache'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-172']?></a>
    <?php }?>
</div>
<?php } ?>
<!--  <========SON=========>>> Left Bar SON !-->


<!-- Mobile !-->
<div class="col-md-3 d-md-none d-sm-inline-block ">
    <a class="btn btn-pink mo-mb-2 btn-block d-flex align-items-center justify-content-between" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
        <?=$diller['adminpanel-text-269']?> <i class="fa fa-plus"></i>
    </a>
    <div class="collapse" id="collapseExample">
        <?php if($yetki['site_ayarlar'] == '1' &&  $yetki['ayar_yonet'] == '1'  ) {?>
            <a href="pages.php?page=settings" class="btn  w-100 mb-2 text-left p-3   <?php if($currentMenu == 'site_settings'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-152']?></a>
            <a href="pages.php?page=panel_settings" class="btn  w-100 mb-2 text-left p-3 <?php if($currentMenu == 'panel_settings'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-154']?></a>
        <?php }?>
        <?php if($yetki['site_ayarlar'] == '1' &&  $yetki['yonetici'] == '1'  ) {?>
            <a href="pages.php?page=admin_list" class="btn  w-100 mb-2 text-left p-3  <?php if($currentMenu == 'admin'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-156']?></a>
            <a href="pages.php?page=admin_permission" class="btn  w-100 mb-2 text-left p-3  <?php if($currentMenu == 'admin_per'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-158']?></a>
            <a href="pages.php?page=login_log" class="btn  w-100 mb-2 text-left p-3  <?php if($currentMenu == 'login_log'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-160']?></a>
        <?php }?>
        <?php if($yetki['site_ayarlar'] == '1' &&  $yetki['dil_yonet'] == '1'  ) {?>
            <a href="pages.php?page=languages" class="btn  w-100 mb-2 text-left p-3  <?php if($currentMenu == 'lang'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-162']?></a>
        <?php }?>
        <?php if($yetki['site_ayarlar'] == '1' &&  $yetki['ayar_diger'] == '1'  ) {?>
            <a href="pages.php?page=maintenance" class="btn  w-100 mb-2 text-left p-3  <?php if($currentMenu == 'bakim'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-164']?></a>
            <a href="pages.php?page=popup" class="btn  w-100 mb-2 text-left p-3  <?php if($currentMenu == 'popup'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-168']?></a>
            <a href="pages.php?page=code" class="btn  w-100 mb-2 text-left p-3  <?php if($currentMenu == 'code'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-170']?></a>
            <a href="pages.php?page=cache_settings" class="btn  w-100 mb-2 text-left p-3  <?php if($currentMenu == 'cache'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-172']?></a>
        <?php }?>
    </div>
</div>
<!--  <========SON=========>>> Mobile SON !-->