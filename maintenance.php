<?php include 'includes/config/session.php';
$bakimMod = $db->prepare("select * from bakim where id='1' and durum='1' order by id");
$bakimMod->execute();
$row = $bakimMod->fetch(PDO::FETCH_ASSOC);

$socialCount = $db->prepare("select * from sosyal where bakim=:bakim order by sira asc");
$socialCount->execute(array(
        'bakim' => '1',
));
if($bakimMod->rowCount() == '0')
{
    header('Location:'.$siteurl.'');

    exit;

}
?>
<!doctype html>
<html lang="tr">
<head>
    <base href="<?php echo"$ayar[site_url]"?>">
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
    <meta name="viewport"
         if content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $ayar['site_baslik']?></title>
    <meta name="description" content="<?php echo"$ayar[site_desc]" ?>">
    <meta name="keywords" content="<?php echo"$ayar[site_tags]" ?>">
    <meta name="news_keywords" content="<?php echo"$ayar[site_tags]" ?>">
    <meta name="author" content="<?php echo"$ayar[site_baslik]" ?>" />
    <meta itemprop="author" content="<?php echo"$ayar[site_baslik]" ?>" />
    <meta name="robots" content="index follow">
    <meta name="googlebot" content="index follow">
    <meta property="og:type" content="website" />
    <link rel="shortcut icon" href="<?php echo $ayar['site_url'] ?>images/<?php echo $ayar['site_favicon']; ?>">
    <link rel="stylesheet" href="assets/css/line-awesome/css/line-awesome.min.css">
    <link rel="stylesheet" href="assets/css/font-awesome/font-awesome.min.css" />
    <link rel="stylesheet" href="assets/css/maintenance.css" />
    <link rel="stylesheet" href="assets/helper/bootstrap/css/bootstrap.min.css" >
    <!-- Google Fonts
        ======================================================================== -->
    <?php
    $fontCek = $db->prepare("select * from fontlar where durum=:durum ");
    $fontCek->execute(array(
        'durum' => '1'
    ));
    ?>
    <?php foreach ($fontCek as $font) {?>
        <link href="<?=$font['kod']?>" rel="stylesheet">
    <?php }?>
    <!-- Google Fonts End -->
    <style>
        html,
        body{
            margin: 0;
            padding: 0;
            height: 100%;
            width: 100%;
            font-family : '<?=$row['font_select']?>',Sans-serif ;
        }
        <?php if($row['bg'] == !null ) {?>
        .main-left{
            background-image: url("i/uploads/<?=$row['bg']?>") ;
        }
        <?php } ?>
        <?php if($row['ebulten'] == '1' ) {?>
        .newsletter_wrap_in_content_form input{
            font-family : '<?=$row['font_select']?>',Sans-serif ;
        }
        .newsletter_wrap_in_content_form button{
            font-family : '<?=$row['font_select']?>',Sans-serif ;
        }
        <?php }?>
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<body>

