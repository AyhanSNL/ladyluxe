<?php Header ("Content-type: text/css; charset=utf-8");?>
<?php
error_reporting(0);
ob_start();
include "../../config/config.php";
include "../../config/language.php";
$sliderayar = $db->prepare("select * from slider_ayar where id='1'");
$sliderayar ->execute();
$slidayar = $sliderayar->fetch(PDO::FETCH_ASSOC);
$sliderayar2 = $db->prepare("select * from slider2_ayar where id='1'");
$sliderayar2 ->execute();
$slidayar2 = $sliderayar2->fetch(PDO::FETCH_ASSOC);
$aboutCek = $db->prepare("select * from html_modul where dil=:dil order by id desc limit 1 ");
$aboutCek->execute(array(
    'dil' => $_SESSION['dil']
));
$about = $aboutCek->fetch(PDO::FETCH_ASSOC);
$StorySetting = $db->prepare("select * from story_ayar where id='1' ");
$StorySetting->execute();
$storyayar = $StorySetting->fetch(PDO::FETCH_ASSOC);
$markasettings = $db->prepare("select * from urun_marka_ayar where id='1'");
$markasettings->execute();
$markaset = $markasettings->fetch(PDO::FETCH_ASSOC);
$tKutuAyar = $db->prepare("select * from tkutu_ayar where id='1'");
$tKutuAyar->execute();
$tkutuRow = $tKutuAyar->fetch(PDO::FETCH_ASSOC);
$countersettings = $db->prepare("select * from sayac_ayar where id='1'");
$countersettings->execute();
$countsett = $countersettings->fetch(PDO::FETCH_ASSOC);
$blogAyar = $db->prepare("select * from blog_ayar where id='1'");
$blogAyar->execute();
$blogset = $blogAyar->fetch(PDO::FETCH_ASSOC);
$yorumsettings = $db->prepare("select * from yorum_ayar where id='1'");
$yorumsettings->execute();
$yorumset = $yorumsettings->fetch(PDO::FETCH_ASSOC);
$serviceayar = $db->prepare("select * from hizmet_ayar where id='1'");
$serviceayar->execute();
$serv = $serviceayar->fetch(PDO::FETCH_ASSOC);
$tanVideo = $db->prepare("select * from tanitim_video where id='1'");
$tanVideo->execute();
$tv = $tanVideo->fetch(PDO::FETCH_ASSOC);
$photogallerysettings = $db->prepare("select * from galeri_ayar where id='1'");
$photogallerysettings->execute();
$photoset = $photogallerysettings->fetch(PDO::FETCH_ASSOC);
$bultensettings = $db->prepare("select * from ebulten_ayar where id='1'");
$bultensettings->execute();
$bultenset = $bultensettings->fetch(PDO::FETCH_ASSOC);
$vitrin_tip1_Ayar = $db->prepare("select * from vitrin_tip1_ayar where id='1'");
$vitrin_tip1_Ayar->execute();
$tip1Ayar = $vitrin_tip1_Ayar->fetch(PDO::FETCH_ASSOC);
$FirsatlarVitriniSql = $db->prepare("select * from vitrin_firsat where id='1'");
$FirsatlarVitriniSql->execute();
$firsatRow = $FirsatlarVitriniSql->fetch(PDO::FETCH_ASSOC);
$vitrin_tip2_Ayar = $db->prepare("select * from vitrin_tip2_ayar where id='1'");
$vitrin_tip2_Ayar->execute();
$tip2Ayar = $vitrin_tip2_Ayar->fetch(PDO::FETCH_ASSOC);
$vitrin_tip3_Ayar = $db->prepare("select * from vitrin_tip3_ayar where id='1'");
$vitrin_tip3_Ayar->execute();
$tip3Ayar = $vitrin_tip3_Ayar->fetch(PDO::FETCH_ASSOC);
$secenekVitrin_ayar = $db->prepare("select * from vitrin_secenekli_ayar where id='1'");
$secenekVitrin_ayar->execute();
$secenekRow = $secenekVitrin_ayar->fetch(PDO::FETCH_ASSOC);
$box_gorunum_turu = $secenekRow['secenekvitrin_grid_sayi'];
$urunKutuAyar = $db->prepare("select * from urun_kutu where id='1'");
$urunKutuAyar->execute();
$urunKutuRow = $urunKutuAyar->fetch(PDO::FETCH_ASSOC);

?>



