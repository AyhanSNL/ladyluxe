<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>

    <!-- Hepsiburada !-->
<?php if($_SESSION['main_alert'] =='hb_envanter_go_sorun'  ) {?>
    <div class="modal fade" id="modalGoster" >
        <div class="modal-dialog modal-dialog-centered modal-sm ">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                    <i class="fa fa-exclamation-triangle text-primary" style="font-size: 40px ; "></i><br>
                    <div class="text-primary" style="font-weight: bold; margin-bottom: 20px; font-size: 20px ;"><?=$diller['adminpanel-modal-text-4']?></div>
                    <div>
                        <?=$diller['pazaryeri-text-184']?>
                    </div>
                </div>
                <div class="category-cart-add-success-modal-footer">
                    <button type="button" class=" btn-primary btn-block p-2"  style="width: 100%; text-align: center; cursor: pointer " data-dismiss="modal"><?=$diller['adminpanel-modal-text-3']?></button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(window).on("load", function() {
            $('#modalGoster').modal('show');
        });
        $(window).load(function () {
            $('#modalGoster').modal('show');
        });
        var $modalDialog = $("#modalGoster");
        $modalDialog.modal('show');

        setTimeout(function() {
            $modalDialog.modal('hide');
        }, 0);
    </script>
    <?php if($adminRow['sound'] == '1' ) {?>
        <audio  autoplay>
            <source src="assets/images/uploads/hata.mp3" type="audio/mp3">
        </audio>
    <?php }?>
    <?php unset($_SESSION['main_alert']) ?>
<?php }?>
<?php if($_SESSION['main_alert'] =='hb_bagli_urun'  ) {?>
    <div class="modal fade" id="modalGoster" >
        <div class="modal-dialog modal-dialog-centered modal-sm ">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                    <i class="fa fa-exclamation-triangle text-primary" style="font-size: 40px ; "></i><br>
                    <div class="text-primary" style="font-weight: bold; margin-bottom: 20px; font-size: 20px ;"><?=$diller['adminpanel-modal-text-4']?></div>
                    <div>
                        <?=$diller['pazaryeri-text-201']?>
                    </div>
                </div>
                <div class="category-cart-add-success-modal-footer">
                    <button type="button" class=" btn-primary btn-block p-2"  style="width: 100%; text-align: center; cursor: pointer " data-dismiss="modal"><?=$diller['adminpanel-modal-text-3']?></button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(window).on("load", function() {
            $('#modalGoster').modal('show');
        });
        $(window).load(function () {
            $('#modalGoster').modal('show');
        });
        var $modalDialog = $("#modalGoster");
        $modalDialog.modal('show');

        setTimeout(function() {
            $modalDialog.modal('hide');
        }, 0);
    </script>
    <?php if($adminRow['sound'] == '1' ) {?>
        <audio  autoplay>
            <source src="assets/images/uploads/hata.mp3" type="audio/mp3">
        </audio>
    <?php }?>
    <?php unset($_SESSION['main_alert']) ?>
<?php }?>
<?php if($_SESSION['main_alert'] =='hb_sku_bos'  ) {?>
    <div class="modal fade" id="modalGoster" >
        <div class="modal-dialog modal-dialog-centered modal-sm ">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                    <i class="fa fa-exclamation-triangle text-primary" style="font-size: 40px ; "></i><br>
                    <div class="text-primary" style="font-weight: bold; margin-bottom: 20px; font-size: 20px ;"><?=$diller['adminpanel-modal-text-4']?></div>
                    <div>
                        <?=$diller['pazaryeri-text-202']?>
                    </div>
                </div>
                <div class="category-cart-add-success-modal-footer">
                    <button type="button" class=" btn-primary btn-block p-2"  style="width: 100%; text-align: center; cursor: pointer " data-dismiss="modal"><?=$diller['adminpanel-modal-text-3']?></button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(window).on("load", function() {
            $('#modalGoster').modal('show');
        });
        $(window).load(function () {
            $('#modalGoster').modal('show');
        });
        var $modalDialog = $("#modalGoster");
        $modalDialog.modal('show');

        setTimeout(function() {
            $modalDialog.modal('hide');
        }, 0);
    </script>
    <?php if($adminRow['sound'] == '1' ) {?>
        <audio  autoplay>
            <source src="assets/images/uploads/hata.mp3" type="audio/mp3">
        </audio>
    <?php }?>
    <?php unset($_SESSION['main_alert']) ?>
<?php }?>
<?php if($_SESSION['main_alert'] =='hb_stokkod_bos'  ) {?>
    <div class="modal fade" id="modalGoster" >
        <div class="modal-dialog modal-dialog-centered modal-sm ">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                    <i class="fa fa-exclamation-triangle text-primary" style="font-size: 40px ; "></i><br>
                    <div class="text-primary" style="font-weight: bold; margin-bottom: 20px; font-size: 20px ;"><?=$diller['adminpanel-modal-text-4']?></div>
                    <div>
                        <?=$diller['pazaryeri-text-215']?>
                    </div>
                </div>
                <div class="category-cart-add-success-modal-footer">
                    <button type="button" class=" btn-primary btn-block p-2"  style="width: 100%; text-align: center; cursor: pointer " data-dismiss="modal"><?=$diller['adminpanel-modal-text-3']?></button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(window).on("load", function() {
            $('#modalGoster').modal('show');
        });
        $(window).load(function () {
            $('#modalGoster').modal('show');
        });
        var $modalDialog = $("#modalGoster");
        $modalDialog.modal('show');

        setTimeout(function() {
            $modalDialog.modal('hide');
        }, 0);
    </script>
    <?php if($adminRow['sound'] == '1' ) {?>
        <audio  autoplay>
            <source src="assets/images/uploads/hata.mp3" type="audio/mp3">
        </audio>
    <?php }?>
    <?php unset($_SESSION['main_alert']) ?>
<?php }?>
<?php if($_SESSION['main_alert'] =='hb_inv_item_var'  ) {?>
    <div class="modal fade" id="modalGoster" >
        <div class="modal-dialog modal-dialog-centered modal-sm ">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                    <i class="fa fa-exclamation-triangle text-primary" style="font-size: 40px ; "></i><br>
                    <div class="text-primary" style="font-weight: bold; margin-bottom: 20px; font-size: 20px ;"><?=$diller['adminpanel-modal-text-4']?></div>
                    <div>
                        <?=$diller['pazaryeri-text-203']?>
                    </div>
                </div>
                <div class="category-cart-add-success-modal-footer">
                    <button type="button" class=" btn-primary btn-block p-2"  style="width: 100%; text-align: center; cursor: pointer " data-dismiss="modal"><?=$diller['adminpanel-modal-text-3']?></button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(window).on("load", function() {
            $('#modalGoster').modal('show');
        });
        $(window).load(function () {
            $('#modalGoster').modal('show');
        });
        var $modalDialog = $("#modalGoster");
        $modalDialog.modal('show');

        setTimeout(function() {
            $modalDialog.modal('hide');
        }, 0);
    </script>
    <?php if($adminRow['sound'] == '1' ) {?>
        <audio  autoplay>
            <source src="assets/images/uploads/hata.mp3" type="audio/mp3">
        </audio>
    <?php }?>
    <?php unset($_SESSION['main_alert']) ?>
<?php }?>
    <!--  <========SON=========>>> Hepsiburada SON !-->


