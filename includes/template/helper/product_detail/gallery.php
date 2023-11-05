<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php if($udetayRow['galeri_tema'] == '1'  ) {
    $urun_galeri = $db->prepare("select * from urun_galeri where urun_id=:urun_id order by sira asc");
    $urun_galeri->execute(array(
        'urun_id' => $icerik['id']
    ));
    ?>
    <link rel="Stylesheet" type="text/css" href="assets/css/productgallery.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js" type="text/javascript"></script>
    <script src="assets/js/jquery.glasscase.min.js" type="text/javascript"></script>
    <ul id="glasscase" class="gc-start" >
        <?php if($urun_galeri->rowCount()>'0'  ) {?>
            <li><img src="images/product/big_photo/<?=$icerik['gorsel']?>" alt="Text"  /></li>
            <?php foreach ($urun_galeri as $galeri) {?>
                <li><img src="images/product/<?=$galeri['gorsel']?>" alt="Text"  /></li>
            <?php }?>
        <?php }else { ?>
            <li><img src="images/product/big_photo/<?=$icerik['gorsel']?>" alt="Text"  /></li>
        <?php }?>
    </ul>

    <!-- Calling the GlassCase plugin -->
    <script type="text/javascript">

        $(document).ready( function () {
            $('#glasscase').glassCase({ 'thumbsPosition': 'bottom', 'widthDisplay': '550', 'heightDisplay' :'520',  'nrThumbsPerRow' : '<?=$udetayRow['galeri_thumb']?>'});
        });

    </script>
<?php }?>
<?php if($udetayRow['galeri_tema'] == '2'  ) {
    $urun_galeri = $db->prepare("select * from urun_galeri where urun_id=:urun_id order by sira asc");
    $urun_galeri->execute(array(
        'urun_id' => $icerik['id']
    ));
    ?>
    <link rel="Stylesheet" type="text/css" href="assets/css/productgallery.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js" type="text/javascript"></script>
    <script src="assets/js/jquery.glasscase.min.js" type="text/javascript"></script>
    <ul id="glasscase" class="gc-start" >
        <?php if($urun_galeri->rowCount()>'0'  ) {?>
            <?php foreach ($urun_galeri as $galeri) {?>
                <li><img src="images/product/<?=$galeri['gorsel']?>" alt="Text"  /></li>
            <?php }?>
        <?php }else { ?>
            <li><img src="images/product/big_photo/<?=$icerik['gorsel']?>" alt="Text"  /></li>
        <?php }?>
    </ul>


    <!-- Calling the GlassCase plugin -->
    <script type="text/javascript">

        $(document).ready( function () {
            $('#glasscase').glassCase({ 'thumbsPosition': 'right', 'widthDisplay': '600', 'heightDisplay' :'<?php if($urun_galeri->rowCount()>'0') { ?>730<?php }else{?>520<?php } ?>', 'nrThumbsPerRow' : '<?=$udetayRow['galeri_thumb']?>'});
        });

    </script>
<?php }?>
<?php if($udetayRow['galeri_tema'] == '3'  ) {
    $urun_galeri = $db->prepare("select * from urun_galeri where urun_id=:urun_id order by sira asc");
    $urun_galeri->execute(array(
        'urun_id' => $icerik['id']
    ));
    ?>
    <link rel="Stylesheet" type="text/css" href="assets/css/productgallery.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js" type="text/javascript"></script>
    <script src="assets/js/jquery.glasscase.min.js" type="text/javascript"></script>
    <ul id="glasscase" class="gc-start" >
        <?php if($urun_galeri->rowCount()>'0'  ) {?>
            <?php foreach ($urun_galeri as $galeri) {?>
                <li><img src="images/product/<?=$galeri['gorsel']?>" alt="Text"  /></li>
            <?php }?>
        <?php }else { ?>
            <li><img src="images/product/big_photo/<?=$icerik['gorsel']?>" alt="Text"  /></li>
        <?php }?>
    </ul>


    <!-- Calling the GlassCase plugin -->
    <script type="text/javascript">

        $(document).ready( function () {
            $('#glasscase').glassCase({ 'thumbsPosition': 'left', 'widthDisplay': '600', 'heightDisplay' :'<?php if($urun_galeri->rowCount()>'0') { ?>730<?php }else{?>520<?php } ?>', 'nrThumbsPerRow' : '<?=$udetayRow['galeri_thumb']?>'});
        });

    </script>
<?php }?>