<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php if(isMobileDevice()  ) {?>
    <?php
    $MarkaUrunleriLeftBar = $db->prepare("select * from urun where dil=:dil and durum=:durum and marka=:marka group by iliskili_kat");
    $MarkaUrunleriLeftBar->execute(array(
        'dil' => $_SESSION['dil'],
        'durum' => '1',
        'marka' => $markaMain['id']
    ));
    ?>
    <!-- Mobile Nav Bar !-->
    <div class="category-detail-mobile-acc">
        <div class="category-detail-mobile-acc-in">
            <?php if($MarkaUrunleriLeftBar->rowCount()>'0'  ) {?>
                <a class="category-detail-mobile-acc-subcat text-uppercase" data-toggle="collapse" data-target="#subcatAccordion" aria-expanded="false" aria-controls="collapseForm" style="font-size: 11px ;">
                    <?=$diller['kategori-detay-text39']?>
                </a>
            <?php }?>
            <a class="category-detail-mobile-acc-filter"  data-toggle="collapse" data-target="#filterAccordion" aria-expanded="false" aria-controls="collapseForm">
                <i class="fa fa-filter"></i> <?=$diller['kategori-detay-text41']?>
            </a>
        </div>
        <div id="accordion" class="accordion">
            <?php if($MarkaUrunleriLeftBar->rowCount()>'0'  ) {?>
                <div class="collapse" id="subcatAccordion" data-parent="#accordion">
                    <div class="subpage-mobile-nav border-top ">
                        <div class="subpage_navigation pl-3 pr-3 pt-2 pb-2" >
                            <?php foreach ($MarkaUrunleriLeftBar as $altkategori) {
                                $kategoriCek = $db->prepare("select * from urun_cat where id=:id");
                                $kategoriCek->execute(array(
                                    'id' => $altkategori['iliskili_kat'],
                                ));
                                $katName = $kategoriCek->fetch(PDO::FETCH_ASSOC);
                                ?>
                                <div class="category-sub-design-box">
                                    <li <?php if(isset($_GET['category']) && $_GET['category'] == $katName['id'] ) {?>class="category-sub-design-box-active"<?php } ?> >
                                        <?php if(isset($_GET['category']) && $_GET['category'] == $katName['id'] ) {?>
                                        <a href="<?=$browser_link?>?<?=$kategoriParseli?>"  <?php if(isset($_GET['category']) && $_GET['category'] == $katName['id'] ) {?>style="color: #<?=$islemayar['altkat_box_text_hover']?>;"<?php } ?> >
                                            <?php }else { ?>
                                            <a href="<?=$browser_link?><?php if(!isset($_GET['s'])) { ?>?s=1<?php }else{?>?<?php } ?><?=$kategoriParseli?>&category=<?=$katName['id']?>" >
                                                <?php }?>
                                                <?php if($katName['icon'] == !null ) {?>
                                                    <i class="<?=$katName['icon']?>"></i>
                                                <?php }?>
                                                <?=$katName['baslik']?>
                                            </a>
                                    </li>
                                </div>
                            <?php }?>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <div class="collapse" id="filterAccordion" data-parent="#accordion">
                <div class="subpage-mobile-nav border-top ">
                    <div class="subpage_navigation p-3" >
                        <?php if ($islemayar['filtre_bedavakargo'] == '1' || $islemayar['filtre_yeniler'] == '1' || $islemayar['filtre_firsatlar'] == '1' || $islemayar['filtre_indirimler'] == '1' || $islemayar['filtre_taksitler'] == '1' || $islemayar['filtre_hizlikargo'] == '1') { ?>
                            <div class="cat-left-box-main">
                                <div class="cat-left-box-h">
                                    <?=$diller['kategori-detay-text1']?>
                                    <div style="width: 30px; height: 3px; background-color: #<?= $islemayar['sol_nav_ayirac'] ?>; margin-top: 7px;  "></div>
                                </div>

                                <div class="cat-left-box-out-first" id="cat-left-overflow">
                                    <?php if ($islemayar['filtre_bedavakargo'] == '1') { ?>
                                        <div class="cat-left-box-t">
                                            <div class="custom-control custom-checkbox">
                                                <?php if($_GET['uk'] == '1'  ) {?>
                                                    <input type="checkbox" class="custom-control-input" id="uk" onclick="javascript:window.location='<?=$browser_link?>?<?=$ukParselMain?>'" checked >
                                                <?php }?>
                                                <?php if($_GET['uk'] == '0' || !isset($_GET['uk'])    ) {?>
                                                    <input type="checkbox" class="custom-control-input" id="uk" onclick="javascript:window.location='<?=$browser_link?><?php if(!isset($_GET['s'])) { ?>?s=1<?php }else{?>?<?php } ?><?=$ukParselMain?>&uk=1'" >
                                                <?php }?>
                                                <label class="custom-control-label" for="uk"><?=$diller['kategori-detay-text2']?></label>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <?php if ($islemayar['filtre_yeniler'] == '1') { ?>
                                        <div class="cat-left-box-t">
                                            <div class="custom-control custom-checkbox">
                                                <?php if($_GET['new'] == '1'  ) {?>
                                                    <input type="checkbox" class="custom-control-input" id="new" onclick="javascript:window.location='<?=$browser_link?>?<?=$npParselMain?>'" checked >
                                                <?php }?>
                                                <?php if($_GET['new'] == '0' || !isset($_GET['new'])    ) {?>
                                                    <input type="checkbox" class="custom-control-input" id="new" onclick="javascript:window.location='<?=$browser_link?><?php if(!isset($_GET['s'])) { ?>?s=1<?php }else{?>?<?php } ?><?=$npParselMain?>&new=1'" >
                                                <?php }?>
                                                <label class="custom-control-label" for="new"><?=$diller['kategori-detay-text3']?></label>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <?php if ($islemayar['filtre_firsatlar'] == '1') { ?>
                                        <div class="cat-left-box-t">
                                            <div class="custom-control custom-checkbox">
                                                <?php if($_GET['firsat'] == '1'  ) {?>
                                                    <input type="checkbox" class="custom-control-input" id="firsat" onclick="javascript:window.location='<?=$browser_link?>?<?=$opParselMain?>'" checked >
                                                <?php }?>
                                                <?php if($_GET['firsat'] == '0' || !isset($_GET['op'])    ) {?>
                                                    <input type="checkbox" class="custom-control-input" id="firsat" onclick="javascript:window.location='<?=$browser_link?><?php if(!isset($_GET['s'])) { ?>?s=1<?php }else{?>?<?php } ?><?=$opParselMain?>&firsat=1'" >
                                                <?php }?>
                                                <label class="custom-control-label" for="firsat"><?=$diller['kategori-detay-text4']?></label>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <?php if ($islemayar['filtre_indirimler'] == '1') { ?>
                                        <div class="cat-left-box-t">
                                            <div class="custom-control custom-checkbox">
                                                <?php if($_GET['indirim'] == '1'  ) {?>
                                                    <input type="checkbox" class="custom-control-input" id="indirim" onclick="javascript:window.location='<?=$browser_link?>?<?=$indirimParselMain?>'" checked >
                                                <?php }?>
                                                <?php if($_GET['indirim'] == '0' || !isset($_GET['indirim'])    ) {?>
                                                    <input type="checkbox" class="custom-control-input" id="indirim" onclick="javascript:window.location='<?=$browser_link?><?php if(!isset($_GET['s'])) { ?>?s=1<?php }else{?>?<?php } ?><?=$indirimParselMain?>&indirim=1'" >
                                                <?php }?>
                                                <label class="custom-control-label" for="indirim"><?=$diller['kategori-detay-text5']?></label>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <?php if ($islemayar['filtre_taksitler'] == '1') { ?>
                                        <div class="cat-left-box-t">
                                            <div class="custom-control custom-checkbox">
                                                <?php if($_GET['taksit'] == '1'  ) {?>
                                                    <input type="checkbox" class="custom-control-input" id="taksit" onclick="javascript:window.location='<?=$browser_link?>?<?=$taksitParselMain?>'" checked >
                                                <?php }?>
                                                <?php if($_GET['taksit'] == '0' || !isset($_GET['taksit'])    ) {?>
                                                    <input type="checkbox" class="custom-control-input" id="taksit" onclick="javascript:window.location='<?=$browser_link?><?php if(!isset($_GET['s'])) { ?>?s=1<?php }else{?>?<?php } ?><?=$taksitParselMain?>&taksit=1'" >
                                                <?php }?>
                                                <label class="custom-control-label" for="taksit"><?=$diller['kategori-detay-text6']?></label>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <?php if ($islemayar['filtre_hizlikargo'] == '1') { ?>
                                        <div class="cat-left-box-t">
                                            <div class="custom-control custom-checkbox">
                                                <?php if($_GET['hizlikargo'] == '1'  ) {?>
                                                    <input type="checkbox" class="custom-control-input" id="hizlikargo" onclick="javascript:window.location='<?=$browser_link?>?<?=$hkParselMain?>'" checked >
                                                <?php }?>
                                                <?php if($_GET['hizlikargo'] == '0' || !isset($_GET['hizlikargo'])    ) {?>
                                                    <input type="checkbox" class="custom-control-input" id="hizlikargo" onclick="javascript:window.location='<?=$browser_link?><?php if(!isset($_GET['s'])) { ?>?s=1<?php }else{?>?<?php } ?><?=$hkParselMain?>&hizlikargo=1'" >
                                                <?php }?>
                                                <label class="custom-control-label" for="hizlikargo"><?=$diller['kategori-detay-text7']?></label>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <?php if ($islemayar['filtre_editor'] == '1') { ?>
                                        <div class="cat-left-box-t">
                                            <div class="custom-control custom-checkbox">
                                                <?php if($_GET['editor'] == '1'  ) {?>
                                                    <input type="checkbox" class="custom-control-input" id="editorsecimi" onclick="javascript:window.location='<?=$browser_link?>?<?=$editorParselMain?>'" checked >
                                                <?php }?>
                                                <?php if($_GET['editor'] == '0' || !isset($_GET['editor'])    ) {?>
                                                    <input type="checkbox" class="custom-control-input" id="editorsecimi" onclick="javascript:window.location='<?=$browser_link?><?php if(!isset($_GET['s'])) { ?>?s=1<?php }else{?>?<?php } ?><?=$editorParselMain?>&editor=1'" >
                                                <?php }?>
                                                <label class="custom-control-label" for="editorsecimi"><?=$diller['kategori-detay-text38']?></label>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>

                            </div>
                        <?php } ?>

                        <?php if($varsayilankur['kod'] == $secilikur['kod'] ) {?>
                            <?php if($maxPrice > '0' && $minPrice >= '0'  ) {?>
                                <div class="cat-left-box-main">
                                    <div class="cat-left-box-h">
                                        <?=$diller['kategori-detay-text25']?>
                                        <div style="width: 30px; height: 3px; background-color: #<?= $islemayar['sol_nav_ayirac'] ?>; margin-top: 7px;  "></div>
                                    </div>
                                    <div class="cat-left-box-out-first"  >

                                        <fieldset class="filter-price">
                                            <div class="price-field">
                                                <?php
                                                $minPrice1 = number_format(kurhesapla($varsayilankur['deger'],$secilikur['deger'],$minPrice ), $secilikur['para_format']);
                                                $maxPrice2 = number_format(kurhesapla($varsayilankur['deger'],$secilikur['deger'],$maxPrice ), $secilikur['para_format']);
                                                ?>
                                                <input type="range" min="<?=$minPrice?>" max="<?=$maxPrice?>" value="<?=$minPrice?>" id="lower" name="min">
                                                <input  type="range" min="<?=$minPrice?>" max="<?=$maxPrice?>" value="<?=$maxPrice?>" id="upper" name="max">
                                            </div>

                                            <div class="price-wrap">
                                                <input id="one" type="hidden" >
                                                <input id="two" type="hidden" >
                                                <div class="price-wrap-outputbox">
                                                    <?php if($secilikur['simge_gosterim'] == '0' ) {?>
                                                        <?=$secilikur['sol_simge']?>
                                                    <?php }?>
                                                    <?php if($secilikur['simge_gosterim'] == '1' ) {?>
                                                        <?=$secilikur['sag_simge']?>
                                                    <?php }?>
                                                    <span class="output">
                            <?php echo number_format(kurhesapla($varsayilankur['deger'],$secilikur['deger'],$minPrice ), $secilikur['para_format']); ?>
                            </span>
                                                    <?php if($secilikur['simge_gosterim'] == '2' ) {?>
                                                        <?=$secilikur['sol_simge']?>
                                                    <?php }?>
                                                    <?php if($secilikur['simge_gosterim'] == '3' ) {?>
                                                        <?=$secilikur['sag_simge']?>
                                                    <?php }?>
                                                </div>
                                                <div class="price-wrap-outputbox" style="margin-right: 0;">
                                                    <?php if($secilikur['simge_gosterim'] == '0' ) {?>
                                                        <?=$secilikur['sol_simge']?>
                                                    <?php }?>
                                                    <?php if($secilikur['simge_gosterim'] == '1' ) {?>
                                                        <?=$secilikur['sag_simge']?>
                                                    <?php }?>
                                                    <span class="output2">
                             <?php echo number_format(kurhesapla($varsayilankur['deger'],$secilikur['deger'],$maxPrice ), $secilikur['para_format']); ?>
                            </span>
                                                    <?php if($secilikur['simge_gosterim'] == '2' ) {?>
                                                        <?=$secilikur['sol_simge']?>
                                                    <?php }?>
                                                    <?php if($secilikur['simge_gosterim'] == '3' ) {?>
                                                        <?=$secilikur['sag_simge']?>
                                                    <?php }?>
                                                </div>
                                            </div>
                                            <div class="price-filter-range-button">
                                                <?php if(isset($_GET['max']) && isset($_GET['min'])  ) {?>
                                                    <button class="<?=$islemayar['fiyat_range_button']?> button-1x" style="width: 100%;  " id="submit" onclick="javascript:window.location='<?=$browser_link?><?php if(!isset($_GET['s'])) { ?>?s=1<?php }else{?>?<?php } ?><?=$PriceFilterParselMain?>&max='+document.getElementById('upper').value+'&min='+document.getElementById('lower').value"><?=$diller['kategori-detay-text26']?></button>
                                                <?php }else { ?>
                                                    <button class="<?=$islemayar['fiyat_range_button']?> button-1x" style="width: 100%; " id="submit" onclick="javascript:window.location='<?=$browser_link?><?php if(!isset($_GET['s'])) { ?>?s=1<?php }else{?>?<?php } ?><?=$PriceFilterParselMain?>&max='+document.getElementById('upper').value+'&min='+document.getElementById('lower').value"><?=$diller['kategori-detay-text26']?></button>
                                                <?php }?>
                                            </div>
                                        </fieldset>

                                    </div>

                                </div>
                                <!-- Fiyat Aralığı !-->
                                <script>
                                    var lowerSlider = document.querySelector('#lower');
                                    var upperSlider = document.querySelector('#upper');

                                    document.querySelector('#two').value = upperSlider.value;
                                    document.querySelector('#one').value = lowerSlider.value;

                                    var lowerVal = parseInt(lowerSlider.value);
                                    var upperVal = parseInt(upperSlider.value);


                                    /* Lover için span ///////////////////////////////////////////*/
                                    var input  = document.querySelector("[id=\"lower\"]"),
                                        output = document.querySelector(".output");

                                    function keydownHandler() {
                                        output.innerHTML = this.value;
                                    }
                                    input.addEventListener("input", keydownHandler);
                                    /* Lover için span SON ///////////////////////////////////////////*/


                                    /* upper için span ///////////////////////////////////////////*/
                                    var input2  = document.querySelector("[id=\"upper\"]"),
                                        output2 = document.querySelector(".output2");

                                    function keydownHandler2() {
                                        output2.innerHTML = this.value;
                                    }
                                    input2.addEventListener("input", keydownHandler2);
                                    /* upper için span SON ///////////////////////////////////////////*/


                                    upperSlider.oninput = function () {
                                        lowerVal = parseInt(lowerSlider.value);
                                        upperVal = parseInt(upperSlider.value);

                                        if (upperVal < lowerVal + 4) {
                                            lowerSlider.value = upperVal - 4;
                                            if (lowerVal == lowerSlider.min) {
                                                upperSlider.value = 4;
                                            }
                                        }
                                        document.querySelector('#two').value = this.value;
                                    };

                                    lowerSlider.oninput = function () {
                                        lowerVal = parseInt(lowerSlider.value);
                                        upperVal = parseInt(upperSlider.value);
                                        if (lowerVal > upperVal - 4) {
                                            upperSlider.value = lowerVal + 4;
                                            if (upperVal == upperSlider.max) {
                                                lowerSlider.value = parseInt(upperSlider.max) - 4;
                                            }
                                        }
                                        document.querySelector('#one').value = this.value;
                                    };

                                </script>
                                <!--  <========SON=========>>> Fiyat Aralığı SON !-->
                            <?php }?>
                        <?php }?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(function () {
            $('#subcatAccordion').on('shown.bs.collapse', function (e) {
                $('html,body').animate({
                        scrollTop: $('#subcatAccordion').offset().top - 80 },
                    500);
            });
            $('#filterAccordion').on('shown.bs.collapse', function (e) {
                $('html,body').animate({
                        scrollTop: $('#filterAccordion').offset().top - 80 },
                    500);
            });
        });
    </script>
    <!--  <========SON=========>>> Mobile Nav Bar SON !-->
<?php }else { ?>
    <div class="detail-none">
        <div class="cat-left-main">
            <?php
            $MarkaUrunleriLeftBar = $db->prepare("select * from urun where dil=:dil and durum=:durum and marka=:marka group by iliskili_kat");
            $MarkaUrunleriLeftBar->execute(array(
                'dil' => $_SESSION['dil'],
                'durum' => '1',
                'marka' => $markaMain['id']
            ));
            ?>
            <?php if($MarkaUrunleriLeftBar->rowCount()>'0'  ) {?>
                <!-- ALt Kategorisi Varsa !-->
                <div class="cat-left-box-main">
                    <div class="cat-left-box-h">
                        <?=$diller['kategori-detay-text39']?>
                        <div style="width: 30px; height: 3px; background-color: #<?= $islemayar['sol_nav_ayirac'] ?>; margin-top: 7px;  "></div>
                    </div>
                    <?php foreach ($MarkaUrunleriLeftBar as $altkategori) {
                        $kategoriCek = $db->prepare("select * from urun_cat where id=:id");
                        $kategoriCek->execute(array(
                            'id' => $altkategori['iliskili_kat'],
                        ));
                        $katName = $kategoriCek->fetch(PDO::FETCH_ASSOC);
                        ?>
                        <div class="category-sub-design-box">
                            <li <?php if(isset($_GET['category']) && $_GET['category'] == $katName['id'] ) {?>class="category-sub-design-box-active"<?php } ?> >
                                <?php if(isset($_GET['category']) && $_GET['category'] == $katName['id'] ) {?>
                                <a href="<?=$browser_link?>?<?=$kategoriParseli?>"  <?php if(isset($_GET['category']) && $_GET['category'] == $katName['id'] ) {?>style="color: #<?=$islemayar['altkat_box_text_hover']?>;"<?php } ?> >
                                    <?php }else { ?>
                                    <a href="<?=$browser_link?><?php if(!isset($_GET['s'])) { ?>?s=1<?php }else{?>?<?php } ?><?=$kategoriParseli?>&category=<?=$katName['id']?>" >
                                        <?php }?>
                                        <?php if($katName['icon'] == !null ) {?>
                                            <i class="<?=$katName['icon']?>"></i>
                                        <?php }?>
                                        <?=$katName['baslik']?>
                                    </a>
                            </li>
                        </div>

                    <?php }?>


                </div>
                <!--  <========SON=========>>> ALt Kategorisi Varsa SON !-->
            <?php }?>

            <?php if ($islemayar['filtre_bedavakargo'] == '1' || $islemayar['filtre_yeniler'] == '1' || $islemayar['filtre_firsatlar'] == '1' || $islemayar['filtre_indirimler'] == '1' || $islemayar['filtre_taksitler'] == '1' || $islemayar['filtre_hizlikargo'] == '1') { ?>
                <div class="cat-left-box-main">
                    <div class="cat-left-box-h">
                        <?=$diller['kategori-detay-text1']?>
                        <div style="width: 30px; height: 3px; background-color: #<?= $islemayar['sol_nav_ayirac'] ?>; margin-top: 7px;  "></div>
                    </div>

                    <div class="cat-left-box-out-first" id="cat-left-overflow">
                        <?php if ($islemayar['filtre_bedavakargo'] == '1') { ?>
                            <div class="cat-left-box-t">
                                <div class="custom-control custom-checkbox">
                                    <?php if($_GET['uk'] == '1'  ) {?>
                                        <input type="checkbox" class="custom-control-input" id="uk" onclick="javascript:window.location='<?=$browser_link?>?<?=$ukParselMain?>'" checked >
                                    <?php }?>
                                    <?php if($_GET['uk'] == '0' || !isset($_GET['uk'])    ) {?>
                                        <input type="checkbox" class="custom-control-input" id="uk" onclick="javascript:window.location='<?=$browser_link?><?php if(!isset($_GET['s'])) { ?>?s=1<?php }else{?>?<?php } ?><?=$ukParselMain?>&uk=1'" >
                                    <?php }?>
                                    <label class="custom-control-label" for="uk"><?=$diller['kategori-detay-text2']?></label>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if ($islemayar['filtre_yeniler'] == '1') { ?>
                            <div class="cat-left-box-t">
                                <div class="custom-control custom-checkbox">
                                    <?php if($_GET['new'] == '1'  ) {?>
                                        <input type="checkbox" class="custom-control-input" id="new" onclick="javascript:window.location='<?=$browser_link?>?<?=$npParselMain?>'" checked >
                                    <?php }?>
                                    <?php if($_GET['new'] == '0' || !isset($_GET['new'])    ) {?>
                                        <input type="checkbox" class="custom-control-input" id="new" onclick="javascript:window.location='<?=$browser_link?><?php if(!isset($_GET['s'])) { ?>?s=1<?php }else{?>?<?php } ?><?=$npParselMain?>&new=1'" >
                                    <?php }?>
                                    <label class="custom-control-label" for="new"><?=$diller['kategori-detay-text3']?></label>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if ($islemayar['filtre_firsatlar'] == '1') { ?>
                            <div class="cat-left-box-t">
                                <div class="custom-control custom-checkbox">
                                    <?php if($_GET['firsat'] == '1'  ) {?>
                                        <input type="checkbox" class="custom-control-input" id="firsat" onclick="javascript:window.location='<?=$browser_link?>?<?=$opParselMain?>'" checked >
                                    <?php }?>
                                    <?php if($_GET['firsat'] == '0' || !isset($_GET['op'])    ) {?>
                                        <input type="checkbox" class="custom-control-input" id="firsat" onclick="javascript:window.location='<?=$browser_link?><?php if(!isset($_GET['s'])) { ?>?s=1<?php }else{?>?<?php } ?><?=$opParselMain?>&firsat=1'" >
                                    <?php }?>
                                    <label class="custom-control-label" for="firsat"><?=$diller['kategori-detay-text4']?></label>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if ($islemayar['filtre_indirimler'] == '1') { ?>
                            <div class="cat-left-box-t">
                                <div class="custom-control custom-checkbox">
                                    <?php if($_GET['indirim'] == '1'  ) {?>
                                        <input type="checkbox" class="custom-control-input" id="indirim" onclick="javascript:window.location='<?=$browser_link?>?<?=$indirimParselMain?>'" checked >
                                    <?php }?>
                                    <?php if($_GET['indirim'] == '0' || !isset($_GET['indirim'])    ) {?>
                                        <input type="checkbox" class="custom-control-input" id="indirim" onclick="javascript:window.location='<?=$browser_link?><?php if(!isset($_GET['s'])) { ?>?s=1<?php }else{?>?<?php } ?><?=$indirimParselMain?>&indirim=1'" >
                                    <?php }?>
                                    <label class="custom-control-label" for="indirim"><?=$diller['kategori-detay-text5']?></label>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if ($islemayar['filtre_taksitler'] == '1') { ?>
                            <div class="cat-left-box-t">
                                <div class="custom-control custom-checkbox">
                                    <?php if($_GET['taksit'] == '1'  ) {?>
                                        <input type="checkbox" class="custom-control-input" id="taksit" onclick="javascript:window.location='<?=$browser_link?>?<?=$taksitParselMain?>'" checked >
                                    <?php }?>
                                    <?php if($_GET['taksit'] == '0' || !isset($_GET['taksit'])    ) {?>
                                        <input type="checkbox" class="custom-control-input" id="taksit" onclick="javascript:window.location='<?=$browser_link?><?php if(!isset($_GET['s'])) { ?>?s=1<?php }else{?>?<?php } ?><?=$taksitParselMain?>&taksit=1'" >
                                    <?php }?>
                                    <label class="custom-control-label" for="taksit"><?=$diller['kategori-detay-text6']?></label>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if ($islemayar['filtre_hizlikargo'] == '1') { ?>
                            <div class="cat-left-box-t">
                                <div class="custom-control custom-checkbox">
                                    <?php if($_GET['hizlikargo'] == '1'  ) {?>
                                        <input type="checkbox" class="custom-control-input" id="hizlikargo" onclick="javascript:window.location='<?=$browser_link?>?<?=$hkParselMain?>'" checked >
                                    <?php }?>
                                    <?php if($_GET['hizlikargo'] == '0' || !isset($_GET['hizlikargo'])    ) {?>
                                        <input type="checkbox" class="custom-control-input" id="hizlikargo" onclick="javascript:window.location='<?=$browser_link?><?php if(!isset($_GET['s'])) { ?>?s=1<?php }else{?>?<?php } ?><?=$hkParselMain?>&hizlikargo=1'" >
                                    <?php }?>
                                    <label class="custom-control-label" for="hizlikargo"><?=$diller['kategori-detay-text7']?></label>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if ($islemayar['filtre_editor'] == '1') { ?>
                            <div class="cat-left-box-t">
                                <div class="custom-control custom-checkbox">
                                    <?php if($_GET['editor'] == '1'  ) {?>
                                        <input type="checkbox" class="custom-control-input" id="editorsecimi" onclick="javascript:window.location='<?=$browser_link?>?<?=$editorParselMain?>'" checked >
                                    <?php }?>
                                    <?php if($_GET['editor'] == '0' || !isset($_GET['editor'])    ) {?>
                                        <input type="checkbox" class="custom-control-input" id="editorsecimi" onclick="javascript:window.location='<?=$browser_link?><?php if(!isset($_GET['s'])) { ?>?s=1<?php }else{?>?<?php } ?><?=$editorParselMain?>&editor=1'" >
                                    <?php }?>
                                    <label class="custom-control-label" for="editorsecimi"><?=$diller['kategori-detay-text38']?></label>
                                </div>
                            </div>
                        <?php } ?>
                    </div>

                </div>
            <?php } ?>

            <?php if($varsayilankur['kod'] == $secilikur['kod'] ) {?>
                <?php if($maxPrice > '0' && $minPrice >= '0'  ) {?>
                    <div class="cat-left-box-main">
                        <div class="cat-left-box-h">
                            <?=$diller['kategori-detay-text25']?>
                            <div style="width: 30px; height: 3px; background-color: #<?= $islemayar['sol_nav_ayirac'] ?>; margin-top: 7px;  "></div>
                        </div>
                        <div class="cat-left-box-out-first"  >

                            <fieldset class="filter-price">
                                <div class="price-field">
                                    <?php
                                    $minPrice1 = number_format(kurhesapla($varsayilankur['deger'],$secilikur['deger'],$minPrice ), $secilikur['para_format']);
                                    $maxPrice2 = number_format(kurhesapla($varsayilankur['deger'],$secilikur['deger'],$maxPrice ), $secilikur['para_format']);
                                    ?>
                                    <input type="range" min="<?=$minPrice?>" max="<?=$maxPrice?>" value="<?=$minPrice?>" id="lower" name="min">
                                    <input  type="range" min="<?=$minPrice?>" max="<?=$maxPrice?>" value="<?=$maxPrice?>" id="upper" name="max">
                                </div>

                                <div class="price-wrap">
                                    <input id="one" type="hidden" >
                                    <input id="two" type="hidden" >
                                    <div class="price-wrap-outputbox">
                                        <?php if($secilikur['simge_gosterim'] == '0' ) {?>
                                            <?=$secilikur['sol_simge']?>
                                        <?php }?>
                                        <?php if($secilikur['simge_gosterim'] == '1' ) {?>
                                            <?=$secilikur['sag_simge']?>
                                        <?php }?>
                                        <span class="output">
                            <?php echo number_format(kurhesapla($varsayilankur['deger'],$secilikur['deger'],$minPrice ), $secilikur['para_format']); ?>
                            </span>
                                        <?php if($secilikur['simge_gosterim'] == '2' ) {?>
                                            <?=$secilikur['sol_simge']?>
                                        <?php }?>
                                        <?php if($secilikur['simge_gosterim'] == '3' ) {?>
                                            <?=$secilikur['sag_simge']?>
                                        <?php }?>
                                    </div>
                                    <div class="price-wrap-outputbox" style="margin-right: 0;">
                                        <?php if($secilikur['simge_gosterim'] == '0' ) {?>
                                            <?=$secilikur['sol_simge']?>
                                        <?php }?>
                                        <?php if($secilikur['simge_gosterim'] == '1' ) {?>
                                            <?=$secilikur['sag_simge']?>
                                        <?php }?>
                                        <span class="output2">
                             <?php echo number_format(kurhesapla($varsayilankur['deger'],$secilikur['deger'],$maxPrice ), $secilikur['para_format']); ?>
                            </span>
                                        <?php if($secilikur['simge_gosterim'] == '2' ) {?>
                                            <?=$secilikur['sol_simge']?>
                                        <?php }?>
                                        <?php if($secilikur['simge_gosterim'] == '3' ) {?>
                                            <?=$secilikur['sag_simge']?>
                                        <?php }?>
                                    </div>
                                </div>
                                <div class="price-filter-range-button">
                                    <?php if(isset($_GET['max']) && isset($_GET['min'])  ) {?>
                                        <button class="<?=$islemayar['fiyat_range_button']?> button-1x" style="width: 100%;  " id="submit" onclick="javascript:window.location='<?=$browser_link?><?php if(!isset($_GET['s'])) { ?>?s=1<?php }else{?>?<?php } ?><?=$PriceFilterParselMain?>&max='+document.getElementById('upper').value+'&min='+document.getElementById('lower').value"><?=$diller['kategori-detay-text26']?></button>
                                    <?php }else { ?>
                                        <button class="<?=$islemayar['fiyat_range_button']?> button-1x" style="width: 100%; " id="submit" onclick="javascript:window.location='<?=$browser_link?><?php if(!isset($_GET['s'])) { ?>?s=1<?php }else{?>?<?php } ?><?=$PriceFilterParselMain?>&max='+document.getElementById('upper').value+'&min='+document.getElementById('lower').value"><?=$diller['kategori-detay-text26']?></button>
                                    <?php }?>
                                </div>
                            </fieldset>

                        </div>

                    </div>
                    <!-- Fiyat Aralığı !-->
                    <script>
                        var lowerSlider = document.querySelector('#lower');
                        var upperSlider = document.querySelector('#upper');

                        document.querySelector('#two').value = upperSlider.value;
                        document.querySelector('#one').value = lowerSlider.value;

                        var lowerVal = parseInt(lowerSlider.value);
                        var upperVal = parseInt(upperSlider.value);


                        /* Lover için span ///////////////////////////////////////////*/
                        var input  = document.querySelector("[id=\"lower\"]"),
                            output = document.querySelector(".output");

                        function keydownHandler() {
                            output.innerHTML = this.value;
                        }
                        input.addEventListener("input", keydownHandler);
                        /* Lover için span SON ///////////////////////////////////////////*/


                        /* upper için span ///////////////////////////////////////////*/
                        var input2  = document.querySelector("[id=\"upper\"]"),
                            output2 = document.querySelector(".output2");

                        function keydownHandler2() {
                            output2.innerHTML = this.value;
                        }
                        input2.addEventListener("input", keydownHandler2);
                        /* upper için span SON ///////////////////////////////////////////*/


                        upperSlider.oninput = function () {
                            lowerVal = parseInt(lowerSlider.value);
                            upperVal = parseInt(upperSlider.value);

                            if (upperVal < lowerVal + 4) {
                                lowerSlider.value = upperVal - 4;
                                if (lowerVal == lowerSlider.min) {
                                    upperSlider.value = 4;
                                }
                            }
                            document.querySelector('#two').value = this.value;
                        };

                        lowerSlider.oninput = function () {
                            lowerVal = parseInt(lowerSlider.value);
                            upperVal = parseInt(upperSlider.value);
                            if (lowerVal > upperVal - 4) {
                                upperSlider.value = lowerVal + 4;
                                if (upperVal == upperSlider.max) {
                                    lowerSlider.value = parseInt(upperSlider.max) - 4;
                                }
                            }
                            document.querySelector('#one').value = this.value;
                        };

                    </script>
                    <!--  <========SON=========>>> Fiyat Aralığı SON !-->
                <?php }?>
            <?php }?>

        </div>
    </div>
<?php }?>