<?php if($_SESSION['main_alert'] =='ty_export_nothing'  ) {?>
    <div class="modal fade" id="modalGoster" >
        <div class="modal-dialog modal-dialog-centered modal-sm ">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                    <i class="fa fa-exclamation-triangle text-primary" style="font-size: 40px ; "></i><br>
                    <div class="text-primary" style="font-weight: bold; margin-bottom: 20px; font-size: 20px ;"><?=$diller['adminpanel-modal-text-4']?></div>
                    <div>
                        <?=$diller['pazaryeri-text-124']?>
                    </div>
                </div>
                <div class="category-cart-add-success-modal-footer">
                    <button type="button" class=" btn-primary btn-block p-2"  style="width: 100%; text-align: center; cursor: pointer " data-dismiss="modal"><?=$diller['adminpanel-modal-text-3']?></button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(window).on("load", function() {
            $('#modalGoster').modal('show');
        });
        $(window).load(function () {
            $('#modalGoster').modal('show');
        });
        var $modalDialog = $("#modalGoster");
        $modalDialog.modal('show');

        setTimeout(function() {
            $modalDialog.modal('hide');
        }, 0);
    </script>
    <?php if($adminRow['sound'] == '1' ) {?>
        <audio  autoplay>
            <source src="assets/images/uploads/hata.mp3" type="audio/mp3">
        </audio>
    <?php }?>
    <?php unset($_SESSION['main_alert']) ?>
<?php }?>
<!-- Demo uyarı !-->
<?php if($_SESSION['main_alert'] =='demo'  ) {?>
    <div class="modal " id="modalGoster" >
        <div class="modal-dialog modal-dialog-centered modal-sm ">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                    <i class="fa fa-exclamation-triangle" style="font-size: 40px ; color: #f24734;"></i><br>
                    <div style="font-weight: bold; margin-bottom: 20px; font-size: 20px ; color: #f24734;"><?=$diller['adminpanel-modal-text-4']?></div>
                    <div>
                        <?=$diller['adminpanel-modal-text-5']?>
                    </div>
                </div>
                <div class="category-cart-add-success-modal-footer">
                    <button type="button" class=" btn-danger btn-block p-2"  style="width: 100%; text-align: center; cursor: pointer " data-dismiss="modal"><?=$diller['adminpanel-modal-text-6']?></button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(window).on("load", function() {
            $('#modalGoster').modal('show');
        });
        $(window).load(function () {
            $('#modalGoster').modal('show');
        });
        var $modalDialog = $("#modalGoster");
        $modalDialog.modal('show');

        setTimeout(function() {
            $modalDialog.modal('hide');
        }, 0);
    </script>
    <?php if($adminRow['sound'] == '1' ) {?>
        <audio  autoplay>
            <source src="assets/images/uploads/hata.mp3" type="audio/mp3">
        </audio>
    <?php }?>
    <?php unset($_SESSION['main_alert']) ?>
<?php }?>
<!--  <========SON=========>>> Demo uyarı SON !-->
<?php if($_SESSION['main_alert'] =='altkatsec'  ) {?>
    <div class="modal fade" id="modalGoster" >
        <div class="modal-dialog modal-dialog-centered modal-sm ">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                    <i class="fa fa-exclamation-triangle text-primary" style="font-size: 40px ; "></i><br>
                    <div class="text-primary" style="font-weight: bold; margin-bottom: 20px; font-size: 20px ;"><?=$diller['adminpanel-modal-text-4']?></div>
                    <div>
                      <?=$diller['adminpanel-modal-text-54']?>
                    </div>
                </div>
                <div class="category-cart-add-success-modal-footer">
                    <button type="button" class=" btn-primary btn-block p-2"  style="width: 100%; text-align: center; cursor: pointer " data-dismiss="modal"><?=$diller['adminpanel-modal-text-3']?></button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(window).on("load", function() {
            $('#modalGoster').modal('show');
        });
        $(window).load(function () {
            $('#modalGoster').modal('show');
        });
        var $modalDialog = $("#modalGoster");
        $modalDialog.modal('show');

        setTimeout(function() {
            $modalDialog.modal('hide');
        }, 0);
    </script>
    <?php if($adminRow['sound'] == '1' ) {?>
        <audio  autoplay>
            <source src="assets/images/uploads/hata.mp3" type="audio/mp3">
        </audio>
    <?php }?>
    <?php unset($_SESSION['main_alert']) ?>
<?php }?>
<?php if($_SESSION['main_alert'] =='musteri_hata'  ) {
    //todo paraşüt modal...

    ?>
    <div class="modal fade" id="modalGoster" >
        <div class="modal-dialog modal-dialog-centered modal-sm ">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                    <i class="fa fa-exclamation-triangle text-primary" style="font-size: 40px ; "></i><br>
                    <div class="text-primary" style="font-weight: bold; margin-bottom: 20px; font-size: 20px ;"><?=$diller['adminpanel-modal-text-4']?></div>
                    <div>
                        <?=$diller['adminpanel-modal-text-55']?>
                    </div>
                </div>
                <div class="category-cart-add-success-modal-footer">
                    <button type="button" class=" btn-primary btn-block p-2"  style="width: 100%; text-align: center; cursor: pointer " data-dismiss="modal"><?=$diller['adminpanel-modal-text-3']?></button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(window).on("load", function() {
            $('#modalGoster').modal('show');
        });
        $(window).load(function () {
            $('#modalGoster').modal('show');
        });
        var $modalDialog = $("#modalGoster");
        $modalDialog.modal('show');

        setTimeout(function() {
            $modalDialog.modal('hide');
        }, 0);
    </script>
    <?php if($adminRow['sound'] == '1' ) {?>
        <audio  autoplay>
            <source src="assets/images/uploads/hata.mp3" type="audio/mp3">
        </audio>
    <?php }?>
    <?php unset($_SESSION['main_alert']) ?>
<?php }?>
<?php if($_SESSION['main_alert'] =='parasut_hata_201'  ) {
    //todo paraşüt modal...
    ?>
    <div class="modal fade" id="modalGoster" >
        <div class="modal-dialog modal-dialog-centered modal-sm ">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                    <i class="fa fa-exclamation-triangle text-primary" style="font-size: 40px ; "></i><br>
                    <div class="text-primary" style="font-weight: bold; margin-bottom: 20px; font-size: 20px ;"><?=$diller['adminpanel-modal-text-4']?></div>
                    <div>
                        <?=$diller['parasut-text-12']?>
                    </div>
                </div>
                <div class="category-cart-add-success-modal-footer">
                    <button type="button" class=" btn-primary btn-block p-2"  style="width: 100%; text-align: center; cursor: pointer " data-dismiss="modal"><?=$diller['adminpanel-modal-text-3']?></button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(window).on("load", function() {
            $('#modalGoster').modal('show');
        });
        $(window).load(function () {
            $('#modalGoster').modal('show');
        });
        var $modalDialog = $("#modalGoster");
        $modalDialog.modal('show');

        setTimeout(function() {
            $modalDialog.modal('hide');
        }, 0);
    </script>
    <?php if($adminRow['sound'] == '1' ) {?>
        <audio  autoplay>
            <source src="assets/images/uploads/hata.mp3" type="audio/mp3">
        </audio>
    <?php }?>
    <?php unset($_SESSION['main_alert']) ?>
<?php }?>
<?php if($_SESSION['main_alert'] =='n11hata'  ) {?>
    <div class="modal fade" id="modalGoster" >
        <div class="modal-dialog modal-dialog-centered modal-sm ">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                    <i class="fa fa-exclamation-triangle text-primary" style="font-size: 40px ; "></i><br>
                    <div class="text-primary" style="font-weight: bold; margin-bottom: 20px; font-size: 20px ;"><?=$diller['adminpanel-modal-text-4']?></div>
                    <div>
                        <?=$diller['adminpanel-modal-text-55']?>
                    </div>
                </div>
                <div class="category-cart-add-success-modal-footer">
                    <button type="button" class=" btn-primary btn-block p-2"  style="width: 100%; text-align: center; cursor: pointer " data-dismiss="modal"><?=$diller['adminpanel-modal-text-3']?></button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(window).on("load", function() {
            $('#modalGoster').modal('show');
        });
        $(window).load(function () {
            $('#modalGoster').modal('show');
        });
        var $modalDialog = $("#modalGoster");
        $modalDialog.modal('show');

        setTimeout(function() {
            $modalDialog.modal('hide');
        }, 0);
    </script>
    <?php if($adminRow['sound'] == '1' ) {?>
        <audio  autoplay>
            <source src="assets/images/uploads/hata.mp3" type="audio/mp3">
        </audio>
    <?php }?>
    <?php unset($_SESSION['main_alert']) ?>
<?php }?>
<?php if($_SESSION['main_alert'] =='varyant_stok_var'  ) {?>
    <div class="modal fade" id="modalGoster" >
        <div class="modal-dialog modal-dialog-centered modal-sm ">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                    <i class="fa fa-exclamation-triangle text-primary" style="font-size: 40px ; "></i><br>
                    <div class="text-primary" style="font-weight: bold; margin-bottom: 20px; font-size: 20px ;"><?=$diller['adminpanel-modal-text-4']?></div>
                    <div>
                        <?=$diller['adminpanel-modal-text-49']?>
                    </div>
                </div>
                <div class="category-cart-add-success-modal-footer">
                    <button type="button" class=" btn-primary btn-block p-2"  style="width: 100%; text-align: center; cursor: pointer " data-dismiss="modal"><?=$diller['adminpanel-modal-text-3']?></button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(window).on("load", function() {
            $('#modalGoster').modal('show');
        });
        $(window).load(function () {
            $('#modalGoster').modal('show');
        });
        var $modalDialog = $("#modalGoster");
        $modalDialog.modal('show');

        setTimeout(function() {
            $modalDialog.modal('hide');
        }, 0);
    </script>
    <?php if($adminRow['sound'] == '1' ) {?>
        <audio  autoplay>
            <source src="assets/images/uploads/hata.mp3" type="audio/mp3">
        </audio>
    <?php }?>
    <?php unset($_SESSION['main_alert']) ?>
<?php }?>
<?php if($_SESSION['main_alert'] =='varyant_var'  ) {?>
    <div class="modal fade" id="modalGoster" >
        <div class="modal-dialog modal-dialog-centered modal-sm ">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                    <i class="fa fa-exclamation-triangle text-primary" style="font-size: 40px ; "></i><br>
                    <div class="text-primary" style="font-weight: bold; margin-bottom: 20px; font-size: 20px ;"><?=$diller['adminpanel-modal-text-4']?></div>
                    <div>
                        <?=$diller['adminpanel-modal-text-48']?>
                    </div>
                </div>
                <div class="category-cart-add-success-modal-footer">
                    <button type="button" class=" btn-primary btn-block p-2"  style="width: 100%; text-align: center; cursor: pointer " data-dismiss="modal"><?=$diller['adminpanel-modal-text-3']?></button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(window).on("load", function() {
            $('#modalGoster').modal('show');
        });
        $(window).load(function () {
            $('#modalGoster').modal('show');
        });
        var $modalDialog = $("#modalGoster");
        $modalDialog.modal('show');

        setTimeout(function() {
            $modalDialog.modal('hide');
        }, 0);
    </script>
    <?php if($adminRow['sound'] == '1' ) {?>
        <audio  autoplay>
            <source src="assets/images/uploads/hata.mp3" type="audio/mp3">
        </audio>
    <?php }?>
    <?php unset($_SESSION['main_alert']) ?>
<?php }?>
<?php if($_SESSION['main_alert'] =='variant_tur_2'  ) {?>
    <div class="modal fade" id="modalGoster" >
        <div class="modal-dialog modal-dialog-centered modal-sm ">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                    <i class="fa fa-exclamation-triangle text-primary" style="font-size: 40px ; "></i><br>
                    <div class="text-primary" style="font-weight: bold; margin-bottom: 20px; font-size: 20px ;"><?=$diller['adminpanel-modal-text-4']?></div>
                    <div>
                        <?=$diller['adminpanel-form-text-1825']?>
                    </div>
                </div>
                <div class="category-cart-add-success-modal-footer">
                    <button type="button" class=" btn-primary btn-block p-2"  style="width: 100%; text-align: center; cursor: pointer " data-dismiss="modal"><?=$diller['adminpanel-modal-text-3']?></button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(window).on("load", function() {
            $('#modalGoster').modal('show');
        });
        $(window).load(function () {
            $('#modalGoster').modal('show');
        });
        var $modalDialog = $("#modalGoster");
        $modalDialog.modal('show');

        setTimeout(function() {
            $modalDialog.modal('hide');
        }, 0);
    </script>
    <?php if($adminRow['sound'] == '1' ) {?>
        <audio  autoplay>
            <source src="assets/images/uploads/hata.mp3" type="audio/mp3">
        </audio>
    <?php }?>
    <?php unset($_SESSION['main_alert']) ?>
<?php }?>
<?php if($_SESSION['main_alert'] =='filtreden_var'  ) {?>
    <div class="modal fade" id="modalGoster" >
        <div class="modal-dialog modal-dialog-centered modal-sm ">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                    <i class="fa fa-exclamation-triangle text-primary" style="font-size: 40px ; "></i><br>
                    <div class="text-primary" style="font-weight: bold; margin-bottom: 20px; font-size: 20px ;"><?=$diller['adminpanel-modal-text-4']?></div>
                    <div>
                        <?=$diller['adminpanel-modal-text-47']?>
                    </div>
                </div>
                <div class="category-cart-add-success-modal-footer">
                    <button type="button" class=" btn-primary btn-block p-2"  style="width: 100%; text-align: center; cursor: pointer " data-dismiss="modal"><?=$diller['adminpanel-modal-text-3']?></button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(window).on("load", function() {
            $('#modalGoster').modal('show');
        });
        $(window).load(function () {
            $('#modalGoster').modal('show');
        });
        var $modalDialog = $("#modalGoster");
        $modalDialog.modal('show');

        setTimeout(function() {
            $modalDialog.modal('hide');
        }, 0);
    </script>
    <?php if($adminRow['sound'] == '1' ) {?>
        <audio  autoplay>
            <source src="assets/images/uploads/hata.mp3" type="audio/mp3">
        </audio>
    <?php }?>
    <?php unset($_SESSION['main_alert']) ?>
<?php }?>
<?php if($_SESSION['main_alert'] =='old_new_pass_error'  ) {?>
    <div class="modal fade" id="modalGoster" >
        <div class="modal-dialog modal-dialog-centered modal-sm ">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                    <i class="fa fa-exclamation-triangle text-primary" style="font-size: 40px ; "></i><br>
                    <div class="text-primary" style="font-weight: bold; margin-bottom: 20px; font-size: 20px ;"><?=$diller['adminpanel-modal-text-4']?></div>
                    <div>
                        <?=$diller['adminpanel-modal-text-41']?>
                    </div>
                </div>
                <div class="category-cart-add-success-modal-footer">
                    <button type="button" class=" btn-primary btn-block p-2"  style="width: 100%; text-align: center; cursor: pointer " data-dismiss="modal"><?=$diller['adminpanel-modal-text-3']?></button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(window).on("load", function() {
            $('#modalGoster').modal('show');
        });
        $(window).load(function () {
            $('#modalGoster').modal('show');
        });
        var $modalDialog = $("#modalGoster");
        $modalDialog.modal('show');

        setTimeout(function() {
            $modalDialog.modal('hide');
        }, 0);
    </script>
    <?php if($adminRow['sound'] == '1' ) {?>
        <audio  autoplay>
            <source src="assets/images/uploads/hata.mp3" type="audio/mp3">
        </audio>
    <?php }?>
    <?php unset($_SESSION['main_alert']) ?>
<?php }?>
<?php if($_SESSION['main_alert'] =='new_password_error'  ) {?>
    <div class="modal fade" id="modalGoster" >
        <div class="modal-dialog modal-dialog-centered modal-sm ">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                    <i class="fa fa-exclamation-triangle text-primary" style="font-size: 40px ; "></i><br>
                    <div class="text-primary" style="font-weight: bold; margin-bottom: 20px; font-size: 20px ;"><?=$diller['adminpanel-modal-text-4']?></div>
                    <div>
                        <?=$diller['adminpanel-modal-text-40']?>
                    </div>
                </div>
                <div class="category-cart-add-success-modal-footer">
                    <button type="button" class=" btn-primary btn-block p-2"  style="width: 100%; text-align: center; cursor: pointer " data-dismiss="modal"><?=$diller['adminpanel-modal-text-3']?></button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(window).on("load", function() {
            $('#modalGoster').modal('show');
        });
        $(window).load(function () {
            $('#modalGoster').modal('show');
        });
        var $modalDialog = $("#modalGoster");
        $modalDialog.modal('show');

        setTimeout(function() {
            $modalDialog.modal('hide');
        }, 0);
    </script>
    <?php if($adminRow['sound'] == '1' ) {?>
        <audio  autoplay>
            <source src="assets/images/uploads/hata.mp3" type="audio/mp3">
        </audio>
    <?php }?>
    <?php unset($_SESSION['main_alert']) ?>
<?php }?>
<?php if($_SESSION['main_alert'] =='old_password_error'  ) {?>
    <div class="modal fade" id="modalGoster" >
        <div class="modal-dialog modal-dialog-centered modal-sm ">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                    <i class="fa fa-exclamation-triangle text-primary" style="font-size: 40px ; "></i><br>
                    <div class="text-primary" style="font-weight: bold; margin-bottom: 20px; font-size: 20px ;"><?=$diller['adminpanel-modal-text-4']?></div>
                    <div>
                        <?=$diller['adminpanel-modal-text-39']?>
                    </div>
                </div>
                <div class="category-cart-add-success-modal-footer">
                    <button type="button" class=" btn-primary btn-block p-2"  style="width: 100%; text-align: center; cursor: pointer " data-dismiss="modal"><?=$diller['adminpanel-modal-text-3']?></button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(window).on("load", function() {
            $('#modalGoster').modal('show');
        });
        $(window).load(function () {
            $('#modalGoster').modal('show');
        });
        var $modalDialog = $("#modalGoster");
        $modalDialog.modal('show');

        setTimeout(function() {
            $modalDialog.modal('hide');
        }, 0);
    </script>
    <?php if($adminRow['sound'] == '1' ) {?>
        <audio  autoplay>
            <source src="assets/images/uploads/hata.mp3" type="audio/mp3">
        </audio>
    <?php }?>
    <?php unset($_SESSION['main_alert']) ?>
<?php }?>
<?php if($_SESSION['main_alert'] =='invoice_theme_alert') {?>
    <div class="modal fade" id="modalGoster" >
        <div class="modal-dialog modal-dialog-centered modal-sm ">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                    <i class="fa fa-exclamation-triangle text-primary" style="font-size: 40px ; "></i><br>
                    <div class="text-primary" style="font-weight: bold; margin-bottom: 20px; font-size: 20px ;"><?=$diller['adminpanel-modal-text-4']?></div>
                    <div>
                        <?=$diller['adminpanel-modal-text-38']?>
                    </div>
                </div>
                <div class="category-cart-add-success-modal-footer">
                    <button type="button" class=" btn-primary btn-block p-2"  style="width: 100%; text-align: center; cursor: pointer " data-dismiss="modal"><?=$diller['adminpanel-modal-text-3']?></button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(window).on("load", function() {
            $('#modalGoster').modal('show');
        });
        $(window).load(function () {
            $('#modalGoster').modal('show');
        });
        var $modalDialog = $("#modalGoster");
        $modalDialog.modal('show');

        setTimeout(function() {
            $modalDialog.modal('hide');
        }, 0);
    </script>
    <?php if($adminRow['sound'] == '1' ) {?>
        <audio  autoplay>
            <source src="assets/images/uploads/hata.mp3" type="audio/mp3">
        </audio>
    <?php }?>
    <?php unset($_SESSION['main_alert']) ?>
<?php }?>
<?php if($_SESSION['main_alert'] =='smsnotihave'  ) {?>
    <div class="modal fade" id="modalGoster" >
        <div class="modal-dialog modal-dialog-centered modal-sm ">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                    <i class="fa fa-exclamation-triangle text-primary" style="font-size: 40px ; "></i><br>
                    <div class="text-primary" style="font-weight: bold; margin-bottom: 20px; font-size: 20px ;"><?=$diller['adminpanel-modal-text-4']?></div>
                    <div>
                        <?=$diller['adminpanel-modal-text-23']?>
                    </div>
                </div>
                <div class="category-cart-add-success-modal-footer">
                    <button type="button" class=" btn-primary btn-block p-2"  style="width: 100%; text-align: center; cursor: pointer " data-dismiss="modal"><?=$diller['adminpanel-modal-text-3']?></button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(window).on("load", function() {
            $('#modalGoster').modal('show');
        });
        $(window).load(function () {
            $('#modalGoster').modal('show');
        });
        var $modalDialog = $("#modalGoster");
        $modalDialog.modal('show');

        setTimeout(function() {
            $modalDialog.modal('hide');
        }, 0);
    </script>
    <?php if($adminRow['sound'] == '1' ) {?>
        <audio  autoplay>
            <source src="assets/images/uploads/hata.mp3" type="audio/mp3">
        </audio>
    <?php }?>
    <?php unset($_SESSION['main_alert']) ?>
<?php }?>
<?php if($_SESSION['main_alert'] =='emailnotihave'  ) {?>
    <div class="modal fade" id="modalGoster" >
        <div class="modal-dialog modal-dialog-centered modal-sm ">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                    <i class="fa fa-exclamation-triangle text-primary" style="font-size: 40px ; "></i><br>
                    <div class="text-primary" style="font-weight: bold; margin-bottom: 20px; font-size: 20px ;"><?=$diller['adminpanel-modal-text-4']?></div>
                    <div>
                        <?=$diller['adminpanel-modal-text-30']?>
                    </div>
                </div>
                <div class="category-cart-add-success-modal-footer">
                    <button type="button" class=" btn-primary btn-block p-2"  style="width: 100%; text-align: center; cursor: pointer " data-dismiss="modal"><?=$diller['adminpanel-modal-text-3']?></button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(window).on("load", function() {
            $('#modalGoster').modal('show');
        });
        $(window).load(function () {
            $('#modalGoster').modal('show');
        });
        var $modalDialog = $("#modalGoster");
        $modalDialog.modal('show');

        setTimeout(function() {
            $modalDialog.modal('hide');
        }, 0);
    </script>
    <?php if($adminRow['sound'] == '1' ) {?>
        <audio  autoplay>
            <source src="assets/images/uploads/hata.mp3" type="audio/mp3">
        </audio>
    <?php }?>
    <?php unset($_SESSION['main_alert']) ?>
<?php }?>
<?php if($_SESSION['main_alert'] =='emailerror'  ) {?>
    <div class="modal fade" id="modalGoster" >
        <div class="modal-dialog modal-dialog-centered modal-sm ">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                    <i class="fa fa-exclamation-triangle text-primary" style="font-size: 40px ; "></i><br>
                    <div class="text-primary" style="font-weight: bold; margin-bottom: 20px; font-size: 20px ;"><?=$diller['adminpanel-modal-text-4']?></div>
                    <div>
                        <?=$diller['adminpanel-modal-text-20']?>
                    </div>
                </div>
                <div class="category-cart-add-success-modal-footer">
                    <button type="button" class=" btn-primary btn-block p-2"  style="width: 100%; text-align: center; cursor: pointer " data-dismiss="modal"><?=$diller['adminpanel-modal-text-3']?></button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(window).on("load", function() {
            $('#modalGoster').modal('show');
        });
        $(window).load(function () {
            $('#modalGoster').modal('show');
        });
        var $modalDialog = $("#modalGoster");
        $modalDialog.modal('show');

        setTimeout(function() {
            $modalDialog.modal('hide');
        }, 0);
    </script>
    <?php if($adminRow['sound'] == '1' ) {?>
        <audio  autoplay>
            <source src="assets/images/uploads/hata.mp3" type="audio/mp3">
        </audio>
    <?php }?>
    <?php unset($_SESSION['main_alert']) ?>
<?php }?>
<?php if($_SESSION['main_alert'] =='emailhave'  ) {?>
    <div class="modal fade" id="modalGoster" >
        <div class="modal-dialog modal-dialog-centered modal-sm ">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                    <i class="fa fa-exclamation-triangle text-primary" style="font-size: 40px ; "></i><br>
                    <div class="text-primary" style="font-weight: bold; margin-bottom: 20px; font-size: 20px ;"><?=$diller['adminpanel-modal-text-4']?></div>
                    <div>
                        <?=$diller['adminpanel-modal-text-26']?>
                    </div>
                </div>
                <div class="category-cart-add-success-modal-footer">
                    <button type="button" class=" btn-primary btn-block p-2"  style="width: 100%; text-align: center; cursor: pointer " data-dismiss="modal"><?=$diller['adminpanel-modal-text-3']?></button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(window).on("load", function() {
            $('#modalGoster').modal('show');
        });
        $(window).load(function () {
            $('#modalGoster').modal('show');
        });
        var $modalDialog = $("#modalGoster");
        $modalDialog.modal('show');

        setTimeout(function() {
            $modalDialog.modal('hide');
        }, 0);
    </script>
    <?php if($adminRow['sound'] == '1' ) {?>
        <audio  autoplay>
            <source src="assets/images/uploads/hata.mp3" type="audio/mp3">
        </audio>
    <?php }?>
    <?php unset($_SESSION['main_alert']) ?>
<?php }?>
<?php if($_SESSION['main_alert'] =='smsoff'  ) {?>
    <div class="modal fade" id="modalGoster" >
        <div class="modal-dialog modal-dialog-centered modal-sm ">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                    <i class="fa fa-exclamation-triangle text-primary" style="font-size: 40px ; "></i><br>
                    <div class="text-primary" style="font-weight: bold; margin-bottom: 20px; font-size: 20px ;"><?=$diller['adminpanel-modal-text-4']?></div>
                    <div>
                        <?=$diller['adminpanel-modal-text-22']?>
                    </div>
                </div>
                <div class="category-cart-add-success-modal-footer">
                    <button type="button" class=" btn-primary btn-block p-2"  style="width: 100%; text-align: center; cursor: pointer " data-dismiss="modal"><?=$diller['adminpanel-modal-text-3']?></button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(window).on("load", function() {
            $('#modalGoster').modal('show');
        });
        $(window).load(function () {
            $('#modalGoster').modal('show');
        });
        var $modalDialog = $("#modalGoster");
        $modalDialog.modal('show');

        setTimeout(function() {
            $modalDialog.modal('hide');
        }, 0);
    </script>
    <?php if($adminRow['sound'] == '1' ) {?>
        <audio  autoplay>
            <source src="assets/images/uploads/hata.mp3" type="audio/mp3">
        </audio>
    <?php }?>
    <?php unset($_SESSION['main_alert']) ?>
<?php }?>
<?php if($_SESSION['main_alert'] =='smszaten'  ) {?>
    <div class="modal fade" id="modalGoster" >
        <div class="modal-dialog modal-dialog-centered modal-sm ">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                    <i class="fa fa-exclamation-triangle text-primary" style="font-size: 40px ; "></i><br>
                    <div class="text-primary" style="font-weight: bold; margin-bottom: 20px; font-size: 20px ;"><?=$diller['adminpanel-modal-text-4']?></div>
                    <div>
                        <?=$diller['adminpanel-modal-text-23']?>
                    </div>
                </div>
                <div class="category-cart-add-success-modal-footer">
                    <button type="button" class=" btn-primary  p-2 mr-2"  style="width:45%; text-align: center; cursor: pointer " data-dismiss="modal"><?=$diller['adminpanel-modal-text-3']?></button>
                    <?php if($_SESSION['smszaten']=='kupon'  ) {?>
                        <a  href="<?=$_SESSION['smszatenurl']?>" class=" btn-success  p-2"  style="width:45%; text-align: center; cursor: pointer " ><?=$diller['adminpanel-modal-text-24']?></a>
                    <?php }?>

                </div>
            </div>
        </div>
    </div>
    <script>
        $(window).on("load", function() {
            $('#modalGoster').modal('show');
        });
        $(window).load(function () {
            $('#modalGoster').modal('show');
        });
        var $modalDialog = $("#modalGoster");
        $modalDialog.modal('show');

        setTimeout(function() {
            $modalDialog.modal('hide');
        }, 0);
    </script>
    <?php if($adminRow['sound'] == '1' ) {?>
        <audio  autoplay>
            <source src="assets/images/uploads/hata.mp3" type="audio/mp3">
        </audio>
    <?php }?>
    <?php unset($_SESSION['main_alert']) ?>
<?php }?>
<?php if($_SESSION['main_alert'] =='smtpoff'  ) {?>
    <div class="modal fade" id="modalGoster" >
        <div class="modal-dialog modal-dialog-centered modal-sm ">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                    <i class="fa fa-exclamation-triangle text-primary" style="font-size: 40px ; "></i><br>
                    <div class="text-primary" style="font-weight: bold; margin-bottom: 20px; font-size: 20px ;"><?=$diller['adminpanel-modal-text-4']?></div>
                    <div>
                        <?=$diller['adminpanel-modal-text-25']?>
                    </div>
                </div>
                <div class="category-cart-add-success-modal-footer">
                    <button type="button" class=" btn-primary btn-block p-2"  style="width: 100%; text-align: center; cursor: pointer " data-dismiss="modal"><?=$diller['adminpanel-modal-text-3']?></button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(window).on("load", function() {
            $('#modalGoster').modal('show');
        });
        $(window).load(function () {
            $('#modalGoster').modal('show');
        });
        var $modalDialog = $("#modalGoster");
        $modalDialog.modal('show');

        setTimeout(function() {
            $modalDialog.modal('hide');
        }, 0);
    </script>
    <?php if($adminRow['sound'] == '1' ) {?>
        <audio  autoplay>
            <source src="assets/images/uploads/hata.mp3" type="audio/mp3">
        </audio>
    <?php }?>
    <?php unset($_SESSION['main_alert']) ?>
<?php }?>
<?php if($_SESSION['main_alert'] =='smtperror'  ) {?>
    <div class="modal fade" id="modalGoster" >
        <div class="modal-dialog modal-dialog-centered modal-sm ">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                    <i class="fa fa-exclamation-triangle text-primary" style="font-size: 40px ; "></i><br>
                    <div class="text-primary" style="font-weight: bold; margin-bottom: 20px; font-size: 20px ;"><?=$diller['adminpanel-modal-text-4']?></div>
                    <div>
                        <?=$diller['adminpanel-modal-text-27']?>
                    </div>
                </div>
                <div class="category-cart-add-success-modal-footer">
                    <button type="button" class=" btn-primary btn-block p-2"  style="width: 100%; text-align: center; cursor: pointer " data-dismiss="modal"><?=$diller['adminpanel-modal-text-3']?></button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(window).on("load", function() {
            $('#modalGoster').modal('show');
        });
        $(window).load(function () {
            $('#modalGoster').modal('show');
        });
        var $modalDialog = $("#modalGoster");
        $modalDialog.modal('show');

        setTimeout(function() {
            $modalDialog.modal('hide');
        }, 0);
    </script>
    <?php if($adminRow['sound'] == '1' ) {?>
        <audio  autoplay>
            <source src="assets/images/uploads/hata.mp3" type="audio/mp3">
        </audio>
    <?php }?>
    <?php unset($_SESSION['main_alert']) ?>
<?php }?>
<?php if($_SESSION['main_alert'] =='gsmuzunluk'  ) {?>
    <div class="modal fade" id="modalGoster" >
        <div class="modal-dialog modal-dialog-centered modal-sm ">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                    <i class="fa fa-exclamation-triangle text-primary" style="font-size: 40px ; "></i><br>
                    <div class="text-primary" style="font-weight: bold; margin-bottom: 20px; font-size: 20px ;"><?=$diller['adminpanel-modal-text-4']?></div>
                    <div>
                        <?=$diller['adminpanel-modal-text-28']?>
                    </div>
                </div>
                <div class="category-cart-add-success-modal-footer">
                    <button type="button" class=" btn-primary btn-block p-2"  style="width: 100%; text-align: center; cursor: pointer " data-dismiss="modal"><?=$diller['adminpanel-modal-text-3']?></button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(window).on("load", function() {
            $('#modalGoster').modal('show');
        });
        $(window).load(function () {
            $('#modalGoster').modal('show');
        });
        var $modalDialog = $("#modalGoster");
        $modalDialog.modal('show');

        setTimeout(function() {
            $modalDialog.modal('hide');
        }, 0);
    </script>
    <?php if($adminRow['sound'] == '1' ) {?>
        <audio  autoplay>
            <source src="assets/images/uploads/hata.mp3" type="audio/mp3">
        </audio>
    <?php }?>
    <?php unset($_SESSION['main_alert']) ?>
<?php }?>
<?php if($_SESSION['main_alert'] =='gsmvar'  ) {?>
    <div class="modal fade" id="modalGoster" >
        <div class="modal-dialog modal-dialog-centered modal-sm ">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                    <i class="fa fa-exclamation-triangle text-primary" style="font-size: 40px ; "></i><br>
                    <div class="text-primary" style="font-weight: bold; margin-bottom: 20px; font-size: 20px ;"><?=$diller['adminpanel-modal-text-4']?></div>
                    <div>
                        <?=$diller['adminpanel-modal-text-29']?>
                    </div>
                </div>
                <div class="category-cart-add-success-modal-footer">
                    <button type="button" class=" btn-primary btn-block p-2"  style="width: 100%; text-align: center; cursor: pointer " data-dismiss="modal"><?=$diller['adminpanel-modal-text-3']?></button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(window).on("load", function() {
            $('#modalGoster').modal('show');
        });
        $(window).load(function () {
            $('#modalGoster').modal('show');
        });
        var $modalDialog = $("#modalGoster");
        $modalDialog.modal('show');

        setTimeout(function() {
            $modalDialog.modal('hide');
        }, 0);
    </script>
    <?php if($adminRow['sound'] == '1' ) {?>
        <audio  autoplay>
            <source src="assets/images/uploads/hata.mp3" type="audio/mp3">
        </audio>
    <?php }?>
    <?php unset($_SESSION['main_alert']) ?>
<?php }?>
<?php if($_SESSION['main_alert'] =='seflink'  ) {?>
    <div class="modal fade" id="modalGoster" >
        <div class="modal-dialog modal-dialog-centered modal-sm ">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                    <i class="fa fa-exclamation-triangle text-primary" style="font-size: 40px ; "></i><br>
                    <div class="text-primary" style="font-weight: bold; margin-bottom: 20px; font-size: 20px ;"><?=$diller['adminpanel-modal-text-4']?></div>
                    <div>
                        <?=$diller['adminpanel-modal-text-19']?>
                    </div>
                </div>
                <div class="category-cart-add-success-modal-footer">
                    <button type="button" class=" btn-primary btn-block p-2"  style="width: 100%; text-align: center; cursor: pointer " data-dismiss="modal"><?=$diller['adminpanel-modal-text-3']?></button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(window).on("load", function() {
            $('#modalGoster').modal('show');
        });
        $(window).load(function () {
            $('#modalGoster').modal('show');
        });
        var $modalDialog = $("#modalGoster");
        $modalDialog.modal('show');

        setTimeout(function() {
            $modalDialog.modal('hide');
        }, 0);
    </script>
    <?php if($adminRow['sound'] == '1' ) {?>
        <audio  autoplay>
            <source src="assets/images/uploads/hata.mp3" type="audio/mp3">
        </audio>
    <?php }?>
    <?php unset($_SESSION['main_alert']) ?>
<?php }?>
<?php if($_SESSION['main_alert'] =='empty'  ) {?>
    <div class="modal fade" id="modalGoster" >
        <div class="modal-dialog modal-dialog-centered modal-sm ">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                    <i class="fa fa-exclamation-triangle text-primary" style="font-size: 40px ; "></i><br>
                    <div class="text-primary" style="font-weight: bold; margin-bottom: 20px; font-size: 20px ;"><?=$diller['adminpanel-modal-text-4']?></div>
                    <div>
                        <?=$diller['adminpanel-modal-text-7']?>
                    </div>
                </div>
                <div class="category-cart-add-success-modal-footer">
                    <button type="button" class=" btn-primary btn-block p-2"  style="width: 100%; text-align: center; cursor: pointer " data-dismiss="modal"><?=$diller['adminpanel-modal-text-3']?></button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(window).on("load", function() {
            $('#modalGoster').modal('show');
        });
        $(window).load(function () {
            $('#modalGoster').modal('show');
        });
        var $modalDialog = $("#modalGoster");
        $modalDialog.modal('show');

        setTimeout(function() {
            $modalDialog.modal('hide');
        }, 0);
    </script>
    <?php if($adminRow['sound'] == '1' ) {?>
        <audio  autoplay>
            <source src="assets/images/uploads/hata.mp3" type="audio/mp3">
        </audio>
    <?php }?>
    <?php unset($_SESSION['main_alert']) ?>
<?php }?>
<?php if($_SESSION['main_alert'] =='zorunlu'  ) {?>
    <div class="modal fade" id="modalGoster" >
        <div class="modal-dialog modal-dialog-centered modal-sm ">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                    <i class="fa fa-exclamation-triangle text-primary" style="font-size: 40px ; "></i><br>
                    <div class="text-primary" style="font-weight: bold; margin-bottom: 20px; font-size: 20px ;"><?=$diller['adminpanel-modal-text-4']?></div>
                    <div>
                        <?=$diller['adminpanel-modal-text-13']?>
                    </div>
                </div>
                <div class="category-cart-add-success-modal-footer">
                    <button type="button" class=" btn-primary btn-block p-2"  style="width: 100%; text-align: center; cursor: pointer " data-dismiss="modal"><?=$diller['adminpanel-modal-text-3']?></button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(window).on("load", function() {
            $('#modalGoster').modal('show');
        });
        $(window).load(function () {
            $('#modalGoster').modal('show');
        });
        var $modalDialog = $("#modalGoster");
        $modalDialog.modal('show');

        setTimeout(function() {
            $modalDialog.modal('hide');
        }, 0);
    </script>
    <?php if($adminRow['sound'] == '1' ) {?>
        <audio  autoplay>
            <source src="assets/images/uploads/hata.mp3" type="audio/mp3">
        </audio>
    <?php }?>
    <?php unset($_SESSION['main_alert']) ?>
<?php }?>
<?php if($_SESSION['main_alert'] =='filesize'  ) {?>
    <div class="modal fade" id="modalGoster" >
        <div class="modal-dialog modal-dialog-centered modal-sm ">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                    <i class="fa fa-exclamation-triangle text-primary" style="font-size: 40px ; "></i><br>
                    <div class="text-primary" style="font-weight: bold; margin-bottom: 20px; font-size: 20px ;"><?=$diller['adminpanel-modal-text-4']?></div>
                    <div>
                        <?=$diller['adminpanel-modal-text-14']?>
                    </div>
                </div>
                <div class="category-cart-add-success-modal-footer">
                    <button type="button" class=" btn-primary btn-block p-2"  style="width: 100%; text-align: center; cursor: pointer " data-dismiss="modal"><?=$diller['adminpanel-modal-text-3']?></button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(window).on("load", function() {
            $('#modalGoster').modal('show');
        });
        $(window).load(function () {
            $('#modalGoster').modal('show');
        });
        var $modalDialog = $("#modalGoster");
        $modalDialog.modal('show');

        setTimeout(function() {
            $modalDialog.modal('hide');
        }, 0);
    </script>
    <?php if($adminRow['sound'] == '1' ) {?>
        <audio  autoplay>
            <source src="assets/images/uploads/hata.mp3" type="audio/mp3">
        </audio>
    <?php }?>
    <?php unset($_SESSION['main_alert']) ?>
<?php }?>
<?php if($_SESSION['main_alert'] =='filetype'  ) {?>
    <div class="modal fade" id="modalGoster" >
        <div class="modal-dialog modal-dialog-centered modal-sm ">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                    <i class="fa fa-exclamation-triangle text-primary" style="font-size: 40px ; "></i><br>
                    <div class="text-primary" style="font-weight: bold; margin-bottom: 20px; font-size: 20px ;"><?=$diller['adminpanel-modal-text-4']?></div>
                    <div>
                        <?=$diller['adminpanel-modal-text-15']?>
                    </div>
                </div>
                <div class="category-cart-add-success-modal-footer">
                    <button type="button" class=" btn-primary btn-block p-2"  style="width: 100%; text-align: center; cursor: pointer " data-dismiss="modal"><?=$diller['adminpanel-modal-text-3']?></button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(window).on("load", function() {
            $('#modalGoster').modal('show');
        });
        $(window).load(function () {
            $('#modalGoster').modal('show');
        });
        var $modalDialog = $("#modalGoster");
        $modalDialog.modal('show');

        setTimeout(function() {
            $modalDialog.modal('hide');
        }, 0);
    </script>
    <?php if($adminRow['sound'] == '1' ) {?>
        <audio  autoplay>
            <source src="assets/images/uploads/hata.mp3" type="audio/mp3">
        </audio>
    <?php }?>
    <?php unset($_SESSION['main_alert']) ?>
<?php }?>
<?php if($_SESSION['main_alert'] =='nocheck'  ) {?>
    <div class="modal fade" id="modalGoster" >
        <div class="modal-dialog modal-dialog-centered modal-sm ">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                    <i class="fa fa-exclamation-triangle text-primary" style="font-size: 40px ; "></i><br>
                    <div class="text-primary" style="font-weight: bold; margin-bottom: 20px; font-size: 20px ;"><?=$diller['adminpanel-modal-text-4']?></div>
                    <div>
                        <?=$diller['adminpanel-modal-text-16']?>
                    </div>
                </div>
                <div class="category-cart-add-success-modal-footer">
                    <button type="button" class=" btn-primary btn-block p-2"  style="width: 100%; text-align: center; cursor: pointer " data-dismiss="modal"><?=$diller['adminpanel-modal-text-3']?></button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(window).on("load", function() {
            $('#modalGoster').modal('show');
        });
        $(window).load(function () {
            $('#modalGoster').modal('show');
        });
        var $modalDialog = $("#modalGoster");
        $modalDialog.modal('show');

        setTimeout(function() {
            $modalDialog.modal('hide');
        }, 0);
    </script>
    <?php if($adminRow['sound'] == '1' ) {?>
        <audio  autoplay>
            <source src="assets/images/uploads/hata.mp3" type="audio/mp3">
        </audio>
    <?php }?>
    <?php unset($_SESSION['main_alert']) ?>
<?php }?>
<?php if($_SESSION['main_alert'] =='multi_update_emptyerror'  ) {?>
    <div class="modal fade" id="modalGoster" >
        <div class="modal-dialog modal-dialog-centered modal-sm ">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                    <i class="fa fa-exclamation-triangle text-primary" style="font-size: 40px ; "></i><br>
                    <div class="text-primary" style="font-weight: bold; margin-bottom: 20px; font-size: 20px ;"><?=$diller['adminpanel-modal-text-4']?></div>
                    <div>
                        <?=$diller['adminpanel-modal-text-50']?>
                    </div>
                </div>
                <div class="category-cart-add-success-modal-footer">
                    <button type="button" class=" btn-primary btn-block p-2"  style="width: 100%; text-align: center; cursor: pointer " data-dismiss="modal"><?=$diller['adminpanel-modal-text-3']?></button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(window).on("load", function() {
            $('#modalGoster').modal('show');
        });
        $(window).load(function () {
            $('#modalGoster').modal('show');
        });
        var $modalDialog = $("#modalGoster");
        $modalDialog.modal('show');

        setTimeout(function() {
            $modalDialog.modal('hide');
        }, 0);
    </script>
    <?php if($adminRow['sound'] == '1' ) {?>
        <audio  autoplay>
            <source src="assets/images/uploads/hata.mp3" type="audio/mp3">
        </audio>
    <?php }?>
    <?php unset($_SESSION['main_alert']) ?>
<?php }?>
<?php if($_SESSION['main_alert'] =='nocheck2'  ) {?>
    <div class="modal fade" id="modalGoster" >
        <div class="modal-dialog modal-dialog-centered modal-sm ">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                    <i class="fa fa-exclamation-triangle text-primary" style="font-size: 40px ; "></i><br>
                    <div class="text-primary" style="font-weight: bold; margin-bottom: 20px; font-size: 20px ;"><?=$diller['adminpanel-modal-text-4']?></div>
                    <div>
                        <?=$diller['adminpanel-modal-text-21']?>
                    </div>
                </div>
                <div class="category-cart-add-success-modal-footer">
                    <button type="button" class=" btn-primary btn-block p-2"  style="width: 100%; text-align: center; cursor: pointer " data-dismiss="modal"><?=$diller['adminpanel-modal-text-3']?></button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(window).on("load", function() {
            $('#modalGoster').modal('show');
        });
        $(window).load(function () {
            $('#modalGoster').modal('show');
        });
        var $modalDialog = $("#modalGoster");
        $modalDialog.modal('show');

        setTimeout(function() {
            $modalDialog.modal('hide');
        }, 0);
    </script>
    <?php if($adminRow['sound'] == '1' ) {?>
        <audio  autoplay>
            <source src="assets/images/uploads/hata.mp3" type="audio/mp3">
        </audio>
    <?php }?>
    <?php unset($_SESSION['main_alert']) ?>
<?php }?>
<?php if($_SESSION['main_alert'] =='haveitem'  ) {?>
    <div class="modal fade" id="modalGoster" >
        <div class="modal-dialog modal-dialog-centered modal-sm ">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                    <i class="fa fa-exclamation-triangle text-primary" style="font-size: 40px ; "></i><br>
                    <div class="text-primary" style="font-weight: bold; margin-bottom: 20px; font-size: 20px ;"><?=$diller['adminpanel-modal-text-4']?></div>
                    <div>
                        <?=$diller['adminpanel-modal-text-18']?>
                    </div>
                </div>
                <div class="category-cart-add-success-modal-footer">
                    <button type="button" class=" btn-primary btn-block p-2"  style="width: 100%; text-align: center; cursor: pointer " data-dismiss="modal"><?=$diller['adminpanel-modal-text-3']?></button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(window).on("load", function() {
            $('#modalGoster').modal('show');
        });
        $(window).load(function () {
            $('#modalGoster').modal('show');
        });
        var $modalDialog = $("#modalGoster");
        $modalDialog.modal('show');

        setTimeout(function() {
            $modalDialog.modal('hide');
        }, 0);
    </script>
    <?php if($adminRow['sound'] == '1' ) {?>
        <audio  autoplay>
            <source src="assets/images/uploads/hata.mp3" type="audio/mp3">
        </audio>
    <?php }?>
    <?php unset($_SESSION['main_alert']) ?>
<?php }?>
<?php if($_GET['alert'] == 'success' ) {?>
    <div class="modal fade" id="successModal" data-backdrop="static" >
        <div class="modal-dialog modal-dialog-centered modal-sm ">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                    <i class="ion ion-md-checkmark-circle-outline" style="font-size: 60px ; color: #66B483;"></i><br>
                    <div style="font-weight: bold; margin-bottom: 20px; font-size: 20px ; color: #66B483;"><?=$diller['adminpanel-modal-text-1']?></div>
                    <div>
                        <?=$diller['adminpanel-modal-text-8']?>
                    </div>
                </div>
                <div class="category-cart-add-success-modal-footer">
                    <button type="button" class=" btn-primary btn-block p-2"  style="width: 100%; text-align: center; cursor: pointer " data-dismiss="modal"><?=$diller['adminpanel-modal-text-3']?></button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(window).on("load", function() {
            $('#successModal').modal('show');
        });
        $(window).load(function () {
            $('#successModal').modal('show');
        });
        var $modalDialog = $("#successModal");
        $modalDialog.modal('show');

        setTimeout(function() {
            $modalDialog.modal('hide');
        }, 0);
    </script>
    <?php if($adminRow['sound'] == '1' ) {?>
        <audio  autoplay>
            <source src="assets/images/uploads/success.mp3" type="audio/mp3">
        </audio>
    <?php } ?>
    <?php
    header("Refresh:1; url=pages.php?page=sitemap");
    ?>
<?php }?>
<?php if($_SESSION['main_alert'] =='success' ) {?>
    <div class="modal fade" id="successModal" >
        <div class="modal-dialog modal-dialog-centered modal-sm ">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                    <i class="ion ion-md-checkmark-circle-outline" style="font-size: 60px ; color: #66B483;"></i><br>
                    <div style="font-weight: bold; margin-bottom: 20px; font-size: 20px ; color: #66B483;"><?=$diller['adminpanel-modal-text-1']?></div>
                    <div>
                        <?=$diller['adminpanel-modal-text-8']?>
                    </div>
                </div>
                <div class="category-cart-add-success-modal-footer">
                    <button type="button" class=" btn-primary btn-block p-2"  style="width: 100%; text-align: center; cursor: pointer " data-dismiss="modal"><?=$diller['adminpanel-modal-text-3']?></button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(window).on("load", function() {
            $('#successModal').modal('show');
        });
        $(window).load(function () {
            $('#successModal').modal('show');
        });
        var $modalDialog = $("#successModal");
        $modalDialog.modal('show');

        setTimeout(function() {
            $modalDialog.modal('hide');
        }, 0);
    </script>
    <?php if($adminRow['sound'] == '1' ) {?>
        <audio  autoplay>
            <source src="assets/images/uploads/success.mp3" type="audio/mp3">
        </audio>
    <?php } ?>
    <?php unset($_SESSION['main_alert']) ?>
<?php }?>
<?php if($_SESSION['main_alert'] =='showcase_html_success'  ) {?>
    <div class="modal fade" id="successModal" >
        <div class="modal-dialog modal-dialog-centered modal-sm ">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                    <i class="ion ion-md-checkmark-circle-outline" style="font-size: 60px ; color: #66B483;"></i><br>
                    <div style="font-weight: bold; margin-bottom: 20px; font-size: 20px ; color: #66B483;"><?=$diller['adminpanel-modal-text-1']?></div>
                    <div>
                        <?=$diller['adminpanel-form-text-986']?>
                    </div>
                </div>
                <div class="category-cart-add-success-modal-footer">
                    <button type="button" class=" btn-primary btn-block p-2"  style="width: 100%; text-align: center; cursor: pointer " data-dismiss="modal"><?=$diller['adminpanel-modal-text-3']?></button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(window).on("load", function() {
            $('#successModal').modal('show');
        });
        $(window).load(function () {
            $('#successModal').modal('show');
        });
        var $modalDialog = $("#successModal");
        $modalDialog.modal('show');

        setTimeout(function() {
            $modalDialog.modal('hide');
        }, 0);
    </script>
    <?php if($adminRow['sound'] == '1' ) {?>
        <audio  autoplay>
            <source src="assets/images/uploads/success.mp3" type="audio/mp3">
        </audio>
    <?php } ?>
    <?php unset($_SESSION['main_alert']) ?>
<?php }?>
<?php if($_SESSION['main_alert_product'] =='main_alert_product'  ) {?>
    <div class="modal fade" id="successModal" >
        <div class="modal-dialog modal-dialog-centered modal-sm ">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                    <i class="ion ion-md-checkmark-circle-outline" style="font-size: 60px ; color: #66B483;"></i><br>
                    <div style="font-weight: bold; margin-bottom: 20px; font-size: 20px ; color: #66B483;"><?=$diller['adminpanel-modal-text-1']?></div>
                    <div>
                        <?=$diller['adminpanel-modal-text-46']?>
                    </div>
                </div>
                <div class="category-cart-add-success-modal-footer">
                    <button type="button" class=" btn-primary btn-block p-2"  style="width: 100%; text-align: center; cursor: pointer " data-dismiss="modal"><?=$diller['adminpanel-modal-text-3']?></button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(window).on("load", function() {
            $('#successModal').modal('show');
        });
        $(window).load(function () {
            $('#successModal').modal('show');
        });
        var $modalDialog = $("#successModal");
        $modalDialog.modal('show');

        setTimeout(function() {
            $modalDialog.modal('hide');
        }, 0);
    </script>
    <?php if($adminRow['sound'] == '1' ) {?>
        <audio  autoplay>
            <source src="assets/images/uploads/success.mp3" type="audio/mp3">
        </audio>
    <?php } ?>
    <?php unset($_SESSION['main_alert_product']) ?>
<?php }?>

