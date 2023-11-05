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


    $uyeOzel = $db->prepare("select * from bildirimler where id < ".$_POST['id']." and dil=:dil and durum=:durum and tur=:tur and uye_id=:uye_id order by id DESC limit $showLimit");
    $uyeOzel->execute(array(
        'dil' => $_SESSION['dil'],
        'durum' => '1',
        'tur' => '2',
        'uye_id' => $userCek['id']
    ));
    $uyeOzelCount = $db->prepare("select * from bildirimler where id < ".$_POST['id']." and dil=:dil and durum=:durum and tur=:tur and uye_id=:uye_id order by id ");
    $uyeOzelCount->execute(array(
        'dil' => $_SESSION['dil'],
        'durum' => '1',
        'tur' => '2',
        'uye_id' => $userCek['id']
    ));
    $totalRowCount = $uyeOzelCount->rowCount();
    ?>
    <?php foreach ($uyeOzel as $ozeluye ) {
        $ozelID = 	$ozeluye['id'];
        ?>
        <div class="bildirimler-box">
            <div class="bildirimler-box-baslik">
                <?php if($ozeluye['ikon'] == !null ) {?>
                    <div style="width: 30px;"><?=$ozeluye['ikon']?></div>
                <?php }else { ?>
                    <div style="width: 30px;"><i class="fa fa-arrow-right"></i></div>
                <?php }?>
                <a href="bildirim/<?=seo($ozeluye['baslik'])?>-B<?=$ozeluye['bildirim_id']?>">
                    <?=$ozeluye['baslik']?>
                </a>
            </div>
            <div class="bildirimler-box-tarih">
                <i class="las la-clock"></i> <?php echo date_tr('j F Y', ''.$ozeluye['tarih'].''); ?>
            </div>
            <div class="bildirimler-box-read">
                <?php
                if($ozeluye['tur'] == '2' ) {
                    $bildirim_ipSorgu = $db->prepare("select * from bildirimler_ip where bildirim_id=:bildirim_id and uye_id=:uye_id ");
                    $bildirim_ipSorgu->execute(array(
                        'bildirim_id' => $ozeluye['bildirim_id'],
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
        <div class="ozelbildirim-show-more-button " id="ozelbildirim-show-more-button<?php echo $ozelID; ?>">
            <span id="<?php echo $ozelID; ?>"  class="ozelbildirim-showmorespan button-white-black button-2x" >+ <?=$diller['bildirimler-text11']?></span>
            <span class="ozelbildirim_loding" style="display: none;"><span class="ozelbildirim_loding_txt"><?=$diller['bildirimler-text12']?></span></span>
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