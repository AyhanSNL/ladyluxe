<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'hbprocess';

$pazarSql = $db->prepare("select * from pazaryeri where id=:id ");
$pazarSql->execute(array(
    'id' => '1'
));
$pazar = $pazarSql->fetch(PDO::FETCH_ASSOC);

$aktarilacak = $db->prepare("select * from hb_urun_bilgi where hb_aktarim=:hb_aktarim and hb_izin=:hb_izin and hazir=:hazir");
$aktarilacak->execute(array(
    'hb_aktarim' => '0',
    'hb_izin' => '1',
    'hazir' => '1',
));
$aktarsayi = $aktarilacak->rowCount();



$aktarildi = $db->prepare("select * from hb_urun_bilgi where hb_kod != '0' and hb_aktarim=:hb_aktarim ");
$aktarildi->execute(array(
        'hb_aktarim' => '1'
));
$aktarilansayi = $aktarildi->rowCount();


$loglular = $db->prepare("select * from hb_urun_bilgi where hb_log != '0' and hb_aktarim=:hb_aktarim ");
$loglular->execute(array(
    'hb_aktarim' => '0'
));
$logsayi = $loglular->rowCount();


$gel = file_get_contents(''.$ayar['panel_url'].'assets/hb_product/ornek.json');
$gel = json_decode($gel);




?>
<title><?=$diller['pazaryeri-text-148']?> - <?=$panelayar['baslik']?></title>

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
                                <a href="javascript:Void(0)"><i class="fa fa-angle-right"></i> <?=$diller['adminpanel-menu-text-86']?></a>
                                <a href="javascript:Void(0)"><i class="fa fa-angle-right"></i> <?=$diller['pazaryeri-text-148']?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <?php if($yetki['entegrasyon'] == '1' && $yetki['entegrasyon_pazar'] == '1') {?>
            <?php if($pazar['hb_durum'] == '1' ) {?>
                <div class="row">
                    <?php include 'inc/modules/_helper/entegration_leftbar.php'; ?>
                    <!-- Contents !-->
                    <style>
                        .ust-pazar-header{
                            width: 100%;
                            display: flex;
                            justify-content: flex-start;
                            flex-wrap:wrap ;
                            margin-bottom: 20px;
                        }
                        .ust-pazar-header-logo{
                            width: 185px;
                            display: flex;
                            align-items: center;
                            justify-content: flex-start;
                            border-right: 2px solid #EBEBEB;
                            margin-right: 30px;
                        }
                        .ust-pazar-header-text{
                            width: auto;
                            font-size: 20px ;
                            font-weight: 600;
                            color: #000;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                        }

                        .ust-pazar-header-link{
                            margin-left: auto;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                        }
                        .pazar-alert-ul{
                            margin-bottom: 0;
                            margin-top: 10px;
                            font-size: 14px ;
                        }
                        .pazar-alert-ul li{
                            margin-bottom: 10px;
                        }

                        @media screen and (max-width: 768px) and (min-width: 0)  {
                            .ust-pazar-header-logo{
                                width: 100%;
                                border-right:0;
                                margin-right: 0;
                                justify-content: center;
                                margin-bottom: 10px;
                            }
                            .ust-pazar-header-text{
                                text-align: center;
                                width: 100%;
                                margin-bottom: 10px;
                            }
                            .ust-pazar-header-link{
                                margin-left: 0;
                                width: 100%;
                                text-align: center;
                                display: block;
                            }
                            .ust-pazar-header-link a{
                                display: block !important;
                            }
                            .pazar-alert-ul{
                                margin-bottom: 0;
                                margin-top: 10px;
                                font-size: 14px ;
                                padding:15px;
                                width: 100%;
                            }
                            .pazar-alert-ul li{
                                margin-bottom: 10px;
                            }
                        }

                    </style>
                    <div class="col-md-12" >
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card p-3">
                                    <div class="ust-pazar-header">
                                        <div class="ust-pazar-header-logo">
                                            <img src="assets/images/hb_logo.png">
                                        </div>
                                        <div class="ust-pazar-header-text">
                                           Hepsiburada <?=$diller['pazaryeri-text-152']?>
                                        </div>
                                        <div class="ust-pazar-header-link">
                                            <a  class="btn btn-primary text-white  mr-1 mt-1 mb-1" href="pages.php?page=hb_envanter"  > <?=$diller['pazaryeri-text-167']?></a>
                                            <?php if($aktarsayi <= '0'  ) {?>
                                                <a  class="btn btn-success disabled text-white yeni_islem mr-1 mt-1 mb-1" data-id="aktarim" ><i class="fa fa-ban"></i> <?=$diller['pazaryeri-text-153']?> (<?=$aktarsayi?>)</a>
                                            <?php }else { ?>
                                                <a  class="btn btn-success  text-white yeni_islem  mr-1 mt-1 mb-1" data-id="aktarim" > <?=$diller['pazaryeri-text-153']?> (<?=$aktarsayi?>)</a>
                                            <?php }?>
                                            <a  class="btn btn-danger text-white  mr-1 mt-1 mb-1" href="pages.php?page=hb_aktarilan_urunler"  > <?=$diller['pazaryeri-text-154']?> (<?=$aktarilansayi?>)</a>
                                        </div>
                                    </div>
                                    <div class="w-100">
                                        <div class="w-100 border p-3 mb-2 up-arrow-2 rounded-0 alert alert-dismissible bg-light border text-dark">
                                            <div>
                                                <ul class="pazar-alert-ul">
                                                   <?=$diller['pazaryeri-text-157']?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                    <!--  <========SON=========>>> Contents SON !-->


                </div>
            <?php }else { ?>
                <div class="card p-xl-5">
                    <div class="col-md-12 p-3 text-center">
                        <h3><?=$diller['adminpanel-text-136']?></h3>
                        <h6><?=$diller['pazaryeri-text-151']?></h6>
                    </div>
                </div>
            <?php }?>
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
<script type='text/javascript'>
    $(document).ready(function(){

        $('.yeni_islem').click(function(){

            var postID = $(this).data('id');
            // AJAX request
            $.ajax({
                url: 'masterpiece.php?page=hb_toplu_urun_aktar',
                type: 'post',
                data: {postID: postID},
                success: function(response){
                    $('.modal-editable').html(response);
                    $('#duzenle').modal('show');
                }
            });
        });
    });

    $(document).ready(function(){

        $('.urun_ceks').click(function(){

            var postID = $(this).data('id');
            // AJAX request
            $.ajax({
                url: 'masterpiece.php?page=hb_urun_cek',
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