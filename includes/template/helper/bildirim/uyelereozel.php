<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<?php
$settings=$db->prepare("SELECT * from ayarlar where id='1'");
$settings->execute(array(0));
$ayar=$settings->fetch(PDO::FETCH_ASSOC);
$siteurl = $ayar['site_url'];
$userSorgusu = $db->prepare("select * from uyeler where eposta=:eposta order by id");
$userSorgusu->execute(array(
    'eposta' => $_SESSION['user_email_address']
));
$userCek = $userSorgusu->fetch(PDO::FETCH_ASSOC);

if(!empty($_POST["id"])){

    $showLimit = '5';



    $uyelereOzel = $db->prepare("select * from bildirimler where id < ".$_POST['id']." and dil=:dil and durum=:durum and tur=:tur order by id DESC limit $showLimit");
    $uyelereOzel->execute(array(
        'dil' => $_SESSION['dil'],
        'durum' => '1',
        'tur' => '1'
    ));
    $uyelereOzelCount = $db->prepare("select * from bildirimler where id < ".$_POST['id']." and dil=:dil and durum=:durum and tur=:tur order by id DESC ");
    $uyelereOzelCount->execute(array(
        'dil' => $_SESSION['dil'],
        'durum' => '1',
        'tur' => '1'
    ));


    $totalRowCount = $uyelereOzelCount->rowCount();
    ?>
    <?php foreach ($uyelereOzel as $uyelerRow ) {
        $uyelerID = 	$uyelerRow['id'];
        ?>
        <div class="bildirimler-box">
            <div class="bildirimler-box-baslik">
                <?php if($uyelerRow['ikon'] == !null ) {?>
                    <div style="width: 30px;"><?=$uyelerRow['ikon']?></div>
                <?php }else { ?>
                    <div style="width: 30px;"><i class="fa fa-arrow-right"></i></div>
                <?php }?>
                <a href="bildirim/<?=seo($uyelerRow['baslik'])?>-B<?=$uyelerRow['bildirim_id']?>">
                    <?=$uyelerRow['baslik']?>
                </a>
            </div>
            <div class="bildirimler-box-tarih">
                <i class="las la-clock"></i> <?php echo date_tr('j F Y', ''.$uyelerRow['tarih'].''); ?>
            </div>
            <div class="bildirimler-box-read">
                <?php if($uyelerRow['tur'] == '1' ) {
                    $bildirim_ipSorgu = $db->prepare("select * from bildirimler_ip where bildirim_id=:bildirim_id and uye_id=:uye_id ");
                    $bildirim_ipSorgu->execute(array(
                        'bildirim_id' => $uyelerRow['bildirim_id'],
                        'uye_id' => $userCek['id']
                    ));
                    if($bildirim_ipSorgu->rowCount()<='0'  ) { ?>
                        <span style="color: dodgerblue; font-weight: 600;"><i class="fa fa-spinner fa-spin fa-fw"></i> <?=$diller['bildirimler-text7']?></span>
                    <?php } else { ?>
                        <span style="color: black;"><i class="las la-check"></i> <?=$diller['bildirimler-text6']?></span>
                    <?php }} ?>
            </div>
        </div>
    <?php }?>

        <?php if($totalRowCount > $showLimit){ ?>
        <div class="uyelerebildirim-show-more-button " id="uyelerebildirim-show-more-button<?php echo $uyelerID; ?>">
            <span id="<?php echo $uyelerID; ?>"  class="uyelerebildirim-showmorespan button-white-black button-2x" >+ <?=$diller['bildirimler-text11']?></span>
            <span class="uyelerebildirim_loding" style="display: none;"><span class="uyelerebildirim_loding_txt"><?=$diller['bildirimler-text12']?></span></span>
        </div>
        <?php }else { ?>
            <div class="button-grey button-2x" style="width: 100%; text-align: center;  ">
                <?=$diller['bildirimler-text13']?>
            </div>
        <?php }?>


<?php
}else{
    header('Location:'.$siteurl.'404');
}
?>