<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'tickets';

$ticketDetail = $db->prepare("select * from destek_talebi where destek_no=:destek_no ");
$ticketDetail->execute(array(
        'destek_no' => $_GET['ticketID'],
));
$row = $ticketDetail->fetch(PDO::FETCH_ASSOC);

if($ticketDetail->rowCount()<='0'  ) {
    header('Location:' . $ayar['panel_url'] . 'pages.php?page=tickets');
    exit();
}

$uyeSorgus = $db->prepare("select * from uyeler where id=:id ");
$uyeSorgus->execute(array(
        'id' => $row['uye_id'],
));
$uyee = $uyeSorgus->fetch(PDO::FETCH_ASSOC);

if($uyeSorgus->rowCount()<='0'  ) {
    header('Location:' . $ayar['panel_url'] . 'pages.php?page=tickets');
    exit();
}

if(isset($_GET['status']) && $_GET['status']=='delete'  ) {
    if ($yetki['demo'] != '1') {
        if($_GET['itemID']==!null  ) {
            $sql  = $db->prepare("select * from destek_talep_mesaj where id=:id ");
            $sql ->execute(array(
                'id' => $_GET['itemID'],
            ));
            $sqlRow = $sql->fetch(PDO::FETCH_ASSOC);

            if($sqlRow['destek_no'] == $_GET['ticketID'] ) {
                /* Delete */
                $silmeislem = $db->prepare("DELETE from destek_talep_mesaj WHERE id=:id");
                $okay = $silmeislem->execute(array(
                    'id' => $_GET['itemID']
                ));
                if ($okay) {
                    header('Location:' . $ayar['panel_url'] . 'pages.php?page=ticket_detail&ticketID='.$_GET['ticketID'].'');
                    exit();
                }else {
                    echo 'veritabanı hatası';
                }
                /*  <========SON=========>>> Delete SON */
            }else{
                header('Location:' . $ayar['panel_url'] . 'pages.php?page=tickets');
                exit();
            }
        }else{
            header('Location:' . $ayar['panel_url'] . 'pages.php?page=tickets');
            exit();
        }
    }else{
        header('Location:' . $ayar['panel_url'] . 'pages.php?page=ticket_detail&ticketID='.$_GET['ticketID'].'');
        exit();
    }
}

?>
<title>#<?=$row['destek_no']?> <?=$diller['adminpanel-form-text-1363']?> - <?=$panelayar['baslik']?></title>
<style>
    .imgce img{
       max-width: 250px;
    }