/* Story Slider */
.story-slider {
width: 100%;
height: 100%;
position: relative;
}
.story-slider .swiper-slide {
text-align: center;
overflow: hidden;
display: flex;
justify-content: center;
align-items: center;
}
.story-slider:hover .swiper-button-next{
background: linear-gradient(90deg, rgba(255, 255, 255, 0) 0%, #<?=$storyayar['arkaplan']?> 100%) !important;
}
.story-slider .swiper-button-next {
background-image: none;
}
.story-slider .swiper-button-next:before{
font-family: FontAwesome;
content: "\f105";
font-size: 35px ;
position: absolute;
right: 10px;
margin-top: 40px;
color: #<?=$storyayar['renk']?>;
}
.story-slider:hover .swiper-button-next {
box-sizing:border-box;
-webkit-transform: translateX(0);
transform: translateX(0);
opacity: 1;
visibility: visible;
position: absolute;
width: 125px;
height: 290px;
top:0;
z-index: 9;
cursor: pointer;
background-size: 15px 100px;
background-position: center;
background-repeat: no-repeat;
margin-right: -10px;
}
.story-slider .swiper-button-next {
top: 0;
margin-right: -40px;
}


@media screen and (max-width:768px) and (min-width:0) {
.story-slider .swiper-button-next {
opacity: 1;
visibility: visible;
width: 145px;
height: 290px;
right: -12px;
}
.story-slider .swiper-button-next{
background: linear-gradient(90deg, rgba(255, 255, 255, 0) 0%, #<?=$storyayar['arkaplan']?> 100%) !important;
}
}





.about-module-main-div-boxed{
<?php if($about['bg_tip'] == '1'  ) {?>
    background:#<?=$about['bg_color']?> ;
<?php }else { ?>
    background-image:url("../../images/uploads/<?=$about['bg_image']?>") ;
    background-size: cover;
    background-position:top center;
    <?php if($about['bg_durum'] == '1' ) {?>
        background-attachment: fixed;
    <?php }?>
<?php }?>
border:1px solid #<?=$about['modul_border']?>;
padding:<?=$about['padding']?>px 0;
margin-top: <?=$about['margin']?>px;
margin-bottom: <?=$about['margin']?>px;
}

.about-module-main-div{
<?php if($about['bg_tip'] == '1'  ) {?>
    background:#<?=$about['bg_color']?> ;
<?php }else { ?>
    background-image:url("../../images/uploads/<?=$about['bg_image']?>") ;
    background-size: cover;
    background-position:top center;
    <?php if($about['bg_durum'] == '1' ) {?>
        background-attachment: fixed;
    <?php }?>
<?php }?>
border-top:1px solid #<?=$about['modul_border']?>;
border-bottom:1px solid #<?=$about['modul_border']?>;
padding:<?=$about['padding']?>px 0;
margin-top: <?=$about['margin']?>px;
margin-bottom: <?=$about['margin']?>px;
}
.about-module-leftside-txt{
font-family : '<?=$about['baslik_font']?>',sans-serif ;
}
.about-module-rightside-txt{
font-family : '<?=$about['baslik_font']?>',sans-serif ;
}


.about-module-main-div{
<?php if($about['bg_tip'] == '1'  ) {?>
    background:#<?=$about['bg_color']?> ;
<?php }else { ?>
    background-image:url("../../images/uploads/<?=$about['bg_image']?>") ;
    background-size: cover;
    background-position:top center;
    <?php if($about['bg_durum'] == '1' ) {?>
        background-attachment: fixed;
    <?php }?>
<?php }?>
border-top:1px solid #<?=$about['modul_border']?>;
border-bottom:1px solid #<?=$about['modul_border']?>;
padding:<?=$about['padding']?>px 0;
margin-top: <?=$about['margin']?>px;
margin-bottom: <?=$about['margin']?>px;
}
.about-module-leftside-txt{
font-family : '<?=$about['baslik_font']?>',sans-serif ;
}
.about-module-center-txt{
font-family : '<?=$about['baslik_font']?>',sans-serif ;
}
.about-module-rightside-txt{
font-family : '<?=$about['baslik_font']?>',sans-serif ;
}



.marka-module-main-div{
<?php if($markaset['bg_tip'] == '1'  ) {?>
    background:#<?=$markaset['bg_color']?> ;
<?php }else { ?>
    background-image:url("../../images/uploads/<?=$markaset['bg_image']?>") ;
    background-size: cover;
    background-position:top center;
    <?php if($markaset['bg_durum'] == '1' ) {?>
        background-attachment: fixed;
    <?php }?>
<?php }?>
padding:<?=$markaset['padding']?>px 0;
margin: <?=$markaset['margin']?>px 0;
border-top: 1px solid #<?=$markaset['modul_border']?>;
border-bottom: 1px solid #<?=$markaset['modul_border']?>;
}

.swiper-clients {
width: 100%;
height: 100%;
position: relative;
}
.swiper-clients .swiper-slide {
text-align: center;
padding: 5px 10px;
height: 85px;
overflow: hidden;
display: flex;
justify-content: center;
align-items: center;
}
.swiper-clients .swiper-slide img{
max-height: 90px;
max-width: 90%;
}



/* Üst Slider için devam */
@media screen and (max-width:374px) and (min-width:0px) {
.swiper-container {
<?php if($slidayar['slider_width'] == '0' ) {?>
    width: 100% !important;
<?php }?>
<?php if($slidayar['slider_width'] == '1' ) {?>
    width: 93% !important;
<?php }?>
height: <?=$slidayar['mobil_height']-40?>px !important;
}
}
@media screen and (max-width:409px) and (min-width:375px) {
.swiper-container {
<?php if($slidayar['slider_width'] == '0' ) {?>
    width: 100% !important;
<?php }?>
<?php if($slidayar['slider_width'] == '1' ) {?>
    width: 93% !important;
<?php }?>
height: <?=$slidayar['mobil_height']?>px !important;
}
}
@media screen and (max-width:599px) and (min-width:410px) {
.swiper-container {
<?php if($slidayar['slider_width'] == '0' ) {?>
    width: 100% !important;
<?php }?>
<?php if($slidayar['slider_width'] == '1' ) {?>
    width: 93% !important;
<?php }?>
height: <?=$slidayar['mobil_height']+20?>px !important;
}
}
@media screen and (max-width:767px) and (min-width:600px) {
.swiper-container {
<?php if($slidayar['slider_width'] == '0' ) {?>
    width: 100% !important;
<?php }?>
<?php if($slidayar['slider_width'] == '1' ) {?>
    width: 93% !important;
<?php }?>
height: <?=$slidayar['mobil_height']+50?>px !important;
}
}
@media screen and (max-width:1023px) and (min-width:768px) {
.swiper-container {
<?php if($slidayar['slider_width'] == '0' ) {?>
    width: 100% !important;
<?php }?>
<?php if($slidayar['slider_width'] == '1' ) {?>
    width: 93% !important;
<?php }?>
height: <?=$slidayar['mobil_height']+70?>px !important;
}
.slider_text_inside_box_h{
<?php if($slidayar['baslik_size'] >= '70'  ) {?>
    font-size: <?=$slidayar['baslik_size']-25?>px !important ;
    line-height: <?=$slidayar['baslik_size']-25?>px !important ;
<?php }else { ?>
    font-size: <?=$slidayar['baslik_size']?>px !important ;
    line-height: <?=$slidayar['baslik_size']?>px !important ;
<?php }?>
}
}
@media screen and (max-width:1151px) and (min-width:1024px) {
.swiper-container {
<?php if($slidayar['slider_width'] == '0' ) {?>
    width: 100% !important;
<?php }?>
<?php if($slidayar['slider_width'] == '1' ) {?>
    width: 93% !important;
<?php }?>
height: <?=$slidayar['height']-55?>px !important;
}
.slider_text_inside_box_h{
<?php if($slidayar['baslik_size'] >= '70'  ) {?>
    font-size: <?=$slidayar['baslik_size']-25?>px !important ;
    line-height: <?=$slidayar['baslik_size']-25?>px !important ;
<?php }else { ?>
    font-size: <?=$slidayar['baslik_size']?>px !important ;
    line-height: <?=$slidayar['baslik_size']?>px !important ;
<?php }?>
}
}
@media screen and (max-width:1279px) and (min-width:1152px) {
.swiper-container {
<?php if($slidayar['slider_width'] == '0' ) {?>
    width: 100% !important;
<?php }?>
<?php if($slidayar['slider_width'] == '1' ) {?>
    width: 93% !important;
<?php }?>
height: <?=$slidayar['height']-40?>px !important;
}
.slider_text_inside_box_h{
<?php if($slidayar['baslik_size'] >= '70'  ) {?>
    font-size: <?=$slidayar['baslik_size']-25?>px !important ;
    line-height: <?=$slidayar['baslik_size']-25?>px !important ;
<?php }else { ?>
    font-size: <?=$slidayar['baslik_size']?>px !important ;
    line-height: <?=$slidayar['baslik_size']?>px !important ;
<?php }?>
}
}

@media screen and (max-width:1300px) and (min-width:1280px) {
.swiper-container {
<?php if($slidayar['slider_width'] == '0' ) {?>
    width: 100% !important;
<?php }?>
<?php if($slidayar['slider_width'] == '1' ) {?>
    width: 1200px !important;
<?php }?>
height: <?=$slidayar['height']-10?>px !important;
}
.slider_text_inside_box_h{
<?php if($slidayar['baslik_size'] >= '70'  ) {?>
    font-size: <?=$slidayar['baslik_size']-25?>px !important ;
    line-height: <?=$slidayar['baslik_size']-25?>px !important ;
<?php }else { ?>
    font-size: <?=$slidayar['baslik_size']?>px !important ;
    line-height: <?=$slidayar['baslik_size']?>px !important ;
<?php }?>
}
}

@media screen and (max-width:1600px) and (min-width:1441px) {
.swiper-container{  height: <?=$slidayar['height']?>px; }
}
@media screen and (max-width:1680px) and (min-width:1601px) {
.swiper-container{  height: <?=$slidayar['height']?>px; }
}
.swiper-container {
height: <?=$slidayar['height']?>px;
<?php if($slidayar['slider_width'] == '0' ) {?>
    width: 100%;
<?php }?>
<?php if($slidayar['slider_width'] == '1' ) {?>
    width: 1300px;
<?php }?>
margin: 0 auto;
margin-bottom: <?=$slidayar['margin']?>px;
margin-top: <?=$slidayar['margin']?>px;
}


.swiper-slide {
width: 100% ;
height: 100%;
display: flex;
align-items: center;
justify-content: center;
display: -webkit-box;
display: -ms-flexbox;
display: -webkit-flex;
}


[class^="swiper-button-"] {
-webkit-transition: all .3s ease;
transition: all .3s ease;
}
[class^="swiper-button-"] {
width: 44px;
opacity: 0;
visibility: hidden;
}
.swiper-button-prev {
-webkit-transform: translateX(50px);
transform: translateX(50px);
}
.swiper-button-next {
-webkit-transform: translateX(-50px);
transform: translateX(-50px);
}
.swiper-container:hover .swiper-button-prev,
.swiper-container:hover .swiper-button-next {
-webkit-transform: translateX(0);
transform: translateX(0);
opacity: 1 !important;
visibility: visible;
}
.swiper-pagination-bullet-active {
width: 28px!important;
height: 7px!important;
opacity: 1 !important;
background-color: #<?=$slidayar['dots_renk']?> !important;
}
.swiper-container [class^="swiper-pagination-bullet"]{
width: 13px;
height: 7px;
border-radius:100px !important;
transition: all .3s ease;
opacity:.7;
background: #fff
}
/*  <========SON=========>>> Üst Slider için devam SON */









/* Sayaç */
.counter-module-main-div{
border-top: 1px solid #<?=$countsett['sayacayar_border']?>;
border-bottom: 1px solid #<?=$countsett['sayacayar_border']?>;
<?php if($countsett['bg_tip'] == '1'  ) {?>
    background:#<?=$countsett['bg_color']?> ;
<?php }else { ?>
    background-image:url("../../images/uploads/<?=$countsett['bg_image']?>") ;
    background-size: cover;
    background-position:top center;
    <?php if($countsett['bg_durum'] == '1' ) {?>
        background-attachment: fixed;
    <?php }?>
<?php }?>
padding:<?=$countsett['padding']?>px 0;
margin: <?=$countsett['margin']?>px 0;
font-family : '<?=$countsett['yazi_font']?>',sans-serif ;
}



/* Blog */
.bloglar-module-main-div{
border-top: 1px solid #<?=$blogset['blogayar_border']?>;
border-bottom: 1px solid #<?=$blogset['blogayar_border']?>;
font-family : '<?=$blogset['baslik_font']?>',sans-serif ;
<?php if($blogset['bg_tip'] == '1'  ) {?>
    background:#<?=$blogset['bg_color']?> ;
<?php }else { ?>
    background-image:url("../../images/uploads/<?=$blogset['bg_image']?>") ;
    background-size: cover;
    background-position:top center;
    <?php if($blogset['bg_durum'] == '1' ) {?>
        background-attachment: fixed;
    <?php }?>
<?php }?>
padding:<?=$blogset['padding']?>px 0;
margin: <?=$blogset['margin']?>px 0;
}


/* Comments */
.yorumlar-module-main-div{
border-top: 1px solid #<?=$yorumset['yorumayar_border']?>;
border-bottom: 1px solid #<?=$yorumset['yorumayar_border']?>;
font-family : '<?=$yorumset['baslik_font']?>',sans-serif ;
<?php if($yorumset['bg_tip'] == '1'  ) {?>
    background:#<?=$yorumset['bg_color']?> ;
<?php }else { ?>
    background-image:url("../../images/uploads/<?=$yorumset['bg_image']?>") ;
    background-size: cover;
    background-position:top center;
    <?php if($yorumset['bg_durum'] == '1' ) {?>
        background-attachment: fixed;
    <?php }?>
<?php }?>
padding:<?=$yorumset['padding']?>px 0;
margin: <?=$yorumset['margin']?>px 0;
}
.swiper-comments .swiper-slide {
width: 100%;
display: block;
box-sizing: border-box;
text-align: center;
cursor: grab;
}
.swiper-comments .swiper-pagination-bullet-active {
width: 22px!important;
height: 8px!important;
border-radius: 100px !important;
background-color: #<?=$yorumset['dots_renk']?> !important;
}
.swiper-comments [class^="swiper-pagination-bullet"]{
width: 13px;
height: 8px;
border-radius: 100px !important;
transition: all .3s ease;
opacity:.2;
}


/* Hizmetler */
.hizmetler-module-main-div{
border-top: 1px solid #<?=$serv['hizmetayar_border']?>;
border-bottom: 1px solid #<?=$serv['hizmetayar_border']?>;

font-family : '<?=$serv['baslik_font']?>',sans-serif ;
<?php if($serv['bg_tip'] == '1'  ) {?>
    background:#<?=$serv['bg_color']?> ;
<?php }else { ?>
    background-image:url("../../images/uploads/<?=$serv['bg_image']?>") ;
    background-size: cover;
    background-position:top center;
    <?php if($serv['bg_durum'] == '1' ) {?>
        background-attachment: fixed;
    <?php }?>
<?php }?>
padding:<?=$serv['padding']?>px 0;
margin: <?=$serv['margin']?>px 0;
}




/* Tanıtım Videosu */
.intro-video-module-main-div{
<?php if($tv['bg_tip'] == '1'  ) {?>
    background:#<?=$tv['bg_color']?> ;
<?php }else { ?>
    background-image:url("../../images/uploads/<?=$tv['bg_image']?>") ;
    background-size: cover;
    background-position:top center;
    <?php if($tv['bg_durum'] == '1' ) {?>
        background-attachment: fixed;
    <?php }?>
<?php }?>
padding:<?=$tv['padding']?>px 0;
margin: <?=$tv['margin']?>px 0;
}
.video-play-button:before {
background: #<?=$tv['button_ani_renk']?>;
}
.video-play-button:after {
background: #<?=$tv['button_renk']?>;
}
.video-play-button:hover:after {
background-color: #<?=$tv['button_hover_renk']?>;
}
.video-play-button span {
border-left: 32px solid #<?=$tv['button_play_renk']?>;
}

/* foto galeri */
.pgallery-module-main-div{
border-top: 1px solid #<?=$photoset['galeriayar_border']?>;
border-bottom: 1px solid #<?=$photoset['galeriayar_border']?>;
<?php if($photoset['bg_tip'] == '1'  ) {?>
    background:#<?=$photoset['bg_color']?> ;
<?php }else { ?>
    background-image:url("../../images/uploads/<?=$photoset['bg_image']?>") ;
    background-size: cover;
    background-position:top center;
    <?php if($photoset['bg_durum'] == '1' ) {?>
        background-attachment: fixed;
    <?php }?>
<?php }?>
padding:<?=$photoset['padding']?>px 0;
margin: <?=$photoset['margin']?>px 0;
}
<?php if($photoset['width'] == '1' ) {?>
    .pgallery-module-inside-area{
    width: 93%;
    }
<?php }?>

/* E-bülten */
.bultenn-module-main-div{
border-top: 1px solid #<?=$bultenset['ebulten_border']?>;
border-bottom: 1px solid #<?=$bultenset['ebulten_border']?>;
font-family : '<?=$bultenset['baslik_font']?>',sans-serif ;
<?php if($bultenset['bg_tip'] == '1'  ) {?>
    background:#<?=$bultenset['bg_color']?> ;
<?php }else { ?>
    background-image:url("../../images/uploads/<?=$bultenset['bg_image']?>") ;
    background-size: cover;
    background-position:top center;
    <?php if($bultenset['bg_durum'] == '1' ) {?>
        background-attachment: fixed;
    <?php }?>
<?php }?>
padding:<?=$bultenset['padding']?>px 0;
margin: <?=$bultenset['margin']?>px 0;
}



/* orta slider */
@media screen and (max-width:374px) and (min-width:0px) {
.swiper-middle-container {
width: 93% !important; margin: 0 auto;
height: <?=$slidayar2['mobil_height']-20?>px !important;
}
.swiper-middle-container .swiper-slide img{
width:100% !important;
height:<?=$slidayar2['mobil_height']-20?>px !important;
}
}
@media screen and (max-width:409px) and (min-width:375px) {
.swiper-middle-container {
width: 93% !important; margin: 0 auto;
height: <?=$slidayar2['mobil_height']?>px !important;
}
.swiper-middle-container .swiper-slide img{
width:100% !important;
height:<?=$slidayar2['mobil_height']?>px !important;
}
}
@media screen and (max-width:599px) and (min-width:410px) {
.swiper-middle-container {
width:  93% !important; margin: 0 auto;
height: <?=$slidayar2['mobil_height']+15?>px !important;
}
.swiper-middle-container .swiper-slide img{
width:100% !important;
height:<?=$slidayar2['mobil_height']+15?>px !important;
}
}
@media screen and  (max-width:599px ) and (min-width:540px ){
.swiper-middle-container {
width:  93% !important; margin: 0 auto;
height: <?=$slidayar2['mobil_height']+55?>px !important;
}
.swiper-middle-container .swiper-slide img{
width:100% !important;
height:<?=$slidayar2['mobil_height']+55?>px !important;
}
}
@media screen and (max-width:767px) and (min-width:600px) {
.swiper-middle-container {
width:  93% !important; margin: 0 auto;
height: <?=$slidayar2['mobil_height']+80?>px !important;
}
.swiper-middle-container .swiper-slide img{
width:100% !important;
height:<?=$slidayar2['mobil_height']+80?>px !important;
}
}
@media screen and (max-width:1023px) and (min-width:768px) {
.swiper-middle-container .swiper-slide .middle-slider-img-mobile,
.swiper-middle-container .swiper-slide{
width:100% !important;
}
.swiper-middle-container {
width:  93% !important;
height: <?=$slidayar2['mobil_height']+135?>px !important;
}
.swiper-middle-container .swiper-slide img{
width:100% !important;
height:<?=$slidayar2['mobil_height']+135?>px !important;
}
}
@media screen and (max-width:1151px) and (min-width:1024px) {
.swiper-middle-container .swiper-slide .middle-slider-img-mobile,
.swiper-middle-container .swiper-slide{
width:100% !important;
}
.swiper-middle-container {
width:  93% !important;
height: <?=$slidayar2['height']-85?>px !important;
}
.swiper-middle-container .swiper-slide img{
width:100% !important;
height:<?=$slidayar2['height']-85?>px !important;
}
}

@media screen and (max-width:1279px) and (min-width:1152px) {
.swiper-middle-container {
width:  93% !important;
height: <?=$slidayar2['height']-50?>px !important;
}
.swiper-middle-container .swiper-slide img{
width:100% !important;
height:<?=$slidayar2['height']-50?>px !important;
}
}
@media screen and (max-width:1359px) and (min-width:1280px) {
.swiper-middle-container{  height: <?=$slidayar2['height']?>px; }
.swiper-middle-container {
width:  1200px !important;
height: <?=$slidayar2['height']-30?>px !important;
}
.swiper-middle-container .swiper-slide img{
width:100% !important;
height:<?=$slidayar2['height']-30?>px !important;
}
}
@media screen and (max-width:1600px) and (min-width:1441px) {
.swiper-middle-container{  height: <?=$slidayar2['height']?>px; }
.swiper-middle-container .swiper-slide img{
width:100% !important;
height:<?=$slidayar2['height']?>px !important;
}
}
@media screen and (max-width:1680px) and (min-width:1601px) {
.swiper-middle-container{  height: <?=$slidayar2['height']?>px; }
.swiper-middle-container .swiper-slide img{
width:100% !important;
height:<?=$slidayar2['height']?>px !important;
}
}

.swiper-middle-container {
width:1280px;
height: <?=$slidayar2['height']?>px;
margin: 0 auto;
margin-bottom: <?=$slidayar2['padding']?>px;
margin-top: <?=$slidayar2['padding']?>px;
}

.swiper-middle-container .swiper-slide img{
border-radius: <?=$slidayar2['radius']?>px
}

.swiper-middle-container:hover .swiper-button-prev,
.swiper-middle-container:hover .swiper-button-next {
-webkit-transform: translateX(0);
transform: translateX(0);
opacity: 1;
visibility: visible;
}


/* Story İçerikleri */
.story-main-div{
width: 100%;
font-family : '<?=$storyayar['font_select']?>',Arial ;
font-size: 13px ;
background-color: #<?=$storyayar['arkaplan']?>;
margin: <?=$storyayar['margin']?>px 0;
border-top:1px solid #<?=$storyayar['border_color']?>;
border-bottom:1px solid #<?=$storyayar['border_color']?>;
padding: <?=$storyayar['padding']?>px 0;
}

.story-group-box{
color:#<?=$storyayar['renk']?>
}
.story-group-box:hover{
color:#<?=$storyayar['renk']?>;
text-decoration:none;
}

.item-link .info strong{
color:#<?=$storyayar['renk']?>
}
.stories.snapgram .story > .item-link{
color:#<?=$storyayar['renk']?> !important;
}

.stories.carousel::-webkit-scrollbar-track {
background-color: #<?=$storyayar['scroll_pasif']?>;
}
.stories.carousel::-webkit-scrollbar {
height: 3px;
}
.stories.carousel::-webkit-scrollbar-thumb {
background-color: #<?=$storyayar['scroll_bg']?>;
}


/* Kategorili Ürün Vitrini */
.cat-detail-products-box-caturunvitrin {
border: <?=$urunKutuRow['border_width']?> solid #<?=$urunKutuRow['kutu_border_renk']?>;
background-color: #<?=$urunKutuRow['kutu_arkaplan']?>;
border-radius: <?=$urunKutuRow['kutu_radius']?>;
<?php if($urunKutuRow['kutu_shadow'] == '0'  ) {?> box-shadow: none !important;
<?php }?>
}
<?php if($tip1Ayar['vitrin_grid'] == '3'  ) {?>
    .cat-detail-products-box-caturunvitrin{
    width: 31.83%;
    }
    .cat-detail-products-box-caturunvitrin-img{
    width: 100%;
    margin-bottom: 15px;
    overflow: hidden;
    position: relative;
    }
    .cat-detail-products-box-caturunvitrin-img img{
    width: 100%;
    transition-duration: 0.1s; transition-timing-function: linear;
    }
    }
<?php }?>
<?php if($tip1Ayar['vitrin_grid'] == '5'  ) {?>
    .cat-detail-products-box-caturunvitrin{
    width: 18.5%;
    }
    .cat-detail-products-box-caturunvitrin-img{
    width: 100%;
    margin-bottom: 15px;
    overflow: hidden;
    position: relative;
    }
    .cat-detail-products-box-caturunvitrin-img img{
    width: 100%;
    transition-duration: 0.1s; transition-timing-function: linear;
    }
    .cat-detail-products-box-caturunvitrin-h{
    font-size: 13px ;
    min-height: 55px;
    margin-bottom: 5px;
    }
    }
<?php }?>
.group-urun-module-main-div{
font-family : '<?=$tip1Ayar['font']?>',sans-serif ;
background-color: #<?=$tip1Ayar['arkaplan']?>;
}
.group-product-main-box{
border-top: 1px solid #<?=$tip1Ayar['border_color']?>;
}
.group-product-main-box:first-child{
border-top: 0;
}
.group-product-main-box-img{
border-radius: <?=$tip1Ayar['gorsel_radius']?>;
}
.group-product-main-box-img:hover img{
<?php if($tip1Ayar['gorsel_zoom'] == '0' ) {?>
    -webkit-transform: scale(1);-moz-transform: scale(1);-ms-transform: scale(1);-o-transform: scale(1);transform: scale(1);
<?php }?>
<?php if($tip1Ayar['gorsel_blur'] == '0' ) {?>
    filter: blur(0);
<?php }?>
}


