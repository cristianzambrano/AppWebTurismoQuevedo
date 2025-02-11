<?php

namespace App\Models;

use CodeIgniter\Model;
use Exception;


class permisos_rol_model extends Model
{
    protected $table = 'permisos_rol';
    protected $primaryKey       = 'id';
    protected $allowedFields = ['rol','ruta_id'];
    
    public function execQuery($Query){
        $query = $this->db->query($Query);
        return $query->getNumRows() > 0?$query:false;
     }
  
     public function getAllowedRoutes($rol)
     {
        return $this->select('ruta.ruta')
                ->join('rol', 'permisos_rol.rol = rol.rol')
                ->join('ruta', 'permisos_rol.ruta_id = ruta.id')
                ->where('rol.rol', $rol)
                ->findAll();
     }

    
   
}