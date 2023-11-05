<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?><?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;

if(isset($_GET['p']) && $_GET['p'] == !null ) {
    $sayfa = '&p='.$_GET['p'].'';
}else{
    $sayfa = null;
}

$timestamp = date('Y-m-d G:i:s');


/* Durum Update */
if(isset($_GET['status_update'])  ) {
    if ($yetki['demo'] != '1') {
        if ($_GET['status_update'] == !null) {

            $statusCek = $db->prepare("select * from panel_todo where random_id=:random_id ");
            $statusCek->execute(array(
                'random_id' => $_GET['status_update']
            ));

            if ($statusCek->rowCount() > '0') {
                $st = $statusCek->fetch(PDO::FETCH_ASSOC);


                if ($st['durum'] == '1') {
                    $statusum = '1';
                }
                if ($st['durum'] == '0') {
                    $statusum = '1';
                }

                $guncelle = $db->prepare("UPDATE panel_todo SET
                 durum=:durum,
                 do_tarih=:do_tarih
          WHERE random_id={$_GET['status_update']}      
         ");
                $sonuc = $guncelle->execute(array(
                    'durum' => $statusum,
                    'do_tarih' => $timestamp,
                ));
                if ($sonuc) {
                    header('Location:' . $ayar['panel_url'] . 'pages.php?page=todo_list'.$sayfa.'');
                } else {
                    echo 'Veritabanı Hatası';
                }

            } else {
                header('Location:' . $ayar['panel_url'] . 'pages.php?page=todo_list');
            }

        } else {
            header('Location:' . $ayar['panel_url'] . 'pages.php?page=todo_list');
        }
    }else{
        header('Location:' . $ayar['panel_url'] . 'pages.php?page=todo_list');
    }
}

/*  <========SON=========>>> Durum Update SON */



/* Delete */
if($_GET['status'] == 'multidelete'  ) {
    //todo burada urunlerde silinsin varyantlarda silinsin
    if($_POST) {
        $liste = $_POST['sil'];
        foreach ($liste as $idler){
            $sorgu = $db->prepare("select * from panel_todo where random_id='$idler' ");
            $sorgu->execute();
            if($sorgu->rowCount()>'0'  ) {
                $row = $sorgu->fetch(PDO::FETCH_ASSOC);

                $silmeislem = $db->prepare("DELETE from panel_todo WHERE random_id=:random_id");
                $silmeislem->execute(array(
                    'random_id' => $idler
                ));
            }
        }
        header('Location:'.$ayar['panel_url'].'pages.php?page=todo_list');
    }else{
        header('Location:'.$ayar['panel_url'].'pages.php?page=todo_list');
    }
}
if(isset($_GET['status'])  ) {
    if($_GET['status']=='todo_delete'  ) {
        if($_GET['no'] >'0'  ) {
            $silmeislem = $db->prepare("DELETE from panel_todo WHERE random_id=:random_id");
            $sil = $silmeislem->execute(array(
                'random_id' => $_GET['no']
            ));
            if ($sil) {
                header('Location:'.$ayar['panel_url'].'pages.php?page=todo_list');
            }else {
                echo 'veritabanı hatası';
            }
        }else{
            header('Location:'.$ayar['panel_url'].'pages.php?page=todo_list');
        }
    }else{
        header('Location:'.$ayar['panel_url'].'pages.php?page=todo_list');
    }
}
/*  <========SON=========>>> Delete SON */


/* Add */
if(isset($_GET['status'])  ) {
    if ($_GET['status'] == 'todo_add'  ) {
        if($_POST && $_POST['baslik'] )  {

            $rand = rand(0,(int) 99999999);
            $kaydet = $db->prepare("INSERT INTO panel_todo SET
                   baslik=:baslik,
                   tarih=:tarih,
                   durum=:durum,
                   admin_id=:admin_id,
                   random_id=:random_id
            ");
            $sonuc = $kaydet->execute(array(
                'baslik' => $_POST['baslik'],
                'tarih' => $timestamp,
                'durum' => '0',
                'admin_id' => $adminRow['id'],
                'random_id' => $rand
            ));
            if($sonuc){
                header('Location:'.$ayar['panel_url'].'pages.php?page=todo_list');
            }else{
            echo 'Veritabanı Hatası';
            }
        }else{
            header('Location:'.$ayar['panel_url'].'pages.php?page=todo_list');
        }
    }
}
/*  <========SON=========>>> Add SON */

?>
<title><?=$diller['adminpanel-text-130']?> - <?=$panelayar['baslik']?></title>

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
                                <a href="pages.php?page=todo_list"><i class="fa fa-angle-right"></i><?=$diller['adminpanel-text-130']?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <?php


            $Sayfa = @intval($_GET['p']); if(!$Sayfa) $Sayfa = 1;
            $Say = $db->query("select * from panel_todo where admin_id='$adminRow[id]' ");
            $ToplamVeri = $Say->rowCount();
            $Limit = 20;
            $Sayfa_Sayisi = ceil($ToplamVeri/$Limit); if($Sayfa > $Sayfa_Sayisi){$Sayfa = 1;}
            $Goster = $Sayfa * $Limit - $Limit;
            $GorunenSayfa = 5;
            $islemListele = $db->query("select * from panel_todo where admin_id='$adminRow[id]' order by id desc limit $Goster,$Limit");
            $islemCek = $islemListele->fetchAll(PDO::FETCH_ASSOC);


            ?>


            <div class="row">



                <!-- Contents !-->
                <div class="col-md-12">
                    <div class="card p-3">
                        <div class="new-buttonu-main-top ">
                            <div class="new-buttonu-main-left">
                                <h4> <?=$diller['adminpanel-text-130']?></h4>
                                <div>
                                    <?=$diller['adminpanel-form-text-1124']?> : <?=$ToplamVeri?>
                                </div>
                            </div>
                                <div class="new-buttonu-main">
                                    <a  class="btn btn-success text-white "  data-toggle="collapse" data-target="#genelAcc" aria-expanded="false" aria-controls="collapseForm"><i class="fas fa-plus-circle "></i> <?=$diller['adminpanel-form-text-1728']?></a>
                                </div>
                        </div>
                        <div id="accordion" class="accordion">
                        <div class="collapse" id="genelAcc" data-parent="#accordion">
                            <div class="w-100 border pl-3 pr-3 pt-3 mb-3  ">
                            <form action="pages.php?page=todo_list&status=todo_add" method="post" >
                                <div class="row ">
                                    <div class="form-group col-md-12 text-center bg-white text-dark mt-n3  border-bottom mb-0 ">
                                        <h5> <?=$diller['adminpanel-form-text-1728']?></h5>
                                    </div>
                                </div>
                                <div class="row mt-3 justify-content-center">
                                    <div class="form-group col-md-6">
                                        <label for="baslik">* <?=$diller['adminpanel-text-105']?></label>
                                        <input type="text" autocomplete="off"  name="baslik" id="baslik" required class="form-control">
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
                        <div class="w-100 mt-3">
                            <form method="post" action="pages.php?page=todo_list&status=multidelete">
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
                                        <th><?=$diller['adminpanel-form-text-1081']?></th>
                                        <th><?=$diller['adminpanel-form-text-1729']?></th>
                                        <th><?=$diller['adminpanel-form-text-1730']?></th>
                                        <th class="text-center"><?=$diller['adminpanel-form-text-62']?></th>
                                        <th  class="text-center"><?=$diller['adminpanel-text-13057']?></th>
                                    </tr>
                                    </thead>
                                    <tbody   >
                                    <?php foreach ($islemCek as $row) {
                                        ?>
                                        <tr >
                                            <td>
                                                <div class="custom-control custom-checkbox" >
                                                    <input type="checkbox" class="custom-control-input individual"   id="checkSec-<?=$row['random_id']?>" name='sil[]' value="<?=$row['random_id']?>" >
                                                    <label class="custom-control-label" for="checkSec-<?=$row['random_id']?>" ></label>
                                                </div>
                                            </td>
                                            <td style=" min-width: 145px">
                                              <?php echo date_tr('j F Y, H:i', ''.$row['tarih'].''); ?>
                                            </td>
                                            <td style="font-weight: 500; min-width: 125px">
                                                <?=$row['baslik']?>
                                            </td>
                                            <td style=" min-width: 145px">
                                                <?php if($row['do_tarih'] == !null ) {?>
                                                    <?php echo date_tr('j F Y, H:i', ''.$row['do_tarih'].''); ?>
                                                <?php }else { ?>
                                               <span class="text-danger" style="font-size: 11px ;"><?=$diller['adminpanel-form-text-1732']?></span>
                                                <?php }?>
                                            </td>
                                            <td style=" min-width: 125px" width="165" class="text-center">
                                                <?php if($row['durum'] == '0' ) {?>
                                                    <a class="btn btn-sm btn-outline-secondary " href="pages.php?page=todo_list&status_update=<?=$row['random_id']?><?=$sayfa?>">
                                                        <div class="d-flex align-items-center">
                                                            <i class="fa fa-arrow-right mr-2"></i>
                                                            <?=$diller['adminpanel-form-text-1731']?>
                                                        </div>
                                                    </a>
                                                <?php }?>
                                                <?php if($row['durum'] == '1' ) {?>
                                                    <div class="btn btn-sm btn-success " >
                                                        <div class="d-flex align-items-center">
                                                            <i class="fa fa-check mr-1"></i>
                                                            <?=$diller['adminpanel-text-107']?>
                                                        </div>
                                                    </div>
                                                <?php }?>
                                            </td>
                                            <td class="text-right" style="min-width: 60px" width="60">
                                              <a href="" data-href="pages.php?page=todo_list&status=todo_delete&no=<?=$row['random_id']?>"  data-toggle="modal" data-target="#confirm-delete"  class="btn btn-sm btn-danger "><i class="fa fa-trash" ></i></a>
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
                                                <li class="page-item "><a class="page-link " href="pages.php?page=todo_list"><?=$diller['sayfalama-ilk']?></a></li>
                                                <li class="page-item "><a class="page-link " href="pages.php?page=todo_list&p=<?=$Sayfa - 1?>"><?=$diller['sayfalama-onceki']?></a></li>
                                            <?php } ?>
                                            <?php
                                            for($i = $Sayfa - $GorunenSayfa; $i < $Sayfa + $GorunenSayfa +1; $i++){ if($i > 0 and $i <= $Sayfa_Sayisi){
                                                if($i == $Sayfa){
                                                    ?>
                                                    <li class="page-item active " aria-current="page">
                                                        <a class="page-link" href="pages.php?page=todo_list&p=<?=$i?>"><?=$i?><span class="sr-only">(current)</span></a>
                                                    </li>
                                                    <?php
                                                }else{
                                                    ?>
                                                    <li class="page-item "><a class="page-link" href="pages.php?page=todo_list&p=<?=$i?>"><?=$i?></a></li>
                                                    <?php
                                                }
                                            }
                                            }
                                            ?>

                                            <?php if($islemListele->rowCount() <=0) { } else { ?>
                                                <?php if($Sayfa != $Sayfa_Sayisi){?>
                                                    <li class="page-item"><a class="page-link" href="pages.php?page=todo_list&p=<?=$Sayfa + 1?>"><?=$diller['sayfalama-sonraki']?></a></li>
                                                    <li class="page-item"><a class="page-link" href="pages.php?page=todo_list&p=<?=$Sayfa_Sayisi?>"><?=$diller['sayfalama-son']?></a></li>
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

    </div>
</div>
