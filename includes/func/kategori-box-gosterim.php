<?php
ob_start();
session_start();
include "../config/config.php";
if(isset($_GET["grid"]))
{

    $_SESSION['cat_box_show_select'] = '1';

    die(json_encode(array()));

}
if(isset($_GET["grid_b"]))
{

    $_SESSION['cat_box_show_select'] = '3';

    die(json_encode(array()));

}
if(isset($_GET["list"]))
{
    $_SESSION['cat_box_show_select'] = '2';

    die(json_encode(array()));
}
?>