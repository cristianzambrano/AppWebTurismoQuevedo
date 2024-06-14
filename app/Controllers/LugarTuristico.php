<?php

namespace App\Controllers;

use App\Models\lugarturistico_model;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Files\File;

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
        $datos = $model->getListadoGrid($IDC, $IDSC);
        if($datos)
            return view('lugarturistico/grid'.($publicView==1?'_public':''), $datos);
       
    }

  

    ///////////// JSON /////////////////////////
    public function getjson_ListadoLugares() {
        $model = new lugarturistico_model();
        $datos = $model->getListado();
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


    public function getjson_ListadoLugaresGrid($IDC, $IDSC) {
        
        if (!is_numeric($IDC))     return $this->sendBadRequest('Parámetro IDC NO numérico');
        if (!is_numeric($IDSC))    return $this->sendBadRequest('Parámetro IDSC NO numérico');
        
        $model = new lugarturistico_model();
        $datos = $model->getListadoGrid($IDC, $IDSC);
        if ($datos) 
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
      
}
