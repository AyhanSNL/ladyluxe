<?php
if(isset($_GET['q'])  ) {
    $userList = $db->prepare("select * from sms_numaralar where (isim like '%$_GET[q]%' or gsm like '%$_GET[q]%') ");
    $userList->execute();

    foreach ($userList as $r){
        $json[] = ['id'=>$r['gsm'], 'text'=>$r['isim']];
    }

}
echo json_encode($json);