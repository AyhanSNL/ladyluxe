<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;

$mesajCek = $db->prepare("select * from mesaj where id=:id ");
$mesajCek->execute(array(
        'id' => $_GET['messageID'],
));
$mesajRow = $mesajCek->fetch(PDO::FETCH_ASSOC);

if($mesajRow['durum'] == '1' ) {
 $guncelle = $db->prepare("UPDATE mesaj SET
         durum=:durum
  WHERE id={$_GET['messageID']}      
 ");
 $sonuc = $guncelle->execute(array(
     'durum' => '0',
 ));
}

if($mesajCek->rowCount()<='0'  ) {
 header('Location:'.$ayar['panel_url'].'pages.php?page=inbox');
 exit();
}

?>
<title><?=$diller['adminpanel-text-210']?> - <?=$panelayar['baslik']?></title>

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
                                <a href="pages.php?page=inbox"><i class="fa fa-angle-right"></i><?=$diller['adminpanel-text-210']?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



<?php if($yetki['gelenkutusu'] == '1') {?>
    <!-- end page title end breadcrumb -->
    <div class="row">

        <!-- Contents !-->
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <a href="pages.php?page=inbox" class="btn btn-outline-dark   btn-sm  " >
                        <i class="fa fa-arrow-left"></i> <?=$diller['adminpanel-text-138']?>
                    </a>
                    <hr>
                    <div class="row mt-3 ">
                        <div class="col-md-12 " >
                            <label for="name"><?=$diller['adminpanel-text-92']?></label>
                            <div style="font-size: 16px ;">
                                <?=$mesajRow['isim']?>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12 " >
                            <label for="name"><?=$diller['adminpanel-form-text-83']?></label>
                            <div style="font-size: 16px ;">
                                <?=$mesajRow['eposta']?>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12 " >
                            <label for="name"><?=$diller['adminpanel-form-text-81']?></label>
                            <div style="font-size: 16px ;">
                                <?=$mesajRow['telno']?>
                            </div>
                        </div>
                    </div>
                    <hr>  
                    <div class="row mb-2">
                        <div class="col-md-12 " >
                            <label for="name"><?=$diller['adminpanel-form-text-1553']?></label>
                            <div style="font-size: 16px ;">
                                <?php echo date_tr('j F Y, H:i', ''.$mesajRow['tarih'].''); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    
                    <div class="w-100 d-flex align-items-center justify-content-start">
                      <i class="fa fa-info mr-2 text-muted"></i> <h6> <?=$mesajRow['konu']?></h6>
                    </div>
                    <hr>
                    <div class="pb-5" style="font-size: 15px ;">
                        <div class="mb-3" style="font-size: 13px ; color: #666;">
                            <?php echo date_tr('j F Y, H:i', ''.$mesajRow['tarih'].''); ?>
                        </div>
                        <?=$mesajRow['mesaj']?>
                        
                    </div>
                    <a href="pages.php?page=newsletter&toInbox=<?=$mesajRow['id']?>" class="btn btn-primary btn-sm " style="padding-left:20px; padding-right: 20px">
                        <i class="far fa-envelope-open mr-1"></i>  <?=$diller['adminpanel-form-text-1742']?>
                    </a>
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
