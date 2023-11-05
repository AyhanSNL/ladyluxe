<?php
if(!isset($_GET['orderID']) && $_GET['orderID'] == null ) { 
 header('Location:pages.php?page=orders');
 exit();
}
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'orders';
$orderDetail = $db->prepare("select * from siparisler where siparis_no=:siparis_no and onay=:onay ");
$orderDetail->execute(array(
    'siparis_no' => $_GET['orderID'],
    'onay' => '1',
));

$row = $orderDetail->fetch(PDO::FETCH_ASSOC);
if($row['parasut_id'] == !null ) {
    header('Location:pages.php?page=orders');
    exit();
}

$sayi = $orderDetail->rowCount();
$pazarSql = $db->prepare("select * from parasut where id=:id ");
$pazarSql->execute(array(
    'id' => '1'
));
$pazar = $pazarSql->fetch(PDO::FETCH_ASSOC);
$kasa_id = $pazar['kasa'];
$siparisno = $_GET['orderID'];


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
            if($_POST['request']=='add'  ) {



                $aciklama  = $_POST['aciklama'];
                $tip = $_POST['fatura_tip'];
                $tarih = $_POST['tarih'];
                $seri_no = $_POST['seri_no'];
                $sira_no = $_POST['sira_no'];
                $doviz = $_POST['doviz'];
                $unvan = $_POST['fatura_unvan'];
                $vd= $_POST['vd'];
                $vn = $_POST['vn'];
                $isim = $_POST['isim'];
                $tc = $_POST['tc'];
                $telefon = $_POST['telefon'];
                $eposta = $_POST['eposta'];
                $adres = $_POST['adres'];
                $ilce = $_POST['ilce'];
                $sehir = $_POST['sehir'];
                $irsaliye = $_POST['irsaliye'];



                if($tip == '1'  ) {
                    $name = $isim;
                    $tax = $tc;
                    $tax_office = null;
                    $musteri_tip = 'person';
                }else{
                    $name = $unvan;
                    $tax = $vn;
                    $tax_office = $vd;
                    $musteri_tip = 'company';
                }




                //önce müşteriyi gönder ve id numarsını al ardından faturayı gönder.
                $contacts = new \Parasut\API\Contacts($parasutAuthorization);
                $createContactData = [
                    "data" => [
                        "type" => "contacts",
                        "attributes" => [
                            "name" => "$name", //*zorunlu //ad soyad
                            "email" => "$eposta", //e-posta
                            "contact_type" => "$musteri_tip", //company, person (tüzel kişi, gerçek kişi)
                            "tax_office" => "$tax_office", //s
                            "tax_number" => "$tax", //vergi numarası
                            "district" => "$ilce", //ilçe
                            "city" => "$sehir", //il
                            "address" => "$adres", //adres
                            "phone" => "$telefon", //tel no
                            "account_type" => "customer" //customer, supplier
                        ]
                    ]
                ];
                $createContact = $contacts->create($createContactData);
                $musteri_post = $createContact->code;
                if($musteri_post != '201'  ) {
                    $_SESSION['main_alert']='musteri_hata';
                    header('Location: pages2.php?page=parasut_fatura_kes&orderID='.$siparisno.'');
                    exit();
                }
                $musteri_id = $createContact->result->data->id;


                $sipBilgi = $db->prepare("select * from siparisler where siparis_no=:siparis_no ");
                $sipBilgi->execute(array(
                    'siparis_no' => $siparisno,
                ));
                $siprow = $sipBilgi->fetch(PDO::FETCH_ASSOC);
                //aratoplam ve indirim toplam...
                $grup_indirim = $row['grup_indirim'];
                $sepette_ek_indirim = $row['sepette_ek_indirim'];
                $ilk_siparis_indirim = $row['ilk_siparis_indirim'];
                $indirim_tutar = $_POST['indirim_tutar'];
                $indirimtoplam = $grup_indirim+$sepette_ek_indirim+$ilk_siparis_indirim+$indirim_tutar;
                if($row['odeme_tur'] == '2' ) {
                 //havale ise..
                    $aratoplam = $siprow['havale_aratutar'];
                    $kargo_tutari = $siprow['havale_kargotutar'];
                    $toplamtutar = $siprow['havale_toplamtutar'];
                }else{
                    //diğerleri ise...
                    $aratoplam = $siprow['ara_tutar'];
                    $kargo_tutari = $siprow['kargo_tutar'];
                    $toplamtutar = $siprow['toplam_tutar'];
                }

                $urun_sirala = $db->prepare("select * from siparis_urunler where siparis_id=:siparis_id ");
                $urun_sirala->execute(array(
                    'siparis_id' => $siparisno,
                ));

                foreach ($urun_sirala as $s){

                    $urungetir = $db->prepare("select kdv_oran from urun where id=:id ");
                    $urungetir->execute(array(
                        'id' => $s['urun_id'],
                    ));
                    $ss = $urungetir->fetch(PDO::FETCH_ASSOC);
                    $kdv = $ss['kdv_oran'];


                    if($row['odeme_tur'] == '2' ) {
                        $kdvsiz_urun_tutar = $s['havale_kdvsiz_tutar'];
                    }else{
                        $kdvsiz_urun_tutar = $s['kdvsiz_tutar'];
                    }

                    //indirim hesabi...
                    if($indirimtoplam>'0'  ) {
                        $urunindirim = ($kdvsiz_urun_tutar / $aratoplam) * $indirimtoplam;
                    }else{
                        $urunindirim = '0';
                    }

                    $urun_arrays[]=
                        [
                            "type" => "sales_invoice_details",
                            "attributes" => [
                                "quantity" => $s['adet'], //birim adedi
                                "unit_price" => $kdvsiz_urun_tutar, //birim fiyatı (kdv'siz fiyatı)
                                "vat_rate" => $ss['kdv_oran'], //kdv oranı
                                "discount_type" => "amount",
                                "discount_value" => $urunindirim,
                                "description" => "$s[urun_baslik]" //ürün açıklaması
                            ],
                            "relationships" => [
                                "product" => [
                                    "data" => [
                                        "id" => $s['parasut_id'], //ürün id
                                        "type" => "products"
                                    ]
                                ]
                            ]
                        ];
                }

                if($kargo_tutari >'0' ) {
                    //Kargo satırı..
                    $urun_arrays[]=
                        [
                            "type" => "sales_invoice_details",
                            "attributes" => [
                                "quantity" => 1, //birim adedi
                                "unit_price" => $kargo_tutari, //birim fiyatı (kdv'siz fiyatı)
                                "vat_rate" => 0, //kdv oranı
                                "description" => "Kargo Bedeli" //ürün açıklaması
                            ],
                            "relationships" => [
                                "product" => [
                                    "data" => [
                                        "id" => $row['parasut_kargo_id'], //ürün id
                                        "type" => "products"
                                    ]
                                ]
                            ]
                        ];
                }



                $createInvoiceData = [
                    "data" => [
                        "type" => "sales_invoices",
                        "attributes" => [
                            "item_type" => "invoice",
                            "description" => "$aciklama", //fatura açıklaması
                            "issue_date" => "$tarih", //düzenleme tarihi
                            "due_date" => "$tarih", //son tahsilat tarihi
                            "invoice_series" => "$seri_no", //fatura seri no
                            "invoice_id" => "$sira_no", //fatura sıra no
                            "currency" => "$doviz", //döviz tipi // TRL, USD, EUR, GBP
                            "shipment_included" => $irsaliye, //irsaliyesiz.
                        ],
                        "relationships" => [
                            "details" => [
                                "data" =>
                                    $urun_arrays,
                            ],
                            "contact" => [
                                "data" => [
                                    "type" => "contacts",
                                    "id" => $musteri_id //müşteri id
                                ]
                            ]
                        ]
                    ]
                ];


                $createInvoice = $invoices->create($createInvoiceData);
                $faturaOK = $createInvoice->code;
                if($faturaOK != '201'  ) {
                    $_SESSION['alert']='parasut_hata_201';
                    header('Location: pages2.php?page=parasut_fatura_kes&orderID='.$siparisno.'');
                    exit();
                }

                $fatura_id = $createInvoice->result->data->id;
                $toplamtutar = $toplamtutar+$kargo_tutari;
                //TAHSİLATI EKLE
                $invoice_id = $fatura_id;
                $payInvoiceData = [
                    "data" => [
                        "type" => "payments",
                        "attributes" => [
                            "account_id" => $_POST['kasa_id'], // Kasa veya Banka id
                            "date" => "$tarih", //ödeme tarihi
                            "amount" => $toplamtutar //ödeme tutarı
                        ]
                    ]
                ];
                $invoices->pay($invoice_id, $payInvoiceData);

                $kaydet = $db->prepare("INSERT INTO parasut_fatura SET
                durum=:durum,
                kasa_id=:kasa_id,
                musteri_id=:musteri_id,
                resmi=:resmi,
                siparis_no=:siparis_no,
                aciklama=:aciklama,
                tarih=:tarih,
                son_tarih=:son_tarih,
                seri_no=:seri_no,
                sira_no=:sira_no,
                doviz=:doviz,
                irsaliye=:irsaliye,
                musteri_vn=:musteri_vn,
                fatura_id=:fatura_id
        ");
                $sonuc = $kaydet->execute(array(
                    'durum' => 'ok',
                    'kasa_id' => $_POST['kasa_id'],
                    'musteri_id' => $musteri_id,
                    'resmi' => '0',
                    'siparis_no' => $siprow['siparis_no'],
                    'aciklama' => $aciklama,
                    'tarih' => $tarih,
                    'son_tarih' => $tarih,
                    'seri_no' => $seri_no,
                    'sira_no' => $sira_no,
                    'doviz' => $doviz,
                    'irsaliye' => $irsaliye,
                    'musteri_vn' => $tax,
                    'fatura_id' => $fatura_id
                ));

                $guncelle = $db->prepare("UPDATE siparisler SET parasut_id=:parasut_id WHERE siparis_no={$siparisno} ");$sonuc = $guncelle->execute(array('parasut_id' => $fatura_id));
                $_SESSION['main_alert'] = 'success';
                header('Location: pages2.php?page=parasut_fatura_kes&orderID='.$siparisno.'');
                exit();


            }
    }
}
?>
<title><?=$diller['parasut-text-7']?> - <?=$panelayar['baslik']?></title>

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
                                <a href="pages.php?page=orders"><i class="fa fa-angle-right"></i><?=$diller['adminpanel-menu-text-17']?></a>
                                <a href="pages.php?page=order_detail&orderID=<?=$row['siparis_no']?>"><i class="fa fa-angle-right"></i> #<?=$row['siparis_no']?> <?=$diller['adminpanel-form-text-1451']?></a>
                                <a href="javascript:Void(0)"><i class="fa fa-angle-right"></i> <?=$diller['parasut-text-7']?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <?php if($yetki['entegrasyon'] == '1' && $yetki['parasut'] == '1' && $yetki['siparis'] == '1' && $yetki['siparis_yonet'] == '1') {



           if($row['parasut_esitle'] != '1' ) {


                $products = new \Parasut\API\Products($parasutAuthorization);

                $ur = $db->prepare("select * from siparis_urunler where siparis_id=:siparis_id ");
                $ur->execute(array(
                    'siparis_id' => $siparisno,
                ));
                $doviz = $row['parabirimi'];
                if($doviz == 'TRY'  ) {
                    $doviz = 'TRL';
                }else{
                    $doviz = $doviz;
                }
                foreach ($ur as $s){
                    $urungetir = $db->prepare("select kdv_oran from urun where id=:id ");
                    $urungetir->execute(array(
                            'id' => $s['urun_id'],
                    ));
                    $ss = $urungetir->fetch(PDO::FETCH_ASSOC);
                    $kdv = $ss['kdv_oran'];
                    $productData = [
                        "data" => [
                            "type" => "products",
                            "attributes" => [
                                "name" => "$s[urun_baslik]", //ürün adı
                                "vat_rate" => $kdv, //KDV oranı
                                "unit" => "Adet", //birim
                                "currency" => "$doviz", //döviz tipi
                                "inventory_tracking" => true, //stok durumu
                                "initial_stock_count" => 1000 //stok adedi
                            ]
                        ]
                    ];
                    $createProduct = $products->create($productData);
                    $parasut_id = $createProduct->result->data->id;
                    //ürünün paraşüt idsini güncelle...
                    $guncelle = $db->prepare("UPDATE siparis_urunler SET parasut_id=:parasut_id WHERE id={$s['id']} ");$sonuc = $guncelle->execute(array('parasut_id' => $parasut_id));
                }

            if($row['odeme_tur'] == '2' ) {
                $kargotutar = $row['havale_kargotutar'];
            }else{
                $kargotutar = $row['kargo_tutar'];
            }

            if($kargotutar > '0' ) {
                //Kargo bedeli var ise....
                $productData = [
                    "data" => [
                        "type" => "products",
                        "attributes" => [
                            "name" => "Kargo Bedeli", //ürün adı
                            "vat_rate" => 0, //KDV oranı
                            "unit" => "Adet", //birim
                            "currency" => "$doviz", //döviz tipi
                            "inventory_tracking" => true, //stok durumu
                            "initial_stock_count" => 1000 //stok adedi
                        ]
                    ]
                ];
                $createProduct = $products->create($productData);
                $kargo_parasut_id = $createProduct->result->data->id;
                $guncelle = $db->prepare("UPDATE siparisler SET parasut_kargo_id=:parasut_kargo_id WHERE siparis_no={$siparisno} ");$sonuc = $guncelle->execute(array('parasut_kargo_id' => $kargo_parasut_id));
            }

               $guncelle = $db->prepare("UPDATE siparisler SET parasut_esitle=:parasut_esitle WHERE siparis_no={$siparisno} ");$sonuc = $guncelle->execute(array('parasut_esitle' => '1'));




           }


            ?>

                <!-- Contents !-->
                    <div class="row">

                        <div class="col-md-12 mb-3">
                                <a href="pages.php?page=orders" class="btn btn-dark   btn-sm  " >
                                    <i class="fa fa-arrow-left"></i> <?=$diller['adminpanel-text-138']?>
                                </a>
                        </div>
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class=" w-100 p-3">

                                        <div class="pl-4 pr-4 pt-0 pb-0">
                                            <h3><img src="assets/images/parsut.png"> <?=$diller['parasut-text-7']?> </h3>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-md-12  pb-3 border pt-3 bg-light  ">
                                                <?php if($sayi>'0'  ) {?>
                                                    <div class="text-dark pl-4 pr-4 pt-3 pb-3" style="font-size: 16px ;">
                                                        <strong>#<?=$_GET['orderID']?> <?=$diller['parasut-text-15']?></strong><br> <?=$diller['parasut-text-14']?>
                                                    </div>
                                                <?php }else { ?>
                                                    <div class="text-dark pl-4 pr-4 pt-1 pb-1">
                                                        Geçerli sipariş numarası gereklidir.
                                                    </div>
                                                <?php }?>
                                            </div>
                                            <div class="w-100 alert alert-warning border border-warning border-top-0 col-md-12 pt-3 pb-3 pl-5 pr-5 text-dark rounded-0" style="font-size: 14px ;">
                                              <?=$diller['parasut-text-13']?>
                                            </div>
                                            <?php if(isset($_GET['orderID'])  ) {?>
                                                <?php if($sayi <= '0'  ) {?>
                                                    <div class="col-md-12 pl-4 pr-4 pt-1 pb-1">
                                                        <a href="pages.php?page=orders" class="btn btn-dark"><?=$diller['adminpanel-text-138']?></a>
                                                    </div>
                                                <?php }else {
                                                    //Her şey OK... işlemler burda...
                                                    $musteri_tip = $row['fatura_turu'];
                                                    ?>
                                                    <div class="col-md-12">
                                                        <form action="" method="post">
                                                            <input type="hidden" name="request" value="add">
                                                            <input type="hidden" name="siparis_no" value="<?=$siparisno?>">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="w-100  p-3">
                                                                        <div class="row">
                                                                            <div class="col-md-12 form-group">
                                                                                <label for="aciklama"><?=$diller['parasut-text-16']?></label>
                                                                                <input type="text" name="aciklama" value="<?=$_GET['orderID']?> Numaralı Sipariş Faturası" id="aciklama" required class="form-control">
                                                                            </div>
                                                                            <div class="col-md-12 form-group">
                                                                                <label for="kasa"><?=$diller['parasut-text-9']?>
                                                                                    <div style="font-size: 11px ; font-weight: 400; color: #999;">
                                                                                        <?=$diller['parasut-text-10']?>
                                                                                    </div>
                                                                                </label>
                                                                                <input type="text" name="kasa_id" value="<?=$kasa_id?>" id="kasa" required class="form-control">
                                                                            </div>
                                                                            <div class="col-md-6 form-group">
                                                                                <div class="w-100 border rounded  p-3 ">
                                                                                    <div class="row">
                                                                                        <div class="col-md-12 ">
                                                                                            <h5><?=$diller['adminpanel-form-text-1548']?></h5>
                                                                                            <hr>
                                                                                        </div>

                                                                                        <?php if($row['uye_id'] == null && $row['adres_fatura_farkli'] == '0' ) {
                                                                                            $musteri_tip= '1';
                                                                                            ?>
                                                                                            <div class="col-md-12 ">
                                                                                                <div class="custom-control custom-radio custom-control-inline">
                                                                                                    <input type="radio" class="custom-control-input minimal" id="bireysel" name="fatura_tip" value="1" <?php if($musteri_tip == '1'  ) { ?>checked<?php }?>>
                                                                                                    <label class="custom-control-label" for="bireysel"><?=$diller['adminpanel-form-text-1320']?></label>
                                                                                                </div>
                                                                                                <div class="custom-control custom-radio custom-control-inline">
                                                                                                    <input type="radio" class="custom-control-input minimal" id="kurumsal" name="fatura_tip" value="2" <?php if($musteri_tip == '2'  ) { ?>checked<?php }?>>
                                                                                                    <label class="custom-control-label" for="kurumsal"><?=$diller['adminpanel-form-text-1321']?></label>
                                                                                                </div>
                                                                                                <hr>
                                                                                            </div>
                                                                                        <?php }?>

                                                                                        <?php if($row['uye_id'] == null && $row['adres_fatura_farkli'] == '1' ) {
                                                                                            if($row['fatura_turu'] == '1' ) {
                                                                                                $musteri_tip= '1';
                                                                                            }
                                                                                            if($row['fatura_turu'] == '2' ) {
                                                                                                $musteri_tip= '2';
                                                                                            }
                                                                                            ?>
                                                                                            <div class="col-md-12 ">
                                                                                                <div class="custom-control custom-radio custom-control-inline">
                                                                                                    <input type="radio" class="custom-control-input minimal" id="bireysel" name="fatura_tip" value="1" <?php if($musteri_tip == '1'  ) { ?>checked<?php }?>>
                                                                                                    <label class="custom-control-label" for="bireysel"><?=$diller['adminpanel-form-text-1320']?></label>
                                                                                                </div>
                                                                                                <div class="custom-control custom-radio custom-control-inline">
                                                                                                    <input type="radio" class="custom-control-input minimal" id="kurumsal" name="fatura_tip" value="2" <?php if($musteri_tip == '2'  ) { ?>checked<?php }?>>
                                                                                                    <label class="custom-control-label" for="kurumsal"><?=$diller['adminpanel-form-text-1321']?></label>
                                                                                                </div>
                                                                                                <hr>
                                                                                            </div>
                                                                                        <?php }?>

                                                                                        <?php if($row['uye_id'] == !null  ) {?>
                                                                                            <div class="col-md-12 ">
                                                                                                <div class="custom-control custom-radio custom-control-inline">
                                                                                                    <input type="radio" class="custom-control-input minimal" id="bireysel" name="fatura_tip" value="1" <?php if($musteri_tip == '1'  ) { ?>checked<?php }?>>
                                                                                                    <label class="custom-control-label" for="bireysel"><?=$diller['adminpanel-form-text-1320']?></label>
                                                                                                </div>
                                                                                                <div class="custom-control custom-radio custom-control-inline">
                                                                                                    <input type="radio" class="custom-control-input minimal" id="kurumsal" name="fatura_tip" value="2" <?php if($musteri_tip == '2'  ) { ?>checked<?php }?>>
                                                                                                    <label class="custom-control-label" for="kurumsal"><?=$diller['adminpanel-form-text-1321']?></label>
                                                                                                </div>
                                                                                                <hr>
                                                                                            </div>
                                                                                        <?php }?>


                                                    <?php if($row['uye_id'] == null && $row['adres_fatura_farkli'] == '0' ) {
                                                        ?>

                                                        <div class="col-md-12 ">
                                                            <div class="  radio-content" data-radio="1" style="display:none">
                                                                <div class="row">
                                                                    <div class="col-md-6  form-group">
                                                                        <label for=""><?=$diller['adminpanel-text-92']?></label>
                                                                        <input type="text" name="isim" value="<?=$row['isim']?> <?=$row['soyisim']?>" id=""  class="form-control">
                                                                    </div>
                                                                    <div class="col-md-6  form-group">
                                                                        <label for="">TC No</label>
                                                                        <input type="text" name="tc" value="<?=$row['tc_no']?>" id=""  class="form-control">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class=" radio-content" data-radio="2" style="display:none">
                                                                <div class="row">
                                                                    <div class="col-md-6  form-group">
                                                                        <label for="fatura_unvan"><?=$diller['adminpanel-form-text-1317']?></label>
                                                                        <input type="text" name="fatura_unvan" value="<?=$row['fatura_unvan']?>" id="fatura_unvan"  class="form-control">
                                                                    </div>
                                                                    <div class="col-md-6  form-group">
                                                                        <label for="vd"><?=$diller['adminpanel-form-text-1318']?></label>
                                                                        <input type="text" name="vd" value="<?=$row['vd']?>" id="vd"  class="form-control">
                                                                    </div>
                                                                    <div class="col-md-12  form-group">
                                                                        <label for="vn"><?=$diller['adminpanel-form-text-1319']?></label>
                                                                        <input type="text" name="vn" value="<?=$row['vn']?>" id="vn"  class="form-control">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 form-group">
                                                            <label for="telefon"><?=$diller['adminpanel-form-text-81']?></label>
                                                            <input type="text" name="telefon" value="<?=$row['telefon']?>" id="telefon" required class="form-control">
                                                        </div>
                                                        <div class="col-md-6 form-group">
                                                              <label for="eposta"><?=$diller['adminpanel-form-text-83']?></label>
                                                            <input type="text" name="eposta" value="<?=$row['eposta']?>" id="eposta" required class="form-control">
                                                        </div>
                                                        <div class="col-md-6 form-group">
                                                            <label for="sehir"><?=$diller['parasut-text-17']?></label>
                                                            <input type="text" name="sehir" value="<?=$row['sehir']?>" id="sehir" required class="form-control">
                                                        </div>
                                                        <div class="col-md-6 form-group">
                                                            <label for="ilce"><?=$diller['parasut-text-18']?></label>
                                                            <input type="text" name="ilce" value="<?=$row['ilce']?>" id="ilce" required class="form-control">
                                                        </div>
                                                        <div class="col-md-12 form-group">
                                                            <label for="adres"><?=$diller['adminpanel-form-text-1279']?></label>
                                                            <textarea name="adres" id="adres" class="form-control" rows="3" required><?=$row['adresbilgisi']?></textarea>
                                                        </div>
                                                        <?php } ?>


                                                    <?php if($row['uye_id'] == null && $row['adres_fatura_farkli'] == '1' ) {
                                                        ?>
                                                        <div class="col-md-12 ">
                                                            <div class="  radio-content" data-radio="1" style="display:none">
                                                                <div class="row">
                                                                    <div class="col-md-6  form-group">
                                                                        <label for=""><?=$diller['adminpanel-text-92']?></label>
                                                                        <input type="text" name="isim" value="<?=$row['fatura_isim']?> <?=$row['fatura_soyisim']?>" id=""  class="form-control">
                                                                    </div>
                                                                    <div class="col-md-6  form-group">
                                                                        <label for="">TC No</label>
                                                                        <input type="text" name="tc" value="<?=$row['fatura_tc']?>" id=""  class="form-control">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class=" radio-content" data-radio="2" style="display:none">
                                                                <div class="row">
                                                                    <div class="col-md-6  form-group">
                                                                        <label for="fatura_unvan"><?=$diller['adminpanel-form-text-1317']?></label>
                                                                        <input type="text" name="fatura_unvan" value="<?=$row['fatura_firma_unvan']?>" id="fatura_unvan"  class="form-control">
                                                                    </div>
                                                                    <div class="col-md-6  form-group">
                                                                        <label for="vd"><?=$diller['adminpanel-form-text-1318']?></label>
                                                                        <input type="text" name="vd" value="<?=$row['fatura_vergi_dairesi']?>" id="vd"  class="form-control">
                                                                    </div>
                                                                    <div class="col-md-12  form-group">
                                                                        <label for="vn"><?=$diller['adminpanel-form-text-1319']?></label>
                                                                        <input type="text" name="vn" value="<?=$row['fatura_vergi_no']?>" id="vn"  class="form-control">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 form-group">
                                                            <label for="telefon"><?=$diller['adminpanel-form-text-81']?></label>
                                                            <input type="text" name="telefon" value="<?=$row['telefon']?>" id="telefon" required class="form-control">
                                                        </div>
                                                        <div class="col-md-6 form-group">
                                                              <label for="eposta"><?=$diller['adminpanel-form-text-83']?></label>
                                                            <input type="text" name="eposta" value="<?=$row['eposta']?>" id="eposta" required class="form-control">
                                                        </div>
                                                        <div class="col-md-6 form-group">
                                                            <label for="sehir"><?=$diller['parasut-text-17']?></label>
                                                            <input type="text" name="sehir" value="<?=$row['fatura_sehir']?>" id="sehir" required class="form-control">
                                                        </div>
                                                        <div class="col-md-6 form-group">
                                                            <label for="ilce"><?=$diller['parasut-text-18']?></label>
                                                            <input type="text" name="ilce" value="<?=$row['fatura_ilce']?>" id="ilce" required class="form-control">
                                                        </div>
                                                        <div class="col-md-12 form-group">
                                                            <label for="adres"><?=$diller['adminpanel-form-text-1279']?></label>
                                                            <textarea name="adres" id="adres" class="form-control" rows="3" required><?=$row['fatura_adresi']?></textarea>
                                                        </div>
                                                        <?php } ?>


                                                                                        <?php if($row['uye_id'] == !null  ) {?>
                                                                                            <div class="col-md-12 ">
                                                                                                <div class="  radio-content" data-radio="1" style="display:none">
                                                                                                    <div class="row">
                                                                                                        <div class="col-md-6  form-group">
                                                                                                            <label for=""><?=$diller['adminpanel-text-92']?></label>
                                                                                                            <input type="text" name="isim" value="<?=$row['fatura_isim']?> <?=$row['fatura_soyisim']?>" id=""  class="form-control">
                                                                                                        </div>
                                                                                                        <div class="col-md-6  form-group">
                                                                                                            <label for="">TC No</label>
                                                                                                            <input type="text" name="tc" value="<?=$row['fatura_tc']?>" id=""  class="form-control">
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class=" radio-content" data-radio="2" style="display:none">
                                                                                                    <div class="row">
                                                                                                        <div class="col-md-6  form-group">
                                                                                                            <label for="fatura_unvan"><?=$diller['adminpanel-form-text-1317']?></label>
                                                                                                            <input type="text" name="fatura_unvan" value="<?=$row['fatura_firma_unvan']?>" id="fatura_unvan"  class="form-control">
                                                                                                        </div>
                                                                                                        <div class="col-md-6  form-group">
                                                                                                            <label for="vd"><?=$diller['adminpanel-form-text-1318']?></label>
                                                                                                            <input type="text" name="vd" value="<?=$row['fatura_vergi_dairesi']?>" id="vd"  class="form-control">
                                                                                                        </div>
                                                                                                        <div class="col-md-12  form-group">
                                                                                                            <label for="vn"><?=$diller['adminpanel-form-text-1319']?></label>
                                                                                                            <input type="text" name="vn" value="<?=$row['fatura_vergi_no']?>" id="vn"  class="form-control">
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-md-6 form-group">
                                                                                                <label for="telefon"><?=$diller['adminpanel-form-text-81']?></label>
                                                                                                <input type="text" name="telefon" value="<?=$row['telefon']?>" id="telefon" required class="form-control">
                                                                                            </div>
                                                                                            <div class="col-md-6 form-group">
                                                                                                <label for="eposta"><?=$diller['adminpanel-form-text-83']?></label>
                                                                                                <input type="text" name="eposta" value="<?=$row['eposta']?>" id="eposta" required class="form-control">
                                                                                            </div>
                                                                                            <div class="col-md-6 form-group">
                                                                                                <label for="sehir"><?=$diller['parasut-text-17']?></label>
                                                                                                <input type="text" name="sehir" value="<?=$row['fatura_sehir']?>" id="sehir" required class="form-control">
                                                                                            </div>
                                                                                            <div class="col-md-6 form-group">
                                                                                                <label for="ilce"><?=$diller['parasut-text-18']?></label>
                                                                                                <input type="text" name="ilce" value="<?=$row['fatura_ilce']?>" id="ilce" required class="form-control">
                                                                                            </div>
                                                                                            <div class="col-md-12 form-group">
                                                                                                <label for="adres"><?=$diller['adminpanel-form-text-1279']?></label>
                                                                                                <textarea name="adres" id="adres" class="form-control" rows="3" required><?=$row['fatura_adresi']?></textarea>
                                                                                            </div>
                                                                                        <?php }?>





                                                                                        <script>
                                                                                            var elems = $(':radio.minimal');
                                                                                            elems.change(function() {
                                                                                                var v = $(elems).filter(':checked').val();
                                                                                                var continer = $('.radio-content');
                                                                                                //Hide all
                                                                                                continer.hide();
                                                                                                continer.filter('[data-radio=' + v + ']').show();
                                                                                            }).change();

                                                                                        </script>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6 form-group">
                                                                                <div class="w-100 border rounded  p-3 ">
                                                                                    <div class="row">
                                                                                        <div class="col-md-12 ">
                                                                                            <h5><?=$diller['parasut-text-19']?></h5>
                                                                                            <hr>
                                                                                        </div>
                                                                                        <div class="col-md-12 ">
                                                                                            <div class="custom-control custom-radio custom-control-inline">
                                                                                                <input type="radio" class="custom-control-input minimal" id="1" name="irsaliye" value="1" >
                                                                                                <label class="custom-control-label" for="1"><?=$diller['parasut-text-20']?></label>
                                                                                            </div>
                                                                                            <div class="custom-control custom-radio custom-control-inline">
                                                                                                <input type="radio" class="custom-control-input minimal" id="0" name="irsaliye" value="0" checked>
                                                                                                <label class="custom-control-label" for="0"><?=$diller['parasut-text-21']?></label>
                                                                                            </div>
                                                                                            <hr>
                                                                                        </div>
                                                                                        <?php
                                                                                        $duz_tarih = date('Y-m-d');
                                                                                        $doviz = $row['parabirimi'];
                                                                                        if($doviz == 'TRY'  ) {
                                                                                            $doviz = 'TRL';
                                                                                        }else{
                                                                                            $doviz = $doviz;
                                                                                        }
                                                                                        ?>
                                                                                        <div class="col-md-12 form-group">
                                                                                            <label for="tarih"><?=$diller['adminpanel-form-text-1355']?></label>
                                                                                            <input class="form-control" name="tarih" id="date_first_coupon" data-date-format="yyyy-mm-dd" value="<?=$duz_tarih?>" type="text"  />
                                                                                        </div>

                                                                                        <div class="col-md-6 form-group">
                                                                                            <label for="seri_no"><?=$diller['parasut-text-22']?></label>
                                                                                            <input type="text" name="seri_no"  id="seri_no"  class="form-control">
                                                                                        </div>
                                                                                        <div class="col-md-6 form-group">
                                                                                            <label for="sira_no"><?=$diller['parasut-text-23']?></label>
                                                                                            <input type="text" name="sira_no" id="sira_no"  class="form-control">
                                                                                        </div>
                                                                                        <div class="col-md-12 form-group">
                                                                                            <label for="doviz"><?=$diller['adminpanel-form-text-2021']?></label>
                                                                                            <select name="doviz" class="form-control" id="doviz" required>
                                                                                                <option value="TRL" <?php if($doviz == 'TRL'  ) { ?>selected<?php }?>>TRY</option>
                                                                                                <option value="USD" <?php if($doviz == 'USD'  ) { ?>selected<?php }?>>USD</option>
                                                                                                <option value="EUR" <?php if($doviz == 'EUR'  ) { ?>selected<?php }?>>EUR</option>
                                                                                                <option value="GBP" <?php if($doviz == 'GBP'  ) { ?>selected<?php }?>>GBP</option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                        </div>

                                                                    </div>

                                                                </div>
                                                                <div class="col-md-12 form-group text-center ml-3 mr-3">
                                                                    <button class="btn btn-success btn-block" style="height: 50px; font-weight: 500;" ><?=$diller['parasut-text-24']?></button>
                                                                </div>
                                                            </div>

                                                        </form>

                                                    </div>
                                                <?php }?>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <!--  <========SON=========>>> Contents SON !-->


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