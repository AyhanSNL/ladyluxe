<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php if(isset($_GET['orderID']) && $_GET['orderID'] >'0' && $_GET['orderID'] == !null  ) {?>
    <?php
    $sablonCek = $db->prepare("select * from print_tema where modul=:modul and varsayilan=:varsayilan ");
    $sablonCek->execute(array(
        'modul' => 'invoice',
        'varsayilan' => '1'
    ));
    $t = $sablonCek->fetch(PDO::FETCH_ASSOC);
    $siparisCek = $db->prepare("select * from siparisler where siparis_no=:siparis_no ");
    $siparisCek->execute(array(
        'siparis_no' => $_GET['orderID'],
    ));
    $s = $siparisCek->fetch(PDO::FETCH_ASSOC);

    $sDurum = $db->prepare("select baslik from siparis_durumlar where id=:id ");
    $sDurum->execute(array(
        'id' => $s['siparis_durum'],
    ));
    $sdur = $sDurum->fetch(PDO::FETCH_ASSOC);
    $orderStatus = $sdur['baslik'];

    /* Parabirimi Çek */
    $paraBir = $db->prepare("select * from para_birimleri where kod=:kod ");
    $paraBir->execute(array(
            'kod' => $s['parabirimi'],
    ));
    $para = $paraBir->fetch(PDO::FETCH_ASSOC);
    /*  <========SON=========>>> Parabirimi Çek SON */
    
    /* Ödeme Türleri Çek */
    if($s['odeme_tur'] == !null ) {
        if($s['odeme_tur'] == '1'  ) {
            $odemeTur = $diller['adminpanel-text-97'];
        }
        if($s['odeme_tur'] == '2'  ) {
            $odemeTur = $diller['adminpanel-text-98'];
        }
        if($s['odeme_tur'] == '3'  ) {
            $odemeTur = $diller['adminpanel-text-99'];
        }
        if($s['odeme_tur'] == '4'  ) {
            $odemeTur = $diller['adminpanel-text-100'];
        }
        if($s['odeme_tur'] == 'free'  ) {
            $odemeTur = $diller['adminpanel-text-342'];
        }
    }
    /*  <========SON=========>>> Ödeme Türleri Çek SON */

    /* Tarih İşleri */
    $originalDate = $s['siparis_tarih'];
    $OrderDate = date("d.m.Y ", strtotime($originalDate));

    $PrintDate = date('Y-m-d');
    $PrintHour = date('G:i:s');
    /*  <========SON=========>>> Tarih İşleri SON */

    /* Kargo Sorguları */
    if($s['kargo_sekli'] == '0' ) {
        if($s['kargo_firma'] == !null ) {
            $kargoCek = $db->prepare("select * from kargo_firma where id=:id ");
            $kargoCek->execute(array(
                'id' => $s['kargo_firma'],
            ));
            $kargo = $kargoCek->fetch(PDO::FETCH_ASSOC);
            $CargoCompany = $kargo['baslik'];
        }else{
            $CargoCompany = null;
        }
    }else{
        $CargoCompany = null;
    }

    if($s['odeme_tur'] == '2' ) {
        $kargoTutar = number_format($s['havale_kargotutar'], 2) .' '.''.$para['sag_simge'].'';
    }else{
        $kargoTutar = number_format($s['kargo_tutar'], 2);
    }

    if($s['kapida_odeme_bedeli'] == !null ) {
        $EkKargoUcret = number_format($s['kapida_odeme_bedeli'], 2) .' '.''.$para['sag_simge'].'';
    }else{
        $EkKargoUcret = null;
    }
    /*  <========SON=========>>> Kargo Sorguları SON */

    if($s['indirim_tutar'] > '0' ) {
     $indirimTutar =  number_format($s['indirim_tutar'], 2) .' '.''.$para['sag_simge'].'';
    }else{
        $indirimTutar = '0.00';
    }

    /* KDV Tutar */
    if($s['odeme_tur'] == '2' ) {
        if($s['havale_kdvtutar'] > '0' ) {
            $KdvTutar =  number_format($s['havale_kdvtutar'], 2) .' '.''.$para['sag_simge'].'';
        }else{
            $KdvTutar = '0.00';
        }
    }else{
        if($s['kdv_tutar'] > '0' ) {
            $KdvTutar =  number_format($s['kdv_tutar'], 2) .' '.''.$para['sag_simge'].'';
        }else{
            $KdvTutar = '0.00';
        }
    }
    /*  <========SON=========>>> KDV Tutar SON */


    /* Toplam Tutar */
    if($s['odeme_tur'] == '2' ) {
        if($s['havale_toplamtutar'] > '0' ) {
            $ToplamTutar =  number_format($s['havale_toplamtutar'], 2) .' '.''.$para['sag_simge'].'';
            $TextToplamTutar = (sayiyiYaziyaCevir($s['havale_toplamtutar'],2,$para['sag_simge'],$para['bozuk_para'],"",null,null,null));
        }else{
            $ToplamTutar = '0.00';
            $TextToplamTutar = null;
        }
        if($s['havale_aratutar'] > '0' ) {
            $OrderSubTotal =  number_format($s['havale_aratutar'], 2) .' '.''.$para['sag_simge'].'';
        }else{
            $OrderSubTotal = '0.00';
        }
    }else{
        if($s['toplam_tutar'] > '0' ) {
            $ToplamTutar =  number_format($s['toplam_tutar'], 2) .' '.''.$para['sag_simge'].'';
            $TextToplamTutar = (sayiyiYaziyaCevir($s['toplam_tutar'],2,$para['sag_simge'],$para['bozuk_para'],"",null,null,null));
        }else{
            $ToplamTutar = '0.00';
            $TextToplamTutar =null;
        }
        if($s['ara_tutar'] > '0' ) {
            $OrderSubTotal =  number_format($s['ara_tutar'], 2) .' '.''.$para['sag_simge'].'';
        }else{
            $OrderSubTotal = '0.00';
        }
    }
    /*  <========SON=========>>> Toplam Tutar SON */

    /* Teslimat Adres & Bilgi */
    $ulkeler = $db->prepare("select * from ulkeler where 3_iso=:3_iso ");
    $ulkeler->execute(array(
            '3_iso' => $s['ulke'],
    ));
    $ulk = $ulkeler->fetch(PDO::FETCH_ASSOC);
    $ulkeler2 = $db->prepare("select * from ulkeler where 3_iso=:3_iso ");
    $ulkeler2->execute(array(
        '3_iso' => $s['fatura_ulke'],
    ));
    $ulk2 = $ulkeler2->fetch(PDO::FETCH_ASSOC);
    $ulke = $ulk['baslik'];
    $ulke2 = $ulk2['baslik'];
    /*  <========SON=========>>> Teslimat Adres & Bilgi SON */
    
    /* Fatura Adresi İşlemleri */
    if($s['adres_fatura_farkli'] == '0' ) {
        $billingName = $s['isim'].' '.$s['soyisim'];
        $billingTC = $s['tc_no'];
        $BillingCity = ''.$s['ilce'].' '.'/'.$s['sehir'].' '.'/'.$ulke.'';
        $BillingAddress = $s['adresbilgisi'];
    }else{
        if($s['fatura_turu']  == '1' ) {
         /* bireysel */
            $billingName = $s['fatura_isim'].' '.$s['fatura_soyisim'];
            $billingTC = $s['fatura_tc'];
        }else{
            /* kurumsal */
            $billingName = $s['fatura_firma_unvan'];
            $billingTax = $s['fatura_vergi_dairesi'];
            $BillingNumberTax = $s['fatura_vergi_no'];
        }
        $BillingCity = ''.$s['fatura_ilce'].' '.'/'.$s['fatura_sehir'].' '.'/'.$ulke2.'';
        $BillingAddress = $s['fatura_adresi'];
    }
    /*  <========SON=========>>> Fatura Adresi İşlemleri SON */
    
    /* Ürün Başlık */
    $urunbaslikFOr = $db->prepare("select * from siparis_urunler where siparis_id=:siparis_id ");
    $urunbaslikFOr->execute(array(
        'siparis_id' => $s['siparis_no'],
    ));
    foreach ($urunbaslikFOr as $baslikRow){
        $ProductName .= $baslikRow['urun_baslik'].'<br>';
    }
    /*  <========SON=========>>> Ürün Başlık SON */

/* Ürün Quantity */
    $quantityFor = $db->prepare("select * from siparis_urunler where siparis_id=:siparis_id ");
    $quantityFor->execute(array(
        'siparis_id' => $s['siparis_no'],
    ));
    foreach ($quantityFor as $q){
        $productQuantity .= $q['adet'].'<br>';
    }
/*  <========SON=========>>> Ürün Quantity SON */


    /* Ürün Birim Fiyat */
    if($s['odeme_tur'] == '2' ) {
        $birimFor = $db->prepare("select * from siparis_urunler where siparis_id=:siparis_id ");
        $birimFor->execute(array(
            'siparis_id' => $s['siparis_no'],
        ));
        foreach ($birimFor as $bir){
            $productBirim .= number_format($bir['havale_kdvsiz_tutar'], 2) .' '.''.$para['sag_simge'].''.'</br>';
        }
    }else{
        $birimFor = $db->prepare("select * from siparis_urunler where siparis_id=:siparis_id ");
        $birimFor->execute(array(
            'siparis_id' => $s['siparis_no'],
        ));
        foreach ($birimFor as $bir){
            $productBirim .=  number_format($bir['kdvsiz_tutar'], 2) .' '.''.$para['sag_simge'].' '.'</br>';
        }
    }
    /*  <========SON=========>>> Ürün Birim Fiyat SON */

    /* Total Ürün Fiyat */
    if($s['odeme_tur'] == '2' ) {
        $totalFor = $db->prepare("select * from siparis_urunler where siparis_id=:siparis_id ");
        $totalFor->execute(array(
            'siparis_id' => $s['siparis_no'],
        ));
        foreach ($totalFor as $tot){
            $productTotalAmount .= number_format(($tot['havale_kdvsiz_tutar']+$tot['havale_kdv_tutar'])*$tot['adet'], 2) .' '.''.$para['sag_simge'].''.'</br>';
        }
    }else{
        $totalFor = $db->prepare("select * from siparis_urunler where siparis_id=:siparis_id ");
        $totalFor->execute(array(
            'siparis_id' => $s['siparis_no'],
        ));
        foreach ($totalFor as $tot){
            $productTotalAmount .= number_format(($tot['kdvsiz_tutar']+$tot['kdv_tutar'])*$tot['adet'], 2) .' '.''.$para['sag_simge'].''.'</br>';
        }
    }
    /*  <========SON=========>>> Total Ürün Fiyat SON */

    /* Total Ürün KDV */
    if($s['odeme_tur'] == '2' ) {
        $totalVatrPro = $db->prepare("select * from siparis_urunler where siparis_id=:siparis_id ");
        $totalVatrPro->execute(array(
            'siparis_id' => $s['siparis_no'],
        ));
        foreach ($totalVatrPro as $vatt){
            $productVat .= number_format($vatt['havale_kdv_tutar'], 2) .' '.''.$para['sag_simge'].''.'</br>';
        }
    }else{
        $totalVatrPro = $db->prepare("select * from siparis_urunler where siparis_id=:siparis_id ");
        $totalVatrPro->execute(array(
            'siparis_id' => $s['siparis_no'],
        ));
        foreach ($totalVatrPro as $vatt){
            $productVat .= number_format($vatt['kdv_tutar'], 2) .' '.''.$para['sag_simge'].''.'</br>';
        }
    }
    /*  <========SON=========>>> Total Ürün KDV SON */

    /* Değişkenler */
    $printCode = $t['kod'];
    $printCode  = $printCode;
    $eski   = array(
        '{OrderNumber}',
        '{OrderNumberBarcode}',
        '{OrderType}',
        '{OrderDate}',
        '{PrintDate}',
        '{PrintHour}',
        '{ShippingCompany}',
        '{TrackCode}',
        '{ShippingAmount}',
        '{ShippingExtraAmount}',  
        '{DiscountAmount}',
        '{OrderVatTotal}',
        '{OrderTotal}',
        '{TextOrderTotal}', 
        '{ShippingName}',
        '{ShippingPhone}',
        '{ShippingMail}',
        '{ShippingAddress}',
        '{ShippingCity}',
        '{BillingName}',
        '{BillingID}',
        '{BillingTax}',
        '{BillingNumberTax}',
        '{BillingCity}',
        '{BillingAddress}',
        '{Currency}',
        '{OrderSubTotal}',
        '{ProductName}',
        '{OrderStatus}',
        '{ProductQuantity}',
        '{ProductCountAmount}',
        '{ProductTotalAmount}',
        '{ProductVat}',
    );
    $yeni   = array(
        ''.$s['siparis_no'].'',
        ''.addslashes('<img alt="testing" src="inc/barcode.php?text='.$s['siparis_no'].'&print=true" />').'',
        ''.$odemeTur.'',
        ''.$OrderDate.'' ,
        ''.$PrintDate.'',
        ''.$PrintHour.'',
        ''.$CargoCompany.'',
        ''.$s['kargo_takip'].'',
        ''.$kargoTutar.'',
        ''.$EkKargoUcret.'',
        ''.$indirimTutar.'',
        ''.$KdvTutar.'',
        ''.$ToplamTutar.'',
        ''.$TextToplamTutar.'', 
        ''.$s['isim'].$s['soyisim'].'',
        ''.$s['telefon'].'',
        ''.$s['eposta'].'',
        ''.$s['adresbilgisi'].'',
        ''.$s['ilce'].' '.'/'.$s['sehir'].' '.'/'.$ulke.'',
        ''.$billingName.'',
        ''.$billingTC.'',
        ''.$billingTax.'',
        ''.$BillingNumberTax.'',
        ''.$BillingCity.'',
        ''.$BillingAddress.'',
        ''.$para['sag_simge'].'',
        ''.$OrderSubTotal.'',
        ''.$ProductName.'',
        ''.$orderStatus.'',
        ''.$productQuantity.'',
        ''.$productBirim.'',
        ''.$productTotalAmount.'',
        ''.$productVat.'',
    );
    $printCode = str_replace($eski, $yeni, $printCode);
    /*  <========SON=========>>> Değişkenler SON */
    ?>

    <?php if($siparisCek->rowCount()>'0'  ) {?>
        <?php if($sablonCek->rowCount()>'0'  ) {?>
            <title><?=$diller['adminpanel-form-text-1435']?> </title>
            <link href="plugins/printDesignerMy/css/designer.css" rel="stylesheet" type="text/css" />
            <style>
                #print-designer-canvas{
                    background-color: #ccc !important;
                    border: 0;
                    width: <?=$t['width']?>mm;
                    height: <?=$t['height']?>mm;
                    padding: 0;
                }
                .print-designer-paper-wrapper .print-designer-paper{
                    border: 0 !important;
                }
                .toolbar-selected{
                    box-shadow: none !important;
                }
                .print-designer-paper-item p{
                    padding: 0;
                    margin:0
                }
            </style>

            <link href="plugins/printDesignerMy/css/colorset.css" rel="stylesheet" type="text/css" />
            <link href="assets/css/icons.css" rel="stylesheet" type="text/css" />
            <link rel="stylesheet" href="../assets/css/line-awesome/css/line-awesome.min.css">
            <script src="assets/js/jquery.min.js"></script>
            <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

            <script>
                ; (function ($, window, document) {
                    "use strict";

                    var pluginName = 'PrintDesigner',
                        defaults = {
                            // canvas selector
                            canvasSelector: "",
                            // items selector
                            itemSelector: "",
                            // toolbar selector
                            toolbarSelector: "",
                            // available items
                            availableItems: [],
                            // paper background url
                            paperBackgroundUrl: "",
                            // paper width (default: a4 mm)
                            paperWidth: 210,
                            // paper height (default: a4 mm)
                            paperHeight: 297,
                            // paper item width (mm)
                            paperItemWidth: 50,
                            // paper item height (mm)put
                            paperItemHeight: 10,
                            // available font families
                            availableFontFamilies: [{ "name": "Open Sans", "text": "Open Sans" }, { "name": "Poppins", "text": "Poppins" }, { "name": "Ubuntu Mono", "text": "Ubuntu" }],
                            // font family
                            fontFamily: "Open Sans",
                            // font size (pt)
                            fontSize: 12,
                            // font weight
                            fontWeight: "normal",
                            // font style
                            fontStyle: "normal",
                            // text align
                            textAlign: "left",
                            // element transform
                            transform: "rotate(0deg)",
                            // font color
                            fontColor: "#000000"
                        }, labels = {
                            // special name
                            specialName: "<?=$diller['adminpanel-print-sablon-text-2']?>",
                            // text area name
                            textAreaName: "<?=$diller['adminpanel-print-sablon-text-3']?>",
                            // width
                            width: "Width",
                            // height
                            height: "Height",
                            // left
                            left: "Left",
                            // top
                            top: "Top",
                            // punto
                            punto: "px",
                            // millimeter
                            millimeter: "mm",
                        }, keys = {
                            LEFT: 37,
                            UP: 38,
                            RIGHT: 39,
                            DOWN: 40,
                            ENTER: 13,
                            ESC: 27,
                            DELETE: 46
                        };

                    // The actual plugin constructor
                    function PrintDesigner(element, options) {
                        this.element = element;

                        this.options = $.extend({}, defaults, options);

                        this._init();
                    }

                    PrintDesigner.prototype = {
                        _init: function () {
                            var self = this;

                            // draw the canvas
                            self._drawCanvas();

                            // prepare list items
                            self._prepareListItems();

                            // deserialize paper
                            self._deserializePaper();

                            // bind paper listeners
                            self._bindPaperListeners();
                        },
                        // drawing canvas
                        _drawCanvas: function () {
                            var self = this;

                            // paper wrapper
                            self.paperWrapper = $("<div>", {
                                "class": "print-designer-paper-wrapper"
                            }).css({
                                width: self.options.paperWidth + 'mm',
                                height: self.options.paperHeight + 'mm'
                            }).mousedown(function (event) {

                                var $this = $(event.target);

                                // check toolbar item
                                if (!$this.hasClass('paper-toolbar-item')) {
                                    return;
                                }

                                // draw ruler for paper
                                self._drawToolbar($this);

                            }).appendTo(self.options.canvasSelector);

                            // paper
                            self.paper = $("<div>", {
                                "class": "print-designer-paper paper-toolbar-item"
                            }).css({
                                width: self.options.paperWidth + 'mm',
                                height: self.options.paperHeight + 'mm'
                            }).appendTo(self.paperWrapper);

                            // paper background url
                            if (self.options.paperBackgroundUrl) {
                                self.paperWrapper.css({
                                    "background-image": "url(" + self.options.paperBackgroundUrl + ")"
                                });
                            }

                            self._makeDroppable(self.paper);

                            // draw the rulers
                            self._drawRuler();

                            // draw ruler for paper
                            self._drawToolbar(self.paper);
                        },
                        // drawing ruler
                        _drawRuler: function () {
                            var self = this;

                            //vertical ruler
                            self.verticalRuler = $("<div>", {
                                "class": "print-designer-ruler vertical-ruler"
                            }).css({
                                height: self.options.paperHeight + 'mm'
                            }).prependTo(self.paperWrapper);

                            var verticalRulerSize = parseInt(self.options.paperHeight / 10);
                            for (var vrs = 0; vrs < verticalRulerSize; vrs++) {
                                //vertical ruler tick
                                var verticalRulerTick = $("<div>", {
                                    "class": "vertical-ruler-tick"
                                }).text(vrs).appendTo(self.verticalRuler);
                            }

                            // vertical ruler scroll
                            self.verticalRulerScroll = $("<div>", {
                                "class": "vertical-ruler-scroll"
                            }).appendTo(self.verticalRuler);

                            //horizontal ruler
                            self.horizontalRuler = $("<div>", {
                                "class": "print-designer-ruler horizontal-ruler"
                            }).css({
                                width: self.options.paperWidth + 'mm'
                            }).prependTo(self.paperWrapper);

                            var horizontalRulerSize = parseInt(self.options.paperWidth / 10);
                            for (var hrs = 0; hrs < horizontalRulerSize; hrs++) {
                                //horizontal ruler tick
                                var horizontalRulerTick = $("<div>", {
                                    "class": "horizontal-ruler-tick"
                                }).text(hrs).appendTo(self.horizontalRuler);
                            }

                            // horizontal ruler scroll
                            self.horizontalRulerScroll = $("<div>", {
                                "class": "horizontal-ruler-scroll"
                            }).appendTo(self.horizontalRuler);

                        },
                        // drawing toolbar
                        _drawToolbar: function (element) {
                            var self = this;

                            // selected element to dom
                            self.selectedElement = $(element);
                            var $this = $(element);
                            var domElement = $this.get(0);

                            // set ruler scroll
                            self._setRulerScroll($this);

                            //reset toolbar
                            $(".toolbar-selected", self.options.canvasSelector).removeClass('toolbar-selected');
                            $(self.options.toolbarSelector).empty();

                            // add element class
                            self.selectedElement.addClass('toolbar-selected');

                            // font family
                            var fontFamilyWrapper = $("<div>", {
                                "class": "toolbar-item toolbar-fontfamily-wrapper"
                            }).appendTo(self.options.toolbarSelector);

                            self.toolbarFontFamily = $('<select>').appendTo(fontFamilyWrapper);
                            $(self.options.availableFontFamilies).each(function () {
                                self.toolbarFontFamily.append($("<option>").attr('value', this.name).text(this.text));
                            });

                            // font size
                            var fontSizeWrapper = $("<div>", {
                                "class": "toolbar-item input-wrapper toolbar-fontsize-wrapper"
                            }).appendTo(self.options.toolbarSelector);

                            self.toolbarFontSize = $("<input>", {
                                "class": "toolbar-fontsize-input"
                            }).appendTo(fontSizeWrapper);

                            $("<span>", {
                                "class": "toolbar-unit toolbar-fontsize-unit"
                            }).text(labels.punto).appendTo(fontSizeWrapper);

                            // bind toolbar paper listeners
                            self._bindToolbarPaperListeners();

                            // case paper


                            // font color
                            var fontColorWrapper = $("<div>", {
                                "class": "toolbar-item input-wrapper toolbar-fontcolor-wrapper"
                            }).appendTo(self.options.toolbarSelector);

                            self.toolbarFontColor = $("<input>", {
                                "class": "toolbar-fontcolor-input"
                            }).val(self.options.fontColor).appendTo(fontColorWrapper);

                            self.toolbarFontColorPicker = $("<div>", {
                                "id": "color-picker",
                                "style": "position:absolute"
                            }).appendTo(fontColorWrapper);




                            // left
                            var leftWrapper = $("<div>", {
                                "class": "toolbar-item input-wrapper toolbar-left-wrapper"
                            }).appendTo(self.options.toolbarSelector);

                            $("<label>", {
                                "class": "input-title"
                            }).text(labels.left).appendTo(leftWrapper);

                            self.toolbarLeft = $("<input>", {
                                "class": "toolbar-left-input"
                            }).appendTo(leftWrapper);

                            $("<span>", {
                                "class": "toolbar-unit toolbar-left-unit"
                            }).text(labels.millimeter).appendTo(leftWrapper);

                            // top
                            var topWrapper = $("<div>", {
                                "class": "toolbar-item input-wrapper toolbar-top-wrapper"
                            }).appendTo(self.options.toolbarSelector);

                            $("<label>", {
                                "class": "input-title"
                            }).text(labels.top).appendTo(topWrapper);

                            self.toolbarTop = $("<input>", {
                                "class": "toolbar-top-input"
                            }).appendTo(topWrapper);

                            $("<span>", {
                                "class": "toolbar-unit toolbar-top-unit"
                            }).text(labels.millimeter).appendTo(topWrapper);

                            // width
                            var widthWrapper = $("<div>", {
                                "class": "toolbar-item input-wrapper toolbar-width-wrapper"
                            }).appendTo(self.options.toolbarSelector);

                            $("<label>", {
                                "class": "input-title"
                            }).text(labels.width).appendTo(widthWrapper);

                            self.toolbarWidth = $("<input>", {
                                "class": "toolbar-width-input"
                            }).appendTo(widthWrapper);

                            $("<span>", {
                                "class": "toolbar-unit toolbar-width-unit"
                            }).text(labels.millimeter).appendTo(widthWrapper);

                            // height
                            var heightWrapper = $("<div>", {
                                "class": "toolbar-item input-wrapper toolbar-height-wrapper"
                            }).appendTo(self.options.toolbarSelector);

                            $("<label>", {
                                "class": "input-title"
                            }).text(labels.height).appendTo(heightWrapper);

                            self.toolbarHeight = $("<input>", {
                                "class": "toolbar-height-input"
                            }).appendTo(heightWrapper);

                            $("<span>", {
                                "class": "toolbar-unit toolbar-height-unit"
                            }).text(labels.millimeter).appendTo(heightWrapper);



                            if ($this.hasClass('print-designer-paper')) {

                                // set paper default value
                                self.toolbarFontSize.val(self.options.fontSize);
                                self.toolbarFontColorPicker.val(self.options.fontColor);

                                return;
                            }





                            // font style
                            var fontStyleWrapper = $("<div>", {
                                "class": "toolbar-item toolbar-fontstyle-wrapper"
                            }).appendTo(self.options.toolbarSelector);

                            self.toolbarFontWeight = $("<button>", {
                                "class": "toolbar-fontweight"
                            }).append($("<i>", { "class": "fa fa-bold" })).appendTo(fontStyleWrapper);

                            self.toolbarFontStyle = $("<button>", {
                                "class": "toolbar-fontstyle"
                            }).append($("<i>", { "class": "fa fa-italic" })).appendTo(fontStyleWrapper);


                            // text align
                            var textAlignWrapper = $("<div>", {
                                "class": "toolbar-item toolbar-textalign-wrapper"
                            }).appendTo(self.options.toolbarSelector);

                            self.toolbarTextAlignLeft = $("<button>", {
                                "class": "toolbar-textalign-left"
                            }).append($("<i>", { "class": "fa fa-align-left" })).appendTo(textAlignWrapper);

                            self.toolbarTextAlignCenter = $("<button>", {
                                "class": "toolbar-textalign-center"
                            }).append($("<i>", { "class": "fa fa-align-center" })).appendTo(textAlignWrapper);

                            self.toolbarTextAlignRight = $("<button>", {
                                "class": "toolbar-textalign-right"
                            }).append($("<i>", { "class": "fa fa-align-right" })).appendTo(textAlignWrapper);

                            //element rotation
                            var ElementTransformWrapper = $("<div>", {
                                "class": "toolbar-item toolbar-ElementTransform-wrapper"
                            }).appendTo(self.options.toolbarSelector);

                            self.toolbarElementTransform90 = $("<button>", {
                                "class": "toolbar-ElementTransform-90"
                            }).append($("<i>", { "class": "fa fa-arrow-left fa-rotate-180" })).appendTo(ElementTransformWrapper);

                            self.toolbarElementTransform180 = $("<button>", {
                                "class": "toolbar-ElementTransform-180"
                            }).append($("<i>", { "class": "fa fa-arrow-left fa-rotate-270" })).appendTo(ElementTransformWrapper);

                            self.toolbarElementTransform270 = $("<button>", {
                                "class": "toolbar-ElementTransform-270"
                            }).append($("<i>", { "class": "fa fa-arrow-left fa-rotate-360" })).appendTo(ElementTransformWrapper);

                            self.toolbarElementTransform360 = $("<button>", {
                                "class": "toolbar-ElementTransform-360"
                            }).append($("<i>", { "class": "fa fa-arrow-left fa-rotate-90" })).appendTo(ElementTransformWrapper);


                            // set toolbar values
                            self._setToolbarValues({
                                // left
                                left: parseInt(domElement.style.left, 10),
                                // top
                                top: parseInt(domElement.style.top, 10),
                                // width
                                width: parseInt(domElement.style.width, 10),
                                // height
                                height: parseInt(domElement.style.height, 10),
                                // font family
                                fontFamily: domElement.style.fontFamily.replace(/"/g, ""),
                                // font size
                                fontSize: parseInt(domElement.style.fontSize, 10),
                                // font weight
                                fontWeight: domElement.style.fontWeight,
                                // font style
                                fontStyle: domElement.style.fontStyle,
                                // text align
                                textAlign: domElement.style.textAlign,
                                // element transform
                                transform: domElement.style.transform,
                                // font color
                                fontColor: domElement.style.fontColor
                            });

                            // bind toolbar listeners
                            self._bindToolbarListeners();


                            // cast text editor
                            if ($this.data("name") !== "text-item" && $this.data("name") !== "AttributeCombination.AttributeId") {
                                return;
                            }

                            // text area
                            var textAreaWrapper = $("<div>", {
                                "class": "toolbar-item input-wrapper toolbar-textarea-wrapper"
                            }).appendTo(self.options.toolbarSelector);

                            $("<label>", {
                                "class": "input-title"
                            }).text(labels.textAreaName).appendTo(textAreaWrapper);

                            self.toolbarTextArea = $("<input>", {
                                "class": "toolbar-textarea-input",
                                "value": $('p', $this).text()
                            }).appendTo(textAreaWrapper);

                            // bind toolbar text area listeners
                            self._bindToolbarTextAreaListeners();

                        },
                        // prepare available list items
                        _prepareListItems: function () {
                            var self = this;
                            // special
                            var specialWrapper = $("<div>", {
                                "class": "print-designer-item"
                            }).appendTo(self.options.itemSelector);

                            // add special name
                            $("<div class='element_Head'>").text(labels.specialName).appendTo(specialWrapper);

                            // add the special list
                            var specialList = $("<ul>").appendTo(specialWrapper);

                            // add the list
                            // add the list
                            var specialItem = $("<li>", {
                                "data-name": "text-item",
                                "data-description": labels.textAreaName,
                                "data-width": self.options.paperItemWidth,
                                "data-height": self.options.paperItemHeight,
                                "data-fontsize": self.options.fontSize,
                                "data-fontweight": self.options.fontWeight,
                                "data-fontstyle": self.options.fontStyle,
                                "data-textalign": self.options.textAlign,
                                "data-transform": self.options.transform,
                                "data-fontcolor": self.options.fontColor
                            }).draggable({
                                helper: "clone"
                            }).appendTo(specialList);

                            // add the special item icon
                            $("<i>").appendTo(specialItem);

                            // add the item special item text
                            $("<span>").text(labels.textAreaName).appendTo(specialItem);
                            // for each items
                            for (var g = 0; g < self.options.availableItems.length; g++) {
                                var group = self.options.availableItems[g];

                                // print designer item
                                var printDesignerWrapper = $("<div>", {
                                    "class": "print-designer-item"
                                }).appendTo(self.options.itemSelector);

                                // add group name
                                $("<div class='element_Head'>").text(group.name).appendTo(printDesignerWrapper);

                                // add the list
                                var paperItemList = $("<ul>").appendTo(printDesignerWrapper);

                                for (var i = 0; i < group.items.length; i++) {
                                    var item = group.items[i];

                                    // width
                                    var width = self.options.paperItemWidth;
                                    if (item.width) {
                                        width = item.width;
                                    }

                                    // height
                                    var height = self.options.paperItemHeight;
                                    if (item.height) {
                                        height = item.height;
                                    }

                                    // font size
                                    var fontSize = self.options.fontSize;
                                    if (item.fontSize) {
                                        fontSize = item.fontSize;
                                    }

                                    // font weight
                                    var fontWeight = self.options.fontWeight;
                                    if (item.fontWeight) {
                                        fontWeight = item.fontWeight;
                                    }

                                    // font style
                                    var fontStyle = self.options.fontStyle;
                                    if (item.fontStyle) {
                                        fontStyle = item.fontStyle;
                                    }

                                    // font color
                                    var fontColor = self.options.fontColor;
                                    if (item.fontColor) {
                                        fontColor = item.fontColor;
                                    }

                                    // text align
                                    var textAlign = self.options.textAlign;
                                    if (item.textAlign) {
                                        textAlign = item.textAlign;
                                    }

                                    // element transform
                                    var transform = self.options.transform;
                                    if (item.transform) {
                                        transform = item.transform;
                                    }

                                    // add the list item
                                    var paperItem = $("<li>", {
                                        "data-name": item.name,
                                        "data-description": item.description,
                                        "data-kodes": item.codes,
                                        "data-width": width,
                                        "data-height": height,
                                        "data-fontsize": fontSize,
                                        "data-fontweight": fontWeight,
                                        "data-fontstyle": fontStyle,
                                        "data-textalign": textAlign,
                                        "data-transform": transform,
                                        "data-fontcolor": fontColor
                                    }).draggable({
                                        helper: "clone"
                                    }).appendTo(paperItemList);

                                    // add the icon
                                    $("<i>", {
                                        "class": item.icon
                                    }).appendTo(paperItem);

                                    // add the item text
                                    $("<span>").text(item.text).text(item.codes).appendTo(paperItem);
                                }

                            }



                        },
                        // make droppable
                        _makeDroppable: function (element) {
                            var self = this;

                            element.droppable({
                                drop: function (event, ui) {


                                    var $this = $(ui.draggable);

                                    //calculate positions
                                    var thisPos = ui.offset;
                                    var parentPos = $(event.target).offset();

                                    var left = self._px2mm(thisPos.left - parentPos.left);
                                    var top = self._px2mm(thisPos.top - parentPos.top);

                                    if ($this.hasClass('print-designer-paper-item')) {

                                        self._setStyles($this, {
                                            // left
                                            left: left,
                                            // top
                                            top: top
                                        });

                                    }
                                    // new item
                                    else {

                                        //create element
                                        var createdElement = $("<div>");

                                        //add to page
                                        self._addElementToPaper(createdElement, {
                                            // name
                                            name: $this.data('name'),
                                            // description
                                            description: $this.data('description')
                                        });

                                        //set styles
                                        self._setStyles(createdElement, {
                                            // left
                                            left: left,
                                            // top
                                            top: top,
                                            // width
                                            width: $this.data('width'),
                                            // height
                                            height: $this.data('height'),
                                            // font family
                                            fontFamily: self.options.fontFamily,
                                            // font size
                                            fontSize: $this.data('fontsize'),
                                            // font weight
                                            fontWeight: $this.data('fontweight'),
                                            // font style
                                            fontStyle: $this.data('fontstyle'),
                                            // text align
                                            textAlign: $this.data('textalign'),
                                            // element transform
                                            transform: $this.data('transform')
                                        });

                                        self._makeDraggable(createdElement);
                                        self._makeResizeable(createdElement);

                                        // draw ruler for paper
                                        self._drawToolbar(createdElement);
                                    }

                                    //serialize paper
                                    self._serializePaper();
                                }
                            });
                        },
                        // make draggable
                        _makeDraggable: function (element) {

                            var self = this;

                            element.draggable({

                                containment: self.paper,
                                drag: function (event, ui) {

                                    var $this = $(ui.helper);

                                    var left = self._px2mm(ui.position.left);
                                    var top = self._px2mm(ui.position.top);

                                    // set toolbar values
                                    self._setToolbarValues({
                                        // left
                                        left: left,
                                        // top
                                        top: top
                                    });

                                    // set ruler scroll
                                    self._setRulerScroll($this);

                                }
                            });
                        },
                        // make resizeable
                        _makeResizeable: function (element) {
                            var self = this;

                            element.resizable({
                                containment: self.paper,
                                start: function (event, ui) {

                                    var $this = $(ui.element);

                                    // selected element
                                    self._drawToolbar($this);

                                },
                                resize: function (event, ui) {

                                    var $this = $(ui.element);

                                    var left = self._px2mm(ui.position.left);
                                    var top = self._px2mm(ui.position.top);
                                    var width = self._px2mm(ui.size.width);
                                    var height = self._px2mm(ui.size.height);

                                    self._setStyles($this, {
                                        // left
                                        left: left,
                                        // top
                                        top: top,
                                        // width
                                        width: width,
                                        // height
                                        height: height
                                    });

                                    // set toolbar values
                                    self._setToolbarValues({
                                        // left
                                        left: left,
                                        // top
                                        top: top,
                                        // width
                                        width: width,
                                        // height
                                        height: height
                                    });

                                    // set ruler scroll
                                    self._setRulerScroll($this);
                                }
                            });
                        },
                        //add element to paper
                        _addElementToPaper: function (element, properties) {
                            var self = this;

                            // element
                            element.attr({
                                "data-name": properties.name,
                                "title": properties.description
                            }).addClass('print-designer-paper-item paper-toolbar-item')
                                .appendTo(self.paper);

                            // text item
                            $("<p>")
                                .html(properties.description)
                                .appendTo(element);

                            //remove element
                            $("<i>", {
                                "class": "fa fa-trash"
                            }).on("click", function (e) {

                                // remove element
                                self._removeElementToPaper(element);

                            }).appendTo(element);

                        },
                        // remove element to paper
                        _removeElementToPaper: function (element) {
                            var self = this;

                            //remove paper item
                            element.remove();

                            //serialize paper
                            self._serializePaper();

                            // draw ruler for paper
                            self._drawToolbar(self.paper);

                        },
                        //set styles
                        _setStyles: function (element, styles) {
                            var self = this;

                            // left
                            if (styles.left !== undefined) {
                                element.css({ left: styles.left + 'mm' });
                            }

                            // top
                            if (styles.top !== undefined) {
                                element.css({ top: styles.top + 'mm' });
                            }

                            // width
                            if (styles.width !== undefined) {
                                element.css({ width: styles.width + 'mm' });
                            }

                            // height
                            if (styles.height !== undefined) {
                                element.css({ height: styles.height + 'mm' });
                            }

                            // font family
                            if (styles.fontFamily !== undefined) {
                                element.css({ fontFamily: styles.fontFamily });
                            }

                            // font size
                            if (styles.fontSize !== undefined) {
                                element.css({ fontSize: styles.fontSize + 'pt' });
                            }

                            // font weight
                            if (styles.fontWeight !== undefined) {
                                element.css({ fontWeight: styles.fontWeight });
                            }

                            // font style
                            if (styles.fontStyle !== undefined) {
                                element.css({ fontStyle: styles.fontStyle });
                            }

                            // font color
                            if (styles.fontColor !== undefined) {
                                element.css({ color : styles.fontColor });
                                element.css({ fontColor : styles.fontColor });
                            }

                            // text align
                            if (styles.textAlign !== undefined) {
                                element.css({ textAlign: styles.textAlign });
                            }

                            // element transform
                            if (styles.transform !== undefined) {
                                element.css({ transform: styles.transform });
                            }

                            //serialize paper
                            self._serializePaper();

                        },
                        //set ruler scroll
                        _setRulerScroll: function (element) {
                            var self = this;

                            // calculate positions
                            var left = self._px2mm(parseInt(element.css("left"), 10));
                            var top = self._px2mm(parseInt(element.css("top"), 10));
                            var width = self._px2mm(parseInt(element.css("width"), 10));
                            var height = self._px2mm(parseInt(element.css("height"), 10));

                            // vertical ruler scroll
                            self.verticalRulerScroll.css({
                                top: top + 'mm',
                                height: height + 'mm'
                            });

                            // horizontal ruler scroll
                            self.horizontalRulerScroll.css({
                                left: left + 'mm',
                                width: width + 'mm'
                            });

                        },
                        //set toolbar values
                        _setToolbarValues: function (styles) {
                            var self = this;

                            // left
                            if (styles.left !== undefined) {
                                self.toolbarLeft.val(styles.left);
                            }

                            // top
                            if (styles.top !== undefined) {
                                self.toolbarTop.val(styles.top);
                            }

                            // width
                            if (styles.width !== undefined) {
                                self.toolbarWidth.val(styles.width);
                            }

                            // height
                            if (styles.height !== undefined) {
                                self.toolbarHeight.val(styles.height);
                            }

                            // font family
                            if (styles.fontFamily !== undefined) {
                                self.toolbarFontFamily.val(styles.fontFamily);
                            }

                            // font size
                            if (styles.fontSize !== undefined) {
                                self.toolbarFontSize.val(styles.fontSize);
                            }

                            // font color
                            if (styles.fontColor !== undefined) {
                                self.toolbarFontColor.val(styles.fontColor);
                                self.toolbarFontColor.attr("style","background-color:"+styles.fontColor);
                            }

                            // font weight
                            if (styles.fontWeight !== undefined) {

                                if (styles.fontWeight === "bold") {
                                    self.toolbarFontWeight.addClass('active');
                                }

                            }

                            // font style
                            if (styles.fontStyle !== undefined) {

                                if (styles.fontStyle === "italic") {
                                    self.toolbarFontStyle.addClass('active');
                                }

                            }

                            // text align
                            if (styles.textAlign !== undefined) {

                                // toolbar text align left
                                if (styles.textAlign === "left") {
                                    self.toolbarTextAlignLeft.addClass('active');
                                }

                                // toolbar text align center
                                if (styles.textAlign === "center") {
                                    self.toolbarTextAlignCenter.addClass('active');
                                }

                                // toolbar text align right
                                if (styles.textAlign === "right") {
                                    self.toolbarTextAlignRight.addClass('active');
                                }

                            }

                            // element transform
                            if (styles.transform !== undefined) {

                                // toolbar element rotation 90 deg
                                if (styles.transform === "90") {
                                    self.toolbarElementTransform90.addClass('active');
                                }

                                // toolbar element rotation 180 deg
                                if (styles.transform === "180") {
                                    self.toolbarElementTransform180.addClass('active');
                                }

                                // toolbar element rotation 270 deg
                                if (styles.transform === "270") {
                                    self.toolbarElementTransform270.addClass('active');
                                }

                                // toolbar element rotation 360 deg
                                if (styles.transform === "360") {
                                    self.toolbarElementTransform360.addClass('active');
                                }
                            }

                        },
                        // px to mm converter
                        _px2mm: function (value) {
                            return Math.max(parseInt(Math.round(value * 0.264583)), 0);
                        },
                        // is numeric key
                        _isNumeric: function (key) {

                            if (key !== 8 && key !== 0 && (key < 48 || key > 57)) {
                                return false;
                            }

                            return true;
                        },
                        // bind listener events
                        _bindPaperListeners: function () {
                            var self = this;
                            // listen on the document because that's where key events are triggered if no input has focus
                            $(document).on("keydown", function (e) {
                                // prevent down key from scrolling the whole page,
                                // and enter key from submitting a form etc
                                if (e.which === keys.UP || e.which === keys.DOWN) {
                                    // up and down to navigate
                                    self._handleUpDownKey(e.which);
                                    e.preventDefault();
                                } else if (e.which === keys.LEFT || e.which === keys.RIGHT) {
                                    // up and down to navigate
                                    self._handleLeftRightKey(e.which);
                                    e.preventDefault();
                                } else if (e.which === keys.ENTER || e.which === keys.ESC) {
                                    // draw ruler for paper
                                    self._drawToolbar(self.paper);
                                    e.preventDefault();
                                }
                                else if (e.which === keys.DELETE) {
                                    // delete key
                                    self._handleDeleteKey();
                                }
                            });
                        },
                        // handle delete key
                        _handleDeleteKey: function () {
                            var self = this;

                            // get selected paper item
                            var element = self.selectedElement;

                            // check toolbar item
                            if (!element.hasClass('paper-toolbar-item')) {
                                return;
                            }

                            // remove element
                            self._removeElementToPaper(element);

                        },
                        // handle up down key
                        _handleUpDownKey: function (key) {
                            var self = this;

                            // get selected paper item
                            var element = self.selectedElement;

                            // check toolbar item
                            if (!element.hasClass('paper-toolbar-item')) {
                                return;
                            }

                            // calculate positions
                            var paperHeight = self._px2mm(parseInt(self.paper.css("height"), 10));
                            var top = self._px2mm(parseInt(element.css("top"), 10));
                            var height = self._px2mm(parseInt(element.css("height"), 10));

                            // check secure area
                            if ((top === 0 && key === keys.UP) || (top + height >= paperHeight && key === keys.DOWN)) {
                                return;
                            }

                            self._setStyles(element, {
                                // top
                                top: key === keys.UP ? top - 1 : top + 1
                            });

                            // set toolbar values
                            self._setToolbarValues({
                                // top
                                top: key === keys.UP ? top - 1 : top + 1
                            });

                            // set ruler scroll
                            self._setRulerScroll(element);

                        },
                        // handle left right key
                        _handleLeftRightKey: function (key) {
                            var self = this;

                            // get selected paper item
                            var element = self.selectedElement;

                            // check toolbar item
                            if (!element.hasClass('paper-toolbar-item')) {
                                return;
                            }

                            // calculate positions
                            var paperWidth = self._px2mm(parseInt(self.paper.css("width"), 10));
                            var left = self._px2mm(parseInt(element.css("left"), 10));
                            var width = self._px2mm(parseInt(element.css("width"), 10));

                            // check secure area
                            if ((left === 0 && key === keys.LEFT) || (left + width >= paperWidth && key === keys.RIGHT)) {
                                return;
                            }

                            self._setStyles(element, {
                                // left
                                left: key === keys.LEFT ? left - 1 : left + 1
                            });

                            // set toolbar values
                            self._setToolbarValues({
                                // left
                                left: key === keys.LEFT ? left - 1 : left + 1
                            });

                            // set ruler scroll
                            self._setRulerScroll(element);
                        },
                        // bind paper toolbar listeners
                        _bindToolbarPaperListeners: function () {
                            var self = this;

                            // toolbar font family
                            self.toolbarFontFamily.on("change", function (e) {
                                self._handleToolbarFontFamily();
                            });


                            // toolbar font size
                            self.toolbarFontSize.on("keypress keyup blur paste", function (e) {
                                if (!self._isNumeric(e.which)) {
                                    e.preventDefault();
                                }
                                self._handleToolbarFontSize();
                            });

                        },
                        // bind toolbar listeners
                        _bindToolbarListeners: function () {
                            var self = this;

                            // toolbar font weight
                            self.toolbarFontWeight.on("click", function (e) {
                                e.preventDefault();
                                self._handleToolbarFontWeight();
                            });

                            // toolbar font style
                            self.toolbarFontStyle.on("click", function (e) {
                                e.preventDefault();
                                self._handleToolbarFontStyle();
                            });

                            // toolbar font color
                            self.toolbarFontColor.on("click", function (e) {
                                e.preventDefault();
                                self._handleToolbarFontColor();
                            });

                            // toolbar text align left
                            self.toolbarTextAlignLeft.on("click", function (e) {
                                e.preventDefault();
                                self._handleToolbarTextAlignLeft();
                            });

                            // toolbar text align center
                            self.toolbarTextAlignCenter.on("click", function (e) {
                                e.preventDefault();
                                self._handleToolbarTextAlignCenter();
                            });

                            // toolbar text align right
                            self.toolbarTextAlignRight.on("click", function (e) {
                                e.preventDefault();
                                self._handleToolbarTextAlignRight();
                            });

                            // toolbar element rotation 90 deg
                            self.toolbarElementTransform90.on("click", function (e) {
                                e.preventDefault();
                                self._handleToolbarElementTransform90();
                            });

                            // toolbar element rotation 180 deg
                            self.toolbarElementTransform180.on("click", function (e) {
                                e.preventDefault();
                                self._handleToolbarElementTransform180();
                            });

                            // toolbar element rotation 270 deg
                            self.toolbarElementTransform270.on("click", function (e) {
                                e.preventDefault();
                                self._handleToolbarElementTransform270();
                            });

                            // toolbar element rotation 360 deg
                            self.toolbarElementTransform360.on("click", function (e) {
                                e.preventDefault();
                                self._handleToolbarElementTransform360();
                            });

                            // toolbar left
                            self.toolbarLeft.on("keypress keyup blur paste", function (e) {
                                if (!self._isNumeric(e.which)) {
                                    e.preventDefault();
                                }
                                self._handleToolbarLeft();
                            });

                            // toolbar top
                            self.toolbarTop.on("keypress keyup blur paste", function (e) {
                                if (!self._isNumeric(e.which)) {
                                    e.preventDefault();
                                }
                                self._handleToolbarTop();
                            });

                            // toolbar width
                            self.toolbarWidth.on("keypress keyup blur paste", function (e) {
                                if (!self._isNumeric(e.which)) {
                                    e.preventDefault();
                                }
                                self._handleToolbarWidth();
                            });

                            // toolbar height
                            self.toolbarHeight.on("keypress keyup blur paste", function (e) {
                                if (!self._isNumeric(e.which)) {
                                    e.preventDefault();
                                }
                                self._handleToolbarHeight();
                            });

                        },
                        // bind toolbar text ares listeners
                        _bindToolbarTextAreaListeners: function () {
                            var self = this;

                            // toolbar text area
                            self.toolbarTextArea.on("keypress keyup blur paste", function (e) {
                                self._handleToolbarTextArea();
                            });

                        },
                        // handle toolbar font family
                        _handleToolbarFontFamily: function () {
                            var self = this;

                            // get selected paper item
                            var element = self.selectedElement;

                            // get toolbar font family value
                            var value = self.toolbarFontFamily.val();

                            // check paper
                            if (element.hasClass('print-designer-paper')) {

                                // foreach all paper items
                                $(".print-designer-paper-item", self.paper).each(function (i, el) {

                                    // currenct item
                                    var $el = $(el);

                                    self._setStyles($el, {
                                        // font family
                                        fontFamily: value
                                    });

                                });

                            }

                            // set style
                            self._setStyles(element, {
                                // font family
                                fontFamily: value
                            });

                        },
                        // handle toolbar font size
                        _handleToolbarFontSize: function () {
                            var self = this;

                            // get selected paper item
                            var element = self.selectedElement;

                            // get toolbar font size value
                            var value = self.toolbarFontSize.val();

                            // parse font size
                            var fontSize = parseInt(value);

                            // check is nan or negative value
                            if (isNaN(fontSize) || fontSize < 0) {
                                fontSize = self.options.fontSize;
                            }

                            // check paper
                            if (element.hasClass('print-designer-paper')) {

                                // foreach all paper items
                                $(".print-designer-paper-item", self.paper).each(function (i, el) {

                                    // currenct item
                                    var $el = $(el);

                                    self._setStyles($el, {
                                        // font size
                                        fontSize: fontSize
                                    });

                                });
                            }

                            // set styles
                            self._setStyles(element, {
                                // font size
                                fontSize: fontSize
                            });
                        },
                        // handle toolbar font color
                        _handleToolbarFontColor: function () {
                            var self = this;

                            // get selected paper item
                            var element = self.selectedElement;
                            $('.toolbar-fontcolor-input').attr("style", "background-color:" + self.toolbarFontColor.val());

                            $('#color-picker').farbtastic(function (e) {

                                $('.toolbar-fontcolor-input').val(e);
                                $('.toolbar-fontcolor-input').attr("style","background-color:"+e);
                                // parse font color
                                var fontColor = e;

                                // set styles
                                self._setStyles(element, {
                                    // font color
                                    fontColor: fontColor
                                });

                            });

                        },
                        // handle toolbar font weight
                        _handleToolbarFontWeight: function () {
                            var self = this;

                            // get selected paper item
                            var element = self.selectedElement;

                            // define font weight
                            var fontWeight = "";

                            if (self.toolbarFontWeight.hasClass("active")) {
                                // set value
                                fontWeight = "normal";
                                // remove element class
                                self.toolbarFontWeight.removeClass("active");
                            }
                            else {
                                // set value
                                fontWeight = "bold";
                                // add element class
                                self.toolbarFontWeight.addClass("active");
                            }

                            // set styles
                            self._setStyles(element, {
                                // font weight
                                fontWeight: fontWeight
                            });
                        },
                        // handle toolbar font style
                        _handleToolbarFontStyle: function () {
                            var self = this;

                            // get selected paper item
                            var element = self.selectedElement;

                            // define font style
                            var fontStyle = "";

                            if (self.toolbarFontStyle.hasClass("active")) {
                                // set value
                                fontStyle = "normal";
                                // remove element class
                                self.toolbarFontStyle.removeClass("active");
                            }
                            else {
                                // set value
                                fontStyle = "italic";
                                // add element class
                                self.toolbarFontStyle.addClass("active");
                            }

                            // set styles
                            self._setStyles(element, {
                                // font style
                                fontStyle: fontStyle
                            });
                        },
                        // handle toolbar text align left
                        _handleToolbarTextAlignLeft: function () {
                            var self = this;

                            // get selected paper item
                            var element = self.selectedElement;

                            // define text align left
                            var textAlign = "left";

                            // remove element class
                            self.toolbarTextAlignLeft.removeClass("active");
                            self.toolbarTextAlignCenter.removeClass("active");
                            self.toolbarTextAlignRight.removeClass("active");

                            // add element class
                            self.toolbarTextAlignLeft.addClass("active");

                            // set styles
                            self._setStyles(element, {
                                // font style
                                textAlign: textAlign
                            });
                        },
                        // handle toolbar text align center
                        _handleToolbarTextAlignCenter: function () {
                            var self = this;

                            // get selected paper item
                            var element = self.selectedElement;

                            // define text align center
                            var textAlign = "center";

                            // remove element class
                            self.toolbarTextAlignLeft.removeClass("active");
                            self.toolbarTextAlignCenter.removeClass("active");
                            self.toolbarTextAlignRight.removeClass("active");

                            // add element class
                            self.toolbarTextAlignCenter.addClass("active");

                            // set styles
                            self._setStyles(element, {
                                // font style
                                textAlign: textAlign
                            });
                        },
                        // handle toolbar text align right
                        _handleToolbarTextAlignRight: function () {
                            var self = this;

                            // get selected paper item
                            var element = self.selectedElement;

                            // define text align right
                            var textAlign = "right";

                            // remove element class
                            self.toolbarTextAlignLeft.removeClass("active");
                            self.toolbarTextAlignCenter.removeClass("active");
                            self.toolbarTextAlignRight.removeClass("active");

                            // add element class
                            self.toolbarTextAlignRight.addClass("active");

                            // set styles
                            self._setStyles(element, {
                                // font style
                                textAlign: textAlign
                            });
                        },
                        // handle toolbar element rotation 90 deg
                        _handleToolbarElementTransform90: function () {
                            var self = this;

                            // get selected paper item
                            var element = self.selectedElement;

                            // define element rotation 90 deg
                            var ElementTransform = "rotate(90deg)";

                            // remove element class
                            self.toolbarElementTransform90.removeClass("active");
                            self.toolbarElementTransform180.removeClass("active");
                            self.toolbarElementTransform270.removeClass("active");
                            self.toolbarElementTransform360.removeClass("active");

                            // add element class
                            self.toolbarElementTransform90.addClass("active");

                            // set styles
                            self._setStyles(element, {
                                // font style
                                transform: ElementTransform
                            });
                        },
                        // handle toolbar element rotation 180 deg
                        _handleToolbarElementTransform180: function () {
                            var self = this;

                            // get selected paper item
                            var element = self.selectedElement;

                            // define element rotation 180 deg
                            var ElementTransform = "rotate(180deg)";

                            // remove element class
                            self.toolbarElementTransform90.removeClass("active");
                            self.toolbarElementTransform180.removeClass("active");
                            self.toolbarElementTransform270.removeClass("active");
                            self.toolbarElementTransform360.removeClass("active");

                            // add element class
                            self.toolbarElementTransform180.addClass("active");

                            // set styles
                            self._setStyles(element, {
                                // font style
                                transform: ElementTransform
                            });
                        },
                        // handle toolbar element rotation 270 deg
                        _handleToolbarElementTransform270: function () {
                            var self = this;

                            // get selected paper item
                            var element = self.selectedElement;

                            // define element rotation 270 deg
                            var ElementTransform = "rotate(270deg)";

                            // remove element class
                            self.toolbarElementTransform90.removeClass("active");
                            self.toolbarElementTransform180.removeClass("active");
                            self.toolbarElementTransform270.removeClass("active");
                            self.toolbarElementTransform360.removeClass("active");

                            // add element class
                            self.toolbarElementTransform270.addClass("active");

                            // set styles
                            self._setStyles(element, {
                                // font style
                                transform: ElementTransform
                            });
                        },
                        // handle toolbar element rotation 360 deg
                        _handleToolbarElementTransform360: function () {
                            var self = this;

                            // get selected paper item
                            var element = self.selectedElement;

                            // define element rotation 360 deg
                            var ElementTransform = "rotate(360deg)";

                            // remove element class
                            self.toolbarElementTransform90.removeClass("active");
                            self.toolbarElementTransform180.removeClass("active");
                            self.toolbarElementTransform270.removeClass("active");

                            // add element class
                            self.toolbarElementTransform360.addClass("active");

                            // set styles
                            self._setStyles(element, {
                                // font style
                                transform: ElementTransform
                            });
                        },
                        // handle toolbar left
                        _handleToolbarLeft: function () {
                            var self = this;

                            // get selected paper item
                            var element = self.selectedElement;

                            // get toolbar left value
                            var value = self.toolbarLeft.val();

                            // calculate positions
                            var paperWidth = self._px2mm(parseInt(self.paper.css("width"), 10));
                            var left = parseInt(value);
                            var width = self._px2mm(parseInt(element.css("width"), 10));

                            // check is nan or negative value
                            if (isNaN(left) || left < 0) {
                                left = 0;
                            }

                            // check secure area
                            if (left + width >= paperWidth) {
                                left = paperWidth - width;
                            }

                            // set styles
                            self._setStyles(element, {
                                // left
                                left: left
                            });

                            // set toolbar value
                            self.toolbarLeft.val(left);

                            // set ruler scroll
                            self._setRulerScroll(element);

                        },
                        // handle toolbar top
                        _handleToolbarTop: function () {
                            var self = this;

                            // get selected paper item
                            var element = self.selectedElement;

                            // get toolbar top value
                            var value = self.toolbarTop.val();

                            // calculate positions
                            var paperHeight = self._px2mm(parseInt(self.paper.css("height"), 10));
                            var top = parseInt(value);
                            var height = self._px2mm(parseInt(element.css("height"), 10));

                            // check is nan or negative value
                            if (isNaN(top) || top < 0) {
                                top = 0;
                            }

                            // check secure area
                            if (top + height >= paperHeight) {
                                top = paperHeight - height;
                            }

                            // set styles
                            self._setStyles(element, {
                                // top
                                top: top
                            });

                            // set toolbar value
                            self.toolbarTop.val(top);

                            // set ruler scroll
                            self._setRulerScroll(element);

                        },
                        // handle toolbar width
                        _handleToolbarWidth: function () {
                            var self = this;

                            // get selected paper item
                            var element = self.selectedElement;

                            // get toolbar width value
                            var value = self.toolbarWidth.val();

                            // calculate positions
                            var paperWidth = self._px2mm(parseInt(self.paper.css("width"), 10));
                            var left = self._px2mm(parseInt(element.css("left"), 10));
                            var width = parseInt(value);

                            // check is nan or negative value
                            if (isNaN(width) || width < 0) {
                                width = 0;
                            }

                            // check secure area
                            if (left + width >= paperWidth) {
                                width = paperWidth - left;
                            }

                            // set styles
                            self._setStyles(element, {
                                // width
                                width: width
                            });

                            // set toolbar value
                            self.toolbarWidth.val(width);

                            // set ruler scroll
                            self._setRulerScroll(element);

                        },
                        // handle toolbar height
                        _handleToolbarHeight: function () {
                            var self = this;

                            // get selected paper item
                            var element = self.selectedElement;

                            // get toolbar height value
                            var value = self.toolbarHeight.val();

                            // calculate positions
                            var paperHeight = self._px2mm(parseInt(self.paper.css("height"), 10));
                            var top = self._px2mm(parseInt(element.css("top"), 10));
                            var height = parseInt(value);

                            // check is nan or negative value
                            if (isNaN(height) || height < 0) {
                                height = 0;
                            }

                            // check secure area
                            if (top + height >= paperHeight) {
                                height = paperHeight - top;
                            }

                            // set styles
                            self._setStyles(element, {
                                // height
                                height: height
                            });

                            // set toolbar value
                            self.toolbarHeight.val(height);

                            // set ruler scroll
                            self._setRulerScroll(element);

                        },
                        // handle toolbar text area
                        _handleToolbarTextArea: function () {
                            var self = this;

                            // get selected paper item
                            var element = self.selectedElement;

                            // get toolbar height value
                            var value = self.toolbarTextArea.val();

                            // set value
                            $('p', element).text(value);

                            //serialize paper
                            self._serializePaper();

                        },
                        //serialize paper
                        _serializePaper: function () {
                            var self = this;

                            var paperArray = [];

                            $(".print-designer-paper-item", self.paper).each(function (i, el) {

                                // create element
                                var $el = $(el);

                                //paper item object
                                var paperItem = {
                                    // name
                                    name: $el.data('name'),
                                    // description
                                    description: $('p', $el).text(),
                                    // left
                                    left: parseInt(el.style.left, 10),
                                    // top
                                    top: parseInt(el.style.top, 10),
                                    // width
                                    width: parseInt(el.style.width, 10),
                                    // height
                                    height: parseInt(el.style.height, 10),
                                    // font family
                                    fontFamily: el.style.fontFamily,
                                    // font size
                                    fontSize: parseInt(el.style.fontSize, 10),
                                    // font weight
                                    fontWeight: el.style.fontWeight,
                                    // font style
                                    fontStyle: el.style.fontStyle,
                                    // text align
                                    textAlign: el.style.textAlign,
                                    // element rotation
                                    transform: el.style.transform,
                                    // font color
                                    fontColor: el.style.fontColor
                                };

                                paperArray.push(paperItem);

                            });

                            var jsonString = JSON.stringify(paperArray);

                            $(self.element).val(jsonString);

                        },
                        //deserialize paper
                        _deserializePaper: function () {
                            var self = this;

                            // get string
                            var jsonString = $(self.element).val();

                            // string to array
                            var paperArray = $.parseJSON(jsonString);

                            //each array
                            $.each(paperArray, function (i, el) {

                                //create element
                                var createdElement = $("<div>");

                                //add to page
                                self._addElementToPaper(createdElement, {
                                    // name
                                    name: el.name,
                                    // description
                                    description: el.description
                                });

                                //set styles
                                self._setStyles(createdElement, {
                                    // left
                                    left: el.left,
                                    // top
                                    top: el.top,
                                    // width
                                    width: el.width,
                                    // height
                                    height: el.height,
                                    // font family
                                    fontFamily: el.fontFamily,
                                    // font size
                                    fontSize: el.fontSize,
                                    // font weight
                                    fontWeight: el.fontWeight,
                                    // font style
                                    fontStyle: el.fontStyle,
                                    // text align
                                    textAlign: el.textAlign,
                                    // element transform
                                    transform: el.transform,
                                    // font color
                                    fontColor: el.fontColor
                                });

                                self._makeDraggable(createdElement);
                                self._makeResizeable(createdElement);

                            });

                        }
                    };

                    $.fn[pluginName] = function (options) {

                        return this.each(function () {
                            if (!$.data(this, pluginName)) {
                                $.data(this, pluginName, new PrintDesigner(this, options));
                            }
                        });

                    };


                }(jQuery, window, document));
            </script>

            <div>
                <div id="print-designer-canvas" ></div>
            </div>
            <textarea  id="themeCode" style="display: none;"><?=$printCode?></textarea>

            <script>

                    $("#themeCode").PrintDesigner({
                        canvasSelector: "#print-designer-canvas",
                        itemSelector: "#print-designer-items",
                        toolbarSelector: "#print-designer-toolbar",
                        paperWidth: <?=$t['width']?>,
                        paperHeight: <?=$t['height']?>,
                        paperBackgroundUrl: '../i/uploads/<?=$t['arkaplan']?>',
                    });


            </script>
            <script>
              window.onload = function() { window.print(); }
            </script>   
        <?php }else {

            $_SESSION['main_alert'] = 'invoice_theme_alert';
            header('Location:'.$_SESSION['current_url'] .'');

        }?>
    <?php }else{
        header('Location:'.$ayar['site_url'].'404');
    }?>
<?php }else {
    header('Location:'.$ayar['site_url'].'404');
}?>
<?php
function sayiyiYaziyaCevir($sayi, $kurusbasamak, $parabirimi, $parakurus, $diyez, $bb1, $bb2, $bb3) {
    $b1 = array("", "bir", "iki", "üç", "dört", "beş", "altı", "yedi", "sekiz", "dokuz");
    $b2 = array("", "on", "yirmi", "otuz", "kırk", "elli", "altmış", "yetmiş", "seksen", "doksan");
    $b3 = array("", "yüz", "bin", "milyon", "milyar", "trilyon", "katrilyon");

    if ($bb1 != null) { // farklı dil kullanımı yada farklı yazım biçimi için
        $b1 = $bb1;
    }
    if ($bb2 != null) { // farklı dil kullanımı
        $b2 = $bb2;
    }
    if ($bb3 != null) { // farklı dil kullanımı
        $b3 = $bb3;
    }

    $say1="";
    $say2 = ""; // say1 virgül öncesi, say2 kuruş bölümü
    $sonuc = "";

    $sayi = str_replace(",", ".",$sayi); //virgül noktaya çevrilir

    $nokta = strpos($sayi,"."); // nokta indeksi

    if ($nokta>0) { // nokta varsa (kuruş)

        $say1 = substr($sayi,0, $nokta); // virgül öncesi
        $say2 = substr($sayi,$nokta, strlen($sayi)); // virgül sonrası, kuruş

    } else {
        $say1 = $sayi; // kuruş yoksa
    }

    $son;
    $w = 1; // işlenen basamak
    $sonaekle = 0; // binler on binler yüzbinler vs. için sona bin (milyon,trilyon...) eklenecek mi?
    $kac = strlen($say1); // kaç rakam var?
    $sonint; // işlenen basamağın rakamsal değeri
    $uclubasamak = 0; // hangi basamakta (birler onlar yüzler gibi)
    $artan = 0; // binler milyonlar milyarlar gibi artışları yapar
    $gecici;

    if ($kac > 0) { // virgül öncesinde rakam var mı?

        for ($i = 0; $i < $kac; $i++) {

            $son = $say1[$kac - 1 - $i]; // son karakterden başlayarak çözümleme yapılır.
            $sonint = $son; // işlenen rakam Integer.parseInt(

            if ($w == 1) { // birinci basamak bulunuyor

                $sonuc = $b1[$sonint] . $sonuc;

            } else if ($w == 2) { // ikinci basamak

                $sonuc = $b2[$sonint] . $sonuc;

            } else if ($w == 3) { // 3. basamak

                if ($sonint == 1) {
                    $sonuc = $b3[1] . $sonuc;
                } else if ($sonint > 1) {
                    $sonuc = $b1[$sonint] . $b3[1] . $sonuc;
                }
                $uclubasamak++;
            }

            if ($w > 3) { // 3. basamaktan sonraki işlemler

                if ($uclubasamak == 1) {

                    if ($sonint > 0) {
                        $sonuc = $b1[$sonint] . $b3[2 + $artan] . $sonuc;
                        if ($artan == 0) { // birbin yazmasını engelle
                            $sonuc = str_replace($b1[1] . $b3[2], $b3[2],$sonuc);
                        }
                        $sonaekle = 1; // sona bin eklendi
                    } else {
                        $sonaekle = 0;
                    }
                    $uclubasamak++;

                } else if ($uclubasamak == 2) {

                    if ($sonint > 0) {
                        if ($sonaekle > 0) {
                            $sonuc = $b2[$sonint] . $sonuc;
                            $sonaekle++;
                        } else {
                            $sonuc = $b2[$sonint] . $b3[2 + $artan] . $sonuc;
                            $sonaekle++;
                        }
                    }
                    $uclubasamak++;

                } else if ($uclubasamak == 3) {

                    if ($sonint > 0) {
                        if ($sonint == 1) {
                            $gecici = $b3[1];
                        } else {
                            $gecici = $b1[$sonint] . $b3[1];
                        }
                        if ($sonaekle == 0) {
                            $gecici = $gecici . $b3[2 + $artan];
                        }
                        $sonuc = $gecici . $sonuc;
                    }
                    $uclubasamak = 1;
                    $artan++;
                }

            }

            $w++; // işlenen basamak

        }
    } // if(kac>0)

    if ($sonuc=="") { // virgül öncesi sayı yoksa para birimi yazma
        $parabirimi = "";
    }

    $say2 = str_replace(".", "",$say2);
    $kurus = "";

    if ($say2!="") { // kuruş hanesi varsa

        if ($kurusbasamak > 3) { // 3 basamakla sınırlı
            $kurusbasamak = 3;
        }
        $kacc = strlen($say2);
        if ($kacc == 1) { // 2 en az
            $say2 = $say2."0"; // kuruşta tek basamak varsa sona sıfır ekler.
            $kurusbasamak = 2;
        }
        if (strlen($say2) > $kurusbasamak) { // belirlenen basamak kadar rakam yazılır
            $say2 = substr($say2,0, $kurusbasamak);
        }

        $kac = strlen($say2); // kaç rakam var?
        $w = 1;

        for ($i = 0; $i < $kac; $i++) { // kuruş hesabı

            $son = $say2[$kac - 1 - $i]; // son karakterden başlayarak çözümleme yapılır.
            $sonint = $son; // işlenen rakam Integer.parseInt(

            if ($w == 1) { // birinci basamak

                if ($kurusbasamak > 0) {
                    $kurus = $b1[$sonint] . $kurus;
                }

            } else if ($w == 2) { // ikinci basamak
                if ($kurusbasamak > 1) {
                    $kurus = $b2[$sonint] . $kurus;
                }

            } else if ($w == 3) { // 3. basamak
                if ($kurusbasamak > 2) {
                    if ($sonint == 1) { // 'biryüz' ü engeller
                        $kurus = $b3[1] . $kurus;
                    } else if ($sonint > 1) {
                        $kurus = $b1[$sonint] . $b3[1] . $kurus;
                    }
                }
            }
            $w++;
        }
        if ($kurus=="") { // virgül öncesi sayı yoksa para birimi yazma
            $parakurus = "";
        } else {
            $kurus = $kurus . " ";
        }
        $kurus = $kurus . $parakurus; // kuruş hanesine 'kuruş' kelimesi ekler
    }

    $sonuc = $diyez . $sonuc . " " . $parabirimi . " " . $kurus . $diyez;
    return $sonuc;
}?>