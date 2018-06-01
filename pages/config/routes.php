<?php
//test
$_cnf = Array();
// Front
$_cnf['index'] = 'index';
// Admin pages
$_cnf['admin/dashboard'] = 'admin/dashboard';

$_cnf['admin/logout'] = 'admin/logout';

$_cnf['admin/general'] = 'admin/system/general';
$_cnf['admin/legal/food-recipient-agreement'] = 'admin/legal/legal';
$_cnf['admin/legal/food-donation-agreement'] = 'admin/legal/legal';
$_cnf['admin/legal/terms-of-website'] = 'admin/legal/legal';
$_cnf['admin/legal/privacy-policy'] = 'admin/legal/legal';
$_cnf['admin/legal/food-safety-and-hygiene'] = 'admin/legal/legal';

$_cnf['admin/administrators'] = 'admin/users/administrators';
$_cnf['admin/administrators/add'] = 'admin/users/administrators_add';
$_cnf['admin/administrators/edit'] = 'admin/users/administrators_edit';
$_cnf['admin/administrators/delete'] = 'admin/users/user_del';

$_cnf['admin/users'] = 'admin/users/users';
$_cnf['admin/users/add'] = 'admin/users/users_add';
$_cnf['admin/users/edit'] = 'admin/users/users_edit';
$_cnf['admin/users/delete'] = 'admin/users/user_del';
$_cnf['admin/users/upgrade'] = 'admin/users/user_upgrade';
$_cnf['admin/users/reject'] = 'admin/users/user_reject';
// admin->API
$_cnf['admin/remotelist'] = 'admin/remote/remotelist';
$_cnf['admin/remotelist/add'] = 'admin/remote/add';
$_cnf['admin/remotelist/edit'] = 'admin/remote/edit';
$_cnf['admin/remotelist/delete'] = 'admin/remote/delete';

$_cnf['admin/remote-log'] = 'admin/remote/log';
$_cnf['admin/remote-log/delete'] = 'admin/remote/delete_log';

// 2ndary data
$_cnf['admin/food-types']='admin/pages/food_types';
$_cnf['admin/location-types']='admin/pages/location_types';

// Admin pages -> System -> Messages
$_cnf['admin/messages'] = 'admin/system/messages';
$_cnf['admin/messages/read'] = 'admin/system/messages_read';
$_cnf['admin/messages/delete'] = 'admin/system/messages_del';
// Locations
$_cnf['admin/locations'] = 'admin/locations/locations';
$_cnf['admin/locations/add'] = 'admin/locations/locations_add';
$_cnf['admin/locations/edit'] = 'admin/locations/locations_edit';
$_cnf['admin/locations/verify'] = 'admin/locations/locations_verify';
$_cnf['admin/locations/delete'] = 'admin/locations/locations_delete';
// Donations
$_cnf['admin/donations'] = 'admin/donations/donations';
$_cnf['admin/donations/add'] = 'admin/donations/donations_add';
$_cnf['admin/donations/edit'] = 'admin/donations/donations_edit';
$_cnf['admin/donations/delete'] = 'admin/donations/donations_delete';
//booking
$_cnf['admin/booking/reset'] = 'admin/booking/reset';
$_cnf['admin/booking/delete'] = 'admin/booking/delete';
$_cnf['admin/booking/taken'] = 'admin/booking/taken';
//slider / working areas
$_cnf['admin/working-areas'] = 'admin/slider/slider';
$_cnf['admin/working-areas/add'] = 'admin/slider/slider_add';
$_cnf['admin/working-areas/edit'] = 'admin/slider/slider_edit';
$_cnf['admin/working-areas/del'] = 'admin/slider/slider_del';
//blog
$_cnf['admin/blog'] = 'admin/blog/index';
$_cnf['admin/blog/add'] = 'admin/blog/add';
$_cnf['admin/blog/edit'] = 'admin/blog/edit';
$_cnf['admin/blog/del'] = 'admin/blog/del';
// blog front
$_cnf['blog'] = 'front/blog/index';
$_cnf['blog/read'] = array(
    'table' => 'publications',
    'page' => 'front/blog/read',
    'index' => 'id',
    'param' => 'id',
    'field' => 'url'
);
$_cnf['blog/search'] = 'front/blog/search';
// Ajax 
$_cnf['ajax/get_locations'] = 'ajax/get_locations';
$_cnf['ajax/get_local_time'] = 'ajax/get_local_time';
$_cnf['ajax/search'] = 'ajax/search';
$_cnf['ajax/get_area_restrictions'] = 'ajax/get_area_restrictions';
//front
$_cnf['about'] = 'front/about';
$_cnf['contact'] = 'front/contact';
$_cnf['profile'] = 'front/profile';
$_cnf['search'] = 'front/search';
$_cnf['terms'] = 'front/terms';

