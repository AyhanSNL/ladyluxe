<?php
//todo faturalar sayfasında PDF Olarak gör butonuna tıklandığında ya da resmileştirildiğinde URL'yi siparisin fatura tablosuna yükle... Dosyayı sunucuya çek ve tabloya kaydet.
$currentURL = $ayar['panel_url'].'pages2.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'parasut_fatura';

$pazarSql = $db->prepare("select * from parasut where id=:id ");
$pazarSql->execute(array(
    'id' => '1'
));
$pazar = $pazarSql->fetch(PDO::FETCH_ASSOC);


require_once 'inc/modules/parasut/parasut/parasut_autoload.php';
try {
    $parasutAuthorization = new \Parasut\API\Authorization([
        "development" => false, //development mode
        "client_id" => "$pazar[client_id]",
        "client_secret" => "$pazar[client_secret]",
        "username" => "$pazar[username]",
        "password" => "$pazar[password]",
        "redirect_uri" => "$pazar[redirect_uri]",
        "company_id" => "$pazar[company_id]"
    ]);
} catch (\Parasut\API\Exception $e) {
    echo "Error code : " . $e->getCode()."<br>";
    echo "Error message : " . $e->getMessage();
    die;
}
$invoices = new \Parasut\API\Invoices($parasutAuthorization);



