<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
if($userSorgusu->rowCount()>'0' && $uyeayar['yorumlar_alani'] == '1') {

    if(isset($_GET['status'])   ) {
     if($_GET['status'] == '0' ||  $_GET['status'] == '1' || $_GET['status'] == '2' ) {

         if($_GET['status'] == '0'  ) {
          $statusCek = "and onay='0'";
         }
         if($_GET['status'] == '1'  ) {
             $statusCek = "and onay='1'";
         }
         if($_GET['status'] == '2'  ) {
             $statusCek = "and onay='2'";
         }

     }else{
         header('Location:'.$ayar['site_url'].'hesabim/yorumlar/');
     }
    }

$userpage = 'yorum';
$Sayfa = @intval($_GET['page']); if(!$Sayfa) $Sayfa = 1;
$Say = $db->query("select * from urun_yorum where uye_id='$userCek[id]' $statusCek ");
$ToplamVeri = $Say->rowCount();
$Limit = 12;
$Sayfa_Sayisi = ceil($ToplamVeri/$Limit); if($Sayfa > $Sayfa_Sayisi){$Sayfa = 1;}
$Goster = $Sayfa * $Limit - $Limit;
$GorunenSayfa = 5;
$islemListele = $db->query("select * from urun_yorum where uye_id='$userCek[id]' $statusCek order by id DESC limit $Goster,$Limit");
$islemCek = $islemListele->fetchAll(PDO::FETCH_ASSOC);

/* Delete Comment */
    if($_GET['deleteItem']=='okay' & isset($_GET['deleteOrder'])  ) {
        if($demo != '1'  ){
            $silmeislem = $db->prepare("DELETE from urun_yorum WHERE rand_id=:rand_id");
            $silmeislem->execute(array(
                'rand_id' => trim(strip_tags($_GET['deleteOrder']))
            ));
            if ($silmeislem) {
                header('Location:'.$ayar['site_url'].'hesabim/yorumlar/');
            }else {
                echo 'veritabanı hatası';
            }
        }else{
            $_SESSION['demo_alert'] = 'demo';
            header('Location:'.$ayar['site_url'].'hesabim/yorumlar/');
        }
    }
/*  <========SON=========>>> Delete Comment SON */
?>
<title><?php echo $diller['users-yorumlar-seo-title']; ?> - <?php echo $ayar['site_baslik']?></title>
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
            <a href="hesabim/yorumlar/"><?=$diller['users-panel-baglanti-text5']?></a>
        </div>
        <!--  <========SON=========>>> Header SON !-->


        <?php include 'includes/template/helper/users/leftbar.php'; ?>

        <!-- Right Content !-->
        <div class="user_subpage_favorites_content">

            <!-- Head !-->
            <div class="user_subpage_flex_header">
                <div class="user_subpage_flex_header_h">
                    <?=$diller['users-panel-text24']?> (<?=$ToplamVeri?>)
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
                    <select name="s" id="dynamic_select" class="select user_subpage_select"  required>
                        <option value="hesabim/yorumlar/" ><?=$diller['users-panel-text28']?></option>
                        <option value="hesabim/yorumlar/?status=1" <?php if(isset($_GET['status']) && $_GET['status'] == '1') { ?>selected<?php }?>><?=$diller['users-panel-text29']?></option>
                        <option value="hesabim/yorumlar/?status=0" <?php if(isset($_GET['status']) && $_GET['status'] == '0') { ?>selected<?php }?>><?=$diller['users-panel-text30']?></option>
                        <option value="hesabim/yorumlar/?status=2" <?php if(isset($_GET['status']) && $_GET['status'] == '2') { ?>selected<?php }?>><?=$diller['users-panel-text31']?></option>
                    </select>
                </div>
            </div>
            <!--  <========SON=========>>> Head SON !-->

            <?php if($ToplamVeri > '0'   ) {?>



                <div class="user_subpage_favorites_box_div_out">
                    <div class="user_subpage_favorites_box_div">
                        <?php foreach ($islemCek as $islemRow) {
                            $urunSorgusu = $db->prepare("select * from urun where id=:id and dil=:dil and durum=:durum ");
                            $urunSorgusu->execute(array(
                                'id' => $islemRow['urun_id'],
                                'dil' => $_SESSION['dil'],
                                'durum' => '1'
                            ));
                            $urunRow = $urunSorgusu->fetch(PDO::FETCH_ASSOC);
                            ?>
                            <?php if($urunSorgusu->rowCount()>'0'  ) {?>
                                <div class="user_subpage_comment_box">
                                    <div class="user_subpage_comment_box_status_main">
                                        <?php if($islemRow['onay'] == '0' ) {?>
                                            <div class="user_subpage_comment_box_status" style="border: 1px solid #9D9D9D; color: #9D9D9D;" >
                                                <i class="fa fa-refresh fa-spin fa-fw"></i><span class="sr-only">Loading...</span> <?=$diller['users-panel-text19']?>
                                            </div>
                                        <?php }?>
                                        <?php if($islemRow['onay'] == '1' ) {?>
                                            <div class="user_subpage_comment_box_status" style="border: 1px solid #66B483; color: #66B483;">
                                                <i class="fa fa-check"></i> <?=$diller['users-panel-text18']?>
                                            </div>
                                        <?php }?>
                                        <?php if($islemRow['onay'] == '2' ) {?>
                                            <div class="user_subpage_comment_box_status" style="border: 1px solid #F06670; color: #F06670;">
                                                <i class="fa fa-times"></i> <?=$diller['users-panel-text20']?>
                                            </div>
                                        <?php }?>
                                    </div>
                                    <div class="user_subpage_comment_box_product">
                                        <div class="user_subpage_comment_box_img">
                                            <a href="<?=$urunRow['seo_url']?>-P<?=$urunRow['id']?>"  target="_blank">
                                                <img src="images/product/<?=$urunRow['gorsel']?>" alt="<?=$urunRow['baslik']?>">
                                            </a>
                                        </div>
                                        <div class="user_subpage_comment_box_point">
                                            <div class="user_subpage_comment_box_product_name">
                                                <a href="<?=$urunRow['seo_url']?>-P<?=$urunRow['id']?>"  target="_blank" style="color: #333;">
                                                    <?=$urunRow['baslik']?>
                                                </a>
                                            </div>
                                            <div class="user_subpage_comment_box_point_count">
                                                <div style="margin-right: 10px;">
                                                    <?=$diller['users-panel-text21']?> :
                                                </div>
                                                <?php if($islemRow['yildiz'] == 0){ ?>
                                                    <span style="color:#CCC">★</span><span style="color:#CCC">★</span><span style="color:#CCC">★</span><span style="color:#CCC">★</span><span style="color:#CCC">★</span>
                                                <?php }?>
                                                <?php if($islemRow['yildiz'] == 1){ ?>
                                                    <span style="color:#ffb400">★</span><span style="color:#CCC">★</span><span style="color:#CCC">★</span><span style="color:#CCC">★</span><span style="color:#CCC">★</span>
                                                <?php }?>
                                                <?php if($islemRow['yildiz'] == 2){ ?>
                                                    <span style="color:#ffb400">★</span><span style="color:#ffb400">★</span><span style="color:#CCC">★</span><span style="color:#CCC">★</span><span style="color:#CCC">★</span>
                                                <?php }?>
                                                <?php if($islemRow['yildiz'] == 3){ ?>
                                                    <span style="color:#ffb400">★</span><span style="color:#ffb400">★</span><span style="color:#ffb400">★</span><span style="color:#CCC">★</span><span style="color:#CCC">★</span>
                                                <?php }?>
                                                <?php if($islemRow['yildiz'] == 4){ ?>
                                                    <span style="color:#ffb400">★</span><span style="color:#ffb400">★</span><span style="color:#ffb400">★</span><span style="color:#ffb400">★</span><span style="color:#CCC">★</span>
                                                <?php }?>
                                                <?php if($islemRow['yildiz'] == 5){ ?>
                                                    <span style="color:#ffb400">★</span><span style="color:#ffb400">★</span><span style="color:#ffb400">★</span><span style="color:#ffb400">★</span><span style="color:#ffb400">★</span>
                                                <?php }?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="user_subpage_comment_box_text"><?=$diller['users-panel-text22']?></div>
                                    <div class="user_subpage_comment_box_content">
                                        <?=$islemRow['yorum']?>
                                    </div>
                                    <div class="user_subpage_comment_box_delete">
                                        <a data-href="hesabim/yorumlar/?deleteItem=okay&deleteOrder=<?=$islemRow['rand_id']?>" href="" data-toggle="modal" data-target="#confirm-delete">
                                            <?=$diller['users-panel-text23']?>
                                        </a>
                                    </div>
                                </div>
                            <?php }?>
                        <?php }?>
                    </div>
                </div>
            <?php }?>

            <?php if($ToplamVeri <='0'  ) {?>
                <?php if(isset($_GET['status'])  ) {?>
                    <div class="user_subpage_favorites_noitems" >
                        <div class="user_subpage_favorites_noitems_head">
                            <?=$diller['users-panel-text32']?>
                        </div>
                        <div class="user_subpage_favorites_noitems_s">
                            <?=$diller['users-panel-text33']?>
                            <br><br>
                            <a href="hesabim/yorumlar/" class="button-black-out button-2x">
                               <?=$diller['users-panel-text34']?>
                            </a>
                        </div>
                    </div>
                <?php }else { ?>
                    <div class="user_subpage_favorites_noitems" >
                        <i class="ion-chatbubble-working" style="color: #CCC;"></i>
                        <div class="user_subpage_favorites_noitems_head">
                            <?=$diller['users-panel-text26']?>
                        </div>
                        <div class="user_subpage_favorites_noitems_s">
                            <?=$diller['users-panel-text27']?>
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

                                <li class="page-item"><a class="page-link" href="hesabim/yorumlar/<?php if(isset($_GET['status'])) { ?>?status=<?=$_GET['status']?><?php }else{?><?php } ?>"><?=$diller['sayfalama-ilk']?></a></li>
                                <li class="page-item"><a class="page-link" href="hesabim/yorumlar/<?php if(isset($_GET['status'])) { ?>?status=<?=$_GET['status']?>&page=<?=$Sayfa - 1?><?php }else{?>?page=<?=$Sayfa - 1?><?php } ?>"><?=$diller['sayfalama-onceki']?></a></li>

                            <?php } ?>
                            <?php
                            for($i = $Sayfa - $GorunenSayfa; $i < $Sayfa + $GorunenSayfa +1; $i++){ if($i > 0 and $i <= $Sayfa_Sayisi){
                                if($i == $Sayfa){
                                    ?>

                                    <li class="page-item active" aria-current="page">
                                        <a class="page-link" href="hesabim/yorumlar/<?php if(isset($_GET['status'])) { ?>?status=<?=$_GET['status']?>&page=<?=$i?><?php }else{?>?page=<?=$i?><?php } ?>"><?=$i?><span class="sr-only">(current)</span></a>
                                    </li>

                                    <?php
                                }else{
                                    ?>
                                    <li class="page-item"><a class="page-link" href="hesabim/yorumlar/<?php if(isset($_GET['status'])) { ?>?status=<?=$_GET['status']?>&page=<?=$i?><?php }else{?>?page=<?=$i?><?php } ?>"><?=$i?></a></li>
                                    <?php
                                }
                            }
                            }
                            ?>

                            <?php if($islemListele->rowCount() <=0) { } else { ?>
                                <?php if($Sayfa != $Sayfa_Sayisi){?>

                                    <li class="page-item"><a class="page-link" href="hesabim/yorumlar/<?php if(isset($_GET['status'])) { ?>?status=<?=$_GET['status']?>&page=<?=$Sayfa + 1?><?php }else{?>?page=<?=$Sayfa + 1?><?php } ?>"><?=$diller['sayfalama-sonraki']?></a></li>
                                    <li class="page-item"><a class="page-link" href="hesabim/yorumlar/<?php if(isset($_GET['status'])) { ?>?status=<?=$_GET['status']?>&page=<?=$Sayfa_Sayisi?><?php }else{?>?page=<?=$Sayfa_Sayisi?><?php } ?>"><?=$diller['sayfalama-son']?></a></li>


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
                    <?=$diller['users-panel-text36']?>
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
    <?php
}else{
    header('Location:'.$ayar['site_url'].'404');
}
?>