.swiper-product-list {
width: 100%;
height: 100%;
position: relative;
}
@media screen and (max-width:1279px) and (min-width:1152px) {
.swiper-product-list .swiper-slide{
margin-left: -.1px !important;
}
}

.swiper-product-list:hover .swiper-button-prev,
.swiper-product-list:hover .swiper-button-next {
background-color: #333;
box-sizing:border-box;
-webkit-transform: translateX(0);
transform: translateX(0);
opacity: 1;
visibility: visible;
position: absolute;
top: 50%;
width: 30px;
height: 44px;
margin-top: -22px;
z-index: 9;
cursor: pointer;
background-size: 15px 100px;
background-position: center;
background-repeat: no-repeat;
}
.swiper-product-list:hover .swiper-button-prev{
margin-left: -10px;
}
.swiper-product-list:hover .swiper-button-next{
margin-right: -10px;
}


/* Fırsatlar Vitrini */
.firsatlar-urun-module-main-div{
border-top: 1px solid #<?=$firsatRow['border_color']?>;
border-bottom: 1px solid #<?=$firsatRow['border_color']?>;
<?php if($firsatRow['bg_tip'] == '1'  ) {?>
    background:#<?=$firsatRow['bg_color']?> ;
<?php }else { ?>
    background-image:url("../../images/uploads/<?=$firsatRow['bg_image']?>") ;
    background-size: cover;
    background-position:top center;
    <?php if($firsatRow['bg_durum'] == '1' ) {?>
        background-attachment: fixed;
    <?php }?>
<?php }?>
padding:<?=$firsatRow['padding']?>px 0;
margin: <?=$firsatRow['margin']?>px 0;
font-family : '<?=$firsatRow['font']?>',sans-serif ;
}

