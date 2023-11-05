<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php if($_GET['bell']=='success'  ) {?>
<?php
    if($_GET['change']=='0' || $_GET['change']=='1'  ) {
        if($_GET['change']=='0'  ) {
            $guncelle = $db->prepare("UPDATE yonetici SET
                 sound=:sound
          WHERE id={$adminRow['id']}      
         ");
            $sonuc = $guncelle->execute(array(
                'sound' => '0'
            ));
            if($sonuc){
                header('Location:'.$_SESSION['current_url'] .'');
            }else{
                echo 'Veritabanı Hatası';
            }
        }
        if($_GET['change']=='1'  ) {
            $guncelle = $db->prepare("UPDATE yonetici SET
                 sound=:sound
          WHERE id={$adminRow['id']}      
         ");
            $sonuc = $guncelle->execute(array(
                'sound' => '1'
            ));
            if($sonuc){
                header('Location:'.$_SESSION['current_url'] .'');
            }else{
                echo 'Veritabanı Hatası';
            }
        }
    }else{
        header('Location:'.$ayar['panel_url'].'');
    }
?>
<?php }else { ?>
    <?php
    header('Location:'.$ayar['panel_url'].'');
    ?>
<?php }?>