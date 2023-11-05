<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<?php
$settings=$db->prepare("SELECT * from ayarlar where id='1'");
$settings->execute(array(0));
$ayar=$settings->fetch(PDO::FETCH_ASSOC);
$siteurl = $ayar['site_url'];
$commentSettings = $db->prepare("select * from modul_yorum_ayar where id=:id ");
$commentSettings->execute(array(
    'id' => '1'
));
$comset = $commentSettings->fetch(PDO::FETCH_ASSOC);
if(!empty($_POST["id"])){

    $UrunyorumListele = $db->prepare("select * from modul_yorum where id < ".$_POST['id']." and durum=:durum and icerik_id=:icerik_id and modul=:modul order by id desc");
    $UrunyorumListele->execute(array(
        'durum' => '1',
        'icerik_id' => $_POST['pro_id'],
        'modul' => 'blog',
    ));
    $totalRowCount = $UrunyorumListele->rowCount();


    $showLimit = $comset['yorumlimit'];


    $UrunyorumListele = $db->prepare("select * from modul_yorum where id < ".$_POST['id']." and durum=:durum and icerik_id=:icerik_id and modul=:modul order by id desc limit $showLimit");
    $UrunyorumListele->execute(array(
        'durum' => '1',
        'icerik_id' => $_POST['pro_id'],
        'modul' => 'blog',
    ));



    if($UrunyorumListele->rowCount() > 0){
       foreach ($UrunyorumListele as $yorum){
            $postID = 	$yorum['id'];
            $proID = $yorum['icerik_id'];

           $ipcek = $_SERVER["REMOTE_ADDR"];
           $likeCek = $db->prepare("select * from modul_yorum_begeni where yorum_id=:yorum_id and durum=:durum ");
           $likeCek->execute(array(
               'yorum_id' => $yorum['id'],
               'durum' => '0'
           ));

           $dislikeCek = $db->prepare("select * from modul_yorum_begeni where yorum_id=:yorum_id and durum=:durum ");
           $dislikeCek->execute(array(
               'yorum_id' => $yorum['id'],
               'durum' => '1'
           ));

           $begenilerS = $db->prepare("select * from modul_yorum_begeni where yorum_id=:yorum_id and ip_adres=:ip_adres order by id desc limit 1");
           $begenilerS->execute(array(
               'yorum_id' => $yorum['id'],
               'ip_adres' => $ipcek
           ));
           $begen = $begenilerS->fetch(PDO::FETCH_ASSOC);
            ?>
           <div class="module_comment_box_main">
               <div class="module_comment_in_box_div">
                   <?php if($comset['gorsel'] == !null && $comset['gorsel']>'0'  ) {?>
                       <div class="module_comment_box_img">
                           <img src="images/uploads/<?=$comset['gorsel']?>" alt="<?=$yorum['isim']?>">
                       </div>
                   <?php }?>
                   <div class="module_comment_box_right">
                       <div class="module_comment_box_head_area">
                           <div class="module_comment_box_name"><?=$yorum['isim']?></div>
                           <div class="module_comment_box_date"><?php echo date_tr('j F Y, H:i', ''.$yorum['tarih'].''); ?></div>
                       </div>
                       <div class="module_comment_box_content">
                           <?=$yorum['icerik']?>
                       </div>
                       <div class="module_comment_box_content" style="margin-top: 10px; padding-top: 10px; border-top: 1px solid #EBEBEB; font-size: 12px ;">

                           <?php if($begen['durum'] == '0' ) {?>
                               <a href="#" class="like-post" data-code="<?php echo $yorum['id']; ?>" style="color: green; font-weight: 700; text-decoration: none;">
                                   <i class="fa fa-thumbs-o-up"></i> <?=$diller['modul-yorum-begen']?> (<?=$likeCek->rowCount()?>)
                               </a>
                               <span style="width:20px; display: inline-block"></span>
                               <a href="#" class="like-dislike-post" data-code="<?php echo $yorum['id']; ?>" style="color: #666; font-weight: 600; text-decoration: none;">
                                   <i class="fa fa-thumbs-o-down"></i> <?=$diller['modul-yorum-begenme']?> (<?=$dislikeCek->rowCount()?>)
                               </a>
                           <?php }?>


                           <?php if($begen['durum'] == '1' ) {?>
                               <a href="#" class="dislike-like-post" data-code="<?php echo $yorum['id']; ?>" style="color: #666; font-weight: 600; text-decoration: none;">
                                   <i class="fa fa-thumbs-o-up"></i> <?=$diller['modul-yorum-begen']?> (<?=$likeCek->rowCount()?>)
                               </a>
                               <span style="width:20px; display: inline-block"></span>
                               <a href="#" class="dislike-post" data-code="<?php echo $yorum['id']; ?>" style="color: red; font-weight: 700; text-decoration: none;">
                                   <i class="fa fa-thumbs-o-down"></i> <?=$diller['modul-yorum-begenme']?> (<?=$dislikeCek->rowCount()?>)
                               </a>
                           <?php }?>


                           <?php if($begen['durum'] == null ) {?>
                               <a href="#" class="like-post" data-code="<?php echo $yorum['id']; ?>" style="color: #666; font-weight: 600; text-decoration: none;">
                                   <i class="fa fa-thumbs-o-up"></i> <?=$diller['modul-yorum-begen']?> (<?=$likeCek->rowCount()?>)
                               </a>
                               <span style="width:20px; display: inline-block"></span>
                               <a href="#" class="dislike-post" data-code="<?php echo $yorum['id']; ?>" style="color: #666; font-weight: 600; text-decoration: none;">
                                   <i class="fa fa-thumbs-o-down"></i> <?=$diller['modul-yorum-begenme']?> (<?=$dislikeCek->rowCount()?>)
                               </a>
                           <?php }?>
                       </div>
                   </div>
               </div>
           </div>
        <?php } ?>
        <?php if($totalRowCount > $showLimit){ ?>
            <div class="blogcomment-show-more-button " id="blogcomment-show-more-button<?php echo $postID; ?>">
                <span id="<?php echo $postID; ?>" data-id="<?=$proID?>" class="blogcomment-showmorespan <?=$comset['tumu_button_bg']?>" >+ <?=$diller['modul-tum-yorumlar-yazisi-alt']?></span>
                <span class="blogcomment_loding" style="display: none;"><span class="blogcomment_loding_txt"><?=$diller['modul-tum-yorumlar-wait']?></span></span>
            </div>
        <?php }else { ?>
            <div class="<?=$comset['tumu_button_bg']?> button-2x" style="width: 100%; text-align: center;  ">
                <?=$diller['modul-tum-yorumlar-yazisi-alt-son']?>
            </div>
        <?php }?>
        <?php
    }
}else{
    header('Location:'.$siteurl.'404');
}
?>