.firsat-product-box {
border: <?=$urunKutuRow['border_width']?> solid #<?=$urunKutuRow['kutu_border_renk']?>;
background-color: #<?=$urunKutuRow['kutu_arkaplan']?>;
border-radius: <?=$urunKutuRow['kutu_radius']?>;
<?php if($urunKutuRow['kutu_shadow'] == '0'  ) {?> box-shadow: none !important;
<?php }?>
}
.swiper-countdown-list {
width: 100%;
height: 100%;
position: relative;
}
@media screen and (max-width:1279px) and (min-width:1152px) {
.swiper-countdown-list .swiper-slide{
margin-left: -.1px !important;
}
}
.swiper-countdown-list:hover .swiper-button-prev,
.swiper-countdown-list:hover .swiper-button-next {
background-color: #333;
box-sizing:border-box;
-webkit-transform: translateX(0);
transform: translateX(0);
opacity: 1;
visibility: visible;
position: absolute;
top: 50%;
width: 30px;
height: 44px;
margin-top: -22px;
z-index: 9;
cursor: pointer;
background-size: 15px 100px;
background-position: center;
background-repeat: no-repeat;
}
.swiper-countdown-list:hover .swiper-button-prev{
margin-left: -10px;
}
.swiper-countdown-list:hover .swiper-button-next{
margin-right: -10px;
}
/*  <========SON=========>>> Fırsatlar Vitrini SON */


