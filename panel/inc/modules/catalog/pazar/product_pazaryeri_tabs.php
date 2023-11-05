<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<style>
    .ssa:before{
        display: none;
    }
    .nav-link{
        color: #000;
        transition-duration: 0.1s; transition-timing-function: linear;
        font-size: 15px;
        padding: 15px;
    }
    .nav-link.active{
        font-weight: 500 !important;
    }
    .saas:hover{
        background-color: #fff;
        color: #000;
    }
    .ssa a{
        border-bottom: 1px solid #EBEBEB;
        padding: 5px !important;
        margin:0 !important;
        font-size: 14px ;
    }
    .ssa a:last-child{
        border-bottom: 0;
    }
    @media (max-width: 768px) {
        .nav-link{
            color: #000;
            transition-duration: 0.1s; transition-timing-function: linear;
            font-weight: 500;
            font-size: 14px;
            padding: 10px;
        }
        .nav-tabs{
            padding: 0 0 10px 0;
            display: none;
        }
        .nav-tabs li:first-child{
            margin-left: 0;
        }
        .nav-link.active{
            border-color: #dee2e6 #dee2e6 #dee2e6 !important;
            border-radius: 6px !important;
        }
        .scrolldiv{
            width: 100%;
            overflow-x: auto;
        }
        .nav-tabs-mobile-div{
            border-bottom: 1px solid #EBEBEB;
            display: flex !important;
            align-items: center;
            justify-content: space-between;
        }
        .nav-tabs-mobile-div-text{
            font-size: 16px ;
            font-weight: 600;
            border: 1px solid #EBEBEB;
            padding: 15px;
            margin-bottom:-1px ;
            border-bottom: 1px solid #FFF;
            border-radius: 4px 4px 0 0;
        }
        .nav-mobile-display{
            display: inline-block !important;
            width: 100%;
        }
        .buttonTextStyle{
            font-size: 14px !important; font-weight: 500;
        }
        .thumb:hover, .thumb:hover span img{
            width:280px;

        }

        .product_gallery_box{
            width: 45% !important;
            padding: 5px !important;
            text-align: center;
            margin-left: 5px !important;
            margin-right: 5px !important;
            margin-bottom: 5px !important;
            margin-top: 5px !important;
        }



    }
    #thumbwrap {
        position:relative;
    }
    .thumb span {
        position:absolute;
        visibility:hidden;
    }
    .thumb:hover, .thumb:hover span {
        visibility:visible;
        bottom:20px;
        right:0px;
        z-index:1;
    }


    .product_gallery_box{
       width: 23.3%;
        border: 1px solid #EBEBEB;
        box-sizing: border-box;
        padding: 15px;
        text-align: center;
        margin-left: 10px;
        margin-right: 10px;
        margin-bottom: 10px;
        margin-top: 10px;
        cursor: move;
        background-color: #fff;
        display: flex;
        align-items : center;
        justify-content: center;
        flex-wrap: wrap;
    }
    .product_gallery_box a{
        padding: 0 10px;
    }
    .product_gallery_box img{
        max-height: 200px;
        border: 1px solid #EBEBEB;
        max-width: 90%;
        padding: 2px ;
        background-color: #fff;
    }



    .nav-mobile-display{
        display: none;
    }


    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
        color: #fff;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
        color: #fff;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: #5985ee;
        border: 1px solid #5985ee;
        color: #fff !important;
        padding: 5px 8px;
    }
    .select2-container--default .select2-selection--multiple {
        border: 1px solid #ced4da;
    }

    .buttonTextStyle{
        font-size: 16px ; font-weight: 500;
        padding: 12px 10px;
    }
</style>

<!-- Mobile Nav !-->
<div class="nav-mobile-display">
    <div class="nav-tabs-mobile-div">
        <div class="nav-tabs-mobile-div-text">
            <?php if($currentTab == 'n11' ) { ?>
            <?=$diller['pazaryeri-text-2']?>
            <?php } ?>
            <?php if($currentTab == 'ty' ) { ?>
                <?=$diller['pazaryeri-text-89']?>
            <?php } ?>
        </div>
        <div class="nav-tabs-mobile-div-list">
            <div class="dropdown d-inline-block">
                <a href="" class="btn shadow-sm border" type="button" style="font-size: 13px ; " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                    <i class="fa fa-bars"></i> <?=$diller['adminpanel-form-text-1605']?>
                </a>
                <div class="dropdown-menu dropdown-menu-right ssa border p-3  " style="margin-top: 4px !important;">
                    <a href="pages.php?page=product_detail_entegration&productID=<?=$row['id']?>" class="dropdown-item cursor-pointer">
                        <div <?php if($currentTab == 'n11' ) { ?>style="font-weight: 600;"<?php }?>><?=$diller['pazaryeri-text-2']?></div>
                    </a>
                    <a href="pages.php?page=product_detail_entegration_ty&productID=<?=$row['id']?>" class="dropdown-item cursor-pointer">
                        <div <?php if($currentTab == 'ty' ) { ?>style="font-weight: 600;"<?php }?>><?=$diller['pazaryeri-text-89']?></div>
                    </a>
                    <a href="pages.php?page=product_detail_entegration_hb&productID=<?=$row['id']?>" class="dropdown-item cursor-pointer">
                        <div <?php if($currentTab == 'hb' ) { ?>style="font-weight: 600;"<?php }?>><?=$diller['pazaryeri-text-150']?></div>
                    </a>
                    <a href="pages.php?page=product_detail&productID=<?=$row['id']?>" class="dropdown-item cursor-pointer">
                        <div ><?=$diller['pazaryeri-text-7']?></div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!--  <========SON=========>>> Mobile Nav SON !-->
<!-- Tab Alanı !-->
<ul class="nav nav-tabs  pt-2" id="myTab" role="tablist">
    <li class="nav-item">
        <a class="nav-link saas <?php if($currentTab == 'n11' ) { ?> active<?php } ?>" href="pages.php?page=product_detail_entegration&productID=<?=$row['id']?>">
            <?=$diller['pazaryeri-text-2']?>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link saas <?php if($currentTab == 'ty' ) { ?> active<?php } ?>" href="pages.php?page=product_detail_entegration_ty&productID=<?=$row['id']?>">
            <?=$diller['pazaryeri-text-89']?>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link saas <?php if($currentTab == 'hb' ) { ?> active<?php } ?>" href="pages.php?page=product_detail_entegration_hb&productID=<?=$row['id']?>">
            <?=$diller['pazaryeri-text-150']?>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link saas" href="pages.php?page=product_detail&productID=<?=$row['id']?>">
            <?=$diller['pazaryeri-text-7']?>
        </a>
    </li>
</ul>
<!--  <========SON=========>>> Tab Alanı SON !-->

