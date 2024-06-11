<!DOCTYPE html>
<html>

<head>
	<title>        
        deu-StudySips
        
        <? if($title){ ?>
        - <?=$title?>
        <? } ?>
    </title>
	<meta charset="utf-8">
	<meta name="viewport" content="initial-scale=1.0,user-scalable=no,maximum-scale=1,width=device-width">
    <meta property="og:type" content="website">
    <meta property="og:image" content="http://deu-studysips.site/assets/image/og_image.png">
    <meta itemprop="image" content="http://deu-studysips.site/assets/image/og_image.png">

	<link rel="stylesheet" type="text/css" href="/assets/css/reset.css<?=$this->config->item('ver')?>">
	<link rel="stylesheet" type="text/css" href="/assets/css/animation.css<?=$this->config->item('ver')?>">
	<link rel="stylesheet" type="text/css" href="/assets/css/admin.css<?=$this->config->item('ver')?>">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.min.css<?=$this->config->item('ver')?>"/>
	<link rel="stylesheet" type="text/css" href="/assets/css/bootstrap-3.3.2.min.css"/>	
       
	<script type="text/javascript" src="/assets/js/jquery-3.3.1.min.js"></script>
	<script type="text/javascript" src="/assets/js/bootstrap-3.3.2.min.js"></script>	
	<script type="text/javascript" src="/assets/js/sweetalert2.all.min.js<?=$this->config->item('ver')?>"></script>
	<script type="text/javascript" src="/assets/js/admin.js<?=$this->config->item('ver')?>"></script>
	<script type="text/javascript" src="/assets/js/util.js<?=$this->config->item('ver')?>"></script>
</head>

<body>
    <div class="adminWrap">
        <div class="sideWrap">
            <img class="logo" src="/assets/image/logo.png">
            
            <p class="title">MENU</p>
            <a>
                <i class="fas fa-cookie-bite"></i>
                메뉴관리
            </a>
            <a>
                <i class="fas fa-desktop"></i>
                정산관리
            </a>
            <a>
                <i class="fas fa-shopping-cart"></i>
                결제내역
            </a>
            <a class="active" href="/AdmSeatInsert/SeatManagement">
                <i class="fas fa-chair"></i>
                좌석관리
            </a>
            
            <a href="/logout">
                <i class="fas fa-sign-out-alt"></i>
                로그아웃
            </a>
            <p class="foot">SoftWare Engineering A5</p>
        </div>
        <div class="mainWrap">
        