<div class="main">

    <?php if($row['bg'] == !null ) {?>
    <!-- Left Background !-->
    <div class="main-left"></div>
    <!--  <========SON=========>>> Left Background SON !-->
    <?php }?>

    <!-- Content !-->
    <div class="main-right" <?php if($row['bg'] == null ) { ?>style="width: 100%" <?php }?>>

        <div class="content-area" <?php if($row['bg'] == null ) { ?>style="margin-top: 0 !important;" <?php }?>>
            <?php if($row['logo'] == !null ) {?>
                <!-- Logo !-->
                <div class="logo">
                    <img src="i/uploads/<?=$row['logo']?>" alt="<?=$row['baslik']?>" style="max-width: 200px; max-height: 200px">
                </div>
                <!--  <========SON=========>>> Logo SON !-->
            <?php }?>


            <!-- Başlık ve Spot !-->
            <div class="h-s">
                <div class="content-h">
                    <?=$row['baslik']?>
                </div>
                <?php if($row['spot'] == !null  ) {?>
                    <div class="content-s">
                        <?=$row['spot']?>
                    </div>
                <?php }?>
            </div>
            <!--  <========SON=========>>> Başlık ve Spot SON !-->


            <?php if($row['tarih_durum'] == '1' ) {?>
                <?php
                $timestamp = date('Y-m-d');
                if($row['tarih'] > $timestamp   ) {?>
                    <!-- CountDown !-->
                    <div class="count-area">
                        <div class="footer" style="margin-bottom: 40px;">
                            <div class="footer-in">
                                <?=$diller['bakim-mod-text10']?>
                            </div>
                        </div>
                            <?php
                            $originalDate = $row['tarih'];
                            $newDate = date("Y-m-d", strtotime($originalDate));
                            ?>
                            <div class='countdown' data-date="<?=$newDate?>"></div>
                    </div>
                    <!--  <========SON=========>>> CountDown SON !-->
                <?php }?>
            <?php }?>


            <?php if($row['ebulten'] == '1' || $row['iletisim'] == '1'  ) {?>
            <div class="button-group">
                <?php if($row['ebulten'] == '1' ) {?>
                <label for="newsletter_side_area" class="button_black">
                    <?=$diller['bakim-mod-text1']?>
                </label>
                <?php } ?>
                <?php if($row['iletisim'] == '1' ) {?>
                <label for="contact_side_area"  class="button_grey">
                    <?=$diller['bakim-mod-text2']?>
                </label>
                <?php } ?>
            </div>
            <?php }?>


            <?php if($row['ebulten'] == '1' ) {?>
                <!-- Left side bar !-->
                <div class="slide-menu">
                    <input id="newsletter_side_area" class="newsletter_side_toggle" type="checkbox" />
                    <div class="newsletter_wrap">


                        <div class="newsletter_wrap_in">
                            <div class="newsletter_wrap_in_close">
                                <label for="newsletter_side_area"><i class="las la-times"></i></label>
                            </div>
                            <div class="newsletter_wrap_in_content">
                                <div class="newsletter_wrap_in_content_hed">
                                    <?=$diller['bakim-mod-text1']?>
                                </div>
                                <div class="newsletter_wrap_in_content_s">
                                    <?=$diller['bakim-mod-text5']?>
                                    <div style="width: 80px; height: 4px; background-color: #000; margin-top: 35px;"></div>
                                </div>
                                <form method="post" action="newsletter-register-form" class="newsletter_wrap_in_content_form">
                                    <input type="email" name="eposta" autocomplete="off" required placeholder="<?=$diller['bakim-mod-text3']?>">
                                    <button name="goAddress">
                                        <?=$diller['bakim-mod-text4']?>
                                    </button>
                                </form>
                            </div>
                        </div>


                    </div>
                    <label for="newsletter_side_area" class="newsletter_side_overlay"></label>
                </div>
                <!-- Left side bar SON !-->
            <?php } ?>

            <?php if($row['iletisim'] == '1' ) {?>
            <!-- Right side bar !-->
            <div class="slide-menu">
                <input id="contact_side_area" class="contact_side_toggle" type="checkbox" />
                <div class="contact_wrap">


                    <div class="contact_wrap_in">
                        <div class="contact_wrap_in_close">
                            <label for="contact_side_area"><i class="las la-times"></i></label>
                        </div>
                            <div class="contact_wrap_in_content">
                                <div class="contact_wrap_in_content_hed">
                                    <?=$diller['bakim-mod-text2']?>
                                </div>
                                <div class="contact_wrap_in_content_s">
                                    <?=$diller['bakim-mod-text6']?>
                                    <div style="width: 80px; height: 4px; background-color: #000; margin-top: 35px;"></div>
                                </div>
                                <?php if($row['tel'] == !null ) {?>
                                    <div class="contact_wrap_in_content_box">
                                        <div class="contact_wrap_in_content_box_i">
                                            <i class="las la-phone"></i>
                                        </div>
                                        <div class="contact_wrap_in_content_box_t">
                                            <a href="tel:<?=$row['tel']?>">
                                                <?=$row['tel']?>
                                            </a>
                                        </div>
                                    </div>
                                <?php }?>
                                <?php if($row['whatsapp'] == !null ) {?>
                                    <div class="contact_wrap_in_content_box">
                                        <div class="contact_wrap_in_content_box_i">
                                            <i class="lab la-whatsapp"></i>
                                        </div>
                                        <div class="contact_wrap_in_content_box_t">
                                            <a href="tel:<?=$row['whatsapp']?>">
                                                <?=$row['whatsapp']?>
                                            </a>
                                        </div>
                                    </div>
                                <?php }?>
                                <?php if($row['eposta'] == !null ) {?>
                                    <div class="contact_wrap_in_content_box">
                                        <div class="contact_wrap_in_content_box_i">
                                            <i class="las la-envelope"></i>
                                        </div>
                                        <div class="contact_wrap_in_content_box_t">
                                            <a href="mailto:<?=$row['eposta']?>">
                                                <?=$row['eposta']?>
                                            </a>
                                        </div>
                                    </div>
                                <?php }?>
                                <?php if($row['adres'] == !null ) {?>
                                    <div class="contact_wrap_in_content_box">
                                        <div class="contact_wrap_in_content_box_i">
                                            <i class="las la-map-marker"></i>
                                        </div>
                                        <div class="contact_wrap_in_content_box_t">
                                                <?=$row['adres']?>
                                        </div>
                                    </div>
                                <?php }?>
                            </div>
                    </div>


                </div>
                <label for="contact_side_area" class="contact_side_overlay"></label>
            </div>
            <!-- Right side bar SON !-->
            <?php } ?>

        </div>


        <?php if($row['sosyal'] == '1' && $socialCount->rowCount()>'0') {?>
        <div class="footer">
            <div class="footer-in">
                <?php foreach ($socialCount as $sos) {?>
                    <a href="<?=$sos['url']?>" target="_blank">
                        <i class="fa <?=$sos['icon']?>"></i>
                    </a>
                <?php }?>
            </div>
        </div>
        <?php } ?>


    </div>
    <!--  <========SON=========>>> Content SON !-->

    
