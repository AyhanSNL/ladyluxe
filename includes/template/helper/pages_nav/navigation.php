<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
$navCek = $db->prepare("select * from navigasyon where dil=:dil and durum=:durum and ust_id=:ust_id order by sira asc ");
$navCek->execute(array(
    'dil' => $_SESSION['dil'],
    'durum' => '1',
    'ust_id' => '0'
));
$navCek2 = $db->prepare("select * from navigasyon where dil=:dil and durum=:durum and ust_id=:ust_id order by sira asc ");
$navCek2->execute(array(
    'dil' => $_SESSION['dil'],
    'durum' => '1',
    'ust_id' => '0'
));
?>
<!-- Mobile Nav Bar !-->
<div class="mb-3 w-100 subpage-nav-mobile-main">
    <a class="subpage-nav-mobile-toggle  "  data-toggle="collapse" data-target="#naviAccordion" aria-expanded="false" aria-controls="collapseForm">
        + <?=$diller['diger-text-1']?>
    </a>
    <div id="accordion" class="accordion">
        <div class="collapse" id="naviAccordion" data-parent="#accordion">
            <div class="subpage-mobile-nav mt-2">
                <div class="subpage_navigation" style="font-family : '<?=$ayar['nav_font']?>',Sans-serif ;">
                    <?php foreach ($navCek as $navRow) {
                        $altNavCek = $db->prepare("select * from navigasyon where dil=:dil and durum=:durum and ust_id=:ust_id order by sira asc ");
                        $altNavCek->execute(array(
                            'dil' => $_SESSION['dil'],
                            'durum' => '1',
                            'ust_id' => $navRow['id']
                        ));
                        ?>
                        <div class="subpage_navigation-box" <?php if($altNavCek->rowCount()<='0'  ) { ?>style="padding: 10px" <?php }?>>
                            <a class="subpage_navigation_header" <?php if($altNavCek->rowCount()<='0'  ) { ?><?php if($navRow['url_adres'] == !null ) { ?>href="<?=$navRow['url_adres']?>"<?php }?>style="margin-bottom: 0; border-bottom: 0; padding-bottom: 0;"<?php }?>>
                                <?php if($navRow['ikon'] == !null ) { ?><i class="<?=$navRow['ikon']?>"></i><?php }?> <?=$navRow['baslik']?>
                            </a>
                            <?php foreach ($altNavCek as $altnavRow) {?>
                                <a class="subpage_navigation_a" <?php if($altnavRow['url_adres'] == !null ) { ?>href="<?=$altnavRow['url_adres']?>" target="_blank" <?php }?>>
                                    <?php if($altnavRow['ikon'] == !null ) { ?><i class="<?=$altnavRow['ikon']?>"></i><?php }?> <?=$altnavRow['baslik']?>
                                </a>
                            <?php }?>
                        </div>
                    <?php }?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {
        $('#naviAccordion').on('shown.bs.collapse', function (e) {
            $('html,body').animate({
                    scrollTop: $('#naviAccordion').offset().top - 80 },
                500);
        });
    });
</script>
<!--  <========SON=========>>> Mobile Nav Bar SON !-->
<?php if($navCek->rowCount()>'0'  ) { ?>
    <div class="subpage-nav-desktop">
        <div class="subpage_navigation" style="font-family : '<?=$ayar['nav_font']?>',Sans-serif ;">
            <?php foreach ($navCek2 as $navRow) {
                $altNavCek = $db->prepare("select * from navigasyon where dil=:dil and durum=:durum and ust_id=:ust_id order by sira asc ");
                $altNavCek->execute(array(
                    'dil' => $_SESSION['dil'],
                    'durum' => '1',
                    'ust_id' => $navRow['id']
                ));
                ?>
                <div class="subpage_navigation-box" <?php if($altNavCek->rowCount()<='0'  ) { ?>style="padding: 10px" <?php }?>>
                    <a class="subpage_navigation_header" <?php if($altNavCek->rowCount()<='0'  ) { ?><?php if($navRow['url_adres'] == !null ) { ?>href="<?=$navRow['url_adres']?>"<?php }?>style="margin-bottom: 0; border-bottom: 0; padding-bottom: 0;"<?php }?>>
                        <?php if($navRow['ikon'] == !null ) { ?><i class="<?=$navRow['ikon']?>"></i><?php }?> <?=$navRow['baslik']?>
                    </a>
                    <?php foreach ($altNavCek as $altnavRow) {?>
                        <a class="subpage_navigation_a" <?php if($altnavRow['url_adres'] == !null ) { ?>href="<?=$altnavRow['url_adres']?>" target="_blank" <?php }?>>
                            <?php if($altnavRow['ikon'] == !null ) { ?><i class="<?=$altnavRow['ikon']?>"></i><?php }?> <?=$altnavRow['baslik']?>
                        </a>
                    <?php }?>
                </div>
            <?php }?>
        </div>
    </div>
<?php }?>
