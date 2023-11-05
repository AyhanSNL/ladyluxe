<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>

<title>404 | <?php echo $ayar['site_baslik']?></title>
<link rel="stylesheet" href="assets/css/style.css" >
<style>
    body{
        background-color: #<?=$ayar['404_main_bg']?>;
        font-family : 'Open Sans',Sans-serif ;
    }
    .topIMG{
             max-width: 200px;
             max-height: 100px;
         }

    .main-div{
        width: 1100px;
        margin: 0 auto;
        display: flex;
        align-items:center;
        justify-content: center;
        flex-wrap: wrap;
        color: #<?=$ayar['404_text_color']?>;
        box-sizing: border-box;
        padding:30px 0
    }
    .notfound-img img{
        max-width: 500px;
        }
    .notfound-left{
        margin-right: 20px;
        width: 450px;
        color: #<?=$ayar['404_text_color']?>;
    <?php if($ayar['404_gorsel'] == null  ) {?>
        text-align: center;
    <?php } ?>
    }
    .notfound-left-h{
        font-size: 40px ;
        font-weight: bold;
    }
    .notfound-left-s{
        font-size: 16px ;
        font-weight: 600;
        margin-top: 15px;
        margin-bottom: 40px;
    }
    .notfound-header{
        width: 100%;
        box-sizing: border-box;
        padding: 20px;
        text-align: center;
        background-color: #<?=$ayar['404_head_bg']?>;
        border-bottom: 1px solid #<?=$ayar['404_header_border']?>;
    }

    @media screen and (max-width:410px) and (min-width:321px) {
        .main-div{
            width: 93%;
        }
        .notfound-img img{
            max-width: 100%;
            margin-top: 30px;
        }
    }
    @media screen and (max-width:321px) and (min-width:0px) {
        .main-div{
            width: 93%;
        }
        .notfound-img img{
            max-width: 100%;
            margin-top: 30px;
        }
    }
    @media screen and (max-width:767px) and (min-width:410px) {
        .main-div{
            width: 93%;
        }
        .notfound-img img{
            max-width: 100%;
            margin-top: 30px;
        }
    }
    @media screen and (max-width:1023px) and (min-width:767px) {
        .main-div{
            width: 93%;
        }
        .notfound-img img{
            max-width: 100%;
            margin-top: 30px;
        }
    }
</style>
</head>
<body>

<div class="notfound-header">
    <a href="<?=$ayar['site_url']?>">
        <img class="topIMG" src="images/logo/<?=$ayar['404_logo']?>" >
    </a>
</div>

<div class="main-div" >
    <div class="notfound-left">
        <div class="notfound-left-h" >
            <?=$diller['404-not-found-text1']?>
        </div>
        <div class="notfound-left-s">
            <?=$diller['404-not-found-text2']?>
        </div>
        <a href="<?=$ayar['site_url']?>" class="<?=$ayar['404_button']?> button-4x" style="text-decoration: none;">
            <?=$diller['404-not-found-text3']?>
        </a>
    </div>
    <?php if($ayar['404_gorsel'] == !null  ) {?>
        <div class="notfound-img">
            <img  src="images/uploads/<?=$ayar['404_gorsel']?>" >
        </div>
    <?php }?>
</div>

</body>






