<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
if($userSorgusu->rowCount()>'0' && $uyeayar['siparisler_alani'] == '1') {
$userpage = 'siparis';

    if(isset($_GET['orderNo'])) {
        if($_GET['orderNo'] == !null  ) {

            if($_GET['orderNo'] != htmlspecialchars($_GET['orderNo'])  ) {
                header('Location:'.$ayar['site_url'].'404');
                exit();
            }
            $getCagir = htmlspecialchars($_GET['orderNo']);
            $araGet = "and siparis_no='$getCagir'";

        }else{
            header('Location:'.$ayar['site_url'].'hesabim/siparisler/');
        }
    }

    /* Date Filter */
    $bugun = date("Y-m-d");


    if(isset($_GET['dateShow'])  ) {
        $dateShow = htmlspecialchars($_GET['dateShow']);
        if($dateShow == '30' || $dateShow=='60' || $dateShow=='90'  ) {

            if($dateShow == '30'  ) {
                $cevir = strtotime('-31 day',strtotime($bugun));
                $tarihgetir = date("Y-m-d",$cevir);
                $dateSql = "and sade_tarih >='$tarihgetir'";
                $datePage = '&dateShow=30';
            }
            if($dateShow == '60'  ) {
                $cevir = strtotime('-61 day',strtotime($bugun));
                $tarihgetir = date("Y-m-d",$cevir);
                $dateSql = "and sade_tarih >='$tarihgetir'";
                $datePage = '&dateShow=60';
            }
            if($dateShow == '90'  ) {
                $cevir = strtotime('-91 day',strtotime($bugun));
                $tarihgetir = date("Y-m-d",$cevir);
                $dateSql = "and sade_tarih >='$tarihgetir'";
                $datePage = '&dateShow=90';
            }
        }else{
            header('Location:'.$ayar['site_url'].'hesabim/siparisler/');
        }
    }
    /*  <========SON=========>>> Date Filter SON */


$Sayfa = @intval($_GET['page']); if(!$Sayfa) $Sayfa = 1;
$Say = $db->query("select * from siparisler where uye_id='$userCek[id]' and onay='1' $araGet $dateSql");
$ToplamVeri = $Say->rowCount();
$Limit = 15;
$Sayfa_Sayisi = ceil($ToplamVeri/$Limit); if($Sayfa > $Sayfa_Sayisi){$Sayfa = 1;}
$Goster = $Sayfa * $Limit - $Limit;
$GorunenSayfa = 5;
$islemListele = $db->query("select * from siparisler where uye_id='$userCek[id]' and onay='1' $araGet $dateSql order by id DESC limit $Goster,$Limit");
$islemCek = $islemListele->fetchAll(PDO::FETCH_ASSOC);
?>
<title><?php echo $diller['users-siparisler-seo-title']; ?> - <?php echo $ayar['site_baslik']?></title>
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
            <a href="hesabim/siparisler/"><?=$diller['users-panel-baglanti-text13']?></a>
        </div>
        <!--  <========SON=========>>> Header SON !-->
        <?php include 'includes/template/helper/users/leftbar.php'; ?>

        <!-- Right Content !-->
        <div class="user_subpage_coupon_content">

            <?php if($ToplamVeri>'0'  ) {?>
                <!-- Head !-->
                <div class="user_subpage_flex_header">
                <div class="user_subpage_flex_header_h">
                   <?=$diller['users-panel-text99']?>
                    <?php if(isset($_GET['status'])  ) {?>
                        <div class="user_subpage_flex_header_links">
                            <?php if($_GET['status'] == '1'  ) {?>
                                <a href="hesabim/yorumlar/" class="button-green button-1x">
                                    <i class="fa fa-check"></i>  <?=$diller['users-panel-text29']?>
                                </a>
                            <?php }?>
                            <?php if($_GET['status'] == '0'  ) {?>
                                <a href="hesabim/yorumlar/" class="button-grey button-1x">
                                    <i class="fa fa-refresh"></i>  <?=$diller['users-panel-text30']?>
                                </a>
                            <?php }?>
                            <?php if($_GET['status'] == '2'  ) {?>
                                <a href="hesabim/yorumlar/" class="button-red button-1x">
                                    <i class="fa fa-times"></i>  <?=$diller['users-panel-text31']?>
                                </a>
                            <?php }?>
                        </div>
                    <?php }?>
                </div>

                <div class="user_subpage_flex_header_right ">
                    <div class="order-search-user-filter" >
                        <?php if(isset($_GET['orderNo']) && $_GET['orderNo'] == !null ) {?>
                            <a href="hesabim/siparisler/" class="button-red button-1x mr-2">
                                <i class="fa fa-times"></i>
                            </a>
                        <?php }?>
                        <form method="GET" action="" class="ustsearch_area">
                            <input type="number" name="orderNo"  autocomplete="off" required class="form-control" <?php if(isset($_GET['orderNo'])  ) { ?>value="<?=$_GET['orderNo']?>" <?php }?> placeholder="<?=$diller['users-panel-text178']?>">
                            <button type="submit"><i class="fa fa-search"></i></button>
                        </form>
                    </div>
                    <select name="s" id="dynamic_select" class="select user_subpage_select"  required>
                        <option value="hesabim/siparisler/" ><?=$diller['users-panel-text227']?></option>
                        <option value="hesabim/siparisler/?dateShow=30" <?php if(isset($_GET['dateShow']) && $_GET['dateShow'] == '30') { ?>selected<?php }?>><?=$diller['users-panel-text228']?></option>
                        <option value="hesabim/siparisler/?dateShow=60" <?php if(isset($_GET['dateShow']) && $_GET['dateShow'] == '60') { ?>selected<?php }?>><?=$diller['users-panel-text229']?></option>
                        <option value="hesabim/siparisler/?dateShow=90" <?php if(isset($_GET['dateShow']) && $_GET['dateShow'] == '90') { ?>selected<?php }?>><?=$diller['users-panel-text230']?></option>
                    </select>
                </div>
            </div>
                <!--  <========SON=========>>> Head SON !-->


                <div class="user_subpage_siparis_boxes_div">


                <?php foreach ($islemCek as $row) {
                    /* ilk ürünü çek */
                    $ilkUrun = $db->prepare("select * from siparis_urunler where siparis_id='$row[siparis_no]' order by id asc limit 1");
                    $ilkUrun->execute();
                    $ilkrow = $ilkUrun->fetch(PDO::FETCH_ASSOC);
                    
                    $sonurun = $db->prepare("select * from urun where id='$ilkrow[urun_id]'");
                    $sonurun->execute();
                    $sonrow = $sonurun->fetch(PDO::FETCH_ASSOC);
                    /*  <========SON=========>>> ilk ürünü çek SON */
                    
                    /* Sipariş Durum Çek */
                    $siparisStatus = $db->prepare("select * from siparis_durumlar where id='$row[siparis_durum]' ");
                    $siparisStatus->execute();
                    $siparisDurum = $siparisStatus->fetch(PDO::FETCH_ASSOC);
                    /*  <========SON=========>>> Sipariş Durum Çek SON */
                    
                    /* Parabirimi */
                    $parabirimleriniSorgula = $db->prepare("select * from para_birimleri where kod='$row[parabirimi]' ");
                    $parabirimleriniSorgula->execute(array());
                     $paraRow = $parabirimleriniSorgula->fetch(PDO::FETCH_ASSOC);
                    /*  <========SON=========>>> Parabirimi SON */
                    
                    /* İptal Talebi Sorgusu */
                    $iptalSorgusuSiparis = $db->prepare("select * from siparis_iptal where siparis_no=:siparis_no and uye_id=:uye_id and durum=:durum ");
                    $iptalSorgusuSiparis->execute(array(
                            'siparis_no' => $row['siparis_no'],
                            'uye_id' => $userCek['id'],
                            'durum' => '0'
                    ));
                    /*  <========SON=========>>> İptal Talebi Sorgusu SON */
                    ?>
                    <div class="user_subpage_siparis_box">

                        <div class="user_subpage_siparis_box_img" style="border-radius: 100px">
                            <img src="images/product/<?=$sonrow['gorsel']?>" style="border-radius: 100px">
                        </div>

                        <div class="user_subpage_siparis_box_orderno">
                            <div class="user_subpage_siparis_box_orderno-1">
                                <?=$diller['users-panel-text102']?> : <strong><?=$row['siparis_no']?></strong>
                            </div>
                            <div class="user_subpage_siparis_box_orderno-2">
                                <?php echo date_tr('j F Y, H:i', ''.$row['siparis_tarih'].''); ?>
                            </div>
                        </div>

                        <?php if($row['iptal'] == '0' ||$row['iptal'] == null ) {?>
                            <div class="user_subpage_siparis_box_status">
                                <?php if($odemeayar['siparis_iptal'] == '1' ) {?>
                                    <?php if($iptalSorgusuSiparis->rowCount()>'0'  ) {?>
                                        <div class="button-red shadow button-1x rounded">
                                            <i class="fa fa-refresh fa-spin fa-fw"></i>  <?=$diller['users-panel-text111']?>
                                        </div>
                                    <?php }else { ?>
                                        <div class="<?=$siparisDurum['renk']?> button-1x rounded">
                                            <?php if($siparisDurum['ikon'] == !null ) {?>
                                                <i class="fa <?=$siparisDurum['ikon']?>"></i>
                                            <?php }?>
                                            <?=$siparisDurum['baslik']?>
                                        </div>
                                    <?php }?>
                                <?php }else { ?>
                                    <div class="<?=$siparisDurum['renk']?> button-1x rounded">
                                        <?php if($siparisDurum['ikon'] == !null ) {?>
                                            <i class="fa <?=$siparisDurum['ikon']?>"></i>
                                        <?php }?>
                                        <?=$siparisDurum['baslik']?>
                                    </div>
                                <?php }?>
                            </div>
                        <?php }else { ?>
                        <div class="user_subpage_siparis_box_status_iptal rounded" style="background-color: #FFFBF9;">
                            <i class="fa fa-times"></i> <?=$diller['users-panel-text108']?>
                        </div>
                        <?php }?>
                        <div class="user_subpage_siparis_box_end">
                            <div class="user_subpage_siparis_box_end_amount">
                                <div class="user_subpage_siparis_box_end_amount_1">
                                    <?php if($row['odeme_tur'] == '2'  ) {?>
                                        <?php if($parabirimleriniSorgula->rowCount()>'0'  ) {?>
                                            <?php if($paraRow['simge_gosterim'] == '0' ) {?>
                                                <?=$paraRow['sol_simge']?>
                                            <?php }?>
                                            <?php if($paraRow['simge_gosterim'] == '1' ) {?>
                                                <?=$paraRow['sag_simge']?>
                                            <?php }?>
                                            <?php echo number_format($row['havale_toplamtutar'], $paraRow['para_format']); ?>
                                            <?php if($paraRow['simge_gosterim'] == '2' ) {?>
                                                <?=$paraRow['sol_simge']?>
                                            <?php }?>
                                            <?php if($paraRow['simge_gosterim'] == '3' ) {?>
                                                <?=$paraRow['sag_simge']?>
                                            <?php }?>
                                        <?php }else { ?>
                                            <?php echo number_format($row['havale_toplamtutar'], 2); ?> <?=$row['parabirimi']?>
                                        <?php }?>
                                    <?php }else { ?>
                                        <?php if($parabirimleriniSorgula->rowCount()>'0'  ) {?>
                                            <?php if($paraRow['simge_gosterim'] == '0' ) {?>
                                                <?=$paraRow['sol_simge']?>
                                            <?php }?>
                                            <?php if($paraRow['simge_gosterim'] == '1' ) {?>
                                                <?=$paraRow['sag_simge']?>
                                            <?php }?>
                                            <?php echo number_format($row['toplam_tutar'], $paraRow['para_format']); ?>
                                            <?php if($paraRow['simge_gosterim'] == '2' ) {?>
                                                <?=$paraRow['sol_simge']?>
                                            <?php }?>
                                            <?php if($paraRow['simge_gosterim'] == '3' ) {?>
                                                <?=$paraRow['sag_simge']?>
                                            <?php }?>
                                        <?php }else { ?>
                                            <?php echo number_format($row['toplam_tutar'], 2); ?> <?=$row['parabirimi']?>
                                        <?php }?>
                                    <?php }?>
                                </div>
                                <div class="user_subpage_siparis_box_end_amount_2">
                                    <?php if($row['odeme_tur'] == '1'  ) {?>
                                        <?=$diller['users-panel-text105']?>
                                    <?php }?>
                                    <?php if($row['odeme_tur'] == '2'  ) {?>
                                        <?=$diller['users-panel-text104']?>
                                    <?php }?>
                                    <?php if($row['odeme_tur'] == '3'  ) {?>
                                        <?=$diller['users-panel-text107']?>
                                    <?php }?>
                                    <?php if($row['odeme_tur'] == '4'  ) {?>
                                        <?=$diller['users-panel-text106']?>
                                    <?php }?>
                                </div>
                            </div>
                            <a class="user_subpage_ticketbox_go" href="hesabim/siparis-detay/<?=$row['siparis_no']?>/">
                                <i class="las la-angle-right"></i>
                            </a>
                        </div>
                    </div>
                <?php }?>

                </div>


                <!---- Sayfalama Elementleri ================== !-->
                <?php if($ToplamVeri > $Limit  ) {?>
                    <div id="SayfalamaElementi" style="width: 100%;  ">
                        <?php if($Sayfa >= 1){?>
                        <nav aria-label="Page navigation example" style="margin-top: 20px;">
                            <ul class="pagination pagination-sm">
                                <?php } ?>

                                <?php if($Sayfa > 1){?>

                                    <li class="page-item"><a class="page-link" href="hesabim/siparisler/?page=1<?=$datePage?>"><?=$diller['sayfalama-ilk']?></a></li>
                                    <li class="page-item"><a class="page-link" href="hesabim/siparisler/?page=<?=$Sayfa - 1?><?=$datePage?>"><?=$diller['sayfalama-onceki']?></a></li>

                                <?php } ?>
                                <?php
                                for($i = $Sayfa - $GorunenSayfa; $i < $Sayfa + $GorunenSayfa +1; $i++){ if($i > 0 and $i <= $Sayfa_Sayisi){
                                    if($i == $Sayfa){
                                        ?>

                                        <li class="page-item active" aria-current="page">
                                            <a class="page-link" href="hesabim/siparisler/?page=<?=$i?><?=$datePage?>"><?=$i?><span class="sr-only">(current)</span></a>
                                        </li>

                                        <?php
                                    }else{
                                        ?>
                                        <li class="page-item"><a class="page-link" href="hesabim/siparisler/?page=<?=$i?><?=$datePage?>"><?=$i?></a></li>
                                        <?php
                                    }
                                }
                                }
                                ?>

                                <?php if($islemListele->rowCount() <=0) { } else { ?>
                                    <?php if($Sayfa != $Sayfa_Sayisi){?>

                                        <li class="page-item"><a class="page-link" href="hesabim/siparisler/?page=<?=$Sayfa + 1?><?=$datePage?>"><?=$diller['sayfalama-sonraki']?></a></li>
                                        <li class="page-item"><a class="page-link" href="hesabim/siparisler/?page=<?=$Sayfa_Sayisi?><?=$datePage?>"><?=$diller['sayfalama-son']?></a></li>


                                    <?php }} ?>

                                <?php if($Sayfa >= 1){?>
                            </ul>
                        </nav>
                    <?php } ?>
                    </div>
                <?php }?>
                <!---- Sayfalama Elementleri ================== !-->


            <?php }else { ?>
                <?php if(isset($_GET['orderNo'])  ) {?>
                    <div class="user_subpage_favorites_noitems" >
                        <i class="las la-backspace" style="color: #999;"></i>
                        <div class="user_subpage_favorites_noitems_head m-top-10" >
                            <?=$diller['users-panel-text199']?>
                        </div>
                        <a href="hesabim/siparisler/" class="button-black-out button-2x m-top-20">
                            <?=$diller['users-panel-text34']?>
                        </a>
                    </div>
                <?php }else { ?>
                    <?php if(isset($_GET['dateShow'])  ) {?>
                        <?php if($_GET['dateShow'] == '30'  ) {
                            $kaynak = $diller['users-panel-text231'];
                            $eski = '{tarih}';
                            $yeni = '30';
                            $aciklamaDateShow = str_replace($eski, $yeni, $kaynak);
                            ?>
                            <div class="user_subpage_favorites_noitems" >
                                <img src="i/uploads/noOrder.svg" alt="">
                                <div class="user_subpage_favorites_noitems_head m-top-10" >
                                    <?=$aciklamaDateShow?>
                                </div>
                                <a href="hesabim/siparisler/" class="button-black-out button-2x m-top-20">
                                    <?=$diller['users-panel-text34']?>
                                </a>
                            </div>
                        <?php }?>
                        <?php if($_GET['dateShow'] == '60'  ) {
                            $kaynak = $diller['users-panel-text231'];
                            $eski = '{tarih}';
                            $yeni = '60';
                            $aciklamaDateShow = str_replace($eski, $yeni, $kaynak);
                            ?>
                            <div class="user_subpage_favorites_noitems" >
                                <img src="i/uploads/noOrder.svg" alt="">
                                <div class="user_subpage_favorites_noitems_head m-top-10" >
                                    <?=$aciklamaDateShow?>
                                </div>
                                <a href="hesabim/siparisler/" class="button-black-out button-2x m-top-20">
                                    <?=$diller['users-panel-text34']?>
                                </a>
                            </div>
                        <?php }?>
                        <?php if($_GET['dateShow'] == '90'  ) {
                            $kaynak = $diller['users-panel-text231'];
                            $eski = '{tarih}';
                            $yeni = '90';
                            $aciklamaDateShow = str_replace($eski, $yeni, $kaynak);
                            ?>
                            <div class="user_subpage_favorites_noitems" >
                                <img src="i/uploads/noOrder.svg" alt="">
                                <div class="user_subpage_favorites_noitems_head m-top-10" >
                                    <?=$aciklamaDateShow?>
                                </div>
                                <a href="hesabim/siparisler/" class="button-black-out button-2x m-top-20">
                                    <?=$diller['users-panel-text34']?>
                                </a>
                            </div>
                        <?php }?>
                    <?php }else { ?>
                        <div class="user_subpage_favorites_noitems" >
                            <i class="las la-shopping-basket" style="color: #999;"></i>
                            <div class="user_subpage_favorites_noitems_head" >
                                <?=$diller['users-panel-text100']?>
                            </div>
                            <div class="user_subpage_favorites_noitems_s">
                                <?=$diller['users-panel-text101']?>
                            </div>
                            <a href="" class="button-black-out button-2x m-top-20">
                                <?=$diller['sepet-alisverise-basla']?>
                            </a>
                        </div>
                    <?php }?>
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
    <script src="assets/js/niceselect/jquery.nice-select.min.js"></script>
    <script src="assets/js/niceselect/fastclick.js"></script>
    <script src="assets/js/niceselect/prism.js"></script>
<?php include "includes/config/footer_libs.php";?>
      <script>
          $(document).ready(function () {
              $('.select').niceSelect();
          });
        $(function(){
            $('#dynamic_select').on('change', function () {
                var url = $(this).val();
                if (url) {
                    window.location = url;
                }
                return false;
            });
        });
    </script>
    <?php if($_SESSION['iptal_status'] =='success'  ) {?>
        <div class="modal fade" id="okArea" data-backdrop="static" >
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                    <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                        <i class="ion-ios-checkmark-outline" style="font-size: 60px ; color: #66B483;"></i><br>
                        <div style="font-weight: bold; margin-bottom: 20px; font-size: 20px ; color: #66B483;"><?=$diller['alert-success']?></div>
                        <div>
                            <?=$diller['users-panel-text109']?>
                        </div>
                        <div style="font-size: 13px ; margin-top: 15px;">
                            <?=$diller['users-panel-text110']?>
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
        <?php unset($_SESSION['iptal_status']); ?>
    <?php }?>
    <?php
}else{
    header('Location:'.$ayar['site_url'].'404');
}
?>
