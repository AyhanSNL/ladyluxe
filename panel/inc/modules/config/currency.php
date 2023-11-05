<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'para';

if($_POST) {
    if ($yetki['demo'] != '1') {
        $position = $_POST['position'];
        $count = 1;
        foreach ($position as $idler) {
            $idler2 = htmlspecialchars(trim($idler));
            try {

                $query = $db->query("UPDATE para_birimleri SET sira = '$count' WHERE id = '$idler2'");
            } catch (PDOException $ex) {
                echo "Hata İşlem Yapılamadı!";
                some_logging_function($ex->getMessage());
            }
            $count++;
        }
    }
}

if(isset($_GET['p']) && $_GET['p'] == !null ) {
    $sayfa = '&p='.$_GET['p'].'';
}else{
    $sayfa = null;
}

if(isset($_GET['status_update'])  ) {
if ($yetki['demo'] != '1') {
    if ($_GET['status_update'] == !null) {

        $statusCek = $db->prepare("select * from para_birimleri where id=:id ");
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

            $guncelle = $db->prepare("UPDATE para_birimleri SET
                 durum=:durum
          WHERE id={$_GET['status_update']}      
         ");
            $sonuc = $guncelle->execute(array(
                'durum' => $statusum
            ));
            if ($sonuc) {
                header('Location:' . $ayar['panel_url'] . 'pages.php?page=currency' . $sayfa . '');
            } else {
                echo 'Veritabanı Hatası';
            }

        } else {
            header('Location:' . $ayar['panel_url'] . 'pages.php?page=currency');
        }

    } else {
        header('Location:' . $ayar['panel_url'] . 'pages.php?page=currency');
    }
}
}
if(isset($_GET['status']) && $_GET['status']=='current' && isset($_GET['no']) ) {
    if ($yetki['demo'] != '1') {
        if ($_GET['no'] == !null) {
            $dilleriGoster = $db->prepare("select * from para_birimleri where id=:id and durum=:durum ");
            $dilleriGoster->execute(array(
                'id' => $_GET['no'],
                'durum' => '1',
            ));
            if ($dilleriGoster->rowCount() > '0') {

                $guncelle = $db->prepare("UPDATE para_birimleri SET
                   varsayilan=:varsayilan 
            ");
                $sonuc = $guncelle->execute(array(
                    'varsayilan' => '0'
                ));
                if ($sonuc) {
                    /* Seçiliyi varsayılan yap */
                    $guncelle = $db->prepare("UPDATE para_birimleri SET
                          varsayilan=:varsayilan   
                     WHERE id={$_GET['no']}      
                    ");
                    $sonuc = $guncelle->execute(array(
                        'varsayilan' => '1'
                    ));
                    if ($sonuc) {
                        header('Location:' . $ayar['panel_url'] . 'pages.php?page=currency' . $sayfa . '');
                        unset($_SESSION['dil']);
                    } else {
                        echo 'Veritabanı Hatası';
                    }
                    /*  <========SON=========>>> Seçiliyi varsayılan yap SON */
                } else {
                    echo 'Veritabanı Hatası';
                }


            } else {
                header('Location:' . $ayar['panel_url'] . 'pages.php?page=currency' . $sayfa . '');
            }
        } else {
            header('Location:' . $ayar['panel_url'] . 'pages.php?page=currency' . $sayfa . '');
        }
    }
}

?>
<title><?=$diller['adminpanel-menu-text-82']?> - <?=$panelayar['baslik']?></title>
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
                                <a href="javascript:Void(0)"><i class="fa fa-angle-right"></i> <?=$diller['adminpanel-menu-text-75']?></a>
                                <a href="pages.php?page=currency"><i class="fa fa-angle-right"></i> <?=$diller['adminpanel-menu-text-82']?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <?php if($yetki['yapilandirma'] == '1') {


            $Sayfa = @intval($_GET['p']); if(!$Sayfa) $Sayfa = 1;
            $Say = $db->query("select * from para_birimleri");
            $ToplamVeri = $Say->rowCount();
            $Limit = 20;
            $Sayfa_Sayisi = ceil($ToplamVeri/$Limit); if($Sayfa > $Sayfa_Sayisi){$Sayfa = 1;}
            $Goster = $Sayfa * $Limit - $Limit;
            $GorunenSayfa = 5;
            $islemListele = $db->query("select * from para_birimleri order by sira ASC limit $Goster,$Limit");
            $islemCek = $islemListele->fetchAll(PDO::FETCH_ASSOC);


            ?>


            <div class="row">

                <?php include 'inc/modules/_helper/config_leftbar.php'; ?>

                <!-- Contents !-->
                <div class="<?php if($panelayar['panel_nav'] == '1'   ) { ?>col-md-9<?php }else{?>col-md-12<?php } ?>">
                    <div class="card p-3">
                        <div class="new-buttonu-main-top ">
                            <div class="new-buttonu-main-left">
                                <h4> <?=$diller['adminpanel-menu-text-82']?></h4>
                            </div>
                            <div class="new-buttonu-main">
                                <a href="post.php?process=currency_post&status=currency_auto" id="waitButton" class="btn btn-dark text-white mb-2" ><i class="fas fa-sync-alt "></i> <?=$diller['adminpanel-form-text-728']?></a>
                                <a  class="btn btn-success text-white mb-2"  data-toggle="collapse" data-target="#genelAcc" aria-expanded="false" aria-controls="collapseForm"><i class="fas fa-plus-circle "></i> <?=$diller['adminpanel-form-text-724']?></a>
                            </div>
                        </div>

                        <div id="accordion" class="accordion">
                        <div class="collapse" id="genelAcc" data-parent="#accordion">
                            <div class="w-100 border pl-3 pr-3 pt-3 mb-3">
                            <form action="post.php?process=currency_post&status=add" method="post" >
                                <div class="row ">
                                    <div class="form-group col-md-12 text-center bg-white text-dark mt-n3 mb-3 border-bottom">
                                        <h5> <?=$diller['adminpanel-form-text-724']?></h5>
                                    </div>
                                </div>
                                <div class="row align-items-center justify-content-center">
                                    <div class="form-group col-md-8">
                                        <label for="baslik"><?=$diller['adminpanel-form-text-725']?></label>
                                        <input type="text" autocomplete="off"  name="baslik" id="baslik" required class="form-control" placeholder="<?=$diller['adminpanel-form-text-731']?>">
                                    </div>
                                </div>
                                <div class="row align-items-center justify-content-center">
                                    <div class="form-group col-md-8">
                                        <label for="kod" class="w-100 d-flex align-items-center justify-content-between flex-wrap">
                                            <?=$diller['adminpanel-form-text-726']?>
                                            <a href="https://www.tcmb.gov.tr/kurlar/today.xml" target="_blank">
                                                <i class="fa fa-external-link-alt"></i>
                                            </a>
                                        </label>
                                        <input type="text" autocomplete="off" maxlength="3" name="kod" id="kod" required class="form-control" placeholder="<?=$diller['adminpanel-form-text-730']?>">
                                    </div>
                                </div>
                                <div class="row align-items-center justify-content-center">
                                    <div class="form-group col-md-8">
                                        <label for="deger"><?=$diller['adminpanel-form-text-727']?></label>
                                        <input type="text" autocomplete="off"   name="deger" id="deger" required class="form-control" placeholder="<?=$diller['adminpanel-form-text-734']?>">
                                    </div>
                                </div>
                                <div class="row align-items-center justify-content-center">
                                    <div class="form-group col-md-2">
                                        <label for="sol_simge"><?=$diller['adminpanel-form-text-732']?></label>
                                        <input type="text" autocomplete="off"  maxlength="1" name="sol_simge" id="sol_simge" required class="form-control" placeholder="₺">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="sag_simge"><?=$diller['adminpanel-form-text-733']?></label>
                                        <input type="text" autocomplete="off"  name="sag_simge" id="sag_simge" required class="form-control" placeholder="TL" maxlength="3">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="bozuk_para"><?=$diller['adminpanel-form-text-1544']?></label>
                                        <input type="text" autocomplete="off"  name="bozuk_para" id="bozuk_para" required class="form-control" placeholder="Kr" maxlength="3">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="para_format"><?=$diller['adminpanel-form-text-736']?></label>
                                        <input type="text" autocomplete="off"  name="para_format" id="para_format" required class="form-control" value="2" maxlength="1">
                                    </div>
                                </div>
                                <div class="row align-items-center justify-content-center">
                                    <div class="form-group col-md-8">
                                        <label for="simge_gosterim"><?=$diller['adminpanel-form-text-735']?></label>
                                        <select name="simge_gosterim" class="form-control" id="simge_gosterim" required>
                                            <option value="0"><?=$diller['adminpanel-form-text-737']?></option>
                                            <option value="1"><?=$diller['adminpanel-form-text-738']?></option>
                                            <option value="2"><?=$diller['adminpanel-form-text-739']?></option>
                                            <option value="3"><?=$diller['adminpanel-form-text-740']?></option>
                                        </select>
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

                        <div class="w-100">
                            <div class="w-100 p-2 bg-primary text-white mb-2 font-12">
                                <i class="fa fa-info-circle mr-1"></i> <?=$diller['adminpanel-form-text-743']?><br><i class="fa fa-info-circle mr-1"></i> <?=$diller['adminpanel-form-text-744']?>
                            </div>
                            <div class="w-100 p-2 bg-light mb-2 font-12">
                                <i class="fa fa-info-circle mr-1"></i> <?=$diller['adminpanel-text-171']?>
                            </div>
                            <div class="table-responsive ">
                                <table class="table table-hover mb-0  ">
                                    <thead class="thead-default">
                                    <tr>
                                        <th><?=$diller['adminpanel-text-170']?></th>
                                        <th><?=$diller['adminpanel-form-text-725']?></th>
                                        <th><?=$diller['adminpanel-form-text-726']?></th>
                                        <th><?=$diller['adminpanel-form-text-727']?></th>
                                        <th><?=$diller['adminpanel-form-text-729']?></th>
                                        <th></th>
                                        <th><?=$diller['adminpanel-form-text-62']?></th>
                                        <th  class="text-center" width="100"><?=$diller['adminpanel-text-157']?></th>
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
                                            <td style="min-width: 125px">
                                                <?=$row['baslik']?>
                                            </td>
                                            <td style="font-weight: 500;">
                                                <?=$row['kod']?>
                                            </td>
                                            <td >
                                                <?=$row['deger']?>
                                            </td>
                                            <td >
                                               <?php echo date_tr('j F Y, H:i', ''.$row['son_guncel'].''); ?>
                                            </td>
                                            <td width="130" style="min-width: 130px;  ">
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
                                                        <a href="pages.php?page=currency&status=current&no=<?=$row['id']?><?=$sayfa?>" class="btn btn-outline-pink ml-2 " style="font-weight: 400 !important; font-size: 11px ;">
                                                            <div class="d-flex align-items-center">
                                                                <?=$diller['adminpanel-form-text-70']?>
                                                            </div>
                                                        </a>
                                                    <?php }?>
                                                <?php }?>
                                            </td>
                                            <td width="85">
                                                <?php if($row['durum'] == '0' ) {?>
                                                    <a class="btn btn-sm btn-outline-danger " href="pages.php?page=currency&status_update=<?=$row['id']?><?=$sayfa?>">
                                                        <div class="d-flex align-items-center">
                                                            <i class="fa fa-times mr-2"></i>
                                                            <?=$diller['adminpanel-form-text-68']?>
                                                        </div>
                                                    </a>
                                                <?php }?>
                                                <?php if($row['durum'] == '1' ) {?>
                                                    <?php if($row['varsayilan'] != '1' ) {?>
                                                        <a class="btn btn-sm btn-success " href="pages.php?page=currency&status_update=<?=$row['id']?><?=$sayfa?>">
                                                    <?php }else { ?>
                                                            <a class="btn btn-sm btn-success " href="javascript:Void(0)>">
                                                    <?php }?>
                                                        <div class="d-flex align-items-center">
                                                            <div class="spinner-grow text-white mr-2" role="status" style="width: 10px; height: 10px">
                                                                <span class="sr-only">Loading...</span>
                                                            </div>
                                                            <?=$diller['adminpanel-form-text-67']?>
                                                        </div>
                                                    <?php if($row['varsayilan'] != '1' ) {?>
                                                        </a>
                                                    <?php }?>

                                                <?php }?>
                                            </td>
                                            <td class="text-right" style="min-width: 100px">
                                                <a href="javascript:Void(0)" data-id="<?=$row['id']?>" class="btn btn-sm btn-primary duzenleAjax" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-text-159']?>"><i class="fa fa-eye" ></i></a>
                                                <?php if($ToplamVeri > '1') {?>
                                                    <a href="" data-href="post.php?process=currency_post&status=delete&no=<?=$row['id']?>"  data-toggle="modal" data-target="#confirm-delete"  class="btn btn-sm btn-danger "><i class="fa fa-trash" ></i></a>
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
                                <?php if($ToplamVeri<='0' ) {?>
                                    <div class="w-100  p-3 ">
                                        <i class="fa fa-ban"></i> <?=$diller['adminpanel-text-162']?>
                                    </div>
                                <?php }?>
                            <div class="border-top"> </div>








                            <!---- Sayfalama Elementleri ================== !-->
                            <?php if($ToplamVeri > $Limit  ) {?>
                                <div id="SayfalamaElementi" class="w-100 p-2  border-bottom bg-light  ">
                                    <?php if($Sayfa >= 1){?>
                                    <nav aria-label="Page navigation example " >
                                        <ul class="pagination pagination-sm justify-content-end mb-0 ">
                                            <?php } ?>
                                            <?php if($Sayfa > 1){  ?>
                                                <li class="page-item "><a class="page-link " href="pages.php?page=currency"><?=$diller['sayfalama-ilk']?></a></li>
                                                <li class="page-item "><a class="page-link " href="pages.php?page=currency&p=<?=$Sayfa - 1?>"><?=$diller['sayfalama-onceki']?></a></li>
                                            <?php } ?>
                                            <?php
                                            for($i = $Sayfa - $GorunenSayfa; $i < $Sayfa + $GorunenSayfa +1; $i++){ if($i > 0 and $i <= $Sayfa_Sayisi){
                                                if($i == $Sayfa){
                                                    ?>
                                                    <li class="page-item active " aria-current="page">
                                                        <a class="page-link" href="pages.php?page=currency&p=<?=$i?>"><?=$i?><span class="sr-only">(current)</span></a>
                                                    </li>
                                                    <?php
                                                }else{
                                                    ?>
                                                    <li class="page-item "><a class="page-link" href="pages.php?page=currency&p=<?=$i?>"><?=$i?></a></li>
                                                    <?php
                                                }
                                            }
                                            }
                                            ?>

                                            <?php if($islemListele->rowCount() <=0) { } else { ?>
                                                <?php if($Sayfa != $Sayfa_Sayisi){?>
                                                    <li class="page-item"><a class="page-link" href="pages.php?page=currency&p=<?=$Sayfa + 1?>"><?=$diller['sayfalama-sonraki']?></a></li>
                                                    <li class="page-item"><a class="page-link" href="pages.php?page=currency&p=<?=$Sayfa_Sayisi?>"><?=$diller['sayfalama-son']?></a></li>
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
                url: 'masterpiece.php?page=currency_edit',
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
        $('#genelAcc').on('shown.bs.collapse', function (e) {
            $('html,body').animate({
                    scrollTop: $('#genelAcc').offset().top - 80 },
                500);
        });
    });
    $(document).ready(function() {
        $('.icon_select2').select2();
    });
    jQuery('#kod').keyup(function() {
        $(this).val($(this).val().toUpperCase());
    });
</script>


