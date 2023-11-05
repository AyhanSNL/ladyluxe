<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>

<?php if($icerik['fiyat_goster'] == '1' && $icerik['stok']>'0'  ) {?>
        <?php if($icerik['taksit'] == '1' ) {?>
          <div id="tabs-taksitler" >
                            <div class="taksitler-main-div">
                                <?php
                                $kartlar = $db->prepare("select * from taksit_kart where durum=:durum order by sira asc ");
                                $kartlar->execute(array(
                                    'durum' => '1'
                                ));
                                ?>
                                <?php if($kartlar->rowCount()<= '0'  ) {?>
                                <div class="alert alert-secondary" style="width: 100%; text-align: left; border-radius: 0  ">
                                    <?=$diller['urun-detay-taksitler-eklenmemiş']?>
                                </div>
                                <?php }?>
                                <?php foreach ($kartlar as $kart) {
                                    $aySorguSonuc = $db->prepare("select * from taksit_kart_ay where durum=:durum and kart_id=:kart_id order by sira asc ");
                                    $aySorguSonuc->execute(array(
                                        'durum' => '1',
                                        'kart_id' => $kart['id']
                                    ));?>
                                    <div class="taksitler-boxes">
                                        <div class="taksitler-boxes-img">
                                            <img src="images/ccards/<?=$kart['gorsel']?>" alt="<?=$kart['baslik']?>">
                                        </div>
                                        <?php if($aySorguSonuc->rowCount() > '0'  ) {?>
                                            <div class="taksitler-boxes-aylar-white">
                                                <div class="taksitler-ic-div" style="padding: 0;font-weight: 600; font-size: 13px;"><?=$diller['urun-detay-taksit-tutarı']?></div>
                                                <div class="taksitler-ic-div" style="padding: 0;font-weight: 600; font-size: 13px;"><?=$diller['urun-detay-taksit-toplam-tutar']?></div>
                                            </div>
                                            <?php
                                            $aylar = $db->prepare("select * from taksit_kart_ay where durum=:durum and kart_id=:kart_id order by sira asc ");
                                            $aylar->execute(array(
                                                'durum' => '1',
                                                'kart_id' => $kart['id']
                                            ));
                                            while ($aycek = $aylar->fetch(PDO::FETCH_ASSOC))
                                            {
                                                if($icerik['kdv'] =='1' ) {
                                                    $kdvlitablofiyati = $mevcutfiyat + kdvhesapla($mevcutfiyat,$icerik['kdv_oran']);
                                                    $taksitlifiyat = taksithesapla($kdvlitablofiyati,$aycek['vade_oran']);
                                                }else{
                                                    $taksitlifiyat = taksithesapla($mevcutfiyat,$aycek['vade_oran']);
                                                }
                                                ?>
                                                <div class="taksitler-boxes-aylar-main">
                                                    <div class="taksitler-ic-div"><strong><?=$aycek['ay']?></strong> x

                                                        <?php if($secilikur['simge_gosterim'] == '0' ) {?>
                                                            <?=$secilikur['sol_simge']?>
                                                        <?php }?>
                                                        <?php if($secilikur['simge_gosterim'] == '1' ) {?>
                                                            <?=$secilikur['sag_simge']?>
                                                        <?php }?>
                                                        <?php echo number_format(kurhesapla($varsayilankur['deger'],$secilikur['deger'],$taksitlifiyat/$aycek['ay'] ), $secilikur['para_format']); ?>
                                                        <?php if($secilikur['simge_gosterim'] == '2' ) {?>
                                                            <?=$secilikur['sol_simge']?>
                                                        <?php }?>
                                                        <?php if($secilikur['simge_gosterim'] == '3' ) {?>
                                                            <?=$secilikur['sag_simge']?>
                                                        <?php }?>

                                                    </div>
                                                    <div class="taksitler-ic-div">
                                                        <?php if($secilikur['simge_gosterim'] == '0' ) {?>
                                                        <?=$secilikur['sol_simge']?>
                                                        <?php }?>
                                                        <?php if($secilikur['simge_gosterim'] == '1' ) {?>
                                                        <?=$secilikur['sag_simge']?>
                                                        <?php }?>
                                                        <?php echo number_format(kurhesapla($varsayilankur['deger'],$secilikur['deger'],$taksitlifiyat ), $secilikur['para_format']); ?>
                                                        <?php if($secilikur['simge_gosterim'] == '2' ) {?>
                                                        <?=$secilikur['sol_simge']?>
                                                        <?php }?>
                                                        <?php if($secilikur['simge_gosterim'] == '3' ) {?>
                                                        <?=$secilikur['sag_simge']?>
                                                        <?php }?>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        <?php }else { ?>
                                            <div style="width: 90%; margin: 0 auto; background-color: #f8f8f8; font-size: 12px; text-align: center; padding: 8px 0;"><?=$diller['urun-detay-taksit-sayisi-yok']?></div>
                                        <?php }?>
                                    </div>
                                <?php }?>
                            </div>
                    </div>
  <?php }?>
<?php }?>

<?php if($icerik['fiyat_goster'] == '2' && $icerik['stok']>'0' ) {?>
<?php if($icerik['taksit'] == '1' ) {?>
        <?php if($userSorgusu->rowCount()>'0'  ) {?>
            <div id="tabs-taksitler" >
                <div class="taksitler-main-div">
                    <?php
                    $kartlar = $db->prepare("select * from taksit_kart where durum=:durum order by sira asc ");
                    $kartlar->execute(array(
                        'durum' => '1'
                    ));
                    ?>
                    <?php if($kartlar->rowCount()<= '0'  ) {?>
                        <div class="alert alert-secondary" style="width: 100%; text-align: left; border-radius: 0  ">
                            <?=$diller['urun-detay-taksitler-eklenmemiş']?>
                        </div>
                    <?php }?>
                    <?php foreach ($kartlar as $kart) {
                        $aySorguSonuc = $db->prepare("select * from taksit_kart_ay where durum=:durum and kart_id=:kart_id order by sira asc ");
                        $aySorguSonuc->execute(array(
                            'durum' => '1',
                            'kart_id' => $kart['id']
                        ));?>
                        <div class="taksitler-boxes">
                            <div class="taksitler-boxes-img">
                                <img src="images/ccards/<?=$kart['gorsel']?>" alt="<?=$kart['baslik']?>">
                            </div>
                            <?php if($aySorguSonuc->rowCount() > '0'  ) {?>
                                <div class="taksitler-boxes-aylar-white">
                                    <div class="taksitler-ic-div" style="padding: 0;font-weight: 600; font-size: 13px;"><?=$diller['urun-detay-taksit-tutarı']?></div>
                                    <div class="taksitler-ic-div" style="padding: 0;font-weight: 600; font-size: 13px;"><?=$diller['urun-detay-taksit-toplam-tutar']?></div>
                                </div>
                                <?php
                                $aylar = $db->prepare("select * from taksit_kart_ay where durum=:durum and kart_id=:kart_id order by sira asc ");
                                $aylar->execute(array(
                                    'durum' => '1',
                                    'kart_id' => $kart['id']
                                ));
                                while ($aycek = $aylar->fetch(PDO::FETCH_ASSOC))
                                {
                                    if($icerik['kdv'] =='1' ) {
                                        $kdvlitablofiyati = $mevcutfiyat + kdvhesapla($mevcutfiyat,$icerik['kdv_oran']);
                                        $taksitlifiyat = taksithesapla($kdvlitablofiyati,$aycek['vade_oran']);
                                    }else{
                                        $taksitlifiyat = taksithesapla($mevcutfiyat,$aycek['vade_oran']);
                                    }
                                    ?>
                                    <div class="taksitler-boxes-aylar-main">
                                        <div class="taksitler-ic-div"><strong><?=$aycek['ay']?></strong> x

                                            <?php if($secilikur['simge_gosterim'] == '0' ) {?>
                                                <?=$secilikur['sol_simge']?>
                                            <?php }?>
                                            <?php if($secilikur['simge_gosterim'] == '1' ) {?>
                                                <?=$secilikur['sag_simge']?>
                                            <?php }?>
                                            <?php echo number_format(kurhesapla($varsayilankur['deger'],$secilikur['deger'],$taksitlifiyat/$aycek['ay'] ), $secilikur['para_format']); ?>
                                            <?php if($secilikur['simge_gosterim'] == '2' ) {?>
                                                <?=$secilikur['sol_simge']?>
                                            <?php }?>
                                            <?php if($secilikur['simge_gosterim'] == '3' ) {?>
                                                <?=$secilikur['sag_simge']?>
                                            <?php }?>

                                        </div>
                                        <div class="taksitler-ic-div">
                                            <?php if($secilikur['simge_gosterim'] == '0' ) {?>
                                                <?=$secilikur['sol_simge']?>
                                            <?php }?>
                                            <?php if($secilikur['simge_gosterim'] == '1' ) {?>
                                                <?=$secilikur['sag_simge']?>
                                            <?php }?>
                                            <?php echo number_format(kurhesapla($varsayilankur['deger'],$secilikur['deger'],$taksitlifiyat ), $secilikur['para_format']); ?>
                                            <?php if($secilikur['simge_gosterim'] == '2' ) {?>
                                                <?=$secilikur['sol_simge']?>
                                            <?php }?>
                                            <?php if($secilikur['simge_gosterim'] == '3' ) {?>
                                                <?=$secilikur['sag_simge']?>
                                            <?php }?>
                                        </div>
                                    </div>
                                <?php } ?>
                            <?php }else { ?>
                                <div style="width: 90%; margin: 0 auto; background-color: #f8f8f8; font-size: 12px; text-align: center; padding: 8px 0;"><?=$diller['urun-detay-taksit-sayisi-yok']?></div>
                            <?php }?>
                        </div>
                    <?php }?>
                </div>
            </div>
        <?php }?>
<?php }}?>

<?php if($icerik['fiyat_goster'] == '3' && $icerik['stok']>'0' ) {?>
    <?php if($icerik['taksit'] == '1' ) {?>
        <?php if($uyegruplariCek->rowCount()>'0'  ) {?>
            <div id="tabs-taksitler" >
                <div class="taksitler-main-div">
                    <?php
                    $kartlar = $db->prepare("select * from taksit_kart where durum=:durum order by sira asc ");
                    $kartlar->execute(array(
                        'durum' => '1'
                    ));
                    ?>
                    <?php if($kartlar->rowCount()<= '0'  ) {?>
                        <div class="alert alert-secondary" style="width: 100%; text-align: left; border-radius: 0  ">
                            <?=$diller['urun-detay-taksitler-eklenmemiş']?>
                        </div>
                    <?php }?>
                    <?php foreach ($kartlar as $kart) {
                        $aySorguSonuc = $db->prepare("select * from taksit_kart_ay where durum=:durum and kart_id=:kart_id order by sira asc ");
                        $aySorguSonuc->execute(array(
                            'durum' => '1',
                            'kart_id' => $kart['id']
                        ));?>
                        <div class="taksitler-boxes">
                            <div class="taksitler-boxes-img">
                                <img src="images/ccards/<?=$kart['gorsel']?>" alt="<?=$kart['baslik']?>">
                            </div>
                            <?php if($aySorguSonuc->rowCount() > '0'  ) {?>
                                <div class="taksitler-boxes-aylar-white">
                                    <div class="taksitler-ic-div" style="padding: 0;font-weight: 600; font-size: 13px;"><?=$diller['urun-detay-taksit-tutarı']?></div>
                                    <div class="taksitler-ic-div" style="padding: 0;font-weight: 600; font-size: 13px;"><?=$diller['urun-detay-taksit-toplam-tutar']?></div>
                                </div>
                                <?php
                                $aylar = $db->prepare("select * from taksit_kart_ay where durum=:durum and kart_id=:kart_id order by sira asc ");
                                $aylar->execute(array(
                                    'durum' => '1',
                                    'kart_id' => $kart['id']
                                ));
                                while ($aycek = $aylar->fetch(PDO::FETCH_ASSOC))
                                {
                                    if($icerik['kdv'] =='1' ) {
                                        $kdvlitablofiyati = $mevcutfiyat + kdvhesapla($mevcutfiyat,$icerik['kdv_oran']);
                                        $taksitlifiyat = taksithesapla($kdvlitablofiyati,$aycek['vade_oran']);
                                    }else{
                                        $taksitlifiyat = taksithesapla($mevcutfiyat,$aycek['vade_oran']);
                                    }
                                    ?>
                                    <div class="taksitler-boxes-aylar-main">
                                        <div class="taksitler-ic-div"><strong><?=$aycek['ay']?></strong> x

                                            <?php if($secilikur['simge_gosterim'] == '0' ) {?>
                                                <?=$secilikur['sol_simge']?>
                                            <?php }?>
                                            <?php if($secilikur['simge_gosterim'] == '1' ) {?>
                                                <?=$secilikur['sag_simge']?>
                                            <?php }?>
                                            <?php echo number_format(kurhesapla($varsayilankur['deger'],$secilikur['deger'],$taksitlifiyat/$aycek['ay'] ), $secilikur['para_format']); ?>
                                            <?php if($secilikur['simge_gosterim'] == '2' ) {?>
                                                <?=$secilikur['sol_simge']?>
                                            <?php }?>
                                            <?php if($secilikur['simge_gosterim'] == '3' ) {?>
                                                <?=$secilikur['sag_simge']?>
                                            <?php }?>

                                        </div>
                                        <div class="taksitler-ic-div">
                                            <?php if($secilikur['simge_gosterim'] == '0' ) {?>
                                                <?=$secilikur['sol_simge']?>
                                            <?php }?>
                                            <?php if($secilikur['simge_gosterim'] == '1' ) {?>
                                                <?=$secilikur['sag_simge']?>
                                            <?php }?>
                                            <?php echo number_format(kurhesapla($varsayilankur['deger'],$secilikur['deger'],$taksitlifiyat ), $secilikur['para_format']); ?>
                                            <?php if($secilikur['simge_gosterim'] == '2' ) {?>
                                                <?=$secilikur['sol_simge']?>
                                            <?php }?>
                                            <?php if($secilikur['simge_gosterim'] == '3' ) {?>
                                                <?=$secilikur['sag_simge']?>
                                            <?php }?>
                                        </div>
                                    </div>
                                <?php } ?>
                            <?php }else { ?>
                                <div style="width: 90%; margin: 0 auto; background-color: #f8f8f8; font-size: 12px; text-align: center; padding: 8px 0;"><?=$diller['urun-detay-taksit-sayisi-yok']?></div>
                            <?php }?>
                        </div>
                    <?php }?>
                </div>
            </div>
        <?php }?>
<?php }}?>


