<?php

namespace App\Models;

use CodeIgniter\Model;
use Exception;


class usuario_model extends Model
{
    protected $table = 'usuario';
    protected $primaryKey       = 'id';
    protected $allowedFields = ['cedula','clave','nombres','apellidos', 'clave_des', 'rol', 'foto'];
    
    public function execQuery($Query){
        $query = $this->db->query($Query);
        return $query->getNumRows() > 0?$query:false;
     }
  
    
    public function findById($id)
    {
       return $this->asArray()->where(['id' => $id])->first();
    }

       
   
    public function get_menu_items_by_role($rol) {
            $sql="Select go.id as idgrupo, go.descripcion AS grupo_descripcion, go.icon AS grupo_icon, mi.descripcion AS item_descripcion,
            r.ruta as ruta, mi.icon AS item_icon, mi.titulo_item as titulo_item 
            from menu_rol mr, menu_items mi, grupo_opciones go, ruta r
            where mr.menuitem_id = mi.id and mi.idgrupo = go.id and mi.idruta = r.id and mr.rol ='".$rol."'
            order by go.id, mr.orden";
            $query = $this->execQuery($sql);
            if($query)
                 return $query->getResultArray();
            else
                return [];
    }
}