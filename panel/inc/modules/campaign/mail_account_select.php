<?php
if(isset($_GET['q'])  ) {
    $userList = $db->prepare("select * from ebulten where (eposta like '%$_GET[q]%') ");
    $userList->execute();

    foreach ($userList as $r){
        $json[] = ['id'=>$r['eposta'], 'text'=>$r['eposta']];
    }

}
echo json_encode($json);