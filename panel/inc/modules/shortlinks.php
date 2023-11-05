<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?><?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;

if(isset($_GET['p']) && $_GET['p'] == !null ) {
    $sayfa = '&p='.$_GET['p'].'';
}else{
    $sayfa = null;
}

if($_POST) {
    if ($yetki['demo'] != '1') {
        $position = $_POST['position'];
        $count = 1;
        foreach ($position as $idler) {
            $idler2 = htmlspecialchars(trim($idler));
            try {

                $query = $db->query("UPDATE panel_kisayol SET sira = '$count' WHERE id = '$idler2'");
            } catch (PDOException $ex) {
                echo "Hata İşlem Yapılamadı!";
                some_logging_function($ex->getMessage());
            }
            $count++;
        }
    }
}



/* Durum Update */
if(isset($_GET['status_update'])  ) {
    if ($yetki['demo'] != '1') {
        if ($_GET['status_update'] == !null) {

            $statusCek = $db->prepare("select * from panel_kisayol where id=:id ");
            $statusCek->execute(array(
                'id' => $_GET['status_update']
            ));

            if ($statusCek->rowCount() > '0') {
                $st = $statusCek->fetch(PDO::FETCH_ASSOC);


                if ($st['durum'] == '1') {
                    $statusum = '0';
                }
                if ($st['durum'] == '0') {
                    $statusum = '1';
                }

                $guncelle = $db->prepare("UPDATE panel_kisayol SET
                 durum=:durum
          WHERE id={$_GET['status_update']}      
         ");
                $sonuc = $guncelle->execute(array(
                    'durum' => $statusum
                ));
                if ($sonuc) {
                    header('Location:' . $ayar['panel_url'] . 'pages.php?page=shortlinks'.$sayfa.'');
                } else {
                    echo 'Veritabanı Hatası';
                }

            } else {
                header('Location:' . $ayar['panel_url'] . 'pages.php?page=shortlinks');
            }

        } else {
            header('Location:' . $ayar['panel_url'] . 'pages.php?page=shortlinks');
        }
    }else{
        header('Location:' . $ayar['panel_url'] . 'pages.php?page=shortlinks');
    }
}

/*  <========SON=========>>> Durum Update SON */



/* Delete */
if($_GET['status'] == 'multidelete'  ) {
    if ($yetki['demo'] != '1') {
        if($_POST) {
            $liste = $_POST['sil'];
            foreach ($liste as $idler){
                $sorgu = $db->prepare("select * from panel_kisayol where id='$idler' ");
                $sorgu->execute();
                if($sorgu->rowCount()>'0'  ) {
                    $row = $sorgu->fetch(PDO::FETCH_ASSOC);

                    $silmeislem = $db->prepare("DELETE from panel_kisayol WHERE id=:id");
                    $silmeislem->execute(array(
                        'id' => $idler
                    ));
                }
            }
            header('Location:'.$ayar['panel_url'].'pages.php?page=shortlinks');
        }else{
            header('Location:'.$ayar['panel_url'].'pages.php?page=shortlinks');
        }
    }else{
        header('Location:' . $ayar['panel_url'] . 'pages.php?page=shortlinks');
    }
}
if(isset($_GET['status'])  ) {
    if($_GET['status']=='shortlink_delete'  ) {
        if ($yetki['demo'] != '1') {
            if($_GET['no'] >'0'  ) {
                $silmeislem = $db->prepare("DELETE from panel_kisayol WHERE id=:id");
                $sil = $silmeislem->execute(array(
                    'id' => $_GET['no']
                ));
                if ($sil) {
                    header('Location:'.$ayar['panel_url'].'pages.php?page=shortlinks');
                }else {
                    echo 'veritabanı hatası';
                }
            }else{
                header('Location:'.$ayar['panel_url'].'pages.php?page=shortlinks');
            }
        }else{
            header('Location:' . $ayar['panel_url'] . 'pages.php?page=shortlinks');
        }
    }else{
        header('Location:'.$ayar['panel_url'].'pages.php?page=shortlinks');
    }
}
/*  <========SON=========>>> Delete SON */


/* Add */
if(isset($_GET['status'])  ) {
    if ($_GET['status'] == 'shortlink_add'  ) {
        if ($yetki['demo'] != '1') {
            if($_POST && $_POST['baslik'] && $_POST['adres_url'])  {

                $kaydet = $db->prepare("INSERT INTO panel_kisayol SET
                   sira=:sira, 
                   baslik=:baslik,
                   adres_url=:adres_url,
                   durum=:durum,
                   dil=:dil,
                   admin_id=:admin_id
            ");
                $sonuc = $kaydet->execute(array(
                    'sira' => 0,
                    'baslik' => $_POST['baslik'],
                    'adres_url' => $_POST['adres_url'],
                    'durum' => '1',
                    'dil' => $_SESSION['dil'],
                    'admin_id' => $adminRow['id']
                ));
                if($sonuc){
                    header('Location:'.$ayar['panel_url'].'pages.php?page=shortlinks');
                }else{
                    echo 'Veritabanı Hatası';
                }
            }else{
                header('Location:'.$ayar['panel_url'].'pages.php?page=shortlinks');
            }
        }else{
            header('Location:' . $ayar['panel_url'] . 'pages.php?page=shortlinks');
        }
    }
}
/*  <========SON=========>>> Add SON */


/* Edit */
if(isset($_GET['status'])  ) {
    if ($_GET['status'] == 'shortlink_edit'  ) {
        if ($yetki['demo'] != '1') {
            if($_POST && $_POST['baslik'] && $_POST['adres_url'])  {

                $guncelle = $db->prepare("UPDATE panel_kisayol SET
                   sira=:sira, 
                   baslik=:baslik,
                   adres_url=:adres_url,
                   durum=:durum
             WHERE id={$_POST['link_id']}      
            ");
                $sonuc = $guncelle->execute(array(
                    'sira' => $_POST['sira'],
                    'baslik' => $_POST['baslik'],
                    'adres_url' => $_POST['adres_url'],
                    'durum' => $_POST['durum']
                ));
                if($sonuc){
                    header('Location:'.$ayar['panel_url'].'pages.php?page=shortlinks');
                }else{
                    echo 'Veritabanı Hatası';
                }
            }else{
                header('Location:'.$ayar['panel_url'].'pages.php?page=shortlinks');
            }
        }else{
            header('Location:' . $ayar['panel_url'] . 'pages.php?page=shortlinks');
        }
    }
}
/*  <========SON=========>>> Edit SON */
?>
<title><?=$diller['adminpanel-text-1']?> - <?=$panelayar['baslik']?></title>

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
                                <a href="pages.php?page=shortlinks"><i class="fa fa-angle-right"></i><?=$diller['adminpanel-text-1']?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <?php if($yetki['kisayol_ekle'] == '1') {


            $Sayfa = @intval($_GET['p']); if(!$Sayfa) $Sayfa = 1;
            $Say = $db->query("select * from panel_kisayol where dil='$_SESSION[dil]' and admin_id='$adminRow[id]' ");
            $ToplamVeri = $Say->rowCount();
            $Limit = 15;
            $Sayfa_Sayisi = ceil($ToplamVeri/$Limit); if($Sayfa > $Sayfa_Sayisi){$Sayfa = 1;}
            $Goster = $Sayfa * $Limit - $Limit;
            $GorunenSayfa = 5;
            $islemListele = $db->query("select * from panel_kisayol where dil='$_SESSION[dil]' and admin_id='$adminRow[id]' order by sira asc limit $Goster,$Limit");
            $islemCek = $islemListele->fetchAll(PDO::FETCH_ASSOC);


            ?>


            <div class="row">



                <!-- Contents !-->
                <div class="col-md-12">
                    <div class="card p-3">
                        <div class="new-buttonu-main-top ">
                            <div class="new-buttonu-main-left">
                                <h4> <?=$diller['adminpanel-text-1']?></h4>
                                <div class="bg-light p-2 ">
                                   <?php
                                   $kaynak = $diller['adminpanel-form-text-1726'];
                                   $kaynak  = $kaynak;
                                   $eski   = '{sayi}';
                                   $yeni   = '<strong>15</strong>';
                                   $kaynak = str_replace($eski, $yeni, $kaynak);
                                   ?>
                                    <?=$kaynak?>
                                </div>
                            </div>
                            <?php if($ToplamVeri<= '14'  ) {?>
                                <div class="new-buttonu-main">
                                    <a  class="btn btn-success text-white "  data-toggle="collapse" data-target="#genelAcc" aria-expanded="false" aria-controls="collapseForm"><i class="fas fa-plus-circle "></i> <?=$diller['adminpanel-form-text-1723']?></a>
                                </div>
                            <?php }?>
                        </div>
                        <?php if($ToplamVeri<= '14'  ) {?>
                        <div id="accordion" class="accordion">
                        <div class="collapse" id="genelAcc" data-parent="#accordion">
                            <div class="w-100 border pl-3 pr-3 pt-3 mb-3  ">
                            <form action="pages.php?page=shortlinks&status=shortlink_add" method="post" >
                                <div class="row ">
                                    <div class="form-group col-md-12 text-center bg-white text-dark mt-n3  border-bottom mb-0 ">
                                        <h5> <?=$diller['adminpanel-form-text-1723']?></h5>
                                    </div>
                                </div>
                                <div class="row mt-3 justify-content-center">
                                    <div class="form-group col-md-6">
                                        <a class=" p-2 border d-inline-block bg-white rounded pl-3 pr-3  ">
                                            <div class="d-flex align-items-center justify-content-start">
                                                <div class="mr-2 flag-icon-<?=$mevcutdil['flag']?>" style="width:18px; height:13px; display: inline-block; vertical-align: middle"></div>
                                                <?=$mevcutdil['baslik']?> <?=$diller['adminpanel-form-text-259']?>
                                                <i class="ti-help-alt text-danger ml-2 " style="cursor: pointer" data-container="body" data-toggle="popover" data-placement="right" data-content="<?=$diller['adminpanel-form-text-722']?>"></i>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div class="row justify-content-center">
                                    <div class="form-group col-md-6">
                                        <label for="baslik">* <?=$diller['adminpanel-form-text-1724']?></label>
                                        <input type="text" autocomplete="off"  name="baslik" id="baslik" required class="form-control">
                                    </div>
                                </div>
                                <div class="row justify-content-center">
                                    <div class="form-group col-md-6">
                                        <label for="adres_url">* <?=$diller['adminpanel-form-text-1725']?></label>
                                        <input type="text" autocomplete="off"  name="adres_url" id="adres_url" placeholder="https://" required class="form-control">
                                    </div>
                                </div>
                                <div class="row border-top pt-3 bg-light pb-3">
                                    <div class="col-md-12 text-right">
                                        <button class="btn  btn-success " name="insert"><?=$diller['adminpanel-form-text-53']?></button>
                                        <a class="btn  btn-secondary text-white" data-toggle="collapse" data-target="#genelAcc" aria-expanded="false" aria-controls="collapseForm"><?=$diller['adminpanel-modal-text-17']?></a>
                                    </div>
                                </div>
                            </form>
                        </div>
                        </div>
                        </div>
                        <?php }?>
                        <div class="w-100">
                            <form method="post" action="pages.php?page=shortlinks&status=multidelete">
                            <div class="table-responsive ">
                                <table class="table table-hover mb-0  ">
                                    <thead class="thead-default">
                                    <tr>
                                        <th width="25">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input selectall"  id="hepsiniSecCheckBox" >
                                                <label class="custom-control-label" for="hepsiniSecCheckBox"></label>
                                            </div>
                                        </th>
                                        <th><?=$diller['adminpanel-form-text-1724']?></th>
                                        <th><?=$diller['adminpanel-form-text-1725']?></th>
                                        <th><?=$diller['adminpanel-form-text-62']?></th>
                                        <th  class="text-center" width="100"><?=$diller['adminpanel-text-157']?></th>
                                    </tr>
                                    </thead>
                                    <tbody  class="row_position" >
                                    <?php foreach ($islemCek as $row) {
                                        ?>
                                        <tr id="<?php echo $row['id'] ?>" style="cursor: move">
                                            <td>
                                                <div class="custom-control custom-checkbox" >
                                                    <input type="checkbox" class="custom-control-input individual"   id="checkSec-<?=$row['id']?>" name='sil[]' value="<?=$row['id']?>" >
                                                    <label class="custom-control-label" for="checkSec-<?=$row['id']?>" ></label>
                                                </div>
                                            </td>
                                            <td style="font-weight: 500; min-width: 125px">
                                                <?=$row['baslik']?>
                                            </td>
                                            <td style=" min-width: 125px">
                                                <?=$row['adres_url']?>
                                            </td>
                                            <td style=" min-width: 125px" width="125">
                                                <?php if($row['durum'] == '0' ) {?>
                                                    <a class="btn btn-sm btn-outline-danger " href="pages.php?page=shortlinks&status_update=<?=$row['id']?><?=$sayfa?>">
                                                        <div class="d-flex align-items-center">
                                                            <i class="fa fa-times mr-2"></i>
                                                            <?=$diller['adminpanel-form-text-68']?>
                                                        </div>
                                                    </a>
                                                <?php }?>
                                                <?php if($row['durum'] == '1' ) {?>
                                                    <a class="btn btn-sm btn-success " href="pages.php?page=shortlinks&status_update=<?=$row['id']?><?=$sayfa?>">
                                                        <div class="d-flex align-items-center">
                                                            <div class="spinner-grow text-white mr-2" role="status" style="width: 10px; height: 10px">
                                                                <span class="sr-only">Loading...</span>
                                                            </div>
                                                            <?=$diller['adminpanel-form-text-67']?>
                                                        </div>
                                                    </a>
                                                <?php }?>
                                            </td>
                                            <td class="text-right" style="min-width: 100px">
                                                <a href="javascript:Void(0)" data-id="<?=$row['id']?>" class="btn btn-sm btn-primary duzenleAjax" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-text-159']?>"><i class="fa fa-eye" ></i></a>
                                                    <a href="" data-href="pages.php?page=shortlinks&status=shortlink_delete&no=<?=$row['id']?>"  data-toggle="modal" data-target="#confirm-delete"  class="btn btn-sm btn-danger "><i class="fa fa-trash" ></i></a>
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
                                <?php if($ToplamVeri<='0' ) {?>
                                    <div class="border-top"> </div>
                                    <div class="w-100  p-3 ">
                                        <i class="fa fa-ban"></i> <?=$diller['adminpanel-text-162']?>
                                    </div>
                                <?php }?>
                                <?php if($ToplamVeri > '0') {?>
                                <div class="w-100 pt-3 pb-3 border-bottom border-top  " >
                                    <button class="btn btn-danger btn-sm rounded-0 shadow-lg pl-4 pr-4 " disabled="disabled" name="deleteMulti" ><i class="fa fa-trash"></i> <?=$diller['adminpanel-text-158']?></button>
                                </div>
                            </form>
                            <script>
                                var checkboxes = $("input[type='checkbox']"),
                                    submitButt = $("button[name='deleteMulti']");

                                checkboxes.click(function() {
                                    submitButt.attr("disabled", !checkboxes.is(":checked"));
                                });
                            </script>
                            <?php }?>





                            <!---- Sayfalama Elementleri ================== !-->
                            <?php if($ToplamVeri > $Limit  ) {?>
                                <div id="SayfalamaElementi" class="w-100 p-2  border-bottom bg-light  ">
                                    <?php if($Sayfa >= 1){?>
                                    <nav aria-label="Page navigation example " >
                                        <ul class="pagination pagination-sm justify-content-end mb-0 ">
                                            <?php } ?>
                                            <?php if($Sayfa > 1){  ?>
                                                <li class="page-item "><a class="page-link " href="pages.php?page=shortlinks"><?=$diller['sayfalama-ilk']?></a></li>
                                                <li class="page-item "><a class="page-link " href="pages.php?page=shortlinks&p=<?=$Sayfa - 1?>"><?=$diller['sayfalama-onceki']?></a></li>
                                            <?php } ?>
                                            <?php
                                            for($i = $Sayfa - $GorunenSayfa; $i < $Sayfa + $GorunenSayfa +1; $i++){ if($i > 0 and $i <= $Sayfa_Sayisi){
                                                if($i == $Sayfa){
                                                    ?>
                                                    <li class="page-item active " aria-current="page">
                                                        <a class="page-link" href="pages.php?page=shortlinks&p=<?=$i?>"><?=$i?><span class="sr-only">(current)</span></a>
                                                    </li>
                                                    <?php
                                                }else{
                                                    ?>
                                                    <li class="page-item "><a class="page-link" href="pages.php?page=shortlinks&p=<?=$i?>"><?=$i?></a></li>
                                                    <?php
                                                }
                                            }
                                            }
                                            ?>

                                            <?php if($islemListele->rowCount() <=0) { } else { ?>
                                                <?php if($Sayfa != $Sayfa_Sayisi){?>
                                                    <li class="page-item"><a class="page-link" href="pages.php?page=shortlinks&p=<?=$Sayfa + 1?>"><?=$diller['sayfalama-sonraki']?></a></li>
                                                    <li class="page-item"><a class="page-link" href="pages.php?page=shortlinks&p=<?=$Sayfa_Sayisi?>"><?=$diller['sayfalama-son']?></a></li>
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
<!-- Editable Modal !-->
<script type='text/javascript'>
    $(document).ready(function(){

        $('.duzenleAjax').click(function(){

            var postID = $(this).data('id');

            // AJAX request
            $.ajax({
                url: 'masterpiece.php?page=shortlink_edit',
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