<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<div class="col-md-3  ">
    <a class="btn btn-pink mo-mb-2 btn-block  mb-3 pt-3 pb-3  d-flex align-items-center justify-content-between " data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
        <?=$diller['adminpanel-text-284']?> <i class="fa fa-plus"></i>
    </a>
    <div class="collapse mb-4 " id="collapseExample" style="max-height: 485px; overflow-y: scroll">
        <?php if($yetki['tema_ayarlar'] == '1') {?>
            <a href="pages.php?page=theme_header_settings" class="btn  w-100 mb-2 text-left p-3   <?php if($currentMenu == 'header'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-99']?></a>
            <a href="pages.php?page=theme_footer_settings" class="btn  w-100 mb-2 text-left p-3   <?php if($currentMenu == 'footer'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-101']?></a>
            <a href="pages.php?page=theme_mobil_settings" class="btn  w-100 mb-2 text-left p-3   <?php if($currentMenu == 'mobileheader'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-184']?></a>
            <a href="pages.php?page=theme_catalog_settings" class="btn  w-100 mb-2 text-left p-3   <?php if($currentMenu == 'catalog'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-103']?></a>
            <a href="pages.php?page=theme_users_settings" class="btn  w-100 mb-2 text-left p-3   <?php if($currentMenu == 'users'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-107']?></a>
            <a href="pages.php?page=fonts" class="btn  w-100 mb-2 text-left p-3   <?php if($currentMenu == 'fonts'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-109']?></a>
            <a href="pages.php?page=theme_banners" class="btn  w-100 mb-2 text-left p-3   <?php if($currentMenu == 'banners'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-111']?></a>
            <a href="pages.php?page=theme_mail" class="btn  w-100 mb-2 text-left p-3   <?php if($currentMenu == 'mail'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-113']?></a>
            <a href="pages.php?page=theme_cart" class="btn  w-100 mb-2 text-left p-3   <?php if($currentMenu == 'cart'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-115']?></a>
            <a href="pages.php?page=theme_compare" class="btn  w-100 mb-2 text-left p-3   <?php if($currentMenu == 'compare'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-119']?></a>
            <a href="pages.php?page=theme_contact" class="btn  w-100 mb-2 text-left p-3   <?php if($currentMenu == 'contact'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-121']?></a>
            <a href="pages.php?page=preloader" class="btn  w-100 mb-2 text-left p-3   <?php if($currentMenu == 'loader'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-123']?></a>
            <a href="pages.php?page=theme_slider" class="btn  w-100 mb-2 text-left p-3   <?php if($currentMenu == 'slider'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-125']?></a>
            <a href="pages.php?page=theme_story" class="btn  w-100 mb-2 text-left p-3   <?php if($currentMenu == 'story'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-127']?></a>
            <a href="pages.php?page=theme_modal" class="btn  w-100 mb-2 text-left p-3   <?php if($currentMenu == 'modal'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-129']?></a>
            <a href="pages.php?page=theme_404" class="btn  w-100 mb-2 text-left p-3   <?php if($currentMenu == '404'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-131']?></a>
            <a href="pages.php?page=theme_banks" class="btn  w-100 mb-2 text-left p-3   <?php if($currentMenu == 'bank'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-133']?></a>
            <a href="pages.php?page=theme_pricing" class="btn  w-100 mb-2 text-left p-3   <?php if($currentMenu == 'pricing'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-135']?></a>
            <a href="pages.php?page=theme_services" class="btn  w-100 mb-2 text-left p-3   <?php if($currentMenu == 'services'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-137']?></a>
            <a href="pages.php?page=theme_blogs" class="btn  w-100 mb-2 text-left p-3   <?php if($currentMenu == 'blogs'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-139']?></a>
            <a href="pages.php?page=theme_enews" class="btn  w-100 mb-2 text-left p-3   <?php if($currentMenu == 'enews'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-141']?></a>
            <a href="pages.php?page=theme_client_comments" class="btn  w-100 mb-2 text-left p-3   <?php if($currentMenu == 'clients'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-143']?></a>
            <a href="pages.php?page=theme_client_counter" class="btn  w-100 mb-2 text-left p-3   <?php if($currentMenu == 'counter'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-145']?></a>
            <a href="pages.php?page=theme_faq" class="btn  w-100 mb-2 text-left p-3   <?php if($currentMenu == 'faq'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-147']?></a>
            <a href="pages.php?page=theme_gallery" class="btn  w-100 mb-2 text-left p-3   <?php if($currentMenu == 'gallery'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-174']?></a>
            <a href="pages.php?page=theme_videos" class="btn  w-100 mb-2 text-left p-3   <?php if($currentMenu == 'videos'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-175']?></a>
            <a href="pages.php?page=theme_intro" class="btn  w-100 mb-2 text-left p-3   <?php if($currentMenu == 'intro'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-176']?></a>
            <a href="pages.php?page=theme_print_invoice" class="btn  w-100 mb-2 text-left p-3   <?php if($currentMenu == 'print_invoice'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-181']?></a>
        <?php }?>
    </div>
    <div class="card p-4 bg-white font-16 mb-2 ">
        <div class="w-100 text-center">
            <img src="assets/images/icon/design-ill.png" >
        </div>
        <h5><?=$diller['adminpanel-text-281']?></h5>
        <?=$diller['adminpanel-text-282']?>
        <div style="font-size: 11px ; color: #999; margin-top: 10px;"><?=$diller['adminpanel-text-283']?></div>
    </div>
</div>