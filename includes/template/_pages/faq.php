<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
$islemleriCek = $db->prepare("select * from sss where durum=:durum and dil=:dil order by sira asc ");
$islemleriCek->execute(array(
    'durum' => '1',
    'dil' => $_SESSION['dil']
));
$islemlerAyar = $db->prepare("select * from sss_ayar where id='1'");
$islemlerAyar->execute();
$islemayar = $islemlerAyar->fetch(PDO::FETCH_ASSOC);
?>
<?php
$page_header_setting = $db->prepare("select * from page_header where page_id='faq' order by id");
$page_header_setting->execute();
$pagehead = $page_header_setting->fetch(PDO::FETCH_ASSOC);
?>
<title><?php echo ucwords_tr($diller['altsayfa-sss-title']); ?> - <?php echo $ayar['site_baslik']?></title>
<meta name="description" content="<?php echo"$islemayar[meta_desc]" ?>">
<meta name="keywords" content="<?php echo"$islemayar[tags]" ?>">
<meta name="news_keywords" content="<?php echo"$islemayar[tags]" ?>">
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
    .accordion_main {
        width: 100%;
        text-align: left;
        font-family : '<?=$islemayar['baslik_font']?>',sans-serif ;
    }

    .accordion-header,
    .accordion-body {}

    .accordion__item{
        border-bottom:1px solid #EBEBEB !important;
        margin-bottom: 0}

    .accordion-header {
        padding: 1.5em 1.5em;
        background: #FFF;
        color: #000;
        cursor: pointer;
        font-size:16px;
        font-weight: 600;
        letter-spacing: .05em;
        transition: all .3s;
    }
    .accordion__item:last-child{
        border-bottom:1px solid #EBEBEB !important;
    }


    .accordion-body {
        background: #F8F8F8;
        color: #000;
        display: none;
        width: 100%;
    }

    .accordion-body__contents {
        padding: 20px 20px 40px 20px;
        line-height: 20px;
        font-size: 15px;
        width: 100%;
        letter-spacing: .03em;
        display: flex;
        flex-wrap: wrap;
        justify-content: flex-start;
        align-items: flex-start;
        overflow: hidden;
    }

    .accordion__item.active:last-child .accordion-header {
        border-radius: 0;
    }

    .accordion:first-child > .accordion__item > .accordion-header {
        border-bottom: 1px solid transparent;
    }

    .accordion__item > .accordion-header:before {
        content: "\f3d0";
        font-family: IonIcons;
        font-size: 1.2em;
        float: left;
        margin-right: 15px;
        position: relative;
        transition: .3s all;
        transform: rotate(0deg);
    }

    .accordion__item.active > .accordion-header:before {
        transform: rotate(-180deg);
    }

    .accordion__item.active .accordion-header {
        background: #F8F8F8;
        color:#000;
    }
</style>

<!-- CONTENT AREA ============== !-->


<div id="MainDiv" style="background-color: #<?=$islemayar['detay_bg']?>; width: 100%;  overflow: hidden  ">

    <?php if($pagehead['durum'] == '1' ) {?>
        <div class="page-banner-main" >
            <div class="page-banner-in-text">
                <div class="page-banner-h <?=$pagehead['baslik_space']?>">
                    <?php echo ucwords_tr($diller['altsayfa-sss-title']); ?>
                </div>
                <div class="page-banner-links ">
                    <a href="<?=$ayar['site_url']?>"><i class="fa fa-home"></i> <?=$diller['sayfa-banner-anasayfa']?></a>
                    <span>/</span>
                    <a>
                        <?php echo ucwords_tr($diller['altsayfa-sss-title']); ?>
                    </a>
                </div>
            </div>
            <?php if($pagehead['bg_tip'] == '0'  ) {?>
                <?php if($pagehead['bg_dark'] == '1'  ) { ?>
                    <!-- Karartma Var ise !-->
                    <div style="background: rgba(0,0,0,0.3); width: 100%; height: 100%; position: absolute; top:0; left:0; z-index: 1"></div>
                    <!-- Karartma Var ise !-->
                    <?php
                }}
            ?>
        </div>
    <?php } ?>


    <div class="sss-faq-container-main">

        <?php if($islemayar['nav_durum'] == '1' ) {?>
            <?php include 'includes/template/helper/pages_nav/navigation.php'; ?>
        <?php }?>

        <div class="sss-box-main-div accordion_main js-accordion">
            <?php foreach ($islemleriCek as $sss) { ?>
                <div class="accordion__item js-accordion-item <?php if($islemayar['first_open'] =='1' ) { ?>active<?php }?> ">
                    <div class="accordion-header js-accordion-header" >
                        <?=$sss['soru']?>
                    </div>
                    <div class="accordion-body js-accordion-body">
                        <div class="accordion-body__contents" >
                            <?php if($sss['gorsel'] == !null ) {?>
                                <div class="sss-content-img">
                                    <img src="images/uploads/<?=$sss['gorsel']?>" alt="<?=$sss['soru']?>">
                                </div>
                            <?php }?>
                            <div class="sss-content-txt">
                                <?=$sss['cevap']?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <?php if($islemleriCek->rowCount()<='0'  ) {?>
                <div class="alert alert-secondary " style="width: 100%;  ">
                    <i class="fa fa-ban"></i> Hiç Soru eklenmemiş!
                </div>
            <?php }?>
        </div>


    </div>
</div>

<!-- CONTENT AREA ============== !-->



<?php include 'includes/template/footer.php'?>
</body>
</html>
<script id="rendered-js">
    var accordion = function () {

        var $accordion = $('.js-accordion');
        var $accordion_header = $accordion.find('.js-accordion-header');
        var $accordion_item = $('.js-accordion-item');

        var settings = {
            speed: 300,
            oneOpen: false };


        return {
            // pass configurable object literal
            init: function ($settings) {
                $accordion_header.on('click', function () {
                    accordion.toggle($(this));
                });
                $.extend(settings, $settings);
                // ensure only one accordion is active if oneOpen is true
                if (settings.oneOpen && $('.js-accordion-item.active').length > 1) {
                    $('.js-accordion-item.active:not(:first)').removeClass('active');
                }
                // reveal the active accordion bodies
                $('.js-accordion-item.active').find('> .js-accordion-body').show();
            },
            toggle: function ($this) {

                if (settings.oneOpen && $this[0] != $this.closest('.js-accordion').find('> .js-accordion-item.active > .js-accordion-header')[0]) {
                    $this.closest('.js-accordion').
                    find('> .js-accordion-item').
                    removeClass('active').
                    find('.js-accordion-body').
                    slideUp();
                }

                // show/hide the clicked accordion item
                $this.closest('.js-accordion-item').toggleClass('active');
                $this.next().stop().slideToggle(settings.speed);
            } };

    }();

    $(document).ready(function () {
        accordion.init({ speed: 300, oneOpen: true });
    });
    //# sourceURL=pen.js
</script>
<?php include "includes/config/footer_libs.php";?>

