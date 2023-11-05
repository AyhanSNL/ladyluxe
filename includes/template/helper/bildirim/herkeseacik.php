<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<?php
$settings=$db->prepare("SELECT * from ayarlar where id='1'");
$settings->execute(array(0));
$ayar=$settings->fetch(PDO::FETCH_ASSOC);
$siteurl = $ayar['site_url'];


if(!empty($_POST["id"])){

    $showLimit = '5';

    $herkeseAcik = $db->prepare("select * from bildirimler where id < ".$_POST['id']." and dil=:dil and durum=:durum and tur=:tur order by id DESC limit $showLimit");
    $herkeseAcik->execute(array(
        'dil' => $_SESSION['dil'],
        'durum' => '1',
        'tur' => '0'
    ));
    $herkeseAcikCount = $db->prepare("select * from bildirimler where id < ".$_POST['id']." and dil=:dil and durum=:durum and tur=:tur order by id DESC ");
    $herkeseAcikCount->execute(array(
        'dil' => $_SESSION['dil'],
        'durum' => '1',
        'tur' => '0'
    ));
    $totalRowCount = $herkeseAcikCount->rowCount();
    ?>

    <?php foreach ($herkeseAcik as $herkes ) {
        $herkeseID = 	$herkes['id'];
        ?>
        <div class="bildirimler-box">
            <div class="bildirimler-box-baslik">
                <?php if($herkes['ikon'] == !null ) {?>
                    <div style="width: 30px;"><?=$herkes['ikon']?></div>
                <?php }else { ?>
                    <div style="width: 30px;"><i class="fa fa-arrow-right"></i></div>
                <?php }?>
                <a href="bildirim/<?=seo($herkes['baslik'])?>-B<?=$herkes['bildirim_id']?>">
                    <?=$herkes['baslik']?>
                </a>
            </div>
            <div class="bildirimler-box-tarih">
                <i class="las la-clock"></i> <?php echo date_tr('j F Y', ''.$herkes['tarih'].''); ?>
            </div>
            <div class="bildirimler-box-read">
                <?php if($herkes['tur'] == '0' ) {
                    $ip = $_SERVER["REMOTE_ADDR"];
                    $bildirim_ipSorgu = $db->prepare("select * from bildirimler_ip where bildirim_id=:bildirim_id and ip_adres=:ip_adres ");
                    $bildirim_ipSorgu->execute(array(
                        'bildirim_id' => $herkes['bildirim_id'],
                        'ip_adres' => $ip
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
        <div class="herkesebildirim-show-more-button " id="herkesebildirim-show-more-button<?php echo $herkeseID; ?>">
            <span id="<?php echo $herkeseID; ?>"  class="herkesebildirim-showmorespan button-white-black button-2x" >+ <?=$diller['bildirimler-text11']?></span>
            <span class="herkesebildirim_loding" style="display: none;"><span class="herkesebildirim_loding_txt"><?=$diller['bildirimler-text12']?></span></span>
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