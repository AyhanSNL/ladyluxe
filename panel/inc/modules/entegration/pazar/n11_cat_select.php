<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?><?php if($_POST['postID'] && $_POST['turnPage']   ) {
    $pazarYeri = $db->prepare("select * from pazaryeri where id='1' ");
    $pazarYeri->execute();
    $pazar = $pazarYeri->fetch(PDO::FETCH_ASSOC);
    include "inc/modules/entegration/pazar/n11_api.php";

    $catCek = $db->prepare("select * from urun_cat where id='$_POST[postID]' ");
    $catCek->execute();
    $catRows = $catCek->fetch(PDO::FETCH_ASSOC);

    if($catCek->rowCount()>0  ) {
        $categories = $n11->GetTopLevelCategories();
    ?>

    <div class="modal-dialog modal-dialog-centered  ">
        <div class="modal-content" style="box-shadow: 0 0 10px 0 rgba(0,0,0,.3); border:1px solid #ccc">
            <div class="btn btn-light btn-sm close border" data-dismiss="modal" aria-label="Close" style=" background-color: #e4e8ec;font-weight: 400 !important; z-index: 99 !important; width: 40px; font-size: 18px ; position: absolute; margin-top:5px; right: 5px;">
                <i class="fa fa-times"></i>
            </div>
            <div class="modal-body  pt-1 pl-4 pr-4 pb-4">
                <div class="w-100  pt-2 pb-0 border-bottom mb-3">
                    <h6><?=$diller['pazaryeri-text-9']?></h6>
                </div>
                <div class="w-100 bg-light p-3 border mb-3">
                    <?=$diller['pazaryeri-text-12']?>
                </div>
                <form action="post.php?process=pazar_post&status=n11_eslestir" method="post" id="commentForm">
                    <input type="hidden" name="cat_id" value="<?=$catRows['id']?>" >
                    <input type="hidden" name="return" value="<?=$_POST['turnPage']?>">
                    <input type="hidden" name="product_id" value="<?=$_POST['productID']?>">
                    <div class="row">
                      <div class="form-group col-md-12">
                          <label for=""><?=$diller['pazaryeri-text-10']?></label>
                          <?php foreach ($categories->categoryList as $arr) { ?>
                              <select name="category_top" class="form-control selet2" style="width: 100% !important;" required>
                                  <option value=""><?=$diller['adminpanel-form-text-50']?></option>
                                  <?php foreach ($arr as $obj => $key) { ?>
                                      <option value="<?= $key->id ?>"><?= $key->name ?></option>
                                  <?php } ?>
                              </select>
                          <?php } ?>
                      </div>
                        <div id="main-container" style="display:none" ></div>
                        <div id="sub1" class="w-100" style="display:none"></div>
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
    <?php }else{
        echo 'Error';
    }
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
<script type="text/javascript">
    $(document).ready(function(){
        $('#main-container').html('Loading... Please wait');
        $("select[name='category_top']").on('change',function(){
            var option = $("select[name='category_top']").val();
            jQuery.ajax({
                type: "GET",
                url: "masterpiece.php?page=n11_subcat&level=1",
                data: "option="+option,
                success: function(response){
                    $("#sub1").html(response);
                    $("#sub1").show();
                }
            });
        });

    });
</script>
<script>
    $(document).ready(function() {
        $('.selet2').select2({

        })})
</script>
