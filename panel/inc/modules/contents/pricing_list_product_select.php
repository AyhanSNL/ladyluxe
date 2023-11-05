<?php
if(isset($_GET['q'])  ) {
    $urunleriCek = $db->prepare("select * from urun where durum='1' and siparis_islem = '0' and dil='$_SESSION[dil]' and (baslik like '%$_GET[q]%' or icerik like '%$_GET[q]%' ) ");
    $urunleriCek->execute();

    foreach ($urunleriCek as $r){
        $json[] = ['id'=>$r['id'], 'text'=>$r['baslik']];
    }

}

echo json_encode($json);