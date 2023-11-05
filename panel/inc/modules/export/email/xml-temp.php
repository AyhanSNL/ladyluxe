<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?><?php
$xml_Content .= '<?xml version="1.0" encoding="UTF-8"?>';
$xml_Content .= '<MailAddressList>';
foreach ($maiLList as $row){
    $xml_Content .= '<MailAddress>';
    $xml_Content .= '<Address>';
    $xml_Content .= ''.$row['eposta'].'';
    $xml_Content .= '</Address>';
    $xml_Content .= '</MailAddress>';
}
$xml_Content .= '</MailAddressList>';
?>