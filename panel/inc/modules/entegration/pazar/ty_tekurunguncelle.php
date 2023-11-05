<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?><?php if($_POST['postID']  ) {

    function replace_tr($text) {
        $text = trim($text);
        $search = array('Ç','ç','Ğ','ğ','ı','İ','Ö','ö','Ş','ş','Ü','ü');
        $replace = array('C','c','G','G','i','I','O','o','S','s','U','u');
        $new_text = str_replace($search,$replace,$text);
        return $new_text;
    }

    $pazarYeri = $db->prepare("select * from pazaryeri where id='1' ");
    $pazarYeri->execute();
    $pazar = $pazarYeri->fetch(PDO::FETCH_ASSOC);
    $urunSorgu = $db->prepare("select * from trendyol_urun_bilgi where id=:id ");
    $urunSorgu->execute(array(
        'id' => $_POST['postID']
    ));
    $bilgi = $urunSorgu->fetch(PDO::FETCH_ASSOC);
    $kodcek = $bilgi['ty_kod'];
    $tyKod = replace_tr($kodcek);
    $supplierId = ''.$pazar['ty_bayi'].'';
    $username = ''.$pazar['ty_api'].'';
    $password = ''.$pazar['ty_secret'].'';
    $authorization = base64_encode($username . ':' . $password);
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.trendyol.com/sapigw/suppliers/'.$supplierId.'/products?barcode='.$tyKod.'',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT =>0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'User-Agent: ' . $supplierId . ' - SelfIntegration',
            'Authorization: Basic ' . $authorization,
        )
    ));
    $ProductResult = curl_exec($curl);
    curl_close($curl);
    $json = json_decode($ProductResult,true);


    if($urunSorgu->rowCount()>0  ) {

        ?>
        <?php if($json['totalElements'] == '1'   ) {?>
            <div class="modal-dialog modal-dialog-centered  ">
                <div class="modal-content" style="box-shadow: 0 0 10px 0 rgba(0,0,0,.3); border:1px solid #ccc">
                    <div class="btn btn-light btn-sm close border" data-dismiss="modal" aria-label="Close"
                         style=" background-color: #e4e8ec;font-weight: 400 !important; z-index: 99 !important; width: 40px; font-size: 18px ; position: absolute; margin-top:5px; right: 5px;">
                        <i class="fa fa-times"></i>
                    </div>
                    <div class="modal-body  pt-1 pl-4 pr-4 pb-4">
                        <div class="w-100  pt-2 pb-0 border-bottom mb-3">
                            <h6><?= $diller['pazaryeri-text-22'] ?>(Trendyol)</h6>
                        </div>
                        <form action="post.php?process=ty_post&status=ty_tekguncelle" method="post" id="commentForm">
                            <input type="hidden" name="bilgi_id" value="<?= $_POST['postID'] ?>">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="fiyat"><?=$diller['adminpanel-form-text-1765']?></label>
                                    <input type="number" name="fiyat" value="<?=$bilgi['ty_fiyat']?>" id="" required class="form-control">
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="stok"><?=$diller['adminpanel-form-text-1759']?></label>
                                    <input type="number" name="stok" value="<?=$bilgi['ty_stok']?>" id="" required class="form-control">
                                </div>
                            </div>
                            <div class="w-100 pt-2 d-flex justify-content-end">
                                <input type="hidden" name="save">
                                <button id="btnSubmit" class="btn btn-success btn-block  shadow-sm">
                                    <i class="fa fa-play"></i> <?= $diller['pazaryeri-text-26'] ?>
                                </button>
                                <button data-dismiss="modal" aria-label="Close" class="btn btn-light ml-1 border ">
                                    <?= $diller['adminpanel-modal-text-17'] ?>
                                </button>
                            </div>
                        </form>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        <?php }?>
        <?php if($json['totalElements'] == '0'   ) {?>
            <div class="modal-dialog modal-dialog-centered  ">
                <div class="modal-content" style="box-shadow: 0 0 10px 0 rgba(0,0,0,.3); border:1px solid #ccc">
                    <div class="btn btn-light btn-sm close border" data-dismiss="modal" aria-label="Close"
                         style=" background-color: #e4e8ec;font-weight: 400 !important; z-index: 99 !important; width: 40px; font-size: 18px ; position: absolute; margin-top:5px; right: 5px;">
                        <i class="fa fa-times"></i>
                    </div>
                    <div class="modal-body  pt-1 pl-4 pr-4 pb-4">
                        <div class="w-100  pt-2 pb-0 border-bottom mb-3">
                            <h6><?= $diller['pazaryeri-text-22'] ?>(Trendyol)</h6>
                        </div>
                        <?=$diller['pazaryeri-text-99']?>
                    </div>
                </div>
            </div>
        <?php }?>
        <?php
    }}
?>
<script>
    $("#btnSubmit").click(function () {
        $(this).text("<?=$diller['adminpanel-text-358']?>");
    });
    $('#commentForm').bind('submit', function (e) {
        var button = $('#btnSubmit');
        button.prop('disabled', true);
        var valid = true;
        if (!valid) {
            e.preventDefault();
            button.prop('disabled', false);
        }
    });
</script>

