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

    $routes->post('lugar_turistico/changevisiblelugarturistico/(:num)', 'LugarTuristico::changeVisibleLugarTuristico/$1');

    


    //Listado Visibles y No visibles para Admin
    $routes->get('lugar_turistico/json_getlistadoall', 'LugarTuristico::getjson_ListadoLugares/2');

    //Lista de Solicitues, según el rol extra tipo de SOlicitudes Todas o de un Propietario específico
    $routes->get('solicitud/json_listado', 'SolicitudActualizacion::getjson_ListadoSolicitudes');
    
    $routes->get('solicitud/view_add', 'SolicitudActualizacion::viewAdd');
    $routes->get('solicitud/vista_listado', 'SolicitudActualizacion::viewListado');
    $routes->get('solicitud/vista_listado_admin', 'SolicitudActualizacion::viewListadoAdmin');
    $routes->post('solicitud/create', 'SolicitudActualizacion::insertSolicitud');
    $routes->post('solicitud/delete/(:num)', 'SolicitudActualizacion::deleteSolicitud/$1');
    $routes->get('solicitud/vista_editar/(:num)', 'SolicitudActualizacion::viewEditSolicitud/$1');
    $routes->post('solicitud/update/(:num)', 'SolicitudActualizacion::updateSolicitud/$1');
    $routes->post('solicitud/solicitarTramite/(:num)', 'SolicitudActualizacion::cambiarAEstadoSolicitado_Sol/$1');
    
  
    $routes->get('solicitud/view_details/(:num)', 'SolicitudActualizacion::viewDetails/$1');
    $routes->get('solicitud/view_detailsadmin/(:num)', 'SolicitudActualizacion::viewDetailsAdmin/$1');
    $routes->get('solicitud/getlistadocamposactcb', 'SolicitudActualizacion::getjson_ListadoCamposActualizacion/');
    

   

    $routes->get('lugar_turistico/campo/(:num)', 'LugarTuristico::getCampoValue/$1');
    $routes->get('lugar_turistico/getinfolugar/(:num)', 'LugarTuristico::getInfoLugar/$1');

    $routes->post('solicitud/create_details_campos', 'SolicitudActualizacion::insertDetalleSolicitudCampos');
    $routes->post('solicitud/create_details_coordenadas', 'SolicitudActualizacion::insertDetalleSolicitudCoordenads');
    $routes->post('solicitud/create_details_logo', 'SolicitudActualizacion::insertDetalleSolicitudLogo');
    $routes->post('solicitud/create_details_gif', 'SolicitudActualizacion::insertDetalleSolicitudGif');
    
    
    
    $routes->post('solicitud/update_details', 'SolicitudActualizacion::updateDetalleSolicitudEstado');

    $routes->post('solicitud/delete_details/(:num)', 'SolicitudActualizacion::deleteSolicitud_detalle/$1');

    $routes->get('solicitud/getlistadocamposdetails/(:num)', 'SolicitudActualizacion::getjson_ListadoDetalleCampos/$1');
    
    $routes->get('solicitud/getcoordenadasdetails/(:num)', 'SolicitudActualizacion::getjson_CoordenadasDelaSolicitud/$1');   
    
    

 });

    
    
    $routes->get('login', 'Login::index');
    $routes->post('login', 'Usuario::login');
    $routes->get('logout', 'Usuario::logout');
    $routes->post('login/seleccionarlugar', 'Usuario::seleccionarLugar');
    
    $routes->get('privacy/v1', 'Usuario::privacy');
    $routes->get('unauthorized', 'Errors::unauthorized');


    //API Públicas
    $routes->get('categoria/getlistadoCB', 'Categoria::getjson_ListadoCategorias/');
    $routes->get('subcategoria/getlistadoCB/(:num)', 'SubCategoria::getjson_ListadoSubCategoriasCB/$1');
    $routes->get('categoria/json_getlistado', 'Categoria::getjson_ListadoCategorias/data');
    $routes->get('subcategoria/json_getlistado', 'SubCategoria::getjson_ListadoSubCategorias');
    
    
   //Vista Grid Pública
    $routes->get('/', 'LugarTuristico::lista_grid_public');
    $routes->get('mapa', 'LugarTuristico::viewMapa_public'); //Retorna >Vista
    $routes->get('mapa', 'LugarTuristico::viewMapaPublic');  //Retorna Resp AJAX  

    $routes->get('lugar_turistico/vista_lista_public', 'LugarTuristico::viewLugarTuristicoGrid/0/0/1');
    $routes->get('lugar_turistico/vista_lista_public/(:num)', 'LugarTuristico::viewLugarTuristicoGrid/$1/0/1');
    $routes->get('lugar_turistico/vista_lista_public/(:num)/(:num)', 'LugarTuristico::viewLugarTuristicoGrid/$1/$2/1');
    $routes->get('lugar_turistico/vista_modal/(:num)', 'LugarTuristico::viewVistaModalLugarTuristico/$1');

    //API Públicas de Lugares
    $routes->get('lugar_turistico/json_getlistado', 'LugarTuristico::getjson_ListadoLugares/1');
    $routes->get('lugar_turistico/json_getlistadoGrid/(:num)/(:num)', 'LugarTuristico::getjson_ListadoLugaresGrid/$1/$2/1');
    $routes->get('lugar_turistico/json_getlistadoGrid', 'LugarTuristico::getjson_ListadoLugaresGrid/0/0/1');
    $routes->get('lugar_turistico/json_getlistadoAbrev', 'LugarTuristico::getjson_ListadoLugaresOpenAI/0/0');
    $routes->get('lugar_turistico/json_getlistadoGridLT', 'LugarTuristico::getjson_ListadoLugaresGrid/0/0/1');
    $routes->get('lugar_turistico/json_getlistadoGridLT/(:num)', 'LugarTuristico::getjson_ListadoLugaresGrid/$1/0/1');
    $routes->get('lugar_turistico/json_getlistadoGridLT/(:num)/(:num)', 'LugarTuristico::getjson_ListadoLugaresGrid/$1/$2/1');
    $routes->get('lugar_turistico/json_getlistadoMapa', 'LugarTuristico::getjson_ListadoLugaresCercanos/1');
    
 

    


    