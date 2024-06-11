<!DOCTYPE html>
<html>

<head>
	<title>
        deu-StudySips <?=!empty($title)? ('-'.$title) : ''?>        
    </title>
	<meta charset="utf-8">
	<meta name="viewport" content="initial-scale=1.0,user-scalable=no,maximum-scale=1,width=device-width">
    <meta property="og:type" content="website">
    <meta property="og:image" content="http://deu-studysips.site/assets/image/og_image.png">
    <meta itemprop="image" content="http://deu-studysips.site/assets/image/og_image.png">

	<link rel="stylesheet" type="text/css" href="/assets/css/reset.css<?=$this->config->item('ver')?>">
	<link rel="stylesheet" type="text/css" href="/assets/css/animation.css<?=$this->config->item('ver')?>">
	<link rel="stylesheet" type="text/css" href="/assets/css/common.css<?=$this->config->item('ver')?>">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.min.css<?=$this->config->item('ver')?>"/>
	<link rel="stylesheet" type="text/css" href="/assets/css/bootstrap-3.3.2.min.css"/>	
       
	<script type="text/javascript" src="/assets/js/jquery-3.3.1.min.js"></script>
	<script type="text/javascript" src="/assets/js/bootstrap-3.3.2.min.js"></script>	
	<script type="text/javascript" src="/assets/js/sweetalert2.all.min.js<?=$this->config->item('ver')?>"></script>
	<script type="text/javascript" src="/assets/js/common.js<?=$this->config->item('ver')?>"></script>
	<script type="text/javascript" src="/assets/js/util.js<?=$this->config->item('ver')?>"></script>	
</head>

<body>	        
	<div class="mainWrap">
        <? if($isHeader){ ?>
            <div id="header">
                <?
                     $seg1 = $this->uri->segment(1, '');
                     $seg2 = $this->uri->segment(2, '');    
                ?>
                <a href="<?=($seg1 =='Mypage' && $seg2 == 'Information')? '/' : 'javascript:window.history.back();'?>">
                    <i class="fas fa-arrow-left"></i>
                </a>

                <p>
                    <? if($isShowTitle){ ?>
                        <?=$title?>
                    <? } ?>
                </p>
                <div></div>
            </div>
        <? } ?>
		