<!-- Önbellek Temizleme Başarılı !-->
<?php if($_SESSION['cache_alert'] =='success'  ) {?>
    <div class="modal fade" id="successModal" >
        <div class="modal-dialog modal-dialog-centered modal-sm ">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                    <i class="ion ion-md-checkmark-circle-outline" style="font-size: 60px ; color: #66B483;"></i><br>
                    <div style="font-weight: bold; margin-bottom: 20px; font-size: 20px ; color: #66B483;"><?=$diller['adminpanel-modal-text-1']?></div>
                    <div>
                        <?=$diller['adminpanel-modal-text-2']?>
                    </div>
                </div>
                <div class="category-cart-add-success-modal-footer">
                    <button type="button" class=" btn-primary btn-block p-2"  style="width: 100%; text-align: center; cursor: pointer " data-dismiss="modal"><?=$diller['adminpanel-modal-text-3']?></button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(window).on("load", function() {
            $('#successModal').modal('show');
        });
        $(window).load(function () {
            $('#successModal').modal('show');
        });
        var $modalDialog = $("#successModal");
        $modalDialog.modal('show');

        setTimeout(function() {
            $modalDialog.modal('hide');
        }, 0);
    </script>
    <?php if($adminRow['sound'] == '1' ) {?>
        <audio  autoplay>
            <source src="assets/images/uploads/success.mp3" type="audio/mp3">
        </audio>
    <?php }?>
    <?php unset($_SESSION['cache_alert']) ?>
<?php }?>
<!--  <========SON=========>>> Önbellek Temizleme Başarılı SON !-->