<script>
    $(function(){
        $('.like-post').click(function(){
            var elem = $(this);
            $.ajax({
                type: "GET",
                url: "includes/func/like_post.php",
                data: "begen_id="+elem.attr('data-code'),
                dataType:"json",
                success: function(data) {

                    setTimeout(function(){// wait for 5 secs(2)
                        location.reload(); // then reload the page.(3)
                    }, 0);

                }
            });
            return false;
        });
    });

    $(function(){
        $('.dislike-post').click(function(){
            var elem = $(this);
            $.ajax({
                type: "GET",
                url: "includes/func/like_post.php",
                data: "disbegen_id="+elem.attr('data-code'),
                dataType:"json",
                success: function(data) {

                    setTimeout(function(){// wait for 5 secs(2)
                        location.reload(); // then reload the page.(3)
                    }, 0);

                }
            });
            return false;
        });
    });

    $(function(){
        $('.like-dislike-post').click(function(){
            var elem = $(this);
            $.ajax({
                type: "GET",
                url: "includes/func/like_post.php",
                data: "likedislike_id="+elem.attr('data-code'),
                dataType:"json",
                success: function(data) {

                    setTimeout(function(){// wait for 5 secs(2)
                        location.reload(); // then reload the page.(3)
                    }, 0);

                }
            });
            return false;
        });
    });

    $(function(){
        $('.dislike-like-post').click(function(){
            var elem = $(this);
            $.ajax({
                type: "GET",
                url: "includes/func/like_post.php",
                data: "dislikelike_id="+elem.attr('data-code'),
                dataType:"json",
                success: function(data) {

                    setTimeout(function(){// wait for 5 secs(2)
                        location.reload(); // then reload the page.(3)
                    }, 0);

                }
            });
            return false;
        });
    });
</script>
