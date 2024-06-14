<?php

namespace App\Controllers;

use App\Models\subcategoria_model;
use CodeIgniter\HTTP\ResponseInterface;

class SubCategoria extends BaseController
{

    ///////////////Rutas//////////////
    public function index(): string
    {
        return view('subcategoria/listado');
    }

    public function listado(): string
    {
        return view('subcategoria/listado');
    }

    public function viewAddSubCategoria(): string
    {
        return view('subcategoria/add');
    }


    public function viewEditSubCategoria($IDC): string
    {
        if(is_numeric($IDC)){
            $model = new subcategoria_model();
            $datos = $model->getSubCategoria($IDC);
            if($datos){ 
                return view('subcategoria/edit', $datos);
            }
            else{
                  echo "SubCategoría No existe";
           }
       } else echo "Error en Parámetros";
      
    }

    ///////////// JSON /////////////////////////
    public function getjson_ListadoSubCategorias() {
        $model = new subcategoria_model();
        $datos = $model->getListado(0); //Todas
        if ($datos) 
            echo json_encode(['data' => $datos]);
    
    }

    
    public function getjson_ListadoSubCategoriasCB($idc) {
        $model = new subcategoria_model();
        $datos = $model->getListado($idc);
        if ($datos) 
            echo json_encode($datos);
    
    }


    public function insertSubCategoria()
    {
        $input = $this->getRequestInput($this->request);

        $rules = [
            'descripcion' => [
                'rules'  => 'required|max_length[100]',
                'errors' => ['required' => 'Descripción de la SubCategoría requerida'],
            ],
            'categoria_id' => [
                'rules'  => 'required|numeric|greater_than[0]',
                'errors' => ['required' => 'ID Categoría requerido'],
            ]
        ];


        if (!$this->validateRequest($input, $rules))
            return $this->sendResponse(['validaciones' => $this->getErrorsAsArray($this->validator->getErrors())], ResponseInterface::HTTP_BAD_REQUEST);

        try {
            $model = new subcategoria_model();
            $model->insert($input);
            return $this->sendResponse(['message' => 'SubCategoría creada correctamente. ID: ' . $model->getInsertID()]);
        } catch (Exception $e) {
            return $this->sendResponse(['error' => $e->getMessage()], ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function updateSubCategoria($id)
    {
        if (!isset($id))         return $this->sendBadRequest('Parámetro ID requerido');
        if (!is_numeric($id))    return $this->sendBadRequest('Parámetro ID numérico');
        if ($id < 1)             return $this->sendBadRequest('Parámetro ID numérico mayor a 0');

        $input = $this->getRequestInput($this->request);

        $model = new subcategoria_model();
        $subc = $model->findById($id); 
        if(!$subc) return $this->sendBadRequest("SubCategoría a actualizar No existe");
        
        

        $rules = [
            'descripcion' => [
                'rules'  => 'required|max_length[100]',
                'errors' => ['required' => 'Descripción de la SubCategoría requerida'],
            ],
            'categoria_id' => [
                'rules'  => 'required|numeric|greater_than[0]',
                'errors' => ['required' => 'ID Categoría requerido'],
            ]
        ];

        if (!$this->validateRequest($input, $rules))
            return $this->sendResponse(['validaciones' => $this->getErrorsAsArray($this->validator->getErrors())], ResponseInterface::HTTP_BAD_REQUEST);

     

       try {
            $model->update($id, $input);
            return $this->sendResponse(['message' => 'SubCategoría editada correctamente']);
        } catch (Exception $e) {
            return $this->sendResponse(['error' => $e->getMessage()], ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function deleteSubCategoria($id)
    {
        if (!isset($id))         return $this->sendBadRequest('Parámetro ID requerido');
        if (!is_numeric($id))    return $this->sendBadRequest('Parámetro ID numérico');
        if ($id < 1)             return $this->sendBadRequest('Parámetro ID numérico mayor a 0');


        $model = new subcategoria_model();
        $subc = $model->findById($id); 
        if(!$subc) return $this->sendBadRequest("SubCategoría a eliminar No existe");
        
        if($model->hasLugaresTuristicos($id)) return $this->sendBadRequest("SubCategoría ".$subc['descripcion']." tiene Lugares Turísticos registrados, NO se puede eliminar");
        
       try {
            $model->delete($id);
            return $this->sendResponse(['message' => 'SubCategoría eliminada correctamente']);
        } catch (Exception $e) {
            return $this->sendResponse(['error' => $e->getMessage()], ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

      
}
