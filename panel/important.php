<?php if($adminSorgu->rowCount()> '0'  ) {?>
    <?php
    //todo ioncube
    if(isset($_GET['process'])){
        $s = $_GET['process'];
        switch($s){
            case 'nononono';
                require_once("inc/template/counters/counter_header.php");
                break;
        }
    }else{
        header('Location:'.$ayar['site_url'].'404');
    }?>
    <?php
}else{
    header('Location:'.$ayar['site_url'].'404');
}
?>