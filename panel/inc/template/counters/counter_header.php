<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php if($panelayar['panel_bildirim'] == '1' && $yetki['bell'] == '1' ) {?>
    <!-- Bildirimler !-->
    <?php
    $BildirimHeader = $db->prepare("select * from panel_bildirim   where durum=:durum order by id desc limit 5 ");
    $BildirimHeader->execute(array(
        'durum' => '1',
    ));
    $bildirimDurumAktif = $db->prepare("select * from panel_bildirim where durum=:durum ");
    $bildirimDurumAktif->execute(array(
        'durum' => '1',
    ));
    ?>
    <li class="list-inline-item dropdown notification-list ">
        <a class="nav-link dropdown-toggle arrow-none waves-effect" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
            <i class="mdi mdi-bell noti-icon"></i>
            <?php if($bildirimDurumAktif->rowCount()>'0'  ) {?>
                <span class="badge  badge-pill noti-icon-badge"><?=$bildirimDurumAktif->rowCount()?></span>
            <?php }?>
        </a>
        <div class="dropdown-menu dropdown-menu-right dropdown-arrow dropdown-menu-lg dropdown-menu-animated">
            <div class="dropdown-item noti-title" style="border-bottom: 1px solid #ebebeb !important;">
                <h5><?=$diller['adminpanel-text-15']?> </h5>
            </div>
            <div class="slimscroll-noti">
                <?php if($BildirimHeader->rowCount()<='0') {?>
                    <div class="card mb-0" >
                        <div class="card-body">
                            <?=$diller['adminpanel-text-17']?>
                        </div>
                    </div>
                <?php }?>
                <?php foreach ($BildirimHeader as $notiRow) {?>
                    <?php if($notiRow['modul'] == 'siparis' && $yetki['siparis'] == '1'&& $yetki['siparis_yonet'] == '1' ) {?>
                        <a href="post.php?process=panel_notification&noti_id=<?=$notiRow['id']?>" class="dropdown-item notify-item border-bottom position-relative <?php if($notiRow['durum'] == '1' ) { ?>active<?php }?>">
                            <div class="notify-icon bg-primary "><i class="fa fa-shopping-basket"></i></div>
                            <p class="notify-details"><b><?=$diller['adminpanel-text-18']?></b><span class="text-muted"><?php echo date_tr('j F Y, H:i ', ''.$notiRow['tarih'].''); ?></span></p>
                            <div class="spinner-grow  text-danger position-absolute" style="top:18px; right: 10px; width: 1.3em; height: 1.3em" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </a>
                    <?php }?>
                    <?php if($notiRow['modul'] == 'destek' && $yetki['uyelik'] == '1' && $yetki['ticket'] == '1') {?>
                        <a href="post.php?process=panel_notification&noti_id=<?=$notiRow['id']?>" class="dropdown-item notify-item border-bottom position-relative <?php if($notiRow['durum'] == '1' ) { ?>active<?php }?>">
                            <div class="notify-icon bg-success "><i class="fa fa-ticket-alt"></i></div>
                            <p class="notify-details"><b><?=$diller['adminpanel-text-20']?></b><span class="text-muted"><?php echo date_tr('j F Y, H:i ', ''.$notiRow['tarih'].''); ?></span></p>
                            <div class="spinner-grow  text-danger position-absolute" style="top:18px; right: 10px; width: 1.3em; height: 1.3em" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </a>
                    <?php }?>
                    <?php if($notiRow['modul'] == 'odemebildirim' && $yetki['siparis'] == '1' && $yetki['odeme_bildirim'] == '1' ) {?>
                        <a href="post.php?process=panel_notification&noti_id=<?=$notiRow['id']?>" class="dropdown-item notify-item border-bottom position-relative <?php if($notiRow['durum'] == '1' ) { ?>active<?php }?>">
                            <div class="notify-icon bg-light "><i class="fa fa-money-bill-alt text-dark"></i></div>
                            <p class="notify-details"><b><?=$diller['adminpanel-text-21']?></b><span class="text-muted"><?php echo date_tr('j F Y, H:i ', ''.$notiRow['tarih'].''); ?></span></p>
                            <div class="spinner-grow  text-danger position-absolute" style="top:18px; right: 10px; width: 1.3em; height: 1.3em" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </a>
                    <?php }?>
                    <?php if($notiRow['modul'] == 'urunyorum' && $yetki['katalog'] == '1' && $yetki['urun_yorum'] == '1' ) {?>
                        <a href="post.php?process=panel_notification&noti_id=<?=$notiRow['id']?>" class="dropdown-item notify-item border-bottom position-relative <?php if($notiRow['durum'] == '1' ) { ?>active<?php }?>">
                            <div class="notify-icon bg-warning "><i class="fa fa-comment-alt text-dark"></i></div>
                            <p class="notify-details"><b><?=$diller['adminpanel-text-22']?></b><span class="text-muted"><?php echo date_tr('j F Y, H:i ', ''.$notiRow['tarih'].''); ?></span></p>
                            <div class="spinner-grow  text-danger position-absolute" style="top:18px; right: 10px; width: 1.3em; height: 1.3em" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </a>
                    <?php }?>
                    <?php if($notiRow['modul'] == 'siparisiptal' && $yetki['siparis_yonet'] == '1' && $yetki['siparis'] == '1') {?>
                        <a href="post.php?process=panel_notification&noti_id=<?=$notiRow['id']?>" class="dropdown-item notify-item border-bottom position-relative <?php if($notiRow['durum'] == '1' ) { ?>active<?php }?>">
                            <div class="notify-icon bg-dark "><i class="fa fa-ban"></i></div>
                            <p class="notify-details"><b><?=$diller['adminpanel-text-23']?></b><span class="text-muted"><?php echo date_tr('j F Y, H:i ', ''.$notiRow['tarih'].''); ?></span></p>
                            <div class="spinner-grow  text-danger position-absolute" style="top:18px; right: 10px; width: 1.3em; height: 1.3em" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </a>
                    <?php }?>
                    <?php if($notiRow['modul'] == 'uruniade' && $yetki['siparis_yonet'] == '1' && $yetki['siparis'] == '1' ) {?>
                        <a href="post.php?process=panel_notification&noti_id=<?=$notiRow['id']?>" class="dropdown-item notify-item border-bottom position-relative <?php if($notiRow['durum'] == '1' ) { ?>active<?php }?>">
                            <div class="notify-icon bg-pink "><i class="fa fa-recycle"></i></div>
                            <p class="notify-details"><b><?=$diller['adminpanel-text-24']?></b><span class="text-muted"><?php echo date_tr('j F Y, H:i ', ''.$notiRow['tarih'].''); ?></span></p>
                            <div class="spinner-grow  text-danger position-absolute" style="top:18px; right: 10px; width: 1.3em; height: 1.3em" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </a>
                    <?php }?>
                    <?php if($notiRow['modul'] == 'mesaj' && $yetki['gelenkutusu'] == '1' ) {?>
                        <a href="post.php?process=panel_notification&noti_id=<?=$notiRow['id']?>" class="dropdown-item notify-item border-bottom position-relative <?php if($notiRow['durum'] == '1' ) { ?>active<?php }?>">
                            <div class="notify-icon bg-info "><i class="fa fa-envelope-open"></i></div>
                            <p class="notify-details"><b><?=$diller['adminpanel-text-25']?></b><span class="text-muted"><?php echo date_tr('j F Y, H:i ', ''.$notiRow['tarih'].''); ?></span></p>
                            <div class="spinner-grow  text-danger position-absolute" style="top:18px; right: 10px; width: 1.3em; height: 1.3em" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </a>
                    <?php }?>
                <?php }?>
            </div>
        </div>
    </li>
    <!--  <========SON=========>>> Bildirimler SON !-->
<?php }?>

