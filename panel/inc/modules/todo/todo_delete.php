<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
if($yetki['demo'] != '1' ) {
    if($_GET['todo'] == 'success' && isset($_GET['todo_no'])  ) {
     $random_no = $_GET['todo_no'];
     $todoCek = $db->prepare("select * from panel_todo where random_id=:random_id and admin_id=:admin_id");
     $todoCek->execute(array(
         'random_id' => $random_no,
         'admin_id' => $adminRow['id']
     ));
     if($todoCek->rowCount()>'0'  ) {
      $silmeislem = $db->prepare("DELETE from panel_todo WHERE random_id=:random_id");
      $silmeislem->execute(array(
         'random_id' => $random_no
      ));
      if ($silmeislem) {
          $_SESSION['collepse_status'] = 'todo_list';
          header('Location:'.$ayar['panel_url'].'');
      }else {
          echo 'veritabanı hatası';
      }
     }else{
         header('Location:'.$ayar['site_url'].'404');
     }
    }else{
        header('Location:'.$ayar['site_url'].'404');
    }
}else{
    header('Location:'.$ayar['panel_url'].'');
    $_SESSION['main_alert'] = 'demo';
}
?>