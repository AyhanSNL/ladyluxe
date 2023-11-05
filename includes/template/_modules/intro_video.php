<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?><link rel="stylesheet" href="assets/css/filter-isotope/isotope.css">
<?php
$tanVideo = $db->prepare("select * from tanitim_video where id='1'");
$tanVideo->execute();
$tv = $tanVideo->fetch(PDO::FETCH_ASSOC);

$tanVids = $db->prepare("select * from tanitim_video_icerik where dil=:dil order by id desc limit 1 ");
$tanVids->execute(array(
    'dil' => $_SESSION['dil'],
));
$tanKod = $tanVids->fetch(PDO::FETCH_ASSOC);
?>
<div class="intro-video-module-main-div">
    <div class="intro-video-module-inside-area">
        <?php if($tv['logo'] ==!null ) {?>
            <div style="width: 100%; text-align: center; margin-bottom: 25px;  ">
                <img src="images/uploads/<?=$tv['logo']?>" alt="<?=$ayar['site_baslik']?>">
            </div>
        <?php }?>
        <?php if($tanKod['baslik'] == !null || $tanKod['ustbaslik'] == !null) {?>
            <!-- Modül başlıgı ve üst başlıgı !-->
            <div class="modules-head-text-main">
                <?php if($tanKod['ustbaslik'] == !null  ) {?>
                    <div class="modules-head-text-s <?=$tv['baslik_space']?>" style="color: #<?=$tv['spot_renk']?>;font-family : '<?=$tv['baslik_font']?>',sans-serif ;">
                       <?=$tanKod['ustbaslik']?>
                    </div>
                <?php }?>
                <?php if($tanKod['baslik'] == !null  ) {?>
                    <div class="modules-head-text-h <?=$tv['baslik_space']?>" style="color: #<?=$tv['baslik_renk']?>;font-family : '<?=$tv['baslik_font']?>',sans-serif ; ">
                        <?=$tanKod['baslik']?>
                    </div>
                <?php }?>
            </div>
            <!-- Modül başlıgı ve üst başlıgı SON !-->
        <?php }?>
        <div style="width: 100%; margin-bottom: 35px; position: relative ">
            <a class="video-play-button" data-toggle="modal" data-target="#tanitimvideosu" role="button" style="cursor: pointer" >
                <span></span>
            </a>
        </div>

    </div>
    <?php if($tv['bg_tip'] == '0'  ) {?>
        <?php if($tv['bg_dark'] == '1'  ) {?>
            <!-- Slider Karartma Var ise !-->
            <div style="background: rgba(0,0,0,0.6); width: 100%; height: 100%; position: absolute; top:0; left:0; z-index:1"></div>
            <!-- Slider Karartma Var ise !-->
        <?php }?>
    <?php }?>
</div>


<!-- Modal -->
<style>
    .modal-content{border-radius: 0 !important;
        border:0 !important;
    }
    .modal-times-icon{
        position: absolute;
        color: #FFF;
        font-size: 25px ;
        margin-top: -40px;
        z-index: 999999;
        text-align: right;
        width: 100%;
    }
    .modal-content iframe{
        width: 100%;
        height: 460px ;
    }
    .example-open .modal-backdrop {background-color:#000; opacity: 0.9!important;}
</style>

<div class="modal fade" id="tanitimvideosu" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document" id="yt-player" >
        <div class="modal-content "  >
            <div class="modal-times-icon">
                <a role="button"  data-dismiss="modal" aria-label="Close" style="cursor: pointer">
                    <i class="fa fa-times-circle"></i>
                </a>
            </div>
            <iframe src="https://www.youtube.com/embed/<?=$tanKod['video_kod']?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>
    </div>
</div>
<script type="text/javascript">
    $("#tanitimvideosu").on('hidden.bs.modal', function (e) {
        $("#tanitimvideosu iframe").attr("src", $("#tanitimvideosu iframe").attr("src"));
    });
    $('#tanitimvideosu').on('show.bs.modal', function (e) {
        $('body').addClass("example-open");
    }).on('hide.bs.modal', function (e) {
        $('body').removeClass("example-open");
    })
</script>
<!-- Modal -->