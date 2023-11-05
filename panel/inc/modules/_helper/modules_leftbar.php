<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php if($yetki['modul'] == '1'  ) {?>
<!-- Left Bar !-->
<?php if($panelayar['panel_nav'] == '1' ) {?>
<div class="col-md-3 d-none d-md-inline-block  ">
    <div class="list-group " style="font-size: 14px ;">
        <?php if($yetki['sirala'] == '1'  ) {?>
            <a href="pages.php?page=modules_sort" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'sort'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-68']?></a>
        <?php }?>
        <?php if($yetki['modul_header_footer'] == '1'  ) {?>
            <a href="pages.php?page=tophtml_area" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'tophtml'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-44']?></a>
            <a href="pages.php?page=topheader_links" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'topheader'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-45']?></a>
            <a href="pages.php?page=header_links" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'header'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-46']?></a>
            <a href="pages.php?page=footer_links" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'footer'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-97']?></a>
        <?php }?>
        <?php if($yetki['modul_diger'] == '1' ) {?>
            <a href="pages.php?page=top_slider" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'topslider'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-69']?></a>
            <a href="pages.php?page=middle_slider" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'midslider'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-70']?></a>
            <a href="pages.php?page=stories" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'story'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-71']?></a>
        <?php } ?>
        <?php if($yetki['modul_vitrin'] == '1' ) {?>
            <a href="pages.php?page=showcase_tabproduct" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'tabproduct'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-11']?></a>
            <a href="pages.php?page=showcase_bannerproduct" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'bannerproduct'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-12']?></a>
            <a href="pages.php?page=showcase_banner1" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'banner1'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-13']?></a>
            <a href="pages.php?page=showcase_banner2" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'banner2'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-14']?></a>
            <a href="pages.php?page=showcase_countdown" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'countdown'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-15']?></a>
            <a href="pages.php?page=showcase_html" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'html'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-72']?></a>
        <?php } ?>
    </div>
</div>
    <?php } ?>
<!--  <========SON=========>>> Left Bar SON !-->

<!-- Mobile !-->
<div class="col-md-3 d-md-none d-sm-inline-block  ">
    <a class="btn btn-pink mo-mb-2 btn-block d-flex align-items-center justify-content-between" data-toggle="collapse" href="#mobileCollepse" aria-expanded="false" aria-controls="collapseExample">
        <?=$diller['adminpanel-text-269']?> <i class="fa fa-plus"></i>
    </a>
    <div class="collapse mb-3" id="mobileCollepse">
        <div class="list-group " style="font-size: 14px ;">
            <?php if($yetki['sirala'] == '1'  ) {?>
                <a href="pages.php?page=modules_sort" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'sort'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-68']?></a>
            <?php }?>
            <?php if($yetki['modul_header_footer'] == '1'  ) {?>
                <a href="pages.php?page=tophtml_area" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'tophtml'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-44']?></a>
                <a href="pages.php?page=topheader_links" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'topheader'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-45']?></a>
                <a href="pages.php?page=header_links" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'header'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-46']?></a>
                <a href="pages.php?page=mobile_header_links" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'mobilheader'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-177']?></a>
                <a href="pages.php?page=footer_links" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'footer'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-97']?></a>
            <?php }?>
            <?php if($yetki['modul_diger'] == '1' ) {?>
                <a href="pages.php?page=top_slider" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'topslider'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-69']?></a>
                <a href="pages.php?page=middle_slider" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'midslider'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-70']?></a>
                <a href="pages.php?page=stories" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'story'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-71']?></a>
            <?php } ?>
            <?php if($yetki['modul_vitrin'] == '1' ) {?>
                <a href="pages.php?page=showcase_tabproduct" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'tabproduct'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-11']?></a>
                <a href="pages.php?page=showcase_bannerproduct" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'bannerproduct'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-12']?></a>
                <a href="pages.php?page=showcase_banner1" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'banner1'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-13']?></a>
                <a href="pages.php?page=showcase_banner2" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'banner2'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-14']?></a>
                <a href="pages.php?page=showcase_countdown" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'countdown'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-15']?></a>
                <a href="pages.php?page=showcase_html" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'html'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-72']?></a>
            <?php } ?>
        </div>
    </div>
</div>
<!--  <========SON=========>>> Mobile SON !-->
<?php }?>
