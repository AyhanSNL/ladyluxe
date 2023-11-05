<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
if($userSorgusu->rowCount()>'0' && $uyeayar['kupon_alani'] == '1') {
$userpage = 'kupon';
$Sayfa = @intval($_GET['page']); if(!$Sayfa) $Sayfa = 1;
$Say = $db->query("select * from kupon where uye_id='$userCek[id]' and durum='1'  ");
$ToplamVeri = $Say->rowCount();
$Limit = 10;
$Sayfa_Sayisi = ceil($ToplamVeri/$Limit); if($Sayfa > $Sayfa_Sayisi){$Sayfa = 1;}
$Goster = $Sayfa * $Limit - $Limit;
$GorunenSayfa = 5;
$islemListele = $db->query("select * from kupon where uye_id='$userCek[id]' and durum='1' order by id DESC limit $Goster,$Limit");
$islemCek = $islemListele->fetchAll(PDO::FETCH_ASSOC);


?>
<title><?php echo $diller['users-kuponlar-seo-title']; ?> - <?php echo $ayar['site_baslik']?></title>
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
            <a href="hesabim/kuponlar/"><?=$diller['users-panel-baglanti-text6']?></a>
        </div>
        <!--  <========SON=========>>> Header SON !-->
        <?php include 'includes/template/helper/users/leftbar.php'; ?>

        <!-- Right Content !-->
        <div class="user_subpage_coupon_content">

            <?php if($ToplamVeri>'0'  ) {?>
                <!-- Head !-->
                <div class="user_subpage_account_header">
                    <?=$diller['users-panel-text39']?>
                    <div class="user_subpage_account_spot">
                        <?=$diller['users-panel-text40']?>
                    </div>
                </div>
                <!--  <========SON=========>>> Head SON !-->

                <?php foreach ($islemCek as $islem) {
                    $sepetKupon = $db->prepare("select * from sepet_kupon where uye_id=:uye_id and kupon_id=:kupon_id ");
                    $sepetKupon->execute(array(
                        'uye_id' => $islem['uye_id'],
                        'kupon_id' => $islem['id']
                    ));
                    $sepetKuponRow = $sepetKupon->fetch(PDO::FETCH_ASSOC);
                    $timestamp = date('Y-m-d');
                    ?>
                    <?php if($ToplamVeri >'0'  ) {?>
                        <div class="user_subpage_kupon_box">
                            <div class="user_subpage_kupon_name">
                                <div class="user_subpage_kupon_name_1">
                                    <?=$islem['baslik']?>
                                </div>
                                <?php if($islem['sepe_alt_limit'] >'0'  ) {?>
                                    <div class="user_subpage_kupon_name_2">
                                        <?=kur_cekimi($islem['sepe_alt_limit'])?> <?=$diller['users-panel-text43']?>
                                    </div>
                                <?php }?>
                            </div>
                            <div class="user_subpage_kupon_tutar">
                                <?php if($islem['tur'] == '1' ) {?>
                                    <div class="user_subpage_kupon_tutar_1">
                                        <?=$diller['users-panel-text45']?>
                                    </div>
                                <?php }?>
                                <?php if($islem['tur'] == '2' ) {?>
                                    <div class="user_subpage_kupon_tutar_1">
                                        <?=$diller['users-panel-text44']?>
                                    </div>
                                <?php }?>
                                <div class="user_subpage_kupon_tutar_2">
                                    <?php if($islem['tur'] == '1' ) {?>
                                        %<?php echo number_format($islem['indirim_tutar'], 0); ?>
                                    <?php }?>
                                    <?php if($islem['tur'] == '2' ) {?>
                                        <?=kur_cekimi($islem['indirim_tutar'])?>
                                    <?php }?>
                                </div>
                            </div>
                            <div class="user_subpage_kupon_sdate">
                                <div class="user_subpage_kupon_sdate_1">
                                    <?=$diller['users-panel-text46']?>
                                </div>
                                <div class="user_subpage_kupon_sdate_2">
                                    <?php echo date_tr('j F Y', ''.$islem['baslangic'].''); ?>
                                </div>
                            </div>
                            <div class="user_subpage_kupon_fdate">
                                <div class="user_subpage_kupon_fdate_1">
                                    <?=$diller['users-panel-text47']?>
                                </div>
                                <div class="user_subpage_kupon_fdate_2">
                                    <?php echo date_tr('j F Y', ''.$islem['bitis'].''); ?>
                                </div>
                            </div>
                            <div class="user_subpage_kupon_status">
                                <div class="user_subpage_kupon_status_1">
                                    <?=$diller['users-panel-text48']?>
                                </div>
                                <div class="user_subpage_kupon_status_2">
                                    <?php if($sepetKupon->rowCount()>'0'  ) {?>
                                        <?php if($sepetKuponRow['kullanim']  == '1' ) {?>
                                            <span style="color:red; font-weight: 600;"><?=$diller['users-panel-text49']?>
                                            <a href="hesabim/siparis-detay/<?=$sepetKuponRow['siparis_id']?>/" data-toggle="tooltip" data-placement="top" title="<?=$diller['users-panel-text53']?>" style="color: red;">
                                                <i class="las la-external-link-alt" style="font-size: 15px ;"></i>
                                            </a>
                                            </span>
                                        <?php }else { ?>
                                            <?php if($timestamp >= $islem['baslangic']) {?>
                                                <?php if($timestamp <= $islem['bitis']) {?>
                                                    <span style="color:mediumseagreen; font-weight: 600;"><?=$diller['users-panel-text52']?></span>
                                                <?php }else { ?>
                                                    <span style="color:red; font-weight: 600;"><?=$diller['users-panel-text50']?></span>
                                                <?php }?>
                                            <?php }else { ?>
                                                <span style="color:red; font-weight: 600;"><?=$diller['users-panel-text51']?></span>
                                            <?php }?>
                                        <?php }?>
                                    <?php }else { ?>
                                        <?php if($timestamp >= $islem['baslangic']) {?>
                                            <?php if($timestamp <= $islem['bitis']) {?>
                                                <span style="color:mediumseagreen; font-weight: 600;"><?=$diller['users-panel-text52']?></span>
                                            <?php }else { ?>
                                                <span style="color:red; font-weight: 600;"><?=$diller['users-panel-text50']?></span>
                                            <?php }?>
                                        <?php }else { ?>
                                            <span style="color:red; font-weight: 600;"><?=$diller['users-panel-text51']?></span>
                                        <?php }?>
                                    <?php }?>
                                </div>
                            </div>
                            <div class="user_subpage_kupon_name_3">
                               <?=$diller['users-panel-text194']?> <span style="font-weight: bold;"><?=$islem['kod']?></span>
                            </div>
                        </div>
                    <?php }?>
                <?php }?>


                <!---- Sayfalama Elementleri ================== !-->
                <?php if($ToplamVeri > $Limit  ) {?>
                    <div id="SayfalamaElementi" style="width: 100%;  ">
                        <?php if($Sayfa >= 1){?>
                        <nav aria-label="Page navigation example" style="margin-top: 20px;">
                            <ul class="pagination pagination-sm">
                                <?php } ?>

                                <?php if($Sayfa > 1){?>

                                    <li class="page-item"><a class="page-link" href="hesabim/kuponlar/<?php if(isset($_GET['status'])) { ?>?status=<?=$_GET['status']?><?php }else{?><?php } ?>"><?=$diller['sayfalama-ilk']?></a></li>
                                    <li class="page-item"><a class="page-link" href="hesabim/kuponlar/<?php if(isset($_GET['status'])) { ?>?status=<?=$_GET['status']?>&page=<?=$Sayfa - 1?><?php }else{?>?page=<?=$Sayfa - 1?><?php } ?>"><?=$diller['sayfalama-onceki']?></a></li>

                                <?php } ?>
                                <?php
                                for($i = $Sayfa - $GorunenSayfa; $i < $Sayfa + $GorunenSayfa +1; $i++){ if($i > 0 and $i <= $Sayfa_Sayisi){
                                    if($i == $Sayfa){
                                        ?>

                                        <li class="page-item active" aria-current="page">
                                            <a class="page-link" href="hesabim/kuponlar/?page=<?=$i?>"><?=$i?><span class="sr-only">(current)</span></a>
                                        </li>

                                        <?php
                                    }else{
                                        ?>
                                        <li class="page-item"><a class="page-link" href="hesabim/kuponlar/?page=<?=$i?>"><?=$i?></a></li>
                                        <?php
                                    }
                                }
                                }
                                ?>

                                <?php if($islemListele->rowCount() <=0) { } else { ?>
                                    <?php if($Sayfa != $Sayfa_Sayisi){?>

                                        <li class="page-item"><a class="page-link" href="hesabim/kuponlar/?page=<?=$Sayfa + 1?>"><?=$diller['sayfalama-sonraki']?></a></li>
                                        <li class="page-item"><a class="page-link" href="hesabim/kuponlar/?page=<?=$Sayfa_Sayisi?>"><?=$diller['sayfalama-son']?></a></li>


                                    <?php }} ?>

                                <?php if($Sayfa >= 1){?>
                            </ul>
                        </nav>
                    <?php } ?>
                    </div>
                <?php }?>
                <!---- Sayfalama Elementleri ================== !-->


            <?php }else { ?>
                <div class="user_subpage_favorites_noitems" >
                    <i class="las la-tags" style="color: #000; margin-bottom: 10px;"></i>
                    <div class="user_subpage_favorites_noitems_head">
                        <?=$diller['users-panel-text41']?>
                    </div>
                    <div class="user_subpage_favorites_noitems_s">
                        <?=$diller['users-panel-text42']?>
                    </div>
                </div>
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
    <?php
}else{
    header('Location:'.$ayar['site_url'].'404');
}
?>
