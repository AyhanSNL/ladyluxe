<?php include 'inc/session.php'; ?>
<?php if($adminSorgu->rowCount()> '0'  ) {?>
    <?php
    //todo ioncube
    if(isset($_GET['page'])){
        $s = $_GET['page'];
        switch($s){
            case 'header_counter';
                require_once("inc/template/counters/counter_header.php");
                break;
            case 'home_visitors';
                require_once("inc/template/counters/home_visitors.php");
                break;
            case 'home_data_counters';
                require_once("inc/template/counters/counter_data_modules.php");
                break;
            case 'home_sale_statistic';
                require_once("inc/template/counters/home-sale-reports.php");
                break;
            case 'home_order_statistic';
                require_once("inc/template/counters/home-order-reports.php");
                break;
            case 'bekleyen_isler';
                require_once("inc/template/counters/bekleyen_isler_counts.php");
                break;
            case 'order_type_pie';
                require_once("inc/template/counters/order_type_pie.php");
                break;
            case 'lang_edit';
                require_once("inc/modules/language/language_edit.php");
                break;
            case 'font_edit';
                require_once("inc/modules/theme/font_edit.php");
                break;
            case 'order_status_edit';
                require_once("inc/modules/config/order_status_edit.php");
                break;
            case 'bank_accounts_edit';
                require_once("inc/modules/config/bank_accounts_edit.php");
                break;
            case 'countries_edit';
                require_once("inc/modules/config/countries_edit.php");
                break;
            case 'currency_edit';
                require_once("inc/modules/config/currency_edit.php");
                break;
            case 'delivery_company_edit';
                require_once("inc/modules/config/delivery_company_edit.php");
                break;
            case 'installment_rate_edit';
                require_once("inc/modules/config/installment_rate_edit.php");
                break;
            case 'installment_month_edit';
                require_once("inc/modules/config/installment_month_edit.php");
                break;
            case 'topheader_links_edit';
                require_once("inc/modules/modules/topheader_links_edit.php");
                break;
            case 'headermenu_product_select';
                require_once("inc/modules/modules/header_links_product_select.php");
                break;
            case 'header_sub_links_edit';
                require_once("inc/modules/modules/header_sub_links_edit.php");
                break;

            case 'mobile_header_edit';
                require_once("inc/modules/modules/mobile_header_edit.php");
                break;

            case 'mobile_header_list_edit';
                require_once("inc/modules/modules/mobile_header_list_edit.php");
                break;


            case 'footer_links_edit';
                require_once("inc/modules/modules/footer_links_edit.php");
                break;
            case 'footer_sub_links_edit';
                require_once("inc/modules/modules/footer_sub_links_edit.php");
                break;
            case 'middle_slider_edit';
                require_once("inc/modules/modules/middle_slider_edit.php");
                break;
            case 'stories_edit';
                require_once("inc/modules/modules/stories_edit.php");
                break;
            case 'stories_item_edit';
                require_once("inc/modules/modules/stories_item_edit.php");
                break;
            case 'showcase_bannerproduct_edit';
                require_once("inc/modules/modules/showcase_bannerproduct_edit.php");
                break;
            case 'showcase_banner1_edit';
                require_once("inc/modules/modules/showcase_banner1_edit.php");
                break;
            case 'showcase_banner2_edit';
                require_once("inc/modules/modules/showcase_banner2_edit.php");
                break;
            case 'showcase_countdown_edit';
                require_once("inc/modules/modules/showcase_countdown_edit.php");
                break;

            case 'sub_navigations_edit';
                require_once("inc/modules/contents/sub_navigations_edit.php");
                break;
            case 'sub_navigations_links_edit';
                require_once("inc/modules/contents/sub_navigations_links_edit.php");
                break;
            case 'page_management_edit';
                require_once("inc/modules/contents/page_management_edit.php");
                break;
            case 'ptable_edit';
                require_once("inc/modules/contents/ptable_edit.php");
                break;
            case 'ptable_list_edit';
                require_once("inc/modules/contents/ptable_list_edit.php");
                break;
            case 'ptable_list_features_edit';
                require_once("inc/modules/contents/ptable_list_features_edit.php");
                break;
            case 'blog_edit';
                require_once("inc/modules/contents/blog_edit.php");
                break;
            case 'blog_cat_edit';
                require_once("inc/modules/contents/blog_cat_edit.php");
                break;
            case 'blog_comments_edit';
                require_once("inc/modules/contents/blog_comments_edit.php");
                break;
            case 'blog_select';
                require_once("inc/modules/contents/blog_select.php");
                break;
            case 'modul_comment_settings';
                require_once("inc/modules/contents/modul_comment_settings.php");
                break;
            case 'merchants_edit';
                require_once("inc/modules/contents/merchants_edit.php");
                break;
            case 'merchants_theme';
                require_once("inc/modules/contents/merchants_theme.php");
                break;
            case 'merchants_gallery';
                require_once("inc/modules/contents/merchants_gallery.php");
                break;
            case 'services_edit';
                require_once("inc/modules/contents/services_edit.php");
                break;
            case 'service_comments_edit';
                require_once("inc/modules/contents/service_comments_edit.php");
                break;
            case 'service_select';
                require_once("inc/modules/contents/service_select.php");
                break;
            case 'photo_gallery_edit';
                require_once("inc/modules/contents/photo_gallery_edit.php");
                break;
            case 'video_gallery_edit';
                require_once("inc/modules/contents/video_gallery_edit.php");
                break;
            case 'contact_edit';
                require_once("inc/modules/contents/contact_edit.php");
                break;
            case 'social_edit';
                require_once("inc/modules/contents/social_edit.php");
                break;
            case 'counters_edit';
                require_once("inc/modules/contents/counters_edit.php");
                break;
            case 'tbox_edit';
                require_once("inc/modules/contents/tbox_edit.php");
                break;
            case 'client_comments_edit';
                require_once("inc/modules/contents/client_comments_edit.php");
                break;
            case 'faq_edit';
                require_once("inc/modules/contents/faq_edit.php");
                break;
            case 'pricing_list_product_select';
                require_once("inc/modules/contents/pricing_list_product_select.php");
                break;
            case 'coupon_edit';
                require_once("inc/modules/campaign/coupon_edit.php");
                break;
            case 'user_select';
                require_once("inc/modules/campaign/user_select.php");
                break;
            case 'tabproduct_select';
                require_once("inc/modules/modules/showcase_tabproduct_select.php");
                break;
            case 'email_list_edit';
                require_once("inc/modules/campaign/email_list_edit.php");
                break;
            case 'mail_account_select';
                require_once("inc/modules/campaign/mail_account_select.php");
                break;
            case 'sms_list_edit';
                require_once("inc/modules/campaign/sms_list_edit.php");
                break;
            case 'sms_number_select';
                require_once("inc/modules/campaign/sms_number_select.php");
                break;
            case 'noti_edit';
                require_once("inc/modules/campaign/noti_edit.php");
                break;
            case 'user_address_edit';
                require_once("inc/modules/users/user_address_edit.php");
                break;
            case 'users_group_edit';
                require_once("inc/modules/users/users_group_edit.php");
                break;
            case 'ticket_msg_edit';
                require_once("inc/modules/users/ticket_msg_edit.php");
                break;
            case 'online_track';
                require_once("inc/modules/users/online_track.php");
                break;
            case 'daily_visitor_for_detail';
                require_once("inc/modules/users/analytics/daily_visitor.php");
                break;
            case 'weekly_visitor_for_detail';
                require_once("inc/modules/users/analytics/weekly_visitor.php");
                break;
            case 'monthly_visitor_for_detail';
                require_once("inc/modules/users/analytics/monthly_visitor.php");
                break;
            case 'year_visitor_for_detail';
                require_once("inc/modules/users/analytics/year_visitor.php");
                break;
            case 'op_order_edit';
                require_once("inc/modules/orders/single_orders_edit.php");
                break;
            case 'offer_edit';
                require_once("inc/modules/orders/offer_orders_edit.php");
                break;
            case 'bank_transfer_detail';
                require_once("inc/modules/orders/bank_transfer_detail.php");
                break;

            case 'daily_order_for_detail';
                require_once("inc/modules/orders/analytics/daily_order.php");
                break;
            case 'week_order_for_detail';
                require_once("inc/modules/orders/analytics/weekly_order.php");
                break;
            case 'month_order_for_detail';
                require_once("inc/modules/orders/analytics/monthly_order.php");
                break;
            case 'year_order_for_detail';
                require_once("inc/modules/orders/analytics/year_order.php");
                break;


            case 'shortlink_edit';
                require_once("inc/modules/shortlink_edit.php");
                break;

            case 'brand_select';
                require_once("inc/modules/catalog/brand_select.php");
                break;

            case 'features_select';
                require_once("inc/modules/catalog/features_select.php");
                break;
            case 'variant_select';
                require_once("inc/modules/catalog/variant_select.php");
                break;
            case 'variant_edit';
                require_once("inc/modules/catalog/variant_edit.php");
                break;
            case 'variant_stock_edit';
                require_once("inc/modules/catalog/variant_stock_edit.php");
                break;

            case 'category_edit';
                require_once("inc/modules/catalog/category_edit.php");
                break;

            case 'sub_category_edit';
                require_once("inc/modules/catalog/sub_category_edit.php");
                break;
            case 'brand_edit';
                require_once("inc/modules/catalog/brand_edit.php");
                break;
            case 'ecatalog_edit';
                require_once("inc/modules/catalog/ecatalog_edit.php");
                break;
            case 'feature_group_edit';
                require_once("inc/modules/catalog/feature_group_edit.php");
                break;
            case 'feature_list_edit';
                require_once("inc/modules/catalog/feature_list_edit.php");
                break;
            case 'variant_group_edit';
                require_once("inc/modules/catalog/variant_group_edit.php");
                break;
            case 'variant_list_edit';
                require_once("inc/modules/catalog/variant_list_edit.php");
                break;
            case 'product_comment_edit';
                require_once("inc/modules/catalog/product_comment_edit.php");
                break;
            case 'product_comment_settings';
                require_once("inc/modules/catalog/product_comment_settings.php");
                break;
            case 'category_select';
                require_once("inc/modules/catalog/category_select.php");
                break;
            case 'sitemap_edit';
                require_once("inc/modules/entegration/sitemap_edit.php");
                break;
            case 'product_export_modal';
                require_once("inc/modules/entegration/product_export_modal.php");
                break;
            case 'product_export_xls_modal';
                require_once("inc/modules/entegration/product_export_modal_xls.php");
                break;
            case 'product_export_xml_edit';
                require_once("inc/modules/entegration/product_export_xml_edit.php");
                break;

            case 'n11CatSelect';
                require_once("inc/modules/entegration/pazar/n11_cat_select.php");
                break;
            case 'n11_subcat';
                require_once("inc/modules/entegration/pazar/n11_subcat_select.php");
                break;
            case 'n11_tek_aktar';
                require_once("inc/modules/entegration/pazar/n11_tekurunaktar.php");
                break;
            case 'n11_tek_guncelle';
                require_once("inc/modules/entegration/pazar/n11_tekurunguncelle.php");
                break;
            case 'n11_toplu_islem_kaydi';
                require_once("inc/modules/entegration/pazar/n11_topluislem_kaydi.php");
                break;
            case 'n11_toplu_islem_kaydi_edit';
                require_once("inc/modules/entegration/pazar/n11_topluislem_kaydi_edit.php");
                break;
            case 'n11_topluguncelle_modal';
                require_once("inc/modules/entegration/pazar/n11_topluguncelle.php");
                break;


            case 'tyCatSelect';
                require_once("inc/modules/entegration/pazar/ty_cat_select.php");
                break;
            case 'ty_subcat';
                require_once("inc/modules/entegration/pazar/ty_subcat_select.php");
                break;
            case 'ty_tek_aktar';
                require_once("inc/modules/entegration/pazar/ty_tekurunaktar.php");
                break;
            case 'ty_tek_guncelle';
                require_once("inc/modules/entegration/pazar/ty_tekurunguncelle.php");
                break;
            case 'ty_toplu_urun_aktar';
                require_once("inc/modules/entegration/pazar/ty_topluurunaktar.php");
                break;
            case 'ty_urun_cek';
                require_once("inc/modules/entegration/pazar/ty_urun_cek.php");
                break;





            /* Hepsiburada */

            case 'hbCatSelect';
                require_once("inc/modules/entegration/pazar/hb_cat_select.php");
                break;

            case 'hb_log_popup';
                require_once("inc/modules/entegration/pazar/hb_log_goster_popup.php");
                break;
            case 'hb_statu_popup';
                require_once("inc/modules/entegration/pazar/hb_statu_kontrol_popup.php");
                break;
            case 'hb_tek_aktar';
                require_once("inc/modules/entegration/pazar/hb_tekurunaktar_popup.php");
                break;

            case 'hb_toplu_urun_aktar';
                require_once("inc/modules/entegration/pazar/hb_topluurunaktar_popup.php");
                break;

            case 'hb_satisa_ac';
                require_once("inc/modules/entegration/pazar/hb_satisa_ac_popup.php");
                break;
            case 'hb_satisa_cikar';
                require_once("inc/modules/entegration/pazar/hb_satisa_cikar_popup.php");
                break;
            case 'hb_satisi_durdur';
                require_once("inc/modules/entegration/pazar/hb_satisa_kapat_popup.php");
                break;
            case 'hb_env_sil';
                require_once("inc/modules/entegration/pazar/hb_envanterden_sil_popup.php");
                break;

            case 'hb_guncelle_envanter';
                require_once("inc/modules/entegration/pazar/hb_satis_guncelle_popup.php");
                break;
            case 'hb_env_urundetay_yolla';
                require_once("inc/modules/entegration/pazar/hb_envantere_yolla_urundetay_popup.php");
                break;

            /*  <========SON=========>>> Hepsiburada SON */


            
        }
    }else{
        header('Location:'.$ayar['site_url'].'404');
    }?>
    <?php
}else{
    header('Location:'.$ayar['site_url'].'404');
}
?>