<?php
include 'inc/session.php';
?>
<?php if($adminSorgu->rowCount() >'0'  ) {
    $currentURL = $ayar['panel_url'];
    $_SESSION['current_url'] = $currentURL;
    ?>
<!DOCTYPE html>
    <html lang="<?=$mevcutdil['kisa_ad']?>" dir="<?=$mevcutdil['area']?>">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <title><?=$diller['adminpanel-text-47']?> - <?=$panelayar['baslik']?></title>
        <meta content="Admin Dashboard" name="description" />
        <meta content="ThemeDesign" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <?php include 'inc/template/headerlibs.php'; ?>
    </head>
    <body>
    <div class="panel-home-main-div">


        <!-- Header !-->
        <?php include 'inc/template/header.php'; ?>
        <!--  <========SON=========>>> Header SON !-->


        <div class="wrapper" style="margin-top: 0;">

            <div class="container-fluid">


                <?php if($panelayar['dash_alert'] == '1' ) {?>
                    <!-- Welcome !-->
                    <div class="row" >
                        <div class="col-md-12" >
                            <div class=" alert alert-white card  alert-dismissible fade show welcome-area-alert " role="alert" style="box-shadow: none; background-color: #dbedff; ">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <div class="card-body d-flex justify-content-start align-items-center flex-wrap welcome-area">
                                    <div style="margin-right: 25px;" class="welcome-area-img" >
                                        <img src="assets/images/dash3.png" style="width: 160px">
                                    </div>
                                    <div class="flex-grow-1 ">
                                        <h4 style="font-weight: 400;"><?=$diller['adminpanel-text-49']?> <strong><?=$adminRow['isim']?>,</strong></h4>
                                        <div class="welcomeText" style="font-weight: 400; font-size: 15px; display: none;">
                                            "<?=$diller['adminpanel-text-50']?>"
                                        </div>
                                        <div class="welcomeText" style="font-weight: 400; font-size: 15px; display: none;">
                                            "<?=$diller['bilgitext-1']?>"
                                        </div>
                                        <div class="welcomeText" style="font-weight: 400; font-size: 15px; display: none;">
                                            "<?=$diller['bilgitext-2']?>"
                                        </div>
                                        <div class="welcomeText" style="font-weight: 400; font-size: 15px; display: none;">
                                            "<?=$diller['bilgitext-3']?>"
                                        </div>
                                        <div class="welcomeText" style="font-weight: 400; font-size: 15px; display: none;">
                                            "<?=$diller['bilgitext-4']?>"
                                        </div>
                                        <div class="welcomeText" style="font-weight: 400; font-size: 15px; display: none;">
                                            "<?=$diller['bilgitext-5']?>"
                                        </div>
                                        <div class="welcomeText" style="font-weight: 400; font-size: 15px; display: none;">
                                            "<?=$diller['bilgitext-6']?>"
                                        </div>
                                        <div class="welcomeText" style="font-weight: 400; font-size: 15px; display: none;">
                                            "<?=$diller['bilgitext-7']?>"
                                        </div>
                                        <div class="welcomeText" style="font-weight: 400; font-size: 15px; display: none;">
                                            "<?=$diller['bilgitext-8']?>."
                                        </div>
                                        <div class="welcomeText" style="font-weight: 400; font-size: 15px; display: none;">
                                            "<?=$diller['bilgitext-9']?>"
                                        </div>
                                        <div class="welcomeText" style="font-weight: 400; font-size: 15px; display: none;">
                                            "<?=$diller['bilgitext-10']?>"
                                        </div>
                                        <div class="welcomeText" style="font-weight: 400; font-size: 15px; display: none;">
                                            "<?=$diller['bilgitext-11']?>"
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <script>
                        $(function(){
                            var random = Math.floor(Math.random() * $('.welcomeText').length);
                            $('.welcomeText').eq(random).show().css('background-color');
                        });
                    </script>
                    <!--  <========SON=========>>> Welcome SON !-->
                <?php }?>


                <!-- Page-Title -->
                <div class="row mb-4">
                    <div class="col-sm-12">
                        <div class="page-title-box bg-white p-3 rounded" >
                            <div class="row align-items-center" >
                                <div class="col-md-8" >
                                    <div class=" d-flex align-items-center justify-content-start" style="font-size: 20px ; font-weight: 600;" >
                                        <i class="las la-tachometer-alt mr-1" style="font-size: 28px ;"></i>
                                        <?=$diller['adminpanel-text-47']?>
                                    </div>
                                    <div style="width: 5px; height: 20px" class=" d-sm-inline-block block d-md-none"></div>
                                </div>
                                <?php if($panelayar['bekleyen_isler_modal'] == '1' ) {?>
                                    <div class="col-md-4  text-right ">
                                        <a href="" data-toggle="modal" data-target=".bekleyenler-modal" class="btn btn-primary" style="font-size: 13px; font-weight: 400;"><i class="fa fa-question-circle"></i> <?=$diller['adminpanel-text-48']?></a>
                                    </div>
                                <?php }?>
                            </div>


                        </div>
                    </div>
                </div>
                <!-- end page title end breadcrumb -->




                <?php if($panelayar['dash_ust'] == '1' ) {?>
                <?php if($yetki['katalog'] == '1' && $yetki['urun'] == '1' && $yetki['siparis'] == '1' && $yetki['siparis_yonet'] == '1'  && $yetki['uyelik'] == '1' && $yetki['ticket'] == '1'   ) {?>
                <!-- 3'lü box !-->
                <div class="row">
                    <div class="col-xl-4">
                        <div class="card">
                            <div class="card-body text-center pb-xl-5 pt-xl-5" >
                                <img class="mb-3" src="assets/images/icon/stores.png" >
                                <br>
                                <h6><?=$diller['adminpanel-text-51']?></h6>
                                <h7 style="color:#999"><?=$diller['adminpanel-text-52']?></h7>
                                <br><br>
                                <a href="pages.php?page=products" class="btn btn-sm btn-success"><?=$diller['adminpanel-text-53']?></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="card">
                            <div class="card-body text-center pb-xl-5 pt-xl-5" >
                                <img class="mb-3" src="assets/images/icon/orders.png" >
                                <br>
                                <h6><?=$diller['adminpanel-text-54']?></h6>
                                <h7 style="color:#999"><?=$diller['adminpanel-text-55']?></h7>
                                <br><br>
                                <a href="pages.php?page=orders" class="btn btn-sm btn-success"><?=$diller['adminpanel-text-56']?></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="card">
                            <div class="card-body text-center pb-xl-5 pt-xl-5" >
                                <img class="mb-3" src="assets/images/icon/supp.png" >
                                <br>
                                <h6><?=$diller['adminpanel-text-57']?></h6>
                                <h7 style="color:#999"><?=$diller['adminpanel-text-58']?></h7>
                                <br><br>
                                <a href="pages.php?page=tickets" class="btn btn-sm btn-success"><?=$diller['adminpanel-text-59']?></a>
                            </div>
                        </div>
                    </div>
                </div>
                <!--  <========SON=========>>> 3'lü box SON !-->
                <?php }?>
                <?php }?>


                <?php if($panelayar['dash_istatistik'] == '1' ) {?>
                <!-- Sol ve Sağ Blok !-->
                <div class="row">
                    <div class="col-xl-8">
                        <div class="row">
                            <div class="col-md-7 ">
                                <div class="card m-b-30">
                                    <div class="card-body">

                                        <div class="w-100 d-flex align-items-start justify-content-between flex-wrap">
                                            <div>
                                                <h4 class="mt-0 header-title"><?=$diller['adminpanel-text-60']?></h4>
                                                <?php if($yetki['uyelik'] == '1' && $yetki['ziyaretci_istatistik'] == '1' ) {?>
                                                <p class="text-muted m-b-0 d-inline-block text-truncate w-100" style="margin-bottom: 0;"><?=$diller['adminpanel-text-61']?></p>
                                                <?php } ?>
                                            </div>
                                            <?php if($yetki['uyelik'] == '1' && $yetki['ziyaretci_istatistik'] == '1' ) { ?>
                                            <a href="pages.php?page=visitor_analytics" class="text-pink" style="font-weight: 400; font-size: 12px;">
                                                <i class="fa fa-external-link-alt"></i> <?=$diller['adminpanel-text-62']?>
                                            </a>
                                            <?php } ?>
                                        </div>
                                        <?php if($yetki['uyelik'] == '1' && $yetki['ziyaretci_istatistik'] == '1' ) {?>
                                            <div id="visitors-analytics-home"></div>
                                        <?php }else { ?>
                                            <div class="w-100 bg-light d-flex align-items-center justify-content-center flex-column" style="padding: 20px;text-align: center;  min-height:250px; border:2px dashed #ccc">
                                                <i class="fa fa-exclamation-triangle" style="font-size: 35px ; margin-bottom: 8px;"></i>
                                                <h6><?=$diller['adminpanel-text-74']?></h6>
                                            </div>
                                        <?php }?>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-5 ">


                                <div class="card  ">
                                    <div class="card-body text-center">
                                        <h6 class="text-dark"> <?=$diller['adminpanel-text-68']?></h6>
                                        <div class="row">
                                            <?php if($yetki['uyelik'] == '1' && $yetki['ziyaretci_istatistik'] == '1' ) {?>
                                                <div class="col-md-12 text-center text-dark" id="onlinever" style="padding: 0px; margin: 0px"></div>
                                                <script>
                                                    $('#onlinever').html('<div class="spinner-border text-success"  style="width:50px; height: 50px; margin:38px 0" role="status">\n' +
                                                        '<span class="sr-only">Loading...</span>\n' +
                                                        '</div>');
                                                    function veriler2(){  $.get("inc/online.php",function(data){ jQuery('#onlinever').html(data); }); }
                                                    window.setInterval("veriler2()",3000);
                                                </script>
                                            <?php }else { ?>
                                                <div class="bg-light d-flex align-items-center justify-content-center flex-column" style="padding: 20px;text-align: center;  margin:20px; min-height:100px; border:2px dashed #ccc">
                                                    <i class="fa fa-exclamation-triangle" style="font-size: 35px ; margin-bottom: 8px;"></i>
                                                    <?=$diller['adminpanel-text-74']?>
                                                </div>
                                            <?php }?>
                                        </div>
                                    </div>
                                </div>


                                <div class="card bg-white">
                                    <div class="card-body d-flex align-items-start justify-content-start text-left row">
                                        <div class="header-title col-md-12 mb-3 d-flex align-items-center justify-content-between flex-wrap" style="font-weight: 600; border-bottom: 2px solid #fff; padding-bottom: 10px; ">
                                           <?=$diller['adminpanel-text-69']?><?php //todo bu alanın detay sayfasını unutma ?>
                                        </div>
                                        <?php if($yetki['veriler'] == '1' ) {?>
                                            <div id="home-veriler-java" style="width: 100%"></div>
                                        <?php }else { ?>
                                            <div class="bg-light d-flex align-items-center justify-content-center flex-column" style="padding: 20px; margin:0 20px; text-align: center; min-height:auto; border:2px dashed #ccc">
                                                <i class="fa fa-exclamation-triangle" style="font-size: 35px ; margin-bottom: 8px;"></i>
                                               <?=$diller['adminpanel-text-74']?>
                                            </div>
                                        <?php }?>
                                    </div>
                                </div>



                            </div>
                        </div>
                        <div class="card">
                            <div class="d-flex p-2 pb-xl-4  pt-xl-4 flex-wrap">


                                <div class="mb-4 col-md-12" >
                                    <div class="font-14 d-flex align-items-center justify-content-between" style=" font-weight: 600;">
                                        <?=$diller['adminpanel-text-75']?>
                                        <?php if($yetki['siparis'] == '1' && $yetki['siparis_diger'] == '1' ) {?>
                                        <a href="pages.php?page=order_reports"  class="text-pink" style="font-weight: 400; font-size: 12px; ">
                                            <i class="fa fa-external-link-alt"></i> <?=$diller['adminpanel-text-62']?>
                                        </a>
                                        <?php } ?>
                                    </div>
                                </div>
                                <?php if($yetki['siparis'] == '1' && $yetki['siparis_diger'] == '1' ) {?>
                                    <div id="home-order-data" style="width: 100%; display: flex; flex-wrap: wrap"></div>
                                <?php }else { ?>
                                    <div class="bg-light " style=" border:2px dashed #ccc; padding:20px; text-align: center; margin: 0 auto; margin-bottom: 20px; width: 97% !important; ">
                                        <i class="fa fa-exclamation-triangle" style="font-size: 35px ; margin-bottom: 8px;"></i><br>
                                        <?=$diller['adminpanel-text-74']?>
                                    </div>
                                <?php }?>


                                <div class="mb-4 col-md-12" >
                                    <div class="font-14 d-flex align-items-center justify-content-between" style=" font-weight: 600;">
                                       <?=$diller['adminpanel-text-79']?>
                                        <?php if($yetki['siparis'] == '1' && $yetki['siparis_diger'] == '1' ) {?>
                                        <a href="pages.php?page=sale_reports"  class="text-pink" style="font-weight: 400; font-size: 12px; ">
                                            <i class="fa fa-external-link-alt"></i> <?=$diller['adminpanel-text-62']?>
                                        </a>
                                        <?php } ?>
                                    </div>
                                </div>
                                <?php if($yetki['siparis'] == '1' && $yetki['siparis_diger'] == '1' ) {?>
                                    <div id="home-sale-data" style="width: 100%; display: flex; flex-wrap: wrap"></div>
                                <?php }else { ?>
                                    <div class="bg-light " style=" border:2px dashed #ccc; padding:20px; text-align: center; margin: 0 auto; margin-bottom: 20px; width: 97% !important; ">
                                        <i class="fa fa-exclamation-triangle" style="font-size: 35px ; margin-bottom: 8px;"></i><br>
                                        <?=$diller['adminpanel-text-74']?>
                                    </div>
                                <?php }?>



                            </div>
                        </div>
                    </div>

                    <!-- sağ taraf !-->
                    <div class="col-xl-4">
                        <div class="card">
                            <div class="card-body text-left " >
                                <?php include 'inc/template/bekleyen-isler.php'; ?>
                            </div>
                        </div>
                    </div>
                    <!--  <========SON=========>>> sağ taraf SON !-->
                </div>
                <!--  <========SON=========>>> Sol ve Sağ Blok SON !-->
                <?php }?>

                <?php if($panelayar['dash_siparis'] == '1' ) {?>
                <div class="row">


                    <div class="col-md-8">
                        <div class="card ">
                            <div class="card-body">
                                <div class="col-md-14 mb-3 d-flex align-items-center justify-content-between flex-wrap">
                                    <div class="font-14" style="font-weight: 600;">
                                        <?=$diller['adminpanel-text-89']?>
                                    </div>
                                    <?php if($yetki['siparis'] == '1' && $yetki['siparis_yonet'] == '1' ) {?>
                                        <a href="pages.php?page=orders" class="btn btn-sm  text-dark" style="font-weight: 600; padding: 0;">
                                            <?=$diller['adminpanel-text-90']?>
                                        </a>
                                    <?php }?>
                                </div>
                                <!-- Siparişler Tablosu !-->
                                <div class="table-responsive ">
                                    <?php if($yetki['siparis'] == '1' && $yetki['siparis_yonet'] == '1' ) {
                                        
                                        $homeLastOrders = $db->prepare("select siparis_no,siparis_tarih,isim,soyisim,siparis_durum,odeme_tur,toplam_tutar,havale_toplamtutar,parabirimi from siparisler where onay=:onay order by id desc limit 7 ");
                                        $homeLastOrders->execute(array(
                                                'onay' => '1',
                                        ));

                                        
                                        ?>
                                    <table class="table table-hover mb-0 ">
                                        <thead class="thead-default">
                                        <tr>
                                            <th><?=$diller['adminpanel-text-91']?></th>
                                            <th><?=$diller['adminpanel-text-92']?></th>
                                            <th><?=$diller['adminpanel-text-93']?></th>
                                            <th><?=$diller['adminpanel-text-94']?></th>
                                            <th><?=$diller['adminpanel-text-95']?></th>
                                            <th><?=$diller['adminpanel-text-96']?></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach ($homeLastOrders as $orderRow) {
                                            $OdemeDurumu = $db->prepare("select baslik from siparis_durumlar where id='$orderRow[siparis_durum]' and durum='1' ");
                                            $OdemeDurumu->execute();
                                            $sipDurum = $OdemeDurumu->fetch(PDO::FETCH_ASSOC);
                                            ?>
                                            <tr >
                                                <th scope="row" style="font-weight: 600;"><a href="pages.php?page=order_detail&orderID=<?=$orderRow['siparis_no']?>" class="text-pink"><u>#<?=$orderRow['siparis_no']?></u></a></th>
                                                <td><?=$orderRow['isim']?> <?=$orderRow['soyisim']?></td>
                                                <td>
                                                    <?php if($orderRow['odeme_tur'] == '1' ) {?>
                                                        <?=$diller['adminpanel-text-97']?>
                                                    <?php }?>
                                                    <?php if($orderRow['odeme_tur'] == '2' ) {?>
                                                        <?=$diller['adminpanel-text-98']?>
                                                    <?php }?>
                                                    <?php if($orderRow['odeme_tur'] == '3' ) {?>
                                                        <?=$diller['adminpanel-text-99']?>
                                                    <?php }?>
                                                    <?php if($orderRow['odeme_tur'] == '4' ) {?>
                                                        <?=$diller['adminpanel-text-100']?>
                                                    <?php }?>
                                                    <?php if($orderRow['odeme_tur'] == 'free' ) {?>
                                                        <?=$diller['adminpanel-text-342']?>
                                                    <?php }?>
                                                </td>
                                                <td style="font-weight: 500;">
                                                    <?php if($orderRow['odeme_tur'] == '2' ) {?>
                                                    <?php echo number_format($orderRow['havale_toplamtutar'], 2); ?> <?=$orderRow['parabirimi']?>
                                                    <?php }else { ?>
                                                        <?php echo number_format($orderRow['toplam_tutar'], 2); ?> <?=$orderRow['parabirimi']?>
                                                    <?php }?>
                                                </td>
                                                <td><?=$sipDurum['baslik']?></td>
                                                <td class="font-12 text-muted"><?php echo date_tr('j F Y, H:i', ''.$orderRow['siparis_tarih'].''); ?></td>
                                            </tr>
                                        <?php }?>
                                        </tbody>
                                    </table>
                                    <?php }else { ?>
                                        <div class="w-100 bg-light d-flex align-items-center justify-content-center flex-column" style="padding: 20px;text-align: center;  min-height:250px; border:2px dashed #ccc">
                                            <i class="fa fa-exclamation-triangle" style="font-size: 35px ; margin-bottom: 8px;"></i>
                                            <h6><?=$diller['adminpanel-text-74']?></h6>
                                        </div>
                                    <?php }?>
                                </div>
                                <!--  <========SON=========>>> Siparişler Tablosu SON !-->
                            </div>
                        </div>
                    </div>


                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="col-md-14 mb-3 d-flex align-items-center justify-content-between flex-wrap">
                                    <div class="font-14" style="font-weight: 600;">
                                        <?=$diller['adminpanel-text-101']?><i class="fa fa-info-circle float-right" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-text-104']?>"></i>
                                        <div class=" text-muted mt-3 mb-4" style="font-weight: 400; font-size: 13px ;">
                                          <?=$diller['adminpanel-text-102']?>
                                        </div>
                                    </div>
                                </div>
                                <?php if($yetki['siparis'] == '1' && $yetki['siparis_diger'] == '1' ) { ?>
                                    <div id="order-type-pie"></div>
                                <?php }else { ?>
                                    <div class="w-100 bg-light d-flex align-items-center justify-content-center flex-column" style="padding: 20px;text-align: center;  min-height:250px; border:2px dashed #ccc">
                                        <i class="fa fa-exclamation-triangle" style="font-size: 35px ; margin-bottom: 8px;"></i>
                                        <h6><?=$diller['adminpanel-text-74']?></h6>
                                    </div>
                                <?php }?>

                            </div>
                        </div>
                    </div>
                </div>
                <?php }?>

                <?php if($panelayar['dash_alt'] == '1' ) {?>
                <div class="row" >
                    
                    <div class="col-xl-4 todo_list"  >
                        <div class="card">
                            <div class="card-body" >
                                <div class="col-md-14 mb-3 d-flex align-items-center justify-content-between flex-wrap"  >
                                    <div class="font-14" style="font-weight: 600;">
                                       <?=$diller['adminpanel-text-10-2']?>
                                    </div>
                                    <a href="pages.php?page=todo_list" class="btn btn-sm  text-dark" style="font-weight: 600; padding: 0;">
                                        <?=$diller['adminpanel-text-90']?>
                                    </a>
                                </div>
                                    <form action="post.php?process=todopost" method="post">
                                        <div class="input-group custom-input mb-4">
                                        <input type="text" class="form-control todo-list-input"  placeholder="<?=$diller['adminpanel-text-105']?>" name="todo_value"  required autocomplete="off">
                                        <span class="input-group-append"></span>
                                        <button name="todoPost" class="btn btn-primary add-new-todo-btn"><?=$diller['adminpanel-text-106']?></button>
                                        </div>
                                    </form>
                                <?php
                                 $todoCheck = $db->prepare("select * from panel_todo where admin_id=:admin_id order by id desc limit 5 ");
                                 $todoCheck->execute(array(
                                        'admin_id' => $adminRow['id'],
                                 ));
                                ?>
                                <?php if($todoCheck->rowCount()>'0'  ) {?>
                                 <?php foreach ($todoCheck as $todoRow) {?>
                                        <div class="col-md-12 p-2 d-flex justify-content-between     mb-3 bg-light" style="border: 1px solid #EBEBEB;">
                                            <?php if($todoRow['durum'] == '1' ) {?>
                                                <a href="javascript:Void(0)" class="rounded btn btn-success  p-2 d-flex justify-content-center align-items-center" style="font-size: 14px ; width: 40px" data-toggle="tooltip" data-placement="right" title="<?=$diller['adminpanel-text-107']?> / <?php echo date_tr('j F Y, H:i ', ''.$todoRow['do_tarih'].''); ?>">
                                                    <i class="fa fa-check" ></i>
                                                </a>
                                            <?php }?>
                                            <?php if($todoRow['durum'] == '0' ) {?>
                                                <a href="#" class="rounded btn btn-light border p-2 d-flex justify-content-center align-items-center gorev-tamamlandi" style="background-color: #e3e6ea !important; font-size: 14px ; width: 40px" data-code="<?=$todoRow['random_id']?>" data-toggle="tooltip" data-placement="right" title="<?=$diller['adminpanel-text-108']?> ">
                                                    <i class="fa fa-check" ></i>
                                                </a>
                                            <?php }?>
                                            <div class="p-2" style="font-size: 13px ; font-weight: 500; flex:1; margin-left: 10px;">
                                                <div style="font-size: 11px ; color: #999;" class="mb-1"><?php echo date_tr('j F Y, H:i ', ''.$todoRow['tarih'].''); ?></div>
                                                <?=$todoRow['baslik']?>
                                            </div>
                                            <a href="" data-href="post.php?process=todo_delete&todo=success&todo_no=<?=$todoRow['random_id']?>"  data-toggle="modal" data-target="#confirm-delete" class="rounded bg-white text-pink p-2 d-flex align-items-center justify-content-center " style="font-size: 14px ; font-weight: 600; border: 1px solid #EBEBEB; width: 50px"  >
                                                <i class="fa fa-trash-alt" ></i>
                                            </a>
                                        </div>
                                 <?php }?>
                                <?php }else { ?>
                                <div class="w-100 text-center  p-4 ">
                                    <img src="assets/images/icon/todo.png" class="img-fluid" style="width: 150px">
                                    <br><br>
                                    <h6><?=$diller['adminpanel-text-109']?></h6>
                                   <?=$diller['adminpanel-text-110']?>
                                </div>
                                <?php }?>

                            </div>
                        </div>
                        <?php if($_SESSION['collepse_status'] == 'todo_list'  ) {?>
                            <script>
                                $(function(){
                                    $('html, body').animate({
                                        scrollTop: $('.todo_list').offset().top
                                    }, 100);
                                    return false;
                                });
                            </script>
                            <?php
                            unset($_SESSION['collepse_status'])
                            ?>
                        <?php }?>
                    </div>

                    <!-- end col -->

                    <div class="col-xl-4">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="mt-0 header-title mb-4"><?=$diller['adminpanel-text-112']?></h4>
                                <?php
                                $hit5urun = $db->prepare("select * from urun where durum='1' order by hit desc limit 5 ");
                                $hit5urun->execute();
                                //todo çok satan 5 ürünü de ekle
                                ?>
                                <?php if($hit5urun->rowCount()>'0'  ) {?>
                                    <?php foreach ($hit5urun as $hitRow) {?>
                                        <div class="w-100 d-flex align-items-start justify-content-start mb-3">
                                            <div style="width: 80px">
                                                <img src="../images/product/<?=$hitRow['gorsel']?>" class="img-fluid card-img border p-1" style="max-height: 80px">
                                            </div>
                                            <div class="col-md-8">
                                                <div href="" class="text-dark " style="font-weight: 500;">
                                                   <?=$hitRow['baslik']?>
                                                </div>
                                                <div class="d-flex justify-content-start align-items-center mt-2">
                                                    <a href="pages.php?page=product_detail&productID=<?=$hitRow['id']?>" class="btn btn-sm btn-primary  mr-1" style="padding: 2px 6px;" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-text-115']?>">
                                                        <i class="fa fa-pencil-alt" style="font-size: 10px ;" ></i>
                                                    </a>
                                                    <a href="<?=$ayar['site_url']?><?=$hitRow['seo_url']?>-P<?=$hitRow['id']?>" class="btn btn-sm btn-light border" style="padding: 2px 6px;" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-text-116']?>" target="_blank">
                                                        <i class="fa fa-external-link-alt" style="font-size: 10px ;" ></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    <?php }?>
                                <?php }else { ?>
                                    <div class="w-100 text-center  p-4 ">
                                        <img src="assets/images/icon/shops.png" class="img-fluid" style="width: 208px">
                                        <br><br>
                                        <h6><?=$diller['adminpanel-text-113']?></h6>
                                        <?=$diller['adminpanel-text-114']?>
                                    </div>
                                <?php }?>
                            </div>
                        </div>
                    </div>
                    <!-- end col -->

                    <!-- Carousel !-->
                    <div class="col-xl-4">
                        <div id="carousel" class="carousel slide" data-ride="carousel"  data-interval="3500">
                            <div class="carousel-inner" role="listbox">
                                <div class="carousel-item active">
                                    <div class="card bg-warning ">
                                        <div class="card-body ml-2 mr-2 ">
                                            <div class="text-dark-50">
                                                <h5 class="text-dark"><?=$diller['adminpanel-text-117']?></h5>
                                                <p><?=$diller['adminpanel-text-118']?></p>
                                                <div>
                                                    <a href="pages.php?page=newsletter" class="btn btn-primary btn-sm mb-2 text-left" style="width: 200px"><i class="fa fa-envelope mr-2"></i> <?=$diller['adminpanel-text-119']?></a>
                                                    <br>
                                                    <a href="pages.php?page=multi_sms" class="btn btn-primary btn-sm mb-2 text-left" style="width: 200px">
                                                        <svg width="15px" height="15px" viewBox="0 0 16 16" class="bi bi-phone-vibrate mr-2" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd" d="M10 3H6a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h4a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1zM6 2a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h4a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H6z"/>
                                                            <path fill-rule="evenodd" d="M8 12a1 1 0 1 0 0-2 1 1 0 0 0 0 2zM1.599 4.058a.5.5 0 0 1 .208.676A6.967 6.967 0 0 0 1 8c0 1.18.292 2.292.807 3.266a.5.5 0 0 1-.884.468A7.968 7.968 0 0 1 0 8c0-1.347.334-2.619.923-3.734a.5.5 0 0 1 .676-.208zm12.802 0a.5.5 0 0 1 .676.208A7.967 7.967 0 0 1 16 8a7.967 7.967 0 0 1-.923 3.734.5.5 0 0 1-.884-.468A6.967 6.967 0 0 0 15 8c0-1.18-.292-2.292-.807-3.266a.5.5 0 0 1 .208-.676zM3.057 5.534a.5.5 0 0 1 .284.648A4.986 4.986 0 0 0 3 8c0 .642.12 1.255.34 1.818a.5.5 0 1 1-.93.364A5.986 5.986 0 0 1 2 8c0-.769.145-1.505.41-2.182a.5.5 0 0 1 .647-.284zm9.886 0a.5.5 0 0 1 .648.284C13.855 6.495 14 7.231 14 8c0 .769-.145 1.505-.41 2.182a.5.5 0 0 1-.93-.364C12.88 9.255 13 8.642 13 8c0-.642-.12-1.255-.34-1.818a.5.5 0 0 1 .283-.648z"/>
                                                        </svg>
                                                        <?=$diller['adminpanel-text-120']?>
                                                    </a>
                                                    <br>
                                                    <a href="pages.php?page=notifications" class="btn btn-primary btn-sm text-left" style="width: 200px">
                                                        <i class="fa fa-bell mr-2"></i>
                                                        <?=$diller['adminpanel-text-121']?></a>
                                                </div>
                                            </div>
                                            <div class="row justify-content-end">
                                                <div class="col-11">
                                                    <div class="mt-4">
                                                        <img src="assets/images/icon/p-5.svg" alt="" class="img-fluid mx-auto d-block">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="carousel-item ">
                                    <div class="card bg-primary ">
                                        <div class="card-body ml-2 mr-2 ">
                                            <div class="text-white-50">
                                                <h5 class="text-white"><?=$diller['adminpanel-text-122']?></h5>
                                                <p><?=$diller['adminpanel-text-123']?></p>
                                                <div>
                                                    <a href="pages.php?page=coupons" class="btn btn-warning btn-sm"><?=$diller['adminpanel-text-124']?></a>
                                                </div>
                                            </div>
                                            <div class="row justify-content-end">
                                                <div class="col-11">
                                                    <div class="mt-4">
                                                        <img src="assets/images/icon/widget-img.png" alt="" class="img-fluid mx-auto d-block">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="carousel-item ">
                                    <div class="card bg-dark ">
                                        <div class="card-body ml-2 mr-2 ">
                                            <div class="text-white-50">
                                                <h5 class="text-white"><?=$diller['adminpanel-text-125']?></h5>
                                                <p><?=$diller['adminpanel-text-126']?></p>
                                                <div>
                                                    <a href="pages.php?page=users" class="btn btn-light btn-sm"><?=$diller['adminpanel-text-127']?></a>
                                                </div>
                                            </div>
                                            <div class="row justify-content-end">
                                                <div class="col-11">
                                                    <div class="mt-4">
                                                        <img src="assets/images/icon/p-1.svg" alt="" class="img-fluid mx-auto d-block">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="carousel-item ">
                                    <div class="card bg-info ">
                                        <div class="card-body ml-2 mr-2 ">
                                            <div class="text-white-50">
                                                <h5 class="text-white"><?=$diller['adminpanel-text-128']?></h5>
                                                <p><?=$diller['adminpanel-text-129']?></p>
                                                <div>
                                                    <a href="pages.php?page=todo_list" class="btn btn-pink btn-sm"><?=$diller['adminpanel-text-130']?></a>
                                                </div>
                                            </div>
                                            <div class="row justify-content-end">
                                                <div class="col-11">
                                                    <div class="mt-4">
                                                        <img src="assets/images/icon/p-2.svg" alt="" class="img-fluid mx-auto d-block">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="carousel-item ">
                                    <div class="card bg-secondary ">
                                        <div class="card-body ml-2 mr-2 ">
                                            <div class="text-white-50">
                                                <h5 class="text-white"><?=$diller['adminpanel-text-131']?></h5>
                                                <p><?=$diller['adminpanel-text-132']?> </p>
                                                <div>
                                                    <a href="pages.php?page=order_reports" class="btn btn-pink btn-sm mb-2 text-left" style="width: 200px"><?=$diller['adminpanel-text-133']?></a>
                                                    <br>
                                                    <a href="pages.php?page=sale_reports" class="btn btn-pink btn-sm mb-2 text-left" style="width: 200px"><?=$diller['adminpanel-text-134']?></a>
                                                </div>
                                            </div>
                                            <div class="row justify-content-end">
                                                <div class="col-11">
                                                    <div class="mt-4">
                                                        <img src="assets/images/icon/p-4.svg" alt="" class="img-fluid mx-auto d-block">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <a class="carousel-control-prev" href="#carousel" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carousel" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>

                    </div>
                    <!--  <========SON=========>>> Carousel SON !-->
                    <!-- end col -->
                </div>
                <?php }?>


            </div> <!-- end container-fluid -->
        </div>
        <!-- end wrapper -->

        <?php if($panelayar['footer_text'] == !null  ) {?>
            <!-- Footer -->
            <footer class="footer <?=$panelayar['footer_bg']?>" >
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 <?=$panelayar['footer_text_color']?>">
                            <?=$panelayar['footer_text']?>
                        </div>
                    </div>
                </div>
            </footer>
            <!-- End Footer -->
        <?php }?>
        <?php include 'inc/template/footerlibs.php'; ?>
    </div>
    </body>
</html>
<?php include 'inc/template/all-modals.php'; ?>

<?php }else { ?>
<?php
header('Location:'.$ayar['site_panel_url'].'login/');
?>
<?php }?>
