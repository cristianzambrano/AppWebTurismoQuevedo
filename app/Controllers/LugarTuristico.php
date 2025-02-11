<?php

namespace App\Controllers;

use App\Models\lugarturistico_model;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Files\File;
use App\Models\camposactualizacion_model;

class LugarTuristico extends BaseController
{

    ///////////////Rutas//////////////
    public function index(): string
    {
        return view('lugarturistico/listado');
    }

    public function listado(): string
    {
        return view('lugarturistico/listado');
    }

  
    public function viewAddLugarTuristico(): string
    {
        return view('lugarturistico/add');
    }

    public function lista_grid(): string
    {
        return view('lugarturistico/lista_grid');
    }

    public function lista_grid_public(): string
    {
        return view('lugarturistico/lista_grid_public');
    }

    public function viewMapa_public(): string
    {
        return view('lugarturistico/mapa_public');
    }

    public function viewVistaModalLugarTuristico($IDC): string
    {
        if(is_numeric($IDC)){
            $model = new lugarturistico_model();
            $datos = $model->getLugarTuristico($IDC);
            if($datos){ 
                return view('lugarturistico/vista_modal', $datos);
            }
            else{
                  echo "Lugar Turístico No existe";
           }
       } else echo "Error en Parámetros";
      
    }


    public function viewEditLugarTuristico($IDC): string
    {
        if(is_numeric($IDC)){
            $model = new lugarturistico_model();
            $datos = $model->getLugarTuristico($IDC);
            if($datos){ 
                return view('lugarturistico/edit', $datos);
            }
            else{
                  echo "Lugar Turístico No existe";
           }
       } else echo "Error en Parámetros";
      
    }

    public function viewLugarTuristicoGrid($IDC, $IDSC, $publicView): string
    {
        if (!is_numeric($IDC))     return $this->sendBadRequest('Parámetro IDC NO numérico');
        if (!is_numeric($IDSC))    return $this->sendBadRequest('Parámetro IDSC NO numérico');

        $model = new lugarturistico_model();
        $datos = $model->getListadoGrid($IDC, $IDSC, 1);
        if($datos)
            return view('lugarturistico/grid'.($publicView==1?'_public':''), $datos);
        else
            return '';
       
    }

    public function viewMapaPublic()
    {
       
        $lat = $this->request->getVar('lat');
        $lng = $this->request->getVar('lng');
        
        if (!is_numeric($lat))     return $this->sendBadRequest('Parámetro lat NO numérico');
        if (!is_numeric($lng))     return $this->sendBadRequest('Parámetro lng NO numérico');

        if ($lat < -90 || $lat > 90)     return $this->sendBadRequest('Parámetro lat fuera del rango válido (-90 a 90)');
        if ($lng < -180 || $lng > 180)    return $this->sendBadRequest('Parámetro lng fuera del rango válido (-180 a 180)');
        

        if($this->request->getVar('radio')){
            $radio = $this->request->getVar('radio');
            if (!is_numeric($radio))    return $this->sendBadRequest('Parámetro radio NO numérico');
            if ($radio<0.1)             return $this->sendBadRequest('El radio debe ser mayor 0.1 km ');
          
        }else $radio = 1;


        if($this->request->getVar('idc')){
            $IDC = $this->request->getVar('idc');
            if (!is_numeric($IDC)) 
                return $this->sendBadRequest('Parámetro IDC NO numérico');
        }else $IDC = 0;

        if($this->request->getVar('idsc')){
            $IDSC = $this->request->getVar('idsc');
            if (!is_numeric($IDSC)) 
                return $this->sendBadRequest('Parámetro IDSC NO numérico');
        }else $IDSC = 0;

        $lugaresCercanos = $this->getLugaresCercanos($lat, $lng, $radio, $IDC, $IDSC);
        if($lugaresCercanos)
          return view('lugarturistico/mapa', $lugaresCercanos);
       
    }

    private function getLugaresCercanos($lat= -1.023, $lng=-79.464, $radio=1, $IDC=0, $IDSC=0){
        $lugaresCercanos = [];

        $model = new lugarturistico_model();
        $lugares = $model->getListadoMapa($IDC,$IDSC);
        if($lugares)
            $lugares = $lugares['data'];
        else return  ['data' => $lugaresCercanos]; 
        
        foreach ($lugares as $lugar) {
            $distancia = $this->calcularDistancia($lat, $lng, $lugar['lat'], $lugar['lng']);
            if ($distancia <= $radio) {
                $lugaresCercanos[] = $lugar;
            }
        }
        return ['data' => $lugaresCercanos]; 
    }