/* Vitrin 2 */
.product-categories-main-div-vitrin2{
border-top: 1px solid #<?=$tip2Ayar['border_color']?>;
border-bottom: 1px solid #<?=$tip2Ayar['border_color']?>;
<?php if($tip2Ayar['bg_tip'] == '1'  ) {?>
    background:#<?=$tip2Ayar['bg_color']?> ;
<?php }else { ?>
    background-image:url("../../images/uploads/<?=$tip2Ayar['bg_image']?>") ;
    background-size: cover;
    background-position:top center;
    <?php if($tip2Ayar['bg_durum'] == '1' ) {?>
        background-attachment: fixed;
    <?php }?>
<?php }?>
padding:<?=$tip2Ayar['padding']?>px 0 <?=$tip2Ayar['padding']-20?>px 0;
margin: <?=$tip2Ayar['margin']?>px 0;
font-family : '<?=$tip2Ayar['font']?>',sans-serif ;
}
<?php if($tip2Ayar['gorsel_zoom'] == '0'  ) {?>
    .vitrin2-box:hover .vitrin2-box-img img{
    -webkit-transform: scale(1);-moz-transform: scale(1);-ms-transform: scale(1);-o-transform: scale(1);transform: scale(1);
    }
<?php }?>



/* Vitrin 1 */