if($_POST) {
    if($yetki['demo'] != '1' ) {
        if($_POST['request'] == 'iptal'  ) {
            $invoice_id = $_POST['fatura_id'];
            $cancelInvoice = $invoices->cancel($invoice_id);
            $guncelle = $db->prepare("UPDATE parasut_fatura SET
                durum=:durum
         WHERE fatura_id={$_POST['fatura_id']}      
        ");
            $sonuc = $guncelle->execute(array(
                'durum' => 'iptal'
            ));
            
            //siparişteki paraşüt bilgilerini sıfırla...
            $guncelle = $db->prepare("UPDATE siparisler SET parasut_kargo_id=:parasut_kargo_id, parasut_id=:parasut_id, parasut_esitle=:parasut_esitle WHERE siparis_no={$_POST['siparis_id']} ");$sonuc = $guncelle->execute(array('parasut_kargo_id' => null, 'parasut_id' => null, 'parasut_esitle' => null));

            //Ürünleri sıfırla...
            $guncelle = $db->prepare("UPDATE siparis_urunler SET parasut_id=:parasut_id WHERE siparis_id={$_POST['siparis_id']} ");$sonuc = $guncelle->execute(array('parasut_id' => null));

            $_SESSION['main_alert']='success';
            header('Location: pages2.php?page=parasut_fatura');
            exit();
        }

        if($_POST['request'] == 'sil'  ) {
            $invoice_id = $_POST['fatura_id'];
            $deleteInvoice = $invoices->delete($invoice_id);
            $silmeislem = $db->prepare("DELETE from parasut_fatura WHERE fatura_id=:fatura_id");
            $sil = $silmeislem->execute(array(
                'fatura_id' => $_POST['fatura_id']
            ));
            //siparişteki paraşüt bilgilerini sıfırla...
            $guncelle = $db->prepare("UPDATE siparisler SET parasut_kargo_id=:parasut_kargo_id, parasut_id=:parasut_id, parasut_esitle=:parasut_esitle WHERE siparis_no={$_POST['siparis_id']} ");$sonuc = $guncelle->execute(array('parasut_kargo_id' => null, 'parasut_id' => null, 'parasut_esitle' => null));
            //Ürünleri sıfırla...
            $guncelle = $db->prepare("UPDATE siparis_urunler SET parasut_id=:parasut_id WHERE siparis_id={$_POST['siparis_id']} ");$sonuc = $guncelle->execute(array('parasut_id' => null));
            $_SESSION['main_alert']='success';
            header('Location: pages2.php?page=parasut_fatura');
            exit();
        }

        if($_POST['request'] == 'resmilestir'  ) {


            $faturabilgileri = $db->prepare("select * from parasut_fatura where fatura_id=:fatura_id ");
            $faturabilgileri->execute(array(
                'fatura_id' => $_POST['fatura_id'],
            ));
            $rowz = $faturabilgileri->fetch(PDO::FETCH_ASSOC);
            $vkn = $rowz['musteri_vn'];
            $musteri_id = $rowz['musteri_id'];
            $checkVKNType = $invoices->check_vkn_type($vkn);


            if (empty($checkVKNType->result))
            {
                //E-ARŞİV...
                $turs = 'earsiv';
                $eArchiveData = [
                    "data" => [
                        "type" => "e_archives",
                        "relationships" => [
                            "sales_invoice" => [
                                "data" => [
                                    "id" => $musteri_id, //invoice_id
                                    "type" => "sales_invoices"
                                ]
                            ]
                        ]
                    ]
                ];
                $createEArchive = $invoices->create_e_archive($eArchiveData);

                $kontrols = $createEArchive->code;
                if($kontrols != '201'  ) {
                    //resmileştirme hatası!
                    echo '
                     <div style="width: 90%; margin: 0 auto;  ">
                        <div class="w-100 border rounded alert alert-danger p-5 text-dark" style="font-size: 16px ;">
                    <strong>Resmileştirme işlemi sırasında hata oluştu!</strong><br> Sadece Canlı ortam API bilgileri ile resmileştirme işlemi yapabilirsiniz!
                    <br><br>
                    <a href="pages2.php?page=parasut_fatura" style="font-weight: 600;">Geri Dön</a>
                        </div>
</div>
                    ';
                    exit();
                }
                $tur_id = $createEArchive->result->data->id;

            }
            else
            {
                //EFATURA
                $turs = 'efatura';
                $checkVKNType = $invoices->check_vkn_type($vkn);
                $eInvoiceAddress = $checkVKNType->result->data[0]->attributes->e_invoice_address;

                $eInvoiceData = [
                    "data" => [
                        "type" => "e_invoices",
                        "attributes" => [
                            'scenario' => 'basic', // basic veya commercial (temel veya ticari)
                            'to' => $eInvoiceAddress
                        ],
                        "relationships" => [
                            "invoice" => [
                                "data" => [
                                    "id" => $musteri_id, //invoice_id
                                    "type" => "sales_invoices"
                                ]
                            ]
                        ]
                    ]
                ];
                $createEInvoice = $invoices->create_e_invoice($eInvoiceData);
                $kontrols = $createEInvoice->code;
                if($kontrols != '201'  ) {
                    //resmileştirme hatası!
                    echo '
                     <div style="width: 90%; margin: 0 auto;  ">
                        <div class="w-100 border rounded alert alert-danger p-5 text-dark" style="font-size: 16px ;">
                    <strong>Resmileştirme işlemi sırasında hata oluştu!</strong><br> Sadece Canlı ortam API bilgileri ile resmileştirme işlemi yapabilirsiniz!
                    <br><br>
                    <a href="pages2.php?page=parasut_fatura" style="font-weight: 600;">Geri Dön</a>
                        </div>
</div>
                    ';
                    exit();
                }
                $tur_id = $createEInvoice->result->data->id;
            }



            //pdf adresini al
            if($turs = 'earsiv'  ) {
                $e_archive_id = $tur_id;
                $URLPdf = $invoices->pdf_e_archive($e_archive_id);
            }else{
                $e_invoice_id = $tur_id;
                $URLPdf = $invoices->pdf_e_invoice($e_invoice_id);
            }

            $guncelle = $db->prepare("UPDATE parasut_fatura SET
                resmi=:resmi,
                tur_id=:tur_id,
                pdf_url=:pdf_url,
                tur=:tur
         WHERE fatura_id={$_POST['fatura_id']}      
        ");
            $sonuc = $guncelle->execute(array(
                'resmi' => '1',
                'tur_id' => $tur_id,
                'pdf_url' => $URLPdf,
                'tur' => $turs
            ));


            $_SESSION['main_alert']='success';
            header('Location: pages2.php?page=parasut_fatura');
            exit();
        }



    }
}
?>
<title>Paraşüt - <?=$diller['parasut-text-6']?> - <?=$panelayar['baslik']?></title>

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
                                <a href="javascript:Void(0)"><i class="fa fa-angle-right"></i> Paraşüt - <?=$diller['parasut-text-6']?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <?php if($yetki['entegrasyon'] == '1' && $yetki['parasut'] == '1') {


            if(isset($_GET['search']) && $_GET['search']== !null  ) {
                $ser = htmlspecialchars(trim($_GET['search']));
                $search = "where (siparis_no like '%$ser%' or fatura_id like '%$ser%') ";
            }else{
                $search = null;
            }

            $Sayfa = @intval($_GET['p']); if(!$Sayfa) $Sayfa = 1;
            $Say = $db->query("select * from  parasut_fatura  $search");
            $ToplamVeri = $Say->rowCount();
            $Limit = 25 ;
            $Sayfa_Sayisi = ceil($ToplamVeri/$Limit); if($Sayfa > $Sayfa_Sayisi){$Sayfa = 1;}
            $Goster = $Sayfa * $Limit - $Limit;
            $GorunenSayfa = 5;
            $islemListele = $db->query("select * from parasut_fatura $search order by id desc limit $Goster,$Limit");
            $islemCek = $islemListele->fetchAll(PDO::FETCH_ASSOC);

            ?>


            <div class="row">


                <!-- Contents !-->
                <div class="col-md-12">
                    <div class="card p-3">
                        <div class="new-buttonu-main-top border-bottom pb-2 mb-0">
                            <div class="new-buttonu-main-left">
                                <h4><img src="assets/images/parsut.png" class="mr-2"> Paraşüt -  <?=$diller['parasut-text-6']?></h4>
                            </div>
                        </div>

                        <!-- Search Form !-->
                        <div class="w-100 pt-2 pb-2  bg-white  mb-2 mt-2 ">
                            <div class="row ">
                                <div class="col-md-7 ">
                                    <?php if(isset($_GET['search'])  && $_GET['search']==!null ) {?>
                                        <h6><?=$diller['adminpanel-text-161']?> : <?=$ToplamVeri?></h6>
                                        <a href="pages2.php?page=parasut_fatura" class="btn btn-sm btn-info shadow"><?=$_GET['search']?> <i class="fa fa-times"></i></a>
                                    <?php }?>
                                </div>
                                <div class="col-md-5 text-right">
                                    <form method="GET" action="pages2.php">
                                        <div class="input-group ">
                                            <input type="hidden" name="page" value="parasut_fatura" >
                                            <input type="text" name="search" class="form-control" placeholder="<?=$diller['parasut-text-8']?>"  aria-describedby="button-addon2" required autocomplete="off">
                                            <div class="input-group-append">
                                                <button class="btn btn-dark rounded-0" type="submit" id="button-addon2"><i class="fa fa-search"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!--  <========SON=========>>> Search Form SON !-->
                        <div class="w-100">
                                <div class="table-responsive ">
                                    <table class="table table-hover  mb-0 table-bordered ">
                                        <thead class="thead-default ">
                                        <tr>
                                            <th></th>
                                            <th scope="col"><?=$diller['parasut-text-25']?></th>
                                            <th scope="col"><?=$diller['adminpanel-text-91']?></th>
                                            <th scope="col"><?=$diller['adminpanel-form-text-901']?></th>
                                            <th scope="col"><?=$diller['adminpanel-form-text-1355']?></th>
                                            <th scope="col"><?=$diller['parasut-text-26']?></th>
                                            <th scope="col"><?=$diller['adminpanel-form-text-1521']?></th>
                                            <th scope="col" style="text-align: center;"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach ($islemCek as $row) {

                                            $siparis = $db->prepare("select * from siparisler where siparis_no=:siparis_no ");
                                            $siparis->execute(array(
                                                'siparis_no' => $row['siparis_no'],
                                            ));

                                            $sip = $siparis->fetch(PDO::FETCH_ASSOC);
                                            if($sip['odeme_tur'] == '2' ) {
                                                $totalfiyat = $sip['havale_toplamtutar'];
                                            }else{
                                                $totalfiyat = $sip['toplam_tutar'];
                                            }

                                            ?>
                                            <tr >
                                                <th class="text-center">
                                                    <?php if($row['durum'] != 'iptal' ) {?>
                                                        <?php if($row['resmi'] == '1' ) {?>
                                                            <div class="btn btn-sm btn-primary shadow-sm  btn-block mb-2">
                                                               <i class="fa fa-check"></i> <?=$diller['parasut-text-28']?>
                                                            </div>
                                                        <?php }?>
                                                        <div class="btn btn-sm btn-success btn-block mb-2">
                                                            <i class="fa fa-check"></i> <?=$diller['parasut-text-27']?>
                                                        </div>
                                                    <?php }else { ?>
                                                        <div class="btn btn-sm btn-danger btn-block mb-2">
                                                            <?=$diller['parasut-text-29']?>
                                                        </div>
                                                    <?php }?>
                                                </th>
                                                <th scope="row"><?=$row['fatura_id']?></th>
                                                <td>
                                                    <a href="pages.php?page=order_detail&orderID=<?=$row['siparis_no']?>" class="border border-primary p-2 rounded" target="_blank">
                                                        #<?=$row['siparis_no']?>
                                                    </a>
                                                </td>
                                                <td><?=$row['aciklama']?></td>
                                                <td><?php echo date_tr('j F Y', ''.$row['tarih'].''); ?></td>
                                                <td><?=$row['musteri_vn']?></td>
                                                <td><?php echo number_format($totalfiyat, 2); ?> <?=$row['doviz']?></td>
                                                <td class="text-right" style="min-width: 100px">
                                                    <?php if($row['resmi'] !='1' ) {?>
                                                        <a  href="javascript:Void(0)" data-id="<?=$row['fatura_id']?>" class="btn btn-sm btn-danger d-block  w-100 silfatura"><?=$diller['adminpanel-text-160']?></a>
                                                        <?php if($row['durum'] != 'iptal' ) {?>
                                                            <a  href="javascript:Void(0)" data-id="<?=$row['fatura_id']?>" class="btn btn-sm btn-light d-block border mt-2 w-100 iptalet"><?=$diller['parasut-text-30']?></a>
                                                            <a  href="javascript:Void(0)" data-id="<?=$row['fatura_id']?>" class="btn btn-sm btn-primary d-block mt-2 w-100 resmilestir"><?=$diller['parasut-text-31']?></a>
                                                        <?php }?>
                                                    <?php }?>
                                                    <?php if($row['resmi'] == '1' ) {?>
                                                        <a href="<?=$row['pdf_url']?>"  target="_blank" class="btn btn-sm btn-info  d-block mt-2"><?=$diller['parasut-text-32']?></a>
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
                                                <li class="page-item "><a class="page-link " href="pages2.php?page=parasut_fatura"><?=$diller['sayfalama-ilk']?></a></li>
                                                <li class="page-item "><a class="page-link " href="pages2.php?page=parasut_fatura&p=<?=$Sayfa - 1?>"><?=$diller['sayfalama-onceki']?></a></li>
                                            <?php } ?>
                                            <?php
                                            for($i = $Sayfa - $GorunenSayfa; $i < $Sayfa + $GorunenSayfa +1; $i++){ if($i > 0 and $i <= $Sayfa_Sayisi){
                                                if($i == $Sayfa){
                                                    ?>
                                                    <li class="page-item active " aria-current="page">
                                                        <a class="page-link" href="pages2.php?page=parasut_fatura&p=<?=$i?>"><?=$i?><span class="sr-only">(current)</span></a>
                                                    </li>
                                                    <?php
                                                }else{
                                                    ?>
                                                    <li class="page-item "><a class="page-link" href="pages2.php?page=parasut_fatura&p=<?=$i?>"><?=$i?></a></li>
                                                    <?php
                                                }
                                            }
                                            }
                                            ?>

                                            <?php if($islemListele->rowCount() <=0) { } else { ?>
                                                <?php if($Sayfa != $Sayfa_Sayisi){?>
                                                    <li class="page-item"><a class="page-link" href="pages2.php?page=parasut_fatura&p=<?=$Sayfa + 1?>"><?=$diller['sayfalama-sonraki']?></a></li>
                                                    <li class="page-item"><a class="page-link" href="pages2.php?page=parasut_fatura&p=<?=$Sayfa_Sayisi?>"><?=$diller['sayfalama-son']?></a></li>
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


<script type='text/javascript'>
    $(document).ready(function(){

        $('.iptalet').click(function(){

            var postID = $(this).data('id');

            // AJAX request
            $.ajax({
                url: 'masterpiece2.php?page=parasut_iptal',
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

        $('.silfatura').click(function(){

            var postID = $(this).data('id');

            // AJAX request
            $.ajax({
                url: 'masterpiece2.php?page=parasut_sil',
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

        $('.resmilestir').click(function(){

            var postID = $(this).data('id');

            // AJAX request
            $.ajax({
                url: 'masterpiece2.php?page=parasut_resmilestir',
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