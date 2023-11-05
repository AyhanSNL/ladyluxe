<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?><?php
//todo ioncube
if(isset($_GET["sepet_no_id"]))
{
    $silget = htmlspecialchars($_GET["sepet_no_id"]);
    $silmeislem = $db->prepare("DELETE from sepet WHERE sepetno=:sepetno");
    $silmeislem->execute(array(
       'sepetno' => $silget
    ));
    if($silmeislem->rowCount()<='0'  ) {
     header('Location:'.$ayar['site_url'].'404');
    }
    die(json_encode(array()));
}else{
    header('Location:'.$ayar['site_url'].'404');
}
