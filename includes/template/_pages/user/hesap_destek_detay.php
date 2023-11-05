<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
$destekno = trim(strip_tags($_GET['destekno']));
$destkSOrgu = $db->prepare("select * from destek_talebi where destek_no=:destek_no and uye_id=:uye_id ");
$destkSOrgu->execute(array(
    'destek_no' => $destekno,
    'uye_id' => $userCek['id']
));
if($userSorgusu->rowCount()>'0' && $destkSOrgu->rowCount()>'0' && $uyeayar['destek_alani'] == '1' ) {
if( $userCek['destek'] == '1' || $userCek['destek'] == '2' ) {
$destekRow = $destkSOrgu->fetch(PDO::FETCH_ASSOC);
$userpage = 'destek';
?>
<title>#<?=$destekno?> <?php echo $diller['users-destek-detay-seo-title']; ?> - <?php echo $ayar['site_baslik']?></title>
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
            <a href="hesabim/destek/"><?=$diller['users-panel-baglanti-text7']?></a>
            <i class="las la-angle-double-right"></i>
            <a >#<?=$destekno?> <?=$diller['users-panel-baglanti-text9']?></a>
        </div>
        <!--  <========SON=========>>> Header SON !-->
        <?php include 'includes/template/helper/users/leftbar.php'; ?>

        <!-- Right Content !-->
        <div class="user_subpage_coupon_content">

                <!-- Head !-->
                <div class="user_subpage_flex_header" style="flex-direction: column">
                    <div class="user_subpage_flex_header_back_href">
                        <?=$diller['users-panel-text66']?>
                        <a href="hesabim/destek/">
                            <?=$diller['users-panel-text67']?>
                        </a>
                    </div>
                    <div class="user_subpage_flex_header_h">
                        #<?=$destekno?> <?=$diller['users-panel-text69']?>
                    </div>
                </div>
                <!--  <========SON=========>>> Head SON !-->


               <!-- Talep Detayları !-->
               <div class="row " style="border-top: 1px solid #EBEBEB; padding-top: 20px;">
                   <div class="form-group col-md-4 ticket-detail-form-area">
                       <label ><?=$diller['users-panel-text70']?></label><br>
                       <?=$destekno?>
                   </div>
                   <div class="form-group col-md-4 ticket-detail-form-area">
                       <label ><?=$diller['users-panel-text59']?></label><br>
                       <?php echo date_tr('j F Y, H:i, l ', ''.$destekRow['ilk_islem'].''); ?>
                   </div>
                   <div class="form-group col-md-4 ticket-detail-form-area">
                       <label ><?=$diller['users-panel-text60']?></label><br>
                       <?php echo date_tr('j F Y, H:i, l ', ''.$destekRow['son_islem'].''); ?>
                   </div>
                   <div class="form-group col-md-4 ticket-detail-form-area">
                       <label ><?=$diller['users-panel-text71']?></label><br>
                       <?=$destekRow['baslik']?>
                   </div>
                   <div class="form-group col-md-4 ticket-detail-form-area">
                       <label ><?=$diller['users-panel-text72']?></label><br>
                       <?php if($destekRow['durum'] == '0' ) {?>
                           <span style="color: red; font-weight: 700;"><?=$diller['users-panel-text58']?></span>
                       <?php }?>
                       <?php if($destekRow['durum'] == '1' ) {?>
                           <span style="color: mediumseagreen; font-weight: 700 ;"><?=$diller['users-panel-text57']?></span>
                       <?php }?>
                   </div>
                   <?php if($uyeayar['destek_siparis_mecbur'] =='1' ) {?>
                       <div class="form-group col-md-4 ticket-detail-form-area">
                           <label ><?=$diller['users-panel-text63-i']?></label><br>
                           <a href="hesabim/siparis-detay/<?=$destekRow['siparis_no']?>/" class="text-dark font-weight-bold" target="_blank">#<?=$destekRow['siparis_no']?></a>
                       </div>
                   <?php }?>

               </div>
               <!--  <========SON=========>>> Talep Detayları SON !-->

            <div class="user_subpage_ticket_line_hed m-top-10">
                <div class="user_subpage_ticket_line_hed_in">
                    <div class="user_subpage_ticket_line_hed_text"><?=$diller['users-panel-text74']?></div>
                </div>
            </div>

            <!-- Ticket Messages !-->
            <div class="user_subpage_ticket_message_main">
                <?php
                $ticketMessages = $db->prepare("select * from destek_talep_mesaj where destek_no=:destek_no ");
                $ticketMessages->execute(array(
                        'destek_no' => $destekno
                ));
                ?>
                <?php foreach ($ticketMessages as $msgRow) {?>
                    <?php if($msgRow['gonderen'] == '1' ) {?>
                        <!-- üye Mesajı yani gonderen = '1' !-->
                        <div class="user_subpage_ticket_message_user_box">
                            <div class="user_subpage_ticket_message_user_box_hed">
                                 <i class="las la-comment-dots"></i> <?=$userCek['isim']?> <?=$userCek['soyisim']?>
                            </div>
                            <div class="user_subpage_ticket_message_user_box_msg">
                                <?=$msgRow['mesaj']?>
                            </div>
                            <div class="user_subpage_ticket_message_user_box_date">
                                <?php echo date_tr('j F Y, H:i, l ', ''.$msgRow['tarih'].''); ?>
                            </div>
                        </div>
                        <!--  <========SON=========>>> üye Mesajı yani gonderen = '1' SON !-->
                    <?php }?>
                    <?php if($msgRow['gonderen'] == '0' ) {?>
                        <div class="user_subpage_ticket_message_support_box">
                            <div class="user_subpage_ticket_message_support_box_hed">
                                <i class="las la-headset"></i> <?=$diller['users-panel-text77']?>
                            </div>
                            <div class="user_subpage_ticket_message_support_box_msg">
                               <?php
                                               $kaynak  = $msgRow['mesaj'];
                                               $eski   = '../i/';
                                               $yeni   = 'i/';
                                               $kaynak = str_replace($eski, $yeni, $kaynak);
                               ?>
                                <?=$kaynak?>
                            </div>
                            <div class="user_subpage_ticket_message_support_box_date">
                                <?php echo date_tr('j F Y, H:i, l ', ''.$msgRow['tarih'].''); ?>
                            </div>
                        </div>
                    <?php }?>
                <?php }?>

            </div>
            <!--  <========SON=========>>> Ticket Messages SON !-->

            <?php if($userCek['destek'] == '1'  ) {?>
                <!-- Ticket Message Area Answer !-->
                <div class="user_subpage_ticket_answer_main teslimat-form-area">
                    <form action="destek-talep-cevap-gonder" method="post">
                        <input type="hidden" name="destek_no" value="<?=$destekno?>">
                        <input type="hidden" name="hashNo" value="<?=md5($destekno+$userCek['id'])?>">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="mesaj"><i class="las la-reply"></i> <?=$diller['users-panel-text75']?></label>
                                <br>
                                <textarea name="mesaj" id="mesaj" class="form-control" rows="3" ></textarea>
                            </div>
                            <div class="form-group col-md-12">
                                <button  id="shopButton"  class="button-blue button-2x"><?=$diller['users-panel-text76']?></button>
                            </div>
                        </div>
                    </form>
                </div>
                <!--  <========SON=========>>> Ticket Message Area Answer SON !-->
            <?php }?>

            <?php if($userCek['destek'] == '2'  ) {
                $today = date('Y-m-d');
                ?>
                <?php if($userCek['destek_sure_2'] >= $today   ) {?>
                    <!-- Ticket Message Area Answer !-->
                    <div class="user_subpage_ticket_answer_main teslimat-form-area">
                        <form action="destek-talep-cevap-gonder" method="post">
                            <input type="hidden" name="destek_no" value="<?=$destekno?>">
                            <input type="hidden" name="hashNo" value="<?=md5($destekno+$userCek['id'])?>">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="mesaj"><i class="las la-reply"></i> <?=$diller['users-panel-text75']?></label>
                                    <br>
                                    <textarea name="mesaj" id="mesaj" class="form-control" rows="3" ></textarea>
                                </div>
                                <div class="form-group col-md-12">
                                    <button  id="shopButton"  class="button-blue button-2x"><?=$diller['users-panel-text76']?></button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!--  <========SON=========>>> Ticket Message Area Answer SON !-->
                <?php }?>
            <?php }?>



        </div>
        <!--  <========SON=========>>> Right Content SON !-->



    </div>


</div>
<!-- CONTENT AREA ============== !-->



<?php include 'includes/template/footer.php'?>
</body>
</html>
<?php include "includes/config/footer_libs.php";?>
    <?php if($_SESSION['destek_alert'] == 'empty'  ) {?>
        <div class="modal fade" id="noArea" data-backdrop="static" >
            <div class="modal-dialog modal-dialog-centered modal-sm ">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                    <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                        <i class="ion-ios-information-outline" style="font-size: 45px ; color: #558cff;"></i><br>
                        <div style="font-weight: bold; margin-bottom: 20px; font-size: 20px ; color: #558cff;"><?=$diller['users-text10']?></div>
                        <div>
                            <?=$diller['users-text34']?>
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
                $('#noArea').modal('show');
            });
            $(window).load(function () {
                $('#noArea').modal('show');
            });
            var $modalDialog = $("#noArea");
            $modalDialog.modal('show');

            setTimeout(function() {
                $modalDialog.modal('hide');
            }, 0);
        </script>
        <?php unset($_SESSION['destek_alert'] ) ?>
    <?php }?>
    <?php if($_SESSION['destek_alert'] =='success'  ) {?>
        <div class="modal fade" id="okArea" data-backdrop="static" >
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                    <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                        <i class="ion-ios-checkmark-outline" style="font-size: 60px ; color: #66B483;"></i><br>
                        <div style="font-weight: bold; margin-bottom: 20px; font-size: 20px ; color: #66B483;"><?=$diller['alert-success']?></div>
                        <div>
                            <?=$diller['users-panel-text78']?>
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
                $('#okArea').modal('show');
            });
            $(window).load(function () {
                $('#okArea').modal('show');
            });
            var $modalDialog = $("#okArea");
            $modalDialog.modal('show');

            setTimeout(function() {
                $modalDialog.modal('hide');
            }, 0);
        </script>
        <?php unset($_SESSION['destek_alert']); ?>
    <?php }?>
    <div id="shopButtonOverlay" style="font-family : '<?=$ayar['iletisim_sayfa_font']?>',Sans-serif ;">
        <div class="shopButtonT">
            <div><img src="images/load.svg" ></div>
            <div><?=$diller['teslimat-uye-text-4']?></div>
        </div>
    </div>
    <?php
}else{
    header('Location:'.$ayar['site_url'].'404');
}
}else{
    header('Location:'.$ayar['site_url'].'404');
}
?>
