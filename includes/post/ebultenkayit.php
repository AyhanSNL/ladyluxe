<?php
ob_start();
session_start();
include "../config/config.php";
date_default_timezone_set( 'Europe/Istanbul' );
$settings=$db->prepare("SELECT * from ayarlar where id='1'");
$settings->execute(array(0));
$ayar=$settings->fetch(PDO::FETCH_ASSOC);
$siteurl = $ayar['site_url'];
?>
<?php
if ($_POST) {

    $eposta = trim(strip_tags($_POST['eposta']));

    if($eposta  ) {
        if($demo != '1'  ){
            if (filter_var($eposta, FILTER_VALIDATE_EMAIL)){

                $epostaSorgula = $db->prepare("select * from ebulten where eposta=:eposta ");
                $epostaSorgula->execute(array(
                    'eposta' => $eposta
                ));

                $timestamp = date('Y-m-d G:i:s');

                if($epostaSorgula->rowCount()<='0'  ) {
                    $kaydet = $db->prepare("INSERT INTO ebulten SET
              eposta=:eposta,
              tarih=:tarih      
            ");
                    $sonuc = $kaydet->execute(array(
                        'eposta' => $eposta,
                        'tarih' => $timestamp
                    ));
                    if($sonuc){
                        $_SESSION['ebulten_sonuc'] = 'success';
                        /* E-Posta Bildirimleri */
                        if($ayar['smtp_durum'] == '1' ) {
                            include 'includes/post/mailtemp/bulten_mail_temp.php';
                        }
                        /* E-Posta Bildirimleri SON */
                        header('Location:'.$siteurl.'');
                    }else{
                        header('Location:'.$siteurl.'404');
                    }
                }else{
                    $_SESSION['ebulten_sonuc'] = 'benzermail';
                    header('Location:'.$siteurl.'');
                }
            }else{
                $_SESSION['ebulten_sonuc'] = 'eposta';
                header('Location:'.$siteurl.'');
            }
        }else{
            $_SESSION['demo_alert'] = 'demo';
            header('Location:'.$siteurl.'');
        }
    }else{
        $_SESSION['ebulten_sonuc'] = 'empty';
        header('Location:'.$siteurl.'');
    }
}else{
    header('Location:'.$siteurl.'404');
}
?>