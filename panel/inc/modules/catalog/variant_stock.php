<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
if(isset($_GET['group_status']) ) {
    if ($yetki['demo'] != '1') {

        if($_GET['group_status'] == 'stock_delete'  ) {
            $VarSorgu = $db->prepare("select * from detay_varyant_stok where id=:id ");
            $VarSorgu->execute(array(
                'id' => $_GET['item_id']
            ));
            if($VarSorgu->rowCount()>'0'  ) {
                $silmeislem = $db->prepare("DELETE from detay_varyant_stok WHERE id=:id");
                $sil = $silmeislem->execute(array(
                    'id' => $_GET['item_id']
                ));
                if ($sil) {
                    header('Location:'.$ayar['panel_url'].'pages.php?page=product_detail_variant&productID='.$_GET['productID'].'&address=stock');
                }else {
                    echo 'veritabanı hatası';
                }
            }else{
                header('Location:'.$ayar['site_url'].'404');
            }
        }

    }else{
        header('Location:'.$ayar['panel_url'].'pages.php?page=product_detail_variant&productID='.$_GET['productID'].'');
    }
}
?>
<?php if($variantList->rowCount()>'0'  ) {
    $stokVaryantGrup = $db->prepare("select * from detay_varyant where urun_id=:urun_id");
    $stokVaryantGrup->execute(array(
            'urun_id' => $row['id'],
    ));
    ?>
    <div class="col-md-12  ">
        <a href="" class="btn btn-primary btn-block d-flex align-items-center justify-content-start" style="text-align: left !important; border-radius: 4px 4px 0 0; padding-top: 20px; font-size: 15px ; padding-bottom: 20px;" data-toggle="collapse" data-target="#stokAcc" aria-expanded="false" aria-controls="collapseForm">
            <div class="spinner-grow text-white mr-2" role="status" style="width: 10px; height: 10px">
                <span class="sr-only">Loading...</span>
            </div>
            <?=$diller['adminpanel-form-text-1830']?>
        </a>
    </div>
    <div id="accordion_stock" class="accordion w-100">
        <div class="collapse <?php if(isset($_GET['stock_search'])) { ?>show<?php }?>" id="stokAcc" data-parent="#accordion_stock">
            <div class="col-md-12">
                <div class="border border-primary  mb-3 pt-0 pb-3 pr-3 pl-3">
                    <div class="row">
                        <div class="mb-3 p-3 alert-warning text-dark w-100 border-bottom border-warning text-center " style="font-size: 13px ;">
                            <?=$diller['adminpanel-form-text-1831']?>
                        </div>
                    </div>
                    <form action="post.php?process=catalog_post&status=product_post" method="post" enctype="multipart/form-data" >
                        <input type="hidden" name="tab" value="variant_stock_add" >
                        <input type="hidden" name="product_id" value="<?=$row['id']?>" >
                        <div class="row d-flex align-items-center justify-content-center">
                            <div class="col-md-4 form-group">
                                <label for="stok_name">* <?=$diller['adminpanel-form-text-1758']?></label>
                                <input type="text" name="stok_name" autocomplete="off"  id="stok_name" required class="form-control">
                            </div>
                            <div class="col-md-2 form-group">
                                <label for="stok_adet">* <?=$diller['adminpanel-form-text-1759']?></label>
                                <input type="number" name="stok_adet"  id="stok_adet" required class="form-control">
                            </div>
                        </div>
                        <?php foreach ($stokVaryantGrup as $stokGrupRow) {
                            $stokVaryant = $db->prepare("select * from detay_varyant_ozellik where varyant_id=:varyant_id and urun_id=:urun_id ");
                            $stokVaryant->execute(array(
                                    'varyant_id' => $stokGrupRow['varyant_id'],
                                    'urun_id' => $row['id']
                            ));
                            ?>
                            <div class="row d-flex align-items-center justify-content-center">
                                <div class="col-md-6 form-group">
                                    <label for="gruplar<?=$stokGrupRow['id']?>"><?=$stokGrupRow['baslik']?></label>
                                    <select name="gruplar[]" class="form-control selet2" id="gruplar<?=$stokGrupRow['id']?>" required style="width: 100%;  ">
                                        <?php foreach ($stokVaryant as $stokRow) {?>
                                            <option value="<?=$stokRow['id']?>"><?=$stokRow['baslik']?></option>
                                        <?php }?>
                                    </select>
                                </div>
                            </div>
                        <?php }?>
                        <div class="row d-flex align-items-center justify-content-center">
                           <div class="col-md-6">
                               <button class="btn btn-block btn-success mb-2 " name="stockAdd">
                                   <?=$diller['adminpanel-form-text-1832']?>
                               </button>
                           </div>
                       </div>
                    </form>
                    <?php
                    if(isset($_GET['stock_search']) && $_GET['stock_search'] == !null  ) {
                        $stockGet = "and stok_kodu='$_GET[stock_search]'";
                    }else{
                        $stockGet = null;
                    }
                    $StokSql = $db->prepare("select * from detay_varyant_stok where urun_id=:urun_id $stockGet");
                    $StokSql->execute(array(
                            'urun_id' => $row['id'],
                    ));
                    ?>
                    <?php if($StokSql->rowCount()>'0'  ) {?>
                    <div class="row mt-3">
                       <div class="col-md-12 border-top" >
                            <div class="pt-3 d-flex align-items-center justify-content-between flex-wrap">
                               <h5> <?=$diller['adminpanel-form-text-1833']?></h5>
                                <div class="row mb-2">
                                    <form method="get" action="pages.php">
                                        <input type="hidden" name="page" value="product_detail_variant" >
                                        <input type="hidden" name="productID" value="<?=$row['id']?>" >
                                        <div class="col-md-12 d-flex align-items-center justify-content-start flex-wrap">
                                            <?php if(isset($_GET['stock_search'])  ) {?>
                                                <a href="pages.php?page=product_detail_variant&productID=<?=$row['id']?>&address=stock" class="btn btn-primary rounded-0 mr-2" style="height: 30px; line-height: normal ">
                                                    <i class="fa fa-times"></i> <?=$diller['adminpanel-form-text-1114']?>
                                                </a>
                                            <?php }?>
                                            <input type="text" name="stock_search" placeholder="<?=$diller['adminpanel-form-text-1834']?>" value="<?=$_GET['stock_search']?>" autocomplete="off"  required  style=" border:0; border-bottom: 1px solid #6c757d; height: 30px">
                                            <button class="btn btn-sm btn-secondary rounded-0" style="height: 30px">
                                                <i class="fa fa-search"></i>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                       </div>

                        <div class="col-md-12">

                            <?php foreach ($StokSql as $stock) {
                                
                                $stockForeach = $stock['varyant'];
                                $stockForeach = explode(',', $stockForeach);
                                
                                ?>
                                <div class="border p-3 rounded mb-3 shadow-sm">
                                    <div class="row">
                                        <div class="col-md-7 d-flex flex-wrap align-items-center justify-content-start">
                                            <?php foreach ($stockForeach as $fors) {
                                                $stokVaryantDeger = $db->prepare("select * from detay_varyant_ozellik where id=:id ");
                                                $stokVaryantDeger->execute(array(
                                                    'id' => $fors,
                                                ));
                                                $n = $stokVaryantDeger->fetch(PDO::FETCH_ASSOC);
                                                ?>
                                                <?php if($stokVaryantDeger->rowCount()>'0'  ) {?>
                                                    <div class="btn  btn-light border shadow-sm rounded-0  m-1">
                                                       <i class="fa fa-caret-right"></i> <?=$n['baslik']?>
                                                    </div>
                                                <?php }?>
                                            <?php }?>
                                        </div>
                                        <div class="col-md-5 text-right">
                                            <div class="btn btn-sm btn-outline-secondary rounded m-1 rounded-0" style="font-size: 13px ;">
                                                <?=$diller['adminpanel-form-text-1758']?> : <strong><?=$stock['stok_kodu']?></strong>
                                            </div>
                                            <div class="btn btn-sm btn-outline-danger rounded m-1 rounded-0" style="font-size: 13px ;">
                                                <?=$diller['adminpanel-form-text-1759']?> : <strong><?=$stock['stok']?></strong>
                                            </div>
                                            <a href="javascript:Void(0)" data-id="<?=$stock['id']?>" class="btn btn-sm btn-primary rounded m-1 rounded-0 duzenleAjax2" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-text-159']?>" style="font-size: 14px ;">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <a href="" data-href="pages.php?page=product_detail_variant&productID=<?=$row['id']?>&group_status=stock_delete&item_id=<?=$stock['id']?>" data-toggle="modal" data-target="#confirm-delete" class="btn btn-sm btn-danger rounded m-1 rounded-0" style="font-size: 14px ;">
                                                <i class="fa fa-times"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            <?php }?>


                        </div>
                    </div>
                    <?php }else { ?>
                        <div class="row mt-3">
                            <?php if(isset($_GET['stock_search'])  ) {?>

                                <div class="col-md-12 border-top" >
                                    <div class="pt-3 text-center ">
                                        <div class="w-100" style="font-size: 16px ; font-weight: 500; margin-bottom: 15px;" >
                                            <?=$diller['adminpanel-text-162']?>
                                        </div>
                                        <a href="pages.php?page=product_detail_variant&productID=<?=$row['id']?>&address=stock" class="btn btn-primary rounded-0 mr-2" style="height: 30px; line-height: normal ">
                                            <i class="fa fa-times"></i> <?=$diller['adminpanel-form-text-1114']?>
                                        </a>
                                    </div>
                                </div>
                            <?php }else { ?>
                                <div class="col-md-12 border-top" >
                                    <div class="pt-3 ">
                                        <h5> <?=$diller['adminpanel-form-text-1833']?></h5>
                                        <div >
                                            <?=$diller['adminpanel-form-text-1835']?>
                                        </div>
                                    </div>
                                </div>
                            <?php }?>
                        </div>
                    <?php }?>
                </div>
            </div>
        </div>
    </div>
    <div class="mb-3"></div>
<?php }?>
