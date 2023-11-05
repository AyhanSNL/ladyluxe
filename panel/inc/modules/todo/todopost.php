<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
if($yetki['demo'] != '1' ) {
   /* Yapılacakları Ekle */
   if($_POST && isset($_POST['todoPost'])  ) {
       $todoValue = trim(strip_tags($_POST['todo_value']));
       if($todoValue  ) {
           $timestamp = date('Y-m-d G:i:s');
           $rand = rand(0,(int) 99999999);
           $kaydet = $db->prepare("INSERT INTO panel_todo SET
                   admin_id=:admin_id,
                   tarih=:tarih,
                   baslik=:baslik,
                   random_id=:random_id,
                   durum=:durum
           ");
           $sonuc = $kaydet->execute(array(
               'admin_id' => $adminRow['id'],
               'tarih' => $timestamp,
               'baslik' => $todoValue,
               'random_id' => $rand,
               'durum' => '0'
           ));
           if($sonuc){
               $_SESSION['collepse_status'] = 'todo_list';
               header('Location:'.$ayar['panel_url'].'');
           }else{
           echo 'Veritabanı Hatası';
           }
       }else{
           header('Location:'.$ayar['panel_url'].'');
           $_SESSION['main_alert'] = 'empty';
       }
   }else{
       header('Location:'.$ayar['site_url'].'404');
   }
   /*  <========SON=========>>> Yapılacakları Ekle SON */ 
}else{
    header('Location:'.$ayar['panel_url'].'');
    $_SESSION['main_alert'] = 'demo';
}
?>