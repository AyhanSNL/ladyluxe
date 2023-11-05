<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'smspost';

?>
<title><?=$diller['adminpanel-menu-text-37']?> - <?=$panelayar['baslik']?></title>
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
                                <a href="pages.php?page=newsletter"><i class="fa fa-angle-right"></i> <?=$diller['adminpanel-menu-text-37']?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <?php if($yetki['kampanya'] == '1' && $yetki['sms_yonet'] == '1' ) {?>


            <div class="row">

                <?php include 'inc/modules/_helper/campaign_leftbar.php'; ?>
                <!-- Contents !-->
                <?php if($sms['durum'] == '1' ) {?>
                    <form class="<?php if($panelayar['panel_nav'] == '1'   ) { ?>col-md-9<?php }else{?>col-md-12<?php } ?>" method="post" action="post.php?process=sms_list_post&status=sms_post">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body p-4">
                                        <div class="w-100 d-flex flex-column pb-2">
                                            <div>
                                                <a href="pages.php?page=sms_numbers" class="btn btn-outline-dark btn-sm  d-inline-block"><i class="fas fa-envelope"></i> <?=$diller['adminpanel-menu-text-36']?></a>
                                            </div>
                                        </div>
                                        <div class="w-100 border-bottom d-flex align-items-center justify-content-between flex-wrap pb-2 ">
                                            <h4><?=$diller['adminpanel-menu-text-37']?></h4>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-12 form-group">
                                                <label for="gsm_select"><?=$diller['adminpanel-form-text-1244']?></label>
                                                <select name="gsm_select" class="form-control" id="gsm_select" required>
                                                    <option value="0"><?=$diller['adminpanel-form-text-1251']?></option>
                                                    <option value="1"><?=$diller['adminpanel-form-text-1252']?></option>
                                                </select>
                                            </div>
                                            <div id="special-choose" class="col-md-12 form-group" style="display:none; ">
                                                <div class="bg-light p-3 border rounded  up-arrow-2">
                                                    <label for="gsm_select">* <?=$diller['adminpanel-form-text-1253']?></label>
                                                    <select class="mail_account_select form-control col-md-12" name="gsm[]" multiple  id="gsm_select" style="width: 100%!important;" >
                                                    </select>
                                                </div>
                                            </div>
                                            <script>
                                                $('#gsm_select').on('change', function() {
                                                    $('#special-choose').css('display', 'none');
                                                    if ( $(this).val() === '1' ) {
                                                        $('#special-choose').css('display', 'block');
                                                    }
                                                });
                                            </script>
                                            <div class="form-group col-md-12">
                                                <label for="icerik">
                                                    * <?=$diller['adminpanel-form-text-1255']?>
                                                </label>
                                                <textarea name="icerik" id="icerik" class="form-control"></textarea>
                                            </div>
                                        </div>

                                        <adiv class="row ">
                                            <div class="col-md-12">
                                                <button class="btn  btn-success btn-block" id="waitButton" name="smsPost"><?=$diller['adminpanel-text-350']?></button>
                                            </div>
                                        </adiv>
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
                                <?=$diller['adminpanel-modal-text-22']?>
                            </div>
                            <div class="mt-3">
                                <a href="pages.php?page=sms_settings" target="_blank" class="btn btn-dark"><i class="fa fa-arrow-right"></i> <?=$diller['adminpanel-menu-text-39']?></a>
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
            placeholder: ' <?=$diller['adminpanel-form-text-1254']?>',
            ajax: {
                url: 'masterpiece.php?page=sms_number_select',
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
