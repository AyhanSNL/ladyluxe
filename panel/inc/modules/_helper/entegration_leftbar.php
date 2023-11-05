<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<!-- Left Bar !-->
<?php if($panelayar['panel_nav'] == '1' && $_GET['page'] != 'n11_process' && $_GET['page'] != 'ty_process' && $_GET['page'] != 'hb_process' && $_GET['page'] != 'n11_process_post') {?>
    <?php if($_GET['page'] != 'product_import' && $_GET['page'] != 'product_export' && $_GET['page'] != 'email_list_import'  && $_GET['page'] != 'gsm_list_import' && $_GET['page'] != 'sitemap') {?>
        <div class="col-md-3 d-none d-md-inline-block ">
            <?php if($yetki['entegrasyon'] == '1' && $yetki['entegrasyon_pazar'] == '1'  ) {?>
                <a href="pages.php?page=n11_settings" class="btn  w-100 mb-2 text-left p-3   <?php if($currentMenu == 'n11settings'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['pazaryeri-text-1']?></a>
                <a href="pages.php?page=n11_process" class="btn  w-100 mb-2 text-left p-3   <?php if($currentMenu == 'n11process'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['pazaryeri-text-42']?></a>

                <a href="pages.php?page=ty_settings" class="btn  w-100 mb-2 text-left p-3   <?php if($currentMenu == 'tysettings'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['pazaryeri-text-72']?></a>
                <a href="pages.php?page=ty_process" class="btn  w-100 mb-2 text-left p-3   <?php if($currentMenu == 'typrocess'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['pazaryeri-text-73']?></a>

                <a href="pages.php?page=hb_settings" class="btn  w-100 mb-2 text-left p-3   <?php if($currentMenu == 'hbsettings'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['pazaryeri-text-147']?></a>
                <a href="pages.php?page=hb_process" class="btn  w-100 mb-2 text-left p-3   <?php if($currentMenu == 'hbprocess'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['pazaryeri-text-148']?></a>

            <?php }?>
            <?php if($yetki['entegrasyon'] == '1' && $yetki['parasut'] == '1'  ) {
                //todo paraşüt?>
                <a href="pages2.php?page=parasut_ayar" class="btn  w-100 mb-2 text-left p-3   <?php if($currentMenu == 'parasut_ayar'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['parasut-text-1']?></a>
                <a href="pages2.php?page=parasut_fatura" class="btn  w-100 mb-2 text-left p-3   <?php if($currentMenu == 'parasut_fatura'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['parasut-text-6']?></a>
            <?php }?>
            <?php if($yetki['entegrasyon'] == '1' &&  $yetki['entegrasyon_urun'] == '1') {?>
                <a href="pages.php?page=product_import" class="btn  w-100 mb-2 text-left p-3   <?php if($currentMenu == 'product_import'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-87']?></a>
                <a href="pages.php?page=product_export" class="btn  w-100 mb-2 text-left p-3   <?php if($currentMenu == 'product_export'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-88']?></a>
            <?php } ?>
        <?php if($yetki['entegrasyon'] == '1' &&  $yetki['entegrasyon_eposta'] == '1') {?>
            <a href="pages.php?page=email_list_import" class="btn  w-100 mb-2 text-left p-3   <?php if($currentMenu == 'email_import'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-91']?></a>
        <?php } ?>
            <?php if($yetki['entegrasyon'] == '1' &&  $yetki['entegrasyon_sms'] == '1') {?>
                <a href="pages.php?page=gsm_list_import" class="btn  w-100 mb-2 text-left p-3   <?php if($currentMenu == 'gsm_import'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-89']?></a>
            <?php } ?>
            <?php if($yetki['entegrasyon'] == '1' &&  $yetki['entegrasyon_map'] == '1') {?>
                <a href="pages.php?page=sitemap" class="btn  w-100 mb-2 text-left p-3   <?php if($currentMenu == 'sitemap'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-93']?></a>
            <?php } ?>
        </div>
    <?php }?>
<?php } ?>
<!--  <========SON=========>>> Left Bar SON !-->

