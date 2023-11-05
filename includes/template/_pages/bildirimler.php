<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php

$islemlerAyar = $db->prepare("select * from bildirimler_ayar where id='1'");
$islemlerAyar->execute();
$islemayar = $islemlerAyar->fetch(PDO::FETCH_ASSOC);


if($islemayar['durum'] == '0'  ) {
    header('Location:'.$ayar['site_url'].'404');
}

if($islemayar['tur'] == '1' && $userSorgusu->rowCount()<='0' ) {
 header('Location:'.$ayar['site_url'].'404');
}

$bildirimLimit = '15';

$herkeseAcik = $db->prepare("select * from bildirimler where dil=:dil and durum=:durum and tur=:tur order by id DESC limit $bildirimLimit");
$herkeseAcik->execute(array(
    'dil' => $_SESSION['dil'],
    'durum' => '1',
    'tur' => '0'
));
$herkeseAcikCount = $db->prepare("select * from bildirimler where dil=:dil and durum=:durum and tur=:tur order by id DESC ");
$herkeseAcikCount->execute(array(
    'dil' => $_SESSION['dil'],
    'durum' => '1',
    'tur' => '0'
));

$uyelereOzel = $db->prepare("select * from bildirimler where dil=:dil and durum=:durum and tur=:tur order by id DESC limit $bildirimLimit");
$uyelereOzel->execute(array(
    'dil' => $_SESSION['dil'],
    'durum' => '1',
    'tur' => '1'
));
$uyelereOzelCount = $db->prepare("select * from bildirimler where dil=:dil and durum=:durum and tur=:tur order by id DESC ");
$uyelereOzelCount->execute(array(
    'dil' => $_SESSION['dil'],
    'durum' => '1',
    'tur' => '1'
));

if($userSorgusu->rowCount()>'0'  ) {
    $uyeOzel = $db->prepare("select * from bildirimler where dil=:dil and durum=:durum and tur=:tur and uye_id=:uye_id order by id DESC limit $bildirimLimit");
    $uyeOzel->execute(array(
        'dil' => $_SESSION['dil'],
        'durum' => '1',
        'tur' => '2',
        'uye_id' => $userCek['id']
    ));
    $uyeOzelCount = $db->prepare("select * from bildirimler where dil=:dil and durum=:durum and tur=:tur and uye_id=:uye_id order by id ");
    $uyeOzelCount->execute(array(
        'dil' => $_SESSION['dil'],
        'durum' => '1',
        'tur' => '2',
        'uye_id' => $userCek['id']
    ));
}

?>
<?php
$page_header_setting = $db->prepare("select * from page_header where page_id='bildirim' order by id");
$page_header_setting->execute();
$pagehead = $page_header_setting->fetch(PDO::FETCH_ASSOC);
?>
<title><?php echo $diller['bildirimler-seo-title']; ?> - <?php echo $ayar['site_baslik']?></title>
<meta name="description" content="<?php echo"$islemayar[meta_desc]" ?>">
<meta name="keywords" content="<?php echo"$islemayar[tags]" ?>">
<meta name="news_keywords" content="<?php echo"$islemayar[tags]" ?>">
<meta name="author" content="<?php echo"$ayar[site_baslik]" ?>" />
<meta itemprop="author" content="<?php echo"$ayar[site_baslik]" ?>" />
<meta name="robots" content="index follow">
<meta name="googlebot" content="index follow">
<meta property="og:type" content="website" />

<?php include "includes/config/header_libs.php";?>

</head>
<body>
<?php include 'includes/template/pre-loader.php'?>
<?php include 'includes/template/header.php'?>


<!-- Page Header ====================== !-->
<?php include 'includes/template/helper/page-headers-stil.php'; ?>


<!-- CONTENT AREA ============== !-->
<div id="MainDiv" style="background-color: #<?=$islemayar['detay_bg']?>; width: 100%; font-family : '<?=$islemayar['font_select']?>',Sans-serif ;    overflow: hidden;
    ">
    <?php if ($pagehead['durum'] == '1') { ?>
        <div class="page-banner-main">
            <div class="page-banner-in-text">
                <div class="page-banner-h <?=$pagehead['baslik_space']?>">
                    <?php echo $diller['bildirimler-text1']; ?>
                </div>
                <div class="page-banner-links ">
                    <a href="<?=$ayar['site_url']?>"><i class="fa fa-home"></i> <?=$diller['sayfa-banner-anasayfa']?></a>
                    <span>/</span>
                    <a>
                        <?php echo $diller['bildirimler-text1']; ?>
                    </a>
                </div>
            </div>
            <?php if ($pagehead['bg_tip'] == '0') { ?>
                <?php if ($pagehead['bg_dark'] == '1') { ?>
                    <!-- Karartma Var ise !-->
                    <div style="background: rgba(0,0,0,0.3); width: 100%; height: 100%; position: absolute; top:0; left:0; z-index: 1"></div>
                    <!-- Karartma Var ise !-->
                    <?php
                }
            }
            ?>
        </div>
    <?php } ?>

