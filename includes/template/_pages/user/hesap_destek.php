<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
if($userSorgusu->rowCount()>'0' && $uyeayar['destek_alani'] == '1' ) {
    if( $userCek['destek'] == '1' || $userCek['destek'] == '2' ) {
$userpage = 'destek';
$Sayfa = @intval($_GET['page']); if(!$Sayfa) $Sayfa = 1;
$Say = $db->query("select * from destek_talebi where uye_id='$userCek[id]'  ");
$ToplamVeri = $Say->rowCount();
$Limit = 10;
$Sayfa_Sayisi = ceil($ToplamVeri/$Limit); if($Sayfa > $Sayfa_Sayisi){$Sayfa = 1;}
$Goster = $Sayfa * $Limit - $Limit;
$GorunenSayfa = 5;
$islemListele = $db->query("select * from destek_talebi where uye_id='$userCek[id]' order by id DESC limit $Goster,$Limit");
$islemCek = $islemListele->fetchAll(PDO::FETCH_ASSOC);


?>
<title><?php echo $diller['users-destek-seo-title']; ?> - <?php echo $ayar['site_baslik']?></title>
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
        </div>
        <!--  <========SON=========>>> Header SON !-->
        <?php include 'includes/template/helper/users/leftbar.php'; ?>

        <!-- Right Content !-->
        <div class="user_subpage_coupon_content">

            <?php if($ToplamVeri>'0'  ) {?>
                <!-- Head !-->
                <div class="user_subpage_flex_header">
                    <div class="user_subpage_flex_header_h">
                        <?=$diller['users-panel-text54']?>
                    </div>
                    <?php if($userCek['destek'] == '1') {?>
                        <div class="user_subpage_flex_header_right ">
                            <a href="hesabim/yeni-destek-talebi/" class="button-blue button-1x" ><i class="las la-plus"></i> <?=$diller['users-panel-text55']?></a>
                        </div>
                    <?php }?>
                    <?php if($userCek['destek'] == '2') {
                    $today = date('Y-m-d');
                    if($userCek['destek_sure_2'] >= $today  ) {?>
                        <div class="user_subpage_flex_header_right ">
                            <a href="hesabim/yeni-destek-talebi/" class="button-blue button-1x" ><i class="las la-plus"></i> <?=$diller['users-panel-text55']?></a>
                        </div>
                        <?php }?>
                    <?php }?>
                </div>
                <?php if($userCek['destek'] == '2'  ) {
                    $today = date('Y-m-d');
                    ?>
                    <?php if($userCek['destek_sure_2'] < $today   ) {?>
                        <div class="alert-danger alert rounded-0 font-13 ">
                            <div class="font-bold mb-2 font-14 text-uppercase">
                                <?=$diller['alert-warning-2']?>
                            </div>
                            <?=$diller['users-panel-text196']?>
                        </div>
                    <?php }?>
                <?php }?>

                <!--  <========SON=========>>> Head SON !-->

                <div class="user_subpage_ticket_line_hed">
                    <div class="user_subpage_ticket_line_hed_in">
                        <div class="user_subpage_ticket_line_hed_text"><?=$diller['users-panel-text73']?></div>
                    </div>
                </div>


                <div class="user_subpage_ticketbox_main">
                <?php foreach ($islemCek as $islem) {?>
                  <div class="user_subpage_ticketbox">
                      <div class="user_subpage_ticketbox_number">
                          #<?=$islem['destek_no']?>
                      </div>
                      <div class="user_subpage_ticketbox_h">
                          <?=$islem['baslik']?>
                      </div>
                      <div class="user_subpage_ticketbox_status">
                        <?php if($islem['durum'] == '0' ) {?>
                        <span style="color: red;"><?=$diller['users-panel-text58']?></span>
                        <?php }?>
                          <?php if($islem['durum'] == '1' ) {?>
                              <span style="color: mediumseagreen;"><?=$diller['users-panel-text57']?></span>
                          <?php }?>
                      </div>
                      <div class="user_subpage_ticketbox_lasthour">
                          <div class="user_subpage_ticketbox_lasthour_1">
                              <?=$diller['users-panel-text60']?> :
                          </div>
                          <div class="user_subpage_ticketbox_lasthour_2">
                              <?php echo date_tr('j F Y, H:i, l ', ''.$islem['son_islem'].''); ?>
                          </div>
                      </div>
                          <a class="user_subpage_ticketbox_go" href="hesabim/destek-detay/<?=$islem['destek_no']?>/">
                              <i class="las la-angle-right"></i>
                          </a>
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

                                    <li class="page-item"><a class="page-link" href="hesabim/destek/<?php if(isset($_GET['status'])) { ?>?status=<?=$_GET['status']?><?php }else{?><?php } ?>"><?=$diller['sayfalama-ilk']?></a></li>
                                    <li class="page-item"><a class="page-link" href="hesabim/destek/<?php if(isset($_GET['status'])) { ?>?status=<?=$_GET['status']?>&page=<?=$Sayfa - 1?><?php }else{?>?page=<?=$Sayfa - 1?><?php } ?>"><?=$diller['sayfalama-onceki']?></a></li>

                                <?php } ?>
                                <?php
                                for($i = $Sayfa - $GorunenSayfa; $i < $Sayfa + $GorunenSayfa +1; $i++){ if($i > 0 and $i <= $Sayfa_Sayisi){
                                    if($i == $Sayfa){
                                        ?>

                                        <li class="page-item active" aria-current="page">
                                            <a class="page-link" href="hesabim/destek/?page=<?=$i?>"><?=$i?><span class="sr-only">(current)</span></a>
                                        </li>

                                        <?php
                                    }else{
                                        ?>
                                        <li class="page-item"><a class="page-link" href="hesabim/destek/?page=<?=$i?>"><?=$i?></a></li>
                                        <?php
                                    }
                                }
                                }
                                ?>

                                <?php if($islemListele->rowCount() <=0) { } else { ?>
                                    <?php if($Sayfa != $Sayfa_Sayisi){?>

                                        <li class="page-item"><a class="page-link" href="hesabim/destek/?page=<?=$Sayfa + 1?>"><?=$diller['sayfalama-sonraki']?></a></li>
                                        <li class="page-item"><a class="page-link" href="hesabim/destek/?page=<?=$Sayfa_Sayisi?>"><?=$diller['sayfalama-son']?></a></li>


                                    <?php }} ?>

                                <?php if($Sayfa >= 1){?>
                            </ul>
                        </nav>
                    <?php } ?>
                    </div>
                <?php }?>
                <!---- Sayfalama Elementleri ================== !-->


            <?php }else { ?>
                <?php if($userCek['destek'] == '1') {?>
                    <div class="user_subpage_favorites_noitems" >
                        <i class="las la-envelope" style="color: #000; margin-bottom: 10px;"></i>
                        <div class="user_subpage_favorites_noitems_head">
                            <?=$diller['users-panel-text56']?>
                        </div>
                        <a href="hesabim/yeni-destek-talebi/" class="button-blue button-2x" ><i class="las la-plus" style="font-size: 14px ; color: #fff;"></i> <?=$diller['users-panel-text55']?></a>
                    </div>
                <?php }?>
                <?php if($userCek['destek'] == '2') {?>
                    <?php
                    $today = date('Y-m-d');
                    if($userCek['destek_sure_2'] < $today   ) {?>
                        <div class="user_subpage_favorites_noitems" >
                            <i class="fa fa-calendar-times-o" style="color: #000; margin-bottom: 10px; font-size: 40px ;"></i>
                            <div class="user_subpage_favorites_noitems_head">
                                <?=$diller['users-panel-text198']?>
                            </div>
                        </div>
                    <?php }else { ?>
                        <div class="user_subpage_favorites_noitems" >
                            <i class="las la-envelope" style="color: #000; margin-bottom: 10px;"></i>
                            <div class="user_subpage_favorites_noitems_head">
                                <?=$diller['users-panel-text56']?>
                            </div>
                            <a href="hesabim/yeni-destek-talebi/" class="button-blue button-2x" ><i class="las la-plus" style="font-size: 14px ; color: #fff;"></i> <?=$diller['users-panel-text55']?></a>
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
<?php include "includes/config/footer_libs.php";?>
    <?php if($_SESSION['destek_alert'] =='success'  ) {?>
        <div class="modal fade" id="okArea" data-backdrop="static" >
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                    <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                        <i class="ion-ios-checkmark-outline" style="font-size: 60px ; color: #66B483;"></i><br>
                        <div style="font-weight: bold; margin-bottom: 20px; font-size: 20px ; color: #66B483;"><?=$diller['alert-success']?></div>
                        <div>
                            <?=$diller['users-panel-text68']?>
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

    <?php
    }else{
    header('Location:'.$ayar['site_url'].'404');
}
}else{
    header('Location:'.$ayar['site_url'].'404');
}
?>