<?php if($panelayar['header_order'] == '1' && $yetki['siparis'] == '1' && $yetki['siparis_yonet'] == '1') {
    $headerOrderCheckTotal = $db->prepare("select * from siparisler where yeni=:yeni and onay=:onay ");
    $headerOrderCheckTotal->execute(array(
        'yeni' => '1',
        'onay' => '1',
    ));
    $headerOrderCheck = $db->prepare("select * from siparisler where yeni=:yeni and onay=:onay order by id desc limit 5 ");
    $headerOrderCheck->execute(array(
        'yeni' => '1',
        'onay' => '1',
    ));
    ?>
    <!-- Siparişler !-->
    <li class="list-inline-item dropdown notification-list  d-none d-lg-inline-block">
        <a class="nav-link dropdown-toggle arrow-none waves-effect" data-toggle="dropdown" href="#" role="button"
           aria-haspopup="false" aria-expanded="false">
            <i class="mdi mdi-shopping noti-icon"></i>
            <?php if($headerOrderCheckTotal->rowCount()>'0'  ) {?>
                <span class="badge  badge-pill noti-icon-badge"><?=$headerOrderCheckTotal->rowCount()?></span>
            <?php }?>
        </a>
        <div class="dropdown-menu dropdown-menu-right dropdown-arrow dropdown-menu-lg dropdown-menu-animated">
            <!-- item-->
            <div class="dropdown-item noti-title" style=" border-bottom: 1px solid #EBEBEB !important;">
                <h5><?=$diller['adminpanel-text-26']?></h5>
            </div>
            <div class="slimscroll-noti">
                <?php if($headerOrderCheck->rowCount()<='0') {?>
                    <div class="card mb-0" >
                        <div class="card-body">
                            <?=$diller['adminpanel-text-28']?>
                        </div>
                    </div>
                <?php }?>
                <?php foreach ($headerOrderCheck as $headOrderRow) {?>
                    <a href="pages.php?page=order_detail&orderID=<?=$headOrderRow['siparis_no']?>" class="dropdown-item notify-item border-bottom active">
                        <div class="notify-icon bg-primary"><i class="fa fa-shopping-basket"></i></div>
                        <span style="font-size: 11px ;" class="text-white bg-primary rounded pl-1 pr-1"><?=$diller['adminpanel-text-30']?></span>
                        <p class="notify-details"><b>#<?=$headOrderRow['siparis_no']?> <i class="fa fa-arrow-right"></i> <?=$diller['adminpanel-text-27']?></b><span class="text-muted"><?php echo date_tr('j F Y, H:i ', ''.$headOrderRow['siparis_tarih'].''); ?></span></p>
                    </a>
                <?php }?>
            </div>
            <!-- All-->
            <a href="pages.php?page=orders" class="dropdown-item bg-primary notify-all font-12 text-center text-white">
                <?=$diller['adminpanel-text-16']?>
            </a>
        </div>
    </li>
    <!--  <========SON=========>>> Siparişler SON !-->
<?php }?>

