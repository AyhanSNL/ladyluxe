<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php if($userSorgusu->rowCount()>'0'   && $uyeayar['durum'] == '1'  ) {?>
    <?php if(isMobileDevice()  ) {?>
        <div class="category-detail-mobile-acc">
            <div class="category-detail-mobile-acc-in">
                <a class="category-detail-mobile-acc-filter"  data-toggle="collapse" data-target="#userAccordion" aria-expanded="false" aria-controls="collapseForm">
                    <i class="fa fa-bars"></i> <?=$diller['users-panel-left-menu-text-mobil']?>
                </a>
            </div>
            <div id="accordion" class="accordion">
                <div class="collapse" id="userAccordion" data-parent="#accordion">
                    <div class=" border-top ">
                        <div class="subpage_navigation" >
                            <div class="user_subpage_left_bar_main" style="border:0 !important;">
                                <div class="user_subpage_left_bar_namediv">
                                    <div class="user_subpage_left_bar_namediv_circle">
                                        <?php
                                        $shortname = mb_substr($userCek['isim'], 0, 1,'UTF-8');
                                        $shortsurname = mb_substr($userCek['soyisim'], 0, 1,'UTF-8');
                                        ?>
                                        <?=$shortname?><?=$shortsurname?>
                                    </div>
                                    <div class="user_subpage_left_bar_namediv_content">
                                        <?php if($uyeayar['basit_form'] == '0' ) {?>
                                            <?php if($userCek['uye_tip'] == '1' ) {?>
                                                <div class="user_subpage_left_bar_namediv_content_usertype"><?=$diller['users-panel-left-menu-text1']?></div>
                                            <?php }?>
                                            <?php if($userCek['uye_tip'] == '2' ) {?>
                                                <div class="user_subpage_left_bar_namediv_content_usertype"><?=$diller['users-panel-left-menu-text2']?></div>
                                            <?php }?>
                                        <?php }?>
                                        <div class="user_subpage_left_bar_namediv_content_h"><?=$userCek['isim']?> <?=$userCek['soyisim']?></div>
                                        <?php if($userCek['uye_grup'] == !null ) {?>
                                            <div class="user_subpage_left_bar_namediv_content_usergroup" <?php if($userCek['uye_grup_sure_durum'] == '1' ) { ?>data-toggle="popover" title="<?=$diller['users-panel-text195']?>" data-content="<?php echo date_tr('j F Y', ''.$userCek['uye_grup_sure_2'].''); ?>" style="cursor: pointer" <?php }?>>
                                                <?=$uyegrup['baslik']?>
                                                <?php if($userCek['uye_grup_sure_durum'] == '1' ) { ?>
                                                    <i class="fa fa-clock-o"></i>
                                                <?php } ?>
                                            </div>
                                        <?php }?>
                                    </div>
                                </div>
                                <!-- Menu Items !-->
                                <div class="user_subpage_left_bar_nav_desktop">
                                    <a href="hesabim/ayarlar/" class="user_subpage_left_bar_nav_desktop_items <?php if($userpage == 'hesap'  ) { ?>user_subpage_left_bar_nav_desktop_items_active<?php }?>">
                                        <div class="user_subpage_left_bar_nav_desktop_items_i">
                                            <i class="las la-user-cog" ></i>
                                        </div>
                                        <div class="user_subpage_left_bar_nav_desktop_items_t" >
                                            <?=$diller['users-panel-left-menu-text3']?>
                                        </div>
                                    </a>
                                    <?php if($uyeayar['siparisler_alani'] == '1'  ) {?>
                                        <a href="hesabim/siparisler/" class="user_subpage_left_bar_nav_desktop_items <?php if($userpage == 'siparis'  ) { ?>user_subpage_left_bar_nav_desktop_items_active<?php }?>">
                                            <div class="user_subpage_left_bar_nav_desktop_items_i">
                                                <i class="las la-cart-arrow-down" ></i>
                                            </div>
                                            <div class="user_subpage_left_bar_nav_desktop_items_t" >
                                                <?=$diller['users-panel-left-menu-text4']?>
                                            </div>
                                        </a>
                                    <?php }?>
                                    <?php if($uyeayar['iptal_alani'] == '1'  ) {?>
                                        <?php if($odemeayar['siparis_iptal'] == '1' || $odemeayar['siparis_urun_iade'] == '1') {?>
                                            <a href="hesabim/iptal-iade-talepleri/" class="user_subpage_left_bar_nav_desktop_items <?php if($userpage == 'iptal'  ) { ?>user_subpage_left_bar_nav_desktop_items_active<?php }?>">
                                                <div class="user_subpage_left_bar_nav_desktop_items_i">
                                                    <i class="las la-backspace"></i>
                                                </div>
                                                <div class="user_subpage_left_bar_nav_desktop_items_t">
                                                    <?=$diller['users-panel-left-menu-text5']?>
                                                </div>
                                            </a>
                                        <?php }?>
                                    <?php }?>
                                    <?php
                                    $teklifler = $db->prepare("select * from siparis_teklif where uye_id=:uye_id ");
                                    $teklifler->execute(array(
                                        'uye_id' => $userCek['id'],
                                    ));
                                    ?>
                                    <?php if($teklifler->rowCount()>'0'  ) {?>
                                        <a href="hesabim/teklifler/" class="user_subpage_left_bar_nav_desktop_items <?php if($userpage == 'teklif'  ) { ?>user_subpage_left_bar_nav_desktop_items_active<?php }?>">
                                            <div class="user_subpage_left_bar_nav_desktop_items_i">
                                                <i class="las la-edit"></i>
                                            </div>
                                            <div class="user_subpage_left_bar_nav_desktop_items_t">
                                                <?=$diller['users-panel-left-menu-text13']?>
                                            </div>
                                        </a>
                                    <?php }?>
                                    <?php
                                    $tekurun = $db->prepare("select * from siparis_normal where uye_id=:uye_id ");
                                    $tekurun->execute(array(
                                        'uye_id' => $userCek['id'],
                                    ));
                                    ?>
                                    <?php if($tekurun->rowCount()>'0'  ) {?>
                                        <a href="hesabim/tek-urun-siparisleri/" class="user_subpage_left_bar_nav_desktop_items <?php if($userpage == 'tekurun'  ) { ?>user_subpage_left_bar_nav_desktop_items_active<?php }?>">
                                            <div class="user_subpage_left_bar_nav_desktop_items_i">
                                                <i class="las la-box"></i>
                                            </div>
                                            <div class="user_subpage_left_bar_nav_desktop_items_t">
                                                <?=$diller['users-panel-left-menu-text12']?>
                                            </div>
                                        </a>
                                    <?php }?>
                                    <?php if($uyeayar['adres_alani'] == '1'  ) {?>
                                        <a href="hesabim/adresler/" class="user_subpage_left_bar_nav_desktop_items <?php if($userpage == 'adres'  ) { ?>user_subpage_left_bar_nav_desktop_items_active<?php }?>">
                                            <div class="user_subpage_left_bar_nav_desktop_items_i">
                                                <i class="lar la-map"></i>
                                            </div>
                                            <div class="user_subpage_left_bar_nav_desktop_items_t">
                                                <?=$diller['users-panel-left-menu-text6']?>
                                            </div>
                                        </a>
                                    <?php }?>
                                    <?php if($uyeayar['favori_alani'] == '1'  ) {?>
                                        <a href="hesabim/favoriler/" class="user_subpage_left_bar_nav_desktop_items <?php if($userpage == 'favori'  ) { ?>user_subpage_left_bar_nav_desktop_items_active<?php }?>">
                                            <div class="user_subpage_left_bar_nav_desktop_items_i">
                                                <i class="lar la-heart"></i>
                                            </div>
                                            <div class="user_subpage_left_bar_nav_desktop_items_t">
                                                <?=$diller['users-panel-left-menu-text11']?>
                                            </div>
                                        </a>
                                    <?php }?>

                                    <?php if($uyeayar['kupon_alani'] == '1'  ) {?>
                                        <a href="hesabim/kuponlar/" class="user_subpage_left_bar_nav_desktop_items <?php if($userpage == 'kupon'  ) { ?>user_subpage_left_bar_nav_desktop_items_active<?php }?>">
                                            <div class="user_subpage_left_bar_nav_desktop_items_i">
                                                <i class="las la-tags"></i>
                                            </div>
                                            <div class="user_subpage_left_bar_nav_desktop_items_t">
                                                <?=$diller['users-panel-left-menu-text7']?>
                                            </div>
                                        </a>
                                    <?php }?>
                                    <?php if($uyeayar['yorumlar_alani'] == '1'  ) {?>
                                        <a href="hesabim/yorumlar/" class="user_subpage_left_bar_nav_desktop_items <?php if($userpage == 'yorum'  ) { ?>user_subpage_left_bar_nav_desktop_items_active<?php }?>">
                                            <div class="user_subpage_left_bar_nav_desktop_items_i">
                                                <i class="las la-comment-dots"></i>
                                            </div>
                                            <div class="user_subpage_left_bar_nav_desktop_items_t">
                                                <?=$diller['users-panel-left-menu-text8']?>
                                            </div>
                                        </a>
                                    <?php }?>
                                    <?php if($uyeayar['destek_alani'] == '1'  ) {
                                        ?>
                                        <?php if($userCek['destek'] == '1' ||$userCek['destek'] == '2'  ) {?>
                                            <a href="hesabim/destek/" class="user_subpage_left_bar_nav_desktop_items <?php if($userpage == 'destek'  ) { ?>user_subpage_left_bar_nav_desktop_items_active<?php }?>">
                                                <div class="user_subpage_left_bar_nav_desktop_items_i">
                                                    <i class="las la-envelope"></i>
                                                </div>
                                                <div class="user_subpage_left_bar_nav_desktop_items_t">
                                                    <?=$diller['users-panel-left-menu-text9']?>
                                                </div>
                                            </a>
                                        <?php }?>
                                    <?php }?>
                                    <a href="logout/" class="user_subpage_left_bar_nav_desktop_items" >
                                        <div class="user_subpage_left_bar_nav_desktop_items_i">
                                            <i class="las la-sign-out-alt"></i>
                                        </div>
                                        <div class="user_subpage_left_bar_nav_desktop_items_t">
                                            <?=$diller['users-panel-left-menu-text10']?>
                                        </div>
                                    </a>
                                </div>
                                <!--  <========SON=========>>> Menu Items SON !-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(function () {
                $('#userAccordion').on('shown.bs.collapse', function (e) {
                    $('html,body').animate({
                            scrollTop: $('#userAccordion').offset().top - 80 },
                        500);
                });
            });
        </script>
    <?php }else { ?>
        <style>
            .popover-header{
                font-size: 13px ;
                font-weight: 600;
                background: #fff;
            }
            .popover{
                padding: 10px 15px;
                font-size: 12px ;
                font-family :  '<?=$uyeayar['font_select']?>',sans-serif ; ;
                box-shadow: 0 0 15px rgba(0,0,0,.1);
            }
        </style>
        <!-- Desktop !-->
        <div class="user_subpage_left_bar_main">
            <div class="user_subpage_left_bar_namediv">
                <div class="user_subpage_left_bar_namediv_circle">
                    <?php
                    $shortname = mb_substr($userCek['isim'], 0, 1,'UTF-8');
                    $shortsurname = mb_substr($userCek['soyisim'], 0, 1,'UTF-8');
                    ?>
                    <?=$shortname?><?=$shortsurname?>
                </div>
                <div class="user_subpage_left_bar_namediv_content">
                    <?php if($uyeayar['basit_form'] == '0' ) {?>
                        <?php if($userCek['uye_tip'] == '1' ) {?>
                            <div class="user_subpage_left_bar_namediv_content_usertype"><?=$diller['users-panel-left-menu-text1']?></div>
                        <?php }?>
                        <?php if($userCek['uye_tip'] == '2' ) {?>
                            <div class="user_subpage_left_bar_namediv_content_usertype"><?=$diller['users-panel-left-menu-text2']?></div>
                        <?php }?>
                    <?php }?>
                    <div class="user_subpage_left_bar_namediv_content_h"><?=$userCek['isim']?> <?=$userCek['soyisim']?></div>
                    <?php if($userCek['uye_grup'] == !null ) {?>
                        <div class="user_subpage_left_bar_namediv_content_usergroup" <?php if($userCek['uye_grup_sure_durum'] == '1' ) { ?>data-toggle="popover" title="<?=$diller['users-panel-text195']?>" data-content="<?php echo date_tr('j F Y', ''.$userCek['uye_grup_sure_2'].''); ?>" style="cursor: pointer" <?php }?>>
                            <?=$uyegrup['baslik']?>
                            <?php if($userCek['uye_grup_sure_durum'] == '1' ) { ?>
                                <i class="fa fa-clock-o"></i>
                            <?php } ?>
                        </div>
                    <?php }?>
                </div>
            </div>
            <!-- Menu Items !-->
            <div class="user_subpage_left_bar_nav_desktop">
                <a href="hesabim/ayarlar/" class="user_subpage_left_bar_nav_desktop_items <?php if($userpage == 'hesap'  ) { ?>user_subpage_left_bar_nav_desktop_items_active<?php }?>">
                    <div class="user_subpage_left_bar_nav_desktop_items_i">
                        <i class="las la-user-cog" ></i>
                    </div>
                    <div class="user_subpage_left_bar_nav_desktop_items_t" >
                        <?=$diller['users-panel-left-menu-text3']?>
                    </div>
                </a>
                <?php if($uyeayar['siparisler_alani'] == '1'  ) {?>
                    <a href="hesabim/siparisler/" class="user_subpage_left_bar_nav_desktop_items <?php if($userpage == 'siparis'  ) { ?>user_subpage_left_bar_nav_desktop_items_active<?php }?>">
                        <div class="user_subpage_left_bar_nav_desktop_items_i">
                            <i class="las la-cart-arrow-down" ></i>
                        </div>
                        <div class="user_subpage_left_bar_nav_desktop_items_t" >
                            <?=$diller['users-panel-left-menu-text4']?>
                        </div>
                    </a>
                <?php }?>
                <?php if($uyeayar['iptal_alani'] == '1'  ) {?>
                    <?php if($odemeayar['siparis_iptal'] == '1' || $odemeayar['siparis_urun_iade'] == '1') {?>
                        <a href="hesabim/iptal-iade-talepleri/" class="user_subpage_left_bar_nav_desktop_items <?php if($userpage == 'iptal'  ) { ?>user_subpage_left_bar_nav_desktop_items_active<?php }?>">
                            <div class="user_subpage_left_bar_nav_desktop_items_i">
                                <i class="las la-backspace"></i>
                            </div>
                            <div class="user_subpage_left_bar_nav_desktop_items_t">
                                <?=$diller['users-panel-left-menu-text5']?>
                            </div>
                        </a>
                    <?php }?>
                <?php }?>
                <?php
                $teklifler = $db->prepare("select * from siparis_teklif where uye_id=:uye_id ");
                $teklifler->execute(array(
                    'uye_id' => $userCek['id'],
                ));
                ?>
                <?php if($teklifler->rowCount()>'0'  ) {?>
                    <a href="hesabim/teklifler/" class="user_subpage_left_bar_nav_desktop_items <?php if($userpage == 'teklif'  ) { ?>user_subpage_left_bar_nav_desktop_items_active<?php }?>">
                        <div class="user_subpage_left_bar_nav_desktop_items_i">
                            <i class="las la-edit"></i>
                        </div>
                        <div class="user_subpage_left_bar_nav_desktop_items_t">
                            <?=$diller['users-panel-left-menu-text13']?>
                        </div>
                    </a>
                <?php }?>
                <?php
                $tekurun = $db->prepare("select * from siparis_normal where uye_id=:uye_id ");
                $tekurun->execute(array(
                    'uye_id' => $userCek['id'],
                ));
                ?>
                <?php if($tekurun->rowCount()>'0'  ) {?>
                    <a href="hesabim/tek-urun-siparisleri/" class="user_subpage_left_bar_nav_desktop_items <?php if($userpage == 'tekurun'  ) { ?>user_subpage_left_bar_nav_desktop_items_active<?php }?>">
                        <div class="user_subpage_left_bar_nav_desktop_items_i">
                            <i class="las la-box"></i>
                        </div>
                        <div class="user_subpage_left_bar_nav_desktop_items_t">
                            <?=$diller['users-panel-left-menu-text12']?>
                        </div>
                    </a>
                <?php }?>
                <?php if($uyeayar['adres_alani'] == '1'  ) {?>
                    <a href="hesabim/adresler/" class="user_subpage_left_bar_nav_desktop_items <?php if($userpage == 'adres'  ) { ?>user_subpage_left_bar_nav_desktop_items_active<?php }?>">
                        <div class="user_subpage_left_bar_nav_desktop_items_i">
                            <i class="lar la-map"></i>
                        </div>
                        <div class="user_subpage_left_bar_nav_desktop_items_t">
                            <?=$diller['users-panel-left-menu-text6']?>
                        </div>
                    </a>
                <?php }?>
                <?php if($uyeayar['favori_alani'] == '1'  ) {?>
                    <a href="hesabim/favoriler/" class="user_subpage_left_bar_nav_desktop_items <?php if($userpage == 'favori'  ) { ?>user_subpage_left_bar_nav_desktop_items_active<?php }?>">
                        <div class="user_subpage_left_bar_nav_desktop_items_i">
                            <i class="lar la-heart"></i>
                        </div>
                        <div class="user_subpage_left_bar_nav_desktop_items_t">
                            <?=$diller['users-panel-left-menu-text11']?>
                        </div>
                    </a>
                <?php }?>

                <?php if($uyeayar['kupon_alani'] == '1'  ) {?>
                    <a href="hesabim/kuponlar/" class="user_subpage_left_bar_nav_desktop_items <?php if($userpage == 'kupon'  ) { ?>user_subpage_left_bar_nav_desktop_items_active<?php }?>">
                        <div class="user_subpage_left_bar_nav_desktop_items_i">
                            <i class="las la-tags"></i>
                        </div>
                        <div class="user_subpage_left_bar_nav_desktop_items_t">
                            <?=$diller['users-panel-left-menu-text7']?>
                        </div>
                    </a>
                <?php }?>
                <?php if($uyeayar['yorumlar_alani'] == '1'  ) {?>
                    <a href="hesabim/yorumlar/" class="user_subpage_left_bar_nav_desktop_items <?php if($userpage == 'yorum'  ) { ?>user_subpage_left_bar_nav_desktop_items_active<?php }?>">
                        <div class="user_subpage_left_bar_nav_desktop_items_i">
                            <i class="las la-comment-dots"></i>
                        </div>
                        <div class="user_subpage_left_bar_nav_desktop_items_t">
                            <?=$diller['users-panel-left-menu-text8']?>
                        </div>
                    </a>
                <?php }?>
                <?php if($uyeayar['destek_alani'] == '1'  ) {
                    ?>
                    <?php if($userCek['destek'] == '1' ||$userCek['destek'] == '2'  ) {?>
                        <a href="hesabim/destek/" class="user_subpage_left_bar_nav_desktop_items <?php if($userpage == 'destek'  ) { ?>user_subpage_left_bar_nav_desktop_items_active<?php }?>">
                            <div class="user_subpage_left_bar_nav_desktop_items_i">
                                <i class="las la-envelope"></i>
                            </div>
                            <div class="user_subpage_left_bar_nav_desktop_items_t">
                                <?=$diller['users-panel-left-menu-text9']?>
                            </div>
                        </a>
                    <?php }?>
                <?php }?>
                <a href="logout/" class="user_subpage_left_bar_nav_desktop_items" >
                    <div class="user_subpage_left_bar_nav_desktop_items_i">
                        <i class="las la-sign-out-alt"></i>
                    </div>
                    <div class="user_subpage_left_bar_nav_desktop_items_t">
                        <?=$diller['users-panel-left-menu-text10']?>
                    </div>
                </a>
            </div>
            <!--  <========SON=========>>> Menu Items SON !-->
        </div>
        <!--  <========SON=========>>> Desktop SON !-->
    <?php }?>
<?php }?>