</style>
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
                                <a href="javascript:Void(0)"><i class="fa fa-angle-right"></i><?=$diller['adminpanel-menu-text-25']?></a>
                                <a href="pages.php?page=tickets"><i class="fa fa-angle-right"></i><?=$diller['adminpanel-menu-text-28']?></a>
                                <a href="javascript:Void(0)"><i class="fa fa-angle-right"></i> #<?=$row['destek_no']?> <?=$diller['adminpanel-form-text-1363']?></a>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <?php if($yetki['uyelik'] == '1' && $yetki['ticket'] == '1') { ?>

            <div class="row">

                <?php include 'inc/modules/_helper/users_leftbar.php'; ?>
                <!-- Contents !-->
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body p-4">
                            <div class="w-100 d-flex flex-column pb-2">
                                <div>
                                    <a href="pages.php?page=tickets" class="btn btn-outline-dark btn-sm  d-inline-block"><i class="fas fa-arrow-left"></i> <?=$diller['adminpanel-text-138']?></a>
                                </div>
                            </div>
                            <div class="w-100 border-bottom d-flex align-items-center justify-content-between flex-wrap pb-2 ">
                                <h4> #<?=$row['destek_no']?> <?=$diller['adminpanel-form-text-1363']?></h4>
                            </div>
                            <div class="row mt-3" style="font-size: 14px ;">
                                <div class="col-md-12 form-group">
                                    <div class="shadow-sm
                                     card-body bg-light rounded d-flex align-items-center justify-content-start" style="font-size: 18px;">
                                        <i class="fa fa-user mr-4"></i>
                                        <div style="font-weight: 500;">
                                            <?=$uyee['isim']?> <?=$uyee['soyisim']?>
                                           <div style="font-size: 12px; font-weight: 200;">
                                               <a href="pages.php?page=user_detail&userID=<?=$uyee['id']?>" class="text-primary" target="_blank">
                                                  <?=$diller['adminpanel-form-text-1365']?>
                                               </a>
                                           </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 form-group">
                                    <div class=" card-body shadow-sm  rounded">
                                        <label for=""><i class="fas fa-ticket-alt"></i> <?=$diller['adminpanel-form-text-1352']?></label>
                                        <br>
                                        #<?=$row['destek_no']?>
                                    </div>
                                </div>
                                <div class="col-md-4 form-group">
                                    <div class=" card-body shadow-sm  rounded">
                                        <label for=""><i class="fa fa-clock"></i> <?=$diller['adminpanel-form-text-1355']?></label>
                                        <br>
                                        <?php echo date_tr('j F Y, H:i, l ', ''.$row['ilk_islem'].''); ?>
                                    </div>
                                </div>
                                <div class="col-md-4 form-group">
                                    <div class=" card-body shadow-sm rounded">
                                        <label for=""><i class="fa fa-clock"></i> <?=$diller['adminpanel-form-text-1356']?></label>
                                        <br>
                                        <?php echo date_tr('j F Y, H:i, l ', ''.$row['son_islem'].''); ?>
                                    </div>
                                </div>
                                <div class="col-md-4 form-group">
                                    <div class=" card-body shadow-sm  rounded">
                                        <label for=""><?=$diller['adminpanel-form-text-1353']?></label>
                                        <br>
                                       <?=$row['baslik']?>
                                    </div>
                                </div>
                                <div class="col-md-4 form-group">
                                    <div class=" card-body shadow-sm  rounded">
                                        <label for=""><?=$diller['adminpanel-form-text-1364']?></label>
                                        <br>
                                        <?php if($row['durum'] == '0' ) {?>
                                        <div class="btn btn-sm btn-success" style="padding: 0 10px; font-size: 13px ;">
                                            <?=$diller['adminpanel-form-text-1358']?>
                                        </div>
                                        <?php }?>
                                        <?php if($row['durum'] == '1' ) {?>
                                            <div class="btn btn-sm btn-primary" style="padding: 0 10px; font-size: 13px ;">
                                                <?=$diller['adminpanel-form-text-1357']?>
                                            </div>
                                        <?php }?>
                                    </div>
                                </div>
                                <?php if($row['siparis_no'] == !null ) {?>
                                    <div class="col-md-4 form-group">
                                        <div class=" card-body shadow-sm  rounded">
                                            <label for=""><?=$diller['adminpanel-text-91']?></label>
                                            <br>
                                            <a href="pages.php?page=order_detail&orderID=<?=$row['siparis_no']?>" target="_blank" style="font-weight: 500;">
                                                #<?=$row['siparis_no']?> <i class="fa fa-external-link-alt ml-1"></i>
                                            </a>
                                        </div>
                                    </div>
                                <?php }?>
                            </div>
                            <!-- Messages !-->


                            <div class="new-buttonu-main-top mb-0 pb-2 ">
                                <div class="new-buttonu-main-left">
                                </div>
                                <a  class="btn btn-success text-white "  data-toggle="collapse" data-target="#genelAcc" aria-expanded="false" aria-controls="collapseForm"><i class="fas fa-plus-circle "></i> <?=$diller['adminpanel-form-text-1367']?></a>
                            </div>
                            <div id="accordion" class="accordion">
                                <div class="collapse " id="genelAcc" data-parent="#accordion">
                                    <div class="w-100 border  pl-3 pr-3 pt-3 mb-3">
                                        <form action="post.php?process=ticket_post&status=msg_add" method="post" >
                                            <input type="hidden" name="destek_no" value="<?=$row['destek_no']?>">
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <textarea name="mesaj" id="tiny" class="form-control" rows="3" ></textarea>
                                                </div>
                                                <div class="form-group col-md-6 mb-0">

                                                    <div class="border card-body" >
                                                        <div class=" w-100 border p-3 mb-3 pr-4 rounded alert alert-dismissible alert-warning border-warning text-dark">
                                                            <div style="font-size: 12px ;">
                                                                <?=$diller['adminpanel-form-text-1372']?>
                                                            </div>
                                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <?php if($ayar['smtp_durum'] == '1' ) {?>
                                                        <div class="kustom-checkbox border-bottom">
                                                            <input type="hidden" name="email_go" value="0"">
                                                            <input type="checkbox" class="individual" id="email_go" name='email_go' value="1" >
                                                            <label for="email_go" style="font-weight: 200 !important;"><span class="ml-2"><?=$diller['adminpanel-form-text-1369']?></span></label>
                                                        </div>
                                                        <?php }else { ?>
                                                            <div class="kustom-checkbox">
                                                                <input type="hidden" name="email_go" value="0"">
                                                                <input type="checkbox" class="individual"  disabled >
                                                                <label for="email_go"><del><?=$diller['adminpanel-form-text-1369']?></del><i class="ti-help-alt text-primary ml-2" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-1300']?>"></i></label>
                                                            </div>
                                                        <?php }?>
                                                        <?php if($sms['durum'] == '1' ) {?>
                                                            <div class="kustom-checkbox border-bottom">
                                                                <input type="hidden" name="sms_go" value="0"">
                                                                <input type="checkbox" class="individual" id="sms_go" name='sms_go' value="1" >
                                                                <label for="sms_go" style="font-weight: 200 !important;"><span class="ml-2"><?=$diller['adminpanel-form-text-1370']?></span></label>
                                                            </div>
                                                        <?php }else { ?>
                                                            <div class="kustom-checkbox">
                                                                <input type="hidden" name="sms_go" value="0"">
                                                                <input type="checkbox" class="individual"  disabled >
                                                                <label for="sms_go"><del><?=$diller['adminpanel-form-text-1370']?></del><i class="ti-help-alt text-primary ml-2" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-1375']?>"></i></label>
                                                            </div>
                                                        <?php }?>

                                                        <?php if($notiSet['durum'] == '1' ) {?>
                                                            <div class="kustom-checkbox border-bottom">
                                                                <input type="hidden" name="noti_go" value="0"">
                                                                <input type="checkbox" class="individual" id="noti_go" name='noti_go' value="1" >
                                                                <label for="noti_go" style="font-weight: 200 !important;"><span class="ml-2"><?=$diller['adminpanel-form-text-1371']?></span></label>
                                                            </div>
                                                        <?php }else { ?>
                                                            <div class="kustom-checkbox">
                                                                <input type="hidden" name="noti_go" value="0"">
                                                                <input type="checkbox" class="individual"  disabled >
                                                                <label for="noti_go"><del><?=$diller['adminpanel-form-text-1371']?></del><i class="ti-help-alt text-primary ml-2" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-1376']?>"></i></label>
                                                            </div>
                                                        <?php }?>

                                                    </div>

                                                </div>
                                            </div>

                                            <div class="row border-top pt-3 bg-light pb-3 mt-3">
                                                <div class="col-md-12 text-right">
                                                    <button id="waitButton" class="btn  btn-success " name="insert"><?=$diller['adminpanel-text-351']?></button>
                                                    <a class="btn  btn-secondary text-white" data-toggle="collapse" data-target="#genelAcc" aria-expanded="false" aria-controls="collapseForm"><?=$diller['adminpanel-modal-text-17']?></a>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="in-header-page-main " >
                                <div class="in-header-page-text">
                                    <i class="las la-comment"></i>
                                    <?=$diller['adminpanel-form-text-1366']?>
                                </div>
                            </div>

                            <?php
                            $mesajlar = $db->prepare("select * from destek_talep_mesaj where destek_no=:destek_no ");
                            $mesajlar->execute(array(
                                    'destek_no' => $row['destek_no'],
                            ));
                            ?>
                            <div class="w-100 d-flex align-items-center justify-content-center flex-wrap mt-3 border p-3">
                                <?php if($mesajlar->rowCount()<='0'  ) {?>
                                    <div class="w-100  p-3 ">
                                        <i class="fa fa-ban"></i> <?=$diller['adminpanel-text-162']?>
                                    </div>
                                <?php }?>
                                <?php foreach ($mesajlar as $mesaj) {?>
                                    <?php if($mesaj['gonderen'] == '1' ) {?>
                                        <div class="col-md-12">
                                            <div class="position-absolute d-flex">
                                                <a href=""  data-toggle="modal" data-target="#confirm-delete" data-href="pages.php?page=ticket_detail&ticketID=<?=$_GET['ticketID']?>&status=delete&itemID=<?=$mesaj['id']?>" class=" bg-danger text-center " style="left:0 ; margin-top: -8px; font-size: 14px ; width: 20px; height: 20px; border-radius: 100px">
                                                    <i class="fa fa-times text-white"></i>
                                                </a>
                                                <a href="javascript:Void(0)" data-id="<?=$mesaj['id']?>" class="ml-1 bg-primary d-flex align-items-center justify-content-center duzenleAjax" style="left:0 ; margin-top: -8px; font-size: 11px ; width: 20px; height: 20px; border-radius: 100px">
                                                    <i class="fa fa-eye text-white"></i>
                                                </a>
                                            </div>
                                            <div class="form-group bg-light border rounded p-4" style="width: 90%">
                                                <div class=" pb-2" style="font-size: 15px ;">
                                                    <?=$uyee['isim']?> <?=$uyee['soyisim']?>
                                                </div>
                                                <div style="font-size: 11px ; color: #999;" class="mb-3">
                                                    <i class="far fa-clock"></i> 
                                                    <?php echo date_tr('j F Y, H:i, l ', ''.$mesaj['tarih'].''); ?>
                                                </div>
                                                <div class="border-top  pt-3">
                                                    <?=$mesaj['mesaj']?>
                                                </div>
                                            </div>
                                        </div>
                                        <div style="font-size: 15px ; color: #ccc;" class="w-100 text-center mb-4">
                                            <i class="fas fa-level-down-alt"></i>
                                        </div>
                                    <?php }?>
                                    <?php if($mesaj['gonderen'] == '0' ) {?>
                                        <div class="col-md-12">
                                            <div class="position-absolute d-flex" style="right: 18px">
                                                <a href=""  data-toggle="modal" data-target="#confirm-delete" data-href="pages.php?page=ticket_detail&ticketID=<?=$_GET['ticketID']?>&status=delete&itemID=<?=$mesaj['id']?>" class=" bg-danger text-center " style="left:0 ; margin-top: -8px; font-size: 14px ; width: 20px; height: 20px; border-radius: 100px">
                                                    <i class="fa fa-times text-white"></i>
                                                </a>
                                                <a href="javascript:Void(0)" data-id="<?=$mesaj['id']?>" class="ml-1 bg-primary d-flex align-items-center justify-content-center duzenleAjax" style=" margin-top: -8px; font-size: 11px ; width: 20px; height: 20px; border-radius: 100px">
                                                    <i class="fa fa-eye text-white"></i>
                                                </a>
                                            </div>
                                            <div class="form-group bg-success text-white rounded p-4" style="width: 90%; margin-left: auto">
                                                <div class=" pb-2" style="font-size: 15px ;">
                                                    <?=$mesaj['admin_isim']?> (<?=$diller['adminpanel-form-text-1373']?>)
                                                </div>
                                                <div style="font-size: 11px ; color: #f8f8f8;" class="mb-3">
                                                    <i class="far fa-clock"></i>
                                                    <?php echo date_tr('j F Y, H:i, l ', ''.$mesaj['tarih'].''); ?>
                                                </div>
                                                <div class=" border-top border-success pt-3 imgce">
                                                    <?=$mesaj['mesaj']?>
                                                </div>
                                            </div>
                                        </div>
                                        <div style="font-size: 15px ; " class="w-100 text-center mb-4 text-success">
                                            <i class="fas fa-level-down-alt"></i>
                                        </div>
                                    <?php }?>
                                <?php }?>
                            </div>
                            <!--  <========SON=========>>> Messages SON !-->
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

<script>
    $(function () {
        $('#genelAcc').on('shown.bs.collapse', function (e) {
            $('html,body').animate({
                    scrollTop: $('#genelAcc').offset().top - 80 },
                500);
        });
    });
</script>

<!-- Editable Modal !-->
<script type='text/javascript'>
    $(document).ready(function(){

        $('.duzenleAjax').click(function(){

            var postID = $(this).data('id');

            // AJAX request
            $.ajax({
                url: 'masterpiece.php?page=ticket_msg_edit',
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