<?php include 'inc/session.php'; ?>
<?php if($adminSorgu->rowCount()> '0'  ) {?>
    <?php
    if(isset($_GET['print'])){
        $s = $_GET['print'];
        switch($s){
            case 'order';
                require_once("inc/modules/orders/order_print.php");
                break;
            case 'op_order';
                require_once("inc/modules/orders/single_order_print.php");
                break;
            case 'invoice';
                require_once("inc/modules/orders/invoice_print.php");
                break;
        }
    }else{
        header('Location:'.$ayar['panel_url'].'404');
    }?>
    <?php
}else{
    header('Location:'.$ayar['site_url'].'404');
}
?>