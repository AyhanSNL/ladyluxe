<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;
unset($_SESSION['form_temp']);?>
<?php
if($userSorgusu->rowCount()>'0' && $uyeayar['adres_alani'] == '1') {
$userpage = 'adres';
$Sayfa = @intval($_GET['page']); if(!$Sayfa) $Sayfa = 1;
$Say = $db->query("select * from uyeler_adres where uye_id='$userCek[id]'  ");
$ToplamVeri = $Say->rowCount();
$Limit = 7;
$Sayfa_Sayisi = ceil($ToplamVeri/$Limit); if($Sayfa > $Sayfa_Sayisi){$Sayfa = 1;}
$Goster = $Sayfa * $Limit - $Limit;
$GorunenSayfa = 5;
$islemListele = $db->query("select * from uyeler_adres where uye_id='$userCek[id]' order by id DESC limit $Goster,$Limit");
$islemCek = $islemListele->fetchAll(PDO::FETCH_ASSOC);
    $_SESSION['teslimat_adres_url'] = 'account';
/* Silme İşlemi */
if(isset($_GET['deleteItem']) && $_GET['deleteItem'] == 'okay' && isset($_GET['deleteId']) ) {

    $adresBul = $db->prepare("select * from uyeler_adres where adres_id=:adres_id and uye_id=:uye_id ");
    $adresBul->execute(array(
            'adres_id' => $_GET['deleteId'],
            'uye_id' => $userCek['id']
    ));

    if($adresBul->rowCount()>'0') {
        $silmeislem = $db->prepare("DELETE from uyeler_adres WHERE adres_id=:adres_id");
        $silmeislem->execute(array(
            'adres_id' => $_GET['deleteId']
        ));
        if ($silmeislem) {
            header('Location:'.$ayar['site_url'].'hesabim/adresler/');
        }else {
            echo 'veritabanı hatası';
        }
    }else{
        header('Location:'.$ayar['site_url'].'404');
    }
}
/*  <========SON=========>>> Silme İşlemi SON */
?>
<title><?php echo $diller['users-adresler-seo-title']; ?> - <?php echo $ayar['site_baslik']?></title>
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
            <a href="hesabim/adresler/"><?=$diller['users-panel-baglanti-text10']?></a>
        </div>
        <!--  <========SON=========>>> Header SON !-->
        <?php include 'includes/template/helper/users/leftbar.php'; ?>

        <!-- Right Content !-->
        <div class="user_subpage_coupon_content">


                <!-- Head !-->
                <div class="user_subpage_account_header">
                    <?=$diller['users-panel-text79']?>
                    <div class="user_subpage_account_spot">
                        <?=$diller['users-panel-text80']?>
                    </div>
                </div>
                <!--  <========SON=========>>> Head SON !-->

            <!-- Address Boxes !-->
            <div class="user_subpage_address_boxes_main ">

            <?php if($ToplamVeri <= '0'  ) {?>
            <a class="user_subpage_address_box_added_noitem" href="hesabim/yeni-adres-ekle/">
                <div class="user_subpage_address_box_added_icon">
                    <i class="las la-plus"></i>
                </div>
                <div class="user_subpage_address_box_added_text">
                    <?=$diller['users-panel-text81']?>
                </div>
            </a>
            <?php }?>

                <?php if($ToplamVeri > '0'  ) {?>
                    <a class="user_subpage_address_box_added" href="hesabim/yeni-adres-ekle/">
                        <div class="user_subpage_address_box_added_icon">
                            <i class="las la-plus"></i>
                        </div>
                        <div class="user_subpage_address_box_added_text">
                            <?=$diller['users-panel-text81']?>
                        </div>
                    </a>
                    <?php foreach ($islemCek as $islemRow) {
                        $ulkeCek = $db->prepare("select * from ulkeler where 3_iso=:3_iso ");
                        $ulkeCek->execute(array(
                                '3_iso' => $islemRow['ulke']
                        ));
                        $ulkeRow = $ulkeCek->fetch(PDO::FETCH_ASSOC);
                        ?>
                        <div class="user_subpage_address_box" >
                            <div class="user_subpage_comment_box_status_main">
                                <?php if($islemRow['secili'] == '1' ) {?>
                                    <div class="user_subpage_comment_box_status" style="border: 1px solid #66B483; color: #66B483;">
                                        <i class="fa fa-check"></i> <?=$diller['users-panel-text95']?>
                                    </div>
                                <?php }?>
                            </div>
                            <div class="user_subpage_address_box_name">
                               <?=$islemRow['baslik']?>
                            </div>
                            <div class="user_subpage_address_box_user">
                                <?=$islemRow['isim']?> <?=$islemRow['soyisim']?>
                            </div>
                            <div class="user_subpage_address_box_content">
                                <?=$islemRow['adresbilgisi']?>
                                <br>
                                <?=$islemRow['ilce']?> / <?=$islemRow['sehir']?>
                                <br>
                                <strong><?=$ulkeRow['baslik']?></strong>
                            </div>
                            <div class="user_subpage_address_box_phone">
                                <?=$islemRow['telefon']?> -  <?=$islemRow['eposta']?>
                            </div>

                            <?php if($odemeayar['faturasiz_teslimat'] == '0'  ) {?>
                                <div class="user_subpage_address_box_type">
                                    <?php if($islemRow['fatura_turu'] == '1' ) {?>
                                        <?=$diller['users-panel-text82']?>
                                    <?php }?>
                                    <?php if($islemRow['fatura_turu'] == '2' ) {?>
                                        <?=$diller['users-panel-text83']?>
                                    <?php }?>
                                </div>
                            <?php }?>
                            <div class="user_subpage_address_box_buttons">
                                <a data-href="hesabim/adresler/?deleteItem=okay&deleteId=<?=$islemRow['adres_id']?>" href="" data-toggle="modal" data-target="#confirm-delete" class="button-white button-1x" style="font-weight: bold !important; letter-spacing: normal!important;" >
                                    <i class="las la-trash"></i> <?=$diller['users-panel-text23']?>
                                </a>
                                <a href="hesabim/adres-duzenle/<?=$islemRow['adres_id']?>/" class="button-orange button-1x">
                                    <?=$diller['users-panel-text84']?>
                                </a>
                            </div>
                        </div>
                    <?php }?>

                <?php }?>



            </div>
            <!--  <========SON=========>>> Address Boxes SON !-->



                <!---- Sayfalama Elementleri ================== !-->
                <?php if($ToplamVeri > $Limit  ) {?>
                    <div id="SayfalamaElementi" style="width: 100%;  ">
                        <?php if($Sayfa >= 1){?>
                        <nav aria-label="Page navigation example" style="margin-top: 20px;">
                            <ul class="pagination pagination-sm">
                                <?php } ?>

                                <?php if($Sayfa > 1){?>

                                    <li class="page-item"><a class="page-link" href="hesabim/adresler/<?php if(isset($_GET['status'])) { ?>?status=<?=$_GET['status']?><?php }else{?><?php } ?>"><?=$diller['sayfalama-ilk']?></a></li>
                                    <li class="page-item"><a class="page-link" href="hesabim/adresler/<?php if(isset($_GET['status'])) { ?>?status=<?=$_GET['status']?>&page=<?=$Sayfa - 1?><?php }else{?>?page=<?=$Sayfa - 1?><?php } ?>"><?=$diller['sayfalama-onceki']?></a></li>

                                <?php } ?>
                                <?php
                                for($i = $Sayfa - $GorunenSayfa; $i < $Sayfa + $GorunenSayfa +1; $i++){ if($i > 0 and $i <= $Sayfa_Sayisi){
                                    if($i == $Sayfa){
                                        ?>

                                        <li class="page-item active" aria-current="page">
                                            <a class="page-link" href="hesabim/adresler/?page=<?=$i?>"><?=$i?><span class="sr-only">(current)</span></a>
                                        </li>

                                        <?php
                                    }else{
                                        ?>
                                        <li class="page-item"><a class="page-link" href="hesabim/adresler/?page=<?=$i?>"><?=$i?></a></li>
                                        <?php
                                    }
                                }
                                }
                                ?>

                                <?php if($islemListele->rowCount() <=0) { } else { ?>
                                    <?php if($Sayfa != $Sayfa_Sayisi){?>

                                        <li class="page-item"><a class="page-link" href="hesabim/adresler/?page=<?=$Sayfa + 1?>"><?=$diller['sayfalama-sonraki']?></a></li>
                                        <li class="page-item"><a class="page-link" href="hesabim/adresler/?page=<?=$Sayfa_Sayisi?>"><?=$diller['sayfalama-son']?></a></li>


                                    <?php }} ?>

                                <?php if($Sayfa >= 1){?>
                            </ul>
                        </nav>
                    <?php } ?>
                    </div>
                <?php }?>
                <!---- Sayfalama Elementleri ================== !-->



        </div>
        <!--  <========SON=========>>> Right Content SON !-->



    </div>


</div>
<!-- CONTENT AREA ============== !-->



<?php include 'includes/template/footer.php'?>
</body>
</html>
<?php include "includes/config/footer_libs.php";?>

    <!-- SİL UYARI POPUP !-->
    <style>
        .modal-content {
            border:1px solid #FFF !important;
            box-sizing: border-box !important;
            background-clip: border-box !important;
        }
        .modal-footer{
            border-top: 1px solid #ebebeb !important;
        }
    </style>
    <div class="modal " id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" >
        <div class="modal-dialog modal-dialog-centered modal-sm ">
            <div class="modal-content">
                <div style="position: absolute; z-index: 9; right: 10px">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="outline: none">
                        <i class="ion-ios-close-empty"></i>
                    </button>
                </div>
                <div class="modal-body" style="font-size: 14px ; font-weight: 300;  padding:  20px !important; letter-spacing: 0.04em!important;">
                    <?=$diller['users-panel-text85']?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="button-green button-2x"   data-dismiss="modal"><?=$diller['users-panel-text38']?></button>
                    <a class="button-red button-2x btn-ok" ><i class="fa fa-trash-o"></i> <?=$diller['users-panel-text37']?></a>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('a[data-confirm]').click(function(ev) {
                var href = $(this).attr('href');

                if (!$('#dataConfirmModal').length) {
                    $('body').append('<div id="dataConfirmModal" class="modal" role="dialog" aria-labelledby="dataConfirmLabel" aria-hidden="true"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button><h3 id="dataConfirmLabel">Please Confirm</h3></div><div class="modal-body"></div><div class="modal-footer"><button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button><a class="btn btn-primary" id="dataConfirmOK">OK</a></div></div>');
                }
                $('#dataConfirmModal').find('.modal-body').text($(this).attr('data-confirm'));
                $('#dataConfirmOK').attr('href', href);
                $('#dataConfirmModal').modal({show:true});
                return false;
            });
        });

        $('#confirm-delete').on('show.bs.modal', function(e) {
            $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
        });

    </script>
    <!-- SİL UYARI POPUP !-->

    <?php if($_SESSION['adres_alert'] =='success'  ) {?>
        <div class="modal fade" id="okArea" data-backdrop="static" >
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                    <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                        <i class="ion-ios-checkmark-outline" style="font-size: 60px ; color: #66B483;"></i><br>
                        <div style="font-weight: bold; margin-bottom: 20px; font-size: 20px ; color: #66B483;"><?=$diller['alert-success']?></div>
                        <div>
                            <?=$diller['users-panel-text92']?>
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
        <?php unset($_SESSION['adres_alert']); ?>
    <?php }?>
    <?php if($_SESSION['adres_alert'] =='success_edit'  ) {?>
        <div class="modal fade" id="okArea" data-backdrop="static" >
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                    <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                        <i class="ion-ios-checkmark-outline" style="font-size: 60px ; color: #66B483;"></i><br>
                        <div style="font-weight: bold; margin-bottom: 20px; font-size: 20px ; color: #66B483;"><?=$diller['alert-success']?></div>
                        <div>
                            <?=$diller['users-panel-text98']?>
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
        <?php unset($_SESSION['adres_alert']); ?>
    <?php }?>

    <?php
}else{
    header('Location:'.$ayar['site_url'].'404');
}
?>
