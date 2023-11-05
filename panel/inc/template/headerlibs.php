<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<!-- App Icons -->
<link rel="shortcut icon" href="<?php echo $ayar['site_url'] ?>images/<?php echo $ayar['site_favicon']; ?>">


<!-- App css -->
<link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link rel='stylesheet' href='https://cdn.jsdelivr.net/bootstrap.tagsinput/0.8.0/bootstrap-tagsinput.css'>
<link href="assets/css/icons.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="../assets/css/line-awesome/css/line-awesome.min.css">
<link href="assets/css/style.css" rel="stylesheet" type="text/css" />
<link href="plugins/select/select2.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="../assets/css/flag/flag-icon.css" >
<link href="plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,400i,500,500i,700,700i&amp;subset=latin-ext" />
<!-- Date Picker !-->
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.css">
<!--  <========SON=========>>> Date Picker SON !-->
<link href="plugins/alertify/css/alertify.css" rel="stylesheet" type="text/css">
<style>
    /* Blur Modal */
    .modal-header .close {
        padding: 1rem 1rem;
    }
    .modal-content{border-radius: 0 !important;
        border:0 !important;
        overflow: hidden !important;
    }
    .modal-backdrop {background-color:#000; opacity: 0.5!important;}
    body.modal-open .panel-home-main-div{
        -webkit-filter: blur(4px);
        -moz-filter: blur(4px);
        -o-filter: blur(4px);
        -ms-filter: blur(4px);
        filter: blur(4px);
        filter: url("https://gist.githubusercontent.com/amitabhaghosh197/b7865b409e835b5a43b5/raw/1a255b551091924971e7dee8935fd38a7fdf7311/blur".svg#blur);
        filter:progid:DXImageTransform.Microsoft.Blur(PixelRadius='4');
    }
    /*  <========SON=========>>> Blur Modal SON */

    /* File upload Custom */
    .custom-file-label{
        line-height:1.9 !important;
    }
    .custom-file-input ~ .custom-file-label::after {
        content: "<?=$diller['adminpanel-text-145']?>" !important;
        line-height: 1.9;
    }
    /*  <========SON=========>>> File upload Custom SON */

    /* Switch Color */
    .custom-control-input:checked~.custom-control-label::before {
        color: #fff;
        border-color: #44B571 !important;
        background-color: #44B571;


        /*border-color: #5985ee !important;*/
        /*background-color: #5985ee;*/
    }
    /*  <========SON=========>>> Switch Color SON */

    /* Sticky Leftbar */
    #sidebar.fixed {
        position: fixed;
        width: 298px;
        <?php if($panelayar['fixed_header'] == '1'  ) {?>
        top:80px
    <?php }else { ?>
        top:10px;
        <?php }?>
    }
    #sidebar {
        position: absolute;
    }
    /*  <========SON=========>>> Sticky Leftbar SON */
    .select2,.select2-results__option{
        font-family: 'fontAwesome', Sans-serif  !important; font-size:13px;
    }
</style>
<script src="assets/js/jquery.min.js"></script>
<!-- Sortable !-->
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"  integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="        crossorigin="anonymous"></script>
<!--  <========SON=========>>> Sortable SON !-->
<link rel="stylesheet" href="plugins/codemirror/codemirror.css">
<script src="plugins/codemirror/codemirror.js"></script>
<script src="plugins/codemirror/mode/xml/xml.js"></script>
<script src="plugins/codemirror/active-line.js"></script>
<style>
    .CodeMirror {border-top: 1px solid black; border-bottom: 1px solid black;}
</style>
