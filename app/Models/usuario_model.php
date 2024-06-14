<?php

namespace App\Models;

use CodeIgniter\Model;
use Exception;


class usuario_model extends Model
{
    protected $table = 'usuario';
    protected $primaryKey       = 'id';
    protected $allowedFields = ['cedula','clave','nombres','apellidos'];
    
    public function execQuery($Query){
        $query = $this->db->query($Query);
        return $query->getNumRows() > 0?$query:false;
     }
  
    
    public function getListado()
    {
        $query = $this->db->query("SELECT Concat('r_',id) as dt_rowid, id, descripcion  FROM categoria_lugar  order by id;");
        return $query->getResultArray();
    }

    public function findById($id)
    {
       return $this->asArray()->where(['id' => $id])->first();
    }

    

    public function getCategoria($ID)
    {
        $sql = "SELECT Concat('r_', c.id) as dt_rowid, c.* FROM categoria_lugar c WHERE c.id=$ID";
        $query = $this->execQuery($sql);
        if($query)
             return $query->getRowArray();
        else
            return false;

    }
   
}