</div>
</body>
<?php if($_SESSION['alert'] == 'success'  ) {?>
    <div class="modal fade" id="successModal" >
        <div class="modal-dialog modal-dialog-centered modal-sm ">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                    <i class="las la-check-circle" style="font-size: 60px ; color: #66B483;"></i>
                    <div style="font-weight: bold; margin-bottom: 20px; font-size: 20px ; color: #66B483;"><?=$diller['bakim-mod-text7']?></div>
                    <div>
                        <?=$diller['bakim-mod-text8']?>
                    </div>
                </div>
                <div class="category-cart-add-success-modal-footer">
                    <button type="button" class=" btn-success  p-2"  style="width: 100%; text-align: center; cursor: pointer; border:0; " data-dismiss="modal"><?=$diller['alert-button-ok']?></button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(window).on("load", function() {
            $('#successModal').modal('show');
        });
        $(window).load(function () {
            $('#successModal').modal('show');
        });
        var $modalDialog = $("#successModal");
        $modalDialog.modal('show');

        setTimeout(function() {
            $modalDialog.modal('hide');
        }, 0);
    </script>
    <?php unset($_SESSION['alert']) ?>
<?php }?>
<?php if($_SESSION['alert'] == 'epostasorun'  ) {?>
    <div class="modal fade" id="successModal" >
        <div class="modal-dialog modal-dialog-centered modal-sm ">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                    <i class="las la-exclamation-circle" style="font-size: 60px ; color: #DA7A72;"></i>
                    <div style="font-weight: bold; margin-bottom: 20px; font-size: 20px ; color: #DA7A72;"><?=$diller['alert-warning']?></div>
                    <div>
                        <?=$diller['alert-warning-eposta-hata']?>
                    </div>
                </div>
                <div class="category-cart-add-success-modal-footer">
                    <button type="button" class=" btn-success  p-2"  style="width: 100%; text-align: center; cursor: pointer; border:0; " data-dismiss="modal"><?=$diller['alert-button-ok']?></button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(window).on("load", function() {
            $('#successModal').modal('show');
        });
        $(window).load(function () {
            $('#successModal').modal('show');
        });
        var $modalDialog = $("#successModal");
        $modalDialog.modal('show');

        setTimeout(function() {
            $modalDialog.modal('hide');
        }, 0);
    </script>
    <?php unset($_SESSION['alert']) ?>
<?php }?>
<?php if($_SESSION['alert'] == 'bos'  ) {?>
    <div class="modal fade" id="successModal" >
        <div class="modal-dialog modal-dialog-centered modal-sm ">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                           <i class="las la-exclamation-circle" style="font-size: 60px ; color: #DA7A72;"></i>
                    <div style="font-weight: bold; margin-bottom: 20px; font-size: 20px ; color: #DA7A72;"><?=$diller['alert-warning']?></div>
                    <div>
                        <?=$diller['alert-warning-bos-alan']?>
                    </div>
                </div>
                <div class="category-cart-add-success-modal-footer">
                    <button type="button" class=" btn-success  p-2"  style="width: 100%; text-align: center; cursor: pointer; border:0; " data-dismiss="modal"><?=$diller['alert-button-ok']?></button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(window).on("load", function() {
            $('#successModal').modal('show');
        });
        $(window).load(function () {
            $('#successModal').modal('show');
        });
        var $modalDialog = $("#successModal");
        $modalDialog.modal('show');

        setTimeout(function() {
            $modalDialog.modal('hide');
        }, 0);
    </script>
    <?php unset($_SESSION['alert']) ?>
<?php }?>
</html>
<script>
    (function ( $ ) {
        function pad(n) {
            return (n < 10) ? ("0" + n) : n;
        }

        $.fn.showclock = function() {

            var currentDate=new Date();
            var fieldDate=$(this).data('date').split('-');
            var fieldTime=[0,0];
            if($(this).data('time')!=undefined)
                fieldTime=$(this).data('time').split(':');
            var futureDate=new Date(fieldDate[0],fieldDate[1]-1,fieldDate[2],fieldTime[0],fieldTime[1]);
            var seconds=futureDate.getTime() / 1000 - currentDate.getTime() / 1000;

            if(seconds<=0 || isNaN(seconds)){
                this.hide();
                return this;
            }

            var days=Math.floor(seconds/86400);
            seconds=seconds%86400;

            var hours=Math.floor(seconds/3600);
            seconds=seconds%3600;

            var minutes=Math.floor(seconds/60);
            seconds=Math.floor(seconds%60);

            var html="";

            if(days!=0){
                html+="<div class='countdown-container days'>"
                html+="<span class='countdown-value days-bottom'>"+pad(days)+"</span>";
                html+="<span class='countdown-heading days-top'><?=$diller['bakim-mod-text11']?></span>";
                html+="</div>";
            }

            html+="<div class='countdown-container hours'>"
            html+="<span class='countdown-value hours-bottom'>"+pad(hours)+"</span>";
            html+="<span class='countdown-heading hours-top'><?=$diller['bakim-mod-text12']?></span>";
            html+="</div>";

            html+="<div class='countdown-container minutes'>"
            html+="<span class='countdown-value minutes-bottom'>"+pad(minutes)+"</span>";
            html+="<span class='countdown-heading minutes-top'><?=$diller['bakim-mod-text13']?></span>";
            html+="</div>";

            html+="<div class='countdown-container seconds'>"
            html+="<span class='countdown-value seconds-bottom'>"+pad(seconds)+"</span>";
            html+="<span class='countdown-heading seconds-top'><?=$diller['bakim-mod-text14']?></span>";
            html+="</div>";

            this.html(html);
        };

        $.fn.countdown = function() {
            var el=$(this);
            el.showclock();
            setInterval(function(){
                el.showclock();
            },1000);

        }

    }(jQuery));

    jQuery(document).ready(function(){
        if(jQuery(".countdown").length>0){
            jQuery(".countdown").each(function(){
                jQuery(this).countdown();
            })

        }
    })
</script>
<script src="assets/helper/bootstrap/js/popper.min.js" ></script>
<script src="assets/helper/bootstrap/js/bootstrap.min.js" ></script>