<?php if($odemeRow['siparis_iptal'] == '1' && $panelayar['header_iptal'] == '1'  && $yetki['siparis'] == '1' && $yetki['siparis_yonet'] == '1' ) {
    $iptaltalepCheckTotal = $db->prepare("select * from siparis_iptal where yeni=:yeni ");
    $iptaltalepCheckTotal->execute(array(
        'yeni' => '1',
    ));
    $iptaltalepCheck = $db->prepare("select * from siparis_iptal where yeni=:yeni order by id desc limit 5 ");
    $iptaltalepCheck->execute(array(
        'yeni' => '1',
    ));
    ?>
    <!-- İptal Talepleri !-->
    <li class="list-inline-item dropdown notification-list  d-none d-lg-inline-block">
        <a class="nav-link dropdown-toggle arrow-none waves-effect" data-toggle="dropdown" href="#" role="button"
           aria-haspopup="false" aria-expanded="false">
            <i class="mdi mdi-cancel noti-icon"></i>
            <?php if($iptaltalepCheckTotal->rowCount()>'0'  ) {?>
                <span class="badge  badge-pill noti-icon-badge"><?=$iptaltalepCheckTotal->rowCount()?></span>
            <?php }?>
        </a>
        <div class="dropdown-menu dropdown-menu-right dropdown-arrow dropdown-menu-lg dropdown-menu-animated">
            <!-- item-->
            <div class="dropdown-item noti-title" style=" border-bottom: 1px solid #EBEBEB !important;">
                <h5><?=$diller['adminpanel-text-29']?></h5>
            </div>
            <div class="slimscroll-noti">
                <?php if($iptaltalepCheck->rowCount()>'0'  ) {?>
                    <?php foreach ($iptaltalepCheck as $HeadiptalRow) {?>
                        <a href="pages.php?page=order_detail&orderID=<?=$HeadiptalRow['siparis_no']?>" class="dropdown-item notify-item active border-bottom">
                            <div class="notify-icon bg-dark"><i class="fa fa-ban"></i></div>
                            <p class="notify-details"><b><?=$diller['adminpanel-text-32']?></b><span class="text-muted"><?php echo date_tr('j F Y, H:i ', ''.$HeadiptalRow['tarih'].''); ?></span></p>
                        </a>
                    <?php }?>
                <?php }else { ?>
                    <div class="card mb-0" >
                        <div class="card-body">
                            <?=$diller['adminpanel-text-31']?>
                        </div>
                    </div>
                <?php }?>
            </div>
            <!-- All-->
            <a href="pages.php?page=order_cancel" class="dropdown-item bg-primary notify-all font-12 text-center text-white">
                <?=$diller['adminpanel-text-16']?>
            </a>
        </div>
    </li>
    <!--  <========SON=========>>> İptal Talepleri SON !-->
<?php }?>

