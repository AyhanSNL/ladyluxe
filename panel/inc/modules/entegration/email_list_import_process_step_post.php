<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
//todo ioncube
if($yetki['demo'] != '1' ) {
    if (isset($_GET['status'])) {
        if ($_GET['status'] == 'import') {
            if($_GET['status'] == 'import'  ) {
                if ($_POST && isset($_POST['sync']) && $_POST['xml_id'] && $_POST['anatag'] && $_POST['adrestag'] && $_POST['dosya']) {
                   $dosya = $_POST['dosya'];
                   $anatag = $_POST['anatag'];
                   $adrestag = $_POST['adrestag'];
                   $xml_file = simplexml_load_file('inc/input/email/'.$dosya.'');
                    if($xml_file) {
                      foreach ($xml_file->$anatag as $i){
                          $guncelle = $db->prepare("UPDATE eposta_import SET
                                   durum=:durum
                               WHERE id={$_POST['xml_id']}      
                              ");
                          $sonuc = $guncelle->execute(array(
                              'durum' => '1'
                          ));
                          $timestamp = date('Y-m-d G:i:s');
                          foreach ($i as $a){
                              $kaydet = $db->prepare("INSERT INTO ebulten SET
                                      eposta=:eposta,
                                      tarih=:tarih,
                                      xml_id=:xml_id
                              ");
                              $sonuc = $kaydet->execute(array(
                                  'eposta' => $a,
                                  'tarih' => $timestamp,
                                  'xml_id' => $_POST['xml_id']
                              ));
                          }
                          if($sonuc){
                              header('Location:'.$ayar['panel_url'].'pages.php?page=email_list_import');
                              $_SESSION['main_alert'] = 'success';
                          }else{
                              echo 'Veritabanı Hatası';
                          }
                      }
                    }else{
                        header('Location:'.$ayar['site_url'].'404');
                        exit();
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
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