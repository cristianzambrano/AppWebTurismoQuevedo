<?php

namespace App\Models;

use CodeIgniter\Model;
use Exception;


class solicitud_actualizacion_model extends Model
{
    protected $table = 'solicitud_actualizacion';
    protected $primaryKey       = 'id';
    protected $allowedFields = ['descripcion','estado'];
    
    public function execQuery($Query){
        $query = $this->db->query($Query);
        return $query->getNumRows() > 0?$query:false;
     }
  
     protected $beforeInsert = ['beforeInsertCallback'];
     protected $beforeUpdate = ['beforeUpdateCallback'];
 
     
     protected function beforeInsertCallback(array $data)
     {
         
        $data['data']['idusuarioreg'] = session()->get('user_id');
        $data['data']['id_lugar'] =  session()->get('lugar_id');
        $data['data']['fecha_solic'] = date('Y-m-d H:i:s');
        $data['data']['estado'] = 'E'; //Edición (user_propietario), Solicitada (user_propietario), Tramitada (admin)
        $data['data']['idusuarioact'] = null;
        $data['data']['fecha_act'] = null;

         return $data;
     }
 
     // Callback antes de actualizar
     protected function beforeUpdateCallback(array $data)
     {
        //Si va a pasar a estado Tramitado Update el usr
        if($data['data']['estado']=='T'){
            $data['data']['idusuarioact'] = session()->get('user_id'); 
            $data['data']['fecha_act'] = date('Y-m-d H:i:s');
        }else{
            $data['data']['fecha_solic'] = date('Y-m-d H:i:s');
        }
         return $data;
     }

     public function findById($id)
     {
        return $this->asArray()->where(['id' => $id])->first();
     }

     
     public function getListado($idusuario) {

        $sql = "SELECT s.id, l.nombre_lugar, s.descripcion, concat(u.nombres,' ',u.apellidos) as usuario_solicito, s.fecha_solic as fecha_sol, 
                CASE 
                WHEN s.estado = 'E' THEN '<span class=\"badge badge-secondary\">Edición</span>'
                WHEN s.estado = 'S' THEN '<span class=\"badge badge-primary\">Solicitada</span>'
                WHEN s.estado = 'T' THEN '<span class=\"badge badge-success\">Tramitada</span>'
                ELSE s.estado 
                END as estado_etiqueta, 
                s.estado
                FROM solicitud_actualizacion s, lugar_turistico l, usuario u
                where s.id_lugar = l.id and s.idusuarioreg = u.id ";
        if($idusuario>0) 
            $sql.=" and s.idusuarioreg=".$idusuario." and s.id_lugar = ".session()->get('lugar_id');
        
        $sql.= " order by s.fecha_solic desc";
        $query = $this->execQuery($sql);
        if($query)
             return ['data' => $query->getResultArray()];
        else
             return ['data' => []];
    }

    public function hasDetails($ids) {
        $sql = "SELECT * FROM detalle_solic_act_lugar where idsolicitud=$ids";
        $query = $this->db->query($sql);
        return $query->getNumRows()>0?true:false;   
    }
   

    public function getSolicitud($ID)
    {
        $sql = "SELECT Concat('r_', s.id) as dt_rowid, s.* FROM solicitud_actualizacion s WHERE s.id=$ID";
        $query = $this->execQuery($sql);
        if($query)
             return $query->getRowArray();
        else
            return false;

    }

    public function getListadoCampos_Actualizacion()
    {
        $query = $this->db->query("SELECT Concat('r_',id) as dt_rowid, id, titulo as descripcion  FROM campos_actualizacion order by id;");
        return $query->getResultArray();
    }


    public function getSolicitudById($id)
    {
        $solicitud = $this->select("solicitud_actualizacion.*,
                CASE 
                WHEN solicitud_actualizacion.estado = 'E' THEN '<span class=\"badge badge-secondary\">Edición</span>'
                WHEN solicitud_actualizacion.estado = 'S' THEN '<span class=\"badge badge-primary\">Solicitada</span>'
                WHEN solicitud_actualizacion.estado = 'T' THEN '<span class=\"badge badge-success\">Tramitada</span>'
                ELSE solicitud_actualizacion.estado 
                END as estado_etiqueta,
                lugar_turistico.nombre_lugar, lugar_turistico.latitud, lugar_turistico.longitud, lugar_turistico.logo, lugar_turistico.imagenes_gif")
                        ->join("lugar_turistico", "lugar_turistico.id = solicitud_actualizacion.id_lugar")
                        ->where("solicitud_actualizacion.id", $id)
                        ->first();
        if ($solicitud) {
            $detalleModel = new detalle_solic_act_model();
            $detalles = $detalleModel->where('idsolicitud', $id)
                                     ->where('idcampo <', 0)
                                     ->findAll();
            $solicitud['detalles'] = $detalles;
        }

        return $solicitud;
    }

}