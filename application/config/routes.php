<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
$route['default_controller'] = 'home';

$route['update/pre-cadastro'] = 'update';

$route['como-funciona'] = 'home/comoFunciona';

$route['user/perfil/editar'] = 'user/edit';
$route['user/update'] = 'user/update';
$route['user/termos-de-uso'] = 'user/termosdeuso';
$route['user/como-funciona'] = 'user/comofunciona';
$route['user/nova-solicitacao'] = 'solicitacao';
$route['user/nova-solicitacao/cadastro'] = 'solicitacao/register';
$route['user/contato'] = 'user/contact';
$route['user/painel'] = 'dashboard/user';
$route['user/solicitacao/(:num)'] = 'solicitacao/solicitacaoDetalhe/$1';
$route['user/solicitacao/update'] = 'solicitacao/update';
$route['user/painel/busca'] = 'dashboard/busca';
$route['user/painel/(:num)'] = 'dashboard/user';

$route['admin/perfil/editar'] = 'admin/edit';
$route['admin/update'] = 'admin/update';
$route['admin/lojistas'] = 'admin/lojistas';
$route['admin/usuarios'] = 'admin/users';
$route['admin/usuarios/cadastro'] = 'admin/userRegister';
$route['admin/painel'] = 'dashboard/admin';
$route['admin/solicitacao/(:num)'] = 'solicitacao/solicitacaoDetalhe/$1';
$route['admin/solicitacao/update'] = 'solicitacao/update';
$route['admin/painel/busca'] = 'dashboard/busca';
$route['admin/painel/(:num)'] = 'dashboard/admin';
$route['admin/usuarios/atualizar/(:num)'] = 'admin/userUpdateView';
$route['admin/usuarios/atualizar/senha/(:num)'] = 'admin/userUpdatePasswordView';
$route['admin/usuarios/atualizar/update'] = 'admin/userUpdate';
$route['admin/usuarios/atualizar/senha/update'] = 'admin/userPasswordUpdate';
$route['admin/relatorios'] = 'relatorios/index';
$route['admin/relatorios/pdf'] = 'relatorios/createPdf';
$route['admin/relatorios/getreport'] = 'relatorios/getResultFromReport';


$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['home/cadastro'] = "home/viewRegister";
$route['termos-de-uso'] = "home/viewTermos";
$route['registrar'] = "home/create";
$route['login'] = "home/login";
$route['logout'] = "home/logout";

$route['recuperar-senha'] = "home/viewRecover";
$route['recover'] = "home/passRecover"; 


