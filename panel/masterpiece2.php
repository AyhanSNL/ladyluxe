<?php include 'inc/session.php'; ?>
<?php if($adminSorgu->rowCount()> '0'  ) {

    ?>
    <?php
    if(isset($_GET['page'])){
        $s = $_GET['page'];
        switch($s){


            //todo paraşüt
            case 'parasut_iptal';
                require_once("inc/modules/parasut/iptalet.php");
                break;
            case 'parasut_sil';
                require_once("inc/modules/parasut/sil.php");
                break;
            case 'parasut_resmilestir';
                require_once("inc/modules/parasut/resmilestir.php");
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