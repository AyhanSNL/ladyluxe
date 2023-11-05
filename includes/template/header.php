<?php
echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;
?> <?php
$headerAyar = $db->prepare("select * from header_ayar where id=:id ");
$headerAyar->execute(array(
    'id' => '1'
));
$head              = $headerAyar->fetch(PDO::FETCH_ASSOC);
$headProductLimit  = $head['dropdown_menu_product_limit'];
$sosyalBaglantilar = $db->prepare("select * from sosyal where header=:header order by sira asc ");
$sosyalBaglantilar->execute(array(
    'header' => '1'
));
$sosyalBaglantilar_fixed = $db->prepare("select * from sosyal where header=:header order by sira asc ");
$sosyalBaglantilar_fixed->execute(array(
    'header' => '1'
));
$fixedmenu = $db->prepare("select * from sabit_header where id=:id ");
$fixedmenu->execute(array(
    'id' => '1'
));
$fx          = $fixedmenu->fetch(PDO::FETCH_ASSOC);
$sitelsonuc  = $ayar['site_tel'];
$sitelsonuc  = str_replace(' ', '', $sitelsonuc);
$topHeadHTML = $db->prepare("select * from headertop_html where dil=:dil and durum=:durum order by id desc limit 1 ");
$topHeadHTML->execute(array(
    'dil' => $_SESSION['dil'],
    'durum' => '1'
));
$tophtmlRow = $topHeadHTML->fetch(PDO::FETCH_ASSOC);
$dropDown   = $db->prepare("select * from haeder_dropdown where id=:id ");
$dropDown->execute(array(
    'id' => '1'
));
$drop = $dropDown->fetch(PDO::FETCH_ASSOC);
?><div class="header-main-div" style="background-color: #<?= $head['header_bg'] ?>; font-family : '<?= $head['font_select'] ?>',Sans-serif ;"><?php
if (isMobileDevice()) {
?><!-- Mobile/Tablet Header !--><div class="header-mobile-view"><?php
    include 'includes/template/header_items/mobile_menu.php';
?></div><!-- Mobile/Tablet Header SON !--><?php
} else {
?><div class="desktop-header-area"><?php
    if ($tophtmlRow['durum'] == '1' && $tophtmlRow['icerik'] == !null) {
?><!-- TopHtml !--><style> .topheader-html-main-in p{margin-bottom: 0;}</style><div class="topheader-html-main" id="headBar"><div class="topheader-html-main-in"><?php
        $content = $tophtmlRow['icerik'];
        $eski    = "../i/";
        $yeni    = "i/";
        $content = str_replace($eski, $yeni, $content);
?> <?= $content ?><div class="topheader-html-close" href="javascript:void(0)" onclick="Hide(headBar);" ><i class="fa fa-times"></i></div></div></div><!--  <========SON=========>>> TopHtml SON !--><?php
    }
?> <?php
    if ($head['topheader'] == '1') {
?><!-- TopHeader !--><div class="topheader-desktop-main-div" style="border-top: 1px solid #<?= $head['topheader_border'] ?>;"><div class="topheader-desktop-main-div-in"><div class="topheader-desktop-main-left"><?php
        $topHEaderLink_left = $db->prepare("select url,ikon,spot,yeni_sekme,baslik from headertop_menu where durum=:durum and dil=:dil and area=:area order by sira asc ");
        $topHEaderLink_left->execute(array(
            'durum' => '1',
            'dil' => $_SESSION['dil'],
            'area' => '1'
        ));
?> <?php
        foreach ($topHEaderLink_left as $topleftRow) {
?><a <?php
            if ($topleftRow['url'] == !null) {
?>href="<?= $topleftRow['url'] ?>"<?php
            } else {
?>href="javascript:void(0)"<?php
            }
?> title="<?= $topleftRow['spot'] ?>" <?php
            if ($topleftRow['yeni_sekme'] == '1' && $topleftRow['url'] == !null) {
?>target="_blank" <?php
            }
?>><?php
            if ($topleftRow['ikon'] == !null) {
?><i class="<?= $topleftRow['ikon'] ?>"></i><?php
            }
?> <?= $topleftRow['baslik'] ?></a><?php
        }
?></div><div class="topheader-desktop-main-right"><?php
        $topHEaderLink_right = $db->prepare("select url,ikon,spot,yeni_sekme,baslik from headertop_menu where durum=:durum and dil=:dil and area=:area order by sira asc ");
        $topHEaderLink_right->execute(array(
            'durum' => '1',
            'dil' => $_SESSION['dil'],
            'area' => '2'
        ));
?> <?php
        foreach ($topHEaderLink_right as $topRightRow) {
?><a <?php
            if ($topRightRow['url'] == !null) {
?>href="<?= $topRightRow['url'] ?>"<?php
            } else {
?>href="javascript:void(0)"<?php
            }
?> title="<?= $topRightRow['spot'] ?>" <?php
            if ($topRightRow['yeni_sekme'] == '1' && $topRightRow['url'] == !null) {
?>target="_blank" <?php
            }
?>><?php
            if ($topRightRow['ikon'] == !null) {
?><i class="<?= $topRightRow['ikon'] ?>"></i><?php
            }
?> <?= $topRightRow['baslik'] ?></a><?php
        }
?><!-- Kur Seçimi !--><?php
        if ($head['topheader_kur'] == '1') {
            $MevcutKurcek = $db->prepare("select * from para_birimleri where kod=:kod and durum=:durum");
            $MevcutKurcek->execute(array(
                'kod' => $_SESSION['current_kur'],
                'durum' => '1'
            ));
            $secilikur = $MevcutKurcek->fetch(PDO::FETCH_ASSOC);
?><div class="topheader-lang-currency-box" <?php
            if ($head['topheader_dil'] == '0') {
?>style="border-right: 1px solid #<?= $head['topheader_border'] ?>;" <?php
            }
?>><a href="#"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?= $_SESSION['current_kur'] ?> <?= $secilikur['sol_simge'] ?><i class="ion-arrow-down-b"></i></a><!-- Currency DropDown !--><div class="dropdown-menu dropdown-menu-right currency-drop"><?php
            foreach ($kurSirala as $kurlar) {
?><a href="" class="currency-change" data-code="<?php
                echo $kurlar['kod'];
?>" <?php
                if ($secilikur['id'] == $kurlar['id']) {
?>style="font-weight: bold!important;"<?php
                }
?>><?php
                echo $kurlar['sol_simge'];
?> <?php
                echo $kurlar['baslik'];
?></a><?php
            }
?></div><!--  <========SON=========>>> Currency DropDown SON !--></div><?php
        }
?><!--  <========SON=========>>> Kur Seçimi SON !--><!-- Dil Seçimi !--><?php
        if ($head['topheader_dil'] == '1') {
            $flagsecim = $db->prepare("select * from dil where kisa_ad='$_SESSION[dil]'");
            $flagsecim->execute();
            $fl             = $flagsecim->fetch(PDO::FETCH_ASSOC);
            $headerLanguage = $db->prepare("select * from dil where durum=:durum order by sira asc");
            $headerLanguage->execute(array(
                'durum' => '1'
            ));
?><div class="topheader-lang-currency-box" style="border-right: 1px solid #<?= $head['topheader_border'] ?>; <?php
            if ($head['topheader_kur'] == '0') {
?>margin-left: 10px !important;<?php
            }
?>"><a href="#"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><div class="flag-icon-<?php
            echo $fl['flag'];
?>" style="width:16px; height:12px; margin-right: 5px; "></div><?php
            echo $fl['baslik'];
?><i class="ion-arrow-down-b"></i></a><!-- Language Change DropDown !--><div class="dropdown-menu dropdown-menu-right currency-drop"><?php
            foreach ($headerLanguage as $headLang) {
?><a href="#" class="language-change" data-code="<?= $headLang['kisa_ad'] ?>" <?php
                if ($headLang['kisa_ad'] == $_SESSION['dil']) {
?>style="font-weight: bold!important;"<?php
                }
?>><div class="flag-icon-<?php
                echo $headLang['flag'];
?>" style="width:18px; height:13px; margin-right: 8px; "></div><?php
                echo $headLang['baslik'];
?></a><?php
            }
?></div><!--  <========SON=========>>> Language Change DropDown SON !--></div><?php
        }
?><!--  <========SON=========>>> Dil Seçimi SON !--></div></div></div><!--  <========SON=========>>> TopHeader SON !--><?php
    }
?><!-- Desktop/Masaüstü Header !--><div class="header-desktop-main-div"><div class="header-desktop-main-div-in"><!-- Logo !--><div class="header-desktop-logo-div"><a href="<?= $ayar['site_url'] ?>"><img src="images/logo/<?= $head['header_logo'] ?>" alt="<?= $ayar['site_baslik'] ?>"></a></div><!-- Logo SON !--><div class="header-desktop-right-area"><!-- Arama Button Tip 1 !--><?php
    if ($head['search_tip'] == '1' && $head['header_search'] == '1') {
?><div class="header-desktop-search1"><form action="arama/" method="get"><input type="hidden" name="s" value="1" ><input type="text" name="q" required placeholder="<?= $diller['header-arama-yazisi'] ?>" autocomplete="off"><button><img src="/i/iconmail/searchcon-kapali.svg"></button></form></div><?php
    }
?><!--  <========SON=========>>> Arama Button Tip 1 SON !--><!-- Çağrı Merkezi !--><?php
    if ($head['cagri_merkezi'] == '1' && $head['cagri_no'] == !null) {
        $cagriTel = $head['cagri_no'];
        $cagriTel = str_replace(' ', '', $cagriTel);
?><div class="header-desktop-call" style="margin-right: 30px; /* if ile kontrol sağla. Sağ taraftaki hiç bir buton yoksa kaldır */"><div class="header-desktop-call-i"><i class="las la-headset"></i></div><div class="header-desktop-call-t"><div class="header-desktop-call-t-1"><?= $diller['header-iletisim-text'] ?></div><div class="header-desktop-call-t-2"><a href="tel:<?= $cagriTel ?>"><?= $head['cagri_no'] ?></a></div></div></div><?php
    }
?><!--  <========SON=========>>> Çağrı Merkezi SON !--><!-- Search type 2 !--><?php
    if ($head['search_tip'] == '2') {
?><div class="header-desktop-navbutton-box"><a id="search-tip2-button" style=" cursor: pointer" <?php
        if ($head['header_text_status'] == '0') {
?>class="tooltip-bottom" data-tooltip="<?= $diller['header-text5'] ?>"<?php
        }
?>><img src="/i/iconmail/searchcon-kapali.svg"><?php
        if ($head['header_text_status'] == '1') {
?><div class="header-desktop-navbutton-box-t"><?= $diller['header-text5'] ?></div><?php
        }
?></a></div><?php
    }
?><!--  <========SON=========>>> Search type 2 SON !--><!-- Bell - Bildirimler !--><?php
    if ($head['header_bell'] == '1' && $bildirimayar['durum'] == '1') {
?><?php
        if ($bildirimayar['tur'] == '0') {
            $bildirimSorgu_limit = '10';
            $bellCekk            = $db->prepare("select * from bildirimler where dil=:dil and durum=:durum order by id desc limit $bildirimSorgu_limit");
            $bellCekk->execute(array(
                'dil' => $_SESSION['dil'],
                'durum' => '1'
            ));
?><div class="header-desktop-navbutton-box"><a href="#" <?php
            if ($head['header_text_status'] == '0') {
?>class="tooltip-bottom" data-tooltip="<?= $diller['header-text1'] ?>"<?php
            }
?> data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php
            if ($bellCountTotal + $bellCountTotalUser + $bellCountTotalUserID > '0') {
?><div class="header-desktop-navbutton-box-count <?= $head['count_bg'] ?>"><?= $bellCountTotal + $bellCountTotalUser + $bellCountTotalUserID ?></div><?php
            }
?><i class="las la-bell"></i><?php
            if ($head['header_text_status'] == '1') {
?><div class="header-desktop-navbutton-box-t"><?= $diller['header-text1'] ?></div><?php
            }
?></a><!-- Bell  Dropdown !--><div class="dropdown-menu dropdown-menu-right bell-drop"><div class="dropdown-bell-area"><?php
            if ($bellCountTotal + $bellCountTotalUser + $bellCountTotalUserID > '0') {
?><div class="dropdown-bell-header"><?= $diller['header-text1'] ?></div><div class="dropdown-bell-list dropdown-bell-overflow"><?php
                foreach ($bellCekk as $bells) {
                    if ($bells['tur'] == '0') {
                        /* everybOdy */
                        $ip            = $_SERVER["REMOTE_ADDR"];
                        $bellIPKontrol = $db->prepare("select * from bildirimler_ip where ip_adres=:ip_adres and bildirim_id=:bildirim_id ");
                        $bellIPKontrol->execute(array(
                            'ip_adres' => $ip,
                            'bildirim_id' => $bells['bildirim_id']
                        ));
                    }
                    if ($bells['tur'] == '1') {
                        /* just member */
                        $ip            = $_SERVER["REMOTE_ADDR"];
                        $bellIPKontrol = $db->prepare("select * from bildirimler_ip where uye_id=:uye_id and bildirim_id=:bildirim_id ");
                        $bellIPKontrol->execute(array(
                            'uye_id' => $userCek['id'],
                            'bildirim_id' => $bells['bildirim_id']
                        ));
                    }
                    if ($bells['tur'] == '2') {
                        /* just member USERID */
                        $ip            = $_SERVER["REMOTE_ADDR"];
                        $bellIPKontrol = $db->prepare("select * from bildirimler_ip where uye_id=:uye_id and bildirim_id=:bildirim_id ");
                        $bellIPKontrol->execute(array(
                            'uye_id' => $userCek['id'],
                            'bildirim_id' => $bells['bildirim_id']
                        ));
                    }
?><?php
                    if ($bells['tur'] == '0' && $bells['uye_id'] <= '0' && $bellIPKontrol->rowCount() <= '0') {
?><div class="dropdown-bell-list-box"><div class="dropdown-bell-list-box-h"><?php
                        if ($bells['ikon'] == !null) {
?><div class="dropdown-bell-list-box-h-icon"><?= $bells['ikon'] ?></div><?php
                        }
?><div class="dropdown-bell-list-box-baslik"><?php
                        if ($bells['icerik'] == !null) {
?><a href="bildirim/<?= seo($bells['baslik']) ?>-B<?= $bells['bildirim_id'] ?>"><?php
                        }
?> <?= $bells['baslik'] ?><?php
                        if ($bells['icerik'] == !null) {
?></a><?php
                        }
?> <?php
                        if ($bells['icerik'] == !null) {
?><div class="dropdown-bell-list-box-s"><?= $diller['header-text19'] ?></div><?php
                        }
?></div><div class="dropdown-bell-list-box-date"><?php
                        echo date_tr('j F Y', '' . $bells['tarih'] . '');
?></div></div></div><?php
                    }
?><?php
                    if ($bells['tur'] == '1' && $userSorgusu->rowCount() > '0' && $bellIPKontrol->rowCount() <= '0') {
?><div class="dropdown-bell-list-box"><div class="dropdown-bell-list-box-h"><?php
                        if ($bells['ikon'] == !null) {
?><div class="dropdown-bell-list-box-h-icon"><?= $bells['ikon'] ?></div><?php
                        }
?><div class="dropdown-bell-list-box-baslik"><?php
                        if ($bells['icerik'] == !null) {
?><a href="bildirim/<?= seo($bells['baslik']) ?>-B<?= $bells['bildirim_id'] ?>"><?php
                        }
?> <?= $bells['baslik'] ?><?php
                        if ($bells['icerik'] == !null) {
?></a><?php
                        }
?> <?php
                        if ($bells['icerik'] == !null) {
?><div class="dropdown-bell-list-box-s"><?= $diller['header-text19'] ?></div><?php
                        }
?></div><div class="dropdown-bell-list-box-date"><?php
                        echo date_tr('j F Y', '' . $bells['tarih'] . '');
?></div></div></div><?php
                    }
?><?php
                    if ($bells['tur'] == '2' && $bells['uye_id'] == $userCek['id'] && $bellIPKontrol->rowCount() <= '0') {
?><div class="dropdown-bell-list-box"><div class="dropdown-bell-list-box-h"><?php
                        if ($bells['ikon'] == !null) {
?><div class="dropdown-bell-list-box-h-icon"><?= $bells['ikon'] ?></div><?php
                        }
?><div class="dropdown-bell-list-box-baslik"><?php
                        if ($bells['icerik'] == !null) {
?><a href="bildirim/<?= seo($bells['baslik']) ?>-B<?= $bells['bildirim_id'] ?>"><?php
                        }
?> <?= $bells['baslik'] ?><?php
                        if ($bells['icerik'] == !null) {
?></a><?php
                        }
?> <?php
                        if ($bells['icerik'] == !null) {
?><div class="dropdown-bell-list-box-s"><?= $diller['header-text19'] ?></div><?php
                        }
?></div><div class="dropdown-bell-list-box-date"><?php
                        echo date_tr('j F Y', '' . $bells['tarih'] . '');
?></div></div></div><?php
                    }
?><?php
                }
?></div><?php
                if ($bellCekk->rowCount() > '5') {
?><div class="dropdown-bell-fullhref"><a href="bildirimler/"><?= $diller['header-text18'] ?></a></div><?php
                }
?><?php
            }
?> <?php
            if ($bellCountTotal + $bellCountTotalUser + $bellCountTotalUserID <= '0') {
?><div class="dropdown-bell-no"><i class="las la-bell-slash"></i><div class="dropdown-bell-no-t"><?= $diller['header-text21'] ?></div><div class="dropdown-bell-no-s"><?= $diller['header-text20'] ?></div></div><div class="dropdown-bell-fullhref"><a href="bildirimler/"><?= $diller['header-text18'] ?></a></div><?php
            }
?></div></div><!--  <========SON=========>>> Bell  Dropdown SON !--></div><?php
        }
?><?php
        if ($bildirimayar['tur'] == '1' && $userSorgusu->rowCount() > '0') {
            $bildirimSorgu_limit = '10';
            /* Bildirim Çek */
            $bellCekk            = $db->prepare("select * from bildirimler where dil=:dil and durum=:durum order by id desc limit $bildirimSorgu_limit");
            $bellCekk->execute(array(
                'dil' => $_SESSION['dil'],
                'durum' => '1'
            ));
            /*  <========SON=========>>> Bildirim Çek SON */
?><div class="header-desktop-navbutton-box"><a href="#" <?php
            if ($head['header_text_status'] == '0') {
?>class="tooltip-bottom" data-tooltip="<?= $diller['header-text1'] ?>"<?php
            }
?> data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php
            if ($bellCountTotal + $bellCountTotalUser + $bellCountTotalUserID > '0') {
?><div class="header-desktop-navbutton-box-count <?= $head['count_bg'] ?>"><?= $bellCountTotal + $bellCountTotalUser + $bellCountTotalUserID ?></div><?php
            }
?><i class="las la-bell"></i><?php
            if ($head['header_text_status'] == '1') {
?><div class="header-desktop-navbutton-box-t"><?= $diller['header-text1'] ?></div><?php
            }
?></a><!-- Bell  Dropdown !--><div class="dropdown-menu dropdown-menu-right bell-drop"><div class="dropdown-bell-area"><?php
            if ($bellCountTotal + $bellCountTotalUser + $bellCountTotalUserID > '0') {
?><div class="dropdown-bell-header"><?= $diller['header-text1'] ?></div><div class="dropdown-bell-list dropdown-bell-overflow"><?php
                foreach ($bellCekk as $bells) {
                    if ($bells['tur'] == '0') {
                        /* everybOdy */
                        $ip            = $_SERVER["REMOTE_ADDR"];
                        $bellIPKontrol = $db->prepare("select * from bildirimler_ip where ip_adres=:ip_adres and bildirim_id=:bildirim_id ");
                        $bellIPKontrol->execute(array(
                            'ip_adres' => $ip,
                            'bildirim_id' => $bells['bildirim_id']
                        ));
                    }
                    if ($bells['tur'] == '1') {
                        /* just member */
                        $ip            = $_SERVER["REMOTE_ADDR"];
                        $bellIPKontrol = $db->prepare("select * from bildirimler_ip where uye_id=:uye_id and bildirim_id=:bildirim_id ");
                        $bellIPKontrol->execute(array(
                            'uye_id' => $userCek['id'],
                            'bildirim_id' => $bells['bildirim_id']
                        ));
                    }
                    if ($bells['tur'] == '2') {
                        /* just member USERID */
                        $ip            = $_SERVER["REMOTE_ADDR"];
                        $bellIPKontrol = $db->prepare("select * from bildirimler_ip where uye_id=:uye_id and bildirim_id=:bildirim_id ");
                        $bellIPKontrol->execute(array(
                            'uye_id' => $userCek['id'],
                            'bildirim_id' => $bells['bildirim_id']
                        ));
                    }
?><?php
                    if ($bells['tur'] == '0' && $bells['uye_id'] <= '0' && $bellIPKontrol->rowCount() <= '0') {
?><div class="dropdown-bell-list-box"><div class="dropdown-bell-list-box-h"><?php
                        if ($bells['ikon'] == !null) {
?><div class="dropdown-bell-list-box-h-icon"><?= $bells['ikon'] ?></div><?php
                        }
?><div class="dropdown-bell-list-box-baslik"><?php
                        if ($bells['icerik'] == !null) {
?><a href="bildirim/<?= seo($bells['baslik']) ?>-B<?= $bells['bildirim_id'] ?>"><?php
                        }
?> <?= $bells['baslik'] ?><?php
                        if ($bells['icerik'] == !null) {
?></a><?php
                        }
?> <?php
                        if ($bells['icerik'] == !null) {
?><div class="dropdown-bell-list-box-s"><?= $diller['header-text19'] ?></div><?php
                        }
?></div><div class="dropdown-bell-list-box-date"><?php
                        echo date_tr('j F Y', '' . $bells['tarih'] . '');
?></div></div></div><?php
                    }
?><?php
                    if ($bells['tur'] == '1' && $userSorgusu->rowCount() > '0' && $bellIPKontrol->rowCount() <= '0') {
?><div class="dropdown-bell-list-box"><div class="dropdown-bell-list-box-h"><?php
                        if ($bells['ikon'] == !null) {
?><div class="dropdown-bell-list-box-h-icon"><?= $bells['ikon'] ?></div><?php
                        }
?><div class="dropdown-bell-list-box-baslik"><?php
                        if ($bells['icerik'] == !null) {
?><a href="bildirim/<?= seo($bells['baslik']) ?>-B<?= $bells['bildirim_id'] ?>"><?php
                        }
?> <?= $bells['baslik'] ?><?php
                        if ($bells['icerik'] == !null) {
?></a><?php
                        }
?> <?php
                        if ($bells['icerik'] == !null) {
?><div class="dropdown-bell-list-box-s"><?= $diller['header-text19'] ?></div><?php
                        }
?></div><div class="dropdown-bell-list-box-date"><?php
                        echo date_tr('j F Y', '' . $bells['tarih'] . '');
?></div></div></div><?php
                    }
?><?php
                    if ($bells['tur'] == '2' && $bells['uye_id'] == $userCek['id'] && $bellIPKontrol->rowCount() <= '0') {
?><div class="dropdown-bell-list-box"><div class="dropdown-bell-list-box-h"><?php
                        if ($bells['ikon'] == !null) {
?><div class="dropdown-bell-list-box-h-icon"><?= $bells['ikon'] ?></div><?php
                        }
?><div class="dropdown-bell-list-box-baslik"><?php
                        if ($bells['icerik'] == !null) {
?><a href="bildirim/<?= seo($bells['baslik']) ?>-B<?= $bells['bildirim_id'] ?>"><?php
                        }
?> <?= $bells['baslik'] ?><?php
                        if ($bells['icerik'] == !null) {
?></a><?php
                        }
?> <?php
                        if ($bells['icerik'] == !null) {
?><div class="dropdown-bell-list-box-s"><?= $diller['header-text19'] ?></div><?php
                        }
?></div><div class="dropdown-bell-list-box-date"><?php
                        echo date_tr('j F Y', '' . $bells['tarih'] . '');
?></div></div></div><?php
                    }
?><?php
                }
?></div><?php
                if ($bellCekk->rowCount() > '5') {
?><div class="dropdown-bell-fullhref"><a href="bildirimler/"><?= $diller['header-text18'] ?></a></div><?php
                }
?><?php
            }
?> <?php
            if ($bellCountTotal + $bellCountTotalUser + $bellCountTotalUserID <= '0') {
?><div class="dropdown-bell-no"><i class="las la-bell-slash"></i><div class="dropdown-bell-no-t"><?= $diller['header-text21'] ?></div><div class="dropdown-bell-no-s"><?= $diller['header-text20'] ?></div></div><div class="dropdown-bell-fullhref"><a href="bildirimler/"><?= $diller['header-text18'] ?></a></div><?php
            }
?></div></div><!--  <========SON=========>>> Bell  Dropdown SON !--></div><?php
        }
?><?php
    }
?><!--  <========SON=========>>> Bell - Bildirimler SON !--><!-- Login !--><?php
    if ($head['header_login'] == '1' && $uyeayar['durum'] == '1') {
?><?php
        if ($userSorgusu->rowCount() > '0') {
?><div class="header-desktop-navbutton-box"><a href="#" <?php
            if ($head['header_text_status'] == '0') {
?>class="tooltip-bottom" data-tooltip="<?= $diller['header-text6'] ?>"<?php
            }
?> data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="las la-user-check"></i><?php
            if ($head['header_text_status'] == '1') {
?><div class="header-desktop-navbutton-box-t"><?= $diller['header-text6'] ?></div><?php
            }
?></a><!-- User Login Success Dropdown !--><div class="dropdown-menu dropdown-menu-right user-drop"><div class="dropdown-user-area"><div class="dropdown-userarea-header"><?= $diller['header-text6'] ?></div><div class="dropdown-user-area-link-area" style="margin-top: 0; border-top: 0;"><?php
            if ($head['login_dropdown_account'] == '1') {
?><a href="hesabim/ayarlar/"><i class="fa fa-user-o"></i> <?= $diller['header-text13'] ?></a><?php
            }
?> <?php
            if ($head['login_dropdown_order'] == '1' && $uyeayar['siparisler_alani'] == '1') {
?><a href="hesabim/siparisler/"><i class="ion-bag"></i> <?= $diller['header-text14'] ?></a><?php
            }
?> <?php
            if ($head['login_dropdown_address'] == '1' && $uyeayar['adres_alani'] == '1') {
?><a href="hesabim/adresler/"><i class="ion-ios-location" style="margin-right: 12px;"></i> <?= $diller['header-text15'] ?></a><?php
            }
?> <?php
            if ($odemeayar['sepet_kupon'] == '1' && $head['login_dropdown_coupon'] == '1' && $uyeayar['kupon_alani'] == '1') {
?><a href="hesabim/kuponlar/"><i class="ion-ios-pricetags" style="margin-right: 12px;"></i> <?= $diller['header-text23'] ?></a><?php
            }
?> <?php
            if ($head['login_dropdown_comments'] == '1' && $uyeayar['yorumlar_alani'] == '1') {
?><a href="hesabim/yorumlar/"><i class="fa fa-star-half-o"></i> <?= $diller['header-text17'] ?></a><?php
            }
?> <?php
            if ($head['login_dropdown_support'] == '1' && $uyeayar['destek_alani'] == '1') {
?><?php
                if ($userCek['destek'] == '1' || $userCek['destek'] == '2') {
?><a href="hesabim/destek/"><i class="fa fa-ticket"></i> <?= $diller['header-text16'] ?></a><?php
                }
?><?php
            }
?> <?php
            if ($head['login_dropdown_compare'] == '1' && $odemeayar['urun_karsilastirma'] == '1') {
?><a href="karsilastirmalar/"><i class="fa fa-random"></i> <?= $diller['header-text11'] ?>&nbsp;<strong><?php
                if (isset($_SESSION['compare_product'])) {
?>(<?= count($_SESSION['compare_product']) ?>)<?php
                }
?></strong></a><?php
            }
?> <?php
            if ($head['login_dropdown_fav'] == '1' && $uyeayar['favori_alani'] == '1') {
?><a href="hesabim/favoriler/"><i class="fa fa-heart-o"></i> <?= $diller['header-text8'] ?></a><?php
            }
?> <?php
            if ($head['login_dropdown_bell'] == '1' && $bildirimayar['durum'] == '1') {
?><a href="bildirimler/"><i class="fa fa-bell-o"></i> <?= $diller['header-text1'] ?>&nbsp;<strong>(<?= $bellCountTotal + $bellCountTotalUser + $bellCountTotalUserID ?>)</strong></a><?php
            }
?><a href="logout/"><i class="fa fa-sign-out"></i> <?= $diller['header-text12'] ?></a></div></div></div><!--  <========SON=========>>> User Login Success Dropdown SON !--></div><?php
        } else {
?><div class="header-desktop-navbutton-box"><a href="#" <?php
            if ($head['header_text_status'] == '0') {
?>class="tooltip-bottom" data-tooltip="<?= $diller['header-text2'] ?>"<?php
            }
?> data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="/i/iconmail/hesabim.svg"><?php
            if ($head['header_text_status'] == '1') {
?><div class="header-desktop-navbutton-box-t"><?= $diller['header-text2'] ?></div><?php
            }
?></a><?php
            if ($userSorgusuOnaysiz->rowCount() <= '0') {
?><!-- User NoLogin Dropdown !--><div class="dropdown-menu dropdown-menu-right user-drop"><div class="dropdown-user-area"><div class="dropdown-user-area-header"><a href="uye-girisi/" class="button-blue" style="<?php
                if ($head['dropdown_radius'] == '1') {
?>border-radius:4px;<?php
                }
?>"><?= $diller['header-uyelik-yazisi'] ?></a><?php
                if ($uyeayar['yeni_uyelik'] == '1') {
?><div class="dropdown-user-area-lineText"><div class="dropdown-user-area-lineText-in"><?= $diller['header-text10'] ?></div></div><a href="uyelik/" class="button-green" style="<?php
                    if ($head['dropdown_radius'] == '1') {
?>border-radius:4px;<?php
                    }
?>"><?= $diller['header-hemen-uye-ol'] ?></a><?php
                }
?></div><?php
                if ($head['dropdown_compare'] == '1' || $head['dropdown_fav'] == '1' || $head['dropdown_bell'] == '1') {
?><div class="dropdown-user-area-link-area"><?php
                    if ($head['dropdown_compare'] == '1' && $odemeayar['urun_karsilastirma'] == '1') {
?><a href="karsilastirmalar/"><i class="fa fa-random"></i> <?= $diller['header-text11'] ?>&nbsp;<strong><?php
                        if (isset($_SESSION['compare_product'])) {
?>(<?= count($_SESSION['compare_product']) ?>)<?php
                        }
?></strong></a><?php
                    }
?> <?php
                    if ($head['dropdown_fav'] == '1' && $uyeayar['favori_alani'] == '1') {
?><a href="hesabim/favoriler/"><i class="fa fa-heart"></i> <?= $diller['header-text8'] ?></a><?php
                    }
?> <?php
                    if ($head['dropdown_bell'] == '1' && $bildirimayar['durum'] == '1') {
?><?php
                        if ($bildirimayar['tur'] == '0') {
?><a href="bildirimler/"><i class="las la-bell"></i> <?= $diller['header-text1'] ?>&nbsp;<strong>(<?= $bellCountTotal + $bellCountTotalUser + $bellCountTotalUserID ?>)</strong></a><?php
                        }
?><?php
                    }
?></div><?php
                }
?></div></div><!--  <========SON=========>>> User NoLogin Dropdown SON !--><?php
            } else {
?><!-- User Onaysız Dropdown !--><div class="dropdown-menu dropdown-menu-right user-drop"><div class="dropdown-user-area"><div class="dropdown-userarea-header p-2 mb-2" style="border: 1px solid #FFAEBE; background: #F9E5D9;"><div><?= $diller['alert-warning-2'] ?><div class="mt-2" style="font-size: 12px ; font-weight: 300;"><?= $diller['users-text14-onaysiz'] ?></div></div></div><div class="dropdown-user-area-link-area" style="margin-top: 0; border-top: 0;"><a href="logout/"><i class="fa fa-sign-out"></i> <?= $diller['header-text12'] ?></a></div></div></div><!--  <========SON=========>>> User Onaysız Dropdown SON !--><?php
            }
?></div><?php
        }
?><?php
    }
?><!--  <========SON=========>>> Login SON !--><!-- Favoriler !--><?php
    if ($head['header_fav'] == '1' && $uyeayar['favori_alani'] == '1') {
?><div class="header-desktop-navbutton-box"><a href="hesabim/favoriler/" <?php
        if ($head['header_text_status'] == '0') {
?>class="tooltip-bottom" data-tooltip="<?= $diller['header-text3'] ?>"<?php
        }
?> ><i class="lar la-heart"></i><?php
        if ($head['header_text_status'] == '1') {
?><div class="header-desktop-navbutton-box-t"><?= $diller['header-text3'] ?></div><?php
        }
?></a></div><?php
    }
?><!--  <========SON=========>>> Favoriler SON !--><!-- Sepet !--><?php
    if ($head['header_cart'] == '1' && $odemeayar['sepet_sistemi'] == '1') {
?><div class="header-desktop-navbutton-box carting"><a href="#" <?php
        if ($head['header_text_status'] == '0') {
?>class="tooltip-bottom" data-tooltip="<?= $diller['header-text4'] ?>"<?php
        }
?> data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php
        if ($shoppingCartCount > '0') {
?><div class="header-desktop-navbutton-box-count-cart <?= $head['count_bg_2'] ?>"><?= $shoppingCartCount ?></div><?php
        }
?><img src="/i/iconmail/sepetiniz.png"><?php
        if ($head['header_text_status'] == '1') {
?><div class="header-desktop-navbutton-box-t"><?= $diller['header-text4'] ?></div><?php
        }
?></a><!-- Sepet Dropdown !--><div class="dropdown-menu dropdown-menu-right cart-drop"><?php
        if ($shoppingCartCount > '0') {
?><div class="dropdown-cart-header"><?= $diller['header-text7'] ?> : <strong><?= $shoppingCartCount ?></strong></div><div class="dropdown-cart-overflow"><?php
            foreach ($shopCount as $headerCartItem) {
                $HeadCartProduct = $db->prepare("select * from urun where id=:id ");
                $HeadCartProduct->execute(array(
                    'id' => $headerCartItem['urun_id']
                ));
                $headProductcartRow = $HeadCartProduct->fetch(PDO::FETCH_ASSOC);
                /* Ara Toplam */
                $hCartAraToplam     = $hCartAraToplam + ($headerCartItem['kdvsiz_fiyat'] * $headerCartItem['adet']) /*  <========SON=========>>> Ara Toplam SON */ ?><div class="dropdown-cart-itembox"><div class="dropdown-cart-itembox-content"><div class="dropdown-cart-itembox-content-img"><img src="images/product/<?= $headProductcartRow['gorsel'] ?>" alt="<?= $headProductcartRow['baslik'] ?>"></div><div class="dropdown-cart-itembox-content-t"><div class="dropdown-cart-itembox-content-t-1"><?= $headProductcartRow['baslik'] ?> <?php
                if ($headProductcartRow['kdv'] == '2') {
?>(<?= $diller['urunler-dahil-kdv'] ?>)<?php
                }
?></div><div class="dropdown-cart-itembox-content-t-3"><?= $diller['sepet-liste-birim-yazisi'] ?> :<span style="color: #0088cc;"><?php
                if ($secilikur['simge_gosterim'] == '0') {
?> <?= $secilikur['sol_simge'] ?><?php
                }
?><?php
                if ($secilikur['simge_gosterim'] == '1') {
?> <?= $secilikur['sag_simge'] ?><?php
                }
?><?php
                echo number_format(kurhesapla($varsayilankur['deger'], $secilikur['deger'], $headerCartItem['kdvsiz_fiyat']), $secilikur['para_format']);
?><?php
                if ($secilikur['simge_gosterim'] == '2') {
?> <?= $secilikur['sol_simge'] ?><?php
                }
?><?php
                if ($secilikur['simge_gosterim'] == '3') {
?> <?= $secilikur['sag_simge'] ?><?php
                }
?><?php
                if ($headProductcartRow['kdv'] == '1') {
?> <?= $diller['urunler-arti-kdv'] ?><?php
                }
?></span></div><div class="dropdown-cart-itembox-content-t-3"><?= $diller['sepet-adet'] ?> : <?= $headerCartItem['adet'] ?></div></div></div><div class="dropdown-cart-itembox-trash"><a href="#" class="cart-item-delete" data-code="<?= $headerCartItem['sepetno'] ?>"><i class="las la-times"></i></a></div></div><?php
            }
?></div><div class="dropdown-cart-priceTotal"><div class="dropdown-cart-priceTotal-l"><?= $diller['sepet-ozet-ara-toplam'] ?> :</div><div class="dropdown-cart-priceTotal-r"><?php
            if ($secilikur['simge_gosterim'] == '0') {
?> <?= $secilikur['sol_simge'] ?><?php
            }
?><?php
            if ($secilikur['simge_gosterim'] == '1') {
?> <?= $secilikur['sag_simge'] ?><?php
            }
?><?php
            echo number_format(kurhesapla($varsayilankur['deger'], $secilikur['deger'], $hCartAraToplam), $secilikur['para_format']);
?><?php
            if ($secilikur['simge_gosterim'] == '2') {
?> <?= $secilikur['sol_simge'] ?><?php
            }
?><?php
            if ($secilikur['simge_gosterim'] == '3') {
?> <?= $secilikur['sag_simge'] ?><?php
            }
?></div></div><div><a href="sepet/" class="button-blue" style="width: 100%;  text-align: center; color: #fff; font-size: 14px; padding: 6px 5px; <?php
            if ($head['dropdown_radius'] == '1') {
?>border-radius:4px;<?php
            }
?>  "><?= $diller['header-sepete-git-yazisi'] ?></a></div><?php
        } else {
?><div class="dropdown-cart-noitem"><i class="ion-bag"></i><div class="dropdown-cart-noitem-t"><?= $diller['sepet-bos'] ?></div><div class="dropdown-cart-noitem-s"><?= $diller['sepet-bos-text'] ?></div></div><?php
        }
?></div><!--  <========SON=========>>> Sepet Dropdown SON !--></div><?php
    }
?><!--  <========SON=========>>> Sepet SON !--></div></div></div><div class="top-level-menu-main-div"><div class="top-level-menu-main-div-in"><div class="head-new-area-left"><?php
    include 'includes/template/header_items/header_items.php';
?></div><!-- Ek Button !--><?php
    $ekButtonSabit = $db->prepare("select * from header_sabit_buton where dil=:dil and durum=:durum ");
    $ekButtonSabit->execute(array(
        'dil' => $_SESSION['dil'],
        'durum' => '1'
    ));
?> <?php
    if ($ekButtonSabit->rowCount() > '0') {
        $ekbuton = $ekButtonSabit->fetch(PDO::FETCH_ASSOC);
?><div class="head-new-area-right"><a  <?php
        if ($ekbuton['url'] == !null) {
?>href="<?= $ekbuton['url'] ?>" <?php
            if ($ekbuton['yeni_sekme'] == '1') {
?>target="_blank" <?php
            }
?><?php
        } else {
?>href="javascript:Void(0)"<?php
        }
?> class="<?= $ekbuton['renk'] ?> button-2x" style="  font-weight: bold;"><?= $ekbuton['baslik'] ?></a></div><?php
    }
?><!-- Ek Button SON !--></div></div><!-- Desktop/Masaüstü Header SON !--></div><?php
}
?></div><?php
if ($head['search_tip'] == '2') {
?><div class="head-search-overlay"><div class="search-tip2-overlay" id="mk-search-head-search-overlay"><a class="mk-fullscreen-close" style="color: #fff; cursor: pointer"><i  class="fa fa-times"></i></a><div id="search-tip2-wrapper"><form id="search-tip2-inside" method="get" action="arama/"><input type="hidden" name="s" value="1" ><input type="text" name="q" placeholder="<?= $diller['header-arama-yazisi'] ?>"  id="mk-fullscreen-search-input" autocomplete="off"><i class="fa fa-search fullscreen-search-icon"><input value="" type="submit" style="cursor: pointer"></i></form></div></div></div><script> jQuery(document).ready(function ($) {var wHeight = window.innerHeight;$('#search-tip2-inside').css('top', wHeight / 2);jQuery(window).resize(function () {wHeight = window.innerHeight;$('#search-tip2-inside').css('top', wHeight / 2);});$('#search-tip2-button').click(function () {$(document).mouseup(function (e) {var container = $("#search-tip2-wrapper");if (!container.is(e.target) && container.has(e.target).length === 0) {$("div.search-tip2-overlay").removeClass("search-tip2-overlay-show");}});console.log("Open Search, Search Centered");$("div.search-tip2-overlay").addClass("search-tip2-overlay-show");});$(".mk-fullscreen-close").click(function () {console.log("Closed Search");$("div.search-tip2-overlay").removeClass("search-tip2-overlay-show");});});</script><?php
}
?>