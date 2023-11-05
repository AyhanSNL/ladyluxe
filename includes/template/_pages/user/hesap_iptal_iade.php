<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
if($userSorgusu->rowCount()>'0' && $uyeayar['iptal_alani'] == '1') {
    if($odemeayar['siparis_urun_iade'] == '1' || $odemeayar['siparis_iptal'] == '1'  ) {
$userpage = 'iptal';
    /* İptal Talepleri */
    $iptalCek = $db->prepare("select * from siparis_iptal where uye_id=:uye_id ");
    $iptalCek->execute(array(
        'uye_id' => $userCek['id']
    ));
    /*  <========SON=========>>> İptal Talepleri SON */

    /* İade Talepleri */
    $iadeCek = $db->prepare("select * from siparis_urunler_iade where uye_id=:uye_id ");
    $iadeCek->execute(array(
        'uye_id' => $userCek['id']
    ));
    /*  <========SON=========>>> İade Talepleri SON */
?>
<title><?php echo $diller['users-iptal-iade-seo-title']; ?> - <?php echo $ayar['site_baslik']?></title>
    <meta name="robots" content="noindex">
    <meta name="googlebot" content="noindex">
    <META HTTP-EQUIV="Expire" CONTENT="now" />
    <META HTTP-EQUIV="pragma" CONTENT="no-cache" />
    <META HTTP-EQUIV="cache-control" CONTENT="no-cache" />

<?php include "includes/config/header_libs.php";?>
</head>
<body>
<?php include 'includes/template/pre-loader.php'?>
<?php include 'includes/template/header.php'?>


<!-- CONTENT AREA ============== !-->

<div class="users_main_div" style="background-color: #<?=$uyeayar['altsayfa_bg']?>;  font-family : '<?=$uyeayar['font_select']?>',sans-serif ; ">

    <div class="user_subpage_div">


        <!-- Header !-->
        <div class="user_page_header_subpage">
            <a href="<?=$ayar['site_url']?>"><?=$diller['users-panel-baglanti-text1']?></a>
           <i class="las la-angle-double-right"></i>
            <a ><?=$diller['users-panel-baglanti-text2']?></a>
           <i class="las la-angle-double-right"></i>
            <a href="hesabim/iptal-iade-talepleri/"><?=$diller['users-panel-baglanti-text15']?></a>
        </div>
        <!--  <========SON=========>>> Header SON !-->
        <?php include 'includes/template/helper/users/leftbar.php'; ?>

        <!-- Right Content !-->
        <div class="user_subpage_coupon_content">


                <!-- Head !-->
                <div class="user_subpage_account_header">
                    <?=$diller['users-panel-text166']?>
                </div>
                <!--  <========SON=========>>> Head SON !-->

            <!-- Address Boxes !-->
            <div class="user_subpage_address_boxes_main ">
                <?php if($odemeayar['siparis_iptal'] == '1'  ) {?>
                    <a class="user_subpage_address_box_added_noitem" href="hesabim/iptal-talepleri/">
                        <div class="user_subpage_address_box_added_icon">
                            <i class="fa fa-times"></i>
                        </div>
                        <div class="user_subpage_address_box_added_text">
                            <?=$diller['users-panel-text167']?> <strong>(<?=$iptalCek->rowCount()?>)</strong>
                        </div>
                    </a>
                <?php }?>
                <?php if($odemeayar['siparis_urun_iade'] == '1'  ) {?>
                <a class="user_subpage_address_box_added_noitem" href="hesabim/iade-talepleri/">
                    <div class="user_subpage_address_box_added_icon">
                        <i class="fa fa-refresh"></i>
                    </div>
                    <div class="user_subpage_address_box_added_text">
                        <?=$diller['users-panel-text168']?> <strong>(<?=$iadeCek->rowCount()?>)</strong>
                    </div>
                </a>
            </div>
            <?php }?>
            <!--  <========SON=========>>> Address Boxes SON !-->




        </div>
        <!--  <========SON=========>>> Right Content SON !-->



    </div>


</div>
<!-- CONTENT AREA ============== !-->



<?php include 'includes/template/footer.php'?>
</body>
</html>
<?php include "includes/config/footer_libs.php";?>
    <?php
    }else{
        header('Location:'.$ayar['site_url'].'404');
    }
}else{
    header('Location:'.$ayar['site_url'].'404');
}
?>