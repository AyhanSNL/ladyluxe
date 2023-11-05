<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<div class="navbar-custom" >
    <div class="container-fluid" >

        <div id="navigation" >

            <!-- Navigation Menu-->
            <ul class="navigation-menu" style="position: relative;  ">

                <li class="has-submenu head-ayirac  d-none d-lg-inline-block " >
                    <a href="<?=$ayar['panel_url']?>"   style="padding-left:5px; padding-right: 5px; " >
                        <i class="fas fa-home" style="margin-right: 0;"></i>
                    </a>
                </li>

                <li class="has-submenu head-ayirac d-lg-none d-sm-inline-block position-relative  dropdown-sub-have w-100">
                    <a href="<?=$ayar['panel_url']?>"><i class="fas fa-home"></i> <?=$diller['adminpanel-menu-text-1']?> </a>
                </li>

                <?php if($yetki['katalog'] == '1' ) {?>
                    <li class="has-submenu head-ayirac position-relative  dropdown-sub-have">
                        <a href="#"
                            <?php if($_GET['page'] == 'products' || $_GET['page'] == 'categories' ||$_GET['page'] == 'brands'||$_GET['page'] == 'e_catalog'||$_GET['page'] == 'product_features'||$_GET['page'] == 'product_variants'||$_GET['page'] == 'products_comments' ||$_GET['page'] == 'allupdate_product' ) {?>
                                style="color: #5985ee;"
                            <?php }?>><i class="far fa-file-pdf"></i> <?=$diller['adminpanel-menu-text-2']?> </a>
                        <ul class="submenu normal-menu-arrow">
                            <?php if($yetki['katalog'] == '1' && $yetki['urun'] == '1' ) {?>
                                <li  >
                                    <a href="pages.php?page=products" <?php if($_GET['page'] == 'products'  ) { ?>style="font-weight: 500; color: #5985ee;"<?php }?>><?=$diller['adminpanel-menu-text-3']?></a>
                                </li>
                            <?php } ?>
                            <?php if($yetki['katalog'] == '1' && $yetki['kat'] == '1' ) {?>
                                <li>
                                    <a href="pages.php?page=categories" <?php if($_GET['page'] == 'categories'  ) { ?>style="font-weight: 500; color: #5985ee;"<?php }?>> <?=$diller['adminpanel-menu-text-4']?></a>
                                </li>
                            <?php } ?>
                            <?php if($yetki['katalog'] == '1' && $yetki['marka'] == '1' ) {?>
                                <li>
                                    <a href="pages.php?page=brands" <?php if($_GET['page'] == 'brands'  ) { ?>style="font-weight: 500; color: #5985ee;"<?php }?>> <?=$diller['adminpanel-menu-text-5']?></a>
                                </li>
                            <?php } ?>
                            <li>
                                <a href="pages.php?page=e_catalog" <?php if($_GET['page'] == 'e_catalog'  ) { ?>style="font-weight: 500; color: #5985ee;"<?php }?>> <?=$diller['adminpanel-menu-text-182']?></a>
                            </li>
                            <?php if($yetki['katalog'] == '1' && $yetki['varyant'] == '1' ) {?>
                                <li style="width: 112%; border-bottom: 1px solid #EBEBEB; margin:7px 0; margin-left: -13px;"></li>
                                <li>
                                    <a href="pages.php?page=product_features" <?php if($_GET['page'] == 'product_features'  ) { ?>style="font-weight: 500; color: #5985ee;"<?php }?>> <?=$diller['adminpanel-menu-text-6']?></a>
                                </li>
                                <li>
                                    <a href="pages.php?page=product_variants" <?php if($_GET['page'] == 'product_variants'  ) { ?>style="font-weight: 500; color: #5985ee;"<?php }?>>  <?=$diller['adminpanel-menu-text-7']?></a>
                                </li>
                            <?php } ?>
                            <?php if($yetki['katalog'] == '1'  ) {?>
                                <?php if($yetki['toplu'] == '1' || $yetki['urun_yorum'] == '1'  ) {?>
                                    <li style="width: 112%; border-bottom: 1px solid #EBEBEB; margin:7px 0; margin-left: -13px;"></li>
                                    <?php if($yetki['urun_yorum'] == '1'  ) {?>
                                        <li>
                                            <a href="pages.php?page=products_comments" <?php if($_GET['page'] == 'products_comments'  ) { ?>style="font-weight: 500; color: #5985ee;"<?php }?>> <?=$diller['adminpanel-menu-text-8']?></a>
                                        </li>
                                    <?php } ?>
                                    <?php if($yetki['toplu'] == '1'  ) {?>
                                        <li>
                                            <a href="pages.php?page=allupdate_product" <?php if($_GET['page'] == 'allupdate_product'  ) { ?>style="font-weight: 500; color: #5985ee;"<?php }?>> <?=$diller['adminpanel-menu-text-9']?></a>
                                        </li>
                                    <?php } ?>
                                <?php } ?>
                            <?php } ?>
                        </ul>
                    </li>
                <?php }?>

                <?php if($yetki['siparis'] == '1' ) {?>
                    <li class="has-submenu head-ayirac position-relative dropdown-sub-have">
                        <a href="#"><i class="fa fa-shopping-basket"></i> <?=$diller['adminpanel-menu-text-16']?> </a>
                        <ul class="submenu normal-menu-arrow">
                            <?php if($yetki['siparis'] == '1' && $yetki['siparis_yonet'] == '1' ) {?>
                                <li>
                                    <a href="pages.php?page=orders"><?=$diller['adminpanel-menu-text-17']?></a>
                                </li>
                                <li>
                                    <a href="pages.php?page=op_orders"><?=$diller['adminpanel-menu-text-18']?></a>
                                </li>
                                <li>
                                    <a href="pages.php?page=offers"><?=$diller['adminpanel-menu-text-19']?></a>
                                </li>
                                <li style="width: 112%; border-bottom: 1px solid #EBEBEB; margin:2px 0; margin-left: -13px;"></li>
                                <li style="background-color: #ff400d; padding-left: 12px; margin-left: -13px; border-bottom: 1px solid #FFF !important; width: 112%;">
                                    <a class="text-white" href="pages.php?page=ty_orders">Trendyol <?=$diller['pazaryeri-text-129']?></a>
                                </li>
                                <li style="width: 112%; border-bottom: 1px solid #EBEBEB; margin:2px 0; margin-left: -13px;"></li>
                                <li>
                                    <a href="pages.php?page=order_cancel"><?=$diller['adminpanel-menu-text-20']?></a>
                                </li>
                                <li>
                                    <a href="pages.php?page=order_product_return"><?=$diller['adminpanel-menu-text-21']?></a>
                                </li>
                            <?php } ?>
                            <?php if($yetki['siparis'] == '1' && $yetki['odeme_bildirim'] == '1' && $yetki['siparis_yonet'] == '1' ) {?>
                                <li style="width: 112%; border-bottom: 1px solid #EBEBEB; margin:2px 0; margin-left: -13px;"></li>
                            <?php } ?>
                            <?php if($yetki['siparis'] == '1' & $yetki['odeme_bildirim'] == '1' ) {?>
                                <li>
                                    <a href="pages.php?page=bank_transfer"><?=$diller['adminpanel-menu-text-22']?></a>
                                </li>
                            <?php } ?>
                            <?php if($yetki['siparis'] == '1' && $yetki['siparis_diger'] == '1'  ) {?>
                                <li style="width: 112%; border-bottom: 1px solid #EBEBEB; margin:2px 0; margin-left: -13px;"></li>
                                <li>
                                    <a href="pages.php?page=all_cart_list"><?=$diller['adminpanel-menu-text-23']?></a>
                                    <a href="pages.php?page=nocomplete_orders"><?=$diller['adminpanel-menu-text-24']?></a>
                                </li>
                                <li style="width: 112%; border-bottom: 1px solid #EBEBEB; margin:2px 0; margin-left: -13px;"></li>
                                <li>
                                    <a href="pages.php?page=order_reports"><?=$diller['adminpanel-menu-text-95']?></a>
                                </li>
                                <li>
                                    <a href="pages.php?page=sale_reports"><?=$diller['adminpanel-menu-text-96']?></a>
                                </li>
                            <?php } ?>
                        </ul>
                    </li>
                <?php }?>


                <?php if($yetki['uyelik'] == '1' ) {?>
                    <li class="has-submenu head-ayirac position-relative dropdown-sub-have">
                        <a href="#"><i class="fa fa-users"></i> <?=$diller['adminpanel-menu-text-25']?> </a>
                        <ul class="submenu normal-menu-arrow">
                            <?php if($yetki['uyelik'] == '1' && $yetki['uye_yonet'] == '1'  ) {?>
                                <li><a href="pages.php?page=users"><?=$diller['adminpanel-menu-text-26']?></a></li>
                                <li><a href="pages.php?page=users_group"><?=$diller['adminpanel-menu-text-27']?></a></li>
                            <?php }?>
                            <?php if($yetki['uyelik'] == '1' && $yetki['ticket'] == '1'  ) {?>
                                <li class="bg-success" style="padding-left: 12px; margin-left: -13px; width: 112%; "><a href="pages.php?page=tickets" style="color: #FFF !important;"><?=$diller['adminpanel-menu-text-28']?></a></li>
                            <?php } ?>
                            <?php if($yetki['uyelik'] == '1' && $yetki['uyelik_ayar'] == '1'  ) {?>
                                <li><a href="pages.php?page=users_settings"><?=$diller['adminpanel-menu-text-29']?></a></li>
                            <?php }?>
                            <?php if($yetki['uyelik'] == '1' && $yetki['ziyaretci_istatistik'] == '1'  ) {?>
                                <li><a href="pages.php?page=visitor_analytics"><?=$diller['adminpanel-text-60']?></a></li>
                            <?php }?>
                        </ul>
                    </li>
                <?php }?>


                <?php if($yetki['kampanya'] == '1' ) {?>
                    <li class="has-submenu head-ayirac position-relative dropdown-sub-have">
                        <a href="#"><i class="fas fa-percentage"></i> <?=$diller['adminpanel-menu-text-30']?> </a>
                        <ul class="submenu normal-menu-arrow">
                            <?php if($yetki['kampanya'] == '1' && $yetki['indirimkod'] == '1' ) {?>
                                <li>
                                    <a href="pages.php?page=coupons"><?=$diller['adminpanel-menu-text-31']?></a>
                                </li>
                                <li>
                                    <a href="pages.php?page=first_order_discount"><?=$diller['adminpanel-menu-text-179']?></a>
                                </li>
                                <li>
                                    <a href="pages.php?page=cart_discount"><?=$diller['adminpanel-menu-text-180']?></a>
                                </li>
                            <?php } ?>
                            <?php if($yetki['kampanya'] == '1' && $yetki['eposta_yonet'] == '1' ) {?>
                                <li style="width: 112%; border-bottom: 1px solid #EBEBEB; margin:7px 0; margin-left: -13px;"></li>
                                <li>
                                    <a href="pages.php?page=email_list"><?=$diller['adminpanel-menu-text-32']?></a>
                                    <a href="pages.php?page=newsletter"><?=$diller['adminpanel-menu-text-33']?></a>
                                </li>
                            <?php } ?>
                            <?php if($yetki['kampanya'] == '1' && $yetki['sms_yonet'] == '1' ) {?>
                                <li style="width: 112%; border-bottom: 1px solid #EBEBEB; margin:7px 0; margin-left: -13px;"></li>
                                <li>
                                    <a href="pages.php?page=sms_numbers"><?=$diller['adminpanel-menu-text-36']?></a>
                                    <a href="pages.php?page=multi_sms"><?=$diller['adminpanel-menu-text-37']?></a>
                                </li>
                            <?php } ?>
                            <?php if($yetki['kampanya'] == '1' && $yetki['bildirim_gonder'] == '1' && $yetki['sms_yonet'] == '1') {?>
                                <li style="width: 112%; border-bottom: 1px solid #EBEBEB; margin:7px 0; margin-left: -13px;"></li>
                            <?php } ?>
                            <?php if($yetki['kampanya'] == '1' && $yetki['bildirim_gonder'] == '1' ) {?>
                                <li>
                                    <a href="pages.php?page=notifications"><i class="mdi mdi-bell-outline"></i> <?=$diller['adminpanel-menu-text-40']?></a>
                                </li>
                            <?php } ?>
                        </ul>
                    </li>
                <?php }?>


                <?php if($yetki['icerik_yonetim'] == '1' ) {?>
                    <li class="has-submenu head-ayirac position-relative dropdown-sub-have">
                        <a href="#" ><i class="fas fa-file"></i> <?=$diller['adminpanel-menu-text-41']?> </a>
                        <ul class="submenu normal-menu-arrow">
                            <?php if($yetki['icerik_yonetim'] == '1' && $yetki['sayfa_yonet'] == '1' ) {?>
                                <li><a href="pages.php?page=sub_navigations"><?=$diller['adminpanel-menu-text-42']?></a></li>
                                <li><a href="pages.php?page=page_management"><?=$diller['adminpanel-menu-text-47']?></a></li>
                                <li class="has-submenu">
                                    <a href="#"><?=$diller['adminpanel-menu-text-48']?></a>
                                    <ul class="submenu">
                                        <li><a href="pages.php?page=user_contract"><?=$diller['adminpanel-menu-text-49']?></a></li>
                                        <li><a href="pages.php?page=sale_contract"><?=$diller['adminpanel-menu-text-50']?></a></li>
                                        <li><a href="pages.php?page=cookie_contract"><?=$diller['adminpanel-menu-text-73']?></a></li>
                                    </ul>
                                </li>
                            <?php } ?>
                            <?php if($yetki['icerik_yonetim'] == '1' && $yetki['ptable'] == '1' ) {?>
                                <li><a href="pages.php?page=pricing_table"><?=$diller['adminpanel-menu-text-51']?></a></li>
                            <?php } ?>
                            <?php if($yetki['icerik_yonetim'] == '1' && $yetki['blog_hizmet'] == '1' ) {?>
                                <li class="has-submenu">
                                    <a href="#"><?=$diller['adminpanel-menu-text-53']?></a>
                                    <ul class="submenu">
                                        <li><a href="pages.php?page=blogs_categories"><?=$diller['adminpanel-menu-text-54-2']?></a></li>
                                        <li><a href="pages.php?page=blogs"><?=$diller['adminpanel-menu-text-54']?></a></li>
                                        <li><a href="pages.php?page=blog_comments"><?=$diller['adminpanel-menu-text-55']?></a></li>
                                    </ul>
                                </li>
                                <li class="has-submenu">
                                    <a href="#"><?=$diller['adminpanel-menu-text-56']?></a>
                                    <ul class="submenu">
                                        <li><a href="pages.php?page=services"><?=$diller['adminpanel-menu-text-57']?></a></li>
                                        <li><a href="pages.php?page=service_comments"><?=$diller['adminpanel-menu-text-58']?></a></li>
                                    </ul>
                                </li>
                            <?php } ?>
                            <?php if($yetki['icerik_yonetim'] == '1' && $yetki['galeri'] == '1' ) {?>
                                <li><a href="pages.php?page=photo_gallery"><?=$diller['adminpanel-menu-text-59']?></a></li>
                                <li><a href="pages.php?page=video_gallery"><?=$diller['adminpanel-menu-text-60']?></a></li>
                                <li><a href="pages.php?page=intro"><?=$diller['adminpanel-menu-text-61']?></a></li>
                            <?php } ?>
                            <?php if($yetki['icerik_yonetim'] == '1' && $yetki['icerik_diger'] == '1' ) {?>
                                <li><a href="pages.php?page=contact_page"><?=$diller['adminpanel-menu-text-62']?></a></li>
                                <li><a href="pages.php?page=social_accounts"><?=$diller['adminpanel-menu-text-63']?></a></li>
                                <li><a href="pages.php?page=counters"><?=$diller['adminpanel-menu-text-64']?></a></li>
                                <li><a href="pages.php?page=commerce_boxes"><?=$diller['adminpanel-menu-text-65']?></a></li>
                                <li><a href="pages.php?page=client_comments"><?=$diller['adminpanel-menu-text-66']?></a></li>
                                <li><a href="pages.php?page=faq"><?=$diller['adminpanel-menu-text-52']?></a></li>
                                <li><a href="pages.php?page=merchants"><?=$diller['adminpanel-menu-text-187']?></a></li>
                            <?php } ?>
                        </ul>
                    </li>
                <?php }?>

                <?php if($yetki['modul'] == '1' ) {?>
                    <li class="has-submenu head-ayirac position-relative dropdown-sub-have">
                        <a href="#"><i class="fas fa-layer-group"></i> <?=$diller['adminpanel-menu-text-67']?> </a>
                        <ul class="submenu normal-menu-arrow">
                            <?php if($yetki['modul'] == '1' && $yetki['sirala'] == '1' ) {?>
                                <li><a href="pages.php?page=modules_sort"><?=$diller['adminpanel-menu-text-68']?></a></li>
                            <?php } ?>
                            <?php if($yetki['modul'] == '1' && $yetki['modul_header_footer'] == '1' ) {?>
                                <li><a href="pages.php?page=tophtml_area"><?=$diller['adminpanel-menu-text-44']?></a></li>
                                <li class="has-submenu">
                                    <a href="#"><?=$diller['adminpanel-menu-text-43']?></a>
                                    <ul class="submenu">
                                        <li><a href="pages.php?page=topheader_links"><?=$diller['adminpanel-menu-text-45']?></a></li>
                                        <li><a href="pages.php?page=header_links"><?=$diller['adminpanel-menu-text-46']?></a></li>
                                    </ul>
                                </li>
                                <li><a href="pages.php?page=footer_links"><?=$diller['adminpanel-menu-text-97']?></a></li>
                            <?php } ?>
                            <?php if($yetki['modul'] == '1' && $yetki['modul_diger'] == '1' ) {?>
                                <li><a href="pages.php?page=top_slider"><?=$diller['adminpanel-menu-text-69']?></a></li>
                                <li><a href="pages.php?page=middle_slider"><?=$diller['adminpanel-menu-text-70']?></a></li>
                                <li><a href="pages.php?page=stories"><?=$diller['adminpanel-menu-text-71']?></a></li>
                            <?php } ?>
                            <?php if($yetki['modul'] == '1' && $yetki['modul_vitrin'] == '1' ) {?>
                                <li><a href="pages.php?page=showcase_tabproduct"><?=$diller['adminpanel-menu-text-11']?></a></li>
                                <li><a href="pages.php?page=showcase_bannerproduct"><?=$diller['adminpanel-menu-text-12']?></a></li>
                                <li><a href="pages.php?page=showcase_banner1"><?=$diller['adminpanel-menu-text-13']?></a></li>
                                <li><a href="pages.php?page=showcase_banner2"><?=$diller['adminpanel-menu-text-14']?></a></li>
                                <li><a href="pages.php?page=showcase_countdown"><?=$diller['adminpanel-menu-text-15']?></a></li>
                                <li><a href="pages.php?page=showcase_html"><?=$diller['adminpanel-menu-text-72']?></a></li>
                            <?php } ?>
                        </ul>
                    </li>
                <?php }?>

                <?php if($yetki['yapilandirma'] == '1' ) {?>
                    <li class="has-submenu head-ayirac position-relative dropdown-sub-have">
                        <a href="#"><i class="fas fa-wrench"></i> <?=$diller['adminpanel-menu-text-75']?> </a>
                        <ul class="submenu normal-menu-arrow">
                            <li><a href="pages.php?page=payment_settings"><?=$diller['adminpanel-menu-text-76']?></a></li>
                            <li><a href="pages.php?page=pos_settings"><?=$diller['adminpanel-menu-text-77']?></a></li>
                            <li><a href="pages.php?page=order_status"><?=$diller['adminpanel-menu-text-78']?></a></li>
                            <li><a href="pages.php?page=commerce_settings"><?=$diller['adminpanel-menu-text-79']?></a></li>
                            <li> <a href="pages.php?page=bank_accounts"><?=$diller['adminpanel-menu-text-80']?></a></li>
                            <li><a href="pages.php?page=countries"><?=$diller['adminpanel-menu-text-81']?></a></li>
                            <li><a href="pages.php?page=currency"><?=$diller['adminpanel-menu-text-82']?></a></li>
                            <li><a href="pages.php?page=delivery_settings"><?=$diller['adminpanel-menu-text-83']?></a></li>
                            <li><a href="pages.php?page=delivery_company"><?=$diller['adminpanel-menu-text-84']?></a></li>
                            <li><a href="pages.php?page=installment_rate"><?=$diller['adminpanel-menu-text-85']?></a></li>
                            <li><a href="pages.php?page=smtp_settings"><?=$diller['adminpanel-menu-text-35']?></a></li>
                            <li><a href="pages.php?page=sms_settings"><?=$diller['adminpanel-menu-text-39']?></a></li>
                        </ul>
                    </li>
                <?php } ?>


                <?php if($yetki['entegrasyon'] == '1' ) {?>
                    <li class="has-submenu head-ayirac position-relative dropdown-sub-have">
                        <a href="#" <?php if($_GET['page'] == 'hb_settings' || $_GET['page'] == 'hb_process' || $_GET['page'] == 'ty_settings'||$_GET['page'] == 'ty_process'|| $_GET['page'] == 'sitemap' || $_GET['page'] == 'n11_settings'|| $_GET['page'] == 'n11_process_products'  ||$_GET['page'] == 'n11_process' ||$_GET['page'] == 'product_import' ||$_GET['page'] == 'product_export' ||$_GET['page'] == 'email_list_import' ||$_GET['page'] == 'gsm_list_import') {?>
                            style="color: #5985ee;"
                        <?php }?>><i class="fas fa-exchange-alt"></i> <?=$diller['adminpanel-menu-text-86']?> </a>
                        <ul class="submenu normal-menu-arrow">
                            <?php if($yetki['entegrasyon'] == '1' &&  $yetki['entegrasyon_pazar'] == '1') {?>
                                <li >
                                    <a href="pages.php?page=n11_settings" <?php if($_GET['page'] == 'n11_settings'  ) { ?>style="font-weight: 500; color: #5985ee;"<?php }?> class="d-flex align-center justify-content-between">
                                        <?=$diller['pazaryeri-text-1']?>
                                        <img src="assets/images/n11.png" width="20">
                                    </a>
                                </li>
                                <li >
                                    <a href="pages.php?page=n11_process" <?php if($_GET['page'] == 'n11_process'|| $_GET['page'] == 'n11_process_products'   ) { ?>style="font-weight: 500; color: #5985ee;"<?php }?> class="d-flex align-center justify-content-between">
                                        <?=$diller['pazaryeri-text-42']?>
                                        <img src="assets/images/n11.png" width="20">
                                    </a>
                                </li>
                                <li style="width: 112%; border-bottom: 1px solid #EBEBEB; margin:7px 0; margin-left: -13px;"></li>
                                <li >
                                    <a href="pages.php?page=ty_settings" <?php if($_GET['page'] == 'ty_settings'  ) { ?>style="font-weight: 500; color: #5985ee;"<?php }?> class="d-flex align-center justify-content-between">
                                        <?=$diller['pazaryeri-text-72']?>
                                        <img src="assets/images/ty.png" width="20">
                                    </a>
                                </li>
                                <li >
                                    <a href="pages.php?page=ty_process" <?php if($_GET['page'] == 'ty_process'|| $_GET['page'] == 'ty_process_products'   ) { ?>style="font-weight: 500; color: #5985ee;"<?php }?> class="d-flex align-center justify-content-between">
                                        <?=$diller['pazaryeri-text-73']?>
                                        <img src="assets/images/ty.png" width="20">
                                    </a>
                                </li>
                                <li style="width: 112%; border-bottom: 1px solid #EBEBEB; margin:7px 0; margin-left: -13px;"></li>
                                <li >
                                    <a href="pages.php?page=hb_settings" <?php if($_GET['page'] == 'hb_settings'  ) { ?>style="font-weight: 500; color: #5985ee;"<?php }?> class="d-flex align-center justify-content-between">
                                        <?=$diller['pazaryeri-text-147']?>
                                        <img src="assets/images/hb.png" width="20">
                                    </a>
                                </li>
                                <li >
                                    <a href="pages.php?page=hb_process" <?php if($_GET['page'] == 'hb_process'|| $_GET['page'] == 'hb_process_products'   ) { ?>style="font-weight: 500; color: #5985ee;"<?php }?> class="d-flex align-center justify-content-between">
                                        <?=$diller['pazaryeri-text-148']?>
                                        <img src="assets/images/hb.png" width="20">
                                    </a>
                                </li>
                                <li style="width: 112%; border-bottom: 1px solid #EBEBEB; margin:7px 0; margin-left: -13px;"></li>
                            <?php } ?>
                            <?php if($yetki['entegrasyon'] == '1' &&  $yetki['parasut'] == '1') {
                                //todo paraşüt
                                ?>
                                <li >
                                    <a href="pages2.php?page=parasut_ayar" <?php if($_GET['page'] == 'parasut_ayar'  ) { ?>style="font-weight: 500; color: #5985ee;"<?php }?> class="d-flex align-center justify-content-between">
                                        <?=$diller['parasut-text-1']?>
                                        <img src="assets/images/parsut.png" >
                                    </a>
                                </li>
                                <li >
                                    <a href="pages2.php?page=parasut_fatura" <?php if($_GET['page'] == 'parasut_fatura'  ) { ?>style="font-weight: 500; color: #5985ee;"<?php }?> class="d-flex align-center justify-content-between">
                                        <?=$diller['parasut-text-6']?>
                                        <img src="assets/images/parsut.png" >
                                    </a>
                                </li>
                                <li style="width: 112%; border-bottom: 1px solid #EBEBEB; margin:7px 0; margin-left: -13px;"></li>
                            <?php } ?>
                            <?php if($yetki['entegrasyon'] == '1' &&  $yetki['entegrasyon_urun'] == '1') {?>
                                <li >
                                    <a href="pages.php?page=product_import" <?php if($_GET['page'] == 'product_import'  ) { ?>style="font-weight: 500; color: #5985ee;"<?php }?>><span class="badge badge-primary float-right" style="font-weight: 400;">XML</span> <?=$diller['adminpanel-menu-text-87']?></a>
                                </li>
                                <li >
                                    <a href="pages.php?page=product_export" class="d-flex align-items-center justify-content-between" <?php if($_GET['page'] == 'product_export'  ) { ?>style="font-weight: 500; color: #5985ee;"<?php }?>> <?=$diller['adminpanel-menu-text-88']?> <span class="badge badge-primary p-1 " style="font-weight: 400;">XML</span></a>
                                </li>
                            <?php } ?>
                            <?php if($yetki['entegrasyon'] == '1' &&  $yetki['entegrasyon_eposta'] == '1') {?>
                                <li style="width: 112%; border-bottom: 1px solid #EBEBEB; margin:7px 0; margin-left: -13px;"></li>
                                <li >
                                    <a href="pages.php?page=email_list_import" <?php if($_GET['page'] == 'email_list_import'  ) { ?>style="font-weight: 500; color: #5985ee;"<?php }?>><span class="badge badge-primary float-right" style="font-weight: 400;">XML</span> <?=$diller['adminpanel-menu-text-91']?></a>
                                </li>
                            <?php } ?>
                            <?php if($yetki['entegrasyon'] == '1' &&  $yetki['entegrasyon_sms'] == '1') {?>
                                <li style="width: 112%; border-bottom: 1px solid #EBEBEB; margin:7px 0; margin-left: -13px;"></li>
                                <li >
                                    <a href="pages.php?page=gsm_list_import" <?php if($_GET['page'] == 'gsm_list_import'  ) { ?>style="font-weight: 500; color: #5985ee;"<?php }?>><span class="badge badge-primary float-right" style="font-weight: 400;">XML</span> <?=$diller['adminpanel-menu-text-89']?></a>
                                </li>
                            <?php } ?>
                            <?php if($yetki['entegrasyon'] == '1' &&  $yetki['entegrasyon_map'] == '1') {?>
                                <li style="width: 112%; border-bottom: 1px solid #EBEBEB; margin:7px 0; margin-left: -13px;"></li>
                                <li >
                                    <a href="pages.php?page=sitemap" <?php if($_GET['page'] == 'sitemap'  ) { ?>style="font-weight: 500; color: #5985ee;"<?php }?>><span class="badge badge-primary float-right" style="font-weight: 400;">XML</span> <?=$diller['adminpanel-menu-text-93']?></a>
                                </li>
                            <?php } ?>
                        </ul>
                    </li>
                <?php }?>

                <?php if($yetki['tema_ayarlar'] == '1' ) {?>
                    <li class="has-submenu head-ayirac dropdown-sub-have ">
                        <a href="#" class="position-relative mega-menu-arrow " ><i class="fas fa-feather-alt"></i> <?=$diller['adminpanel-menu-text-98']?> </a>
                        <ul class="submenu megamenu" style="z-index: 9999">
                            <div  class="d-flex justify-content-start align-items-start flex-wrap megamenu-geneldiv">
                                <div style="width: 100%; box-sizing:border-box;  font-size:18px ; font-weight: 500; margin-bottom: 10px; padding-bottom: 10px; border-bottom: 1px solid #EBEBEB; text-align: center;">
                                    <?=$diller['adminpanel-menu-text-149']?>
                                </div>
                                <div class="dis_div">
                                    <div class="megamenu_item_ic_div">
                                        <div class="themebox_main" >
                                            <div class="themebox_item mt-0">
                                                <div class="themebox_item_img">
                                                    <i class="las la-chalkboard"></i>
                                                </div>
                                                <div class="themebox_item_heading_txt">
                                                    <?=$diller['adminpanel-menu-text-99']?>
                                                    <div class="themebox_small">
                                                        <?=$diller['adminpanel-menu-text-100']?>
                                                    </div>
                                                    <a href="pages.php?page=theme_header_settings">
                                                        <?=$diller['adminpanel-form-text-1947']?>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="themebox_item mt-0">
                                                <div class="themebox_item_img">
                                                    <i class="las la-window-minimize"></i>
                                                </div>
                                                <div class="themebox_item_heading_txt">
                                                    <?=$diller['adminpanel-menu-text-101']?>
                                                    <div class="themebox_small">
                                                        <?=$diller['adminpanel-menu-text-102']?>
                                                    </div>
                                                    <a href="pages.php?page=theme_footer_settings">
                                                        <?=$diller['adminpanel-form-text-1947']?>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="themebox_item mt-0">
                                                <div class="themebox_item_img">
                                                    <i class="las la-mobile"></i>
                                                </div>
                                                <div class="themebox_item_heading_txt">
                                                    <?=$diller['adminpanel-menu-text-184']?>
                                                    <div class="themebox_small">
                                                        <?=$diller['adminpanel-menu-text-185']?>
                                                    </div>
                                                    <a href="pages.php?page=theme_mobil_settings">
                                                        <?=$diller['adminpanel-form-text-1947']?>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="themebox_item ">
                                                <div class="themebox_item_img">
                                                    <i class="las la-tags"></i>
                                                </div>
                                                <div class="themebox_item_heading_txt">
                                                    <?=$diller['adminpanel-menu-text-103']?>
                                                    <div class="themebox_small">
                                                        <?=$diller['adminpanel-menu-text-104']?>
                                                    </div>
                                                    <a href="pages.php?page=theme_catalog_settings">
                                                        <?=$diller['adminpanel-form-text-1947']?>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="themebox_item">
                                                <div class="themebox_item_img">
                                                    <i class="las la-users-cog"></i>
                                                </div>
                                                <div class="themebox_item_heading_txt">
                                                    <?=$diller['adminpanel-menu-text-107']?>
                                                    <div class="themebox_small">
                                                        <?=$diller['adminpanel-menu-text-108']?>
                                                    </div>
                                                    <a href="pages.php?page=theme_users_settings">
                                                        <?=$diller['adminpanel-form-text-1947']?>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="themebox_item">
                                                <div class="themebox_item_img">
                                                    <i class="fas fa-font" style="font-size: 27px ;"></i><i class="fas fa-italic" style="font-size: 27px ;"></i>
                                                </div>
                                                <div class="themebox_item_heading_txt">
                                                    <?=$diller['adminpanel-menu-text-109']?>
                                                    <div class="themebox_small">
                                                        <?=$diller['adminpanel-menu-text-110']?>
                                                    </div>
                                                    <a href="pages.php?page=fonts">
                                                        <?=$diller['adminpanel-form-text-1947']?>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="themebox_item">
                                                <div class="themebox_item_img">
                                                    <i class="las la-pager"></i>
                                                </div>
                                                <div class="themebox_item_heading_txt">
                                                    <?=$diller['adminpanel-menu-text-111']?>
                                                    <div class="themebox_small">
                                                        <?=$diller['adminpanel-menu-text-112']?>
                                                    </div>
                                                    <a href="pages.php?page=theme_banners">
                                                        <?=$diller['adminpanel-form-text-1947']?>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="themebox_item">
                                                <div class="themebox_item_img">
                                                    <i class="las la-mail-bulk"></i>
                                                </div>
                                                <div class="themebox_item_heading_txt">
                                                    <?=$diller['adminpanel-menu-text-113']?>
                                                    <div class="themebox_small">
                                                        <?=$diller['adminpanel-menu-text-114']?>
                                                    </div>
                                                    <a href="pages.php?page=theme_mail">
                                                        <?=$diller['adminpanel-form-text-1947']?>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="themebox_item">
                                                <div class="themebox_item_img">
                                                    <i class="las la-receipt"></i>
                                                </div>
                                                <div class="themebox_item_heading_txt">
                                                    <?=$diller['adminpanel-menu-text-181']?>
                                                    <div class="themebox_small">
                                                        <?=$diller['adminpanel-menu-text-183']?>
                                                    </div>
                                                    <a href="pages.php?page=theme_print_invoice">
                                                        <?=$diller['adminpanel-form-text-1947']?>
                                                    </a>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="themebox_right_main">
                                            <div class="themebox_right_main-heading">
                                                <?=$diller['adminpanel-menu-text-186']?>
                                            </div>
                                            <!-- Linkler !-->
                                            <div class="w-100 mb-4">
                                                <a class="themebox_right_main-box" href="pages.php?page=theme_cart">
                                                    <i class="las la-caret-right"></i> <?=$diller['adminpanel-menu-text-115']?>
                                                </a>
                                                <a class="themebox_right_main-box" href="pages.php?page=preloader">
                                                    <i class="las la-caret-right"></i> <?=$diller['adminpanel-menu-text-123']?>
                                                </a>
                                                <a class="themebox_right_main-box" href="pages.php?page=theme_slider">
                                                    <i class="las la-caret-right"></i> <?=$diller['adminpanel-menu-text-125']?>
                                                </a>



                                                <a class="themebox_right_main-box" href="pages.php?page=theme_404">
                                                    <i class="las la-caret-right"></i> <?=$diller['adminpanel-menu-text-131']?>
                                                </a>
                                                <a class="themebox_right_main-box" href="pages.php?page=theme_compare">
                                                    <i class="las la-caret-right"></i>  <?=$diller['adminpanel-menu-text-119']?>
                                                </a>
                                                <a class="themebox_right_main-box" href="pages.php?page=theme_contact">
                                                    <i class="las la-caret-right"></i>  <?=$diller['adminpanel-menu-text-121']?>
                                                </a>
                                                <a class="themebox_right_main-box" href="pages.php?page=theme_story">
                                                    <i class="las la-caret-right"></i>  <?=$diller['adminpanel-menu-text-127']?>
                                                </a>
                                                <a class="themebox_right_main-box" href="pages.php?page=theme_modal">
                                                    <i class="las la-caret-right"></i>  <?=$diller['adminpanel-menu-text-129']?>
                                                </a>
                                                <a class="themebox_right_main-box" href="pages.php?page=theme_banks">
                                                    <i class="las la-caret-right"></i>  <?=$diller['adminpanel-menu-text-133']?>
                                                </a>
                                                <a class="themebox_right_main-box" href="pages.php?page=theme_pricing">
                                                    <i class="las la-caret-right"></i>  <?=$diller['adminpanel-menu-text-135']?>
                                                </a>
                                                <a class="themebox_right_main-box" href="pages.php?page=theme_services">
                                                    <i class="las la-caret-right"></i>  <?=$diller['adminpanel-menu-text-137']?>
                                                </a>
                                                <a class="themebox_right_main-box" href="pages.php?page=theme_blogs">
                                                    <i class="las la-caret-right"></i>  <?=$diller['adminpanel-menu-text-139']?>
                                                </a>
                                                <a class="themebox_right_main-box" href="pages.php?page=theme_enews">
                                                    <i class="las la-caret-right"></i>  <?=$diller['adminpanel-menu-text-141']?>
                                                </a>
                                                <a class="themebox_right_main-box" href="pages.php?page=theme_client_comments">
                                                    <i class="las la-caret-right"></i>  <?=$diller['adminpanel-menu-text-143']?>
                                                </a>
                                                <a class="themebox_right_main-box" href="pages.php?page=theme_client_counter">
                                                    <i class="las la-caret-right"></i>  <?=$diller['adminpanel-menu-text-145']?>
                                                </a>
                                                <a class="themebox_right_main-box" href="pages.php?page=theme_faq">
                                                    <i class="las la-caret-right"></i>  <?=$diller['adminpanel-menu-text-147']?>
                                                </a>
                                                <a class="themebox_right_main-box" href="pages.php?page=theme_gallery">
                                                    <i class="las la-caret-right"></i>  <?=$diller['adminpanel-menu-text-174']?>
                                                </a>
                                                <a class="themebox_right_main-box" href="pages.php?page=theme_videos">
                                                    <i class="las la-caret-right"></i>  <?=$diller['adminpanel-menu-text-175']?>
                                                </a>
                                                <a class="themebox_right_main-box" href="pages.php?page=theme_intro">
                                                    <i class="las la-caret-right"></i>  <?=$diller['adminpanel-menu-text-176']?>
                                                </a>
                                            </div>
                                            <!--  <========SON=========>>> Linkler SON !-->

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </ul>
                    </li>
                <?php } ?>

                <?php if($yetki['site_ayarlar'] == '1' ) {?>
                    <li class="has-submenu head-ayirac dropdown-sub-have " >
                        <a href="#" class="position-relative mega-menu-arrow " style="transition-duration: 2s; transition-timing-function: linear;"><i class="fas fa-cog"></i> <?=$diller['adminpanel-menu-text-151']?> </a>
                        <ul class="submenu megamenu">
                            <div class="d-flex justify-content-start align-items-start flex-wrap megamenu-geneldiv">
                                <div style="width: 100%; box-sizing:border-box;  font-size:18px ; font-weight: 500; text-align: center; margin-bottom: 10px; padding-bottom: 10px; border-bottom: 1px solid #EBEBEB;">
                                    <?=$diller['adminpanel-menu-text-150']?>
                                </div>
                                <div class="dis_div">
                                    <div class="megamenu_item_ic_div" >
                                        <!-- itembox !-->
                                        <?php if($yetki['site_ayarlar'] == '1' && $yetki['ayar_yonet'] == '1' ) {?>
                                            <a href="pages.php?page=settings" class="megamenu_set_item_box">
                                                <div class="megamenu_item_box_img">
                                                    <img src="assets/images/icon/settings.png">
                                                </div>
                                                <div class="megamenu_item_box_h">
                                                    <?=$diller['adminpanel-menu-text-152']?>
                                                </div>
                                                <div class="megamenu_item_box_s">
                                                    <?=$diller['adminpanel-menu-text-153']?>
                                                </div>
                                            </a>
                                            <a href="pages.php?page=panel_settings" class="megamenu_set_item_box">
                                                <div class="megamenu_item_box_img">
                                                    <img src="assets/images/icon/panel_settings.png">
                                                </div>
                                                <div class="megamenu_item_box_h">
                                                    <?=$diller['adminpanel-menu-text-154']?>
                                                </div>
                                                <div class="megamenu_item_box_s">
                                                    <?=$diller['adminpanel-menu-text-155']?>
                                                </div>
                                            </a>
                                        <?php }?>
                                        <?php if($yetki['site_ayarlar'] == '1' && $yetki['yonetici'] == '1' ) {?>
                                            <a href="pages.php?page=admin_list" class="megamenu_set_item_box">
                                                <div class="megamenu_item_box_img">
                                                    <img src="assets/images/icon/panel_admin.png">
                                                </div>
                                                <div class="megamenu_item_box_h">
                                                    <?=$diller['adminpanel-menu-text-156']?>
                                                </div>
                                                <div class="megamenu_item_box_s">
                                                    <?=$diller['adminpanel-menu-text-157']?>
                                                </div>
                                            </a>
                                            <a href="pages.php?page=admin_permission" class="megamenu_set_item_box">
                                                <div class="megamenu_item_box_img">
                                                    <img src="assets/images/icon/panel_yetki.png">
                                                </div>
                                                <div class="megamenu_item_box_h">
                                                    <?=$diller['adminpanel-menu-text-158']?>
                                                </div>
                                                <div class="megamenu_item_box_s">
                                                    <?=$diller['adminpanel-menu-text-159']?>
                                                </div>
                                            </a>
                                            <a href="pages.php?page=login_log" class="megamenu_set_item_box">
                                                <div class="megamenu_item_box_img">
                                                    <img src="assets/images/icon/panel_log.png">
                                                </div>
                                                <div class="megamenu_item_box_h">
                                                    <?=$diller['adminpanel-menu-text-160']?>
                                                </div>
                                                <div class="megamenu_item_box_s">
                                                    <?=$diller['adminpanel-menu-text-161']?>
                                                </div>
                                            </a>
                                        <?php }?>
                                        <?php if($yetki['site_ayarlar'] == '1' && $yetki['dil_yonet'] == '1' ) {?>
                                            <a href="pages.php?page=languages" class="megamenu_set_item_box">
                                                <div class="megamenu_item_box_img">
                                                    <img src="assets/images/icon/lang.png">
                                                </div>
                                                <div class="megamenu_item_box_h">
                                                    <?=$diller['adminpanel-menu-text-162']?>
                                                </div>
                                                <div class="megamenu_item_box_s">
                                                    <?=$diller['adminpanel-menu-text-163']?>
                                                </div>
                                            </a>
                                        <?php }?>
                                        <?php if($yetki['site_ayarlar'] == '1' && $yetki['ayar_diger'] == '1' ) {?>
                                            <a href="pages.php?page=maintenance" class="megamenu_set_item_box">
                                                <div class="megamenu_item_box_img">
                                                    <img src="assets/images/icon/bakim.png">
                                                    <!-- Bakım Mod Kontrol !-->
                                                    <?php if($bakim['durum'] == '0' ) {?>
                                                        <span class="badge badge-danger float-right font-12"><?=$diller['adminpanel-menu-text-167']?></span>
                                                    <?php }?>
                                                    <?php if($bakim['durum'] == '1' ) {?>
                                                        <span class="badge badge-success float-right font-12"><span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> <?=$diller['adminpanel-menu-text-166']?></span>
                                                    <?php }?>
                                                    <!--  <========SON=========>>> Bakım Mod Kontrol SON !-->
                                                </div>
                                                <div class="megamenu_item_box_h">
                                                    <?=$diller['adminpanel-menu-text-164']?>
                                                </div>
                                                <div class="megamenu_item_box_s">
                                                    <?=$diller['adminpanel-menu-text-165']?>
                                                </div>
                                            </a>
                                            <a href="pages.php?page=popup" class="megamenu_set_item_box">
                                                <div class="megamenu_item_box_img">
                                                    <img src="assets/images/icon/popup.png">
                                                    <!-- Popup Kontrol !-->
                                                    <?php if($popup['durum'] == '0' ) {?>
                                                        <span class="badge badge-danger float-right font-12"><?=$diller['adminpanel-menu-text-167']?></span>
                                                    <?php }?>
                                                    <?php if($popup['durum'] == '1' ) {?>
                                                        <span class="badge badge-success float-right font-12"><span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> <?=$diller['adminpanel-menu-text-166']?></span>
                                                    <?php }?>
                                                    <!--  <========SON=========>>> Popup Kontrol SON !-->
                                                </div>
                                                <div class="megamenu_item_box_h">
                                                    <?=$diller['adminpanel-menu-text-168']?>
                                                </div>
                                                <div class="megamenu_item_box_s">
                                                    <?=$diller['adminpanel-menu-text-169']?>
                                                </div>
                                            </a>
                                            <a href="pages.php?page=code" class="megamenu_set_item_box">
                                                <div class="megamenu_item_box_img">
                                                    <img src="assets/images/icon/code.png">
                                                </div>
                                                <div class="megamenu_item_box_h">
                                                    <?=$diller['adminpanel-menu-text-170']?>
                                                </div>
                                                <div class="megamenu_item_box_s">
                                                    <?=$diller['adminpanel-menu-text-171']?>
                                                </div>
                                            </a>
                                            <a href="pages.php?page=cache_settings" class="megamenu_set_item_box">
                                                <div class="megamenu_item_box_img">
                                                    <img src="assets/images/icon/cache.png">
                                                </div>
                                                <div class="megamenu_item_box_h">
                                                    <?=$diller['adminpanel-menu-text-172']?>
                                                </div>
                                                <div class="megamenu_item_box_s">
                                                    <?=$diller['adminpanel-menu-text-173']?>
                                                </div>
                                            </a>
                                        <?php }?>
                                        <!--  <========SON=========>>> itembox SON !-->
                                    </div>

                                </div>
                            </div>
                        </ul>
                    </li>
                <?php } ?>
            </ul>
            <!-- End navigation menu -->
        </div> <!-- end #navigation -->
    </div> <!-- end container -->
</div> <!-- end navbar-custom -->