$_cnf['locations/add'] = 'front/locations/locations_add';
$_cnf['locations/edit'] = 'front/locations/locations_edit';
$_cnf['locations/view'] = 'front/locations/locations_edit';

$_cnf['donations/add'] = 'front/donations/donations_add';
$_cnf['donations/edit'] = 'front/donations/donations_edit';
$_cnf['donations/delete'] = 'front/donations/donations_delete';
$_cnf['donations/delete_booking'] = 'front/donations/delete_booking';

$_cnf['food-recipient-agreement'] = 'front/legal/legal';
$_cnf['food-donation-agreement'] = 'front/legal/legal';
$_cnf['terms-of-website'] = 'front/legal/legal';
$_cnf['privacy-policy'] = 'front/legal/legal';
$_cnf['food-safety-and-hygiene'] = 'front/legal/legal';

$_cnf['forgotten_password'] = 'front/forgotten_password';

$_cnf['social-login'] = 'front/social_login';

//API CALLS
$_cnf['api/get_slides'] = 'api/getSlides';

// API -> Blog
$_cnf['api/get_blog_collection'] = 'api/blog/getCollection';
$_cnf['api/get_blog_post'] = 'api/blog/getPost';
$_cnf['api/get_blog_post_admin'] = 'api/blog/getPostAdmin';
$_cnf['api/search_blog'] = 'api/blog/search';
$_cnf['api/add_blog_post'] = 'api/blog/addPost';
$_cnf['api/update_blog_post'] = 'api/blog/updatePost';
$_cnf['api/set_post_image'] = 'api/blog/setImage';
$_cnf['api/del_blog_post'] = 'api/blog/delPost';

//API -> User
$_cnf['api/getuser_by_id'] = 'api/user/get_by_id';
$_cnf['api/login_user'] = 'api/user/login';
$_cnf['api/create_session'] = 'api/user/create_session';
$_cnf['api/check_session'] = 'api/user/check_session';
$_cnf['api/log_off'] = 'api/user/log_off';
$_cnf['api/add_user'] = 'api/user/add';
$_cnf['api/update_user'] = 'api/user/update';
$_cnf['api/delete_user'] = 'api/user/delete';
$_cnf['api/user_exists'] = 'api/user/exists';
$_cnf['api/upload_user_image'] = 'api/user/upload_image';

//API -> Users
$_cnf['api/users_get_collection'] = 'api/users/get_collection';

//API -> Foods
$_cnf['api/get_food_list'] = 'api/foods/get_list';
$_cnf['api/save_food_type'] = 'api/foods/save';
$_cnf['api/update_food_type'] = 'api/foods/update';
$_cnf['api/delete_food_type'] = 'api/foods/delete';

//API -> Location types
$_cnf['api/location_types_get'] = 'api/location_types/get';
$_cnf['api/location_types_add'] = 'api/location_types/add';
$_cnf['api/location_types_update'] = 'api/location_types/update';
$_cnf['api/location_types_delete'] = 'api/location_types/delete';

//API -> Locations
$_cnf['api/locations_getcollection'] = 'api/locations/get_collection';
$_cnf['api/locations_add'] = 'api/locations/add';
$_cnf['api/locations_update'] = 'api/locations/update';
$_cnf['api/locations_delete'] = 'api/locations/delete';
$_cnf['api/locations_upload_image'] = 'api/locations/upload_image';

//API -> Area Restrictions
$_cnf['api/get_area_restrictions'] = 'api/area_restriction/getCollection';
$_cnf['api/add_area_restrictions'] = 'api/area_restriction/add';
$_cnf['api/update_area_restrictions'] = 'api/area_restriction/update';
$_cnf['api/delete_area_restrictions'] = 'api/area_restriction/delete';
$_cnf['api/image_area_restrictions'] = 'api/area_restriction/uploadImage';

//API -> Donations
$_cnf['api/donations_getcollection'] = 'api/donations/get_collection';
$_cnf['api/donations_add'] = 'api/donations/add';
$_cnf['api/donations_update'] = 'api/donations/update';
$_cnf['api/donations_delete'] = 'api/donations/delete';
$_cnf['api/donations_reset'] = 'api/donations/reset';
$_cnf['api/donations_book'] = 'api/donations/book';
$_cnf['api/donations_unbook'] = 'api/donations/unbook';
$_cnf['api/donations_citylist'] = 'api/donations/citylist';
$_cnf['api/donations_search'] = 'api/donations/search';
//API -> Booking
$_cnf['api/booking_taken'] = 'api/booking/taken';
$_cnf['api/booking_reset'] = 'api/booking/reset';

//API -> Silders
$_cnf['api/sliders_getcollection'] = 'api/sliders/get_collection';

//API -> Dashboard / Admin
$_cnf['api/get_dashboard_data'] = 'api/admin/get_dashboard_data';
//API -> Test toen
$_cnf['api/test_token'] = 'api/test_token';

return $_cnf;