    private function calcularDistancia($lat1, $lng1, $lat2, $lng2)
    {
        $earthRadius = 6371; // Radio de la Tierra en kilómetros

        $dLat = deg2rad($lat2 - $lat1);
        $dLng = deg2rad($lng2 - $lng1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLng / 2) * sin($dLng / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        $distancia = $earthRadius * $c;

        return $distancia;
    }

    ///////////// JSON /////////////////////////
    public function getjson_ListadoLugares($visible) {
        $model = new lugarturistico_model();
        $datos = $model->getListado($visible);
        if ($datos) 
            echo json_encode($datos);
    
    }

   public function getjson_ListadoLugaresOpenAI($IDC, $IDSC) {
       if (!is_numeric($IDC))     return $this->sendBadRequest('Parámetro IDC NO numérico');
        if (!is_numeric($IDSC))    return $this->sendBadRequest('Parámetro IDSC NO numérico');
        
        $model = new lugarturistico_model();
        $datos = $model->getListadoOpenAI($IDC, $IDSC);
        if ($datos) 
            echo json_encode($datos);    
    }


    public function getjson_ListadoLugaresGrid($IDC, $IDSC, $visible) {
        
        if (!is_numeric($IDC))     return $this->sendBadRequest('Parámetro IDC NO numérico');
        if (!is_numeric($IDSC))    return $this->sendBadRequest('Parámetro IDSC NO numérico');
        if (!is_numeric($visible))    return $this->sendBadRequest('Parámetro Visible NO numérico');
        
        $model = new lugarturistico_model();
        $datos = $model->getListadoGrid($IDC, $IDSC, $visible);
        if ($datos) 
            echo json_encode($datos);
    
    }

    public function getjson_ListadoLugaresCercanos() {
    
        $lat = $this->request->getVar('lat');
        $lng = $this->request->getVar('lng');
        
        if (!is_numeric($lat))     return $this->sendBadRequest('Parámetro lat NO numérico');
        if (!is_numeric($lng))     return $this->sendBadRequest('Parámetro lng NO numérico');

        if ( $lat < -90 || $lat > 90)     return $this->sendBadRequest('Parámetro lat fuera del rango válido (-90 a 90)');
        if ($lng < -180 || $lng > 180)    return $this->sendBadRequest('Parámetro lng fuera del rango válido (-180 a 180)');
        

        if($this->request->getVar('radio')){
            $radio = $this->request->getVar('radio');
            if (!is_numeric($radio))    return $this->sendBadRequest('Parámetro radio NO numérico');
            if ($radio<0.1)             return $this->sendBadRequest('El radio debe ser mayor 0.1 km ');
          
        }else $radio = 1;


        if($this->request->getVar('idc')){
            $IDC = $this->request->getVar('idc');
            if (!is_numeric($IDC)) 
                return $this->sendBadRequest('Parámetro IDC NO numérico');
        }else $IDC = 0;

        if($this->request->getVar('idsc')){
            $IDSC = $this->request->getVar('idsc');
            if (!is_numeric($IDSC)) 
                return $this->sendBadRequest('Parámetro IDSC NO numérico');
        }else $IDSC = 0;

        $datos = $this->getLugaresCercanos($lat, $lng, $radio, $IDC, $IDSC);
        echo json_encode($datos);
    
    }


    public function insertLugarTuristico()
    {
        $input = $this->getRequestInput($this->request);

        $rules = [
            'subcategoria_id' => [
                'rules'  => 'required|numeric|greater_than[0]',
                'errors' => ['required' => 'ID SubCategoría requerido'],
            ],
            'nombre_lugar' => [
                'rules'  => 'required|max_length[100]',
                'errors' => ['required' => 'Nombre del Lugar requerido'],
            ],
            'descripcion' => [
                'rules'  => 'required|max_length[1000]',
                'errors' => ['required' => 'Descripción del Lugar requerido'],
            ],
            'direccion' => [
                'rules'  => 'required|max_length[300]',
                'errors' => ['required' => 'Dirección del Lugar requerido'],
            ],
            'puntuacion' => [
                'rules'  => 'required|numeric|greater_than[0]',
                'errors' => ['required' => 'Puntuación requerido'],
            ],
            'anio' => [
                'rules'  => 'required|numeric|greater_than[1990]',
                'errors' => ['required' => 'Año requerido'],
            ],
            'latitud' => [
                'rules'  => 'required|numeric|greater_than_equal_to[-90]|less_than_equal_to[90]',
                'errors' => ['required' => 'Latitud requerida'],
            ],
            'longitud' => [
                'rules'  => 'required|numeric|greater_than_equal_to[-180]|less_than_equal_to[180]',
                'errors' => ['required' => 'Longitud requerida'],
            ],
            'telefono' => [
                'rules'  => 'required|max_length[100]',
                'errors' => ['required' => 'Teléfono del Lugar requerido'],
            ],
            'delivery' => [
                'rules'  => 'max_length[300]',
                'errors' => ['required' => 'Link de delivery Lugar requerido'],
            ],
            'whatsapp' => [
                'rules'  => 'max_length[100]',
                'errors' => ['required' => 'Link de Whatsapp del Lugar requerido'],
            ],
            'google_maps' => [
                'rules'  => 'max_length[100]',
                'errors' => ['required' => 'Link de Google Maps del Lugar requerido'],
            ]
        ];


        if (!$this->validateRequest($input, $rules))
            return $this->sendResponse(['validaciones' => $this->getErrorsAsArray($this->validator->getErrors())], ResponseInterface::HTTP_BAD_REQUEST);

        
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
                ],
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


        $imgLogo = $this->request->getFile('regFileLogo');
        $newName = $imgLogo->getRandomName();
        if ($imgLogo->hasMoved()) return $this->sendResponse(['error' => 'Fichero Movido'], ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        try {
            $imgLogo->move(ROOTPATH .'assets/imgs/logos_gifs', $newName);
        } catch (Exception $e) {
            return $this->sendResponse(['error' => $e->getMessage()], ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }

        $input['logo'] = $newName;

        $imgImgs = $this->request->getFile('regFileImgs');
        $newName = $imgImgs->getRandomName();
        if ($imgImgs->hasMoved()) return $this->sendResponse(['error' => 'Fichero Movido'], ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        try {
            $imgImgs->move(ROOTPATH .'assets/imgs/logos_gifs', $newName);
        } catch (Exception $e) {
            return $this->sendResponse(['error' => $e->getMessage()], ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }
        $input['imagenes_gif'] = $newName;
       
                     
        

        try {
            $model = new lugarturistico_model();
            $model->insert($input);
            return $this->sendResponse(['message' => 'Lugar Turístico creado correctamente. ID: ' . $model->getInsertID()]);
        } catch (Exception $e) {
            return $this->sendResponse(['error' => $e->getMessage()], ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

  

    public function updateLugarTuristico($id)
    {
        if (!isset($id))         return $this->sendBadRequest('Parámetro ID requerido');
        if (!is_numeric($id))    return $this->sendBadRequest('Parámetro ID numérico');
        if ($id < 1)             return $this->sendBadRequest('Parámetro ID numérico mayor a 0');

        $input = $this->getRequestInput($this->request);

        $model = new lugarturistico_model();
        $lugar = $model->findById($id); 
        if(!$lugar) return $this->sendBadRequest("Lugar Turístico a actualizar No existe");
        
        $rules = [
            'subcategoria_id' => [
                'rules'  => 'required|numeric|greater_than[0]',
                'errors' => ['required' => 'ID SubCategoría requerido'],
            ],
            'nombre_lugar' => [
                'rules'  => 'required|max_length[100]',
                'errors' => ['required' => 'Nombre del Lugar requerido'],
            ],
            'descripcion' => [
                'rules'  => 'required|max_length[1000]',
                'errors' => ['required' => 'Descripción del Lugar requerido'],
            ],
            'direccion' => [
                'rules'  => 'required|max_length[300]',
                'errors' => ['required' => 'Dirección del Lugar requerido'],
            ],
            'puntuacion' => [
                'rules'  => 'required|numeric|greater_than[0]',
                'errors' => ['required' => 'Puntuación requerido'],
            ],
            'anio' => [
                'rules'  => 'required|numeric|greater_than[1990]',
                'errors' => ['required' => 'Año requerido'],
            ],
            'telefono' => [
                'rules'  => 'required|max_length[100]',
                'errors' => ['required' => 'Teléfono del Lugar requerido'],
            ],
            'latitud' => [
                'rules'  => 'required|numeric|greater_than_equal_to[-90]|less_than_equal_to[90]',
                'errors' => ['required' => 'Latitud requerida'],
            ],
            'longitud' => [
                'rules'  => 'required|numeric|greater_than_equal_to[-180]|less_than_equal_to[180]',
                'errors' => ['required' => 'Longitud requerida'],
            ],
            'delivery' => [
                'rules'  => 'max_length[300]',
                'errors' => ['required' => 'Link de delivery Lugar requerido'],
            ],
            'whatsapp' => [
                'rules'  => 'max_length[100]',
                'errors' => ['required' => 'Link de Whatsapp del Lugar requerido'],
            ],
            'google_maps' => [
                'rules'  => 'max_length[100]',
                'errors' => ['required' => 'Link de Google Maps del Lugar requerido'],
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
        
        $imgImgs = $this->request->getFile('regFileImgs');
        if($imgImgs){
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

        if($imgLogo){
            if(!$this->deleteArchivoImagen($lugar['logo'])) return $this->sendResponse(['error' => "No se pudo eliminar la imagen del Logo: ".$lugar['logo']], ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
      
            $newName = $imgLogo->getRandomName();
            if (!$imgLogo->hasMoved()) 
                $imgLogo->move(ROOTPATH .'assets/imgs/logos_gifs', $newName);
            else  $newName='';
            $input['logo'] = $newName;
        }

      
        if($imgImgs){
            if($this->deleteArchivoImagen($lugar['imagenes_gif'])){
                $newName = $imgImgs->getRandomName();
                if (!$imgImgs->hasMoved()) 
                    $imgImgs->move(ROOTPATH .'assets/imgs/logos_gifs', $newName);
                else $newName='';
                $input['imagenes_gif'] = $newName;
            }
        }
       
       try {
            $model->update($id, $input);
            return $this->sendResponse(['message' => 'Lugar Turístico editado correctamente']);
        } catch (Exception $e) {
            return $this->sendResponse(['error' => $e->getMessage()], ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function deleteLugarTuristico($id)
    {
        if (!isset($id))         return $this->sendBadRequest('Parámetro ID requerido');
        if (!is_numeric($id))    return $this->sendBadRequest('Parámetro ID numérico');
        if ($id < 1)             return $this->sendBadRequest('Parámetro ID numérico mayor a 0');


        $model = new lugarturistico_model();
        $lugar = $model->findById($id); 
        if(!$lugar) return $this->sendBadRequest("Lugar Turístico a eliminar No existe");

        
        if(!$this->deleteArchivoImagen($lugar['logo']))         return $this->sendResponse(['error' => "No se pudo eliminar la imagen del Logo: ".$lugar['logo']], ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        if(!$this->deleteArchivoImagen($lugar['imagenes_gif'])) return $this->sendResponse(['error' => "No se pudo eliminar la imagen Gif: ".$lugar['imagenes_gif']], ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
       
        try {
            $model->delete($id);
            return $this->sendResponse(['message' => 'Lugar Turístico eliminado correctamente']);
        } catch (Exception $e) {
            return $this->sendResponse(['error' => $e->getMessage()], ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function deleteArchivoImagen($imagen){
       if($imagen!=""){
            $imagenpath = 'assets/imgs/logos_gifs/'.$imagen;
            if (file_exists($imagenpath)) 
                 return unlink($imagenpath);
       }
       return true;
    }


    public function getCampoValue($campoId)
    {
        $lugarId = session()->get('lugar_id');

        if (!$lugarId) 
            return $this->sendBadRequest("ID de lugar no encontrado en la sesión");
        

        $camposModel = new camposactualizacion_model();
        $campo = $camposModel->getCampoNombre($campoId);
        if (!$campo) 
            return $this->sendBadRequest("Campo ID inválido");
        

        $model = new lugarturistico_model();
        $valor = $model->getCampoValue($lugarId, $campo);

        // Validar que el registro y el campo existen
        if ($valor === null) 
            return $this->sendBadRequest("Registro o campo no encontrado");
        
        return $this->response->setJSON([$campo => $valor]);
    }

    public function getInfoLugar($lugarId)
    {

        $model = new lugarturistico_model();
        $lugar = $model->findById($lugarId);
        
        if ($lugar === null) 
            return $this->sendBadRequest("ID de lugar no encontrado");
        
    
        return $this->response->setJSON($lugar);
    }


    public function changeVisibleLugarTuristico($id)
    {
        if (!isset($id))         return $this->sendBadRequest('Parámetro ID requerido');
        if (!is_numeric($id))    return $this->sendBadRequest('Parámetro ID numérico');
        if ($id < 1)             return $this->sendBadRequest('Parámetro ID numérico mayor a 0');

        $model = new lugarturistico_model();
        $lugar = $model->findById($id); 
        if(!$lugar) return $this->sendBadRequest("Lugar Turístico a actualizar No existe");
        
        $estado_msg = "";
        if($lugar['visible']=='0') {
            $input['visible'] = '1';
            $estado_msg =" Visible";
        }else{
           $input['visible'] = '0';
           $estado_msg ="Oculto";
        }
      
       try {
            $model->update($id, $input);
            return $this->sendResponse(['message' => 'Lugar turístico se ha cambiado a estado '.$estado_msg. ' correctamente!'  ]);
        } catch (Exception $e) {
            return $this->sendResponse(['error' => $e->getMessage()], ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
      
}
