<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'users_group';

if(isset($_GET['p']) && $_GET['p'] == !null ) {
    $sayfa = '&p='.$_GET['p'].'';
}else{
    $sayfa = null;
}



?>
<title><?=$diller['adminpanel-menu-text-27']?> - <?=$panelayar['baslik']?></title>

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
                                <a href="pages.php?page=users_group"><i class="fa fa-angle-right"></i><?=$diller['adminpanel-menu-text-27']?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <?php if($yetki['uyelik'] == '1' && $yetki['uye_yonet'] == '1') {


            $Sayfa = @intval($_GET['p']); if(!$Sayfa) $Sayfa = 1;
            $Say = $db->query("select * from uyeler_grup ");
            $ToplamVeri = $Say->rowCount();
            $Limit = 20;
            $Sayfa_Sayisi = ceil($ToplamVeri/$Limit); if($Sayfa > $Sayfa_Sayisi){$Sayfa = 1;}
            $Goster = $Sayfa * $Limit - $Limit;
            $GorunenSayfa = 5;
            $islemListele = $db->query("select * from uyeler_grup order by id DESC limit $Goster,$Limit");
            $islemCek = $islemListele->fetchAll(PDO::FETCH_ASSOC);


            ?>


            <div class="row">


                <?php include 'inc/modules/_helper/users_leftbar.php'; ?>

                <!-- Contents !-->
                <div class="col-md-12">
                    <div class="card p-3">
                        <div class="new-buttonu-main-top ">
                            <div class="new-buttonu-main-left">
                                <h4> <?=$diller['adminpanel-menu-text-27']?></h4>
                            </div>
                            <div class="new-buttonu-main">
                                <a  class="btn btn-primary text-white "  href="pages.php?page=users_settings"><i class="fa fa-wrench"></i> <?=$diller['adminpanel-menu-text-29']?></a>
                                <a  class="btn btn-secondary text-white "  href="pages.php?page=users"><i class="fa fa-users"></i> <?=$diller['adminpanel-menu-text-26']?></a>
                                <a  class="btn btn-success text-white "  data-toggle="collapse" data-target="#genelAcc" aria-expanded="false" aria-controls="collapseForm"><i class="fas fa-plus-circle "></i> <?=$diller['adminpanel-form-text-1338']?></a>
                            </div>
                        </div>
                        <div id="accordion" class="accordion">
                        <div class="collapse" id="genelAcc" data-parent="#accordion">
                            <div class="w-100 border pl-3 pr-3 pt-3 mb-3  ">
                            <form action="post.php?process=users_post&status=group_add" method="post" >
                                <div class="row ">
                                    <div class="form-group col-md-12 text-center bg-white text-dark mt-n3  border-bottom mb-0 ">
                                        <h5> <?=$diller['adminpanel-form-text-1338']?></h5>
                                    </div>
                                </div>
                                <div class="row mt-3 justify-content-center">
                                    <div class="form-group col-md-6">
                                        <label for="baslik"><?=$diller['adminpanel-form-text-1339']?></label>
                                        <input type="text" autocomplete="off"  name="baslik" id="baslik" required class="form-control">
                                    </div>
                                </div>
                                <div class="row justify-content-center">
                                    <div class="form-group col-md-6 ">
                                        <label for="fiyat"><?=$diller['adminpanel-form-text-1340']?></label>
                                        <select name="fiyat_tip" class="form-control" id="fiyat" required>
                                            <option value="0"><?=$diller['adminpanel-form-text-1341']?></option>
                                            <option value="1"><?=$diller['adminpanel-form-text-1342']?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row justify-content-center">
                                    <div class="form-group col-md-6 mb-3 ">
                                        <label for="ozel_indirim"><?=$diller['adminpanel-form-text-1971']?></label>
                                        <select name="ozel_indirim" class="form-control" id="ozel_indirim" required>
                                            <option value="0"><?=$diller['adminpanel-form-text-1972']?></option>
                                            <option value="1"><?=$diller['adminpanel-form-text-1973']?></option>
                                        </select>
                                    </div>
                                </div>



                                <div id="myself-choise" class="w-100" style="display:none">
                                    <div class="row justify-content-center">
                                        <div class="form-group col-md-6 mb-5">
                                            <label for="indirim_oran"><?=$diller['adminpanel-form-text-1218']?></label>
                                            <div class="input-group mb-2">
                                                <input type="text" class="form-control" autocomplete="off" id="indirim_oran" name="indirim_oran" placeholder="<?=$diller['adminpanel-form-text-1660']?>">
                                                <div class="input-group-append">
                                                    <div class="input-group-text font-12 font-weight-bold">
                                                        <div id="oran">
                                                            <i class="fas fa-percent"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <script>
                                    $('#ozel_indirim').on('change', function() {
                                        $('#myself-choise').css('display', 'none');
                                        if ( $(this).val() === '1' ) {
                                            $('#myself-choise').css('display', 'block');
                                        }
                                    });
                                </script>



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
                            <div class="table-responsive ">
                                <table class="table table-hover mb-0  ">
                                    <thead class="thead-default">
                                    <tr>
                                        <th><?=$diller['adminpanel-form-text-1339']?></th>
                                        <th><?=$diller['adminpanel-form-text-1340']?></th>
                                        <th class="text-center"><?=$diller['adminpanel-form-text-1971']?></th>
                                        <th  class="text-center" width="100"><?=$diller['adminpanel-text-157']?></th>
                                    </tr>
                                    </thead>
                                    <tbody  >
                                    <?php foreach ($islemCek as $row) {
                                        ?>
                                        <tr >
                                            <td style="font-weight: 500; min-width: 125px">
                                                <?=$row['baslik']?>
                                            </td>
                                            <td style=" min-width: 125px">
                                                <?php if($row['fiyat_tip'] == '0' ) {?>
                                                <?=$diller['adminpanel-form-text-1341']?>
                                                <?php }?>
                                                <?php if($row['fiyat_tip'] == '1' ) {?>
                                                   <div class="btn btn-outline-primary btn-sm">
                                                       <?=$diller['adminpanel-form-text-1342']?>
                                                   </div>
                                                <?php }?>
                                            </td>
                                            <td style="font-weight: 500; min-width: 125px; text-align: center;">
                                              <a class=" bg-white border border-danger text-danger rounded btn btn-sm " style="width: 100px; display: inline-block">
                                                  %<?php echo number_format($row['indirim_oran'], 0); ?>
                                              </a>
                                            </td>
                                            <td class="text-right" style="min-width: 100px">
                                                <a href="javascript:Void(0)" data-id="<?=$row['id']?>" class="btn btn-sm btn-primary duzenleAjax" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-text-159']?>"><i class="fa fa-eye" ></i></a>
                                                <?php if($ToplamVeri > '1') {?>
                                                    <a href="" data-href="post.php?process=users_post&status=group_delete&no=<?=$row['id']?>"  data-toggle="modal" data-target="#confirm-delete"  class="btn btn-sm btn-danger "><i class="fa fa-trash" ></i></a>
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
                                    <div class="border-top"> </div>
                                    <div class="w-100  p-3 ">
                                        <i class="fa fa-ban"></i> <?=$diller['adminpanel-text-162']?>
                                    </div>
                                <?php }?>






                            <!---- Sayfalama Elementleri ================== !-->
                            <?php if($ToplamVeri > $Limit  ) {?>
                                <div id="SayfalamaElementi" class="w-100 p-2  border-bottom bg-light  ">
                                    <?php if($Sayfa >= 1){?>
                                    <nav aria-label="Page navigation example " >
                                        <ul class="pagination pagination-sm justify-content-end mb-0 ">
                                            <?php } ?>
                                            <?php if($Sayfa > 1){  ?>
                                                <li class="page-item "><a class="page-link " href="pages.php?page=users_group"><?=$diller['sayfalama-ilk']?></a></li>
                                                <li class="page-item "><a class="page-link " href="pages.php?page=users_group&p=<?=$Sayfa - 1?>"><?=$diller['sayfalama-onceki']?></a></li>
                                            <?php } ?>
                                            <?php
                                            for($i = $Sayfa - $GorunenSayfa; $i < $Sayfa + $GorunenSayfa +1; $i++){ if($i > 0 and $i <= $Sayfa_Sayisi){
                                                if($i == $Sayfa){
                                                    ?>
                                                    <li class="page-item active " aria-current="page">
                                                        <a class="page-link" href="pages.php?page=users_group&p=<?=$i?>"><?=$i?><span class="sr-only">(current)</span></a>
                                                    </li>
                                                    <?php
                                                }else{
                                                    ?>
                                                    <li class="page-item "><a class="page-link" href="pages.php?page=users_group&p=<?=$i?>"><?=$i?></a></li>
                                                    <?php
                                                }
                                            }
                                            }
                                            ?>

                                            <?php if($islemListele->rowCount() <=0) { } else { ?>
                                                <?php if($Sayfa != $Sayfa_Sayisi){?>
                                                    <li class="page-item"><a class="page-link" href="pages.php?page=users_group&p=<?=$Sayfa + 1?>"><?=$diller['sayfalama-sonraki']?></a></li>
                                                    <li class="page-item"><a class="page-link" href="pages.php?page=users_group&p=<?=$Sayfa_Sayisi?>"><?=$diller['sayfalama-son']?></a></li>
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
<!-- Editable Modal !-->
<script type='text/javascript'>
    $(document).ready(function(){

        $('.duzenleAjax').click(function(){

            var postID = $(this).data('id');

            // AJAX request
            $.ajax({
                url: 'masterpiece.php?page=users_group_edit',
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