<?php if($panelayar['bekleyen_isler_modal'] == '1' ) {?>
<!-- Bekleyen işler !-->
<div class="modal fade bekleyenler-modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="box-shadow: 0 0 10px 0 rgba(0,0,0,.3); border:1px solid #ccc">
            <div class="btn btn-light btn-sm close" data-dismiss="modal" aria-label="Close" style="font-weight: 400 !important; z-index: 99 !important; width: 40px; font-size: 18px ; position: absolute; margin-top:5px; right: 5px;">
                <i class="fa fa-times"></i>
            </div>
            <div class="modal-body">
                <?php include 'inc/template/bekleyen-isler-modal.php'; ?>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!--  <========SON=========>>> Bekleyen işler SON !-->
<?php } ?>




<!-- cargo_company  Modal !-->
<div class="modal fade cargo_company" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" >
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="box-shadow: 0 0 10px 0 rgba(0,0,0,.3); border:1px solid #ccc">
            <div class="btn btn-light btn-sm close" data-dismiss="modal" aria-label="Close" style="font-weight: 400 !important; z-index: 99 !important; width: 40px; font-size: 18px ; position: absolute; margin-top:5px; right: 5px;">
                <i class="fa fa-times"></i>
            </div>
            <div class="modal-body">
                <div class="w-100 p-3 border-bottom ">
                    <h4><?=$diller['adminpanel-form-text-763']?></h4>
                </div>
                <div class="border p-3 " style="font-size: 14px ;">
                    <?=$diller['adminpanel-form-text-767']?>
                </div>
                <div class="border p-3 ">
                    <div class="col-md-12 form-group">
                        <label for="ptt">PTT KARGO TAKİP LİNKİ</label>
                        <div class="d-flex">
                            <input type="text" id="pttKargo" value="https://gonderitakip.ptt.gov.tr/Track/Verify?q="  class="form-control rounded-0 rounded-left" readonly>
                            <button onclick="myFunction()" class="btn btn-dark rounded-0 rounded-right"><i class="fa fa-copy"></i></button>
                        </div>
                    </div>
                    <div class="col-md-12 form-group">
                        <label for="">MNG KARGO TAKİP LİNKİ</label>
                        <div class="d-flex">
                            <input type="text" id="mngKargo" value="https://service.mngkargo.com.tr/iactive/popup/kargotakip.asp?k="  class="form-control rounded-0 rounded-left" readonly>
                            <button onclick="myFunction2()" class="btn btn-dark rounded-0 rounded-right"><i class="fa fa-copy"></i></button>
                        </div>
                    </div>
                    <div class="col-md-12 form-group">
                        <label for="">YURTİÇİ KARGO TAKİP LİNKİ</label>
                        <div class="d-flex">
                            <input type="text" id="yurtIciKargo" value="https://www.yurticikargo.com/tr/online-servisler/gonderi-sorgula?code="  class="form-control rounded-0 rounded-left" readonly>
                            <button onclick="myFunction3()" class="btn btn-dark rounded-0 rounded-right"><i class="fa fa-copy"></i></button>
                        </div>
                    </div>
                    <div class="col-md-12 form-group">
                        <label for="">ARAS KARGO GÖNDERİ TAKİP LİNKİ</label>
                        <div class="d-flex">
                            <input type="text" id="arasKargo" value="https://kargotakip.araskargo.com.tr/yurticigonbil.aspx?Cargo_Code="  class="form-control rounded-0 rounded-left" readonly>
                            <button onclick="myFunction4()" class="btn btn-dark rounded-0 rounded-right"><i class="fa fa-copy"></i></button>
                        </div>
                    </div>
                    <div class="col-md-12 form-group">
                        <label for="">UPS KARGO GÖNDERİ TAKİP LİNKİ</label>
                        <div class="d-flex">
                            <input type="text" id="upsKargo" value="https://www.ups.com.tr/WaybillSorgu.aspx?Waybill="  class="form-control rounded-0 rounded-left" readonly>
                            <button onclick="myFunction5()" class="btn btn-dark rounded-0 rounded-right"><i class="fa fa-copy"></i></button>
                        </div>
                    </div>
                    <div class="col-md-12 form-group">
                        <label for="">SÜRAT KARGO GÖNDERİ TAKİP LİNKİ</label>
                        <div class="d-flex">
                            <input type="text" id="suratKargo" value="http://suratkargo.com.tr/KargoTakip?kargotakipno="  class="form-control rounded-0 rounded-left" readonly>
                            <button onclick="myFunction6()" class="btn btn-dark rounded-0 rounded-right"><i class="fa fa-copy"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
