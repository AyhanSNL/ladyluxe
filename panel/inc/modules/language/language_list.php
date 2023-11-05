<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'lang';


if($_POST) {
if ($yetki['demo'] != '1') {
    $position = $_POST['position'];
    $count = 1;
    foreach ($position as $idler) {
        $idler2 = htmlspecialchars(trim($idler));
        try {

            $query = $db->query("UPDATE dil SET sira = '$count' WHERE id = '$idler2'");
        } catch (PDOException $ex) {
            echo "Hata İşlem Yapılamadı!";
            some_logging_function($ex->getMessage());
        }
        $count++;
    }
}}

if(isset($_GET['status']) && $_GET['status']=='current' && isset($_GET['no']) ) {
if ($yetki['demo'] != '1') {
    if ($_GET['no'] == !null) {
        $dilleriGoster = $db->prepare("select * from dil where id=:id and durum=:durum ");
        $dilleriGoster->execute(array(
            'id' => $_GET['no'],
            'durum' => '1',
        ));
        if ($dilleriGoster->rowCount() > '0') {

            $guncelle = $db->prepare("UPDATE dil SET
                   varsayilan=:varsayilan 
            ");
            $sonuc = $guncelle->execute(array(
                'varsayilan' => '0'
            ));
            if ($sonuc) {
                /* Seçiliyi varsayılan yap */
                $guncelle = $db->prepare("UPDATE dil SET
                          varsayilan=:varsayilan   
                     WHERE id={$_GET['no']}      
                    ");
                $sonuc = $guncelle->execute(array(
                    'varsayilan' => '1'
                ));
                if ($sonuc) {
                    header('Location:' . $ayar['panel_url'] . 'pages.php?page=languages');
                    unset($_SESSION['dil']);
                } else {
                    echo 'Veritabanı Hatası';
                }
                /*  <========SON=========>>> Seçiliyi varsayılan yap SON */
            } else {
                echo 'Veritabanı Hatası';
            }


        } else {
            header('Location:' . $ayar['panel_url'] . 'pages.php?page=languages');
        }
    } else {
        header('Location:' . $ayar['panel_url'] . 'pages.php?page=languages');
    }
}else{
    header('Location:' . $ayar['panel_url'] . 'pages.php?page=languages');

}
}
?>
<title><?=$diller['adminpanel-menu-text-162']?> - <?=$panelayar['baslik']?></title>

<div class="wrapper" style="margin-top: 0;">
    <div class="container-fluid">

        <!-- Page-Title -->
        <div class="row mb-3">
            <div class="col-md-12 ">
                <div class="page-title-box bg-white card mb-0 pl-3" >
                    <div class="row align-items-center" >
                        <div class="col-md-8" >
                            <div class="page-title-nav">
                                <a href="<?=$ayar['panel_url']?>"><i class="ion ion-md-home"></i> <?=$diller['adminpanel-text-341']?></a>
                                <a href="javascript:Void(0)"><i class="fa fa-angle-right"></i> <?=$diller['adminpanel-menu-text-151']?></a>
                                <a href="pages.php?page=languages"><i class="fa fa-angle-right"></i> <?=$diller['adminpanel-menu-text-162']?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->



        <?php if($yetki['site_ayarlar'] == '1' &&  $yetki['dil_yonet'] == '1') {



            $Sayfa = @intval($_GET['p']); if(!$Sayfa) $Sayfa = 1;
            $Say = $db->query("select * from dil ");
            $ToplamVeri = $Say->rowCount();
            $Limit = 10;
            $Sayfa_Sayisi = ceil($ToplamVeri/$Limit); if($Sayfa > $Sayfa_Sayisi){$Sayfa = 1;}
            $Goster = $Sayfa * $Limit - $Limit;
            $GorunenSayfa = 5;
            $islemListele = $db->query("select * from dil  order by sira ASC limit $Goster,$Limit");
            $islemCek = $islemListele->fetchAll(PDO::FETCH_ASSOC);




            ?>


            <div class="row">

                <?php include 'inc/modules/_helper/settings_leftbar.php'; ?>

                <!-- Contents !-->
                <div class="<?php if($panelayar['panel_nav'] == '1'   ) { ?>col-md-9<?php }else{?>col-md-12<?php } ?>">
                    <div class="card p-3">
                        <div class="new-buttonu-main-top ">
                            <div class="new-buttonu-main-left">
                                <h4> <?=$diller['adminpanel-menu-text-162']?></h4>
                            </div>
                            <div class="new-buttonu-main">
                                <?php if($yetki['demo'] != '1'  ) {?>
                                <a href="" data-toggle="collapse" data-target="#bilgi" aria-expanded="false" aria-controls="collapseForm" class="btn btn-purple "><?=$diller['adminpanel-text-254']?></a>
                                <?php }?>
                                <a href="" data-toggle="collapse" data-target="#genelAcc" aria-expanded="false" aria-controls="collapseForm" class="btn btn-success "><i class="fas fa-plus-circle "></i> <?=$diller['adminpanel-text-253']?></a>
                            </div>
                        </div>
                        <div id="accordion" class="accordion">
                            <div class="collapse " id="genelAcc" data-parent="#accordion">
                                <div class="w-100 border pl-3 pr-3 mb-3">
                                    <form action="post.php?process=lang_post&status=lang_add" method="post">
                                        <div class="row ">
                                            <div class="form-group col-md-12 text-center bg-white text-dark border-bottom mb-0 ">
                                                <h5> <?=$diller['adminpanel-text-253']?></h5>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="form-group col-md-6 mb-4">
                                                <label  for="durum" class="w-100"><?=$diller['adminpanel-form-text-62']?></label>
                                                <div class="custom-control custom-switch custom-switch-lg">
                                                    <input type="hidden" name="durum" value="0"">
                                                    <input type="checkbox" class="custom-control-input" id="durum" name="durum" value="1" checked>
                                                    <label class="custom-control-label" for="durum"></label>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-6 mb-4">
                                                <label  for="varsayilan" class="w-100"><?=$diller['adminpanel-form-text-69']?></label>
                                                <div class="custom-control custom-switch custom-switch-lg">
                                                    <input type="hidden" name="varsayilan" value="0"">
                                                    <input type="checkbox" class="custom-control-input" id="varsayilan" name="varsayilan" value="1">
                                                    <label class="custom-control-label" for="varsayilan"></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-12">
                                                <label for="baslik">* <?=$diller['adminpanel-form-text-64']?></label>
                                                <input type="text" name="baslik" id="baslik"  autocomplete="off"  required class="form-control">
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="area">* <?=$diller['adminpanel-form-text-66']?></label>
                                                <select name="area" class="form-control" id="area" required>
                                                    <option value="ltr"><?=$diller['adminpanel-text-255']?></option>
                                                    <option value="rtl"><?=$diller['adminpanel-text-256']?></option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="sira">* <?=$diller['adminpanel-form-text-55']?></label>
                                                <input type="number" name="sira" id="sira" required class="form-control">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-12">
                                                <label for="countries">* <?=$diller['adminpanel-form-text-71']?></label>
                                                <select class="form-control" id="countries" style="width: 100% !important; " required name="dil_kodu">
                                                    <option value="">-- <?=$diller['adminpanel-form-text-72']?></option>
                                                    <?php include 'inc/modules/_helper/flagselector.php';?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row border-top pt-3 bg-light pb-3 mt-3">
                                            <div class="col-md-12 text-right">
                                                <button class="btn  btn-success " name="langAdd"><?=$diller['adminpanel-form-text-53']?></button>
                                                <a class="btn  btn-secondary text-white" data-toggle="collapse" data-target="#genelAcc" aria-expanded="false" aria-controls="collapseForm"><?=$diller['adminpanel-modal-text-17']?></a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="collapse  " id="bilgi" data-parent="#accordion">
                                <div class="w-100 border pl-3 pr-3 mb-3">
                                        <div class="row ">
                                            <div class="form-group col-md-12 text-center bg-white text-dark border-bottom mb-0 ">
                                                <h5> <?=$diller['adminpanel-text-254']?></h5>
                                            </div>
                                        </div>
                                    <div class="w-100 font-16">
                                        <div class="w-100 mb-3 mt-3 border rounded border-warning alert-warning p-3 text-dark">
                                            Dil çevirileri güvenlik sebebi ile ftp veya sunucunuzun
                                            panellerindeki dosya yönetimi alanlarından yapılmaktadır
                                        </div>
                                        <div class="w-100 mb-3 p-3 border rounded bg-light">
                                            <strong>1- Mağaza Arayüzü Çevirileri</strong>
                                            <br><br>
                                            <span style="font-size: 14px ;">
                                                Anasayfanızdaki kelimelerin çevirileri için sunucunuzdaki dosyalardan
                                            <strong>includes/lang/tr.php</strong> (eklediğiniz dilin kodu ne ise o şekilde isimlendirilir)
                                            dosyasına ulaşın ve bir editör yardımı ile dosyayı düzenleme sayfasına erişin.

                                            ardından gördüğünüz kodlar içerisinde çift tırnak içindeki kelimeleri
                                            çevirebilirsiniz.
                                            </span>
                                        </div>
                                        <div class="w-100 mb-3 p-3 border rounded" style="font-size: 14px ;">
                                            <strong>Örnek kod </strong><span style="font-style: italic"><u>tr.php dosyasındaki 1.satırda yer alan koddur.</u></span>
                                            <br><br>
                                            <strong class="text-pink">$diller['sekme-hatirlatici-title'] = "<span class="text-info">Alışverişe Devam Et</span>";</strong>
                                            <br>
                                            Üstteki örnek kod içerisinde “Alışverişe Devam Et” alanını düzenleyebilirsiniz.
                                            <br><br>
                                            <strong>ÖNEMLİ : </strong>Ayrıca bu dosya php dosyası oldugu için çift tırnak içinde tekrar çift tırnak
                                            kullanamazsınız.
                                            <br><br>
                                            <strong>Yanlış Tırnak Kullanım :</strong>
                                            <br>
                                            <span class="text-danger">$diller['sekme-hatirlatici-title'] = "<strong>Alışverişe <del>"Devam"</del> Et</strong>";</span>
                                            <br>
                                            bu yukarıdaki kod yanlıştır ve sitenizi bozacaktır. Onun yerine tek tırnak
                                            kullanabilirsiniz
                                            <br><br>
                                            <strong>Doğru Tırnak Kullanımı  :</strong>
                                            <br>
                                            <span class="text-success">$diller['sekme-hatirlatici-title'] = "<strong>Alışverişe 'Devam' Et</strong>";</span>
                                        </div>
                                        <div class="w-100 mb-2 p-3 border rounded bg-light">
                                            <strong>2- Yönetim Paneli Arayüzü Çevirileri</strong>
                                            <br><br>
                                            <span style="font-size: 14px ;">
                        Yönetim paneli arayüzündeki kelimelerin çevirileri için sunucunuzdaki dosyalardan
                        <strong>includes/lang/tr-panel.php</strong> (eklediğiniz dilin kodu ne ise o şekilde isimlendirilir
                        ve sonuna -panel yazısı eklenir.) dosyasına ulaşın ve bir editör yardımı ile
                        dosyayı düzenleme sayfasına erişin.
                        <br><br>
                        <strong>Mağaza arayüzü çevirisindeki kullanım detayları ile ilgili bilgileri panel çevirileri içinde kullanabilirsiniz.</strong>
                        </span>
                                        </div>
                                    </div>
                                        <div class="row border-top pt-3 bg-light pb-3 mt-3">
                                            <div class="col-md-12 text-right">
                                                <a class="btn  btn-secondary text-white" data-toggle="collapse" data-target="#bilgi" aria-expanded="false" aria-controls="collapseForm"><?=$diller['adminpanel-modal-text-17']?></a>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                        <div class="w-100">
                            <div class="w-100 p-2 bg-light mb-2 font-12">
                                <i class="fa fa-info-circle mr-1"></i> <?=$diller['adminpanel-text-171']?>
                            </div>
                                <div class="table-responsive ">
                                    <table class="table table-hover mb-0  ">
                                        <thead class="thead-default">
                                        <tr>
                                            <th><?=$diller['adminpanel-text-170']?></th>
                                            <th class="text-center"><?=$diller['adminpanel-form-text-63']?></th>
                                            <th><?=$diller['adminpanel-form-text-64']?></th>
                                            <th><?=$diller['adminpanel-form-text-66']?></th>
                                            <th><?=$diller['adminpanel-form-text-65']?></th>
                                            <th><?=$diller['adminpanel-form-text-62']?></th>
                                            <th></th>
                                            <th  class="text-center" width="130"><?=$diller['adminpanel-text-157']?></th>
                                        </tr>
                                        </thead>
                                        <tbody  class="row_position">
                                        <?php foreach ($islemCek as $row) {?>
                                            <tr id="<?php echo $row['id'] ?>" style="cursor: move">
                                                <td width="40">
                                                    <div class="btn btn-outline-pink btn-sm">
                                                        <?=$row['sira']?>
                                                    </div>
                                                </td>
                                                <td class="text-center" style="font-weight: 500;min-width: 100px">
                                                    <?=$row['kisa_ad']?>
                                                </td>
                                                <td style="font-weight: 500; min-width: 100px">
                                                    <?=$row['baslik']?>
                                                </td>
                                                <td style="min-width:120px ">
                                                    <?php if($row['area'] == 'ltr' ) {?>
                                                       <?=$diller['adminpanel-text-255']?>
                                                    <?php }?>
                                                    <?php if($row['area'] == 'rtl' ) {?>
                                                       <?=$diller['adminpanel-text-256']?>
                                                    <?php }?>
                                                </td>
                                                <td>
                                                    <div class="flag-icon-<?=$row['flag']?>" style="width:18px; height:13px; "></div>
                                                </td>
                                                <td>
                                                    <?php if($row['durum'] == '0' ) {?>
                                                        <div class="btn btn-sm btn-outline-danger ">
                                                            <div class="d-flex align-items-center">
                                                              <i class="fa fa-times mr-2"></i>
                                                                <?=$diller['adminpanel-form-text-68']?>
                                                            </div>
                                                        </div>
                                                    <?php }?>
                                                    <?php if($row['durum'] == '1' ) {?>
                                                        <div class="btn btn-sm btn-success ">
                                                            <div class="d-flex align-items-center">
                                                                <div class="spinner-grow text-white mr-2" role="status" style="width: 10px; height: 10px">
                                                                    <span class="sr-only">Loading...</span>
                                                                </div>
                                                                <?=$diller['adminpanel-form-text-67']?>
                                                            </div>
                                                        </div>
                                                    <?php }?>
                                                </td>
                                                <td width="130" style="min-width: 130px">
                                                    <?php if($row['durum'] == '1' ) {?>
                                                        <?php if($row['varsayilan'] == '1' ) {?>
                                                            <div class="badge badge-pink p-2 ml-2 " style="font-weight: 400 !important; font-size: 11px ;">
                                                                <div class="d-flex align-items-center">
                                                                    <i class="fa fa-check mr-2"></i>
                                                                    <?=$diller['adminpanel-form-text-69']?>
                                                                </div>
                                                            </div>
                                                        <?php }?>
                                                        <?php if($row['varsayilan'] == '0' ) {?>
                                                            <a href="pages.php?page=languages&status=current&no=<?=$row['id']?>" class="btn btn-outline-pink ml-2 " style="font-weight: 400 !important; font-size: 11px ;">
                                                                <div class="d-flex align-items-center">
                                                                    <?=$diller['adminpanel-form-text-70']?>
                                                                </div>
                                                            </a>
                                                        <?php }?>
                                                    <?php }?>
                                                </td>
                                                <td class="text-right" style="min-width: 100px">
                                                    <a href="javascript:Void(0)" data-id="<?=$row['id']?>" class="btn btn-sm btn-primary duzenleAjax" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-text-159']?>"><i class="fa fa-eye" ></i></a>
                                                    <?php if($ToplamVeri > '1') {?>
                                                        <a href="" data-href="post.php?process=lang_post&status=lang_delete&no=<?=$row['id']?>"  data-toggle="modal" data-target="#confirm-delete"  class="btn btn-sm btn-danger "><i class="fa fa-trash" ></i></a>
                                                    <?php }?>
                                                </td>
                                            </tr>
                                        <?php }?>
                                        </tbody>
                                    </table>
                                </div>
                            <!-- Kaydırılabilir Alert !-->
                            <div class="d-md-none d-sm-block p-2 bg-light  text-center">
                                <?=$diller['adminpanel-text-340']?> <i class="fas fa-hand-pointer"></i>
                            </div>
                            <!--  <========SON=========>>> Kaydırılabilir Alert SON !-->
                                    <div class="border-top"> </div>

                                <?php if($ToplamVeri<='0' && !isset($_GET['search']) ) {?>
                                    <div class="w-100  p-3 ">
                                        <i class="fa fa-ban"></i> <?=$diller['adminpanel-text-162']?>
                                    </div>
                                <?php }?>





                            <!---- Sayfalama Elementleri ================== !-->
                            <?php if($ToplamVeri > $Limit  ) {?>
                                <div id="SayfalamaElementi" class="w-100 p-2  border-bottom bg-light  ">
                                    <?php if($Sayfa >= 1){?>
                                    <nav aria-label="Page navigation example " >
                                        <ul class="pagination pagination-sm justify-content-end mb-0 ">
                                            <?php } ?>
                                            <?php if($Sayfa > 1){  ?>
                                                <li class="page-item "><a class="page-link " href="pages.php?page=languages"><?=$diller['sayfalama-ilk']?></a></li>
                                                <li class="page-item "><a class="page-link " href="pages.php?page=languages&p=<?=$Sayfa - 1?>"><?=$diller['sayfalama-onceki']?></a></li>
                                            <?php } ?>
                                            <?php
                                            for($i = $Sayfa - $GorunenSayfa; $i < $Sayfa + $GorunenSayfa +1; $i++){ if($i > 0 and $i <= $Sayfa_Sayisi){
                                                if($i == $Sayfa){
                                                    ?>
                                                    <li class="page-item active " aria-current="page">
                                                        <a class="page-link" href="pages.php?page=languages&p=<?=$i?>"><?=$i?><span class="sr-only">(current)</span></a>
                                                    </li>
                                                    <?php
                                                }else{
                                                    ?>
                                                    <li class="page-item "><a class="page-link" href="pages.php?page=languages&p=<?=$i?>"><?=$i?></a></li>
                                                    <?php
                                                }
                                            }
                                            }
                                            ?>

                                            <?php if($islemListele->rowCount() <=0) { } else { ?>
                                                <?php if($Sayfa != $Sayfa_Sayisi){?>
                                                    <li class="page-item"><a class="page-link" href="pages.php?page=languages&p=<?=$Sayfa + 1?>"><?=$diller['sayfalama-sonraki']?></a></li>
                                                    <li class="page-item"><a class="page-link" href="pages.php?page=languages&p=<?=$Sayfa_Sayisi?>"><?=$diller['sayfalama-son']?></a></li>
                                                <?php }} ?>
                                            <?php if($Sayfa >= 1){?>
                                        </ul>
                                    </nav>
                                <?php } ?>
                                </div>
                            <?php }?>
                            <!---- Sayfalama Elementleri ================== !-->

                        </div>
                    </div>
                </div>
                <!--  <========SON=========>>> Contents SON !-->





            </div>



        <?php }else { ?>
            <div class="card p-xl-5">
                <h3><?=$diller['adminpanel-text-136']?></h3>
                <h6><?=$diller['adminpanel-text-137']?></h6>
                <div  class="mt-3">
                    <a href="<?=$ayar['panel_url']?>" class="btn btn-primary"><?=$diller['adminpanel-text-138']?></a>
                </div>
            </div>
        <?php }?>
    </div>
</div>
<!-- Sıralama Kodu !-->
<script type="text/javascript">
    $( ".row_position" ).sortable({
        delay: 150,
        stop: function() {
            var selectedData = new Array();
            $('.row_position>tr').each(function() {
                selectedData.push($(this).attr("id"));
            });
            updateOrder(selectedData);
        }
    });


    function updateOrder(data) {
        $.ajax({
            url:"",
            type:'post',
            data:{position:data},
            success:function(){
                setTimeout(function(){// wait for 5 secs(2)
                    location.reload(); // then reload the page.(3)
                }, 1);
            }
        })
    }
</script>
<!-- Sıralama Kodu Son !-->

<!-- Editable Modal !-->
<script type='text/javascript'>
    $(document).ready(function(){

        $('.duzenleAjax').click(function(){

            var postID = $(this).data('id');

            // AJAX request
            $.ajax({
                url: 'masterpiece.php?page=lang_edit',
                type: 'post',
                data: {postID: postID},
                success: function(response){
                    $('.modal-editable').html(response);
                    $('#duzenle').modal('show');
                }
            });
        });
    });
</script>
<!--  <========SON=========>>> Editable Modal SON !-->
<script>
    $(function () {
        $('#bilgi').on('shown.bs.collapse', function (e) {
            $('html,body').animate({
                    scrollTop: $('#bilgi').offset().top - 80 },
                500);
        });
        $('#genelAcc').on('shown.bs.collapse', function (e) {
            $('html,body').animate({
                    scrollTop: $('#genelAcc').offset().top - 80 },
                500);
        });
    });
</script>