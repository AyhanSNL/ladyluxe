<?php
//todo ioncube
include 'inc/session.php'
?>
<?php if($adminSorgu->rowCount()> '0'  ) {?>
    <!DOCTYPE html>
    <html lang="<?=$mevcutdil['kisa_ad']?>" dir="<?=$mevcutdil['area']?>">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <meta content="Admin Dashboard" name="description" />
        <meta content="ThemeDesign" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <?php include 'inc/template/headerlibs.php'; ?>
    </head>
    <body>
    <div class="panel-home-main-div">
        <!-- Header !-->
        <?php include 'inc/template/header.php'; ?>
        <!--  <========SON=========>>> Header SON !-->
        <?php
        if(isset($_GET['page'])){
            $s = $_GET['page'];
            switch($s){


                //todo paraşüt
                case 'parasut_ayar';
                    require_once("inc/modules/parasut/ayar.php");
                    break;

                case 'parasut_fatura_kes';
                    require_once("inc/modules/parasut/fatura_kes.php");
                    break;

                case 'parasut_fatura';
                    require_once("inc/modules/parasut/fatura_listesi.php");
                    break;

            }
        }else {
            ?>
            <?php
            header('Location:'.$ayar['panel_url'].'');
            ?>
            <?php
        }
        ?>

        <?php if($panelayar['footer_text'] == !null  ) {?>
            <!-- Footer -->
            <footer class="footer" style="background-color: #<?=$panelayar['footer_bg']?>;" >
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 " style="color: #<?=$panelayar['footer_text_color']?> !important;">
                            <?=$panelayar['footer_text']?>
                        </div>
                    </div>
                </div>
            </footer>
            <!-- End Footer -->
        <?php }?>
        <div id="foot_divider"></div>
        <?php include 'inc/template/footerlibs.php'; ?>
    </div>
    </body>
    </html>
    <?php include 'inc/template/all-modals.php'; ?>
<?php }else{
    header('Location:'.$ayar['site_url'].'404');
}
?>