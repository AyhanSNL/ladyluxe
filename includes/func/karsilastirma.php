<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
if(isset($_GET["urun_id"]))
{
    if(isset($_SESSION['compare_product'])  ) {
         $_SESSION['compare_product'][$_GET['urun_id']] = $_GET['urun_id'];
        $_SESSION['compare_status'] = 'success';
                array_map('unlink', glob('../../i/cache/d/*.html'));
    die(json_encode(array()));
    }else{
           $_SESSION['compare_product'][$_GET['urun_id']] = $_GET['urun_id'];
            $_SESSION['compare_status'] = 'success';
                    array_map('unlink', glob('../../i/cache/d/*.html'));
    die(json_encode(array()));
    }

}
if(isset($_GET["cikar_id"]))
{
    unset($_SESSION['compare_product'][$_GET['cikar_id']]);
    if( $_SESSION['compare_product'] == null ) {
        unset($_SESSION['compare_product']);
    }
            array_map('unlink', glob('../../i/cache/d/*.html'));
    die(json_encode(array()));
}
?>