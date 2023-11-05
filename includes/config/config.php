<?php
try {
    $db=new PDO("mysql:host=localhost;dbname=rekbil_e11;charset=utf8",'rekbil_e11','abcd25abcd25*');
    $rewurlbase="/";
}
catch (PDOExpception $e) {
    echo $e->getMessage();
}
?>