.product-categories-main-div{
border-top: 1px solid #<?=$tip3Ayar['border_color']?>;
border-bottom: 1px solid #<?=$tip3Ayar['border_color']?>;
<?php if($tip3Ayar['bg_tip'] == '1'  ) {?>
    background:#<?=$tip3Ayar['bg_color']?> ;
<?php }else { ?>
    background-image:url("../../images/uploads/<?=$tip3Ayar['bg_image']?>") ;
    background-size: cover;
    background-position:top center;
    <?php if($tip3Ayar['bg_durum'] == '1' ) {?>
        background-attachment: fixed;
    <?php }?>
<?php }?>
padding:<?=$tip3Ayar['padding']?>px 0;
margin: <?=$tip3Ayar['margin']?>px 0;
font-family : '<?=$tip3Ayar['font']?>',sans-serif ;
}
.product-categories-box{
background-color: #<?=$tip3Ayar['box_disbaslik_bg']?>;
border: 1px solid #<?=$tip3Ayar['box_border']?>;
}
.product-categories-box:hover .product-categories-box-img{
<?php if($tip3Ayar['box_icbaslik_blur'] == '0'  ) {?>
    filter: blur(0);
<?php }?>
<?php if($tip3Ayar['box_icbaslik_zoom'] == '0'  ) {?>
    -webkit-transform: scale(1);-moz-transform: scale(1);-ms-transform: scale(1);-o-transform: scale1);transform: scale(1);
<?php }?>
}
<?php if($tip3Ayar['box_icbaslik'] == '1' || $tip3Ayar['box_icbaslik'] == '3'  ) {?>
    .product-categories-box-img-line-line{
    justify-content: center;
    }
<?php }?>
<?php if($tip3Ayar['box_icbaslik'] == '3'  ) {?>
    .product-categories-box-img-line-line{
    opacity: 1;
    }
<?php }?>
<?php if($tip3Ayar['grid_sayi'] == '3' ) {?>
    .product-categories-box{
    width: 31.93%;
    }
    .product-categories-box-img{
    height: 260px;
    }
    .product-categories-box-img-dis{
    height: 260px;
    }
    .vitrin1_text{
    font-size: 26px ;
    font-weight: 500;
    }
    @media screen and (max-width:1151px) and (min-width:1024px) {
    .product-categories-box{
    width: 31.93% !important;
    }
    .product-categories-box-img{
    height: 190px !important;
    }
    .product-categories-box-img-dis{
    height: 190px !important;
    }
    }
<?php }?>
<?php if($tip3Ayar['grid_sayi'] == '4' ) {?>
    @media screen and (max-width:1151px) and (min-width:1024px) {
    .product-categories-box{
    width: 23.6% !important;
    }
    .product-categories-box-img{
    height: 140px !important;
    }
    .product-categories-box-img-dis{
    height: 140px !important;
    }
    }
<?php } ?>
<?php if($tip3Ayar['grid_sayi'] == '5' ) {?>
    .product-categories-box{
    width: 18.6%;
    }
    .product-categories-box-img{
    height: 145px;
    }
    .product-categories-box-img-dis{
    height: 145px;
    }
    @media screen and (max-width:1151px) and (min-width:1024px) {
    .product-categories-box{
    width: 18.6% !important;
    }
    .product-categories-box-img{
    height: 105px !important;
    }
    .product-categories-box-img-dis{
    height: 105px !important;
    }
    }
<?php }?>


