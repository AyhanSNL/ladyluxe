<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
if($userSorgusu->rowCount()>'0' && $uyeayar['destek_alani'] == '1') {
    if( $userCek['destek'] == '1' || $userCek['destek'] == '2' ) {
        $userpage = 'destek';
        ?>
        <title><?php echo $diller['users-destek-yeni-seo-title']; ?> - <?php echo $ayar['site_baslik']?></title>
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
                    <a href="hesabim/yeni-destek-talebi/"><?=$diller['users-panel-baglanti-text8']?></a>
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
                            <?=$diller['users-panel-text61']?>
                        </div>
                    </div>
                    <!--  <========SON=========>>> Head SON !-->


                    <?php if($userCek['destek'] == '1'  ) {?>
                        <?php if($uyeayar['destek_siparis_mecbur'] == '0' ) {?>
                            <div class="user_subpage_info_div_blue">
                                <?=$diller['users-panel-text62']?>
                            </div>

                            <!-- Form !-->
                            <form action="destek-talep-gonder" method="post">
                                <div class="row teslimat-form-area">
                                    <div class="form-group col-md-7">
                                        <label for="baslik"><?=$diller['users-panel-text63']?></label>
                                        <input type="text" name="baslik"  id="baslik"  class="form-control" autocomplete="off">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="mesaj"><?=$diller['users-panel-text64']?></label>
                                        <textarea name="mesaj" id="mesaj" class="form-control" rows="3" ></textarea>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <button id="shopButton" class="button-blue button-2x"><?=$diller['users-panel-text65']?></button>
                                    </div>
                                </div>
                            </form>
                        <?php }?>
                        <?php if($uyeayar['destek_siparis_mecbur'] == '1' ) {
                            $siparisBilgi = $db->prepare("select * from siparisler where uye_id=:uye_id and onay=:onay ");
                            $siparisBilgi->execute(array(
                                'uye_id' => $userCek['id'],
                                'onay' => '1'
                            ));
                            if($siparisBilgi->rowCount()>'0'){
                                ?>
                                <!-- Form !-->
                                <form action="destek-talep-gonder" method="post">
                                    <div class="row teslimat-form-area border-top pt-4">
                                        <div class="form-group col-md-7">
                                            <label for="baslik"><?=$diller['users-panel-text63']?></label>
                                            <input type="text" name="baslik"  id="baslik"  class="form-control" autocomplete="off">
                                        </div>
                                        <div class="form-group col-md-7">
                                            <label for="siparis_no"><?=$diller['users-panel-text63-i']?></label>
                                            <select name="siparis_no" class="form-control" id="siparis_no" required>
                                                <?php foreach ($siparisBilgi as $sipRow) {?>
                                                    <option value="<?=$sipRow['siparis_no']?>">#<?=$sipRow['siparis_no']?></option>
                                                <?php }?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="mesaj"><?=$diller['users-panel-text64']?></label>
                                            <textarea name="mesaj" id="mesaj" class="form-control" rows="3" ></textarea>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <button id="shopButton" class="button-blue button-2x"><?=$diller['users-panel-text65']?></button>
                                        </div>
                                    </div>
                                </form>
                            <?php }else { ?>
                                <div class="user_subpage_info_div_red">
                                    <i class="fa fa-exclamation-triangle"></i>
                                    <?=$diller['users-panel-text62-i']?>
                                </div>

                            <?php }?>
                        <?php }?>
                    <?php }?>

                    <?php if($userCek['destek'] == '2'  ) {
                        $today = date('Y-m-d');
                        ?>
                        <?php if($userCek['destek_sure_2'] >= $today   ) {?>
                            <?php if($uyeayar['destek_siparis_mecbur'] == '0' ) {?>
                                <div class="user_subpage_info_div_blue">
                                    <?=$diller['users-panel-text62']?>
                                </div>

                                <!-- Form !-->
                                <form action="destek-talep-gonder" method="post">
                                    <div class="row teslimat-form-area">
                                        <div class="form-group col-md-7">
                                            <label for="baslik"><?=$diller['users-panel-text63']?></label>
                                            <input type="text" name="baslik"  id="baslik"  class="form-control" autocomplete="off">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="mesaj"><?=$diller['users-panel-text64']?></label>
                                            <textarea name="mesaj" id="mesaj" class="form-control" rows="3" ></textarea>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <button id="shopButton" class="button-blue button-2x"><?=$diller['users-panel-text65']?></button>
                                        </div>
                                    </div>
                                </form>
                            <?php }?>
                            <?php if($uyeayar['destek_siparis_mecbur'] == '1' ) {
                                $siparisBilgi = $db->prepare("select * from siparisler where uye_id=:uye_id and onay=:onay ");
                                $siparisBilgi->execute(array(
                                    'uye_id' => $userCek['id'],
                                    'onay' => '1'
                                ));
                                if($siparisBilgi->rowCount()>'0'){
                                    ?>
                                    <!-- Form !-->
                                    <form action="destek-talep-gonder" method="post">
                                        <div class="row teslimat-form-area border-top pt-4">
                                            <div class="form-group col-md-7">
                                                <label for="baslik"><?=$diller['users-panel-text63']?></label>
                                                <input type="text" name="baslik"  id="baslik"  class="form-control" autocomplete="off">
                                            </div>
                                            <div class="form-group col-md-7">
                                                <label for="siparis_no"><?=$diller['users-panel-text63-i']?></label>
                                                <select name="siparis_no" class="form-control" id="siparis_no" required>
                                                    <?php foreach ($siparisBilgi as $sipRow) {?>
                                                        <option value="<?=$sipRow['siparis_no']?>">#<?=$sipRow['siparis_no']?></option>
                                                    <?php }?>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="mesaj"><?=$diller['users-panel-text64']?></label>
                                                <textarea name="mesaj" id="mesaj" class="form-control" rows="3" ></textarea>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <button id="shopButton" class="button-blue button-2x"><?=$diller['users-panel-text65']?></button>
                                            </div>
                                        </div>
                                    </form>
                                <?php }else { ?>
                                    <div class="user_subpage_info_div_red">
                                        <i class="fa fa-exclamation-triangle"></i>
                                        <?=$diller['users-panel-text62-i']?>
                                    </div>

                                <?php }?>
                            <?php }?>
                        <?php }else {
                            header('Location:'.$ayar['site_url'].'404');
                        }?>
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
