<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'code';
?>
<title><?=$diller['adminpanel-menu-text-170']?> - <?=$panelayar['baslik']?></title>

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
                                <a href="javascript:Void(0)"><i class="fa fa-angle-right"></i> <?=$diller['adminpanel-menu-text-151']?></a>
                                <a href="pages.php?page=code"><i class="fa fa-angle-right"></i> <?=$diller['adminpanel-menu-text-170']?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <?php if($yetki['site_ayarlar'] == '1' &&  $yetki['ayar_diger'] == '1') {?>


            <div class="row">

                <?php include 'inc/modules/_helper/settings_leftbar.php'; ?>

                <!-- Contents !-->
                <div class="<?php if($panelayar['panel_nav'] == '1'   ) { ?>col-md-9<?php }else{?>col-md-12<?php } ?>">
                    <div class="card p-4">
                        <form method="post" action="post.php?process=code_post&status=update" enctype="multipart/form-data">
                            <div class="w-100">
                                <div class="w-100 text-left  mb-1 pb-2">
                                    <h4><?=$diller['adminpanel-menu-text-170']?></h4>
                                    <span class="font-14"><?=$diller['adminpanel-text-264']?></span>
                                    <div class="w-100 bg-light  p-2  mb-2 mt-2">
                                      <?=$diller['adminpanel-text-265']?>
                                    </div>
                                </div>
                               <div class="row">
                                    <div class="form-group pl-3 pr-3 col-md-12">
                                        <div class="w-100 border border-dark border-top-0 border-bottom-0">
                                            <textarea name="js_kodlar" id="code" class="form-control " rows="3" ><?=$ayar['js_kodlar']?></textarea>
                                            <script>
                                                var nonEmpty = false;
                                                var editor = CodeMirror.fromTextArea(document.getElementById("code"), {
                                                    mode: "application/xml",
                                                    styleActiveLine: true,
                                                    lineNumbers: true,
                                                    lineWrapping: true
                                                });

                                                function toggleSelProp() {
                                                    nonEmpty = !nonEmpty;
                                                    editor.setOption("styleActiveLine", {nonEmpty: nonEmpty});
                                                    var label = nonEmpty ? 'Disable nonEmpty option' : 'Enable nonEmpty option';
                                                    document.getElementById('toggleButton').innerText = label;
                                                }
                                            </script>
                                        </div>

                                    </div>
                               </div>
                            </div>
                            <div class="w-100 pt-2">
                                <button class="btn btn-success btn-block" name="update">
                                    <?=$diller['adminpanel-form-text-53']?>
                                </button>
                            </div>
                        </form>
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
