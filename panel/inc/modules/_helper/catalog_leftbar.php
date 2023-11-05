<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php if($yetki['katalog'] == '1' ) {?>
<!-- Mobile !-->
<div class="col-md-3 d-md-none d-sm-inline-block  ">
    <a class="btn btn-pink mo-mb-2 btn-block d-flex align-items-center justify-content-between" data-toggle="collapse" href="#mobileCollepse" aria-expanded="false" aria-controls="collapseExample">
        <?=$diller['adminpanel-text-269']?> <i class="fa fa-plus"></i>
    </a>
    <div class="collapse mb-3" id="mobileCollepse">
        <div class="list-group " style="font-size: 14px ;">
            <?php if($yetki['urun'] == '1' ) {?>
                <a href="pages.php?page=products" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'products'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-3']?></a>
            <?php }?>
            <?php if($yetki['kat'] == '1' ) {?>
                <a href="pages.php?page=categories" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'categories'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-4']?></a>
            <?php }?>
            <?php if($yetki['marka'] == '1' ) {?>
                <a href="pages.php?page=brands" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'brands'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-5']?></a>
            <?php }?>
                <a href="pages.php?page=e_catalog" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'e_catalog'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-182']?></a>
            <?php if($yetki['varyant'] == '1' ) {?>
                <a href="pages.php?page=product_features" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'features'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-6']?></a>
                <a href="pages.php?page=product_variants" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'variants'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-7']?></a>
            <?php }?>
            <?php if($yetki['urun_yorum'] == '1' ) {?>
                <a href="pages.php?page=products_comments" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'products_comments'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-8']?></a>
            <?php }?>
            <?php if($yetki['toplu'] == '1' ) {?>
                <a href="pages.php?page=allupdate_product" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'allupdate_product'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-9']?></a>
            <?php }?>
        </div>
    </div>
</div>
<!--  <========SON=========>>> Mobile SON !-->
<?php }?>
