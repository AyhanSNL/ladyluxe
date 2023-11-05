<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<title><?php echo $diller['altsayfa-odeme-bildirimi-title'] ?> - <?php echo $ayar['site_baslik']?></title>
<meta name="description" content="<?php echo"$ayar[site_desc]" ?>">
<meta name="keywords" content="<?php echo"$ayar[site_tags]" ?>">
<meta name="news_keywords" content="<?php echo"$ayar[site_tags]" ?>">
<meta name="author" content="<?php echo"$ayar[site_baslik]" ?>" />
<meta itemprop="author" content="<?php echo"$ayar[site_baslik]" ?>" />
<meta name="robots" content="index follow">
<meta name="googlebot" content="index follow">
<meta property="og:type" content="website" />
<?php
if($_GET['delete'] = 'yes' && $_GET['order']=='new' && isset($_GET['sID']) ) {
    if(strip_tags(htmlspecialchars($_GET['sID'])) != $_GET['sID']  ) {
        header('Location:'.$ayar['site_url'].'404');
        exit();
    }
    $bildCek = $db->prepare("select * from odeme_bildirim where siparis_no=:siparis_no and durum=:durum");
    $bildCek->execute(array(
        'siparis_no' => trim(strip_tags($_GET['sID'])),
        'durum' => '2',
    ));
    if($bildCek->rowCount()>'0'  ) {
        $silmeislem = $db->prepare("DELETE from odeme_bildirim WHERE siparis_no=:siparis_no");
        $silmeislem->execute(array(
            'siparis_no' => $_GET['sID']
        ));
        if ($silmeislem) {
            header('Location:'.$siteurl.'odeme-bildirimi/?sID='.$_GET['sID'].'');
        }else {
            echo 'veritabanı hatası';
        }
    }else{
        header('Location:'.$siteurl.'404');
    }
}
?>
<?php include "includes/config/header_libs.php";?>
</head>
<body>
<?php include 'includes/template/pre-loader.php'?>
<?php include 'includes/template/header.php'?>
<?php include 'includes/template/helper/page-headers-stil.php';  ?>
<!-- CONTENT AREA ============== !-->
<div id="MainDiv" style="background-color: #<?=$ayar['odeme_bildirim_bg']?>; width: 100%; font-family : '<?=$ayar['odeme_bildirim_font']?>',Sans-serif ; overflow: hidden  ">
    <div class="user_login_register_div">
        <?php if(isset($_GET['sID'])  ) {

            if(strip_tags(htmlspecialchars($_GET['sID'])) != $_GET['sID']  ) {
                header('Location:'.$ayar['site_url'].'odeme-bildirimi/');
                exit();
            }

            /* Sipariş Check */
            $siparisKontrol = $db->prepare("select * from siparisler where siparis_no=:siparis_no ");
            $siparisKontrol->execute(array(
                'siparis_no' => trim(strip_tags($_GET['sID'])),
            ));
            $siparis = $siparisKontrol->fetch(PDO::FETCH_ASSOC);
            /*  <========SON=========>>> Sipariş Check SON */

            /* Para Birimi */
            $paraBirimi = $db->prepare("select * from para_birimleri where durum=:durum order by sira asc ");
            $paraBirimi->execute(array(
                'durum' => '1',
            ));
            /*  <========SON=========>>> Para Birimi SON */


            /* Banka Numaraları */
            $bankalar = $db->prepare("select * from bankalar where durum=:durum order by sira asc ");
            $bankalar->execute(array(
                'durum' => '1',
            ));
            /*  <========SON=========>>> Banka Numaraları SON */


            $moneyler = $db->prepare("select * from para_birimleri where kod=:kod ");
            $moneyler->execute(array(
                'kod' => $siparis['parabirimi'],
            ));
            $money = $moneyler->fetch(PDO::FETCH_ASSOC);

            /* Ödeme bildirimi Kontrolü */
            $bildirimKontroluYap = $db->prepare("select * from odeme_bildirim where siparis_no=:siparis_no ");
            $bildirimKontroluYap->execute(array(
                'siparis_no' => trim(strip_tags($_GET['sID']))
            ));
            $bildirim = $bildirimKontroluYap->fetch(PDO::FETCH_ASSOC);
            /*  <========SON=========>>> Ödeme bildirimi Kontrolü SON */


            ?>
            <?php if(trim(strip_tags($_GET['sID'])) == null  ) {?>
                <?php
                header('Location:'.$ayar['site_url'].'odeme-bildirimi/');
                ?>
            <?php }else { ?>
                <?php if($siparisKontrol->rowCount()>'0'  ) {?>
                    <?php if($bildirimKontroluYap->rowCount()>'0'  ) {?>
                        <div class="iletisim-container-in">
                            <div class="odeme-bildirim-uyari" >
                                <div class="odeme-bildirim-uyari-i">
                                    <i class="las la-info-circle"></i>
                                </div>
                                <div class="user_subpage_favorites_noitems_head m-top-10" >
                                    <?=$diller['odeme-bildirimi-text24']?>
                                </div>
                                <div class="user_subpage_favorites_noitems_s">
                                    #<?=$_GET['sID']?> <?=$diller['odeme-bildirimi-text25']?>
                                </div>
                                <?php if($bildirim['durum'] == '0' ) {?>
                                    <div  class="button-blue-out button-2x m-top-20">
                                        <i class="fa fa-refresh fa-spin  fa-fw"></i> <?=$diller['users-panel-text121']?>
                                    </div>
                                    <br>
                                <?php }?>
                                <?php if($bildirim['durum'] == '1' ) {?>
                                    <div  class="button-green-out button-2x m-top-20">
                                        <i class="fa fa-check"></i> <?=$diller['users-panel-text122']?>
                                    </div>
                                    <br>
                                <?php }?>
                                <?php if($bildirim['durum'] == '2' ) {?>
                                    <div  class="button-red-out button-2x m-top-20">
                                        <i class="fa fa-times"></i> <?=$diller['users-panel-text122-b']?>
                                    </div>
                                    <br>
                                    <a href="odeme-bildirimi/?sID=<?=$_GET['sID']?>&delete=yes&order=new"  class="button-blue button-2x m-top-20">
                                        <?=$diller['users-panel-text122-c']?>
                                    </a>
                                    <br>
                                <?php }?>
                                <a href="odeme-bildirimi/" style="width: auto; display: inline-block; margin-top: 20px; font-size: 13px; border-bottom: 1px solid #666; color: #000; text-decoration: none;" >
                                    <i class="las la-long-arrow-alt-left"></i> <?=$diller['odeme-bildirimi-text16']?>
                                </a>
                            </div>
                        </div>
                    <?php }else { ?>
                        <div class="odeme-bildirim-main-div">
                            <!-- Header !-->
                            <div class="user_page_header2" >
                                <?=$diller['odeme-bildirimi-baslik']?>
                                <div class="user_page_header_spot">
                                    <?=$diller['odeme-bildirimi-text14']?>
                                </div>
                            </div>
                            <!--  <========SON=========>>> Header SON !-->


                            <div class="odeme-bildirim-boxes-flex">
                                <div class="odeme-bildirim-box">
                                    <div class="odeme-bildirim-box-hed" style="margin-bottom: 0;">
                                        <?=$diller['odeme-bildirimi-text4']?>
                                    </div>
                                    <div class="odeme-bildirim-box-account-div">
                                        <?php if($bankalar->rowCount()<='0'  ) {?>
                                            <div class="user_subpage_info_div_red m-top-20" style="font-weight: 600;" >
                                                <?=$diller['odeme-bildirimi-text23']?>
                                            </div>
                                        <?php }else { ?>
                                        <form action="odemeyi-bildir" method="post">
                                            <?php foreach ($bankalar as $banka) {?>
                                                <div class="odeme-bildirim-banka-radio">
                                                    <input class="form-check-input" type="radio" name="banka" id="<?=$banka['id']?>" value="<?=$banka['id']?>"  >
                                                    <label class="form-check-label" for="<?=$banka['id']?>">
                                                        <div class="odeme-bildirim-banka-radio-hed">
                                                            <?php if($banka['gorsel'] == !null  ) {?>
                                                                <div class="odeme-bildirim-banka-radio-hed-img">
                                                                    <img src="i/banks/<?=$banka['gorsel']?>" alt="">
                                                                </div>
                                                            <?php }?>
                                                            <div class="odeme-bildirim-banka-radio-bank">
                                                                <?=$banka['banka_adi']?> (<?=$banka['doviz']?>)
                                                            </div>
                                                        </div>
                                                        <div class="odeme-bildirim-banka-radio-text">
                                                            <strong><?=$diller['banka-hesap-text6']?> :</strong> <?=$banka['hesap_sahibi']?>
                                                        </div>
                                                        <div class="odeme-bildirim-banka-radio-text">
                                                            <strong><?=$diller['banka-hesap-text8']?> :</strong> <?=$banka['hesap_sube']?> / <?=$banka['hesap_no']?>
                                                        </div>
                                                        <div class="odeme-bildirim-banka-radio-text">
                                                            <strong><?=$diller['banka-hesap-text7']?> :</strong> <?=$banka['hesap_iban']?>
                                                        </div>
                                                    </label>
                                                </div>
                                            <?php }?>
                                            <?php }?>
                                    </div>
                                </div>
                                <div class="odeme-bildirim-box">
                                    <div class="odeme-bildirim-box-hed">
                                        <?=$diller['odeme-bildirimi-text5']?>
                                    </div>
                                    <div class="user_subpage_info_div_blue">
                                        <?=$diller['odeme-bildirimi-text22']?> :
                                        <strong>
                                            <?php if($siparis['odeme_tur'] == '2' ) {?>
                                                <?php if($moneyler->rowCount()>'0'  ) {?>
                                                    <?php if($money['simge_gosterim'] == '0' ) {?>
                                                        <?=$money['sol_simge']?>
                                                    <?php }?>
                                                    <?php if($money['simge_gosterim'] == '1' ) {?>
                                                        <?=$money['sag_simge']?>
                                                    <?php }?>
                                                    <?php echo number_format($siparis['havale_toplamtutar'], $money['para_format']); ?>
                                                    <?php if($money['simge_gosterim'] == '2' ) {?>
                                                        <?=$money['sol_simge']?>
                                                    <?php }?>
                                                    <?php if($money['simge_gosterim'] == '3' ) {?>
                                                        <?=$money['sag_simge']?>
                                                    <?php }?>
                                                <?php }else { ?>
                                                    <?php echo number_format($siparis['havale_toplamtutar'], 2); ?> <?=$siparis['parabirimi']?>
                                                <?php }?>
                                            <?php }else { ?>
                                                <?php if($moneyler->rowCount()>'0'  ) {?>
                                                    <?php if($money['simge_gosterim'] == '0' ) {?>
                                                        <?=$money['sol_simge']?>
                                                    <?php }?>
                                                    <?php if($money['simge_gosterim'] == '1' ) {?>
                                                        <?=$money['sag_simge']?>
                                                    <?php }?>
                                                    <?php echo number_format($siparis['toplam_tutar'], $money['para_format']); ?>
                                                    <?php if($money['simge_gosterim'] == '2' ) {?>
                                                        <?=$money['sol_simge']?>
                                                    <?php }?>
                                                    <?php if($money['simge_gosterim'] == '3' ) {?>
                                                        <?=$money['sag_simge']?>
                                                    <?php }?>
                                                <?php }else { ?>
                                                    <?php echo number_format($siparis['toplam_tutar'], 2); ?> <?=$siparis['parabirimi']?>
                                                <?php }?>
                                            <?php }?>
                                        </strong>
                                    </div>
                                    <div class="odeme-bildirim-box-form teslimat-form-area">
                                        <input type="hidden" name="hidden_order" value="<?=trim(strip_tags($_GET['sID']))?>">
                                        <div class="row">
                                            <div class="form-group col-md-12">
                                                <label for="orderno"><?=$diller['odeme-bildirimi-text6']?> <i class="fa fa-check" style="color: mediumseagreen;"></i></label>
                                                <input type="number" name="orderno" value="<?=trim(strip_tags($_GET['sID']))?>" id="orderno"   class="form-control" disabled>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="name"><?=$diller['odeme-bildirimi-text7']?></label>
                                                <input type="text" name="name" value="<?=$_SESSION['form_temp_odemebildirimi']['isim']?>" id="name" class="form-control" autocomplete="off" >
                                            </div>
                                            <div class="form-group col-md-8">
                                                <label for="amount"><?=$diller['odeme-bildirimi-text8']?></label>
                                                <input type="number" name="amount" id="amount" value="<?=$_SESSION['form_temp_odemebildirimi']['tutar']?>" class="form-control" autocomplete="off" >
                                            </div>
                                            <?php if($paraBirimi->rowCount()>'0'  ) {?>
                                                <div class="form-group col-md-4">
                                                    <label for="parabirimi"><?=$diller['odeme-bildirimi-text18']?></label>
                                                    <select name="parabirimi" class="form-control" id="parabirimi" >
                                                        <?php foreach ($paraBirimi as $para) {?>
                                                            <option value="<?=$para['kod']?>" <?php if($para['varsayilan'] == '1' ) { ?>selected<?php }?>><?=$para['kod']?></option>
                                                        <?php }?>
                                                    </select>
                                                </div>
                                            <?php }?>
                                            <div class="form-group col-md-12">
                                                <label for="aciklama"><?=$diller['odeme-bildirimi-text9']?></label>
                                                <textarea name="aciklama" id="aciklama" class="form-control" rows="2" ><?=$_SESSION['form_temp_odemebildirimi']['aciklama']?></textarea>
                                            </div>
                                            <div class="form-group col-md-12" style="margin-bottom: 0;">
                                                <button type="submit" name="odemeBildir" id="shopButton"  style="width: 100%" class="button-blue button-2x">
                                                    <?=$diller['odeme-bildirimi-text13']?>
                                                </button>
                                            </div>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="odeme-bildirim-box" >
                                    <div class="odeme-bildirim-box-hed">
                                        <?=$diller['odeme-bildirimi-text10']?>
                                    </div>
                                    <div class="odeme-bildirim-box-spot">
                                        <?=$diller['odeme-bildirimi-text11']?>
                                    </div>
                                    <div class="odeme-bildirim-box-spotsm">
                                        <?=$diller['odeme-bildirimi-text12']?>
                                    </div>
                                </div>
                            </div>


                        </div>
                    <?php }?>
                <?php }else { ?>
                    <div class="iletisim-container-in">
                        <div class="user_subpage_favorites_noitems" >
                            <img src="i/uploads/noOrder.svg" alt="">
                            <div class="user_subpage_favorites_noitems_head m-top-10" >
                                <?=$diller['odeme-bildirimi-text15']?>
                            </div>
                            <div class="user_subpage_favorites_noitems_s">
                                <?=$diller['odeme-bildirimi-text17']?>
                            </div>
                            <a href="odeme-bildirimi/" class="button-blue button-2x m-top-20">
                                <?=$diller['odeme-bildirimi-text16']?>
                            </a>
                        </div>
                    </div>
                <?php }?>
            <?php }?>
        <?php }else {
            unset($_SESSION['form_temp_odemebildirimi']);
            ?>
            <!-- Header !-->
            <div class="user_page_header">
                <?=$diller['odeme-bildirimi-baslik']?>
            </div>
            <!--  <========SON=========>>> Header SON !-->
            <div class="user_page_login_form ">
                <div class=" teslimat-form-area">
                    <form action="" method="get" >
                        <div class="user_subpage_info_div_blue" style="margin-top: -10px; margin-bottom:20px;" >
                            <?=$diller['odeme-bildirimi-text2']?>
                        </div>
                        <div class="row" >
                            <div class="form-group col-md-12">
                                <label for="orderNumber" style="font-weight: 600;">* <?=$diller['odeme-bildirimi-text1']?></label>
                                <input type="number" name="sID" id="orderNumber" class="form-control" autocomplete="off">
                            </div>
                            <div class="form-group col-md-12 " style="margin-bottom: 0;" >
                                <button   class="button-blue button-2x" style="width: 100%;  " ><i class="fa fa-search"></i> <?=$diller['odeme-bildirimi-text3']?> </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        <?php }?>



    </div>
    <!-- CONTENT AREA ============== !-->



    <?php include 'includes/template/footer.php'?>
