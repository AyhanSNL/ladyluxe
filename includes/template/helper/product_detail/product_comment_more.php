<?php
$settings=$db->prepare("SELECT * from ayarlar where id='1'");
$settings->execute(array(0));
$ayar=$settings->fetch(PDO::FETCH_ASSOC);
$siteurl = $ayar['site_url'];

$urunDetay = $db->prepare("select * from urun_detay where id='1'");
$urunDetay->execute();
$udetayRow = $urunDetay->fetch(PDO::FETCH_ASSOC);
if(!empty($_POST["id"])){

    $UrunyorumListele = $db->prepare("select * from urun_yorum where id < ".$_POST['id']." and urun_id=:urun_id and onay=:onay order by id desc");
    $UrunyorumListele->execute(array(
        'urun_id' => $_POST['pro_id'],
        'onay' => '1'
    ));
    $totalRowCount = $UrunyorumListele->rowCount();

    $showLimit = 5;

    $UrunyorumListele = $db->prepare("select * from urun_yorum where id < ".$_POST['id']." and urun_id=:urun_id and onay=:onay order by id desc limit $showLimit");
    $UrunyorumListele->execute(array(
        'urun_id' => $_POST['pro_id'],
        'onay' => '1'
    ));

    if($UrunyorumListele->rowCount() > 0){
       foreach ($UrunyorumListele as $yor){
            $shortname = mb_substr($yor['isim'], 0, 1,'UTF-8');
            $postID = 	$yor['id'];
            $proID = $yor['urun_id'];
            ?>
            <div class="product-comment-head-content-box-out">
                <div class="product-comment-head-content-box">
                    <div class="product-comment-head-content-box-name-rad <?=$udetayRow['detay_yorum_oval_bg']?>">
                        <?=$shortname?>
                    </div>
                    <div class="product-comment-head-content-box-in">
                        <div class="product-comment-head-content-box-in-1">
                            <div class="product-comment-head-content-box-in-1-name">
                                <?php if($yor['gizli']  == 1 ) {?>
                                    <?php
                                    $gizliisim = mb_substr($yor['isim'],0,2,'UTF-8');
                                    $gizlisoyisim = mb_substr($yor['soyisim'],0,2,'UTF-8');
                                    ?>
                                    <?=$gizliisim ?>**** <?=$gizlisoyisim ?>****
                                <?php }else { ?>
                                    <?=$yor['isim']?> <?=$yor['soyisim']?>
                                <?php }?>
                            </div>
                            <div class="product-comment-head-content-box-in-1-date">
                                <?php echo date_tr('j F Y, l ', ''.$yor['tarih'].''); ?>
                            </div>
                        </div>
                        <div class="product-comment-head-content-box-in-2">
                            <?php echo trim(strip_tags($yor['baslik']))?>
                        </div>
                        <div class="product-comment-head-content-box-in-3">
                            <?php if($yor['yildiz'] == 0){ ?>
                                <span style="color:#CCC">★</span><span style="color:#CCC">★</span><span style="color:#CCC">★</span><span style="color:#CCC">★</span><span style="color:#CCC">★</span>
                            <?php }?>
                            <?php if($yor['yildiz'] == 1){ ?>
                                <span style="color:#ffb400">★</span><span style="color:#CCC">★</span><span style="color:#CCC">★</span><span style="color:#CCC">★</span><span style="color:#CCC">★</span>
                            <?php }?>
                            <?php if($yor['yildiz'] == 2){ ?>
                                <span style="color:#ffb400">★</span><span style="color:#ffb400">★</span><span style="color:#CCC">★</span><span style="color:#CCC">★</span><span style="color:#CCC">★</span>
                            <?php }?>
                            <?php if($yor['yildiz'] == 3){ ?>
                                <span style="color:#ffb400">★</span><span style="color:#ffb400">★</span><span style="color:#ffb400">★</span><span style="color:#CCC">★</span><span style="color:#CCC">★</span>
                            <?php }?>
                            <?php if($yor['yildiz'] == 4){ ?>
                                <span style="color:#ffb400">★</span><span style="color:#ffb400">★</span><span style="color:#ffb400">★</span><span style="color:#ffb400">★</span><span style="color:#CCC">★</span>
                            <?php }?>
                            <?php if($yor['yildiz'] == 5){ ?>
                                <span style="color:#ffb400">★</span><span style="color:#ffb400">★</span><span style="color:#ffb400">★</span><span style="color:#ffb400">★</span><span style="color:#ffb400">★</span>
                            <?php }?>
                        </div>
                        <div class="product-comment-head-content-box-in-4">
                            <?php echo trim(strip_tags($yor['yorum']))?>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
        <?php if($totalRowCount > $showLimit){ ?>
            <div class="urundetay-show-more-button" id="urundetay-show-more-button<?php echo $postID; ?>">
                <span id="<?php echo $postID; ?>" data-id="<?=$proID?>" class="urundetay-showmorespan <?=$udetayRow['detay_more_comment_button']?>" >+ <?=$diller['urun-detay-daha-fazla-yorum-goster']?></span>
                <span class="urundetay_loding" style="display: none;"><span class="urundetay_loding_txt"><?=$diller['modul-tum-yorumlar-wait']?></span></span>
            </div>
        <?php }else { ?>
            <div class="<?=$udetayRow['detay_more_comment_button']?> button-2x" style="width: 100%; text-align: center;  ">
                <?=$diller['urun-detay-daha-fazla-yorum-bitis']?>
            </div>
        <?php }?>
        <?php
    }
}else{
    header('Location:'.$siteurl.'404');
}
?>