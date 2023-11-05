<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'print_invoice';

$printCheck = $db->prepare("select * from print_tema where modul=:modul order by id desc ");
$printCheck->execute(array(
    'modul' => 'invoice',
));
$printayar = $printCheck->fetch(PDO::FETCH_ASSOC);

?>
<title><?=$diller['adminpanel-menu-text-181']?> - <?=$panelayar['baslik']?></title>
<?php
if($_GET['theme'] == null && !isset($_GET['theme']) && $_GET['theme'] <= '0'  ) {
    ?>
    <div class="wrapper" style="margin-top: 0;">
        <div class="container-fluid">
            <!-- Page-Title -->
            <div class="row mb-3">
                <div class="col-md-12 ">
                    <div class="page-title-box  bg-white card mb-0 pl-3">
                        <div class="row align-items-center d-flex justify-content-between">
                            <div class="col-md-8">
                                <div class="page-title-nav">
                                    <a href="<?= $ayar['panel_url'] ?>"><i  class="ion ion-md-home"></i> <?= $diller['adminpanel-text-341'] ?></a>
                                    <a href="javascript:Void(0)"><i   class="fa fa-angle-right"></i> <?= $diller['adminpanel-menu-text-98'] ?>
                                    </a>
                                    <a href="pages.php?page=theme_print_invoice"><i class="fa fa-angle-right"></i> <?= $diller['adminpanel-menu-text-181'] ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}
?>

