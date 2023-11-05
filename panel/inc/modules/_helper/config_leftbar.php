<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<!-- Left Bar !-->
<?php if($panelayar['panel_nav'] == '1' ) {?>
<div class="col-md-3 d-none d-md-inline-block ">
    <?php if($yetki['yapilandirma'] == '1'  ) {?>
        <a href="pages.php?page=payment_settings" class="btn  w-100 mb-2 text-left p-3   <?php if($currentMenu == 'payment'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-76']?></a>
        <a href="pages.php?page=pos_settings" class="btn  w-100 mb-2 text-left p-3 <?php if($currentMenu == 'pos'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-77']?></a>
        <a href="pages.php?page=order_status" class="btn  w-100 mb-2 text-left p-3 <?php if($currentMenu == 'status'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-78']?></a>
        <a href="pages.php?page=commerce_settings" class="btn  w-100 mb-2 text-left p-3 <?php if($currentMenu == 'commerce'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-79']?></a>
        <a href="pages.php?page=bank_accounts" class="btn  w-100 mb-2 text-left p-3 <?php if($currentMenu == 'bank'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-80']?></a>
        <a href="pages.php?page=countries" class="btn  w-100 mb-2 text-left p-3 <?php if($currentMenu == 'ulke'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-81']?></a>
        <a href="pages.php?page=currency" class="btn  w-100 mb-2 text-left p-3 <?php if($currentMenu == 'para'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-82']?></a>
        <a href="pages.php?page=delivery_settings" class="btn  w-100 mb-2 text-left p-3 <?php if($currentMenu == 'kargoayar'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-83']?></a>
        <a href="pages.php?page=delivery_company" class="btn  w-100 mb-2 text-left p-3 <?php if($currentMenu == 'kargo'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-84']?></a>
        <a href="pages.php?page=installment_rate" class="btn  w-100 mb-2 text-left p-3 <?php if($currentMenu == 'taksit'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-85']?></a>
        <a href="pages.php?page=smtp_settings" class="btn  w-100 mb-2 text-left p-3 <?php if($currentMenu == 'smtp'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-35']?></a>
        <a href="pages.php?page=sms_settings" class="btn  w-100 mb-2 text-left p-3 <?php if($currentMenu == 'sms'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-39']?></a>

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
        <?php if($yetki['yapilandirma'] == '1'  ) {?>
            <a href="pages.php?page=payment_settings" class="btn  w-100 mb-2 text-left p-3   <?php if($currentMenu == 'payment'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-76']?></a>
            <a href="pages.php?page=pos_settings" class="btn  w-100 mb-2 text-left p-3 <?php if($currentMenu == 'pos'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-77']?></a>
            <a href="pages.php?page=order_status" class="btn  w-100 mb-2 text-left p-3 <?php if($currentMenu == 'status'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-78']?></a>
            <a href="pages.php?page=commerce_settings" class="btn  w-100 mb-2 text-left p-3 <?php if($currentMenu == 'commerce'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-79']?></a>
            <a href="pages.php?page=bank_accounts" class="btn  w-100 mb-2 text-left p-3 <?php if($currentMenu == 'bank'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-80']?></a>
            <a href="pages.php?page=countries" class="btn  w-100 mb-2 text-left p-3 <?php if($currentMenu == 'ulke'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-81']?></a>
            <a href="pages.php?page=currency" class="btn  w-100 mb-2 text-left p-3 <?php if($currentMenu == 'para'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-82']?></a>
            <a href="pages.php?page=delivery_settings" class="btn  w-100 mb-2 text-left p-3 <?php if($currentMenu == 'kargoayar'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-83']?></a>
            <a href="pages.php?page=delivery_company" class="btn  w-100 mb-2 text-left p-3 <?php if($currentMenu == 'kargo'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-84']?></a>
            <a href="pages.php?page=installment_rate" class="btn  w-100 mb-2 text-left p-3 <?php if($currentMenu == 'taksit'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-85']?></a>
            <a href="pages.php?page=smtp_settings" class="btn  w-100 mb-2 text-left p-3 <?php if($currentMenu == 'smtp'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-35']?></a>
            <a href="pages.php?page=sms_settings" class="btn  w-100 mb-2 text-left p-3 <?php if($currentMenu == 'sms'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-39']?></a>

        <?php }?>
    </div>
</div>
<!--  <========SON=========>>> Mobile SON !-->