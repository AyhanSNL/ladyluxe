<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php if($_POST) {
    //todo ioncube
    $itemNo = trim(strip_tags($_POST['cartitem']));
    $token = trim(strip_tags($_POST['token']));
    if($itemNo && $itemNo > '0' && $token ) {
        if($token == md5('plusquantity') || $token == md5('minusquantity')  ) {
            if($token == md5('plusquantity')  ) {

                $ipcek = $_SERVER["REMOTE_ADDR"];
                $sepet = $db->prepare("select * from sepet where sepetno=:sepetno and ip=:ip");
                $sepet->execute(array(
                    'sepetno' => $itemNo,
                    'ip' => $ipcek
                ));
                $sep = $sepet->fetch(PDO::FETCH_ASSOC);

                if($sepet->rowCount()<=''  ) {
                    header('Location:'.$ayar['site_url'].'404');
                    exit();
                }

                /* varyant stok sorgusu */
                $stokKontrolVaryant = $db->prepare("select * from detay_varyant_stok where urun_id=:urun_id and varyant=:varyant ");
                $stokKontrolVaryant->execute(array(
                    'urun_id' => $sep['urun_id'],
                    'varyant' => $sep['varyant']
                ));
                $varstok = $stokKontrolVaryant->fetch(PDO::FETCH_ASSOC);
                /* varyant stok sorgusu SON */

                /* Ana ürün stok kontrolü */
                $anaurunStokKontrol = $db->prepare("SELECT SUM(adet) AS geneladet FROM sepet where ip=:ip and varyant_stok_durum=:varyant_stok_durum and urun_id=:urun_id");
                $anaurunStokKontrol->execute(array(
                    'ip' => $ipcek,
                    'varyant_stok_durum' => '0',
                    'urun_id' => $sep['urun_id']
                ));
                $anastok = $anaurunStokKontrol->fetch(PDO::FETCH_ASSOC);
                $anaurunToplamAdetSayisi = $anastok['geneladet'] + 1 ;
                /* Ana ürün stok kontrolü SON */

                $urun = $db->prepare("select * from urun where id=:id ");
                $urun->execute(array(
                    'id' => $sep['urun_id']
                ));
                $uruncek = $urun->fetch(PDO::FETCH_ASSOC);

                if($sep['varyant_stok_durum'] == '1' ) {
                    if($sepet->rowCount() > '0' && $varstok['stok'] > $sep['adet']) {
                        $guncelle = $db->prepare("UPDATE sepet SET
                        adet=:adet
                        WHERE sepetno={$itemNo} 
                        ");
                        $sonuc = $guncelle->execute(array(
                            'adet' => $sep['adet']+1
                        ));
                        if($sonuc) {
                            $_SESSION['item_go_scroll'] = ''.$itemNo.'';
                         header('Location:'.$ayar['site_url'].'sepet/');
                        }
                        unset($_SESSION['siparis_islem_id']);
                    }else{
                        $_SESSION['addtocart'] = 'nomorestok';
                        header('Location:'.$ayar['site_url'].'sepet/');
                    }
                }
                if($sep['varyant_stok_durum'] == '0') {
                    if($sepet->rowCount() > '0' && $uruncek['stok'] >= $anaurunToplamAdetSayisi) {
                        $guncelle = $db->prepare("UPDATE sepet SET
                        adet=:adet
                        WHERE sepetno={$itemNo} 
                        ");
                        $sonuc = $guncelle->execute(array(
                            'adet' => $sep['adet']+1
                        ));
                        if($sonuc) {
                            $_SESSION['item_go_scroll'] = ''.$itemNo.'';
                         header('Location:'.$ayar['site_url'].'sepet/');
                        }
                        unset($_SESSION['siparis_islem_id']);
                    }
                }


            }
            if($token == md5('minusquantity')  ) {


                $ipcek = $_SERVER["REMOTE_ADDR"];
                $sepet = $db->prepare("select * from sepet where sepetno=:sepetno and ip=:ip");
                $sepet->execute(array(
                    'sepetno' => $itemNo,
                    'ip' => $ipcek
                ));
                $sep = $sepet->fetch(PDO::FETCH_ASSOC);

                $urun = $db->prepare("select * from urun where id=:id ");
                $urun->execute(array(
                    'id' => $sep['urun_id']
                ));
                $uruncek = $urun->fetch(PDO::FETCH_ASSOC);

                if($sepet->rowCount() > '0' ) {

                    /* toplam adet 1 den büyükse 1 eksilt ///////////////////////////////////////////*/
                    if( $sep['adet'] > '1' ) {
                        $guncelle = $db->prepare("UPDATE sepet SET
                                adet=:adet
                         WHERE sepetno={$itemNo} 
                        ");
                        $sonuc = $guncelle->execute(array(
                            'adet' => $sep['adet']-1
                        ));
                        if($sonuc) {
                            $_SESSION['item_go_scroll'] = ''.$itemNo.'';
                            header('Location:'.$ayar['site_url'].'sepet/');
                        }
                        unset($_SESSION['siparis_islem_id']);
                    }
                    /* toplam adet 1 den büyükse 1 eksilt SON///////*/

                    /* Toplam adet 1'e eşitse ürünü kaldır ///////////////////////////////////////////*/
                    if( $sep['adet'] == '1' ) {
                        $silmeislem = $db->prepare("DELETE from sepet WHERE sepetno=:sepetno");
                        $sil = $silmeislem->execute(array(
                            'sepetno' => $itemNo
                        ));
                        $_SESSION['item_go_scroll'] = ''.$itemNo.'';
                        header('Location:'.$ayar['site_url'].'sepet/');
                        unset($_SESSION['siparis_islem_id'] );
                    }
                    /* Toplam adet 1'e eşitse ürünü kaldır SON //////////////*/
                }


            }
        }else{
            header('Location:'.$ayar['site_url'].'404');
        }
    }else{
        header('Location:'.$ayar['site_url'].'404');
    }
 }else {
    header('Location:'.$ayar['site_url'].'404');
}?>
