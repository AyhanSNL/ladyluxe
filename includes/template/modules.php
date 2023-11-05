<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?><?php
$modulCek = $db->prepare("select * from moduller where durum='1' order by sira asc");
$modulCek->execute();
?>
<?php foreach ($modulCek as $modul) {

include "$modul[kod]";

}?>
