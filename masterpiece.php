<?php include 'includes/config/session.php';
if(isset($_GET['sayfa'])){
    $s = $_GET['sayfa'];
    switch($s){
        case 'paytr_bildirim';
            require_once("includes/paytr_notification.php");
            break;
        case 'teslimat_ulke_data';
            require_once("includes/post/teslimat-ulke-data.php");
            break;
        case 'teslimat_ulke_data_fatura';
            require_once("includes/post/teslimat-ulke-data-fatura.php");
            break;
        case 'comment_more_product';
            require_once("includes/template/helper/product_detail/product_comment_more.php");
            break;
        case 'comment_more_blog';
            require_once("includes/template/helper/blog/blog_comment_more.php");
            break;
        case 'comment_more_hizmet';
            require_once("includes/template/helper/hizmet/hizmet_comment_more.php");
            break;
        case 'bildirim_ozel_more';
            require_once("includes/template/helper/bildirim/ozel.php");
            break;
        case 'bildirim_herkese_more';
            require_once("includes/template/helper/bildirim/herkeseacik.php");
            break;
        case 'bildirim_uyelere_more';
            require_once("includes/template/helper/bildirim/uyelereozel.php");
            break;
        case 'teklif_cek_ajax';
            require_once("includes/template/helper/users/teklifcek.php");
            break;
        case 'siparis_cek_ajax';
            require_once("includes/template/helper/users/normalsiparis.php");
            break;
        case 'cart_load_ajax';
            require_once("includes/template/helper/cart/cart_items.php");
            break;
        case 'favoriye_ekle';
            require_once("includes/func/favoriye-ekle.php");
            break;
        case 'compare';
            require_once("includes/func/karsilastirma.php");
            break;
        case 'header_cart_delete';
            require_once("includes/func/header_cart_item_delete.php");
            break;
        case 'like_button';
            require_once("includes/func/like_post.php");
            break;
        case 'quantity_process';
            require_once("includes/func/quantity.php");
            break;
        case 'currency_change';
            require_once("includes/config/parabirimi.php");
            break;
        case 'language_change';
            require_once("includes/config/language.php");
            break;
        case 'cart_item_process';
            require_once("includes/func/cart_item_process.php");
            break;

        case 'output_xml';
            require_once("includes/template/output/xml.php");
            break;


    }
}else{
    header('Location:'.$ayar['site_url'].'404');
}?>