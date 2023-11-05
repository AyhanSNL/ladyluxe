<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php if($yetki['icerik_yonetim'] == '1'  ) {?>
<?php if($panelayar['panel_nav'] == '1' ) {?>
<!-- Left Bar !-->
<div class="col-md-3 d-none d-md-inline-block  ">
    <div class="list-group " style="font-size: 14px ;">
        <?php if($yetki['sayfa_yonet'] == '1'  ) {?>
            <a href="pages.php?page=sub_navigations" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'sub'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-42']?></a>
            <a href="pages.php?page=page_management" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'htmlpage'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-47']?></a>
            <a href="pages.php?page=user_contract" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'contract'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-49']?></a>
            <a href="pages.php?page=sale_contract" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'salecontract'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-50']?></a>
            <a href="pages.php?page=cookie_contract" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'cookie'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-73']?></a>
        <?php }?>
        <?php if($yetki['icerik_yonetim'] == '1' && $yetki['ptable'] == '1' ) {?>
            <a href="pages.php?page=pricing_table" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'ptable'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-51']?></a>
        <?php }?>
        <?php if($yetki['icerik_yonetim'] == '1' && $yetki['blog_hizmet'] == '1' ) {?>
            <a href="pages.php?page=blogs" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'blog'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-54']?></a>
           <?php if($_GET['page'] == 'blogs_categories'  ) {?>
                <a href="pages.php?page=blogs_categories" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'blogcat'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-54-2']?></a>
           <?php }?>
            <?php if($_GET['page'] == 'blog_comments'  ) {?>
                <a href="pages.php?page=blog_comments" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'blogcom'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-55']?></a>
            <?php }?>
            <a href="pages.php?page=services" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'service'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-57']?></a>
            <?php if($_GET['page'] == 'service_comments'  ) {?>
                <a href="pages.php?page=service_comments" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'servicescom'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-58']?></a>
            <?php }?>
        <?php }?>
        <?php if($yetki['icerik_yonetim'] == '1' && $yetki['galeri'] == '1' ) {?>
            <a href="pages.php?page=photo_gallery" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'photo'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-59']?></a>
            <a href="pages.php?page=video_gallery" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'video'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-60']?></a>
            <a href="pages.php?page=intro" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'intro'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-61']?></a>
        <?php }?>
        <?php if($yetki['icerik_yonetim'] == '1' && $yetki['icerik_diger'] == '1' ) {?>
            <a href="pages.php?page=contact_page" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'contact'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-62']?></a>
            <a href="pages.php?page=social_accounts" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'social'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-63']?></a>
            <a href="pages.php?page=counters" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'counter'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-64']?></a>
            <a href="pages.php?page=commerce_boxes" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'tbox'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-65']?></a>
            <a href="pages.php?page=client_comments" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'com'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-66']?></a>
            <a href="pages.php?page=faq" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'faq'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-52']?></a>
        <?php } ?>
    </div>
</div>
<!--  <========SON=========>>> Left Bar SON !-->
    <?php } ?>

<!-- Mobile !-->
<div class="col-md-3 d-md-none d-sm-inline-block  ">
    <a class="btn btn-pink mo-mb-2 btn-block d-flex align-items-center justify-content-between" data-toggle="collapse" href="#mobileCollepse" aria-expanded="false" aria-controls="collapseExample">
        <?=$diller['adminpanel-text-269']?> <i class="fa fa-plus"></i>
    </a>
    <div class="collapse mb-3" id="mobileCollepse">
        <div class="list-group " style="font-size: 14px ;">
            <?php if($yetki['sayfa_yonet'] == '1'  ) {?>
                <a href="pages.php?page=sub_navigations" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'sub'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-42']?></a>
                <a href="pages.php?page=page_management" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'htmlpage'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-47']?></a>
                <a href="pages.php?page=user_contract" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'contract'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-49']?></a>
                <a href="pages.php?page=sale_contract" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'salecontract'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-50']?></a>
                <a href="pages.php?page=cookie_contract" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'cookie'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-73']?></a>
            <?php }?>
            <?php if($yetki['icerik_yonetim'] == '1' && $yetki['ptable'] == '1' ) {?>
                <a href="pages.php?page=pricing_table" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'ptable'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-51']?></a>
            <?php }?>
            <?php if($yetki['icerik_yonetim'] == '1' && $yetki['blog_hizmet'] == '1' ) {?>
                <a href="pages.php?page=blogs" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'blog'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-54']?></a>
                <?php if($_GET['page'] == 'blogs_categories'  ) {?>
                    <a href="pages.php?page=blogs_categories" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'blogcat'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-54-2']?></a>
                <?php }?>
                <?php if($_GET['page'] == 'blog_comments'  ) {?>
                    <a href="pages.php?page=blog_comments" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'blogcom'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-55']?></a>
                <?php }?>
                <a href="pages.php?page=services" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'service'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-57']?></a>
                <?php if($_GET['page'] == 'service_comments'  ) {?>
                    <a href="pages.php?page=service_comments" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'servicescom'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-58']?></a>
                <?php }?>
            <?php }?>
            <?php if($yetki['icerik_yonetim'] == '1' && $yetki['galeri'] == '1' ) {?>
                <a href="pages.php?page=photo_gallery" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'photo'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-59']?></a>
                <a href="pages.php?page=video_gallery" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'video'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-60']?></a>
                <a href="pages.php?page=intro" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'intro'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-61']?></a>
            <?php }?>
            <?php if($yetki['icerik_yonetim'] == '1' && $yetki['icerik_diger'] == '1' ) {?>
                <a href="pages.php?page=contact_page" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'contact'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-62']?></a>
                <a href="pages.php?page=social_accounts" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'social'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-63']?></a>
                <a href="pages.php?page=counters" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'counter'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-64']?></a>
                <a href="pages.php?page=commerce_boxes" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'tbox'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-65']?></a>
                <a href="pages.php?page=client_comments" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'com'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-66']?></a>
                <a href="pages.php?page=faq" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'faq'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-52']?></a>
            <?php } ?>
        </div>
    </div>
</div>
<!--  <========SON=========>>> Mobile SON !-->
<?php }?>
