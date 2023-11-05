<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php if($_GET['page'] !='n11_process_post'  ) {?>
<div class="header-bg">
    <!-- Navigation Bar-->
    <header id="topnav">
        <div class="topbar-main" style=" position: relative; font-size:0">
            <div class="container-fluid">

                <!-- Logo-->
                <div>
                    <a href="<?=$ayar['panel_url']?>" class="logo ">
                        <img src="assets/images/<?=$panelayar['panel_logo']?>" alt="" height="26">
                    </a>
                </div>
                <!-- End Logo-->

                <div class="menu-extras topbar-custom navbar p-0">

                    <ul class="list-inline d-none d-lg-block mb-0">

                        <?php if($panelayar['shortlink'] == '1' && $yetki['kisayol_ekle'] == '1'  ) {?>
                        <!-- Kısa yollar !-->
                        <?php
                        $kisaYollarCek = $db->prepare("select * from panel_kisayol where dil=:dil and durum=:durum and admin_id=:admin_id order by sira asc ");
                        $kisaYollarCek->execute(array(
                            'dil' => $_SESSION['dil'],
                            'durum' => '1',
                            'admin_id' => $adminRow['id'],
                        ));
                        ?>

                            <li class="list-inline-item dropdown notification-list">
                                <a class="nav-link dropdown-toggle arrow-none waves-effect" data-toggle="dropdown" href="#" role="button"
                                   aria-haspopup="false" aria-expanded="false">
                                    <?=$diller['adminpanel-text-1']?> <i class="mdi mdi-chevron-down"></i>
                                </a>
                                <div class="dropdown-menu  dropdown-menu-animated">
                                    <?php if($kisaYollarCek->rowCount()<='0'  ) {?>
                                        <a class="dropdown-item mt-2" href="javascript:Void(0)">
                                            <?=$diller['adminpanel-text-263']?>
                                        </a>
                                    <?php }?>
                                    <?php foreach ($kisaYollarCek as $kisayol) {?>
                                        <a class="dropdown-item" href="<?=$kisayol['adres_url']?>"><?=$kisayol['baslik']?></a>
                                    <?php }?>
                                    <?php if($yetki['kisayol_ekle'] == '1' ) {?>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="pages.php?page=shortlinks"><?=$diller['adminpanel-text-2']?></a>
                                    <?php } ?>
                                </div>
                            </li>
                        <!--  <========SON=========>>> Kısa yollar SON !-->
                        <?php }?>

                    <!-- Dil Seçimleri !-->
                        <?php
                        $headerLangSelect = $db->prepare("select * from dil where durum=:durum order by sira asc ");
                        $headerLangSelect->execute(array(
                            'durum' => '1',
                        ));
                        ?>
                        <li class="list-inline-item dropdown notification-list nav-user">
                            <a class="nav-link dropdown-toggle arrow-none waves-effect" data-toggle="dropdown" href="#" role="button"
                               aria-haspopup="false" aria-expanded="false" >
                                <div class="flag-icon-<?=$mevcutdil['flag']?>" style="width:18px; height:13px; display: inline-block; vertical-align: middle"></div> <?=$mevcutdil['baslik']?> <i class="mdi mdi-chevron-down"></i>
                            </a>
                            <div class="dropdown-menu  dropdown-menu-animated">
                                <?php foreach ($headerLangSelect as $headlangRow) {?>
                                    <a data-code="<?=$headlangRow['kisa_ad']?>" class="dropdown-item language-change" href="#"><?=$headlangRow['baslik']?></a>
                                <?php }?>
                                <?php if($yetki['site_ayarlar'] == '1' && $yetki['dil_yonet']) {?>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="pages.php?page=languages"><?=$diller['adminpanel-text-3']?></a>
                                <?php } ?>
                            </div>
                        </li>
                    <!--  <========SON=========>>> Dil Seçimleri SON !-->
                    </ul>

                    <ul class="list-inline ml-auto mb-0">

                        <?php if($panelayar['header_cache'] == '1' && $yetki['ayar_diger'] == '1' && $yetki['site_ayarlar'] == '1') {?>
                            <!-- Önbellekj Temizle !-->
                            <li class="list-inline-item dropdown notification-list  d-none d-lg-inline-block">
                                <a class="nav-link dropdown-toggle arrow-none waves-effect" data-toggle="dropdown" href="#" role="button"
                                   aria-haspopup="false" aria-expanded="false">
                                    <i class="mdi mdi-refresh noti-icon"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-arrow dropdown-menu-lg dropdown-menu-animated">
                                    <div>
                                        <!-- item-->
                                        <a href="post.php?process=cache_clear&cache=trash" class="dropdown-item notify-item ">
                                            <div class="notify-icon bg-white border text-dark noti-icon"><i class="mdi mdi-refresh"></i></div>
                                            <p class="notify-details"><b><?=$diller['adminpanel-text-4']?></b><span class="text-muted"><?=$diller['adminpanel-text-5']?></span></p>
                                        </a>
                                    </div>
                                    <!-- All-->
                                    <a href="pages.php?page=cache_settings" class="dropdown-item notify-all  font-12">
                                        <?=$diller['adminpanel-text-6']?>
                                    </a>
                                </div>
                            </li>
                            <!--  <========SON=========>>> Önbellekj Temizle SON !-->
                        <?php }?>
                        <?php
                        $headerLangSelectMobile = $db->prepare("select * from dil where durum=:durum order by sira asc ");
                        $headerLangSelectMobile->execute(array(
                            'durum' => '1',
                        ));
                        ?>
                        <li class="list-inline-item dropdown notification-list d-sm-inline-block d-md-none">
                            <a class="nav-link dropdown-toggle arrow-none waves-effect" data-toggle="dropdown" href="#" role="button"
                               aria-haspopup="false" aria-expanded="false">
                                <i class="ti-world  noti-icon"></i>
                            </a>
                            <div class="dropdown-menu  dropdown-menu-animated">
                                <?php foreach ($headerLangSelectMobile as $headlangRow2) {?>
                                    <a data-code="<?=$headlangRow2['kisa_ad']?>" class="dropdown-item language-change" href="#"><?=$headlangRow2['baslik']?></a>
                                <?php }?>
                                <?php if($yetki['site_ayarlar'] == '1' && $yetki['dil_yonet']) {?>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="pages.php?page=languages"><?=$diller['adminpanel-text-3']?></a>
                                <?php } ?>
                            </div>
                        </li>

                        <div id="count-noti" style="display: inline-block"></div>

                        <!-- User-->
                        <li class="list-inline-item dropdown notification-list nav-user">
                            <a class="nav-link dropdown-toggle arrow-none waves-effect" data-toggle="dropdown" href="#" role="button"
                               aria-haspopup="false" aria-expanded="false">
                                <i class="ion ion-md-person  noti-icon d-sm-inline-block d-md-none"></i>
                                <span class="d-none d-md-inline-block ml-1"><?=$diller['adminpanel-text-7']?> <i class="mdi mdi-chevron-down"></i> </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated profile-dropdown">

                                <div class="dropdown-item" style="font-weight: 600; text-align: center;">
                                    <?php if($adminRow['foto'] == !null ) {?>
                                        <img src="assets/images/uploads/<?=$adminRow['foto']?>" alt="user" class="rounded-circle d-none d-md-inline-block" style="width: 50px; height: 50px; margin-bottom: 15px;">
                                        <br>
                                    <?php }?>
                                    <?=$diller['adminpanel-text-8']?> <?=$adminRow['isim']?>
                                </div>
                                <div class=" p-2 pl-3 border border-right-0 border-left-0 mt-2 mb-2 bg-light">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="customSwitch1" <?php if($adminRow['sound'] == '1' ) { ?>checked<?php }?>>
                                            <?php if($adminRow['sound'] == '0' ) {?>
                                                <label class="custom-control-label" for="customSwitch1"  onclick="javascript:window.location='post.php?process=bell_sound_switch&change=1&bell=success'" style="padding-top: 2px !important; font-weight: 400 !important;"><?=$diller['adminpanel-text-111']?></label>
                                            <?php }?>
                                            <?php if($adminRow['sound'] == '1' ) {?>
                                                <label class="custom-control-label" for="customSwitch1"   onclick="javascript:window.location='post.php?process=bell_sound_switch&change=0&bell=success'" style="padding-top: 2px !important; font-weight: 400 !important;"><?=$diller['adminpanel-text-111']?></label>
                                            <?php }?>
                                        </div>
                                </div>
                                <a class="dropdown-item" href="pages.php?page=my_account"><i class="dripicons-user text-muted"></i>  <?=$diller['adminpanel-text-9']?></a>
                                    <a class="dropdown-item" href="pages.php?page=account_log"><i class="dripicons-wallet text-muted"></i>  <?=$diller['adminpanel-text-10']?></a>
                                <a class="dropdown-item" href="pages.php?page=password_change"><i class="ion ion-md-key text-muted"></i>  <?=$diller['adminpanel-text-11']?></a>
                                <a class="dropdown-item" href="pages.php?page=todo_list">
                                    <i class="mdi mdi-playlist-check text-muted"></i>  <?=$diller['adminpanel-text-10-2']?>
                                </a>
                                <?php if($yetki['gelenkutusu'] == '1' ) {
                                    $mesajSorgu = $db->prepare("select id from mesaj where durum='1' ");
                                    $mesajSorgu->execute();
                                    ?>
                                    <a class="dropdown-item d-flex align-items-center justify-content-between" href="pages.php?page=inbox">
                                        <div><i class="mdi mdi-email-outline text-muted"></i>  <?=$diller['adminpanel-text-210']?></div> <div class="badge badge-danger "><?=$mesajSorgu->rowCount()?></div>
                                    </a>
                                <?php }?>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="<?=$ayar['site_url']?>" target="_blank"><i class="dripicons-store text-muted"></i>  <?=$diller['adminpanel-text-13']?></a>
                                <a class="dropdown-item" href="logout/"><i class="dripicons-exit text-muted"></i>   <?=$diller['adminpanel-text-14']?></a>
                            </div>
                        </li>
                        <li class="menu-item list-inline-item">
                            <!-- Mobile menu toggle-->
                            <a class="navbar-toggle nav-link">
                                <div class="lines">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </div>
                            </a>
                            <!-- End mobile menu toggle-->
                        </li>

                    </ul>

                </div>
                <!-- end menu-extras -->

                <div class="clearfix"></div>

            </div> <!-- end container -->
        </div>
        <!-- end topbar-main -->

        <!-- MENU Start -->
       <?php include 'inc/template/header_items.php'; ?>
    </header>
    <!-- End Navigation Bar-->

</div>
<!-- header-bg -->

    <style>
        .dropdown-overlay-show{
            background-color: rgba(0,0,0,<?=$panelayar['headermenu_overlay_op']?>);
        }
    </style>
    <div class="dropdown-overlay-show "></div>
    <script>
        $(function() {
            $('.dropdown-sub-have').hover(function() {
                $('.dropdown-overlay-show').show();
            }, function() {
                $('.dropdown-overlay-show').hide();
            });
        });
    </script>
<?php if($panelayar['fixed_header'] == '1' ) {?>
    <style>
        #fixed-header-main{
            position:fixed;
            display:none;
            width:100%;
            z-index:9;
            top: 0;
            left: 0;
        }
    </style>
    <div id="fixed-header-main" >
        <header id="topnav" >
            <?php include 'inc/template/header_items.php'; ?>
        </header>
    </div>

<?php }?>


<?php }?>
