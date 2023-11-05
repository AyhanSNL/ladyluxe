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
            <?php if($currentTab == 'info' ) { ?>
            <?=$diller['adminpanel-form-text-1604']?>
            <?php } ?>
            <?php if($currentTab == 'price' ) { ?>
                <?=$diller['adminpanel-form-text-1607']?>
            <?php } ?>
            <?php if($currentTab == 'desc' ) { ?>
                <?=$diller['adminpanel-form-text-1608']?>
            <?php } ?>
            <?php if($currentTab == 'variant' ) { ?>
                <?=$diller['adminpanel-form-text-1610']?>
            <?php } ?>
            <?php if($currentTab == 'features' ) { ?>
                <?=$diller['adminpanel-form-text-1611']?>
            <?php } ?>
            <?php if($currentTab == 'gallery' ) { ?>
                <?=$diller['adminpanel-form-text-1612']?>
            <?php } ?>
            <?php if($currentTab == 'extra' ) { ?>
                <?=$diller['adminpanel-form-text-1609']?>
            <?php } ?>
            <?php if($currentTab == 'seo' ) { ?>
                <?=$diller['adminpanel-form-text-1606']?>
            <?php } ?>
            <?php if($currentTab == 'other' ) { ?>
                <?=$diller['adminpanel-form-text-1613']?>
            <?php } ?>
        </div>
        <div class="nav-tabs-mobile-div-list">
            <div class="dropdown d-inline-block">
                <a href="" class="btn shadow-sm border" type="button" style="font-size: 13px ; " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                    <i class="fa fa-bars"></i> <?=$diller['adminpanel-form-text-1605']?>
                </a>
                <div class="dropdown-menu dropdown-menu-right ssa border p-3  " style="margin-top: 4px !important;">
                    <a href="pages.php?page=product_detail&productID=<?=$row['id']?>" class="dropdown-item cursor-pointer">
                        <div <?php if($currentTab == 'info' ) { ?>style="font-weight: 600;"<?php }?>><?=$diller['adminpanel-form-text-1604']?></div>
                    </a>
                    <a href="pages.php?page=product_detail_price_shipping&productID=<?=$row['id']?>" class="dropdown-item cursor-pointer">
                        <div <?php if($currentTab == 'price' ) { ?>style="font-weight: 600;"<?php }?>><?=$diller['adminpanel-form-text-1607']?></div>
                    </a>
                    <a href="pages.php?page=product_detail_description&productID=<?=$row['id']?>" class="dropdown-item cursor-pointer">
                        <div <?php if($currentTab == 'desc' ) { ?>style="font-weight: 600;"<?php }?>><?=$diller['adminpanel-form-text-1608']?></div>
                    </a>
                    <a href="pages.php?page=product_detail_variant&productID=<?=$row['id']?>" class="dropdown-item cursor-pointer">
                        <div <?php if($currentTab == 'variant' ) { ?>style="font-weight: 600;"<?php }?>><?=$diller['adminpanel-form-text-1610']?></div>
                    </a>
                    <a href="pages.php?page=product_detail_features&productID=<?=$row['id']?>" class="dropdown-item cursor-pointer">
                        <div <?php if($currentTab == 'features' ) { ?>style="font-weight: 600;"<?php }?>><?=$diller['adminpanel-form-text-1611']?></div>
                    </a>
                    <a href="pages.php?page=product_detail_gallery&productID=<?=$row['id']?>" class="dropdown-item cursor-pointer">
                        <div <?php if($currentTab == 'gallery' ) { ?>style="font-weight: 600;"<?php }?>><?=$diller['adminpanel-form-text-1612']?></div>
                    </a>
                    <a href="pages.php?page=product_detail_extra&productID=<?=$row['id']?>" class="dropdown-item cursor-pointer">
                        <div <?php if($currentTab == 'extra' ) { ?>style="font-weight: 600;"<?php }?>><?=$diller['adminpanel-form-text-1609']?></div>
                    </a>
                    <a href="pages.php?page=product_detail_seo&productID=<?=$row['id']?>" class="dropdown-item cursor-pointer">
                        <div <?php if($currentTab == 'seo' ) { ?>style="font-weight: 600;"<?php }?>><?=$diller['adminpanel-form-text-1606']?></div>
                    </a>
                    <a href="pages.php?page=product_detail_other&productID=<?=$row['id']?>" class="dropdown-item cursor-pointer">
                        <div <?php if($currentTab == 'other' ) { ?>style="font-weight: 600;"<?php }?>><?=$diller['adminpanel-form-text-1613']?></div>
                    </a>
                    <a href="pages.php?page=product_detail_entegration&productID=<?=$row['id']?>" class="dropdown-item cursor-pointer">
                        <div <?php if($currentTab == 'other' ) { ?>style="font-weight: 600;"<?php }?>><?=$diller['pazaryeri-text-13']?></div>
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
        <a class="nav-link saas <?php if($currentTab == 'info' ) { ?> active<?php } ?>" href="pages.php?page=product_detail&productID=<?=$row['id']?>">
            <?=$diller['adminpanel-form-text-1604']?>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link saas <?php if($currentTab == 'price' ) { ?> active<?php } ?>" href="pages.php?page=product_detail_price_shipping&productID=<?=$row['id']?>">
            <?=$diller['adminpanel-form-text-1607']?>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link saas <?php if($currentTab == 'desc' ) { ?> active<?php } ?>" href="pages.php?page=product_detail_description&productID=<?=$row['id']?>">
            <?=$diller['adminpanel-form-text-1608']?>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link saas <?php if($currentTab == 'variant' ) { ?> active<?php } ?>" href="pages.php?page=product_detail_variant&productID=<?=$row['id']?>">
            <?=$diller['adminpanel-form-text-1610']?>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link saas <?php if($currentTab == 'features' ) { ?> active<?php } ?>" href="pages.php?page=product_detail_features&productID=<?=$row['id']?>">
            <?=$diller['adminpanel-form-text-1611']?>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link saas <?php if($currentTab == 'gallery' ) { ?> active<?php } ?>" href="pages.php?page=product_detail_gallery&productID=<?=$row['id']?>">
            <?=$diller['adminpanel-form-text-1612']?>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link saas <?php if($currentTab == 'extra' ) { ?> active<?php } ?>" href="pages.php?page=product_detail_extra&productID=<?=$row['id']?>">
            <?=$diller['adminpanel-form-text-1609']?>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link saas <?php if($currentTab == 'seo' ) { ?> active<?php } ?>" href="pages.php?page=product_detail_seo&productID=<?=$row['id']?>">
            <?=$diller['adminpanel-form-text-1606']?>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link saas <?php if($currentTab == 'other' ) { ?> active<?php } ?>" href="pages.php?page=product_detail_other&productID=<?=$row['id']?>">
            <?=$diller['adminpanel-form-text-1613']?>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link saas <?php if($currentTab == 'pazar' ) { ?> active<?php } ?>" href="pages.php?page=product_detail_entegration&productID=<?=$row['id']?>">
            <?=$diller['pazaryeri-text-13']?>
        </a>
    </li>
</ul>
<!--  <========SON=========>>> Tab Alanı SON !-->