<!-- end page title end breadcrumb -->
<?php if($yetki['tema_ayarlar'] == '1' ) {?>

    <?php if($_GET['theme'] == null && !isset($_GET['theme']) && $_GET['theme'] <= '0'  ) {?>
        <div class="wrapper" style="margin-top: 0;">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="w-100">
                                    <a data-toggle="collapse" data-target="#olusturAcc" aria-expanded="false" aria-controls="collapseForm" class="btn btn-primary text-white">+ <?=$diller['adminpanel-form-text-1534']?></a>
                                    <div id="accordion" class="accordion" style="width: 100%;  ">
                                        <div class="collapse  " id="olusturAcc" data-parent="#accordion">
                                            <div class="border border-grey w-100 p-3 d-flex align-items-center justify-content-between mt-2" >
                                                <div>
                                                    <h5><?=$diller['adminpanel-form-text-1534']?></h5>
                                                </div>
                                                <a data-toggle="collapse" data-target="#olusturAcc" aria-expanded="false" aria-controls="collapseForm" class="btn btn-sm btn-dark ml-2 text-white"><?=$diller['adminpanel-modal-text-17']?></a>
                                            </div>
                                            <form method="post" action="post.php?process=print_theme_post&status=invoice_add" enctype="multipart/form-data" >
                                                <div class="border border-grey border-top-0 p-3">
                                                    <div class="row">
                                                        <div class="col-md-3 form-group">
                                                            <div class="kustom-checkbox">
                                                                <input type="checkbox" class="individual" id="varsayilan" name='varsayilan' value="1">
                                                                <label for="varsayilan"><?=$diller['adminpanel-form-text-1536']?></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 form-group">
                                                            <label for="baslik"><?=$diller['adminpanel-form-text-1535']?></label>
                                                            <input type="text" autocomplete="off"  name="baslik"  id="baslik" required class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="row ">
                                                        <div class="col-md-3 form-group">
                                                            <label for="width"><?=$diller['adminpanel-form-text-1531']?> (mm)</label>
                                                            <input type="number" name="width" id="width" required class="form-control">
                                                        </div>
                                                        <div class="col-md-3 form-group">
                                                            <label for="height"><?=$diller['adminpanel-form-text-1532']?> (mm)</label>
                                                            <input type="number" name="height"  id="height" required class="form-control">
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <div class=" ">
                                                                <label  for="inputGroupFile01" class="w-100"><?=$diller['adminpanel-form-text-1537']?> <small>( png,  jpg, jpeg)</small></label>
                                                                <div class="input-group ">
                                                                    <div class="custom-file ">
                                                                        <input type="file" class="custom-file-input " id="inputGroupFile01" name="arkaplan"  >
                                                                        <label class="custom-file-label" for="inputGroupFile01"  ><?=$diller['adminpanel-form-text-106']?></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-3">
                                                        <div class="col-md-12 form-group mb-0">
                                                            <button class="btn  btn-success btn-block" name="invoiceAdd"><?=$diller['adminpanel-form-text-53']?></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-100 border border-grey mt-2 p-3 d-flex align-items-center justify-content-center" style="height: 250px">
                                    <div  class="text-center sablon-text-div">
                                       <div class="border-bottom border-grey">
                                           <h3><?=$diller['adminpanel-menu-text-181']?></h3>
                                       </div>
                                        <h6><?=$diller['adminpanel-form-text-1538']?></h6>
                                        <div>
                                            <?=$diller['adminpanel-form-text-1539']?>
                                        </div>
                                        <div class="w-100 mt-2">
                                            <select name="" class="form-control" onchange="javascript:location.href = this.value;" >
                                                <!-- Sablon listesi !-->
                                                <?php
                                                $sabloncek = $db->prepare("select * from print_tema where modul=:modul ");
                                                $sabloncek->execute(array(
                                                    'modul' => 'invoice',
                                                ));
                                                ?>
                                                <?php if($sabloncek->rowCount()>'0'  ) {?>
                                                    <option value="0" >-- <?=$diller['adminpanel-form-text-1540']?></option>
                                                    <?php foreach ($sabloncek as $sablonRow) {?>
                                                        <option value="pages.php?page=theme_print_invoice&theme=<?=$sablonRow['id']?>"><?=$sablonRow['baslik']?> <?php if($sablonRow['varsayilan'] == '1' ) { ?>(<?=$diller['adminpanel-form-text-69']?>)<?php }?></option>
                                                    <?php }?>
                                                <?php }else { ?>
                                                    <option value="0"><?=$diller['adminpanel-form-text-1541']?></option>
                                                <?php }?>
                                                <!--  <========SON=========>>> Sablon listesi SON !-->
                                            </select>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php }else { 
        $temacek = $db->prepare("select * from print_tema where id=:id and modul=:modul ");
        $temacek->execute(array(
                'id' => $_GET['theme'],
            'modul' => 'invoice',
        ));
        $temarow = $temacek->fetch(PDO::FETCH_ASSOC);
        ?>
    <?php if($temacek->rowCount()>'0'  ) {?>
            <!-- Css & Javascript & Jquery !-->
            <link href="plugins/printDesignerMy/css/designer.css" rel="stylesheet" type="text/css" />
            <link href="plugins/printDesignerMy/css/colorset.css" rel="stylesheet" type="text/css" />
            <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
            <style>
                .ui-draggable i{
                    margin-right: 5px;
                }
            </style>

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
                                .text(properties.description)
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

            <script src="plugins/printDesignerMy/colorset.js" type="text/javascript"></script>


            <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,700,700i" rel="stylesheet">
            <link href="https://fonts.googleapis.com/css?family=Poppins:400,400i,700,700i" rel="stylesheet">
            <link href="https://fonts.googleapis.com/css?family=Ubuntu+Mono:400,400i,700,700i" rel="stylesheet">
            <!--  <========SON=========>>> Css & Javascript & Jquery SON !-->
        <div class="pl-3 pr-3 d-none d-md-block" style="width: 95%; margin: 0 auto;">
            <form action="post.php?process=print_theme_post&status=invoice_edit" method="post" enctype="multipart/form-data" >
             <input type="hidden" type="hidden" id="themeCode" name="kod" value="<?=$temarow['kod']?>" />
             <input type="hidden" name="themeId" value="<?=$temarow['id']?>">
            <div class="row">
                <div class="col-md-12 mb-2">
                    <a href="pages.php?page=theme_print_invoice" class="btn btn-sm btn-dark"><i class="fa fa-arrow-left"></i> <?=$diller['adminpanel-text-138']?></a>
                </div>
                <!-- SEçili Tema Ayarları !-->
                <div class="col-md-12">
                    <div class="card mb-2">
                        <div class="card-body">
                            <div class="w-100 d-flex align-items-center justify-content-between flex-wrap">
                                <h5>
                                    <?=$diller['adminpanel-form-text-1533']?>
                                </h5>
                                <a data-toggle="collapse" data-target="#setAcc" aria-expanded="false" aria-controls="collapseForm" class="btn btn-primary text-white">- <?=$diller['adminpanel-text-356']?></a>
                            </div>
                            <div id="accordion" class="accordion" >
                                <div class="collapse show" id="setAcc" data-parent="#accordion">
                                    <div class="border-top border-grey pt-2 mt-2">
                                        <div class="row">
                                            <div class="col-md-12 form-group">
                                                <a href="" data-href="post.php?process=print_theme_post&status=delete&no=<?=$temarow['id']?>"  data-toggle="modal" data-target="#confirm-delete"  class="btn btn-sm btn-danger mt-2"><i class="ti-trash"></i> <?=$diller['adminpanel-form-text-1542']?></a>
                                            </div>
                                            <div class="col-md-3 form-group">
                                                <div class="kustom-checkbox">
                                                    <input type="checkbox" class="individual" id="varsayilan" name='varsayilan' value="1" <?php if($temarow['varsayilan'] == '1' ) { ?>checked<?php }?>>
                                                    <label for="varsayilan"><?=$diller['adminpanel-form-text-1536']?></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="baslik"><?=$diller['adminpanel-form-text-1535']?></label>
                                                <input type="text" autocomplete="off"  name="baslik" value="<?=$temarow['baslik']?>" id="baslik" required class="form-control">
                                            </div>
                                        </div>
                                        <div class="row ">
                                            <div class="col-md-3 form-group">
                                                <label for="width"><?=$diller['adminpanel-form-text-1531']?> (mm)</label>
                                                <input type="number" name="width" value="<?=$temarow['width']?>" id="width" required class="form-control">
                                            </div>
                                            <div class="col-md-3 form-group">
                                                <label for="height"><?=$diller['adminpanel-form-text-1532']?> (mm)</label>
                                                <input type="number" name="height" value="<?=$temarow['height']?>" id="height" required class="form-control">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-12">
                                                <label for="inputGroupFile01_2"><?=$diller['adminpanel-form-text-1537']?>   <small>( png,  jpg, jpeg)</small></label>
                                                <div class="w-100 bg-light border p-3">
                                                    <div class="mx-auto" style=" text-align: center;">
                                                        <?php if($temarow['arkaplan'] == !null ) {?>
                                                            <img class="img-fluid p-1 bg-white border" src="<?=$ayar['site_url']?>i/uploads/<?=$temarow['arkaplan']?>" alt=""style="height: 160px">
                                                            <br>
                                                            <a href="" data-href="post.php?process=print_theme_post&status=bg_delete&no=<?=$temarow['id']?>"  data-toggle="modal" data-target="#confirm-delete"  class="btn btn-sm btn-danger mt-2"><i class="ti-trash"></i> <?=$diller['adminpanel-text-167']?></a>
                                                        <?php }else { ?>
                                                            <img src="assets/images/no-img.jpg" class="img-fluid border p-1" style=" height: 150px; " >
                                                        <?php }?>
                                                    </div>
                                                </div>
                                                <div class="input-group ">
                                                    <div class="custom-file">
                                                        <input type="hidden" name="old_img" value="<?=$temarow['arkaplan']?>">
                                                        <input type="file" class="custom-file-input" id="inputGroupFile01_2" name="arkaplan" >
                                                        <label class="custom-file-label" for="inputGroupFile01_2"><?=$diller['adminpanel-form-text-106']?></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <!-- Şablon Tasrım Ayarları  !-->
                    <div class="card mb-2 " >
                        <div class="card-body">
                            <div class="w-100">
                                <div class="row">
                                    <div class="col-md-12 text-left form-group">
                                        <button name="invoiceEdit" class="btn btn-success"><?=$diller['adminpanel-form-text-1543']?></button>
                                    </div>
                                    <div class="col-md-12 text-right form-group">
                                        <div class="portlet-body " >
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div id="print-designer-toolbar"></div>
                                                </div>
                                                <div class="col-md-12 d-flex align-items-start justify-content-start position-relative">
                                                    <div class="template-invoice-leftbar" style="width: 300px; max-height: <?=$temarow['height']?>mm; overflow-y: auto; box-sizing: border-box; border:1px solid #EBEBEB">
                                                        <div id="print-designer-items" ></div>
                                                    </div>
                                                    <div class="flex-grow-1 ">
                                                        <div class="w-100 ">
                                                            <div id="print-designer-canvas"></div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--  <========SON=========>>> Şablon Tasrım Ayarları  SON !-->
                </div>
                <!--  <========SON=========>>> SEçili Tema Ayarları SON !-->
            </div>
            </form>
        </div>
            <script>
                $(document).ready(function () {

                    $("#themeCode").PrintDesigner({
                        canvasSelector: "#print-designer-canvas",
                        itemSelector: "#print-designer-items",
                        toolbarSelector: "#print-designer-toolbar",
                        paperWidth: <?=$temarow['width']?>,
                        paperHeight: <?=$temarow['height']?>,
                        paperBackgroundUrl: '../i/uploads/<?=$temarow['arkaplan']?>',
                        availableItems: [
                            {"name":"<?=$diller['adminpanel-print-sablon-text-1']?>",
                                "items":[
                                    {"name":"Currency","text":"<?=$diller['adminpanel-print-sablon-text-38']?> {Currency}","description":"{Currency}","icon":"fa fa-angle-right","width":25,"height":7,"fontSize":11,"fontWeight":"normal","fontStyle":"normal","textAlign":"left"},
                                    {"name":"OrderNumber","text":"<?=$diller['adminpanel-print-sablon-text-4']?> {OrderNumber}","description":"{OrderNumber}","icon":"fa fa-angle-right","width":35,"height":7,"fontSize":11,"fontWeight":"normal","fontStyle":"normal","textAlign":"left"},
                                    {"name":"OrderNumberBarcode","text":"<?=$diller['adminpanel-print-sablon-text-5']?> {OrderNumberBarcode}","description":"{OrderNumberBarcode}","icon":"fa fa-angle-right","width":55,"height":7,"fontSize":11,"fontWeight":"normal","fontStyle":"normal","textAlign":"left"},
                                    {"name":"OrderStatus","text":"<?=$diller['adminpanel-print-sablon-text-42']?> {OrderStatus}","description":"{OrderStatus}","icon":"fa fa-angle-right","width":45,"height":7,"fontSize":11,"fontWeight":"normal","fontStyle":"normal","textAlign":"left"},
                                    {"name":"OrderDate","text":"<?=$diller['adminpanel-print-sablon-text-6']?> {OrderDate}","description":"{OrderDate}","icon":"fa fa-angle-right","width":40,"height":7,"fontSize":11,"fontWeight":"normal","fontStyle":"normal","textAlign":"left"},
                                    {"name":"PrintDate","text":"<?=$diller['adminpanel-print-sablon-text-7']?> {PrintDate}","description":"{PrintDate}","icon":"fa fa-angle-right","width":35,"height":7,"fontSize":11,"fontWeight":"normal","fontStyle":"normal","textAlign":"left"},
                                    {"name":"PrintHour","text":"<?=$diller['adminpanel-print-sablon-text-8']?> {PrintHour}","description":"{PrintHour}","icon":"fa fa-angle-right","width":35,"height":7,"fontSize":11,"fontWeight":"normal","fontStyle":"normal","textAlign":"left"},
                                    {"name":"OrderType","text":"<?=$diller['adminpanel-print-sablon-text-9']?> {OrderType}","description":"{OrderType}","icon":"fa fa-angle-right","width":35,"height":7,"fontSize":11,"fontWeight":"normal","fontStyle":"normal","textAlign":"left"},
                                    {"name":"ShippingCompany","text":"<?=$diller['adminpanel-print-sablon-text-10']?> {ShippingCompany}","description":"{ShippingCompany}","icon":"fa fa-angle-right","width":43,"height":7,"fontSize":11,"fontWeight":"normal","fontStyle":"normal","textAlign":"left"},
                                    {"name":"TrackCode","text":"<?=$diller['adminpanel-print-sablon-text-11']?> {TrackCode}","description":"{TrackCode}","icon":"fa fa-angle-right","width":40,"height":7,"fontSize":11,"fontWeight":"normal","fontStyle":"normal","textAlign":"left"},
                                    {"name":"ShippingAmount","text":"<?=$diller['adminpanel-print-sablon-text-12']?> {ShippingAmount}","description":"{ShippingAmount}","icon":"fa fa-angle-right","width":40,"height":7,"fontSize":11,"fontWeight":"normal","fontStyle":"normal","textAlign":"left"},
                                    {"name":"ShippingExtraAmount","text":"<?=$diller['adminpanel-print-sablon-text-14']?> {ShippingExtraAmount}","description":"{ShippingExtraAmount}","icon":"fa fa-angle-right","width":40,"height":7,"fontSize":10,"fontWeight":"normal","fontStyle":"normal","textAlign":"left"},
                                    {"name":"DiscountAmount","text":"<?=$diller['adminpanel-print-sablon-text-13']?> {DiscountAmount}","description":"{DiscountAmount}","icon":"fa fa-angle-right","width":40,"height":7,"fontSize":11,"fontWeight":"normal","fontStyle":"normal","textAlign":"left"},
                                    {"name":"OrderSubTotal","text":"<?=$diller['adminpanel-print-sablon-text-18']?> {OrderSubTotal}","description":"{OrderSubTotal}","icon":"fa fa-angle-right","width":40,"height":7,"fontSize":11,"fontWeight":"normal","fontStyle":"normal","textAlign":"left"},
                                    {"name":"OrderVatTotal","text":"<?=$diller['adminpanel-print-sablon-text-19']?> {OrderVatTotal}","description":"{OrderVatTotal}","icon":"fa fa-angle-right","width":40,"height":7,"fontSize":11,"fontWeight":"normal","fontStyle":"normal","textAlign":"left"},
                                    {"name":"OrderTotal","text":"<?=$diller['adminpanel-print-sablon-text-20']?> {OrderTotal}","description":"{OrderTotal}","icon":"fa fa-angle-right","width":40,"height":7,"fontSize":11,"fontWeight":"normal","fontStyle":"normal","textAlign":"left"},
                                    {"name":"TextOrderTotal","text":"<?=$diller['adminpanel-print-sablon-text-22']?> {TextOrderTotal}","description":"{TextOrderTotal}","icon":"fa fa-angle-right","width":55,"height":7,"fontSize":11,"fontWeight":"normal","fontStyle":"normal","textAlign":"left"},
                                    {"name":"ShippingName","text":"<?=$diller['adminpanel-print-sablon-text-23']?> {ShippingName}","description":"{ShippingName}","icon":"fa fa-angle-right","width":40,"height":7,"fontSize":11,"fontWeight":"normal","fontStyle":"normal","textAlign":"left"},
                                    {"name":"ShippingPhone","text":"<?=$diller['adminpanel-print-sablon-text-24']?> {ShippingPhone}","description":"{ShippingPhone}","icon":"fa fa-angle-right","width":40,"height":7,"fontSize":11,"fontWeight":"normal","fontStyle":"normal","textAlign":"left"},
                                    {"name":"ShippingMail","text":"<?=$diller['adminpanel-print-sablon-text-25']?> {ShippingMail}","description":"{ShippingMail}","icon":"fa fa-angle-right","width":40,"height":7,"fontSize":11,"fontWeight":"normal","fontStyle":"normal","textAlign":"left"},
                                    {"name":"ShippingAddress","text":"<?=$diller['adminpanel-print-sablon-text-26']?> {ShippingAddress}","description":"{ShippingAddress}","icon":"fa fa-angle-right","width":75,"height":7,"fontSize":11,"fontWeight":"normal","fontStyle":"normal","textAlign":"left"},
                                    {"name":"ShippingCity","text":"<?=$diller['adminpanel-print-sablon-text-27']?> {ShippingCity}","description":"{ShippingCity}","icon":"fa fa-angle-right","width":90,"height":7,"fontSize":11,"fontWeight":"normal","fontStyle":"normal","textAlign":"left"},
                                    {"name":"BillingName","text":"<?=$diller['adminpanel-print-sablon-text-28']?> {BillingName}","description":"{BillingName}","icon":"fa fa-angle-right","width":40,"height":7,"fontSize":11,"fontWeight":"normal","fontStyle":"normal","textAlign":"left"},
                                    {"name":"BillingID","text":"<?=$diller['adminpanel-print-sablon-text-29']?> {BillingID}","description":"{BillingID}","icon":"fa fa-angle-right","width":40,"height":7,"fontSize":11,"fontWeight":"normal","fontStyle":"normal","textAlign":"left"},
                                    {"name":"BillingAddress","text":"<?=$diller['adminpanel-print-sablon-text-30']?> {BillingAddress}","description":"{BillingAddress}","icon":"fa fa-angle-right","width":75,"height":7,"fontSize":11,"fontWeight":"normal","fontStyle":"normal","textAlign":"left"},
                                    {"name":"BillingCity","text":"<?=$diller['adminpanel-print-sablon-text-31']?> {BillingCity}","description":"{BillingCity}","icon":"fa fa-angle-right","width":90,"height":7,"fontSize":11,"fontWeight":"normal","fontStyle":"normal","textAlign":"left"},
                                    {"name":"BillingTax","text":"<?=$diller['adminpanel-print-sablon-text-32']?> {BillingTax}","description":"{BillingTax}","icon":"fa fa-angle-right","width":40,"height":7,"fontSize":11,"fontWeight":"normal","fontStyle":"normal","textAlign":"left"},
                                    {"name":"BillingNumberTax","text":"<?=$diller['adminpanel-print-sablon-text-33']?> {BillingNumberTax}","description":"{BillingNumberTax}","icon":"fa fa-angle-right","width":40,"height":7,"fontSize":11,"fontWeight":"normal","fontStyle":"normal","textAlign":"left"},
                                    {"name":"ProductName","text":"<?=$diller['adminpanel-print-sablon-text-35']?> {ProductName}","description":"{ProductName}","icon":"fa fa-angle-right","width":110,"height":7,"fontSize":10,"fontWeight":"normal","fontStyle":"normal","textAlign":"left"},
                                    {"name":"ProductCountAmount","text":"<?=$diller['adminpanel-print-sablon-text-37']?> {ProductCountAmount}","description":"{ProductCountAmount}","icon":"fa fa-angle-right","width":30,"height":7,"fontSize":10,"fontWeight":"normal","fontStyle":"normal","textAlign":"left"},
                                    {"name":"ProductQuantity","text":"<?=$diller['adminpanel-print-sablon-text-39']?> {ProductQuantity}","description":"{ProductQuantity}","icon":"fa fa-angle-right","width":20,"height":7,"fontSize":10,"fontWeight":"normal","fontStyle":"normal","textAlign":"left"},
                                    {"name":"ProductVat","text":"<?=$diller['adminpanel-print-sablon-text-40']?> {ProductVat}","description":"{ProductVat}","icon":"fa fa-angle-right","width":30,"height":7,"fontSize":10,"fontWeight":"normal","fontStyle":"normal","textAlign":"left"},
                                    {"name":"ProductTotalAmount","text":"<?=$diller['adminpanel-print-sablon-text-41']?> {ProductTotalAmount}","description":"{ProductTotalAmount}","icon":"fa fa-angle-right","width":30,"height":7,"fontSize":10,"fontWeight":"normal","fontStyle":"normal","textAlign":"left"},
                                ]
                            },
                        ],
                    });

                });
            </script>
            <div class="d-md-none d-sm-inline-block pl-3 pr-3">
                <div class="row">
                    <div class="col-md-12 mb-2">
                        <a href="pages.php?page=theme_print_invoice" class="btn btn-sm btn-dark"><i class="fa fa-arrow-left"></i> <?=$diller['adminpanel-text-138']?></a>
                    </div>
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body text-center">
                                <i class="fa fa-ban mb-2" style="font-size: 30px;"></i>
                                <br>
                                <h6 style="font-weight: 300;"><?=$diller['adminpanel-text-357']?></h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php }else {
            header('Location:'.$ayar['panel_url'].'pages.php?page=theme_print_invoice');
        }?>
    <?php }?>


<?php }else { ?>
    <div class="wrapper" style="margin-top: 0;">
        <div class="container-fluid">
            <div class="card p-xl-5">
                <h3><?=$diller['adminpanel-text-136']?></h3>
                <h6><?=$diller['adminpanel-text-137']?></h6>
                <div  class="mt-3">
                    <a href="<?=$ayar['panel_url']?>" class="btn btn-primary"><?=$diller['adminpanel-text-138']?></a>
                </div>
            </div>
        </div>
    </div>
<?php }?>

<script>
    $(function () {
        $('#olusturAcc').on('shown.bs.collapse', function (e) {
            $('html,body').animate({
                    scrollTop: $('#olusturAcc').offset().top - 80 },
                500);
        });
    });
    $(function () {
        $('#setAcc').on('shown.bs.collapse', function (e) {
            $('html,body').animate({
                    scrollTop: $('#setAcc').offset().top - 80 },
                500);
        });
    });
</script>
<?php if($_SESSION['collepse_status'] == 'setAcc'  ) {?>
    <script>
        $('#setAcc').addClass('show');
        $('html,body').animate({
                scrollTop: $('#setAcc').offset().top - 80 },
            0);
    </script>
    <?php
    unset($_SESSION['collepse_status'])
    ?>
<?php }?>

