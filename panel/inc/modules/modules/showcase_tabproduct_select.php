<?php
if(isset($_GET['q'])  ) {
    $urunleriCek = $db->prepare("select * from urun where durum='1' and dil='$_SESSION[dil]' and anasayfa='1' and (baslik like '%$_GET[q]%') ");
    $urunleriCek->execute();

    foreach ($urunleriCek as $r){
        $json[] = ['id'=>$r['id'], 'text'=>$r['baslik']];
    }

}

echo json_encode($json);