<?php

use CodeIgniter\Router\RouteCollection;


/**
 * @var RouteCollection $routes
 */

 $routes->group('',['filter' => 'AuthCheck'], function ($routes) {
    
   $routes->get('panel', 'Home::panel');

    $routes->get('categoria/vista_listado', 'Categoria::listado');
    $routes->get('categoria/vista_editar/(:num)', 'Categoria::viewEditCategoria/$1');
    $routes->get('categoria/vista_agregar', 'Categoria::viewAddCategoria');
    $routes->post('categoria/update/(:num)', 'Categoria::updateCategoria/$1');
    $routes->post('categoria/delete/(:num)', 'Categoria::deleteCategoria/$1');
    $routes->post('categoria/create', 'Categoria::insertCategoria');


    $routes->get('subcategoria/vista_listado', 'SubCategoria::listado');
    $routes->get('subcategoria/vista_editar/(:num)', 'SubCategoria::viewEditSubCategoria/$1');
    $routes->get('subcategoria/vista_agregar', 'SubCategoria::viewAddSubCategoria');
    $routes->post('subcategoria/update/(:num)', 'SubCategoria::updateSubCategoria/$1');
    $routes->post('subcategoria/delete/(:num)', 'SubCategoria::deleteSubCategoria/$1');
    $routes->post('subcategoria/create', 'SubCategoria::insertSubCategoria');

    $routes->get('lugar_turistico/vista_listado', 'LugarTuristico::listado');
    $routes->get('lugar_turistico/vista_grid', 'LugarTuristico::lista_grid');

   //Vista Grid Privada Admin
    $routes->get('lugar_turistico/vista_lista', 'LugarTuristico::viewLugarTuristicoGrid/0/0/0');
    $routes->get('lugar_turistico/vista_lista/(:num)', 'LugarTuristico::viewLugarTuristicoGrid/$1/0/0');
    $routes->get('lugar_turistico/vista_lista/(:num)/(:num)', 'LugarTuristico::viewLugarTuristicoGrid/$1/$2/0');

    $routes->get('lugar_turistico/vista_agregar', 'LugarTuristico::viewAddLugarTuristico');
    $routes->get('lugar_turistico/vista_editar/(:num)', 'LugarTuristico::viewEditLugarTuristico/$1');
    $routes->post('lugar_turistico/create', 'LugarTuristico::insertLugarTuristico');
    $routes->post('lugar_turistico/delete/(:num)', 'LugarTuristico::deleteLugarTuristico/$1');
    $routes->post('lugar_turistico/update/(:num)', 'LugarTuristico::updateLugarTuristico/$1');


 });

    
 
    $routes->get('login', 'Login::index');
    $routes->post('login', 'Usuario::login');
    $routes->get('logout', 'Usuario::logout');

    $routes->get('privacy/v1', 'Usuario::privacy');
    

    $routes->get('categoria/getlistadoCB', 'Categoria::getjson_ListadoCategorias/');
    $routes->get('subcategoria/getlistadoCB/(:num)', 'SubCategoria::getjson_ListadoSubCategoriasCB/$1');
    $routes->get('categoria/json_getlistado', 'Categoria::getjson_ListadoCategorias/data');
    $routes->get('subcategoria/json_getlistado', 'SubCategoria::getjson_ListadoSubCategorias');
    $routes->get('lugar_turistico/json_getlistado', 'LugarTuristico::getjson_ListadoLugares');
    $routes->get('lugar_turistico/json_getlistadoGrid/(:num)/(:num)', 'LugarTuristico::getjson_ListadoLugaresGrid/$1/$2');


   //Vista Grid Pública
    $routes->get('/', 'LugarTuristico::lista_grid_public');
    $routes->get('mapa', 'LugarTuristico::viewMapa_public');
    $routes->get('lugar_turistico/vista_lista_public', 'LugarTuristico::viewLugarTuristicoGrid/0/0/1');
    $routes->get('lugar_turistico/vista_lista_public/(:num)', 'LugarTuristico::viewLugarTuristicoGrid/$1/0/1');
    $routes->get('lugar_turistico/vista_lista_public/(:num)/(:num)', 'LugarTuristico::viewLugarTuristicoGrid/$1/$2/1');

    $routes->get('lugar_turistico/vista_modal/(:num)', 'LugarTuristico::viewVistaModalLugarTuristico/$1');

    $routes->get('lugar_turistico/json_getlistadoGrid', 'LugarTuristico::getjson_ListadoLugaresGrid/0/0');
    $routes->get('lugar_turistico/json_getlistadoAbrev', 'LugarTuristico::getjson_ListadoLugaresOpenAI/0/0');
    $routes->get('lugar_turistico/json_getlistadoGridLT', 'LugarTuristico::getjson_ListadoLugaresGrid/0/0');
    $routes->get('lugar_turistico/json_getlistadoGridLT/(:num)', 'LugarTuristico::getjson_ListadoLugaresGrid/$1/0');
    $routes->get('lugar_turistico/json_getlistadoGridLT/(:num)/(:num)', 'LugarTuristico::getjson_ListadoLugaresGrid/$1/$2');

    $routes->get('lugar_turistico/json_getlistadoMapa', 'LugarTuristico::getjson_ListadoLugaresCercanos');
    
    $routes->get('mapa', 'LugarTuristico::viewMapaPublic');    

