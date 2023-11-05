<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php if($odemeayar['sepet_sistemi'] == '1' ) {?>
<?php
$page_header_setting = $db->prepare("select * from page_header where page_id='cart2' order by id");
$page_header_setting->execute();
$pagehead = $page_header_setting->fetch(PDO::FETCH_ASSOC);
include 'includes/func/cartcalc.php';
?>
    <title><?=$diller['teslimat-sayfa-baslik']?> - <?php echo $ayar['site_baslik']?></title>
    <meta name="description" content="<?php echo"$ayar[site_desc]" ?>">
    <meta name="keywords" content="<?php echo"$ayar[site_tags]" ?>">
    <meta name="news_keywords" content="<?php echo"$ayar[site_tags]" ?>">
    <meta name="author" content="<?php echo"$ayar[site_baslik]" ?>" />
    <meta itemprop="author" content="<?php echo"$ayar[site_baslik]" ?>" />
    <meta name="robots" content="index follow">
    <meta name="googlebot" content="index follow">
    <meta property="og:type" content="website" />

    <?php include "includes/config/header_libs.php";?>

    </head>
    <body>
    <?php include 'includes/template/pre-loader.php'?>
    <?php include 'includes/template/header.php'?>
    <?php include 'includes/template/helper/page-headers-stil.php';  ?>
    <style>
        .tooltip{
            font-size: 12px !important ;
        }
        .teslimat-page-main-div{
            font-family : '<?=$odemeayar['sepet_font']?>',Sans-serif ;
        }
    </style>
    <!-- CONTENT AREA ============== !-->
    <?php
    if($OnaySepetSorgusu->rowCount()>'0'  ) {
        if($uyeayar['durum'] == '1' ) {
            if($userSorgusu->rowCount() >'0'  ) {
                include'includes/template/helper/cart/teslimat_uye.php';
            }else{
                if($odemeayar['uyesiz_alisveris'] == '1' ) {
                    include'includes/template/helper/cart/teslimat_nologin.php';
                }else{
                    header('Location:'.$siteurl.'sepet/');
                }
            }
        }else{
            include'includes/template/helper/cart/teslimat_nologin.php';
        }
    }else{
        header('Location:'.$siteurl.'sepet/');
    }
    ?>
    <!-- CONTENT AREA ============== !-->
    <?php include 'includes/template/footer.php'?>
    </body>
    </html>
    <script src="assets/js/phoneFormat.js"></script>
    <?php include "includes/config/footer_libs.php";?>
    <!-- Ülke seçimine göre şehir !-->
    <script type="text/javascript">
        $(document).ready(function(){ /* PREPARE THE SCRIPT */
            $("#ulke").change(function(){ /* WHEN YOU CHANGE AND SELECT FROM THE SELECT FIELD */
                var ulke = $(this).val(); /* GET THE VALUE OF THE SELECTED DATA */
                var dataString = "ulke="+ulke; /* STORE THAT TO A DATA STRING */

                $.ajax({ /* THEN THE AJAX CALL */
                    type: "POST", /* TYPE OF METHOD TO USE TO PASS THE DATA */
                    url: "teslimat-ulke-data", /* PAGE WHERE WE WILL PASS THE DATA */
                    data: dataString, /* THE DATA WE WILL BE PASSING */
                    success: function(result){ /* GET THE TO BE RETURNED DATA */
                        $("#show").html(result); /* THE RETURNED DATA WILL BE SHOWN IN THIS DIV */
                    }
                });

            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function(){ /* PREPARE THE SCRIPT */
            $("#fatura_ulke").change(function(){ /* WHEN YOU CHANGE AND SELECT FROM THE SELECT FIELD */
                var fatura_ulke = $(this).val(); /* GET THE VALUE OF THE SELECTED DATA */
                var dataString = "fatura_ulke="+fatura_ulke; /* STORE THAT TO A DATA STRING */

                $.ajax({ /* THEN THE AJAX CALL */
                    type: "POST", /* TYPE OF METHOD TO USE TO PASS THE DATA */
                    url: "teslimat-ulke-data-fatura", /* PAGE WHERE WE WILL PASS THE DATA */
                    data: dataString, /* THE DATA WE WILL BE PASSING */
                    success: function(result){ /* GET THE TO BE RETURNED DATA */
                        $("#show_fatura").html(result); /* THE RETURNED DATA WILL BE SHOWN IN THIS DIV */
                    }
                });

            });
        });
    </script>
    <!-- Ülke seçimine göre şehir SON !-->

    <!-- Text - to password !-->
    <script>
        $("#postakodu").keyup(function() {
            $("#postakodu").val(this.value.match(/[0-9]*/));
        });
        $("#fatura_postakodu").keyup(function() {
            $("#fatura_postakodu").val(this.value.match(/[0-9]*/));
        });
    </script>
    <!-- Text - to password SON !-->

    <!-- Fatura Tip seçimi !-->
    <script id="rendered-js">
        $('.fatura-secim input').change(function () {
            $(this).closest('.fatura-secim').next('.fatura-secim-bireysel').toggle(this.value == 'fatura_turu1').next('.fatura-secim-kurumsal').toggle(this.value == 'fatura_turu2');
        }).filter(':checked').change();
    </script>
    <script id="rendered-js">
        function checkMe(selected)
        {
            if (selected)
            {
                document.getElementById("faturagir").style.display = "";
            } else

            {
                document.getElementById("faturagir").style.display = "none";
            }

        }
    </script>
    <!-- Fatura Tip seçimi SON !-->

    <!-- Radio Payments Div !-->
    <script>
        var elems = $(':radio.change_radio');
        elems.change(function() {
            var v = $(elems).filter(':checked').val();
            var continer = $('.radio-content');
            //Hide all
            continer.hide();
            continer.filter('[data-radio=' + v + ']').show();
        }).change();
    </script>
    <!--  <========SON=========>>> Radio Payments Div SON !-->
<?php }else { ?>
<?php
header('Location:'.$siteurl.'404');
?>
<?php }?>