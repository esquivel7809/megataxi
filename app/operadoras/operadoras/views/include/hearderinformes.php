<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <title><?php echo NOMBRE_APLICACION; ?></title>
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>css/reset.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>css/text.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>css/960.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>css/layout.css" media="screen" />
    <link rel="shortcut icon" type="image/x-icon" href="<?=base_url()?>img/favicon.ico" />
    <!--[if IE 6]><link rel="stylesheet" type="text/css" href="../../css/megataxi/ie6.css" media="screen" /><![endif]-->
    <!--[if IE 7]><link rel="stylesheet" type="text/css" href="../../css/megataxi/ie.css" media="screen" /><![endif]-->
    <script type="text/javascript" src="<?=base_url()?>js/jquery.js"></script>
</head>
<?php if($imprimir):?>
<body onLoad="print()">
<?php else:?>
<body>
<?php endif?>
    <div id="body">
