<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php if($yetki['kampanya'] == '1'  ) {?>
    <?php if($panelayar['panel_nav'] == '1' ) {?>
        <?php if($_GET['page'] !='coupons'  ) {?>
            <!-- Left Bar !-->
            <div class="col-md-3 d-none d-md-inline-block  ">
                <div class="list-group " style="font-size: 14px ;">
                    <?php if($yetki['indirimkod'] == '1'  ) {?>
                        <a href="pages.php?page=coupons" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'coupon'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-31']?></a>
                        <a href="pages.php?page=first_order_discount" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'firstorder'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-179']?></a>
                        <a href="pages.php?page=cart_discount" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'cartdiscount'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-180']?></a>
                    <?php }?>
                    <?php if($yetki['eposta_yonet'] == '1'  ) {?>
                        <a href="pages.php?page=email_list" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'maillist'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-32']?></a>
                        <a href="pages.php?page=newsletter" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'mailpost'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-33']?></a>
                    <?php }?>
                    <?php if($yetki['sms_yonet'] == '1'  ) {?>
                        <a href="pages.php?page=sms_numbers" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'smslist'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-36']?></a>
                        <a href="pages.php?page=multi_sms" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'smspost'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-37']?></a>
                    <?php }?>
                    <?php if($yetki['bildirim_gonder'] == '1'  ) {?>
                        <a href="pages.php?page=notifications" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'noti'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-40']?></a>
                    <?php }?>
                </div>
            </div>
            <!--  <========SON=========>>> Left Bar SON !-->
        <?php }?>
    <?php } ?>

<!-- Mobile !-->
<div class="col-md-3 d-md-none d-sm-inline-block  ">
    <a class="btn btn-pink mo-mb-2 btn-block d-flex align-items-center justify-content-between" data-toggle="collapse" href="#mobileCollepse" aria-expanded="false" aria-controls="collapseExample">
        <?=$diller['adminpanel-text-269']?> <i class="fa fa-plus"></i>
    </a>
    <div class="collapse mb-3" id="mobileCollepse">
        <div class="list-group " style="font-size: 14px ;">
            <?php if($yetki['indirimkod'] == '1'  ) {?>
                <a href="pages.php?page=coupons" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'coupon'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-31']?></a>
                <a href="pages.php?page=first_order_discount" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'firstorder'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-179']?></a>
                <a href="pages.php?page=cart_discount" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'cartdiscount'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-180']?></a>
            <?php }?>
            <?php if($yetki['eposta_yonet'] == '1'  ) {?>
                <a href="pages.php?page=email_list" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'maillist'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-32']?></a>
                <a href="pages.php?page=newsletter" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'mailpost'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-33']?></a>
            <?php }?>
            <?php if($yetki['sms_yonet'] == '1'  ) {?>
                <a href="pages.php?page=sms_numbers" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'smslist'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-36']?></a>
                <a href="pages.php?page=multi_sms" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'smspost'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-37']?></a>
            <?php }?>
            <?php if($yetki['bildirim_gonder'] == '1'  ) {?>
                <a href="pages.php?page=notifications" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'noti'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-40']?></a>
            <?php }?>
        </div>
    </div>
</div>
<!--  <========SON=========>>> Mobile SON !-->
<?php }?>
