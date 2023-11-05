<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php if($uyeayar['favori_alani'] == '1'  ) {?>
<?php
$userpage = 'favori';
$favoriSorgusu = $db->prepare("select * from urun_favori where uye_id=:uye_id ");
$favoriSorgusu->execute(array(
    'uye_id' => $userCek['id']
));
$Sayfa = @intval($_GET['page']); if(!$Sayfa) $Sayfa = 1;
$Say = $db->query("select * from urun_favori where uye_id='$userCek[id]' ");
$ToplamVeri = $Say->rowCount();
$Limit = 16;
$Sayfa_Sayisi = ceil($ToplamVeri/$Limit); if($Sayfa > $Sayfa_Sayisi){$Sayfa = 1;}
$Goster = $Sayfa * $Limit - $Limit;
$GorunenSayfa = 5;
$islemListele = $db->query("select * from urun_favori where uye_id='$userCek[id]'order by id DESC limit $Goster,$Limit");
$islemCek = $islemListele->fetchAll(PDO::FETCH_ASSOC);


?>
<title><?php echo $diller['users-favoriler-seo-title']; ?> - <?php echo $ayar['site_baslik']?></title>
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
            <a href="hesabim/favoriler/"><?=$diller['users-panel-baglanti-text4']?></a>
        </div>
        <!--  <========SON=========>>> Header SON !-->


        <?php include 'includes/template/helper/users/leftbar.php'; ?>


        <!-- Right Content !-->
        <div class="user_subpage_favorites_content">

            <?php if($userSorgusu->rowCount()<='0'  ) {?>
                <div class="user_subpage_favorites_nologin">
                    <i class="ion-heart-broken"></i>
                    <div class="user_subpage_favorites_nologin_head">
                        <?=$diller['users-panel-text11']?> (0)
                    </div>
                    <div class="user_subpage_favorites_nologin_s">
                        <?=$diller['users-panel-text12']?>
                    </div>
                    <div class="user_subpage_favorites_nologin_buttons">
                        <a href="uye-girisi/" class="button-black-out button-2x" ><?=$diller['uyegiris-modal-text7']?></a>
                        <?php if($uyeayar['yeni_uyelik'] == '1' ) {?>
                            <a href="uyelik/" class="button-pink button-2x" ><?=$diller['uyegiris-modal-text10']?></a>
                        <?php }?>
                    </div>
                </div>
            <?php }else { ?>
                <?php if($favoriSorgusu->rowCount()>'0'  ) {?>
                    <!-- Head !-->
                    <div class="user_subpage_account_header">
                        <?=$diller['users-panel-text11']?> (<?=$favoriSorgusu->rowCount()?>)
                        <div class="user_subpage_account_spot">
                            <?=$diller['users-panel-text13']?>
                        </div>
                    </div>
                    <!--  <========SON=========>>> Head SON !-->
                    <div class="user_subpage_favorites_box_div">
                        <?php foreach ($islemCek as $favoriRow) {
                            $urunSorgusu = $db->prepare("select * from urun where id=:id and dil=:dil ");
                            $urunSorgusu->execute(array(
                                    'id' => $favoriRow['urun_id'],
                                    'dil' => $_SESSION['dil']
                            ));
                            $urunRow = $urunSorgusu->fetch(PDO::FETCH_ASSOC);
                            ?>
                            <?php if($urunSorgusu->rowCount()>'0'  ) {?>
                                <div class="user_subpage_favorites_box">
                                    <div class="user_subpage_favorites_box_icon">
                                    <i class="fa fa-heart"></i>
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
                                    </div>
                                    <div class="user_subpage_favorites_box_go">
                                        <a  <?php if($demo != '1'  ) { ?>href="#" class="product-fav-del" data-code="<?php echo $urunRow['id']; ?>"<?php }else{?>href="javascript:Void(0)" <?php } ?>  style="color: #F06670;" >
                                           <i class="las la-trash"></i> <?=$diller['users-panel-text17']?>
                                        </a>
                                    </div>
                                </div>
                            <?php }?>
                        <?php }?>
                    </div>
<!---- Sayfalama Elementleri ================== !-->
    <?php if($ToplamVeri > $Limit  ) {?>
        <div id="SayfalamaElementi" style="width: 100%;  ">
            <?php if($Sayfa >= 1){?>
            <nav aria-label="Page navigation example" style="margin-top: 20px;">
                <ul class="pagination  pagination-sm">
                    <?php } ?>

                    <?php if($Sayfa > 1){?>

                        <li class="page-item"><a class="page-link" href="hesabim/favoriler/1/"><?=$diller['sayfalama-ilk']?></a></li>
                        <li class="page-item"><a class="page-link" href="hesabim/favoriler/<?=$Sayfa - 1?>/"><?=$diller['sayfalama-onceki']?></a></li>

                    <?php } ?>
                    <?php
                    for($i = $Sayfa - $GorunenSayfa; $i < $Sayfa + $GorunenSayfa +1; $i++){ if($i > 0 and $i <= $Sayfa_Sayisi){
                        if($i == $Sayfa){
                            echo '    
    
                            <li class="page-item active" aria-current="page">
                              <a class="page-link" href="hesabim/favoriler/'.$i.'/">'.$i.'<span class="sr-only">(current)</span></a>
                            </li>
                            
                            ';
                        }else{
                            echo '
                    <li class="page-item"><a class="page-link" href="hesabim/favoriler/'.$i.'/">'.$i.'</a></li>
                    ';
                        }
                    }
                    }
                    ?>

                    <?php if($islemListele->rowCount() <=0) { } else { ?>
                        <?php if($Sayfa != $Sayfa_Sayisi){?>

                            <li class="page-item"><a class="page-link" href="hesabim/favoriler/<?=$Sayfa + 1?>/"><?=$diller['sayfalama-sonraki']?></a></li>
                            <li class="page-item"><a class="page-link" href="hesabim/favoriler/<?=$Sayfa_Sayisi?>/"><?=$diller['sayfalama-son']?></a></li>


                        <?php }} ?>

                    <?php if($Sayfa >= 1){?>
                </ul>
            </nav>
        <?php } ?>
        </div>
    <?php }?>
    <!---- Sayfalama Elementleri ================== !-->
                <?php }else { ?>
                    <div class="user_subpage_favorites_noitems">
                        <i class="ion-heart-broken"></i>
                        <div class="user_subpage_favorites_noitems_head">
                            <?=$diller['users-panel-text14']?>
                        </div>
                        <div class="user_subpage_favorites_noitems_s">
                            <?=$diller['users-panel-text15']?>
                        </div>
                    </div>
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
<?php }else { ?>
    <?php
    header('Location:'.$ayar['site_url'].'404');
    ?>
<?php }?>
