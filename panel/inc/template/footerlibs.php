<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/i18n/jquery-ui-timepicker-tr.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src='https://cdn.jsdelivr.net/bootstrap.tagsinput/0.8.0/bootstrap-tagsinput.min.js'></script>
<script src="assets/js/modernizr.min.js"></script>
<script src="assets/js/waves.js"></script>
<script src="assets/js/jquery.slimscroll.js"></script>
<script src="assets/js/bs4inputfilename.js"></script>
<script src="plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<script src='plugins/select//select2.min.js'></script>
<script src="plugins/tinymce/tinymce.min.js"></script>
<script src="plugins/bootstrap-inputmask/bootstrap-inputmask.min.js"></script>
<!-- Alertify js -->
<script src="plugins/alertify/js/alertify.js"></script>
<script src="assets/pages/alertify-init.js"></script>
<script src="assets/js/app.js"></script>
<!-- Dropdown ve Tooltip Bir arada !-->
<script>
    $('[data-toggle-second="tooltip"]').tooltip();
</script>
<!--  <========SON=========>>> Dropdown ve Tooltip Bir arada SON !-->
<div id="waitProcessOverlay">
    <div class="waitProcessIn">
        <div><img src="../images/load.svg" alt=""></div>
        <div><?=$diller['adminpanel-form-text-742']?></div>
    </div>
</div>
<script>
    $('.dropdown-menu').click(function(e) {
        e.stopPropagation();
    });
</script>
<script>
    /* Tüm checkboxları seç */
    $(".selectall").click(function () {
        $(".individual").prop("checked", $(this).prop("checked"));
    });
    /*  <========SON=========>>> Tüm checkboxları seç SON */
    $('#selectall').click(function () {

        $('.individual').prop('checked', !$('.individual').prop('checked'));
        console.log('checked');

    });
</script>
<script>
    /* DataPicker */
    window.onload=function(){
        var dateToday = new Date();
        var selectedDate;
        $("#dateSelected").datepicker(    {
                monthNames: [ "<?=$diller['tarih-text8']?>", "<?=$diller['tarih-text9']?>", "<?=$diller['tarih-text10']?>", "<?=$diller['tarih-text11']?>", "<?=$diller['tarih-text12']?>", "<?=$diller['tarih-text13']?>", "<?=$diller['tarih-text14']?>", "<?=$diller['tarih-text15']?>", "<?=$diller['tarih-text16']?>", "<?=$diller['tarih-text17']?>", "<?=$diller['tarih-text18']?>", "<?=$diller['tarih-text19']?>" ],
                dayNamesMin: [ "<?=$diller['tarih-text-20']?>", "<?=$diller['tarih-text-21']?>", "<?=$diller['tarih-text-22']?>", "<?=$diller['tarih-text-23']?>", "<?=$diller['tarih-text-24']?>", "<?=$diller['tarih-text-25']?>", "<?=$diller['tarih-text-26']?>" ],
                firstDay:1,
                minDate: dateToday,
                dateFormat: "yy-mm-dd",
            },
        );
        var selectedDate;
        $("#date_first").datepicker(    {
                monthNames: [ "<?=$diller['tarih-text8']?>", "<?=$diller['tarih-text9']?>", "<?=$diller['tarih-text10']?>", "<?=$diller['tarih-text11']?>", "<?=$diller['tarih-text12']?>", "<?=$diller['tarih-text13']?>", "<?=$diller['tarih-text14']?>", "<?=$diller['tarih-text15']?>", "<?=$diller['tarih-text16']?>", "<?=$diller['tarih-text17']?>", "<?=$diller['tarih-text18']?>", "<?=$diller['tarih-text19']?>" ],
                dayNamesMin: [ "<?=$diller['tarih-text-20']?>", "<?=$diller['tarih-text-21']?>", "<?=$diller['tarih-text-22']?>", "<?=$diller['tarih-text-23']?>", "<?=$diller['tarih-text-24']?>", "<?=$diller['tarih-text-25']?>", "<?=$diller['tarih-text-26']?>" ],
                firstDay:1,
                dateFormat: "yy-mm-dd",
            changeYear: true,
            showButtonPanel: true,
            },
        );
        $("#date_ends").datepicker(    {
                monthNames: [ "<?=$diller['tarih-text8']?>", "<?=$diller['tarih-text9']?>", "<?=$diller['tarih-text10']?>", "<?=$diller['tarih-text11']?>", "<?=$diller['tarih-text12']?>", "<?=$diller['tarih-text13']?>", "<?=$diller['tarih-text14']?>", "<?=$diller['tarih-text15']?>", "<?=$diller['tarih-text16']?>", "<?=$diller['tarih-text17']?>", "<?=$diller['tarih-text18']?>", "<?=$diller['tarih-text19']?>" ],
                dayNamesMin: [ "<?=$diller['tarih-text-20']?>", "<?=$diller['tarih-text-21']?>", "<?=$diller['tarih-text-22']?>", "<?=$diller['tarih-text-23']?>", "<?=$diller['tarih-text-24']?>", "<?=$diller['tarih-text-25']?>", "<?=$diller['tarih-text-26']?>" ],
                firstDay:1,
                dateFormat: "yy-mm-dd",
            changeYear: true,
            showButtonPanel: true,
            },
        );
        $("#date_first_coupon").datepicker(    {
                monthNames: [ "<?=$diller['tarih-text8']?>", "<?=$diller['tarih-text9']?>", "<?=$diller['tarih-text10']?>", "<?=$diller['tarih-text11']?>", "<?=$diller['tarih-text12']?>", "<?=$diller['tarih-text13']?>", "<?=$diller['tarih-text14']?>", "<?=$diller['tarih-text15']?>", "<?=$diller['tarih-text16']?>", "<?=$diller['tarih-text17']?>", "<?=$diller['tarih-text18']?>", "<?=$diller['tarih-text19']?>" ],
                dayNamesMin: [ "<?=$diller['tarih-text-20']?>", "<?=$diller['tarih-text-21']?>", "<?=$diller['tarih-text-22']?>", "<?=$diller['tarih-text-23']?>", "<?=$diller['tarih-text-24']?>", "<?=$diller['tarih-text-25']?>", "<?=$diller['tarih-text-26']?>" ],
                firstDay:1,
                dateFormat: "yy-mm-dd",
            changeYear: true,
            showButtonPanel: true,
            },
        );
        $("#date_ends_coupon").datepicker(    {
                monthNames: [ "<?=$diller['tarih-text8']?>", "<?=$diller['tarih-text9']?>", "<?=$diller['tarih-text10']?>", "<?=$diller['tarih-text11']?>", "<?=$diller['tarih-text12']?>", "<?=$diller['tarih-text13']?>", "<?=$diller['tarih-text14']?>", "<?=$diller['tarih-text15']?>", "<?=$diller['tarih-text16']?>", "<?=$diller['tarih-text17']?>", "<?=$diller['tarih-text18']?>", "<?=$diller['tarih-text19']?>" ],
                dayNamesMin: [ "<?=$diller['tarih-text-20']?>", "<?=$diller['tarih-text-21']?>", "<?=$diller['tarih-text-22']?>", "<?=$diller['tarih-text-23']?>", "<?=$diller['tarih-text-24']?>", "<?=$diller['tarih-text-25']?>", "<?=$diller['tarih-text-26']?>" ],
                firstDay:1,
                dateFormat: "yy-mm-dd",
            changeYear: true,
            showButtonPanel: true,
            },
        );
    }

    /*  <========SON=========>>> DataPicker SON */