<script>
    function myFunction() {
        var copyText = document.getElementById("pttKargo");
        copyText.select();
        copyText.setSelectionRange(0, 99999)
        document.execCommand("copy");
        alert("Kopyalandı : " + copyText.value);
    }
    function myFunction2() {
        var copyText = document.getElementById("mngKargo");
        copyText.select();
        copyText.setSelectionRange(0, 99999)
        document.execCommand("copy");
        alert("Kopyalandı : " + copyText.value);
    }
    function myFunction3() {
        var copyText = document.getElementById("yurtIciKargo");
        copyText.select();
        copyText.setSelectionRange(0, 99999)
        document.execCommand("copy");
        alert("Kopyalandı : " + copyText.value);
    }
    function myFunction4() {
        var copyText = document.getElementById("arasKargo");
        copyText.select();
        copyText.setSelectionRange(0, 99999)
        document.execCommand("copy");
        alert("Kopyalandı : " + copyText.value);
    }
    function myFunction5() {
        var copyText = document.getElementById("upsKargo");
        copyText.select();
        copyText.setSelectionRange(0, 99999)
        document.execCommand("copy");
        alert("Kopyalandı : " + copyText.value);
    }
    function myFunction6() {
        var copyText = document.getElementById("suratKargo");
        copyText.select();
        copyText.setSelectionRange(0, 99999)
        document.execCommand("copy");
        alert("Kopyalandı : " + copyText.value);
    }