<div class="bildirimler-container-main" >


    <div class="bildirimler-box-main">



        <div class="bildirim_tabs_main">
            <ul id="bildirim_tabs" >
                <?php if($userSorgusu->rowCount()>'0'  ) {?>
                <li><a href="#member"><i class="las la-bullhorn"></i> <?=$diller['bildirimler-text4']?></a></li>
                <li><a href="#members"><i class="las la-bullhorn"></i> <?=$diller['bildirimler-text5']?></a></li>
                <?php } ?>
                <?php if($islemayar['tur'] == '0'  ) {?>
                    <li ><a href="#pushing" style="border-right: 0;"><i class="las la-bullhorn"></i> <?=$diller['bildirimler-text3']?></a></li>
                <?php }?>
            </ul>
        </div>

        <?php if($diller['bildirimler-text2'] == !null  ) {?>
            <div class="bildirimler-bilgi-box">
                <?=$diller['bildirimler-text2']?>
            </div>
        <?php }?>

        <?php if($userSorgusu->rowCount()>'0'  ) {?>

            <div class="bildirim_tab_content" id="member">
                <?php foreach ($uyeOzel as $ozeluye ) {
                    $ozelID = 	$ozeluye['id'];
                    ?>
                    <div class="bildirimler-box">
                        <div class="bildirimler-box-baslik">
                            <?php if($ozeluye['ikon'] == !null ) {?>
                                <div style="width: 30px;"><?=$ozeluye['ikon']?></div>
                            <?php }else { ?>
                                <div style="width: 30px;"><i class="fa fa-arrow-right"></i></div>
                            <?php }?>
                            <a href="bildirim/<?=seo($ozeluye['baslik'])?>-B<?=$ozeluye['bildirim_id']?>">
                                <?=$ozeluye['baslik']?>
                            </a>
                        </div>
                        <div class="bildirimler-box-tarih">
                            <i class="las la-clock"></i> <?php echo date_tr('j F Y', ''.$ozeluye['tarih'].''); ?>
                        </div>
                        <div class="bildirimler-box-read">
                            <?php if($ozeluye['tur'] == '2' ) {
                                $bildirim_ipSorgu = $db->prepare("select * from bildirimler_ip where bildirim_id=:bildirim_id and uye_id=:uye_id ");
                                $bildirim_ipSorgu->execute(array(
                                    'bildirim_id' => $ozeluye['bildirim_id'],
                                    'uye_id' => $userCek['id']
                                ));
                                if($bildirim_ipSorgu->rowCount()<='0'  ) { ?>
                                    <span style="color: dodgerblue; font-weight: 600;"><i class="fa fa-spinner fa-spin fa-fw"></i> <?=$diller['bildirimler-text7']?></span>
                                <?php } else { ?>
                                    <span style="color: black;"><i class="las la-check"></i> <?=$diller['bildirimler-text6']?></span>
                             <?php }} ?>
                        </div>
                    </div>
                <?php }?>
                <?php if($uyeOzel->rowCount()<= '0'  ) {?>
                    <div class="bildirimler-box" style="padding: 15px;">
                        <div class="bildirimler-box-no-count">
                            <i class="las la-bell-slash"></i> <?=$diller['bildirimler-text8']?>
                        </div>
                    </div>
                <?php }?>
                <?php if($uyeOzelCount->rowCount() > $bildirimLimit  ) {?>
                    <div class="ozelbildirim-show-more-button " id="ozelbildirim-show-more-button<?php echo $ozelID; ?>">
                        <span id="<?php echo $ozelID; ?>"  class="ozelbildirim-showmorespan button-white-black button-2x" >+ <?=$diller['bildirimler-text11']?></span>
                        <span class="ozelbildirim_loding" style="display: none;"><span class="ozelbildirim_loding_txt"><?=$diller['bildirimler-text12']?></span></span>
                    </div>
                <?php }?>
            </div>

            <div class="bildirim_tab_content" id="members">
                <?php foreach ($uyelereOzel as $uyelerRow ) {
                    $uyelerID = 	$uyelerRow['id'];
                    ?>
                    <div class="bildirimler-box">
                        <div class="bildirimler-box-baslik">
                            <?php if($uyelerRow['ikon'] == !null ) {?>
                                <div style="width: 30px;"><?=$uyelerRow['ikon']?></div>
                            <?php }else { ?>
                                <div style="width: 30px;"><i class="fa fa-arrow-right"></i></div>
                            <?php }?>
                            <a href="bildirim/<?=seo($uyelerRow['baslik'])?>-B<?=$uyelerRow['bildirim_id']?>">
                                <?=$uyelerRow['baslik']?>
                            </a>
                        </div>
                        <div class="bildirimler-box-tarih">
                            <i class="las la-clock"></i> <?php echo date_tr('j F Y', ''.$uyelerRow['tarih'].''); ?>
                        </div>
                        <div class="bildirimler-box-read">
                            <?php if($uyelerRow['tur'] == '1' ) {
                                $bildirim_ipSorgu = $db->prepare("select * from bildirimler_ip where bildirim_id=:bildirim_id and uye_id=:uye_id ");
                                $bildirim_ipSorgu->execute(array(
                                    'bildirim_id' => $uyelerRow['bildirim_id'],
                                    'uye_id' => $userCek['id']
                                ));
                                if($bildirim_ipSorgu->rowCount()<='0'  ) { ?>
                                    <span style="color: dodgerblue; font-weight: 600;"><i class="fa fa-spinner fa-spin fa-fw"></i> <?=$diller['bildirimler-text7']?></span>
                                <?php } else { ?>
                                    <span style="color: black;"><i class="las la-check"></i> <?=$diller['bildirimler-text6']?></span>
                                <?php }} ?>
                        </div>
                    </div>
                <?php }?>
                <?php if($uyelereOzel->rowCount()<= '0'  ) {?>
                    <div class="bildirimler-box" style="padding: 15px;">
                        <div class="bildirimler-box-no-count">
                            <i class="las la-bell-slash"></i> <?=$diller['bildirimler-text9']?>
                        </div>
                    </div>
                <?php }?>
                <?php if($uyelereOzelCount->rowCount() > $bildirimLimit  ) {?>
                    <div class="uyelerebildirim-show-more-button " id="uyelerebildirim-show-more-button<?php echo $uyelerID; ?>">
                        <span id="<?php echo $uyelerID; ?>"  class="uyelerebildirim-showmorespan button-white-black button-2x" >+ <?=$diller['bildirimler-text11']?></span>
                        <span class="uyelerebildirim_loding" style="display: none;"><span class="uyelerebildirim_loding_txt"><?=$diller['bildirimler-text12']?></span></span>
                    </div>
                <?php }?>
            </div>
        <?php } ?>

        <?php if($islemayar['tur'] == '0'  ) {?>
        <div class="bildirim_tab_content" id="pushing">
            <?php foreach ($herkeseAcik as $herkes ) {
                $herkeseID = 	$herkes['id'];
                ?>
                <div class="bildirimler-box">
                    <div class="bildirimler-box-baslik">
                        <?php if($herkes['ikon'] == !null ) {?>
                            <div style="width: 30px;"><?=$herkes['ikon']?></div>
                        <?php }else { ?>
                            <div style="width: 30px;"><i class="fa fa-arrow-right"></i></div>
                        <?php }?>
                        <a href="bildirim/<?=seo($herkes['baslik'])?>-B<?=$herkes['bildirim_id']?>">
                            <?=$herkes['baslik']?>
                        </a>
                    </div>
                    <div class="bildirimler-box-tarih">
                        <i class="las la-clock"></i> <?php echo date_tr('j F Y', ''.$herkes['tarih'].''); ?>
                    </div>
                    <div class="bildirimler-box-read">
                        <?php if($herkes['tur'] == '0' ) {
                            $ip = $_SERVER["REMOTE_ADDR"];
                            $bildirim_ipSorgu = $db->prepare("select * from bildirimler_ip where bildirim_id=:bildirim_id and ip_adres=:ip_adres ");
                            $bildirim_ipSorgu->execute(array(
                                'bildirim_id' => $herkes['bildirim_id'],
                                'ip_adres' => $ip
                            ));
                            if($bildirim_ipSorgu->rowCount()<='0'  ) { ?>
                                <span style="color: dodgerblue; font-weight: 600;"><i class="fa fa-spinner fa-spin fa-fw"></i> <?=$diller['bildirimler-text7']?></span>
                            <?php } else { ?>
                                <span style="color: black;"><i class="las la-check"></i> <?=$diller['bildirimler-text6']?></span>
                            <?php }} ?>
                    </div>
                </div>
            <?php }?>
            <?php if($herkeseAcik->rowCount()<= '0'  ) {?>
            <div class="bildirimler-box" style="padding: 15px;">
                <div class="bildirimler-box-no-count">
                    <i class="las la-bell-slash"></i> <?=$diller['bildirimler-text10']?>
                </div>
            </div>
            <?php }?>
            <?php if($herkeseAcikCount->rowCount() > $bildirimLimit  ) {?>
                <div class="herkesebildirim-show-more-button " id="herkesebildirim-show-more-button<?php echo $herkeseID; ?>">
                    <span id="<?php echo $herkeseID; ?>"  class="herkesebildirim-showmorespan button-white-black button-2x" >+ <?=$diller['bildirimler-text11']?></span>
                    <span class="herkesebildirim_loding" style="display: none;"><span class="herkesebildirim_loding_txt"><?=$diller['bildirimler-text12']?></span></span>
                </div>
            <?php }?>
        </div>
        <?php } ?>

    </div>

