<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
//todo ioncube
if(isset($_GET['cID'])) {
$removeSorgu = $db->prepare("select * from sepet_kupon where random_id=:random_id and uye_id=:uye_id and durum=:durum and kullanim=:kullanim  ");
$removeSorgu->execute(array(
    'random_id' => htmlspecialchars(trim($_GET['cID'])),
    'uye_id' => $userCek['id'],
    'durum' => '1',
    'kullanim' => '0'
));
?>
<?php if($removeSorgu->rowCount() > '0'  ) {?>
    <?php
        /* Kuponların stok sayısını 1 artır */
        $kuponSorgu = $db->prepare("select * from kupon where random=:random ");
        $kuponSorgu->execute(array(
            'random' => $_GET['cID']
        ));
        $kuponRow = $kuponSorgu->fetch(PDO::FETCH_ASSOC);
        if($kuponSorgu->rowCount()>'0'  ) {
                $guncelle = $db->prepare("UPDATE kupon SET
                       adet=:adet     
                     WHERE random={$_GET['cID']}      
                    ");
                $sonuc = $guncelle->execute(array(
                    'adet' => $kuponRow['adet']+1
                ));
        }
        /*  <========SON=========>>> Kuponların stok sayısını 1 artır SON */

        $silmeislem = $db->prepare("DELETE from sepet_kupon WHERE random_id=:random_id");
        $silmeislem = $silmeislem->execute(array(
           'random_id' => htmlspecialchars(trim($_GET['cID']))
        ));
        if ($silmeislem) {
            header('Location:'.$siteurl.'sepet/');
            $_SESSION['kupon_sil'] ='success';
        }else {
            header('Location:'.$siteurl.'404');
        }
    ?>
<?php }else { ?>
<?php
header('Location:'.$siteurl.'404');
?>
<?php }
}else{
    header('Location:'.$siteurl.'404');
}?>
