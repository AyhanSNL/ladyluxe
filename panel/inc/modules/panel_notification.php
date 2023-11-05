<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
if($yetki['demo'] != '1' ) {
    if (isset($_GET['noti_id'])) {
        if ($_GET['noti_id'] == !null && $_GET['noti_id']>'0' && isset($_GET['noti_id'])  ) {

              $notiCek = $db->prepare("select * from panel_bildirim where id=:id ");
              $notiCek->execute(array(
                  'id' => $_GET['noti_id']
              ));

              if($notiCek->rowCount()>'0'  ) {
                  $not = $notiCek->fetch(PDO::FETCH_ASSOC);

                  if($not['modul'] == 'destek'  ) {
                      if($yetki['uyelik'] == '1' && $yetki['ticket'] == '1') {
                        $guncelle = $db->prepare("UPDATE panel_bildirim SET
                              durum=:durum  
                         WHERE id={$_GET['noti_id']}      
                        ");
                        $sonuc = $guncelle->execute(array(
                            'durum' => '0'
                        ));
                        if($sonuc){
                            header('Location:'.$ayar['panel_url'].'pages.php?page=ticket_detail&ticketID='.$not['icerik_id'].'');
                        }else{
                        echo 'Veritabanı Hatası';
                        }
                      }else{
                          header('Location:'.$_SESSION['current_url'] .'');
                          exit();
                      }
                  }


                  if($not['modul'] == 'siparis'  ) {
                      if($yetki['siparis'] == '1'&& $yetki['siparis_yonet'] == '1') {
                          $guncelle = $db->prepare("UPDATE panel_bildirim SET
                              durum=:durum  
                         WHERE id={$_GET['noti_id']}      
                        ");
                          $sonuc = $guncelle->execute(array(
                              'durum' => '0'
                          ));
                          if($sonuc){
                              header('Location:'.$ayar['panel_url'].'pages.php?page=order_detail&orderID='.$not['icerik_id'].'');
                          }else{
                              echo 'Veritabanı Hatası';
                          }
                      }else{
                          header('Location:'.$_SESSION['current_url'] .'');
                          exit();
                      }
                  }

                  if($not['modul'] == 'odemebildirim'  ) {
                      if($yetki['siparis'] == '1' && $yetki['odeme_bildirim'] == '1') {
                          $guncelle = $db->prepare("UPDATE panel_bildirim SET
                              durum=:durum  
                         WHERE id={$_GET['noti_id']}      
                        ");
                          $sonuc = $guncelle->execute(array(
                              'durum' => '0'
                          ));
                          if($sonuc){
                              header('Location:'.$ayar['panel_url'].'pages.php?page=transfer_detail&transferID='.$not['icerik_id'].'');
                          }else{
                              echo 'Veritabanı Hatası';
                          }
                      }else{
                          header('Location:'.$_SESSION['current_url'] .'');
                          exit();
                      }
                  }

                  if($not['modul'] == 'urunyorum'  ) {
                      if($yetki['katalog'] == '1' && $yetki['urun_yorum'] == '1') {
                          $guncelle = $db->prepare("UPDATE panel_bildirim SET
                              durum=:durum  
                         WHERE id={$_GET['noti_id']}      
                        ");
                          $sonuc = $guncelle->execute(array(
                              'durum' => '0'
                          ));
                          if($sonuc){
                              header('Location:'.$ayar['panel_url'].'pages.php?page=products_comments');
                          }else{
                              echo 'Veritabanı Hatası';
                          }
                      }else{
                          header('Location:'.$_SESSION['current_url'] .'');
                          exit();
                      }
                  }

                  if($not['modul'] == 'siparisiptal'  ) {
                      if($yetki['siparis_yonet'] == '1' && $yetki['siparis'] == '1') {
                          $guncelle = $db->prepare("UPDATE panel_bildirim SET
                              durum=:durum  
                         WHERE id={$_GET['noti_id']}      
                        ");
                          $sonuc = $guncelle->execute(array(
                              'durum' => '0'
                          ));
                          if($sonuc){
                              header('Location:'.$ayar['panel_url'].'pages.php?page=order_detail&orderID='.$not['icerik_id'].'');
                          }else{
                              echo 'Veritabanı Hatası';
                          }
                      }else{
                          header('Location:'.$_SESSION['current_url'] .'');
                          exit();
                      }
                  }

                  if($not['modul'] == 'uruniade'  ) {
                      if($yetki['siparis_yonet'] == '1' && $yetki['siparis'] == '1') {
                          $guncelle = $db->prepare("UPDATE panel_bildirim SET
                              durum=:durum  
                         WHERE id={$_GET['noti_id']}      
                        ");
                          $sonuc = $guncelle->execute(array(
                              'durum' => '0'
                          ));
                          if($sonuc){
                              header('Location:'.$ayar['panel_url'].'pages.php?page=product_return&no='.$not['icerik_id'].'');
                          }else{
                              echo 'Veritabanı Hatası';
                          }
                      }else{
                          header('Location:'.$_SESSION['current_url'] .'');
                          exit();
                      }
                  }

                  if($not['modul'] == 'mesaj'  ) {
                      if($yetki['gelenkutusu'] == '1') {
                          $guncelle = $db->prepare("UPDATE panel_bildirim SET
                              durum=:durum  
                         WHERE id={$_GET['noti_id']}      
                        ");
                          $sonuc = $guncelle->execute(array(
                              'durum' => '0'
                          ));
                          if($sonuc){
                              header('Location:'.$ayar['panel_url'].'pages.php?page=inbox_detail&messageID='.$not['icerik_id'].'');
                          }else{
                              echo 'Veritabanı Hatası';
                          }
                      }else{
                          header('Location:'.$_SESSION['current_url'] .'');
                          exit();
                      }
                  }


              }else{
                    header('Location:'.$_SESSION['current_url'] .'');
                    exit();
              }


        }else{
                header('Location:'.$ayar['site_url'].'404');
        }
    }else{
              header('Location:'.$ayar['site_url'].'404');
    }

}else{
    header('Location:'.$_SESSION['current_url'] .'');
    $_SESSION['main_alert'] = 'demo';
}