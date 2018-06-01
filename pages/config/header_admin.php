<?php

$_cnf = array();
$_cnf[] = '<base href="' . ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/"/>';
$_cnf[] = '<meta charset="utf-8"/>';
$_cnf[] = '<meta http-equiv="X-UA-Compatible" content="IE=edge">';
$_cnf[] = '<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no"/>';
$_cnf[] = '<link rel="icon" href="img/fav.png"/>';
$_cnf[] = '<link rel="stylesheet" href="style/bootstrap.min.css"/>';
$_cnf[] = '<link rel="stylesheet" href="style/fa/css/font-awesome.min.css" />';

$_cnf[] = '<script src="js/jquery/jquery-1.11.3.min.js"></script>';
$_cnf[] = '<script src="js/bootstrap.min.js"></script>';

$_cnf[] = '<link href="style/admin.css" rel="stylesheet">';
$_cnf[] = '<link href="style/metisMenu.min.css" rel="stylesheet">';

return $_cnf;
