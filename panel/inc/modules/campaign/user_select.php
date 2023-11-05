<?php
if(isset($_GET['q'])  ) {
    $userList = $db->prepare("select * from uyeler where (isim like '%$_GET[q]%' or soyisim like '%$_GET[q]%') ");
    $userList->execute();

    foreach ($userList as $r){
        $json[] = ['id'=>$r['id'], 'text'=>$r['isim'].' '.$r['soyisim']];
    }

}
$json[] = ['id'=>'0', 'text'=>''.$diller['adminpanel-form-text-1222'].''];
echo json_encode($json);