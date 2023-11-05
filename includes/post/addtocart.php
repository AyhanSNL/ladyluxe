<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
//todo ioncube
if (isset($_POST['addtocart']) && $_POST) {
    if( $_POST['product_code'] == !null && $_POST['product_code']>'0') {
        $callback = trim(strip_tags($_POST['token']));
        if($callback == md5('homepageCallBack') || $callback == md5('pricingCallBack') || $callback == md5('detailCallBack') ||$callback == md5('brandCallBack') ||$callback == md5('categoryCallBack') ||$callback == md5('searchCallBack') ) {

            $urun_id = trim(strip_tags($_POST['product_code']));

            $urunCek = $db->prepare("select * from urun where id=:id and durum=:durum ");
            $urunCek->execute(array(
                'id' => $urun_id,
                'durum' => '1'
            ));
            $urun = $urunCek->fetch(PDO::FETCH_ASSOC);
            if($urunCek->rowCount()>'0') {
                $urunstok = $urun['stok'];
                $adet = trim(strip_tags($_POST['quantity']));
                $ip = $_SERVER["REMOTE_ADDR"];
                $taksit_durum = $urun['taksit'];
                $rand = rand(0,(int) 99999999);

                /* Herkese Kapalı*/
                if($urun['fiyat_goster'] == '0' ) {
                    header('Location:'.$siteurl.'404');
                    exit();
                }
                /*  <========SON=========>>> Herkese Kapalı SON */

                if($callback == md5('homepageCallBack')  ) {
                    $sesurun_adres = ''.$ayar['site_url'].'';
                }
                if($callback == md5('detailCallBack')  ) {
                    $sesurun_adres = ''.$ayar['site_url'].''.$urun['seo_url'].'-P'.$urun['id'].'';
                }
                if($callback == md5('brandCallBack')  ) {
                    $markaGetir = $db->prepare("select id,seo_url from urun_marka where id=:id ");
                    $markaGetir->execute(array(
                        'id' => $urun['marka']
                    ));
                    if($markaGetir->rowCount()<=''  ) {
                     header('Location:'.$ayar['site_url'].'404');
                        exit();
                    }
                    if($_POST['actualCheck'] == !null  ) {
                     $actualGet = trim(strip_tags($_POST['actualCheck']));
                     $actual_Link_Get = "?$actualGet";
                    }else{
                        $actual_Link_Get = "";
                    }
                    $markaRow = $markaGetir->fetch(PDO::FETCH_ASSOC);
                    $brandName = $markaRow['seo_url'];
                    $sesurun_adres = ''.$ayar['site_url'].'marka/'.$brandName.'/'.$actual_Link_Get.'';
                }
                if($callback == md5('categoryCallBack')  ) {
                    $categorySeo = trim(strip_tags(htmlspecialchars($_POST['categoryRequest'])));
                    $categorySql = $db->prepare("select id from urun_cat where seo_url=:seo_url ");
                    $categorySql->execute(array(
                        'seo_url' => $categorySeo
                    ));
                    if($categorySql->rowCount()<='0'  ) {
                     header('Location:'.$ayar['site_url'].'404');
                     exit();
                    }
                    if($_POST['actualCheck'] == !null  ) {
                        $actualGet = trim(strip_tags($_POST['actualCheck']));
                        $actual_Link_Get = "?$actualGet";
                    }else{
                        $actual_Link_Get = "";
                    }
                    $sesurun_adres = ''.$ayar['site_url'].''.$categorySeo.'/'.$actual_Link_Get.'';
                }
                if($callback == md5('searchCallBack')  ) {
                    if($_POST['actualCheck'] == !null  ) {
                        $actualGet = trim(strip_tags($_POST['actualCheck']));
                        $actual_Link_Get = "?$actualGet";
                    }else{
                        header('Location:'.$ayar['site_url'].'404');
                        exit();
                    }
                    $sesurun_adres = ''.$ayar['site_url'].'arama/'.$actual_Link_Get.'';
                }
                if($callback == md5('pricingCallBack') ) {
                    if($_POST['request'] == !null  ) {
                        if($_POST['request'] == md5('tablesCallBack') || $_POST['request'] == md5('tablesCatCallBack')  ) {
                            if($_POST['request'] == md5('tablesCallBack') ) {
                                $sesurun_adres = ''.$ayar['site_url'].'paketler/';
                            }
                            if($_POST['request'] == md5('tablesCatCallBack') ) {
                                if($_POST['request_name'] == !null  ) {
                                    $pricKate = $db->prepare("select id,seo_url from pricing_kat where seo_url=:seo_url ");
                                    $pricKate->execute(array(
                                        'seo_url' => trim(strip_tags($_POST['request_name']))
                                    ));
                                    if($pricKate->rowCount()>'0'  ) {
                                        $pricRow = $pricKate->fetch(PDO::FETCH_ASSOC);
                                        $sesurun_adres = ''.$ayar['site_url'].'paket/'.$pricRow['seo_url'].'/';
                                    }else{
                                        header('Location:'.$ayar['site_url'].'404');
                                           exit();
                                    }
                                }else{
                                    header('Location:'.$ayar['site_url'].'404');
                                       exit();
                                }
                            }
                        }else{
                            header('Location:'.$ayar['site_url'].'404');
                            exit();
                        }
                    }else{
                        header('Location:'.$ayar['site_url'].'404');
                        exit();
                    }
                }

                /* Herkese açık ürün */
                if($urun['fiyat_goster'] == '1' ) {
                    include 'includes/post/addtocart_in.php';
                }
                /*  <========SON=========>>> Herkese açık ürün SON */

                /* Sadece Üyeler Açık Ürün */
                if($urun['fiyat_goster'] == '2' ) {
                    if($userSorgusu->rowCount()>'0'  ) {
                        include 'includes/post/addtocart_in.php';
                    }else{
                        header('Location:'.$siteurl.'404');
                        exit();
                    }
                }
                /*  <========SON=========>>> Sadece Üyeler Açık Ürün SON */

                /* Sadece Üye Gruplarına Açık Ürün */
                if($urun['fiyat_goster'] == '3' ) {
                    if($uyegruplariCek->rowCount()> '0'  ) {
                        include 'includes/post/addtocart_in.php';
                    }else{
                        header('Location:'.$siteurl.'404');
                        exit();
                    }
                }
                /*  <========SON=========>>> Sadece Üye Gruplarına Açık Ürün SON */
            }else {
                header('Location:'.$siteurl.'404');
                exit();
            }
        }else{
           header('Location:'.$ayar['site_url'].'404');
            exit();
        }
    }else{
        header('Location:'.$siteurl.'404');
        exit();
    }
}else{
    header('Location:'.$siteurl.'404');
    exit();
}
?>