</div>
</div>

<!-- CONTENT AREA ============== !-->



<?php include 'includes/template/footer.php'?>
</body>
</html>
<?php include "includes/config/footer_libs.php";?>

<script type="text/javascript">//<![CDATA[


    var tabLinks = new Array();
    var contentDivs = new Array();

    function init() {

        // Grab the tab links and content divs from the page
        var tabListItems = document.getElementById('bildirim_tabs').childNodes;
        for (var i = 0; i < tabListItems.length; i++) {
            if (tabListItems[i].nodeName == "LI") {
                var tabLink = getFirstChildWithTagName(tabListItems[i], 'A');
                var id = getHash(tabLink.getAttribute('href'));
                tabLinks[id] = tabLink;
                contentDivs[id] = document.getElementById(id);
            }
        }

        // Assign onclick events to the tab links, and
        // highlight the first tab
        var i = 0;

        for (var id in tabLinks) {
            tabLinks[id].onclick = showTab;
            tabLinks[id].onfocus = function() {
                this.blur()
            };
            if (i == 0) tabLinks[id].className = 'selected';
            i++;
        }

        // Hide all content divs except the first
        var i = 0;

        for (var id in contentDivs) {
            if (i != 0) contentDivs[id].className = 'bildirim_tab_content hide';
            i++;
        }
    }

    function showTab() {
        var selectedId = getHash(this.getAttribute('href'));

        // Highlight the selected tab, and dim all others.
        // Also show the selected content div, and hide all others.
        for (var id in contentDivs) {
            if (id == selectedId) {
                tabLinks[id].className = 'selected';
                contentDivs[id].className = 'bildirim_tab_content';
            } else {
                tabLinks[id].className = '';
                contentDivs[id].className = 'bildirim_tab_content hide';
            }
        }

        // Stop the browser following the link
        return false;
    }

    function getFirstChildWithTagName(element, tagName) {
        for (var i = 0; i < element.childNodes.length; i++) {
            if (element.childNodes[i].nodeName == tagName) return element.childNodes[i];
        }
    }

    function getHash(url) {
        var hashPos = url.lastIndexOf('#');
        return url.substring(hashPos + 1);
    }

    init();


    //]]></script>