</script>
<!-- Sticky Bar !-->
<script>
    $(function () {
        var top = $('#sidebar').offset().top - parseFloat($('#sidebar').css('marginTop').replace(/auto/, 0));
        var footTop = $('#foot_divider').offset().top - parseFloat($('#foot_divider').css('marginTop').replace(/auto/, 0));

        var maxY = footTop - $('#sidebar').outerHeight();

        $(window).scroll(function (evt) {
            var y = $(this).scrollTop();
            if (y > top) {

                //Quand scroll, ajoute une classe ".fixed" et supprime le Css existant
                if (y < maxY) {
                    $('#sidebar').addClass('fixed').removeAttr('style');
                } else {

                    //Quand la sidebar arrive au footer, supprime la classe "fixed" précèdement ajouté
                    $('#sidebar').removeClass('fixed').css({
                        position: 'absolute',
                        top: maxY - top + 'px' });

                }
            } else {
                $('#sidebar').removeClass('fixed');
            }
        });
    });
</script>
<!--  <========SON=========>>> Sticky Bar SON !-->
<!-- Editor !-->
<script>

    $(document).ready(function(){0<$("#tiny").length&&tinymce.init({selector:"textarea#tiny",
        height:300,
        <?php if($panelayar['editor_dil'] == 'tr' ) {?>
        language: 'tr_TR',
        <?php }?>
        valid_elements : '*[*]',
        <?php if($yetki['demo'] != '1'  ) {?>
        plugins:["advlist autolink link image responsivefilemanager lists charmap print preview hr anchor media  spellchecker","searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime  ","save table contextmenu directionality emoticons  paste textcolor"],
    <?php }else { ?>
        plugins:["advlist autolink link   lists charmap print preview hr anchor   spellchecker","searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime  ","save table contextmenu directionality emoticons  paste textcolor"],
    <?php }?>
        toolbar:"insertfile undo redo | code | fontsizeselect | bold italic forecolor backcolor | l      ink image | responsivefilemanager | media | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect | print preview fullpage | emoticons",
        fontsize_formats: "11px 12px 13px 14px 15px 16px 18px 20px 24px 30px 36px 45px 55px",
        setup : function(ed)
        {
            ed.on('init', function()
            {
                this.getDoc().body.style.fontSize = '14px';
            });
        },
        images_upload_url: 'editor_upload.php',

        // override default upload handler to simulate successful upload
        images_upload_handler: function (blobInfo, success, failure) {
            var xhr, formData;

            xhr = new XMLHttpRequest();
            xhr.withCredentials = false;
            xhr.open('POST', 'editor_upload.php');

            xhr.onload = function() {
                var json;

                if (xhr.status != 200) {
                    failure('HTTP Error: ' + xhr.status);
                    return;
                }

                json = JSON.parse(xhr.responseText);

                if (!json || typeof json.location != 'string') {
                    failure('Invalid JSON: ' + xhr.responseText);
                    return;
                }

                success(json.location);
            };

            formData = new FormData();
            formData.append('file', blobInfo.blob(), blobInfo.filename());

            xhr.send(formData);
        },
        external_filemanager_path:"../assets/responsive_filemanager/filemanager/",
        filemanager_title:"<?=$diller['adminpanel-text-285']?>" ,
        external_plugins: { "filemanager" : "../assets/responsive_filemanager/filemanager/plugin.min.js"},
        style_formats:[{title:"Bold text",inline:"b"},{title:"Red text",inline:"span",styles:{color:"#ff0000"}},{title:"Red header",block:"h1",styles:{color:"#ff0000"}},{title:"Example 1",inline:"span",classes:"example1"},{title:"Example 2",inline:"span",classes:"example2"},{title:"Table styles"},{title:"Table row 1",selector:"tr",classes:"tablerow1"}]})});



</script>
<!--  <========SON=========>>> Editor SON !-->

