<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
if($userSorgusu->rowCount()>'0') {

$userpage = 'tekurun';
$Sayfa = @intval($_GET['page']); if(!$Sayfa) $Sayfa = 1;
$Say = $db->query("select * from siparis_normal where uye_id='$userCek[id]'  ");
$ToplamVeri = $Say->rowCount();
$Limit = 12;
$Sayfa_Sayisi = ceil($ToplamVeri/$Limit); if($Sayfa > $Sayfa_Sayisi){$Sayfa = 1;}
$Goster = $Sayfa * $Limit - $Limit;
$GorunenSayfa = 2;
$islemListele = $db->query("select * from siparis_normal where uye_id='$userCek[id]'  order by id DESC limit $Goster,$Limit");
$islemCek = $islemListele->fetchAll(PDO::FETCH_ASSOC);

if($ToplamVeri <='0'  ) {
 header('Location:'.$ayar['site_url'].'404');
}
?>
<title><?php echo $diller['users-tek-urun-seo-title']; ?> - <?php echo $ayar['site_baslik']?></title>
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
            <a href="hesabim/tek-urun-siparisleri/"><?=$diller['users-panel-baglanti-text18']?></a>
        </div>
        <!--  <========SON=========>>> Header SON !-->


        <?php include 'includes/template/helper/users/leftbar.php'; ?>

        <!-- Right Content !-->
        <div class="user_subpage_favorites_content">






            <?php if($ToplamVeri > '0'   ) {?>

                <!-- Head !-->
                <div class="user_subpage_flex_header">
                    <div class="user_subpage_flex_header_h">
                        <?=$diller['users-panel-text179']?> (<?=$ToplamVeri?>)
                    </div>
                </div>
                <!--  <========SON=========>>> Head SON !-->


                <div class="user_subpage_favorites_box_div_out">
                    <div class="user_subpage_favorites_box_div">
                        <?php foreach ($islemCek as $islemRow) {
                            $urunSorgusu = $db->prepare("select * from urun where id=:id ");
                            $urunSorgusu->execute(array(
                                'id' => $islemRow['urun_id']
                            ));
                            $urunRow = $urunSorgusu->fetch(PDO::FETCH_ASSOC);

                            $duruMCek = $db->prepare("select * from siparis_durumlar where id=:id ");
                            $duruMCek->execute(array(
                                    'id' => $islemRow['durum'],
                            ));
                            $durum = $duruMCek->fetch(PDO::FETCH_ASSOC);
                            ?>
                            <?php if($urunSorgusu->rowCount()>'0'  ) {?>
                            <div class="user_subpage_favorites_box">
                                <div class="user_subpage_comment_box_status <?=$durum['renk']?>" style=" text-align: center;">
                                    <?=$durum['baslik']?>
                                </div>
                                <div class="user_subpage_favorites_box_img">
                                    <a href="<?=$urunRow['seo_url']?>-P<?=$urunRow['id']?>"  target="_blank">
                                        <img src="images/product/<?=$urunRow['gorsel']?>" alt="<?=$urunRow['baslik']?>">
                                    </a>
                                </div>
                                <div class="user_subpage_favorites_box_h">
                                    <a href="<?=$urunRow['seo_url']?>-P<?=$urunRow['id']?>" style="color: #666;" target="_blank">
                                        <?=$urunRow['baslik']?>
                                    </a>
                                    <br><br>
                                    <div class="user_subpage_favorites_box_hin rounded" style="color: #333;">
                                        <?=$diller['users-panel-text102']?> : <span style="font-weight: 600;">#<?=$islemRow['siparis_no']?></span>
                                    </div>
                                </div>
                                <div class="user_subpage_favorites_box_go">
                                    <a data-id="<?=$islemRow['siparis_no']?>" class="duzenleAjax btn-block"  style="cursor: pointer; text-align: center; border: 1px solid #999; font-weight: 600; font-size: 13px ;  box-sizing: border-box; padding: 4px 15px; border-radius: 5px" >
                                        <?=$diller['users-panel-text183']?>
                                    </a>
                                </div>
                            </div>
                            <?php }?>
                        <?php }?>
                    </div>
                </div>
            <?php }?>


            <!---- Sayfalama Elementleri ================== !-->
            <?php if($ToplamVeri > $Limit  ) {?>
                <div id="SayfalamaElementi" style="width: 100%;  ">
                    <?php if($Sayfa >= 1){?>
                    <nav aria-label="Page navigation example" style="margin-top: 20px;">
                        <ul class="pagination pagination-sm">
                            <?php } ?>

                            <?php if($Sayfa > 1){?>

                                <li class="page-item"><a class="page-link" href="hesabim/tek-urun-siparisleri/<?php if(isset($_GET['status'])) { ?>?status=<?=$_GET['status']?><?php }else{?><?php } ?>"><?=$diller['sayfalama-ilk']?></a></li>
                                <li class="page-item"><a class="page-link" href="hesabim/tek-urun-siparisleri/<?php if(isset($_GET['status'])) { ?>?status=<?=$_GET['status']?>&page=<?=$Sayfa - 1?><?php }else{?>?page=<?=$Sayfa - 1?><?php } ?>"><?=$diller['sayfalama-onceki']?></a></li>

                            <?php } ?>
                            <?php
                            for($i = $Sayfa - $GorunenSayfa; $i < $Sayfa + $GorunenSayfa +1; $i++){ if($i > 0 and $i <= $Sayfa_Sayisi){
                                if($i == $Sayfa){
                                    ?>

                                    <li class="page-item active" aria-current="page">
                                        <a class="page-link" href="hesabim/tek-urun-siparisleri/?page=<?=$i?>"><?=$i?><span class="sr-only">(current)</span></a>
                                    </li>

                                    <?php
                                }else{
                                    ?>
                                    <li class="page-item"><a class="page-link" href="hesabim/tek-urun-siparisleri/?page=<?=$i?>"><?=$i?></a></li>
                                    <?php
                                }
                            }
                            }
                            ?>

                            <?php if($islemListele->rowCount() <=0) { } else { ?>
                                <?php if($Sayfa != $Sayfa_Sayisi){?>

                                    <li class="page-item"><a class="page-link" href="hesabim/tek-urun-siparisleri/?page=<?=$Sayfa + 1?>"><?=$diller['sayfalama-sonraki']?></a></li>
                                    <li class="page-item"><a class="page-link" href="hesabim/tek-urun-siparisleri/?page=<?=$Sayfa_Sayisi?>"><?=$diller['sayfalama-son']?></a></li>


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


    <!-- Düzenle Modal EDITABLE !-->
        <div id="duzenle" class="modal " data-backdrop="static" >
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content modal-editable rounded shadow-lg">

                </div>
            </div>
        </div>
    <!--  <========SON=========>>> Düzenle Modal EDITABLE SON !-->


<?php include 'includes/template/footer.php'?>
</body>
</html>
<?php include "includes/config/footer_libs.php";?>
    <script type='text/javascript'>
    $(document).ready(function(){

        $('.duzenleAjax').click(function(){

            var siparisID = $(this).data('id');

            // AJAX request
            $.ajax({
                url: 'normal-siparis-ajax',
                type: 'post',
                data: {siparisID: siparisID},
                success: function(response){
                    $('.modal-editable').html(response);
                    $('#duzenle').modal('show');
                }
            });
        });
    });
</script>
    <?php
}else{
    header('Location:'.$ayar['site_url'].'404');
}
?>