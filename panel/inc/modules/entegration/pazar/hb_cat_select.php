<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?><?php if($_POST['postID'] && $_POST['turnPage']   ) {
    $pazarYeri = $db->prepare("select ty_bayi, ty_api, ty_secret from pazaryeri where id='1' ");
    $pazarYeri->execute();
    $pazar = $pazarYeri->fetch(PDO::FETCH_ASSOC);

    $catCek = $db->prepare("select * from urun_cat where id='$_POST[postID]' ");
    $catCek->execute();
    $catRows = $catCek->fetch(PDO::FETCH_ASSOC);

    $fileCheck = file_get_contents(''.$ayar['panel_url'].'assets/hb_categories/liste1.json');
    $json = json_decode($fileCheck);
    $fileCheck2 = file_get_contents(''.$ayar['panel_url'].'assets/hb_categories/liste2.json');
    $json2 = json_decode($fileCheck2);
    $fileCheck3 = file_get_contents(''.$ayar['panel_url'].'assets/hb_categories/liste3.json');
    $json3 = json_decode($fileCheck3);
    ?>

    <div class="modal-dialog modal-dialog-centered  ">
        <div class="modal-content" style="box-shadow: 0 0 10px 0 rgba(0,0,0,.3); border:1px solid #ccc">
            <div class="btn btn-light btn-sm close border" data-dismiss="modal" aria-label="Close" style=" background-color: #e4e8ec;font-weight: 400 !important; z-index: 99 !important; width: 40px; font-size: 18px ; position: absolute; margin-top:5px; right: 5px;">
                <i class="fa fa-times"></i>
            </div>
            <div class="modal-body  pt-1 pl-4 pr-4 pb-4">
                <div class="w-100  pt-2 pb-0 border-bottom mb-3">
                    <h6><?=$diller['pazaryeri-text-9']?> (Hepsiburada)</h6>
                </div>
                <form action="post.php?process=hb_post&status=hb_eslestir" method="post" id="commentForm">
                    <input type="hidden" name="cat_id" value="<?=$catRows['id']?>" >
                    <input type="hidden" name="return" value="<?=$_POST['turnPage']?>">
                    <input type="hidden" name="product_id" value="<?=$_POST['productID']?>">
                    <div class="row">
                      <div class="form-group col-md-12">
                          <label for=""><?=$diller['pazaryeri-text-164']?></label>
                          <select name="select_kat_id" class="form-control selet2" style="width: 100% !important;" required>
                              <option value=""><?=$diller['adminpanel-form-text-50']?></option>
                              <?php foreach ($json->data as $a){  ?>
                                  <option value="<?=$a->categoryId?>"><?php foreach ($a->paths as $pa){ echo $pa; echo ' / ';} ?></option>
                              <?php } ?>
                              <?php foreach ($json2->data as $a2){  ?>
                                  <option value="<?=$a2->categoryId?>"><?php foreach ($a2->paths as $pa2){ echo $pa2; echo ' / ';} ?></option>
                              <?php } ?>
                              <?php foreach ($json3->data as $a3){  ?>
                                  <option value="<?=$a3->categoryId?>"><?php foreach ($a3->paths as $pa3){ echo $pa3; echo ' / ';} ?></option>
                              <?php } ?>
                          </select>
                      </div>
                    </div>
                    <div class="w-100 pt-2 mt-2 d-flex justify-content-end">
                        <input type="hidden" name="save" >
                        <button id="btnSubmit" class="btn btn-success btn-block  shadow-sm">
                            <?=$diller['adminpanel-form-text-53']?>
                        </button>
                        <button data-dismiss="modal" aria-label="Close" class="btn btn-light ml-1 border ">
                            <?=$diller['adminpanel-modal-text-17']?>
                        </button>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
    <?php
}else {     echo 'Error';
}?>
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
<script>
    $(document).ready(function() {
        $('.selet2').select2({

        })})
</script>