<?php if($odemeRow['siparis_urun_iade'] == '1' && $panelayar['header_iade'] == '1' && $yetki['siparis'] == '1' && $yetki['siparis_yonet'] == '1') {
    $iadeTalepCheckTotal = $db->prepare("select * from siparis_urunler_iade where yeni=:yeni  ");
    $iadeTalepCheckTotal->execute(array(
        'yeni' => '1',
    ));
    $iadeTalepCheck = $db->prepare("select * from siparis_urunler_iade where yeni=:yeni order by id desc limit 5 ");
    $iadeTalepCheck->execute(array(
        'yeni' => '1',
    ));
    ?>
    <!-- Ürün İade Talepleri !-->
    <li class="list-inline-item dropdown notification-list  d-none d-lg-inline-block">
        <a class="nav-link dropdown-toggle arrow-none waves-effect" data-toggle="dropdown" href="#" role="button"
           aria-haspopup="false" aria-expanded="false">
            <i class="mdi mdi-recycle noti-icon"></i>
            <?php if($iadeTalepCheckTotal->rowCount()>'0'  ) {?>
                <span class="badge  badge-pill noti-icon-badge"><?=$iadeTalepCheckTotal->rowCount()?></span>
            <?php }?>
        </a>
        <div class="dropdown-menu dropdown-menu-right dropdown-arrow dropdown-menu-lg dropdown-menu-animated">
            <!-- item-->
            <div class="dropdown-item noti-title" style=" border-bottom: 1px solid #EBEBEB !important;">
                <h5><?=$diller['adminpanel-text-33']?></h5>
            </div>
            <div class="slimscroll-noti">
                <?php if($iadeTalepCheck->rowCount()>'0'  ) {?>
                    <?php foreach ($iadeTalepCheck as $headiadeRow) {?>
                        <a href="pages.php?page=product_return&no=<?=$headiadeRow['talep_no']?>" class="dropdown-item notify-item active border-bottom">
                            <div class="notify-icon bg-pink"><i class="fa fa-recycle"></i></div>
                            <p class="notify-details"><b><?=$diller['adminpanel-text-35']?></b><span class="text-muted"><?php echo date_tr('j F Y, H:i ', ''.$headiadeRow['tarih'].''); ?></span></p>
                        </a>
                    <?php }?>
                <?php }else { ?>
                    <div class="card mb-0" >
                        <div class="card-body">
                            <?=$diller['adminpanel-text-34']?>
                        </div>
                    </div>
                <?php }?>
            </div>
            <!-- All-->
            <a href="pages.php?page=order_product_return" class="dropdown-item bg-primary notify-all font-12 text-center text-white">
                <?=$diller['adminpanel-text-16']?>
            </a>
        </div>
    </li>
    <!--  <========SON=========>>> Ürün İade Talepleri SON !-->
<?php } ?>