</body>
</html>
<?php include "includes/config/footer_libs.php";?>
<?php if($_SESSION['bildirim_alert'] == 'success') {?>
    <div class="modal fade" id="succesMessagePost" >
        <div class="modal-dialog modal-dialog-centered modal-sm ">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                    <i class="ion-ios-checkmark-outline" style="font-size: 60px ; color: green;"></i><br>
                    <div style="font-weight: bold; margin-bottom: 20px; font-size: 24px ;"><?=$diller['alert-success']?></div>
                    <div>
                        <?=$diller['odeme-bildirimi-text21']?>
                    </div>
                </div>
                <div class="category-cart-add-success-modal-footer">
                    <button type="button" class="button-blue button-2x category-cart-add-success-modal-footer-button"  style=" " data-dismiss="modal"><?=$diller['alert-button-ok']?></button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(window).on("load", function() {
            $('#succesMessagePost').modal('show');
        });
        $(window).load(function () {
            $('#succesMessagePost').modal('show');
        });
        var $modalDialog = $("#succesMessagePost");
        $modalDialog.modal('show');

        setTimeout(function() {
            $modalDialog.modal('hide');
        }, 0);
    </script>
    <?php unset($_SESSION['bildirim_alert']); ?>
<?php }?>
<?php if($_SESSION['bildirim_alert'] == 'empty') {?>
    <div class="modal fade" id="errorModal" data-backdrop="static" style="z-index: 99999" >
        <div class="modal-dialog modal-dialog-centered modal-sm ">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                    <i class="ion-ios-information-outline" style="font-size: 45px ; color: #558cff;"></i><br>
                    <div style="font-weight: bold; margin-bottom: 20px; font-size: 20px ; color: #558cff;"><?=$diller['alert-warning']?></div>
                    <div>
                        <?=$diller['odeme-bildirimi-text20']?>
                    </div>
                </div>
                <div class="category-cart-add-success-modal-footer">
                    <button type="button" class="button-blue button-2x"  style="width: 100%; text-align: center; " data-dismiss="modal"><?=$diller['alert-button-ok']?></button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(window).on("load", function() {
            $('#errorModal').modal('show');
        });
        $(window).load(function () {
            $('#errorModal').modal('show');
        });
        var $modalDialog = $("#errorModal");
        $modalDialog.modal('show');

        setTimeout(function() {
            $modalDialog.modal('hide');
        }, 0);
    </script>
    <?php unset($_SESSION['bildirim_alert']); ?>
<?php }?>
<?php if($_SESSION['bildirim_alert'] == 'bankasec') {?>
    <div class="modal fade" id="errorModal" data-backdrop="static" style="z-index: 99999" >
        <div class="modal-dialog modal-dialog-centered modal-sm ">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                    <i class="ion-ios-information-outline" style="font-size: 45px ; color: #558cff;"></i><br>
                    <div style="font-weight: bold; margin-bottom: 20px; font-size: 20px ; color: #558cff;"><?=$diller['alert-warning']?></div>
                    <div>
                        <?=$diller['odeme-bildirimi-text19']?>
                    </div>
                </div>
                <div class="category-cart-add-success-modal-footer">
                    <button type="button" class="button-blue button-2x"  style="width: 100%; text-align: center; " data-dismiss="modal"><?=$diller['alert-button-ok']?></button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(window).on("load", function() {
            $('#errorModal').modal('show');
        });
        $(window).load(function () {
            $('#errorModal').modal('show');
        });
        var $modalDialog = $("#errorModal");
        $modalDialog.modal('show');

        setTimeout(function() {
            $modalDialog.modal('hide');
        }, 0);
    </script>
    <?php unset($_SESSION['bildirim_alert']); ?>
<?php }?>
<div id="shopButtonOverlay" style="font-family : '<?=$ayar['iletisim_sayfa_font']?>',Sans-serif ;">
    <div class="shopButtonT">
        <div><img src="images/load.svg" ></div>
        <div><?=$diller['teslimat-uye-text-4']?></div>
    </div>
</div>