/* seçenekli ürün vitrini */
.urunler-module-main-div{
<?php if($secenekRow['secenekvitrin_bg_tip'] == '1'  ) {?>
    background:#<?=$secenekRow['secenekvitrin_bg_color']?> ;
<?php }else { ?>
    background-image:url("../../images/uploads/<?=$secenekRow['secenekvitrin_bg_image']?>") ;
    background-size: cover;
    background-position:top center;
    <?php if($secenekRow['secenekvitrin_bg_durum'] == '1' ) {?>
        background-attachment: fixed;
    <?php }?>
<?php }?>
padding:<?=$secenekRow['secenekvitrin_padding']?>px 0 <?=$secenekRow['secenekvitrin_padding']-30?>px 0;
margin: <?=$secenekRow['secenekvitrin_margin']?>px 0;
font-family : '<?=$secenekRow['secenekvitrin_baslik_font']?>',sans-serif ;
border-top: 1px solid #<?=$secenekRow['secenekvitrin_border']?>;
border-bottom: 1px solid #<?=$secenekRow['secenekvitrin_border']?>;
}

.home-product-tablinks.active {
background-color: #<?=$secenekRow['secenekvitrin_aktif_tab_renk']?>;
border: 1px solid #<?=$secenekRow['secenekvitrin_aktif_tab_border']?>;
}
.home-product-tablinks.active::after{
border-color: #<?=$secenekRow['secenekvitrin_aktif_tab_border']?> transparent transparent transparent;
}
.home-product-tablinks {
background-color: #<?=$secenekRow['secenekvitrin_tab_renk']?>;
border-radius: <?=$secenekRow['secenekvitrin_tab_radius']?>px;
border: 1px solid #<?=$secenekRow['secenekvitrin_tab_border']?>;
margin: <?=$secenekRow['secenekvitrin_tab_margin']?>px;
}
.home-product-tablinks p{
font-size: <?=$secenekRow['secenekvitrin_tab_baslik_size']?>px ;
font-weight: <?=$secenekRow['secenekvitrin_tab_baslik_weight']?>;
}
.home-product-tablinks.active p,
.home-product-tablinks.active:hover p {
color: #<?=$secenekRow['secenekvitrin_aktif_tab_yazi']?>;
}
.home-product-tablinks p{
color: #<?=$secenekRow['secenekvitrin_tab_yazi']?>;
}



