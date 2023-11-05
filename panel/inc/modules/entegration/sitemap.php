<?php
$currentURL = $ayar['panel_url'] . 'pages.php?' . $_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'sitemap';

$sitemapDurum = $ayar['sitemap_durum'];
error_reporting(0);

if($_POST) {
    if ($yetki['demo'] != '1') {
        $position = $_POST['position'];
        $count = 1;
        if($position >'0'  ) {
            foreach ($position as $idler) {
                $idler2 = htmlspecialchars(trim($idler));
                try {

                    $query = $db->query("UPDATE sitemap_link SET sira = '$count' WHERE id = '$idler2'");
                } catch (PDOException $ex) {
                    echo "Hata İşlem Yapılamadı!";
                    some_logging_function($ex->getMessage());
                }
                $count++;
            }
        }
    }
}


if (isset($_GET['make'])) {
    if ($yetki['demo'] != '1') {

        if ($_GET['make'] == 'sitemap') {

            if ($sitemapDurum != '1') {

                $guncelle = $db->prepare("UPDATE ayarlar SET
                    sitemap_durum=:sitemap_durum
             WHERE id='1'      
            ");
                $sonuc = $guncelle->execute(array(
                    'sitemap_durum' => '1'
                ));
                /* Dosyayı Oluştur */
                $xml_Content = "";
                $uploads_dir = '/../../../../';
                $dosyaName = 'sitemap';
                $uzanti = ".xml";
                $dosya = fopen(__DIR__ . "$uploads_dir$dosyaName$uzanti", "a");
                $yaz = fwrite($dosya, $xml_Content);
                /*  <========SON=========>>> Dosyayı Oluştur SON */

                header('Location:' . $ayar['panel_url'] . 'pages.php?page=sitemap');
            } else {
                header('Location:' . $ayar['site_url'] . '404');
            }

        } else {
            header('Location:' . $ayar['site_url'] . '404');
        }

    } else {
        header('Location:' . $ayar['panel_url'] . 'pages.php?page=sitemap');
    }
}


if (isset($_GET['process'])) {
    if ($yetki['demo'] != '1') {
        if ($_GET['process'] == 'address_add' || $_GET['process'] == 'update' || $_GET['process'] == 'download' || $_GET['process'] == 'address_edit'  || $_GET['process'] == 'address_delete') {

            if ($_GET['process'] == 'address_edit') {
                if ($_POST && $_POST['address_item'] == 'edit' && isset($_POST['edit']) && $_POST['address_id']) {
                    $guncelle = $db->prepare("UPDATE sitemap_link SET
                            adres=:adres,
                            sira=:sira
                     WHERE id={$_POST['address_id']}      
                    ");
                    $sonuc = $guncelle->execute(array(
                        'adres' => $_POST['adres_name'],
                        'sira' => $_POST['sira']
                    ));
                    if($sonuc){
                        header('Location:' . $ayar['panel_url'] . 'pages.php?page=sitemap&go=add');
                    }else{
                    echo 'Veritabanı Hatası';
                    }
                } else {
                    header('Location:' . $ayar['site_url'] . '404');
                }
            }

            if ($_GET['process'] == 'address_add') {
                if ($_POST && $_POST['address_item'] == 'add') {
                    /* linkleri ekle */
                    $link = trim(strip_tags($_POST['address_url']));
                    if($link == null  ) {
                        header('Location:' . $ayar['panel_url'] . 'pages.php?page=sitemap&go=add');
                        exit();
                    }
                    $kaydet = $db->prepare("INSERT INTO sitemap_link SET
                            adres=:adres
                    ");
                    $sonuc = $kaydet->execute(array(
                        'adres' => $link
                    ));
                    if($sonuc){
                        header('Location:' . $ayar['panel_url'] . 'pages.php?page=sitemap&go=add');
                    }else{
                        echo 'Veritabanı Hatası';
                    }
                } else {
                    header('Location:' . $ayar['site_url'] . '404');
                }
            }

            if ($_GET['process'] == 'update') {
                $timestamp = date('Y-m-d');
                unlink('../sitemap.xml');
                /* Dosyayı Oluştur */
                $mapLinks = $db->prepare("select * from sitemap_link order by sira asc ");
                $mapLinks->execute();
                include 'inc/modules/entegration/sitemap-temp.php';
                $uploads_dir = '/../../../../';
                $dosyaName = 'sitemap';
                $uzanti = ".xml";
                $dosya = fopen(__DIR__ . "$uploads_dir$dosyaName$uzanti", "a");
                $yaz = fwrite($dosya, $xml_Content);
                /*  <========SON=========>>> Dosyayı Oluştur SON */
               header('Location:' . $ayar['panel_url'] . 'pages.php?page=sitemap&alert=success');
            }

            if ($_GET['process'] == 'download') {
                $file = '../sitemap.xml';
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename=' . basename($file));
                header('Content-Transfer-Encoding: binary');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($file));
                ob_clean();
                flush();
                readfile($file);
                exit;
            }

            if ($_GET['process'] == 'address_delete') {
                $deleteIDS = $_POST['sil'];

                if($deleteIDS>'0'  ) {
                    foreach ($deleteIDS as $deleteno){
                       $silmeislem = $db->prepare("DELETE from sitemap_link WHERE id=:id");
                       $sil = $silmeislem->execute(array(
                       'id' => $deleteno
                       ));
                    }
                    header('Location:' . $ayar['panel_url'] . 'pages.php?page=sitemap&go=address');
                }else{
                    header('Location:' . $ayar['panel_url'] . 'pages.php?page=sitemap');
                }
            }

        } else {
            header('Location:' . $ayar['site_url'] . '404');
        }
    } else {
        header('Location:' . $ayar['panel_url'] . 'pages.php?page=sitemap');
    }
}

$adreslerSql = $db->prepare("select * from sitemap_link order by sira asc ");
$adreslerSql->execute();

$Sayfa = @intval($_GET['p']); if(!$Sayfa) $Sayfa = 1;
$Say = $db->query("select * from sitemap_link ");
$ToplamVeri = $Say->rowCount();
$Limit = 60;
$Sayfa_Sayisi = ceil($ToplamVeri/$Limit); if($Sayfa > $Sayfa_Sayisi){$Sayfa = 1;}
$Goster = $Sayfa * $Limit - $Limit;
$GorunenSayfa = 5;
$islemListele = $db->query("select * from sitemap_link order by sira ASC limit $Goster,$Limit");
$islemCek = $islemListele->fetchAll(PDO::FETCH_ASSOC);

?>
<title><?= $diller['adminpanel-menu-text-93'] ?> - <?= $panelayar['baslik'] ?></title>

<div class="wrapper" style="margin-top: 0;">
    <div class="container-fluid">

        <!-- Page-Title -->
        <div class="row mb-3">
            <div class="col-md-12 ">
                <div class="page-title-box bg-white card mb-0 pl-3">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <div class="page-title-nav">
                                <a href="<?= $ayar['panel_url'] ?>"><i
                                        class="ion ion-md-home"></i> <?= $diller['adminpanel-text-341'] ?></a>
                                <a href="javascript:Void(0)"><i
                                        class="fa fa-angle-right"></i> <?= $diller['adminpanel-menu-text-86'] ?></a>
                                <a href="pages.php?page=sitemap"><i
                                        class="fa fa-angle-right"></i> <?= $diller['adminpanel-menu-text-93'] ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <?php if ($yetki['entegrasyon'] == '1' && $yetki['entegrasyon_map'] == '1') { ?>
            <div class="row">
                <?php include 'inc/modules/_helper/entegration_leftbar.php'; ?>
                <?php if ($sitemapDurum == '0') { ?>
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body d-flex align-items-center justify-content-center"
                                 style="height:300px">
                                <div class="w-100 text-center">
                                    <div style="font-size: 18px ; font-weight: 500;" class="mb-3">
                                        <i class="fa fa-map-marked-alt" style="font-size: 36px ;"></i>
                                        <br><br>
                                        <?= $diller['adminpanel-form-text-1937'] ?>
                                    </div>
                                    <a class="btn btn-primary btn-lg" style="width: 220px; font-size: 18px ;"
                                       href="pages.php?page=sitemap&make=sitemap">
                                        <?= $diller['adminpanel-form-text-1936'] ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="col-md-12 mb-3">
                        <div class="card mb-0">
                            <div class="sitemap-div-main">
                                <div class="sitemap-heading">
                                    <?= $diller['adminpanel-form-text-1938'] ?>
                                </div>
                                <div class="sitemap-link-main mt-3">
                                    <div class="sitemap-link-icon">
                                        <img src="assets/images/icon/href_icon.png">
                                    </div>
                                    <div class="sitemap-link-address">
                                        <a href="<?= $ayar['site_url'] ?>sitemap.xml" target="_blank">
                                            <?= $ayar['site_url'] ?>sitemap.xml
                                        </a>
                                    </div>
                                    <a class="sitemap-link-download" href="pages.php?page=sitemap&process=download">
                                        <i class="fas fa-download"></i> <?= $diller['adminpanel-form-text-1528'] ?>
                                    </a>
                                    <a class="sitemap-link-refresh" href="pages.php?page=sitemap&process=update">
                                        <i class="fas fa-sync-alt"></i> <?= $diller['adminpanel-form-text-1939'] ?>
                                    </a>
                                </div>
                            </div>
                            <div class="bg-light p-2 mt-2 border-top border-grey rounded-bottom">
                                <ul class="ul_area">
                                    <?= $diller['adminpanel-form-text-1940'] ?>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 mb-3">
                        <div class="card mb-0">
                            <div class="card-body" id="go-add">
                                <div class="form-heading"><?= $diller['adminpanel-form-text-1941'] ?></div>
                                <form method="post" action="pages.php?page=sitemap&process=address_add">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input type="hidden" name="address_item" value="add" >
                                            <div class="form-group address_add_form mb-0">
                                                <input type="text" name="address_url" autocomplete="off"  placeholder="https://" required class="form-control">
                                                <button class="btn btn-primary">
                                                    <?=$diller['adminpanel-form-text-1942']?>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <?php if($adreslerSql->rowCount()>'0'  ) {?>
                        <div class="col-md-12 mb-3">
                            <div class="card mb-0">
                                <div class="card-body">
                                    <div class="form-heading" style="color: #000;">
                                        <?= $diller['adminpanel-form-text-1945'] ?>
                                        <div style="font-weight: 200; color: #999; font-size: 11px ;">
                                            <?=$diller['adminpanel-text-171']?>
                                        </div>
                                    </div>
                                    <form method="post" action="pages.php?page=sitemap&process=address_delete">
                                        <!-- Responsive tablo !-->
                                        <div class="table-responsive" id="go-address">
                                            <table class="table table-hover mb-0  ">
                                                <thead class="thead-default">
                                                <tr>
                                                    <th width="25">
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" data-id="chec" class="custom-control-input selectall"  id="hepsiniSecCheckBox" >
                                                            <label class="custom-control-label" for="hepsiniSecCheckBox"></label>
                                                        </div>
                                                    </th>
                                                    <th><?=$diller['adminpanel-form-text-1944']?></th>
                                                    <th  class="text-center" width="70"></th>
                                                </tr>
                                                </thead>
                                                <tbody  class="row_position">
                                                <?php foreach ($islemCek as $row) {
                                                    ?>
                                                    <tr id="<?php echo $row['id'] ?>" style="cursor: move">
                                                        <td>
                                                            <div class="custom-control custom-checkbox" >
                                                                <input type="checkbox" data-id="chec" class="custom-control-input individual"   id="checkSec-<?=$row['id']?>" name='sil[]' value="<?=$row['id']?>" >
                                                                <label class="custom-control-label" for="checkSec-<?=$row['id']?>" ></label>
                                                            </div>
                                                        </td>
                                                        <td style="font-weight: 500; min-width: 200px" >
                                                            <?=$row['adres']?>
                                                        </td>
                                                        <td class="text-right" style="min-width: 100px">
                                                            <a href="javascript:Void(0)" data-id="<?=$row['id']?>" class="btn btn-sm btn-primary duzenleAjax" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-text-159']?>"><i class="fa fa-eye" ></i></a>
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
                                        <div class="w-100 pt-3 pb-3 border-top   " >
                                            <button class="btn btn-danger btn-sm pl-4 pr-4 " disabled="disabled" name="deleteMulti" ><i class="fa fa-trash"></i> <?=$diller['adminpanel-text-158']?></button>
                                        </div>
                                    </form>
                                    <script>
                                        var checkboxes = $("input[data-id='chec']"),
                                            submitButt = $("button[name='deleteMulti']");

                                        checkboxes.click(function() {
                                            submitButt.attr("disabled", !checkboxes.is(":checked"));
                                        });
                                    </script>
                                    <!--  <========SON=========>>> Responsive tablo SON !-->
                                    <?php if($ToplamVeri > $Limit  ) {?>
                                        <div id="SayfalamaElementi" class="w-100 p-2  border-bottom bg-light border-top  ">
                                            <?php if($Sayfa >= 1){?>
                                            <nav aria-label="Page navigation example " >
                                                <ul class="pagination pagination-sm justify-content-end mb-0 ">
                                                    <?php } ?>
                                                    <?php if($Sayfa > 1){  ?>
                                                        <li class="page-item "><a class="page-link " href="pages.php?page=sitemap<?=$searchPage?>"><?=$diller['sayfalama-ilk']?></a></li>
                                                        <li class="page-item "><a class="page-link " href="pages.php?page=sitemap<?=$searchPage?>&p=<?=$Sayfa - 1?>"><?=$diller['sayfalama-onceki']?></a></li>
                                                    <?php } ?>
                                                    <?php
                                                    for($i = $Sayfa - $GorunenSayfa; $i < $Sayfa + $GorunenSayfa +1; $i++){ if($i > 0 and $i <= $Sayfa_Sayisi){
                                                        if($i == $Sayfa){
                                                            ?>
                                                            <li class="page-item active " aria-current="page">
                                                                <a class="page-link" href="pages.php?page=sitemap<?=$searchPage?>&p=<?=$i?>"><?=$i?><span class="sr-only">(current)</span></a>
                                                            </li>
                                                            <?php
                                                        }else{
                                                            ?>
                                                            <li class="page-item "><a class="page-link" href="pages.php?page=sitemap<?=$searchPage?>&p=<?=$i?>"><?=$i?></a></li>
                                                            <?php
                                                        }
                                                    }
                                                    }
                                                    ?>

                                                    <?php if($islemListele->rowCount() <=0) { } else { ?>
                                                        <?php if($Sayfa != $Sayfa_Sayisi){?>
                                                            <li class="page-item"><a class="page-link" href="pages.php?page=sitemap<?=$searchPage?>&p=<?=$Sayfa + 1?>"><?=$diller['sayfalama-sonraki']?></a></li>
                                                            <li class="page-item"><a class="page-link" href="pages.php?page=sitemap<?=$searchPage?>&p=<?=$Sayfa_Sayisi?>"><?=$diller['sayfalama-son']?></a></li>
                                                        <?php }} ?>
                                                    <?php if($Sayfa >= 1){?>
                                                </ul>
                                            </nav>
                                        <?php } ?>
                                        </div>
                                    <?php }?>
                                </div>
                            </div>
                        </div>
                    <?php }else { ?>
                        <div class="col-md-12 mb-3">
                            <div class="card mb-0">
                                <div class="card-body d-flex align-items-center justify-content-center text-center" style="min-height: 180px; font-size: 17px;">
                                    <div>
                                        <?=$diller['adminpanel-form-text-1943']?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php }?>


                <?php } ?>
            </div>
        <?php } else { ?>
            <div class="card p-xl-5">
                <h3><?= $diller['adminpanel-text-136'] ?></h3>
                <h6><?= $diller['adminpanel-text-137'] ?></h6>
                <div class="mt-3">
                    <a href="<?= $ayar['panel_url'] ?>"
                       class="btn btn-primary"><?= $diller['adminpanel-text-138'] ?></a>
                </div>
            </div>
        <?php } ?>
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
                url: 'masterpiece.php?page=sitemap_edit',
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
<?php if($_GET['go'] == 'address'  ) {?>
    <script>
        $(function(){
            $('html, body').animate({
                scrollTop: $('#go-address').offset().top
            }, 300);
            return false;
        });
    </script>
<?php }?>
<?php if($_GET['go'] == 'add'  ) {?>
    <script>
        $(function(){
            $('html, body').animate({
                scrollTop: $('#go-add').offset().top
            }, 300);
            return false;
        });
    </script>
<?php }?>