<script>
    $(document).ready(function(){
        $(document).on('click','.ozelbildirim-showmorespan',function(){
            var ID = $(this).attr('id');
            $('.ozelbildirim-showmorespan').hide();
            $('.ozelbildirim_loding').show();
            $.ajax({
                type:'POST',
                url:'bildirim-ozel-more',
                data:{id: ID},
                success:function(html){
                    $('#ozelbildirim-show-more-button'+ID).remove();
                    $('#member').append(html);
                }
            });
        });
    });
    $(document).ready(function(){
        $(document).on('click','.herkesebildirim-showmorespan',function(){
            var ID = $(this).attr('id');
            $('.herkesebildirim-showmorespan').hide();
            $('.herkesebildirim_loding').show();
            $.ajax({
                type:'POST',
                url:'bildirim-herkese-more',
                data:{id: ID},
                success:function(html){
                    $('#herkesebildirim-show-more-button'+ID).remove();
                    $('#pushing').append(html);
                }
            });
        });
    });
    $(document).ready(function(){
        $(document).on('click','.uyelerebildirim-showmorespan',function(){
            var ID = $(this).attr('id');
            $('.uyelerebildirim-showmorespan').hide();
            $('.uyelerebildirim_loding').show();
            $.ajax({
                type:'POST',
                url:'bildirim-uyelere-more',
                data:{id: ID},
                success:function(html){
                    $('#uyelerebildirim-show-more-button'+ID).remove();
                    $('#members').append(html);
                }
            });
        });
    });
</script>