/* Ürün Kutuları */
.urun-box-special-area-caturunvitrin{
border: 1px dashed #<?=$urunKutuRow['kutu_arkaplan']?>;
background-color: #<?=$urunKutuRow['kutu_ozelfiyat_bg']?>;
color: #<?=$urunKutuRow['kutu_ozelfiyat_text']?>;
}
.urun-box-special-area{
border: 1px dashed #<?=$urunKutuRow['kutu_arkaplan']?>;
background-color: #<?=$urunKutuRow['kutu_ozelfiyat_bg']?>;
color: #<?=$urunKutuRow['kutu_ozelfiyat_text']?>;
}
.cat-detail-products-box {
border: <?=$urunKutuRow['border_width']?> solid #<?=$urunKutuRow['kutu_border_renk']?>;
background-color: #<?=$urunKutuRow['kutu_arkaplan']?>;
border-radius: <?=$urunKutuRow['kutu_radius']?>;
<?php if($urunKutuRow['kutu_shadow'] == '0'  ) {?> box-shadow: none !important;
<?php }?>
}
.cat-detail-products-box-cart-2 {
border-top: 1px solid #<?=$urunKutuRow['kutu_border_renk']?>;
}
.cat-detail-products-box-stars .aktif-span {
color: #<?=$urunKutuRow['star_color']?>;
}

.cat-detail-products-box-stars .pasif-span {
color: #<?=$urunKutuRow['star_pasif_color']?>;
}

.cat-detail-products-box-kargo {
background-color: #<?=$urunKutuRow['kutu_arkaplan']?>;
color: #<?=$urunKutuRow['kutu_kargo_renk']?>;
}
<?php if ($box_gorunum_turu == '4') {?>
    .cat-detail-products-box{
    width: 23.5%;
    }
    .cat-detail-products-box-img{
    width: 100%;
    }
    .cat-detail-products-box-img img{
    width: 100%;

    }
    @media screen and (max-width:1151px) and (min-width:1023px) {
    .cat-detail-products-box-img{
    width: 100%;
    }
    .cat-detail-products-box-img img{
    width: 100%;

    }
    }
    @media screen and (max-width:1279px) and (min-width:1152px) {
    .cat-detail-products-box-img{
    width: 100%;
    }
    .cat-detail-products-box-img img{
    width: 100%;

    }
    }
    @media screen and (max-width:1359px) and (min-width:1280px) {
    .cat-detail-products-box-img{
    width: 100%;
    }
    .cat-detail-products-box-img img{
    width: 100%;

    }
    }
<?php }?>
<?php if ($box_gorunum_turu == '5') {?>
    .cat-detail-products-box{
    width: 18.5%;
    }
    .cat-detail-products-box-img{
    width: 100%;
    }
    .cat-detail-products-box-img img{
    width: 100%;

    }
    @media screen and (max-width:1151px) and (min-width:1023px) {
    .cat-detail-products-box-img{
    width: 100%;
    }
    .cat-detail-products-box-img img{
    width: 100%;

    }
    }
    @media screen and (max-width:1279px) and (min-width:1152px) {
    .cat-detail-products-box-img{
    width: 100%;
    }
    .cat-detail-products-box-img img{
    width: 100%;

    }
    }
    @media screen and (max-width:1359px) and (min-width:1280px) {
    .cat-detail-products-box-img{
    width: 100%;
    }
    .cat-detail-products-box-img img{
    width: 100%;

    }
    }
<?php }?>
<?php if ($box_gorunum_turu == '6') {?>
    .cat-detail-products-box{
    width: 15.15%;
    }
    .cat-detail-products-box-img{
    width: 100%;

    }
    .cat-detail-products-box-img img{
    width: 100%;
    }
    @media screen and (max-width:1151px) and (min-width:1023px) {
    .cat-detail-products-box-img{
    width: 100%;
    }
    .cat-detail-products-box-img img{
    width: 100%;
    }
    }
    @media screen and (max-width:1279px) and (min-width:1152px) {
    .cat-detail-products-box-img{
    width: 100%;
    height: 140px;
    }
    .cat-detail-products-box-img img{
    width: 100%;
    }
    }
    @media screen and (max-width:1359px) and (min-width:1280px) {
    .cat-detail-products-box-img{
    width: 100%;
    height: 160px;
    }
    .cat-detail-products-box-img img{
    width: 100%;
    }
    }
<?php }?>
