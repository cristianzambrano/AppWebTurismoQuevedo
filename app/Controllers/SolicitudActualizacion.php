<?php

namespace App\Controllers;

use App\Models\solicitud_actualizacion_model;
use App\Models\detalle_solic_act_model;
use App\Models\lugarturistico_model;


use CodeIgniter\HTTP\ResponseInterface;

class SolicitudActualizacion extends BaseController
{

     ///////////////Rutas//////////////
    public function index(): string
    {
        return view('categoria/listado');
    }

    public function viewListado(): string
    {
        return view('solicitud/listado');
    }

    public function viewListadoAdmin(): string
    {
        return view('solicitud/listado_admin');
    }

    public function viewAdd(): string
    {
        return view('solicitud/add');
    }

    public function viewDetails($solicitudId): string
    {

        $solicitudModel = new solicitud_actualizacion_model();
        $solicitud = $solicitudModel->getSolicitudById($solicitudId);

        if (!$solicitud) {
            return "Solicitud no encontrada";
        }else{
            return view('solicitud/details', ['solicitud' => $solicitud]);
        }

    }

    public function viewDetailsAdmin($solicitudId): string
    {

        $solicitudModel = new solicitud_actualizacion_model();
        $solicitud = $solicitudModel->getSolicitudById($solicitudId);

        if (!$solicitud) {
            return "Solicitud no encontrada";
        }else{
            return view('solicitud/detailsadmin', ['solicitud' => $solicitud]);
        }

    }

    public function viewEditSolicitud($IDS): string
    {
        if(is_numeric($IDS)){
            $model = new solicitud_actualizacion_model();
            $datos = $model->getSolicitud($IDS);
            if($datos){ 
                return view('solicitud/edit', $datos);
            }
            else{
                  echo "Solicitud No existe";
           }
       } else echo "Error en Parámetros";
      
    }

    ///////////// JSON /////////////////////////
    public function getjson_ListadoSolicitudes() {
        $model = new solicitud_actualizacion_model();
        if(session()->get('rol')=='propietario_local'){
            //Del prpietario y lugar loggeado
            $datos = $model->getListado(session()->get('user_id')); 
        }else{
            $datos = $model->getListado(0);
        }
        if ($datos) 
            echo json_encode($datos);
    
    }

    public function getjson_ListadoDetalleCampos($idsol) {

        $model = new detalle_solic_act_model();
        $datos = $model->getListadoDetallesCampos($idsol);
        if ($datos) 
            echo json_encode($datos);
    
    }

    public function getjson_ListadoCamposActualizacion($ArrayName) {
        $model = new solicitud_actualizacion_model();
        $datos = $model->getListadoCampos_Actualizacion();
        if ($datos) 
            if($ArrayName!="")
                 echo json_encode([$ArrayName => $datos]);
            else
                 echo json_encode($datos);
    
    }


    public function getjson_CoordenadasDelaSolicitud($IDSol) {
        $model = new detalle_solic_act_model();
        $existingRecord = $model->where('idcampo', -1)
                     ->where('idsolicitud', $IDSol)
                     ->first();
        if ($existingRecord) {
            echo json_encode(['datos' => $existingRecord]);
        } else {
            echo json_encode(['datos' => '']);
        }

    }


