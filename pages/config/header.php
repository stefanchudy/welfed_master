<?php

$_cnf = array();
$_cnf[] = '<base href="' . ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/"/>';
$_cnf[] = '<meta charset="utf-8"/>';
$_cnf[] = '<meta http-equiv="X-UA-Compatible" content="IE=edge">';
$_cnf[] = '<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">';
// fav icon
$_cnf[] = '<link rel="icon" href="img/fav.png"/>';

$_cnf[] = '<link rel="stylesheet" href="style/bootstrap.min.css"/>';
$_cnf[] = '<link rel="stylesheet" href="style/fa/css/font-awesome.min.css" />';
//theme CSS
$_cnf[] = '<link rel="stylesheet" href="theme/plugins/magnific-popup/css/magnific-popup.css" />';
$_cnf[] = '<link rel="stylesheet" href="theme/plugins/swiper/css/swiper.css" />';
$_cnf[] = '<link rel="stylesheet" href="theme/plugins/youtube-player/css/YTPlayer.css" />';
$_cnf[] = '<link rel="stylesheet" href="theme/css/animate.min.css" />';
$_cnf[] = '<link rel="stylesheet" href="theme/css/ei-icon.css" />';
$_cnf[] = '<link rel="stylesheet" href="theme/css/main.css" />';
$_cnf[] = '<link rel="stylesheet" href="theme/css/colors/blue.css" />';


$_cnf[] = '<script src="js/jquery/jquery-2.1.4.min.js"></script>';
$_cnf[] = '<script src="js/bootstrap.min.js"></script>';

//$_cnf[] = '<link rel="stylesheet" href="style/animations.css" />';
$_cnf[] = '<link rel="stylesheet" href="style/bootstrap-social.css" />';

//theme css
$_cnf[] = '';
$_cnf[] = '';
$_cnf[] = '';
$_cnf[] = '';


$_cnf[] = '<link rel="stylesheet" href="style/style.css" />';

return $_cnf;
