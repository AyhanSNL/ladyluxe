<?php
try {
    $db=new PDO("mysql:host=localhost;dbname=ladyluxedb;charset=utf8",'ladyluxedbu','h3q0q8!1N');
    $rewurlbase="/";
}
catch (PDOExpception $e) {
    echo $e->getMessage();
}
?>