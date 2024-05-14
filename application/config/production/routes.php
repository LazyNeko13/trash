<?php

defined('BASEPATH') or exit('No direct script access allowed');



/*

| -------------------------------------------------------------------------

| URI ROUTING

| -------------------------------------------------------------------------

| This file lets you re-map URI requests to specific controller functions.

|

| Typically there is a one-to-one relationship between a URL string

| and its corresponding controller class/method. The segments in a

| URL normally follow this pattern:

|

|	example.com/class/method/id/

|

| In some instances, however, you may want to remap this relationship

| so that a different class/function is called than the one

| corresponding to the URL.

|

| Please see the user guide for complete details:

|

|	https://codeigniter.com/user_guide/general/routing.html

|

| -------------------------------------------------------------------------

| RESERVED ROUTES

| -------------------------------------------------------------------------

|

| There are three reserved routes:

|

|	$route['default_controller'] = 'welcome';

|

| This route indicates which controller class should be loaded if the

| URI contains no data. In the above example, the "welcome" class

| would be loaded.

|

|	$route['404_override'] = 'errors/page_missing';

|

| This route will tell the Router which controller/method to use if those

| provided in the URL cannot be matched to a valid route.

|

|	$route['translate_uri_dashes'] = FALSE;

|

| This is not exactly a route, but allows you to automatically route

| controller and method names that contain dashes. '-' isn't a valid

| class or method name character, so it requires translation.

| When you set this option to TRUE, it will replace ALL dashes in the

| controller and method URI segments.

|

| Examples:	my-controller/index	-> my_controller/index

|		my-controller/my-method	-> my_controller/my_method

*/

require_once(BASEPATH .'database/DB'. EXT);
// $db =& DB();
// var_dump($db);die;
// $query = $db->get("cms_halaman WHERE can_delete = 'Y' AND deleted = 'N' AND block = 'N'");
// $result = $query->result();
// // echo"<pre>";print_r($result);exit;
// foreach( $result as $row )
// {
//     $route[$row->link]                 = 'guest/controller_ctl/page/'.$row->id_halaman;
//     $route['cms/'.$row->link]          = 'cms/controller_ctl/pengaturan/'.$row->id_halaman;
// }

// AUTH PAGE
$route['auth']  = 'auth/controller_ctl';

$route['auth/(:any)'] = 'auth/controller_ctl/$1';

$route['auth/(:any)/(:any)'] = 'auth/controller_ctl/$1/$2';

$route['login'] = 'auth/controller_ctl/base/login';

$route['logout'] = 'auth/controller_ctl/logout';

$route['register'] = 'auth/controller_ctl/base/register';

$route['func_auth']  = 'auth/function_ctl';

$route['func_auth/(:any)'] = 'auth/function_ctl/$1';

$route['func_auth/(:any)/(:any)'] = 'auth/function_ctl/$1/$2';



if (in_array($_SESSION['trash_id_role'],[1,2])) {
    $route['dashboard']  = 'dashboard/controller_ctl';

    $route['dashboard/(:any)'] = 'dashboard/controller_ctl/$1';

    $route['dashboard/(:any)/(:any)'] = 'dashboard/controller_ctl/$1/$2';

}else{
    $route['dashboard']  = 'dashboard/controller_ctl/penukaran';

    $route['dashboard/(:any)'] = 'dashboard/controller_ctl/penukaran/$1';

    $route['dashboard/(:any)/(:any)'] = 'dashboard/controller_ctl/penukaran/$1/$2';
}

$route['penukaran']  = 'dashboard/controller_ctl/penukaran';

$route['penukaran/(:any)'] = 'dashboard/controller_ctl/penukaran/$1';

$route['penukaran/(:any)/(:any)'] = 'dashboard/controller_ctl/penukaran/$1/$2';


$route['dashboard_function']  = 'dashboard/function_ctl';

$route['dashboard_function/(:any)'] = 'dashboard/function_ctl/$1';

$route['dashboard_function/(:any)/(:any)'] = 'dashboard/function_ctl/$1/$2';




$route['master']  = 'master/controller_ctl';

$route['master/(:any)'] = 'master/controller_ctl/$1';

$route['master/(:any)/(:any)'] = 'master/controller_ctl/$1/$2';

$route['master_function']  = 'master/function_ctl';

$route['master_function/(:any)'] = 'master/function_ctl/$1';

$route['master_function/(:any)/(:any)'] = 'master/function_ctl/$1/$2';



$route['report']  = 'report/controller_ctl';

$route['report/(:any)'] = 'report/controller_ctl/$1';

$route['report/(:any)/(:any)'] = 'report/controller_ctl/$1/$2';

// DEFAULT PAGE
$route['default_controller'] = 'auth/controller_ctl';


// MANIPULASI LINK

$route['404_override'] = '';


$route['translate_uri_dashes'] = TRUE;