<?php if($panelayar['header_ticket'] == '1' && $yetki['uyelik'] == '1'  && $yetki['ticket'] == '1' ) {
    $TicketCheckHeadTotal = $db->prepare("select * from destek_talebi where durum=:durum");
    $TicketCheckHeadTotal->execute(array(
        'durum' => '0'
    ));
    $TicketCheckHead = $db->prepare("select * from destek_talebi where durum=:durum order by son_islem desc limit 5 ");
    $TicketCheckHead->execute(array(
        'durum' => '0'
    ));
    ?>
    <!-- Destek Bildirimleri !-->
    <li class="list-inline-item dropdown notification-list  d-none d-lg-inline-block">
        <a class="nav-link dropdown-toggle arrow-none waves-effect" data-toggle="dropdown" href="#" role="button"
           aria-haspopup="false" aria-expanded="false">
            <i class="typcn typcn-ticket noti-icon"></i>
            <?php if($TicketCheckHeadTotal->rowCount()>'0'  ) {?>
                <span class="badge  badge-pill noti-icon-badge"><?=$TicketCheckHeadTotal->rowCount()?></span>
            <?php }?>
        </a>
        <div class="dropdown-menu dropdown-menu-right dropdown-arrow dropdown-menu-lg dropdown-menu-animated">
            <!-- item-->
            <div class="dropdown-item noti-title"  style=" border-bottom: 1px solid #EBEBEB !important;">
                <h5><?=$diller['adminpanel-text-36']?></h5>
            </div>
            <div class="slimscroll-noti">
                <?php if($TicketCheckHead->rowCount()>'0'  ) {?>
                    <?php foreach ($TicketCheckHead as $headTicketRow) {?>
                        <a href="pages.php?page=ticket_detail&ticketID=<?=$headTicketRow['destek_no']?>" class="dropdown-item notify-item active  border-bottom">
                            <div class="notify-icon bg-success"><i class="fa fa-ticket-alt"></i></div>
                            <?php if($headTicketRow['yeni'] =='1' ) {?>
                                <span style="font-size: 11px ;" class="text-white bg-success rounded pl-1 pr-1"><?=$diller['adminpanel-text-39']?></span>
                            <?php }else { ?>
                                <span style="font-size: 11px ;" class="text-white bg-pink rounded pl-1 pr-1"><?=$diller['adminpanel-text-40']?></span>
                            <?php }?>
                            <p class="notify-details"><b>#<?=$headTicketRow['destek_no']?> <i class="fa fa-arrow-right"></i> <?=$diller['adminpanel-text-38']?></b><span class="text-muted"><?php echo date_tr('j F Y, H:i ', ''.$headTicketRow['son_islem'].''); ?></span></p>
                        </a>
                    <?php }?>
                <?php }else { ?>
                    <div class="card mb-0" >
                        <div class="card-body">
                            <?=$diller['adminpanel-text-37']?>
                        </div>
                    </div>
                <?php }?>
            </div>
            <!-- All-->
            <a href="pages.php?page=tickets" class="dropdown-item bg-primary notify-all font-12 text-center text-white">
                <?=$diller['adminpanel-text-16']?>
            </a>
        </div>
    </li>
    <!--  <========SON=========>>> Destek Bildirimleri SON !-->
<?php }?>

