<?php
//todo ioncube
include 'inc/session.php'
?>
<?php if($adminSorgu->rowCount()> '0'  ) {?>
    <!DOCTYPE html>
    <html lang="<?=$mevcutdil['kisa_ad']?>" dir="<?=$mevcutdil['area']?>">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <meta content="Admin Dashboard" name="description" />
        <meta content="ThemeDesign" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <?php include 'inc/template/headerlibs.php'; ?>
    </head>
    <body>
    <div class="panel-home-main-div">
        <!-- Header !-->
        <?php include 'inc/template/header.php'; ?>
        <!--  <========SON=========>>> Header SON !-->
        <?php
        if(isset($_GET['page'])){
            $s = $_GET['page'];
            switch($s){


                case 'null';
                    require_once("inc/modules/null.php");
                    break;
                case 'settings';
                    require_once("inc/modules/settings/settings.php");
                    break;
                case 'panel_settings';
                    require_once("inc/modules/settings/panel_settings.php");
                    break;
                case 'admin_list';
                    require_once("inc/modules/admin/admin_list.php");
                    break;
                case 'admin_add';
                    require_once("inc/modules/admin/admin_add.php");
                    break;
                case 'admin_edit';
                    require_once("inc/modules/admin/admin_edit.php");
                    break;
                case 'admin_log';
                    require_once("inc/modules/admin/admin_log.php");
                    break;
                case 'admin_permission';
                    require_once("inc/modules/admin/admin_permission.php");
                    break;
                case 'permission_add';
                    require_once("inc/modules/admin/admin_permission_add.php");
                    break;
                case 'permission_edit';
                    require_once("inc/modules/admin/admin_permission_edit.php");
                    break;
                case 'login_log';
                    require_once("inc/modules/login/login_log.php");
                    break;
                case 'languages';
                    require_once("inc/modules/language/language_list.php");
                    break;
                case 'maintenance';
                    require_once("inc/modules/settings/maintenance.php");
                    break;
                case 'popup';
                    require_once("inc/modules/settings/popup.php");
                    break;
                case 'code';
                    require_once("inc/modules/settings/code.php");
                    break;
                case 'cache_settings';
                    require_once("inc/modules/settings/cache_settings.php");
                    break;

                /* Theme Settings */
                case 'theme_mobil_settings';
                    require_once("inc/modules/theme/mobil_settings.php");
                    break;
                case 'theme_print_invoice';
                    require_once("inc/modules/theme/print_invoice.php");
                    break;
                case 'theme_header_settings';
                    require_once("inc/modules/theme/header_settings.php");
                    break;
                case 'theme_footer_settings';
                    require_once("inc/modules/theme/footer_settings.php");
                    break;
                case 'theme_catalog_settings';
                    require_once("inc/modules/theme/catalog_settings.php");
                    break;
                case 'theme_product_box';
                    require_once("inc/modules/theme/catalog_product_box.php");
                    break;
                case 'theme_product_detail';
                    require_once("inc/modules/theme/catalog_product_detail.php");
                    break;
                case 'theme_cat_detail';
                    require_once("inc/modules/theme/catalog_category.php");
                    break;
                case 'theme_brand';
                    require_once("inc/modules/theme/catalog_brand.php");
                    break;
                case 'theme_tbox';
                    require_once("inc/modules/theme/catalog_tbox.php");
                    break;
                case 'theme_showcase_tab';
                    require_once("inc/modules/theme/catalog_tab_products.php");
                    break;
                case 'theme_showcase_bannerproduct';
                    require_once("inc/modules/theme/catalog_img_showcase.php");
                    break;
                case 'theme_showcase_banner1';
                    require_once("inc/modules/theme/catalog_banner_showcase.php");
                    break;
                case 'theme_showcase_banner2';
                    require_once("inc/modules/theme/catalog_banner2_showcase.php");
                    break;
                case 'theme_showcase_countdown';
                    require_once("inc/modules/theme/catalog_countdown_showcase.php");
                    break;
                case 'theme_users_settings';
                    require_once("inc/modules/theme/users_settings.php");
                    break;
                case 'fonts';
                    require_once("inc/modules/theme/font.php");
                    break;
                case 'theme_banners';
                    require_once("inc/modules/theme/banners.php");
                    break;
                case 'theme_banner_edit';
                    require_once("inc/modules/theme/banners_edit.php");
                    break;
                case 'theme_mail';
                    require_once("inc/modules/theme/mail_theme.php");
                    break;
                case 'theme_cart';
                    require_once("inc/modules/theme/cart_theme.php");
                    break;
                case 'theme_compare';
                    require_once("inc/modules/theme/compare_theme.php");
                    break;
                case 'theme_contact';
                    require_once("inc/modules/theme/contact_theme.php");
                    break;
                case 'preloader';
                    require_once("inc/modules/theme/preloader_theme.php");
                    break;
                case 'theme_slider';
                    require_once("inc/modules/theme/slider_theme.php");
                    break;
                case 'theme_story';
                    require_once("inc/modules/theme/story_theme.php");
                    break;
                case 'theme_modal';
                    require_once("inc/modules/theme/modal_theme.php");
                    break;
                case 'theme_404';
                    require_once("inc/modules/theme/404_theme.php");
                    break;
                case 'theme_banks';
                    require_once("inc/modules/theme/banks_theme.php");
                    break;
                case 'theme_pricing';
                    require_once("inc/modules/theme/ptable_theme.php");
                    break;
                case 'theme_services';
                    require_once("inc/modules/theme/services_theme.php");
                    break;
                case 'theme_blogs';
                    require_once("inc/modules/theme/blogs_theme.php");
                    break;
                case 'theme_enews';
                    require_once("inc/modules/theme/enews_theme.php");
                    break;
                case 'theme_client_comments';
                    require_once("inc/modules/theme/comments_theme.php");
                    break;
                case 'theme_client_counter';
                    require_once("inc/modules/theme/counters_theme.php");
                    break;
                case 'theme_faq';
                    require_once("inc/modules/theme/faq_theme.php");
                    break;

                case 'theme_videos';
                    require_once("inc/modules/theme/videos_theme.php");
                    break;
                case 'theme_intro';
                    require_once("inc/modules/theme/intro_theme.php");
                    break;
                case 'theme_gallery';
                    require_once("inc/modules/theme/gallery_theme.php");
                    break;
                case 'payment_settings';
                    require_once("inc/modules/config/payment_settings.php");
                    break;
                case 'pos_settings';
                    require_once("inc/modules/config/pos_settings.php");
                    break;
                case 'order_status';
                    require_once("inc/modules/config/order_status.php");
                    break;
                case 'commerce_settings';
                    require_once("inc/modules/config/commerce_settings.php");
                    break;
                case 'bank_accounts';
                    require_once("inc/modules/config/bank_accounts.php");
                    break;
                case 'countries';
                    require_once("inc/modules/config/countries.php");
                    break;
                case 'currency';
                    require_once("inc/modules/config/currency.php");
                    break;
                case 'delivery_settings';
                    require_once("inc/modules/config/delivery_settings.php");
                    break;
                case 'delivery_company';
                    require_once("inc/modules/config/delivery_company.php");
                    break;
                case 'installment_rate';
                    require_once("inc/modules/config/installment_rate.php");
                    break;
                case 'installment_month';
                    require_once("inc/modules/config/installment_month.php");
                    break;
                case 'smtp_settings';
                    require_once("inc/modules/config/smtp_settings.php");
                    break;
                case 'sms_settings';
                    require_once("inc/modules/config/sms_settings.php");
                    break;
                case 'modules_sort';
                    require_once("inc/modules/modules/modules_sort.php");
                    break;
                case 'tophtml_area';
                    require_once("inc/modules/modules/tophtml_area.php");
                    break;
                case 'topheader_links';
                    require_once("inc/modules/modules/topheader_links.php");
                    break;
                case 'header_links';
                    require_once("inc/modules/modules/header_links.php");
                    break;
                case 'header_links_edit';
                    require_once("inc/modules/modules/header_links_edit.php");
                    break;
                case 'new_header_link_add';
                    require_once("inc/modules/modules/header_links_add.php");
                    break;
                case 'header_sub_links';
                    require_once("inc/modules/modules/header_sub_links.php");
                    break;

                case 'mobile_header_links';
                    require_once("inc/modules/modules/mobile_header.php");
                    break;
                case 'mobile_header_list';
                    require_once("inc/modules/modules/mobile_header_list.php");
                    break;

                case 'footer_links';
                    require_once("inc/modules/modules/footer_links.php");
                    break;
                case 'footer_sub_links';
                    require_once("inc/modules/modules/footer_sub_links.php");
                    break;
                case 'top_slider';
                    require_once("inc/modules/modules/top_slider.php");
                    break;
                case 'top_slider_add';
                    require_once("inc/modules/modules/top_slider_add.php");
                    break;
                case 'top_slider_edit';
                    require_once("inc/modules/modules/top_slider_edit.php");
                    break;
                case 'middle_slider';
                    require_once("inc/modules/modules/middle_slider.php");
                    break;
                case 'stories';
                    require_once("inc/modules/modules/stories.php");
                    break;
                case 'story_item_list';
                    require_once("inc/modules/modules/stories_item_list.php");
                    break;
                case 'showcase_tabproduct';
                    require_once("inc/modules/modules/showcase_tabproduct.php");
                    break;
                case 'showcase_bannerproduct';
                    require_once("inc/modules/modules/showcase_bannerproduct.php");
                    break;
                case 'showcase_bannerproduct_list';
                    require_once("inc/modules/modules/showcase_bannerproduct_list.php");
                    break;
                case 'showcase_banner1';
                    require_once("inc/modules/modules/showcase_banner1.php");
                    break;
                case 'showcase_banner2';
                    require_once("inc/modules/modules/showcase_banner2.php");
                    break;
                case 'showcase_html';
                    require_once("inc/modules/modules/showcase_html.php");
                    break;
                case 'showcase_countdown';
                    require_once("inc/modules/modules/showcase_countdown.php");
                    break;
                case 'sub_navigations';
                    require_once("inc/modules/contents/sub_navigations.php");
                    break;
                case 'sub_navigations_links';
                    require_once("inc/modules/contents/sub_navigations_links.php");
                    break;
                case 'page_management';
                    require_once("inc/modules/contents/page_management.php");
                    break;
                case 'user_contract';
                    require_once("inc/modules/contents/user_contract.php");
                    break;
                case 'sale_contract';
                    require_once("inc/modules/contents/sale_contract.php");
                    break;
                case 'cookie_contract';
                    require_once("inc/modules/contents/cookie_contract.php");
                    break;
                case 'pricing_table';
                    require_once("inc/modules/contents/ptable_cat.php");
                    break;
                case 'pricing_table_list';
                    require_once("inc/modules/contents/ptable_list.php");
                    break;
                case 'pricing_table_features';
                    require_once("inc/modules/contents/ptable_list_features.php");
                    break;
                case 'blogs';
                    require_once("inc/modules/contents/blog.php");
                    break;
                case 'blogs_categories';
                    require_once("inc/modules/contents/blog_cat.php");
                    break;
                case 'blog_comments';
                    require_once("inc/modules/contents/blog_comments.php");
                    break;
                case 'services';
                    require_once("inc/modules/contents/services.php");
                    break;
                case 'service_comments';
                    require_once("inc/modules/contents/service_comments.php");
                    break;
                case 'photo_gallery';
                    require_once("inc/modules/contents/photo_gallery.php");
                    break;
                case 'photo_gallery_list';
                    require_once("inc/modules/contents/photo_gallery_list.php");
                    break;
                case 'video_gallery';
                    require_once("inc/modules/contents/video_gallery.php");
                    break;
                case 'intro';
                    require_once("inc/modules/contents/intro.php");
                    break;
                case 'contact_page';
                    require_once("inc/modules/contents/contact.php");
                    break;
                case 'social_accounts';
                    require_once("inc/modules/contents/social.php");
                    break;
                case 'counters';
                    require_once("inc/modules/contents/counters.php");
                    break;
                case 'commerce_boxes';
                    require_once("inc/modules/contents/tbox.php");
                    break;
                case 'client_comments';
                    require_once("inc/modules/contents/client_comments.php");
                    break;
                case 'faq';
                    require_once("inc/modules/contents/faq.php");
                    break;
                case 'merchants';
                    require_once("inc/modules/contents/merchants.php");
                    break;
                case 'coupons';
                    require_once("inc/modules/campaign/coupon.php");
                    break;
                case 'first_order_discount';
                    require_once("inc/modules/campaign/first_order_discount.php");
                    break;
                case 'first_order_user';
                    require_once("inc/modules/campaign/first_order_user.php");
                    break;
                case 'cart_discount';
                    require_once("inc/modules/campaign/cart_discount.php");
                    break;
                case 'email_list';
                    require_once("inc/modules/campaign/email_list.php");
                    break;
                case 'newsletter';
                    require_once("inc/modules/campaign/newsletter.php");
                    break;
                case 'sms_numbers';
                    require_once("inc/modules/campaign/sms_list.php");
                    break;
                case 'multi_sms';
                    require_once("inc/modules/campaign/sms_multi.php");
                    break;
                case 'notifications';
                    require_once("inc/modules/campaign/noti.php");
                    break;
                case 'users';
                    require_once("inc/modules/users/users.php");
                    break;
                case 'user_detail';
                    require_once("inc/modules/users/users_detail.php");
                    break;
                case 'user_detail_address';
                    require_once("inc/modules/users/users_detail_address.php");
                    break;
                case 'user_favorites';
                    require_once("inc/modules/users/users_detail_favorites.php");
                    break;
                case 'user_log';
                    require_once("inc/modules/users/users_detail_log.php");
                    break;
                case 'user_coupon';
                    require_once("inc/modules/users/users_detail_coupon.php");
                    break;
                case 'users_group';
                    require_once("inc/modules/users/users_group.php");
                    break;
                case 'tickets';
                    require_once("inc/modules/users/tickets.php");
                    break;
                case 'ticket_detail';
                    require_once("inc/modules/users/tickets_detail.php");
                    break;
                case 'users_settings';
                    require_once("inc/modules/users/users_settings.php");
                    break;
                case 'visitor_analytics';
                    require_once("inc/modules/users/visitor_analytics.php");
                    break;
                case 'visitor_analytics_chart';
                    require_once("inc/modules/users/visitor_analytics_chart.php");
                    break;
                case 'visitor_analytics_date';
                    require_once("inc/modules/users/visitor_analytics_date.php");
                    break;
                case 'visitor_analytics_users';
                    require_once("inc/modules/users/visitor_analytics_users.php");
                    break;
                case 'orders';
                    require_once("inc/modules/orders/orders.php");
                    break;
                case 'order_detail';
                    require_once("inc/modules/orders/order_detail.php");
                    break;

                case 'op_orders';
                    require_once("inc/modules/orders/single_orders.php");
                    break;
                case 'offers';
                    require_once("inc/modules/orders/offer_orders.php");
                    break;
                case 'order_cancel';
                    require_once("inc/modules/orders/order_cancel.php");
                    break;
                case 'order_product_return';
                    require_once("inc/modules/orders/order_product_return.php");
                    break;
                case 'product_return';
                    require_once("inc/modules/orders/order_product_return_detail.php");
                    break;
                case 'bank_transfer';
                    require_once("inc/modules/orders/bank_transfer.php");
                    break;
                case 'all_cart_list';
                    require_once("inc/modules/orders/cart_list.php");
                    break;
                case 'nocomplete_orders';
                    require_once("inc/modules/orders/nocomplete_orders.php");
                    break;
                case 'order_reports';
                    require_once("inc/modules/orders/order_reports.php");
                    break;
                case 'order_reports_data';
                    require_once("inc/modules/orders/order_reports_data.php");
                    break;
                case 'order_reports_date';
                    require_once("inc/modules/orders/order_reports_date.php");
                    break;
                case 'order_reports_type';
                    require_once("inc/modules/orders/order_reports_type.php");
                    break;
                case 'sale_reports';
                    require_once("inc/modules/orders/sale_reports.php");
                    break;
                case 'sale_reports_date';
                    require_once("inc/modules/orders/sale_reports_date.php");
                    break;
                case 'shortlinks';
                    require_once("inc/modules/shortlinks.php");
                    break;
                case 'todo_list';
                    require_once("inc/modules/todo_list.php");
                    break;
                case 'password_change';
                    require_once("inc/modules/password_change.php");
                    break;
                case 'account_log';
                    require_once("inc/modules/account_log.php");
                    break;
                case 'my_account';
                    require_once("inc/modules/my_account.php");
                    break;
                case 'inbox';
                    require_once("inc/modules/inbox.php");
                    break;
                case 'inbox_detail';
                    require_once("inc/modules/inbox_detail.php");
                    break;
                case 'products';
                    require_once("inc/modules/catalog/products.php");
                    break;
                case 'product_detail';
                    require_once("inc/modules/catalog/product_detail.php");
                    break;
                case 'product_detail_price_shipping';
                    require_once("inc/modules/catalog/product_detail_price_shipping.php");
                    break;
                case 'product_detail_description';
                    require_once("inc/modules/catalog/product_detail_description.php");
                    break;
                case 'product_detail_gallery';
                    require_once("inc/modules/catalog/product_detail_gallery.php");
                    break;
                case 'product_detail_extra';
                    require_once("inc/modules/catalog/product_detail_extra.php");
                    break;
                case 'product_detail_seo';
                    require_once("inc/modules/catalog/product_detail_seo.php");
                    break;
                case 'product_detail_other';
                    require_once("inc/modules/catalog/product_detail_other.php");
                    break;
                case 'product_detail_features';
                    require_once("inc/modules/catalog/product_detail_features.php");
                    break;
                case 'product_detail_variant';
                    require_once("inc/modules/catalog/product_detail_variant.php");
                    break;
                case 'product_detail_entegration';
                    require_once("inc/modules/catalog/pazar/product_detail_n11.php");
                    break;
                case 'categories';
                    require_once("inc/modules/catalog/categories.php");
                    break;
                case 'sub_categories';
                    require_once("inc/modules/catalog/sub_categories.php");
                    break;
                case 'brands';
                    require_once("inc/modules/catalog/brands.php");
                    break;
                case 'e_catalog';
                    require_once("inc/modules/catalog/e_catalog.php");
                    break;
                case 'product_features';
                    require_once("inc/modules/catalog/product_features.php");
                    break;
                case 'product_features_list';
                    require_once("inc/modules/catalog/product_features_list.php");
                    break;
                case 'product_variants';
                    require_once("inc/modules/catalog/product_variants.php");
                    break;
                case 'product_variants_list';
                    require_once("inc/modules/catalog/product_variants_list.php");
                    break;
                case 'products_comments';
                    require_once("inc/modules/catalog/product_comments.php");
                    break;
                case 'allupdate_product';
                    require_once("inc/modules/catalog/allupdate_product.php");
                    break;
                case 'sitemap';
                    require_once("inc/modules/entegration/sitemap.php");
                    break;
                case 'product_export';
                    require_once("inc/modules/entegration/product_export.php");
                    break;
                case 'email_list_import';
                    require_once("inc/modules/entegration/email_list_import.php");
                    break;
                case 'email_list_import_process';
                    require_once("inc/modules/entegration/email_list_import_process.php");
                    break;
                case 'email_list_import_process_step';
                    require_once("inc/modules/entegration/email_list_import_process_step.php");
                    break;
                case 'email_list_import_data';
                    require_once("inc/modules/entegration/email_list_import_data.php");
                    break;

                case 'gsm_list_import';
                    require_once("inc/modules/entegration/gsm_list_import.php");
                    break;
                case 'gsm_list_import_process';
                    require_once("inc/modules/entegration/gsm_list_import_process.php");
                    break;
                case 'gsm_list_import_process_step';
                    require_once("inc/modules/entegration/gsm_list_import_process_step.php");
                    break;
                case 'gsm_list_import_data';
                    require_once("inc/modules/entegration/gsm_list_import_data.php");
                    break;

                case 'product_import';
                    require_once("inc/modules/entegration/product_import.php");
                    break;
                case 'product_import_process';
                    require_once("inc/modules/entegration/product_import_process.php");
                    break;
                case 'product_import_process_step';
                    require_once("inc/modules/entegration/product_import_process_step.php");
                    break;
                case 'product_import_data';
                    require_once("inc/modules/entegration/product_import_data.php");
                    break;

                case 'n11_settings';
                    require_once("inc/modules/entegration/pazar/n11_settings.php");
                    break;
                case 'n11_process';
                    require_once("inc/modules/entegration/pazar/n11_process.php");
                    break;
                case 'n11_process_post';
                    require_once("inc/modules/entegration/pazar/n11_process_post.php");
                    break;
                case 'n11_process_products';
                    require_once("inc/modules/entegration/pazar/n11_process_products.php");
                    break;
                case 'n11_sync';
                    require_once("inc/modules/catalog/pazar/categories_n11_sync.php");
                    break;


                case 'ty_settings';
                    require_once("inc/modules/entegration/pazar/ty_settings.php");
                    break;
                case 'ty_sync';
                    require_once("inc/modules/catalog/pazar/categories_ty_sync.php");
                    break;
                case 'product_detail_entegration_ty';
                    require_once("inc/modules/catalog/pazar/product_detail_ty.php");
                    break;
                case 'ty_process_post';
                    require_once("inc/modules/entegration/pazar/ty_process_urunleri_gonder.php");
                    break;
                case 'ty_process';
                    require_once("inc/modules/entegration/pazar/ty_process.php");
                    break;
                case 'ty_aktarilan_urunler';
                    require_once("inc/modules/entegration/pazar/ty_aktarilan_products.php");
                    break;
                case 'ty_rapor_urunler';
                    require_once("inc/modules/entegration/pazar/ty_rapor_products.php");
                    break;
                case 'ty_stoklari_cek';
                    require_once("inc/modules/entegration/pazar/ty_process_stoklari_cek.php");
                    break;
                case 'ty_toplu_guncelleme';
                    require_once("inc/modules/entegration/pazar/ty_process_guncelleme_yap.php");
                    break;
                case 'ty_orders';
                    require_once("inc/modules/orders/pazar/ty_orders.php");
                    break;
                case 'ty_order_detail';
                    require_once("inc/modules/orders/pazar/ty_orders_detail.php");
                    break;




                case 'hb_settings';
                    require_once("inc/modules/entegration/pazar/hb_settings.php");
                    break;
                case 'hb_sync';
                    require_once("inc/modules/catalog/pazar/categories_hb_sync.php");
                    break;
                case 'product_detail_entegration_hb';
                    require_once("inc/modules/catalog/pazar/product_detail_hb.php");
                    break;
                case 'hb_envanter';
                    require_once("inc/modules/entegration/pazar/hb_envanter.php");
                    break;
                case 'hb_process';
                    require_once("inc/modules/entegration/pazar/hb_process.php");
                    break;
                case 'hb_aktarilan_urunler';
                    require_once("inc/modules/entegration/pazar/hb_onaya_gonderilenler_listesi.php");
                    break;


            }
        }else {
            ?>
            <?php
            header('Location:'.$ayar['panel_url'].'');
            ?>
            <?php
        }
        ?>

        <?php if($panelayar['footer_text'] == !null  ) {?>
            <!-- Footer -->
            <footer class="footer" style="background-color: #<?=$panelayar['footer_bg']?>;" >
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 " style="color: #<?=$panelayar['footer_text_color']?> !important;">
                            <?=$panelayar['footer_text']?>
                        </div>
                    </div>
                </div>
            </footer>
            <!-- End Footer -->
        <?php }?>
        <div id="foot_divider"></div>
        <?php include 'inc/template/footerlibs.php'; ?>
    </div>
    </body>
    </html>
    <?php include 'inc/template/all-modals.php'; ?>
<?php }else{
    header('Location:'.$ayar['site_url'].'404');
}
?>