    public function insertSolicitud()
    {
        $input = $this->getRequestInput($this->request);

        $rules = [
            'descripcion' => [
                'rules'  => 'required|max_length[500]',
                'errors' => ['required' => 'Descripción de la Solicitud requerida'],
            ]
        ];


        if (!$this->validateRequest($input, $rules))
            return $this->sendResponse(['validaciones' => $this->getErrorsAsArray($this->validator->getErrors())], ResponseInterface::HTTP_BAD_REQUEST);

        try {
            $model = new solicitud_actualizacion_model();
            $model->insert($input);
            return $this->sendResponse(['message' => 'Solicitud creada correctamente. ID: ' . $model->getInsertID()]);
        } catch (Exception $e) {
            return $this->sendResponse(['error' => $e->getMessage()], ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function updateSolicitud($id)
    {
        if (!isset($id))         return $this->sendBadRequest('Parámetro ID requerido');
        if (!is_numeric($id))    return $this->sendBadRequest('Parámetro ID numérico');
        if ($id < 1)             return $this->sendBadRequest('Parámetro ID numérico mayor a 0');

        $input = $this->getRequestInput($this->request);

        $model = new solicitud_actualizacion_model();
        $solicitud = $model->findById($id); 
        if(!$solicitud) return $this->sendBadRequest("Solicitud a actualizar No existe");
        if($solicitud['idusuarioreg'] != session()->get('user_id')) return $this->sendBadRequest("Solicitud no corresponde a su usuario");

        $rules = [
            'descripcion' => [
                'rules'  => 'required|max_length[500]',
                'errors' => ['required' => 'Descripción de la Solicitud requerida'],
            ],
            'estado' => [
                'rules'  => 'required|max_length[1]',
                'errors' => ['required' => 'Estado de la Solicitud requerida'],
            ]
        ];

        if (!$this->validateRequest($input, $rules))
            return $this->sendResponse(['validaciones' => $this->getErrorsAsArray($this->validator->getErrors())], ResponseInterface::HTTP_BAD_REQUEST);

     

       try {
            $model->update($id, $input);
            return $this->sendResponse(['message' => 'Solicitud editada correctamente']);
        } catch (Exception $e) {
            return $this->sendResponse(['error' => $e->getMessage()], ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function deleteSolicitud($id)
    {
        if (!isset($id))         return $this->sendBadRequest('Parámetro ID requerido');
        if (!is_numeric($id))    return $this->sendBadRequest('Parámetro ID numérico');
        if ($id < 1)             return $this->sendBadRequest('Parámetro ID numérico mayor a 0');


        $model = new solicitud_actualizacion_model();
        $solicitud = $model->findById($id); 
        if(!$solicitud) return $this->sendBadRequest("Solicitud a eliminar No existe");
        if($solicitud['estado']!='E') return $this->sendBadRequest("Solicitud a eliminar ya ha sido Solicitada o Tramitada");
        if($solicitud['idusuarioreg'] != session()->get('user_id')) return $this->sendBadRequest("Solicitud no corresponde a su usuario");

        if($model->hasDetails($id)) return $this->sendBadRequest("Solicitud ".$solicitud['descripcion']." tiene Campos registradas, NO se puede eliminar");
        
       try {
            $model->delete($id);
            return $this->sendResponse(['message' => 'Solicitud eliminada correctamente']);
        } catch (Exception $e) {
            return $this->sendResponse(['error' => $e->getMessage()], ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function insertDetalleSolicitudCampos()
    {
        $input = $this->getRequestInput($this->request);

        $rules = [
            'idcampo' => [
                'rules'  => 'required|numeric|greater_than[0]',
                'errors' => ['required' => 'ID Campo requerido'],
            ],
            'idsolicitud' => [
                'rules'  => 'required|numeric|greater_than[0]',
                'errors' => ['required' => 'ID Solicitud requerido'],
            ],
            'valorantes' => [
                'rules'  => 'max_length[1000]',
                'errors' => ['required' => 'Información actual requerida'],
            ],
            'valorsolic' => [
                'rules'  => 'max_length[1000]',
                'errors' => ['required' => 'Información a actualizar requerida'],
            ]
        ];


        if (!$this->validateRequest($input, $rules))
            return $this->sendResponse(['validaciones' => $this->getErrorsAsArray($this->validator->getErrors())], ResponseInterface::HTTP_BAD_REQUEST);

        try {
            $model = new detalle_solic_act_model();
            $model->insert($input);
            return $this->sendResponse(['message' => 'Detalle agregado correctamente. ID: ' . $model->getInsertID()]);
        } catch (Exception $e) {
            return $this->sendResponse(['error' => $e->getMessage()], ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    

    public function insertDetalleSolicitudCoordenads()
    {
        $input = $this->getRequestInput($this->request);

        $rules = [
            'idsolicitud' => [
                'rules'  => 'required|numeric|greater_than[0]',
                'errors' => ['required' => 'ID Solicitud requerido'],
            ],
            'lat_sol' => [
                'rules'  => 'required|numeric|greater_than_equal_to[-90]|less_than_equal_to[90]',
                'errors' => [
                    'required' => 'La nueva latitud es requerida',
                    'numeric' => 'La nueva latitud debe ser un número',
                    'greater_than_equal_to' => 'La nueva latitud debe ser mayor o igual a -90',
                    'less_than_equal_to' => 'La nueva latitud debe ser menor o igual a 90',
                ],
            ],
            'lng_sol' => [
                'rules'  => 'required|numeric|greater_than_equal_to[-180]|less_than_equal_to[180]',
                'errors' => [
                    'required' => 'La nueva longitud es requerida',
                    'numeric' => 'La nueva longitud debe ser un número',
                    'greater_than_equal_to' => 'La nueva longitud debe ser mayor o igual a -180',
                    'less_than_equal_to' => 'La nueva longitud debe ser menor o igual a 180',
                ],
            ],
        ];


        if (!$this->validateRequest($input, $rules))
            return $this->sendResponse(['validaciones' => $this->getErrorsAsArray($this->validator->getErrors())], ResponseInterface::HTTP_BAD_REQUEST);

        try {
            $model = new detalle_solic_act_model();
            $existingRecord = $model->where('idcampo', -1)
                         ->where('idsolicitud', $input['idsolicitud'])
                         ->first();
            if ($existingRecord) {
                $input['estado'] = 'S';
                $model->update($existingRecord['id'], $input);
                return $this->sendResponse(['message' => 'Coordenadas actualizadas correctamente. ID: ' . $existingRecord['id']]);
            } else {
                $input['idcampo'] = -1;
                $model->insert($input);
                return $this->sendResponse(['message' => 'Nueva coordenada agregada correctamente. ID: ' . $model->getInsertID()]);
            }

        } catch (Exception $e) {
            return $this->sendResponse(['error' => $e->getMessage()], ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function insertDetalleSolicitudLogo()
    {
        $input = $this->getRequestInput($this->request);

        $rules = [
            'idsolicitud' => [
                'rules'  => 'required|numeric|greater_than[0]',
                'errors' => ['required' => 'ID Solicitud requerido'],
            ]
        ];

        if (!$this->validateRequest($input, $rules))
            return $this->sendResponse(['validaciones' => $this->getErrorsAsArray($this->validator->getErrors())], ResponseInterface::HTTP_BAD_REQUEST);

        $imgLogo = $this->request->getFile('regFileLogo');
        if($imgLogo){
                $validationRule = [
                    'regFileLogo' => [
                        'label' => 'Image File',
                        'rules' => [
                            'uploaded[regFileLogo]',
                            'is_image[regFileLogo]',
                            'mime_in[regFileLogo,image/jpg,image/jpeg,image/png]',
                            'max_size[regFileLogo,6000]',
                            'max_dims[regFileLogo,1024,768]',
                        ],
                        'errors' => ['uploaded' => 'Se requiere Imagen para el Logo', 'mime_in' => 'Formato de la imagen debe ser .jpg, .jpeg o .png','is_image' => 'Fichero deber ser una imagen válida',
                                     'max_size' => 'Tamaño máximo 5MB', 'max_dims' => 'Tamaño deber ser máximo 1024x768'],
                    ]
                ];
                if (! $this->validate($validationRule))     
                    return $this->sendResponse(['validaciones' => $this->getErrorsAsArray($this->validator->getErrors())], ResponseInterface::HTTP_BAD_REQUEST);         
        }

        if($imgLogo){
            $newName = "logo_s_" . $input['idsolicitud'].".".$imgLogo->getClientExtension();
            if (!$imgLogo->hasMoved()) {
                $imgLogo->move(ROOTPATH . 'assets/imgs/logos_gifsolicitados', $newName, true);
            } else {
                $newName = '';
            }
            $input['valorsolic'] = $newName;
        }

        try {
            $model = new detalle_solic_act_model();
            $existingRecord = $model->where('idcampo', -2)
                         ->where('idsolicitud', $input['idsolicitud'])
                         ->first();
            if ($existingRecord) {
                $input['estado'] = 'S';
                $model->update($existingRecord['id'], $input);
                return $this->sendResponse(['message' => 'Nuevo Logo actualizado correctamente. ID: ' . $existingRecord['id']]);
            } else {
                $input['idcampo'] = -2;
                $model->insert($input);
                return $this->sendResponse(['message' => 'Nueva Logo agregado correctamente. ID: ' . $model->getInsertID()]);
            }

        } catch (Exception $e) {
            return $this->sendResponse(['error' => $e->getMessage()], ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    public function insertDetalleSolicitudGif()
    {
        $input = $this->getRequestInput($this->request);

        $rules = [
            'idsolicitud' => [
                'rules'  => 'required|numeric|greater_than[0]',
                'errors' => ['required' => 'ID Solicitud requerido'],
            ]
        ];

        if (!$this->validateRequest($input, $rules))
            return $this->sendResponse(['validaciones' => $this->getErrorsAsArray($this->validator->getErrors())], ResponseInterface::HTTP_BAD_REQUEST);

        $imgGif = $this->request->getFile('regFileImgs');
        if($imgGif){
                $validationRule = [
                    'regFileImgs' => [
                        'label' => 'Images File',
                        'rules' => [
                            'uploaded[regFileImgs]',
                            'is_image[regFileImgs]',
                            'mime_in[regFileImgs,image/gif]',
                            'max_size[regFileImgs,10000]',
                            'max_dims[regFileImgs,1024,768]',
                        ],
                        'errors' => ['uploaded' => 'Se requiere Imagen formato Gif', 'mime_in' => 'Formato de la imagen debe ser .gif','is_image' => 'Fichero deber ser una imagen válida',
                                     'max_size' => 'Tamaño máximo 10MB', 'max_dims' => 'Tamaño deber ser máximo 1024x768'],
                    ],
                ];

                if (! $this->validate($validationRule))     
                    return $this->sendResponse(['validaciones' => $this->getErrorsAsArray($this->validator->getErrors())], ResponseInterface::HTTP_BAD_REQUEST);         
        }

        if($imgGif){
            $newName = "imgsgif_s_" . $input['idsolicitud'].".".$imgGif->getClientExtension();
            if (!$imgGif->hasMoved()) {
                $imgGif->move(ROOTPATH . 'assets/imgs/logos_gifsolicitados', $newName, true);
            } else {
                $newName = '';
            }
            $input['valorsolic'] = $newName;
        }

        try {
            $model = new detalle_solic_act_model();
            $existingRecord = $model->where('idcampo', -3)
                         ->where('idsolicitud', $input['idsolicitud'])
                         ->first();
            if ($existingRecord) {
                $input['estado'] = 'S';
                $model->update($existingRecord['id'], $input);
                return $this->sendResponse(['message' => 'Nuevas Imágenes Gif actualizada correctamente']);
            } else {
                $input['idcampo'] = -3;
                $model->insert($input);
                return $this->sendResponse(['message' => 'Nuevas Imágenes Gif agregada correctamente.']);
            }

        } catch (Exception $e) {
            return $this->sendResponse(['error' => $e->getMessage()], ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function deleteSolicitud_detalle($id)
    {
        if (!isset($id))         return $this->sendBadRequest('Parámetro ID requerido');
        if (!is_numeric($id))    return $this->sendBadRequest('Parámetro ID numérico');
        if ($id < 1)             return $this->sendBadRequest('Parámetro ID numérico mayor a 0');


        $model = new detalle_solic_act_model();
        $detalle_sol = $model->findById($id); 
        if(!$detalle_sol) return $this->sendBadRequest("Detalle de Solicitud a eliminar No existe");

        if($detalle_sol['usuario_sol']!=session()->get('user_id')) return $this->sendBadRequest("No es el usuario que registró la solicitud");
        if($detalle_sol['estado']!='S') return $this->sendBadRequest("Detalle de Solicitud no se puede eliminar, Ya ha sido Aprobada o rechazada");

        if($detalle_sol['idcampo']==-2){
            if(!$this->deleteArchivoImagen($detalle_sol['valorsolic']))    return $this->sendResponse(['error' => "No se pudo eliminar la imagen del Logo: ".$detalle_sol['valorsolic']], ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }else if($detalle_sol['idcampo']==-3){
           if(!$this->deleteArchivoImagen($detalle_sol['valorsolic'])) return $this->sendResponse(['error' => "No se pudo eliminar la imagen Gif: ".$detalle_sol['valorsolic']], ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }

       
       try {
            $model->delete($id);
            return $this->sendResponse(['message' => 'Detalle de la Solicitud eliminada correctamente']);
        } catch (Exception $e) {
            return $this->sendResponse(['error' => $e->getMessage()], ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
      

    public function deleteArchivoImagen($imagen){
        if($imagen!=""){
             $imagenpath = 'assets/imgs/logos_gifsolicitados/'.$imagen;
             if (file_exists($imagenpath)) 
                  return unlink($imagenpath);
        }
        return true;
     }

     public function updateDetalleSolicitudEstado()
     {
         $input = $this->getRequestInput($this->request);
 
         $rules = [
             'id' => [
                 'rules'  => 'required|numeric|greater_than[0]',
                 'errors' => ['required' => 'ID Detalle Solicitud requerido'],
             ],
             'observaciones' => [
                'rules'  => 'required|max_length[1000]',
                'errors' => ['required' => 'Observaciones requerida'],
            ],
            'estado' => [
                'rules'  => 'required|max_length[1]|in_list[A,R]',
                'errors' => ['required' => 'Observaciones requerida',
                            'max_length' => 'El estado no puede tener más de un carácter',
                            'in_list' => 'El estado debe ser A o R'],
            ],
         ];
 
 
         if (!$this->validateRequest($input, $rules))
             return $this->sendResponse(['validaciones' => $this->getErrorsAsArray($this->validator->getErrors())], ResponseInterface::HTTP_BAD_REQUEST);
 
         try {
             $model = new detalle_solic_act_model();
             $existingRecord = $model->where('id', $input['id'])->first();
             if (!$existingRecord) return $this->sendBadRequest("Detalle de Solicitud a actualizar No existe ". $input['id']);
             if ($existingRecord['estado']!='S') return $this->sendBadRequest("Detalle de Solicitud ya ha sido tramitada");

             $sol_model = new solicitud_actualizacion_model();
             $datos['estado'] = 'T';
             $sol_model->update($existingRecord['idsolicitud'], $datos);

            if($input['estado']=='A'){

                $modeloLugar = new lugarturistico_model();

                if( $existingRecord['idcampo']>0){
                    $details = $model->getDetailsFromDetails($existingRecord['id']);
                    if (!$details) return $this->sendBadRequest("Detalle de Solicitud a actualizar No existe ". $input['id']);
                    $campos[$details['campo']] = $details['valorsolic'];
                    $modeloLugar->update($details['id_lugar'],$campos);

                }else{
                    $details = $model->getDetailsFromDetailsOthers($existingRecord['id']);
                    if (!$details) return $this->sendBadRequest("Detalle de Solicitud a actualizar No existe ". $input['id']);

                    if( $existingRecord['idcampo']==-1){
                        $campos['latitud'] = $details['lat_sol'];
                        $campos['longitud'] = $details['lng_sol'];
                        $modeloLugar->update($details['id_lugar'],$campos);

                    }else if( $existingRecord['idcampo']==-2){

                        $imgSolicitada = ROOTPATH . 'assets/imgs/logos_gifsolicitados/'.$details['valorsolic'];
                        $destinationPath = ROOTPATH . 'assets/imgs/logos_gifs/'.$details['valorsolic'];
                        if (file_exists($imgSolicitada)) {
                            if (copy($imgSolicitada, $destinationPath)) {
                                $campos['logo'] = $details['valorsolic'];
                                $modeloLugar->update($details['id_lugar'],$campos);
                            } else return $this->sendBadRequest("Hubo un error al copiar el Logo");
                        } else return $this->sendBadRequest("El archivo no existe en la ruta especificada");

                    }else if( $existingRecord['idcampo']==-3){

                        $imgSolicitada = ROOTPATH . 'assets/imgs/logos_gifsolicitados/'.$details['valorsolic'];
                        $destinationPath = ROOTPATH . 'assets/imgs/logos_gifs/'.$details['valorsolic'];
                        if (file_exists($imgSolicitada)) {
                            if (copy($imgSolicitada, $destinationPath)) {
                                $campos['imagenes_gif'] = $details['valorsolic'];
                                $modeloLugar->update($details['id_lugar'],$campos);
                            } else return $this->sendBadRequest("Hubo un error al copiar el Logo");
                        } else return $this->sendBadRequest("El archivo no existe en la ruta especificada");
                    }
                }
            }
         
           
            $model->update($existingRecord['id'], $input);
            return $this->sendResponse(['message' => 'Detalle de Solicitud procesada correctamente']);
             
            
         } catch (Exception $e) {
             return $this->sendResponse(['error' => $e->getMessage()], ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
         }
     }

     public function cambiarAEstadoSolicitado_Sol($id)
    {
        if (!isset($id))         return $this->sendBadRequest('Parámetro ID requerido');
        if (!is_numeric($id))    return $this->sendBadRequest('Parámetro ID numérico');
        if ($id < 1)             return $this->sendBadRequest('Parámetro ID numérico mayor a 0');

        $model = new solicitud_actualizacion_model();
        $solicitud = $model->findById($id); 
        if(!$solicitud) return $this->sendBadRequest("Solicitud a actualizar No existe");
        
        if($solicitud['estado']!='E') return $this->sendBadRequest("Solicitud no está en estado de Edición");
        if($solicitud['idusuarioreg'] != session()->get('user_id')) return $this->sendBadRequest("Solicitud no corresponde a su usuario");
       
        $datos['estado'] = 'S';

       try {
            $model->update($id, $datos);
            return $this->sendResponse(['message' => 'Solicitud tramitada correctamente']);
        } catch (Exception $e) {
            return $this->sendResponse(['error' => $e->getMessage()], ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}