<?php if($panelayar['header_comment'] == '1' && $yetki['katalog'] == '1'  && $yetki['urun_yorum'] == '1' ) {
    $urunYorumHeadercheckTotal = $db->prepare("select * from urun_yorum where onay=:onay");
    $urunYorumHeadercheckTotal->execute(array(
        'onay' => '0',
    ));
    $urunYorumHeadercheck = $db->prepare("select * from urun_yorum where onay=:onay order by id desc limit 5 ");
    $urunYorumHeadercheck->execute(array(
        'onay' => '0',
    ));
    ?>
    <!-- Ürün Yorumları !-->
    <li class="list-inline-item dropdown notification-list  d-none d-lg-inline-block">
        <a class="nav-link dropdown-toggle arrow-none waves-effect" data-toggle="dropdown" href="#" role="button"
           aria-haspopup="false" aria-expanded="false">
            <i class="mdi mdi-comment-processing noti-icon"></i>
            <?php if($urunYorumHeadercheckTotal->rowCount()>'0'  ) {?>
                <span class="badge  badge-pill noti-icon-badge"><?=$urunYorumHeadercheckTotal->rowCount()?></span>
            <?php }?>
        </a>
        <div class="dropdown-menu dropdown-menu-right dropdown-arrow dropdown-menu-lg dropdown-menu-animated">
            <!-- item-->
            <div class="dropdown-item noti-title" style=" border-bottom: 1px solid #EBEBEB !important;">
                <h5><?=$diller['adminpanel-text-41']?></h5>
            </div>
            <div class="slimscroll-noti">
                <?php if($urunYorumHeadercheck->rowCount()>'0'  ) {?>
                    <?php foreach ($urunYorumHeadercheck as $ehadurunRow) {?>
                        <a href="pages.php?page=products_comments" class="dropdown-item notify-item active  border-bottom">
                            <div class="notify-icon bg-warning text-dark"><i class="fa fa-comment-alt"></i></div>
                            <p class="notify-details"><b><?=$diller['adminpanel-text-43']?></b><span class="text-muted"><?php echo date_tr('j F Y, H:i ', ''.$ehadurunRow['tarih'].''); ?></span></p>
                        </a>
                    <?php }?>
                <?php }else { ?>
                    <div class="card mb-0" >
                        <div class="card-body">
                            <?=$diller['adminpanel-text-42']?>
                        </div>
                    </div>
                <?php }?>
            </div>
            <!-- All-->
            <a href="pages.php?page=products_comments" class="dropdown-item bg-primary notify-all font-12 text-center text-white">
                <?=$diller['adminpanel-text-16']?>
            </a>
        </div>
    </li>
    <!--  <========SON=========>>> Ürün Yorumları SON !-->
<?php } ?>

<?php if($panelayar['header_inbox'] == '1'  && $yetki['gelenkutusu'] == '1') {
    $inboxHeadCheckTotal = $db->prepare("select * from mesaj where durum=:durum  ");
    $inboxHeadCheckTotal->execute(array(
        'durum' => '1',
    ));
    $inboxHeadCheck = $db->prepare("select * from mesaj where durum=:durum order by id desc limit 5 ");
    $inboxHeadCheck->execute(array(
        'durum' => '1',
    ));
    ?>
    <!-- Gleen Kutusu Talepleri !-->
    <li class="list-inline-item dropdown notification-list">
        <a class="nav-link dropdown-toggle arrow-none waves-effect" data-toggle="dropdown" href="#" role="button"
           aria-haspopup="false" aria-expanded="false">
            <i class="mdi mdi-email noti-icon"></i>
            <?php if($inboxHeadCheckTotal->rowCount()>'0'  ) {?>
                <span class="badge  badge-pill noti-icon-badge"><?=$inboxHeadCheckTotal->rowCount()?></span>
            <?php }?>
        </a>
        <div class="dropdown-menu dropdown-menu-right dropdown-arrow dropdown-menu-lg dropdown-menu-animated">
            <!-- item-->
            <div class="dropdown-item noti-title" style=" border-bottom: 1px solid #EBEBEB !important;">
                <h5><?=$diller['adminpanel-text-44']?></h5>
            </div>
            <div class="slimscroll-noti">
                <?php if($inboxHeadCheck->rowCount()>'0'  ) {?>
                    <?php foreach ($inboxHeadCheck as $inboxRow) {?>
                        <a href="pages.php?page=inbox_detail&messageID=<?=$inboxRow['id']?>" class="dropdown-item notify-item active border-bottom">
                            <div class="notify-icon bg-info"><i class="fa fa-envelope-open"></i></div>
                            <p class="notify-details"><b><?=$diller['adminpanel-text-46']?></b>
                                <span class="text-dark "><i class="fa fa-reply-all" style="font-size: 10px ;"></i> <?=$inboxRow['isim']?></span>
                                <span class="text-muted"><?php echo date_tr('j F Y, l ', ''.$inboxRow['tarih'].''); ?></span>
                            </p>
                        </a>
                    <?php }?>
                <?php }else {?>
                    <div class="card mb-0" >
                        <div class="card-body">
                            <?=$diller['adminpanel-text-45']?>
                        </div>
                    </div>
                <?php }?>
            </div>
            <!-- All-->
            <a href="pages.php?page=inbox" class="dropdown-item bg-primary notify-all font-12 text-center text-white">
                <?=$diller['adminpanel-text-16']?>
            </a>
        </div>
    </li>
    <!--  <========SON=========>>> Gleen Kutusu Talepleri SON !-->
<?php } ?>