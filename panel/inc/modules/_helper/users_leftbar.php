<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php if($yetki['uyelik'] == '1'  ) {?>
<!-- Mobile !-->
<div class="col-md-3 d-md-none d-sm-inline-block  ">
    <a class="btn btn-pink mo-mb-2 btn-block d-flex align-items-center justify-content-between" data-toggle="collapse" href="#mobileCollepse" aria-expanded="false" aria-controls="collapseExample">
        <?=$diller['adminpanel-text-269']?> <i class="fa fa-plus"></i>
    </a>
    <div class="collapse mb-3" id="mobileCollepse">
        <div class="list-group " style="font-size: 14px ;">
            <?php if($yetki['uye_yonet'] == '1'  ) {?>
                <a href="pages.php?page=users" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'users'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-26']?></a>
                <a href="pages.php?page=users_group" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'users_group'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-27']?></a>
            <?php }?>
            <?php if( $yetki['ticket'] == '1' ) {?>
                <a href="pages.php?page=tickets" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'tickets'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-28']?></a>
            <?php }?>
            <?php if( $yetki['uyelik_ayar'] == '1' ) {?>
                <a href="pages.php?page=users_settings" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'usersettings'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-29']?></a>
            <?php }?>
            <?php if( $yetki['ziyaretci_istatistik'] == '1' ) {?>
                <a href="pages.php?page=visitor_analytics" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'visitor'  ) { ?>active<?php }?>"><?=$diller['adminpanel-text-60']?></a>
            <?php }?>
        </div>
    </div>
</div>
<!--  <========SON=========>>> Mobile SON !-->
<?php }?>
