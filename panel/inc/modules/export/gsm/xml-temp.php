<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?><?php
$xml_Content .= '<?xml version="1.0" encoding="UTF-8"?>';
$xml_Content .= '<NumberList>';
foreach ($gsmList as $row){
    $xml_Content .= '<GsmNumber>';
    $xml_Content .= '<Number>';
    $xml_Content .= ''.$row['gsm'].'';
    $xml_Content .= '</Number>';
    $xml_Content .= '<Name>';
    $xml_Content .= ''.$row['isim'].'';
    $xml_Content .= '</Name>';
    $xml_Content .= '</GsmNumber>';
}
$xml_Content .= '</NumberList>';
?>