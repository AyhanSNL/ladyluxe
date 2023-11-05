<?php include 'includes/config/xml_include.php'; ?>
<?php
if(isset($_GET['sayfa'])){
    $s = $_GET['sayfa'];
    switch($s){
        case 'output_xml';
            require_once("includes/template/output/xml.php");
            break;
    }
}else{
    header('Location:'.$ayar['site_url'].'404');
}?>