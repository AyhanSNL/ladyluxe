<?php
if(isset($_GET['q'])  ) {
    $urunleriCek = $db->prepare("select * from hizmet where dil='$_SESSION[dil]' and (baslik like '%$_GET[q]%') ");
    $urunleriCek->execute();

    foreach ($urunleriCek as $r){
        $json[] = ['id'=>$r['id'], 'text'=>$r['baslik']];
    }

}

echo json_encode($json);