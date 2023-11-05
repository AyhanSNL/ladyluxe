<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
if($userSorgusu->rowCount()>'0' && $uyeayar['iptal_alani'] == '1') {

$userpage = 'iptal';
$Sayfa = @intval($_GET['page']); if(!$Sayfa) $Sayfa = 1;
$Say = $db->query("select * from siparis_iptal where uye_id='$userCek[id]'  ");
$ToplamVeri = $Say->rowCount();
$Limit = 12;
$Sayfa_Sayisi = ceil($ToplamVeri/$Limit); if($Sayfa > $Sayfa_Sayisi){$Sayfa = 1;}
$Goster = $Sayfa * $Limit - $Limit;
$GorunenSayfa = 5;
$islemListele = $db->query("select * from siparis_iptal where uye_id='$userCek[id]'  order by id DESC limit $Goster,$Limit");
$islemCek = $islemListele->fetchAll(PDO::FETCH_ASSOC);
?>
<title><?php echo $diller['users-iptal-seo-title']; ?> - <?php echo $ayar['site_baslik']?></title>
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
            <a href="hesabim/iptal-iade-talepleri/"><?=$diller['users-panel-baglanti-text15']?></a>
           <i class="las la-angle-double-right"></i>
            <a href="hesabim/iptal-talepleri/"><?=$diller['users-panel-baglanti-text17']?></a>
        </div>
        <!--  <========SON=========>>> Header SON !-->


        <?php include 'includes/template/helper/users/leftbar.php'; ?>

        <!-- Right Content !-->
        <div class="user_subpage_favorites_content">



            <?php if($ToplamVeri <= '0'   ) {?>
                <div class="user_subpage_favorites_noitems" >
                    <i class="las la-backspace" style="color: #999;"></i>
                    <div class="user_subpage_favorites_noitems_head m-top-10" >
                        <?=$diller['users-panel-text190']?>
                    </div>
                    <div class="user_subpage_favorites_noitems_s">
                        <?=$diller['users-panel-text191']?>
                    </div>
                    <a href="" class="button-black-out button-2x m-top-20">
                        <?=$diller['sepet-alisverise-basla']?>
                    </a>
                </div>
            <?php } ?>
            
            <?php if($ToplamVeri > '0'   ) {?>
                <!-- Head !-->
                <div class="user_subpage_flex_header">
                    <div class="user_subpage_flex_header_h">
                        <?=$diller['users-panel-text167']?> (<?=$ToplamVeri?>)
                    </div>
                </div>
                <!--  <========SON=========>>> Head SON !-->

                <?php if($diller['users-panel-text177'] == !null  ) {?>
                    <div class="user_subpage_info_div_blue">
                        <?=$diller['users-panel-text177']?>
                    </div>
                <?php }?>
                <div class="user_subpage_favorites_box_div_out">
                    <div class="user_subpage_favorites_box_div" style="width: 100%;  ">
                        <?php foreach ($islemCek as $islemRow) { ?>
                            <div class="user_subpage_siparis_box" style="border: 2px solid #EBEBEB;">
                                <div class="user_subpage_return_box_orderno">
                                    <div class="user_subpage_siparis_box_orderno-1">
                                        <?=$diller['users-panel-text175']?>
                                        <div class="mt-2" style="font-size: 13px ;">
                                            <strong>#<?=$islemRow['talep_no']?></strong>
                                        </div>
                                    </div>
                                </div>
                                <div class="user_subpage_return_box_orderno">
                                    <div class="user_subpage_siparis_box_orderno-1">
                                        <?=$diller['users-panel-text102']?>
                                        <div class="mt-2" style="font-size: 13px ;">
                                            <strong>#<?=$islemRow['siparis_no']?></strong>
                                        </div>
                                    </div>
                                </div>
                                <div class="user_subpage_return_box_orderno">
                                    <div class="user_subpage_siparis_box_orderno-1">
                                        <?=$diller['users-panel-text176']?>
                                        <div class="mt-2" style="font-size: 13px ;">
                                            <strong><?php echo date_tr('j F Y, H:i', ''.$islemRow['tarih'].''); ?></strong>
                                        </div>
                                    </div>
                                </div>
                                <div class="user_subpage_siparis_box_end">
                                    <div class="user_subpage_siparis_box_end_amount">
                                        <?php if($islemRow['durum'] == '0' ) {?>
                                            <div class="button-grey button-1x rounded">
                                                <i class="fa fa-refresh fa-spin fa-fw"></i><span class="sr-only">Loading...</span> <?=$diller['users-panel-text172']?>
                                            </div>
                                        <?php }?>
                                        <?php if($islemRow['durum'] == '1' ) {?>
                                            <div class="button-red button-1x rounded">
                                                <i class="fa fa-check"></i> <?=$diller['users-panel-text174']?>
                                            </div>
                                        <?php }?>
                                    </div>
                                    <a class="user_subpage_ticketbox_go"href="hesabim/siparis-detay/<?=$islemRow['siparis_no']?>/" target="_blank" >
                                        <i class="las la-angle-right"></i>
                                    </a>
                                </div>
                            </div>
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

                                <li class="page-item"><a class="page-link" href="hesabim/iptal-talepleri/<?php if(isset($_GET['status'])) { ?>?status=<?=$_GET['status']?><?php }else{?><?php } ?>"><?=$diller['sayfalama-ilk']?></a></li>
                                <li class="page-item"><a class="page-link" href="hesabim/iptal-talepleri/<?php if(isset($_GET['status'])) { ?>?status=<?=$_GET['status']?>&page=<?=$Sayfa - 1?><?php }else{?>?page=<?=$Sayfa - 1?><?php } ?>"><?=$diller['sayfalama-onceki']?></a></li>

                            <?php } ?>
                            <?php
                            for($i = $Sayfa - $GorunenSayfa; $i < $Sayfa + $GorunenSayfa +1; $i++){ if($i > 0 and $i <= $Sayfa_Sayisi){
                                if($i == $Sayfa){
                                    ?>

                                    <li class="page-item active" aria-current="page">
                                        <a class="page-link" href="hesabim/iptal-talepleri/?page=<?=$i?>"><?=$i?><span class="sr-only">(current)</span></a>
                                    </li>

                                    <?php
                                }else{
                                    ?>
                                    <li class="page-item"><a class="page-link" href="hesabim/iptal-talepleri/?page=<?=$i?>"><?=$i?></a></li>
                                    <?php
                                }
                            }
                            }
                            ?>

                            <?php if($islemListele->rowCount() <=0) { } else { ?>
                                <?php if($Sayfa != $Sayfa_Sayisi){?>

                                    <li class="page-item"><a class="page-link" href="hesabim/iptal-talepleri/?page=<?=$Sayfa + 1?>"><?=$diller['sayfalama-sonraki']?></a></li>
                                    <li class="page-item"><a class="page-link" href="hesabim/iptal-talepleri/?page=<?=$Sayfa_Sayisi?>"><?=$diller['sayfalama-son']?></a></li>


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
    <?php
}else{
    header('Location:'.$ayar['site_url'].'404');
}
?>