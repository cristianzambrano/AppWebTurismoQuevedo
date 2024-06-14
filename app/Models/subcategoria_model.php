<?php

namespace App\Models;

use CodeIgniter\Model;
use Exception;


class subcategoria_model extends Model
{
    protected $table = 'subcategoria_lugar';
    protected $primaryKey       = 'id';
    protected $allowedFields = ['categoria_id', 'descripcion'];
    
    public function execQuery($Query){
        $query = $this->db->query($Query);
        return $query->getNumRows() > 0?$query:false;
     }
  
     public function findById($id)
     {
        return $this->asArray()->where(['id' => $id])->first();
     }

     
     public function getListado($idc) {
        $sql = "SELECT Concat('r_',sc.id) as dt_rowid, sc.id, sc.categoria_id, sc.descripcion, c.descripcion as categoria
        FROM subcategoria_lugar sc, categoria_lugar c
        WHERE c.id = sc.categoria_id ";
        if($idc>0) $sql = $sql . " and c.id=$idc "; 
        $sql = $sql." order by c.id";
        $query = $this->execQuery($sql);
        if($query)
             return $query->getResultArray();
        else
            return false;
    }

   
    public function getSubCategoria($ID)
    {
        $sql = "SELECT Concat('r_',sc.id) as dt_rowid, sc.id, sc.categoria_id, sc.descripcion, c.descripcion as categoria
                FROM subcategoria_lugar sc, categoria_lugar c
                WHERE c.id = sc.categoria_id and sc.id=$ID
                order by c.id";

        $query = $this->execQuery($sql);
        if($query)
             return $query->getRowArray();
        else
            return false;

    }

    public function hasLugaresTuristicos($idsc) {
        $sql = "SELECT * FROM lugar_turistico where subcategoria_id=$idsc";
        $query = $this->db->query($sql);
        return $query->getNumRows()>0?true:false;   
    }

}