</script>
<!-- /.modal -->
<!--  <========SON=========>>> cargo_companySON !-->


<!-- ikon seç  Modal !-->
<div class="modal fade ikon_adresleri" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" >
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="box-shadow: 0 0 10px 0 rgba(0,0,0,.3); border:1px solid #ccc">
            <div class="btn btn-light btn-sm close" data-dismiss="modal" aria-label="Close" style="font-weight: 400 !important; z-index: 99 !important; width: 40px; font-size: 18px ; position: absolute; margin-top:5px; right: 5px;">
                <i class="fa fa-times"></i>
            </div>
            <div class="modal-body">
                <div class="w-100 p-3 border-bottom ">
                    <h4><?=$diller['adminpanel-text-337']?></h4>
                </div>
                <div class="border p-3 bg-light" style="font-size: 14px ;">
                   <?=$diller['adminpanel-text-338']?>
                </div>
                <div class="border p-3 ">
                    <div class="col-md-12 form-group">
                        <a href="https://fontawesome.com/v4.7.0/icons/" class="btn btn-block btn-success p-3" target="_blank">FONT AWESOME 4.7</a>
                        <a href="https://icons8.com/line-awesome" class="btn btn-block btn-warning p-3" target="_blank">LINE AWESOME</a>
                    </div>
                    <div class="col-md-12">
                        <div class="p-3 border border-warning rounded-top alert-warning text-dark" style="font-size: 14px ; font-weight: 600;"><?=$diller['adminpanel-text-339']?></div>
                        <div class="border  p-3 bg-white border-top-0 shadow-sm ">
                           <strong> Font Awesome :</strong> fa fa-address-book
                        </div>
                        <div class="border  p-3 bg-white border-top-0 rounded-bottom shadow-sm ">
                            <strong> Line Awesome :</strong> las la-braille
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
<!-- /.modal -->
<!--  <========SON=========>>> ikon seç !-->



