<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'mailpost';

if(isset($_GET['toInbox'])  ) {
 if($_GET['toInbox'] >'0'  ) {

     $mesajcek = $db->prepare("select * from mesaj where id=:id ");
     $mesajcek->execute(array(
             'id' => $_GET['toInbox'],
     ));

     if($mesajcek->rowCount()>'0'  ) {
      $mesajRow = $mesajcek->fetch(PDO::FETCH_ASSOC);
     }else{
         header('Location:'.$ayar['panel_url'].'pages.php?page=newsletter');
     }

 }else{
   header('Location:'.$ayar['panel_url'].'pages.php?page=newsletter');
 }
}

?>
<title><?=$diller['adminpanel-menu-text-33']?> - <?=$panelayar['baslik']?></title>

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
                                <a href="javascript:Void(0)"><i class="fa fa-angle-right"></i> <?=$diller['adminpanel-menu-text-30']?></a>
                                <a href="pages.php?page=newsletter"><i class="fa fa-angle-right"></i> <?=$diller['adminpanel-menu-text-33']?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <?php if($yetki['kampanya'] == '1' && $yetki['eposta_yonet'] == '1' ) {?>


            <div class="row">

                <?php include 'inc/modules/_helper/campaign_leftbar.php'; ?>
                <!-- Contents !-->
                <?php if($ayar['smtp_durum'] == '1' ) {?>
                    <form class="<?php if($panelayar['panel_nav'] == '1'   ) { ?>col-md-9<?php }else{?>col-md-12<?php } ?>" method="post" action="post.php?process=email_list_post&status=mail_post">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body p-4">
                                        <div class="w-100 d-flex flex-column pb-2">
                                            <div>
                                                <a href="pages.php?page=email_list" class="btn btn-outline-dark btn-sm  d-inline-block"><i class="fas fa-envelope"></i> <?=$diller['adminpanel-menu-text-32']?></a>
                                            </div>
                                        </div>
                                        <div class="w-100 border-bottom d-flex align-items-center justify-content-between flex-wrap pb-2 ">
                                            <h4><?=$diller['adminpanel-menu-text-33']?></h4>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-12 form-group">
                                                <label for="sablon"><?=$diller['adminpanel-form-text-1247']?></label>
                                                <select name="sablon" class="form-control " id="sablon" >
                                                    <option value="0"><?=$diller['adminpanel-form-text-1246']?></option>
                                                    <option value="1"><?=$diller['adminpanel-form-text-1245']?></option>
                                                </select>
                                            </div>
                                            <?php if(isset($_GET['toInbox'])  ) {?>
                                                <div class="form-group col-md-12">
                                                    <label for="baslik">
                                                        * <?=$diller['adminpanel-form-text-1744']?>
                                                    </label>
                                                    <input type="hidden" name="adress_select" value="1" >
                                                    <input type="text" name="eposta[]" autocomplete="off" value="<?=$mesajRow['eposta']?>" readonly  id="eposta"  class="form-control">
                                                </div>
                                            <?php }else { ?>
                                                <div class="col-md-12 form-group">
                                                    <label for="adress_select"><?=$diller['adminpanel-form-text-1244']?></label>
                                                    <select name="adress_select" class="form-control" id="adress_select" required>
                                                        <option value="0"><?=$diller['adminpanel-form-text-1243']?></option>
                                                        <option value="1"><?=$diller['adminpanel-form-text-1242']?></option>
                                                    </select>
                                                </div>
                                                <div id="special-choose" class="col-md-12 form-group" style="display:none; ">
                                                    <div class="bg-light p-3 border rounded  up-arrow-2">
                                                        <label for="adress_select">* <?=$diller['adminpanel-form-text-1241']?></label>
                                                        <select class="mail_account_select form-control col-md-12" name="eposta[]" multiple  id="adress_select" style="width: 100%!important;" >
                                                        </select>
                                                    </div>
                                                </div>
                                                <script>
                                                    $('#adress_select').on('change', function() {
                                                        $('#special-choose').css('display', 'none');
                                                        if ( $(this).val() === '1' ) {
                                                            $('#special-choose').css('display', 'block');
                                                        }
                                                    });
                                                </script>
                                            <?php }?>
                                            <div class="form-group col-md-12">
                                                <label for="baslik">
                                                    * <?=$diller['adminpanel-form-text-1248']?>
                                                </label>
                                                <input type="text" name="baslik" autocomplete="off"  id="baslik"  class="form-control">
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="icerik">
                                                    * <?=$diller['adminpanel-form-text-1240']?>
                                                </label>
                                                <?php if(isset($_GET['toInbox'])  ) {?>
                                                    <textarea name="icerik" id="tiny3"><br><br><div style="width: 100%; background-color: #f8f8f8; border: 1px solid #EBEBEB; color: #000; box-sizing: border-box; padding: 15px; font-size: 12px;"><strong><?=$diller['adminpanel-form-text-1743']?></strong><br><br><?=$mesajRow['mesaj']?></div></textarea>
                                                <?php }else { ?>
                                                    <textarea name="icerik" id="tiny3"></textarea>
                                                <?php }?>
                                            </div>
                                        </div>

                                        <div class="row ">
                                            <div class="col-md-12">
                                                <button class="btn  btn-success btn-block" id="waitButton" name="mailPost"><?=$diller['adminpanel-text-350']?></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                <?php }else { ?>
                <div class="<?php if($panelayar['panel_nav'] == '1'   ) { ?>col-md-9<?php }else{?>col-md-12<?php } ?> ">
                    <div class="card">
                        <div class="card-body">
                            <div style="font-size: 14px ; border-bottom: 1px solid #EBEBEB;" class="alert-warning text-dark border border-warning p-3 rounded">
                                <?=$diller['adminpanel-modal-text-25']?>
                            </div>
                            <div class="mt-3">
                                <a href="pages.php?page=smtp_settings" target="_blank" class="btn btn-dark"><i class="fa fa-arrow-right"></i> <?=$diller['adminpanel-menu-text-35']?></a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php }?>
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
    $(document).ready(function() {
        $('.mail_account_select').select2({
            maximumSelectionLength: 999,
            placeholder: ' <?=$diller['adminpanel-form-text-1239']?>',
            ajax: {
                url: 'masterpiece.php?page=mail_account_select',
                dataType: 'json',
                delay: 250,
                data: function (data) {
                    return {
                        q: data.term
                    };
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }

        });
    });
</script>
<script>

    $(document).ready(function(){0<$("#tiny3").length&&tinymce.init({selector:"textarea#tiny3",
        height:300,
        <?php if($panelayar['editor_dil'] == 'tr' ) {?>
        language: 'tr_TR',
        <?php }?>
        plugins:["advlist autolink link   lists charmap print preview hr anchor  image  spellchecker","searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime  ","save  contextmenu directionality emoticons  paste textcolor"],
        toolbar:"insertfile undo redo | code | fontsizeselect | bold italic forecolor backcolor | image | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect | print preview fullpage | emoticons",
        fontsize_formats: "11px 12px 13px 14px 15px 16px 18px 20px 24px 30px 36px 45px 55px",
        external_plugins: { "filemanager" : "../assets/responsive_filemanager/filemanager/plugin.min.js"},
        style_formats:[{title:"Bold text",inline:"b"},{title:"Red text",inline:"span",styles:{color:"#ff0000"}},{title:"Red header",block:"h1",styles:{color:"#ff0000"}},{title:"Example 1",inline:"span",classes:"example1"},{title:"Example 2",inline:"span",classes:"example2"},{title:"Table styles"},{title:"Table row 1",selector:"tr",classes:"tablerow1"}]})});



</script>