<?php if($_GET['page'] != 'n11_process_post'  ) {?>
<!-- Mobile !-->
<div class="col-md-3 d-md-none d-sm-inline-block ">
    <a class="btn btn-pink mo-mb-2 btn-block d-flex align-items-center justify-content-between" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
        <?=$diller['adminpanel-text-269']?> <i class="fa fa-plus"></i>
    </a>
    <div class="collapse" id="collapseExample">
        <?php if($yetki['entegrasyon'] == '1' && $yetki['entegrasyon_pazar'] == '1'  ) {?>
            <a href="pages.php?page=n11_settings" class="btn  w-100 mb-2 text-left p-3   <?php if($currentMenu == 'n11settings'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['pazaryeri-text-1']?></a>
            <a href="pages.php?page=n11_process" class="btn  w-100 mb-2 text-left p-3   <?php if($currentMenu == 'n11process'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['pazaryeri-text-42']?></a>

            <a href="pages.php?page=ty_settings" class="btn  w-100 mb-2 text-left p-3   <?php if($currentMenu == 'tysettings'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['pazaryeri-text-72']?></a>
            <a href="pages.php?page=ty_process" class="btn  w-100 mb-2 text-left p-3   <?php if($currentMenu == 'typrocess'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['pazaryeri-text-73']?></a>

            <a href="pages.php?page=hb_settings" class="btn  w-100 mb-2 text-left p-3   <?php if($currentMenu == 'hbsettings'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['pazaryeri-text-147']?></a>
            <a href="pages.php?page=hb_process" class="btn  w-100 mb-2 text-left p-3   <?php if($currentMenu == 'hbprocess'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['pazaryeri-text-148']?></a>

        <?php }?>
        <?php if($yetki['entegrasyon'] == '1' && $yetki['parasut'] == '1'  ) {
            //todo paraşüt?>
            <a href="pages2.php?page=parasut_ayar" class="btn  w-100 mb-2 text-left p-3   <?php if($currentMenu == 'parasut_ayar'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['parasut-text-1']?></a>
            <a href="pages2.php?page=parasut_fatura" class="btn  w-100 mb-2 text-left p-3   <?php if($currentMenu == 'parasut_fatura'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['parasut-text-6']?></a>
        <?php }?>
        <?php if($yetki['entegrasyon'] == '1' &&  $yetki['entegrasyon_urun'] == '1') {?>
            <a href="pages.php?page=product_import" class="btn  w-100 mb-2 text-left p-3   <?php if($currentMenu == 'product_import'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-87']?></a>
            <a href="pages.php?page=product_export" class="btn  w-100 mb-2 text-left p-3   <?php if($currentMenu == 'product_export'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-88']?></a>
        <?php } ?>
        <?php if($yetki['entegrasyon'] == '1' &&  $yetki['entegrasyon_eposta'] == '1') {?>
            <a href="pages.php?page=email_list_import" class="btn  w-100 mb-2 text-left p-3   <?php if($currentMenu == 'email_import'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-91']?></a>
        <?php } ?>
        <?php if($yetki['entegrasyon'] == '1' &&  $yetki['entegrasyon_sms'] == '1') {?>
            <a href="pages.php?page=gsm_list_import" class="btn  w-100 mb-2 text-left p-3   <?php if($currentMenu == 'gsm_import'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-89']?></a>
        <?php } ?>
        <?php if($yetki['entegrasyon'] == '1' &&  $yetki['entegrasyon_map'] == '1') {?>
            <a href="pages.php?page=sitemap" class="btn  w-100 mb-2 text-left p-3   <?php if($currentMenu == 'sitemap'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-93']?></a>
        <?php } ?>
    </div>
</div>
<!--  <========SON=========>>> Mobile SON !-->
<?php }?>
