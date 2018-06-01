<?php

$_cnf = Array();

$_cnf['database'] = 'wellfed';
$_cnf['user'] = 'root';
$_cnf['pass'] = '';
$_cnf['host'] = 'localhost';

// if ($_SERVER['SERVER_ADDR'] == '127.0.0.1') {
//     $_cnf['database'] = 'wellfed';
//     $_cnf['user'] = 'root';
//     $_cnf['pass'] = '';
//     $_cnf['host'] = '127.0.0.1';
// } else {
// //    $_cnf['database'] = 'gmaccounting_wellfed';
// //    $_cnf['user'] = 'wellfed';
// //    $_cnf['pass'] = 'Bb324123';
// //    $_cnf['host'] = '127.0.0.1';
//     $_cnf['database'] = 'wellf-4we-u-139782';
//     $_cnf['user'] = 'wellf-4we-u-139782';
//     $_cnf['pass'] = 'MANutd08!';
//     $_cnf['host'] = '10.16.16.3';
// }

$_cnf['users_data'] = 'users_data';
$_cnf['users_data_key'] = 'user_id';

$_cnf['settings_table'] = 'settings';

return $_cnf;