<!-- Editable Modal !-->
<div id="duzenle" class="modal   modal-editable"  role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" data-backdrop="static" >

</div>

<div id="duzenle-settings" class="modal   modal-editable-settings"  role="dialog" aria-labelledby="mySmallModalLabesl" aria-hidden="true" data-backdrop="static" >

</div>
<!--  <========SON=========>>> Editable Modal SON !-->

<!-- Delete Modal !-->
<div class="modal " id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" >
    <div class="modal-dialog modal-dialog-centered modal-sm ">
        <div class="modal-content" >
            <div style="position: absolute; z-index: 9; right: 10px">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="outline: none">
                    <i class="ion-ios-close-empty"></i>
                </button>
            </div>
            <div class="modal-body" style="font-size: 14px ; font-weight: 300;  padding:  20px !important; letter-spacing: 0.04em!important;">
                <div style="font-size: 18px ; font-weight: 500; color: red; margin-bottom: 10px;">
                    <?=$diller['adminpanel-modal-text-9']?>
                </div>
                <?=$diller['adminpanel-modal-text-10']?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light"   data-dismiss="modal"><?=$diller['adminpanel-modal-text-12']?></button>
                <a class="btn btn-danger text-white btn-ok" ><i class="fa fa-trash"></i> <?=$diller['adminpanel-modal-text-11']?></a>
            </div>
        </div>
    </div>
</div>
<script>
    $('#confirm-delete').on('show.bs.modal', function(e) {
        $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
    });
</script>
<!--  <========SON=========>>> Delete Modal SON !-->

<!-- n11 İşlem Delete !-->

<?php if($_GET['page']=='n11_process'  ) {?>
<!-- Delete Modal !-->
<div class="modal " id="n11-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" >
    <div class="modal-dialog modal-dialog-centered modal ">
        <div class="modal-content" >
            <div style="position: absolute; z-index: 9; right: 10px">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="outline: none">
                    <i class="ion-ios-close-empty"></i>
                </button>
            </div>
            <div class="modal-body" style="font-size: 14px ; font-weight: 300;  padding:  20px !important; letter-spacing: 0.04em!important;">
                <div style="font-size: 18px ; font-weight: 500; color: red; margin-bottom: 10px;">
                    <?=$diller['adminpanel-modal-text-9']?>
                </div>
                <?=$diller['adminpanel-modal-text-56']?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light"   data-dismiss="modal"><?=$diller['adminpanel-modal-text-12']?></button>
                <a class="btn btn-danger text-white btn-ok" ><i class="fa fa-trash"></i> <?=$diller['adminpanel-modal-text-11']?></a>
            </div>
        </div>
    </div>
</div>
<script>
    $('#n11-delete').on('show.bs.modal', function(e) {
        $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
    });
</script>
<!--  <========SON=========>>> Delete Modal SON !-->
<?php }?>

<?php if($_GET['page']=='n11_process'  ) {?>
    <div class="modal " id="n11-import" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" >
        <div class="modal-dialog modal-dialog-centered modal ">
            <div class="modal-content" >
                <div style="position: absolute; z-index: 9; right: 10px">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="outline: none">
                        <i class="ion-ios-close-empty"></i>
                    </button>
                </div>
                <div class="modal-body" style="font-size: 16px ; font-weight: 300;  padding:  20px !important; ">
                    <div style="font-size: 18px ; font-weight: 500; color: green; margin-bottom: 10px;">
                        <?=$diller['adminpanel-modal-text-9']?>
                    </div>
                    <?=$diller['adminpanel-modal-text-57']?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light"   data-dismiss="modal"><?=$diller['adminpanel-modal-text-12']?></button>
                    <a class="btn btn-primary text-white btn-ok" ><i class="fa fa-play"></i> <?=$diller['pazaryeri-text-26']?></a>
                </div>
            </div>
        </div>
    </div>
    <script>
        $('#n11-import').on('show.bs.modal', function(e) {
            $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
        });
    </script>
<?php }?>

<!--  <========SON=========>>> n11 İşlem Delete SON !-->

<!-- Sipariş İptal Onay !-->
<div class="modal " id="order-cancel-confirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" >
    <div class="modal-dialog modal-dialog-centered  ">
        <div class="modal-content" >
            <div style="position: absolute; z-index: 9; right: 10px">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="outline: none">
                    <i class="ion-ios-close-empty"></i>
                </button>
            </div>
            <div class="modal-body" style="font-size: 14px ; font-weight: 300;  padding:  20px !important; letter-spacing: 0.04em!important;">
                <div style="font-size: 18px ; font-weight: 500; color: red; margin-bottom: 10px;">
                    <?=$diller['adminpanel-modal-text-9']?>
                </div>
                <?=$diller['adminpanel-modal-text-31']?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light"   data-dismiss="modal"><?=$diller['adminpanel-modal-text-12']?></button>
                <a class="btn btn-danger text-white btn-ok" > <?=$diller['adminpanel-modal-text-32']?></a>
            </div>
        </div>
    </div>
