<?php include 'includes/config/session.php';
if ($bakim['durum'] == '1' ) {
    header("Location:$ayar[site_url]maintenance/");
    exit();
}
?>
<!doctype html>
<html lang="<?=$current_lang['kisa_ad']?>" dir="<?=$current_lang['area']?>">
<head>
    <base href="<?php echo"$ayar[site_url]"?>">
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="<?php echo $ayar['site_url'] ?>images/<?php echo $ayar['site_favicon']; ?>">
    <?php if($ayar['site_width'] == '0' ) {  ?>
    <div class="main-body">
        <?php }else { ?>
        <div class="main-body-2">
        <?php }?>
    <?php
    if(isset($_GET['sayfa'])){
        $s = $_GET['sayfa'];
        switch($s){

            case 'errorpage';
                require_once("includes/template/_pages/404.php");
                break;

            case 'htmlsayfa';
                require_once("includes/template/_pages/htmlpages.php");
                break;


            case 'commentspage';
                require_once("includes/template/_pages/comments.php");
                break;


            case 'pricing';
                require_once("includes/template/_pages/pricing.php");
                break;

            case 'blog';
                require_once("includes/template/_pages/blog.php");
                break;

            case 'services';
                require_once("includes/template/_pages/services.php");
                break;

            case 'photogallery';
                require_once("includes/template/_pages/photo_gallery.php");
                break;

            case 'photodetail';
                require_once("includes/template/_pages/photo_gallery_detail.php");
                break;

            case 'videos';
                require_once("includes/template/_pages/videos.php");
                break;

            case 'videodetail';
                require_once("includes/template/_pages/video_detail.php");
                break;

            case 'servicedetail';
                require_once("includes/template/_pages/service_detail.php");
                break;

            case 'blogdetail';
                require_once("includes/template/_pages/blog_detail.php");
                break;

            case 'contact';
                require_once("includes/template/_pages/contact.php");
                break;

            case 'iletisimgonder';
                require_once("includes/post/iletisimgonder.php");
                break;

            case 'newsletter';
                require_once("includes/post/ebultenkayit.php");
                break;

            case 'faq';
                require_once("includes/template/_pages/faq.php");
                break;

            case 'blogcommentpost';
                require_once("includes/post/blogyorumpost.php");
                break;
            case 'servicecommentpost';
                require_once("includes/post/hizmetyorumpost.php");
                break;






            case 'usercomment';
                require_once("includes/template/_pages/user-comments.php");
                break;

            case 'productloginpage';
                require_once("includes/post/loginPost/comment_loginpost.php");
                break;

            case 'productaddcomment';
                require_once("includes/post/productaddcomment.php");
                break;

            case 'logout';
                require_once("includes/post/logout.php");
                break;


            case 'addtocart';
                require_once("includes/post/addtocart.php");
                break;

            case 'removebasket';
                require_once("includes/post/removebasket.php");
                break;

            case 'removecoupon';
                require_once("includes/post/removecoupon.php");
                break;

            case 'discountquery';
                require_once("includes/post/discount_query.php");
                break;


            case 'productdetail';
                require_once("includes/template/_pages/products_detail.php");
                break;
            case 'catdetail';
                require_once("includes/template/_pages/cat_detail.php");
                break;




            case 'cart';
                require_once("includes/template/_pages/cart.php");
                break;

            case 'cartloginpage';
                require_once("includes/post/loginPost/cart_loginpost.php");
                break;

            case 'teslimat';
                require_once("includes/template/_pages/cart-2.php");
                break;

            case 'odemeyegecfonksiyon';
                require_once("includes/func/cart_delivery.php");
                break;
            case 'havale_eft_siparis';
                require_once("includes/template/_pages/siparis_havale_eft_success.php");
                break;
            case 'kapida_odeme_siparis';
                require_once("includes/template/_pages/siparis_kapida_odeme_success.php");
                break;
            case 'kart_odeme_siparis_basarili';
                require_once("includes/template/_pages/siparis_kart_success.php");
                break;
            case 'ucretsiz_siparis';
                require_once("includes/template/_pages/siparis_ucretsiz_success.php");
                break;
            case 'kartlaodeme';
                require_once("includes/template/_pages/payment.php");
                break;

            case 'orneksuccess';
                require_once("includes/template/_pages/ornek_success.php");
                break;

            case 'normalOrder';
                require_once("includes/post/siparisdb/offer_order/order.php");
                break;
            case 'offerOrder';
                require_once("includes/post/siparisdb/offer_order/offer.php");
                break;


                /* Üyelik */
            case 'loginpage';
                require_once("includes/template/_pages/user/login.php");
                break;
            case 'loginpost';
                require_once("includes/post/loginPost/loginpost.php");
                break;
            case 'register';
                require_once("includes/template/_pages/user/register.php");
                break;
            case 'registerpage';
                require_once("includes/post/users/registerpost.php");
                break;
            case 'sifremiunuttum';
                require_once("includes/template/_pages/user/sifremi_unuttum.php");
                break;
            case 'rememberpassword';
                require_once("includes/post/users/sifremiunuttum.php");
                break;
            case 'sifremi_sifirla';
                require_once("includes/template/_pages/user/sifreyi_sifirla.php");
                break;
            case 'remembernewpassword';
                require_once("includes/post/users/sifremiunuttumpost.php");
                break;

            case 'hesapayarlari';
                require_once("includes/template/_pages/user/hesap_ayarlari.php");
                break;
            case 'hesap_siparisler';
                require_once("includes/template/_pages/user/hesap_siparisler.php");
                break;
            case 'hesap_siparisler_detay';
                require_once("includes/template/_pages/user/hesap_siparisler_detay.php");
                break;
            case 'hesap_iptal_iade';
                require_once("includes/template/_pages/user/hesap_iptal_iade.php");
                break;
            case 'hesap_iptaller';
                require_once("includes/template/_pages/user/hesap_iptaller.php");
                break;
            case 'hesap_iadeler';
                require_once("includes/template/_pages/user/hesap_iadeler.php");
                break;
            case 'hesap_iade_detay';
                require_once("includes/template/_pages/user/hesap_iade_detay.php");
                break;
            case 'hesap_teklifler';
                require_once("includes/template/_pages/user/hesap_teklifler.php");
                break;
                case 'hesap_tek_urun';
            require_once("includes/template/_pages/user/hesap_tek_urun.php");
            break;
            case 'hesap_adresler';
                require_once("includes/template/_pages/user/hesap_adresler.php");
                break;
            case 'hesap_adresler_ekle';
                require_once("includes/template/_pages/user/hesap_adresler_ekle.php");
                break;
            case 'hesap_adresekle_post';
                require_once("includes/post/users/hesap_adresekle_post.php");
                break;
            case 'hesap_adresduzenle_post';
                require_once("includes/post/users/hesap_adresduzenle_post.php");
                break;
            case 'hesap_adresler_duzenle';
                require_once("includes/template/_pages/user/hesap_adresler_duzenle.php");
                break;
            case 'hesap_kuponlar';
                require_once("includes/template/_pages/user/hesap_kuponlar.php");
                break;
            case 'hesap_yorumlar';
                require_once("includes/template/_pages/user/hesap_yorumlar.php");
                break;
            case 'hesap_favoriler';
                require_once("includes/template/_pages/user/hesap_favoriler.php");
                break;
            case 'hesap_destek';
                require_once("includes/template/_pages/user/hesap_destek.php");
                break;
            case 'hesap_destek_yeni';
                require_once("includes/template/_pages/user/hesap_destek_yeni.php");
                break;
            case 'hesap_destekgonder_post';
                require_once("includes/post/users/hesap_destekgonder_post.php");
                break;
            case 'hesap_destek_yanitgonder_post';
                require_once("includes/post/users/hesap_destek_yanitgonder_post.php");
                break;
            case 'hesap_destek_detay';
                require_once("includes/template/_pages/user/hesap_destek_detay.php");
                break;

            case 'hesap_sifre_degispost';
                require_once("includes/post/users/hesap_sifre_degispost.php");
                break;
            case 'hesap_ayar_degispost';
                require_once("includes/post/users/hesap_ayar_degispost.php");
                break;

            case 'urun_iade_post';
                require_once("includes/post/users/urun_iade.php");
                break;
                /*  <========SON=========>>> Üyelik SON */


            /* Bildirim */
            case 'bildirimler';
                require_once("includes/template/_pages/bildirimler.php");
                break;
            case 'bildirimdetay';
                require_once("includes/template/_pages/bildirim_detay.php");
                break;
            /*  <========SON=========>>> Bildirim SON */


            case 'urun_karsilastirma';
                require_once("includes/template/_pages/urun_karsilastirma.php");
                break;

                /* banka ve bildirim */
            case 'hesapnumaralari';
                require_once("includes/template/_pages/banka_hesaplari.php");
                break;
            case 'odemebildirimi';
                require_once("includes/template/_pages/odeme_bildirimi.php");
                break;
            case 'odemebildirimpost';
                require_once("includes/post/odemebildirimpost.php");
                break;
                /*  <========SON=========>>> banka ve bildirim SON */

            case 'siparistakip';
                require_once("includes/template/_pages/siparis_takip.php");
                break;

                /* Ürün marka */
            case 'urun_markalari';
            require_once("includes/template/_pages/urun_markalari.php");
            break;
            case 'marka_listesi';
                require_once("includes/template/_pages/marka_listesi.php");
                break;
                /*  <========SON=========>>> Ürün marka SON */


            case 'urun_ara';
                require_once("includes/template/_pages/urun_ara.php");
                break;

            case 'urun_compare';
                require_once("includes/template/_pages/urun_compare.php");
                break;



            case 'paket_kategori';
                require_once("includes/template/_pages/pricing_kat.php");
                break;


            case 'shopierOrderSuccess';
                require_once("includes/template/_pages/shopier_success.php");
                break;

        }
    }else {
        header('Location:'.$ayar['site_url'].'404');
    }
    ?>
</div>
