<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php if($yetki['siparis'] == '1'  ) {?>
<!-- Mobile !-->
<div class="col-md-3 d-md-none d-sm-inline-block  ">
    <a class="btn btn-pink mo-mb-2 btn-block d-flex align-items-center justify-content-between" data-toggle="collapse" href="#mobileCollepse" aria-expanded="false" aria-controls="collapseExample">
        <?=$diller['adminpanel-text-269']?> <i class="fa fa-plus"></i>
    </a>
    <div class="collapse mb-3" id="mobileCollepse">
        <div class="list-group " style="font-size: 14px ;">
            <?php if($yetki['siparis_yonet'] == '1'  ) {?>
                <a href="pages.php?page=orders" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'orders'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-17']?></a>
                <a href="pages.php?page=op_orders" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'op_orders'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-18']?></a>
                <a href="pages.php?page=offers" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'offers'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-19']?></a>
                <a href="pages.php?page=order_cancel" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'order_cancel'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-20']?></a>
                <a href="pages.php?page=order_product_return" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'order_product_return'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-21']?></a>
            <?php }?>
            <?php if($yetki['odeme_bildirim'] == '1'  ) {?>
                <a href="pages.php?page=bank_transfer" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'bank_transfer'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-22']?></a>
            <?php }?>
            <?php if($yetki['siparis_diger'] == '1'  ) {?>
                <a href="pages.php?page=all_cart_list" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'all_cart_list'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-23']?></a>
                <a href="pages.php?page=nocomplete_orders" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'nocomplete_orders'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-24']?></a>
                <a href="pages.php?page=order_reports" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'order_reports'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-95']?></a>
                <a href="pages.php?page=sale_reports" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'sale_reports'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-96']?></a>
            <?php }?>
        </div>
    </div>
</div>
<!--  <========SON=========>>> Mobile SON !-->
<?php }?>