</div>
<script>
    $('#order-cancel-confirm').on('show.bs.modal', function(e) {
        $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
    });
</script>
<div class="modal " id="order-active-confirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" >
    <div class="modal-dialog modal-dialog-centered  ">
        <div class="modal-content" >
            <div style="position: absolute; z-index: 9; right: 10px">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="outline: none">
                    <i class="ion-ios-close-empty"></i>
                </button>
            </div>
            <div class="modal-body" style="font-size: 14px ; font-weight: 300;  padding:  20px !important; letter-spacing: 0.04em!important;">
                <div style="font-size: 18px ; font-weight: 500; color: #52b584; margin-bottom: 10px;">
                    <?=$diller['adminpanel-modal-text-9']?>
                </div>
                <?=$diller['adminpanel-modal-text-33']?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light"   data-dismiss="modal"><?=$diller['adminpanel-modal-text-12']?></button>
                <a class="btn btn-success text-white btn-ok" > <?=$diller['adminpanel-modal-text-34']?></a>
            </div>
        </div>
    </div>
</div>
<script>
    $('#order-active-confirm').on('show.bs.modal', function(e) {
        $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
    });
</script>
<!--  <========SON=========>>> Sipariş İptal Onay SON !-->
<!-- Ödeme Onay !-->
<div class="modal " id="bank-confirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" >
    <div class="modal-dialog modal-dialog-centered  ">
        <div class="modal-content" >
            <div style="position: absolute; z-index: 9; right: 10px">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="outline: none">
                    <i class="ion-ios-close-empty"></i>
                </button>
            </div>
            <div class="modal-body" style="font-size: 14px ; font-weight: 300;  padding:  20px !important; letter-spacing: 0.04em!important;">
                <div style="font-size: 18px ; font-weight: 500; color: #52b584; margin-bottom: 10px;">
                    <?=$diller['adminpanel-modal-text-9']?>
                </div>
                <?=$diller['adminpanel-modal-text-36']?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light"   data-dismiss="modal"><?=$diller['adminpanel-modal-text-12']?></button>
                <a class="btn btn-success text-white btn-ok" > <?=$diller['adminpanel-modal-text-35']?></a>
                <a class="btn btn-danger text-white btn-no" > <?=$diller['adminpanel-modal-text-37']?></a>
            </div>
        </div>
    </div>
</div>
<script>
    $('#bank-confirm').on('show.bs.modal', function(e) {
        $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
        $(this).find('.btn-no').attr('href', $(e.relatedTarget).data('href-2'));
    });
</script>
<!--  <========SON=========>>> Ödeme Onay SON !-->
<div class="modal " id="stock-load" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" >
    <div class="modal-dialog modal-dialog-centered  ">
        <div class="modal-content" >
            <div style="position: absolute; z-index: 9; right: 10px">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="outline: none">
                    <i class="ion-ios-close-empty"></i>
                </button>
            </div>
            <div class="modal-body" style="font-size: 14px ; font-weight: 300;  padding:  20px !important; letter-spacing: 0.04em!important;">
                <div style="font-size: 18px ; font-weight: 500; color: #52b584; margin-bottom: 10px;">
                    <?=$diller['adminpanel-modal-text-9']?>
                </div>
                <?=$diller['adminpanel-modal-text-42']?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light"   data-dismiss="modal"><?=$diller['adminpanel-modal-text-12']?></button>
                <a class="btn btn-success text-white btn-ok" > <?=$diller['adminpanel-modal-text-43']?></a>
            </div>
        </div>
    </div>
</div>
<script>
    $('#stock-load').on('show.bs.modal', function(e) {
        $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
    });
</script>
<div class="modal " id="stock-load-2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" >
    <div class="modal-dialog modal-dialog-centered modal-sm ">
        <div class="modal-content" >
            <div style="position: absolute; z-index: 9; right: 10px">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="outline: none">
                    <i class="ion-ios-close-empty"></i>
                </button>
            </div>
            <div class="modal-body" style="font-size: 14px ; font-weight: 300;  padding:  20px !important; letter-spacing: 0.04em!important;">
                <div style="font-size: 18px ; font-weight: 500; color: #52b584; margin-bottom: 10px;">
                    <?=$diller['adminpanel-modal-text-9']?>
                </div>
                <?=$diller['adminpanel-modal-text-44']?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light"   data-dismiss="modal"><?=$diller['adminpanel-modal-text-12']?></button>
                <a class="btn btn-success text-white btn-ok" > <?=$diller['adminpanel-modal-text-45']?></a>
            </div>
        </div>
    </div>
</div>
<script>
    $('#stock-load-2').on('show.bs.modal', function(e) {
        $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
    });
</script>

<div class="modal " id="import-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" >
    <div class="modal-dialog modal-dialog-centered  ">
        <div class="modal-content" >
            <div style="position: absolute; z-index: 9; right: 10px">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="outline: none">
                    <i class="ion-ios-close-empty"></i>
                </button>
            </div>
            <div class="modal-body" style="font-size: 14px ; font-weight: 300;  padding:  20px !important; letter-spacing: 0.04em!important;">
                <div style="font-size: 18px ; font-weight: 500; color: #B51633; margin-bottom: 10px;">
                    <?=$diller['adminpanel-modal-text-9']?>
                </div>
                <?=$diller['adminpanel-modal-text-51']?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light btn-sm border"   data-dismiss="modal"><?=$diller['adminpanel-modal-text-12']?></button>
                <a class="btn btn-sm btn-danger text-white btn-ok" > <?=$diller['adminpanel-modal-text-52']?></a>
                <a class="btn btn-sm btn-danger text-white btn-no" > <?=$diller['adminpanel-modal-text-53']?></a>
            </div>
        </div>
    </div>
</div>
<script>
    $('#import-delete').on('show.bs.modal', function(e) {
        $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
        $(this).find('.btn-no').attr('href', $(e.relatedTarget).data('href-2'));
    });
</script>



<?php if($_SESSION['main_alert'] =='ty_stok_alert'  ) {?>
    <div class="modal " id="modalGoster" >
        <div class="modal-dialog modal-dialog-centered modal-sm ">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                    <i class="fa fa-exclamation-triangle" style="font-size: 40px ; color: #f24734;"></i><br>
                    <div style="font-weight: bold; margin-bottom: 20px; font-size: 20px ; color: #f24734;"><?=$diller['adminpanel-modal-text-4']?></div>
                    <div>
                        <?=$diller['pazaryeri-text-96']?>
                    </div>
                </div>
                <div class="category-cart-add-success-modal-footer">
                    <button type="button" class=" btn-danger btn-block p-2"  style="width: 100%; text-align: center; cursor: pointer " data-dismiss="modal"><?=$diller['adminpanel-modal-text-6']?></button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(window).on("load", function() {
            $('#modalGoster').modal('show');
        });
        $(window).load(function () {
            $('#modalGoster').modal('show');
        });
        var $modalDialog = $("#modalGoster");
        $modalDialog.modal('show');

        setTimeout(function() {
            $modalDialog.modal('hide');
        }, 0);
    </script>
    <?php if($adminRow['sound'] == '1' ) {?>
        <audio  autoplay>
            <source src="assets/images/uploads/hata.mp3" type="audio/mp3">
        </audio>
    <?php }?>
<?php
unset($_SESSION['main_alert']);
}?>


<?php if($_SESSION['main_alert'] =='ty_guncelleme_hata'  ) {?>
    <div class="modal " id="modalGoster" >
        <div class="modal-dialog modal-dialog-centered modal-sm ">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                    <i class="fa fa-exclamation-triangle" style="font-size: 40px ; color: #f24734;"></i><br>
                    <div style="font-weight: bold; margin-bottom: 20px; font-size: 20px ; color: #f24734;"><?=$diller['adminpanel-modal-text-4']?></div>
                    <div>
                        <?php
                        $asd = json_encode($_SESSION['ty_guncelleme_hata']);
                        $dde = json_decode($asd,TRUE);
                        ?>
                       <?=print_r($dde[0])?>
                        
                        <div style="font-size: 13px; margin-top: 8px;">
                            <?=$diller['pazaryeri-text-97']?>
                        </div>
                    </div>
                </div>
                <div class="category-cart-add-success-modal-footer">
                    <button type="button" class=" btn-danger btn-block p-2"  style="width: 100%; text-align: center; cursor: pointer " data-dismiss="modal"><?=$diller['adminpanel-modal-text-6']?></button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(window).on("load", function() {
            $('#modalGoster').modal('show');
        });
        $(window).load(function () {
            $('#modalGoster').modal('show');
        });
        var $modalDialog = $("#modalGoster");
        $modalDialog.modal('show');

        setTimeout(function() {
            $modalDialog.modal('hide');
        }, 0);
    </script>
    <?php if($adminRow['sound'] == '1' ) {?>
        <audio  autoplay>
            <source src="assets/images/uploads/hata.mp3" type="audio/mp3">
        </audio>
    <?php }?>
    <?php
    unset($_SESSION['main_alert']);unset($_SESSION['ty_guncelleme_hata']);
}?>




<?php if($_SESSION['main_alert'] =='ty_tekekleme_hata'  ) {?>
    <div class="modal " id="modalGoster" >
        <div class="modal-dialog modal-dialog-centered modal-sm ">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                    <i class="fa fa-exclamation-triangle" style="font-size: 40px ; color: #f24734;"></i><br>
                    <div style="font-weight: bold; margin-bottom: 20px; font-size: 20px ; color: #f24734;"><?=$diller['adminpanel-modal-text-4']?></div>
                    <div>
                        <?=$diller['pazaryeri-text-98']?>
                    </div>
                </div>
                <div class="category-cart-add-success-modal-footer">
                    <button type="button" class=" btn-danger btn-block p-2"  style="width: 100%; text-align: center; cursor: pointer " data-dismiss="modal"><?=$diller['adminpanel-modal-text-6']?></button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(window).on("load", function() {
            $('#modalGoster').modal('show');
        });
        $(window).load(function () {
            $('#modalGoster').modal('show');
        });
        var $modalDialog = $("#modalGoster");
        $modalDialog.modal('show');

        setTimeout(function() {
            $modalDialog.modal('hide');
        }, 0);
    </script>
    <?php if($adminRow['sound'] == '1' ) {?>
        <audio  autoplay>
            <source src="assets/images/uploads/hata.mp3" type="audio/mp3">
        </audio>
    <?php }?>
    <?php
    unset($_SESSION['main_alert']);
}?>