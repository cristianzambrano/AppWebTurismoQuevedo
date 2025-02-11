<?php

namespace App\Models;

use CodeIgniter\Model;
use Exception;


class lugarturistico_model extends Model
{
    protected $table = 'lugar_turistico';
    protected $primaryKey       = 'id';
    protected $allowedFields = ['subcategoria_id','nombre_lugar','descripcion','direccion','logo','imagenes_gif','puntuacion',
                                'telefono','anio','delivery','whatsapp','google_maps','latitud','longitud',
                                'id_usrpropietario','email','registro_municipal', 'visible','facebook','x','instagram','tiktok'];
    
    public function execQuery($Query){
        $query = $this->db->query($Query);
        return $query->getNumRows() > 0?$query:false;
     }
  
     protected $beforeInsert = ['beforeInsertCallback'];
     protected $beforeUpdate = ['beforeUpdateCallback'];
 
     
     protected function beforeInsertCallback(array $data)
     {
         
        $userId = session()->get('user_id'); 
        $data['data']['id_usuario_creacion'] = $userId;
        $data['data']['fecha_creacion'] = date('Y-m-d H:i:s');
        $data['data']['visible'] = '0';
        $data['data']['id_usuario_modifico'] = $userId;
        $data['data']['fecha_modificacion'] = date('Y-m-d H:i:s');

         return $data;
     }
 
     // Callback antes de actualizar
     protected function beforeUpdateCallback(array $data)
     {
        $userId = session()->get('user_id'); 
        $data['data']['id_usuario_modifico'] = $userId;
        $data['data']['fecha_modificacion'] = date('Y-m-d H:i:s');
         return $data;
     }

     public function findById($id)
     {
        return $this->asArray()->where(['id' => $id])->first();
     }

     
     public function getListado($visible) {
        $sql = "SELECT Concat('r_',l.id) as dt_rowid, c.id as categoria_id, c.descripcion as categoria, sc.descripcion as subcategoria,
        Concat(l.nombre_lugar,'<br/>',l.descripcion) as detalle_lugar,   l.*,
        CASE 
                    WHEN l.visible = '0' THEN '<span class=\"badge badge-secondary\">No Visible</span>' 
                    WHEN l.visible = '1' THEN '<span class=\"badge badge-success\">Visible</span>'
                    ELSE l.visible 
        END as visible_etiqueta
        FROM lugar_turistico l, subcategoria_lugar sc, categoria_lugar c
        WHERE sc.id = l.subcategoria_id and c.id = sc.categoria_id ";

        if($visible==2)
                $sql = $sql. " and  (l.visible='1' or l.visible='0') ";
        else if($visible==1 || $visible==0) 
                $sql = $sql. " and  l.visible='$visible'  ";
        else    $sql = $sql. " and  l.visible='1' ";

        
        $sql.=" order by c.descripcion, sc.descripcion, l.nombre_lugar";
        $query = $this->execQuery($sql);
        if($query)
             return ['data' => $query->getResultArray()];
        else
            return false;
    }

   
    public function getLugarTuristico($ID)
    {
        $sql = "SELECT Concat('r_',l.id) as dt_rowid, c.id  as categoria_id,  c.descripcion as categoria, sc.descripcion as subcategoria, l.*
        FROM lugar_turistico l, subcategoria_lugar sc, categoria_lugar c
        WHERE sc.id = l.subcategoria_id and c.id = sc.categoria_id and l.id=$ID";
        $query = $this->execQuery($sql);
        if($query)
             return $query->getRowArray();
        else
            return false;

    }

    public function getListadoGrid($IDC, $IDSC, $visible) {
        $sql = "SELECT c.id as categoria_id, c.descripcion as categoria, sc.descripcion as subcategoria, l.*
        FROM lugar_turistico l, subcategoria_lugar sc, categoria_lugar c
        WHERE sc.id = l.subcategoria_id and c.id = sc.categoria_id ";
        if ($IDC>0)  $sql = $sql. " and c.id=$IDC ";
        if ($IDSC>0) $sql = $sql. " and sc.id=$IDSC ";
        

        if($visible==2)
                $sql = $sql. " and  (l.visible='1' or l.visible='0') ";
        else if($visible==1 || $visible==0) 
                $sql = $sql. " and  l.visible='$visible'  ";
        else    $sql = $sql. " and  l.visible='1' ";

        $sql = $sql. " order by c.descripcion, sc.descripcion, l.nombre_lugar";
        
        $query = $this->execQuery($sql);
        if($query)
             return ['data' => $query->getResultArray()];
        else
            return false;
    }

    public function getListadoMapa($IDC, $IDSC) {
        $sql = "SELECT l.id,  l.nombre_lugar as nombre, l.latitud as lat, l.longitud as lng, l.google_maps as url, l.logo, 
        c.descripcion as categoria, sc.descripcion as subcategoria, c.id as categoria_id, sc.id as subcategoria_id
        FROM lugar_turistico l, subcategoria_lugar sc, categoria_lugar c
        WHERE sc.id = l.subcategoria_id and c.id = sc.categoria_id and l.visible='1' ";
        if ($IDC>0)  $sql = $sql. " and c.id=$IDC ";
        if ($IDSC>0) $sql = $sql. " and sc.id=$IDSC ";

        $sql = $sql. " order by c.descripcion, sc.descripcion, l.nombre_lugar";
        $query = $this->execQuery($sql);
        if($query)
             return ['data' => $query->getResultArray()];
        else
            return false;
    }

   public function getListadoOpenAI($IDC, $IDSC) {
        $sql = "SELECT l.nombre_lugar , c.descripcion as categoria
	        FROM lugar_turistico l, subcategoria_lugar sc, categoria_lugar c
        	WHERE sc.id = l.subcategoria_id and c.id = sc.categoria_id ";
        if ($IDC>0)  $sql = $sql. " and c.id=$IDC ";
        if ($IDSC>0) $sql = $sql. " and sc.id=$IDSC ";

        $sql = $sql. " order by c.descripcion, sc.descripcion, l.nombre_lugar";
        $query = $this->execQuery($sql);
        if($query)
             return $query->getResultArray();
        else
            return false;
    }

    public function getCampoValue($lugarId, $campo)
    {
        $registro = $this->find($lugarId);
        if (!$registro)   return null;        
        if (!array_key_exists($campo, $registro))  return null;
        return $registro[$campo] === null ? '' : $registro[$campo];
    }

}