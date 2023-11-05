<?php
if(isset($_GET['q'])  ) {
    $urunleriCek = $db->prepare("select * from urun_cat where durum='1'  and (baslik like '%$_GET[q]%') order by sira asc ");
    $urunleriCek->execute();

    foreach ($urunleriCek as $r){
        $json[] = ['id'=>$r['id'], 'text'=>$r['baslik']];
    }

}

echo json_encode($json);