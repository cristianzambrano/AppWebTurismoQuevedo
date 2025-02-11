<?php

namespace App\Models;

use CodeIgniter\Model;
use Exception;


class detalle_solic_act_model extends Model
{
    protected $table = 'detalle_solic_act_lugar';
    protected $primaryKey       = 'id';
    protected $allowedFields = ['idsolicitud','idcampo','valorantes','valorsolic','lat_antes','lng_antes','lat_sol', 'lng_sol','estado', 'observaciones'];
    
    public function execQuery($Query){
        $query = $this->db->query($Query);
        return $query->getNumRows() > 0?$query:false;
     }
  
     protected $beforeInsert = ['beforeInsertCallback'];
     protected $beforeUpdate = ['beforeUpdateCallback'];
 
     
     protected function beforeInsertCallback(array $data)
     {
         
        $data['data']['usuario_sol'] = session()->get('user_id');
        $data['data']['fecha_sol'] = date('Y-m-d H:i:s');
        $data['data']['estado'] = 'S'; //Solicitado, Aprobado o Rechazado
        $data['data']['observaciones'] = null;
        $data['data']['usuario_tramito'] = null;
        $data['data']['fecha_tram'] = null;

         return $data;
     }
 
     // Callback antes de actualizar
     protected function beforeUpdateCallback(array $data)
     {
        //Si va a pasar a estado Aprobado o Rechazado Update el usr
        if($data['data']['estado']!='S'){
            $data['data']['usuario_tramito'] = session()->get('user_id'); 
            $data['data']['fecha_tram'] = date('Y-m-d H:i:s');
        }else{
            $data['data']['fecha_sol'] = date('Y-m-d H:i:s');
        }
         return $data;
     }

     public function findById($id)
     {
        return $this->asArray()->where(['id' => $id])->first();
     }

     
     public function getListadoDetallesCampos($idsol) {

        $sql = "SELECT s.estado as estado_solicitud, c.titulo as campo, ds.id, ds.idsolicitud, ds.idcampo, ds.fecha_sol,ds.valorsolic, ds.observaciones, ds.fecha_tram,
                ds.valorantes,
               CASE 
                WHEN ds.estado = 'S' THEN '<span class=\"badge badge-primary\">Solicitada</span>'
                WHEN ds.estado = 'A' THEN CONCAT('<span class=\"badge badge-success\">Aceptada</span><br><small class=\"text-muted\">',IFNULL(ds.observaciones,''),'</small>')
                WHEN ds.estado = 'R' THEN CONCAT('<span class=\"badge badge-danger\">Rechazada</span><br><small class=\"text-muted\">',IFNULL(ds.observaciones,''),'</small>')
                ELSE ds.estado 
                END as estado_etiqueta,
                CASE 
                    WHEN ds.estado = 'S' THEN 'Solicitada' 
                    WHEN ds.estado = 'A' THEN 'Aceptada' 
                    WHEN ds.estado = 'R' THEN 'Rechazada' 
                    ELSE ds.estado 
                END as estado
                FROM detalle_solic_act_lugar ds, campos_actualizacion c, solicitud_actualizacion s
                where ds.idcampo = c.id and ds.idcampo > 0 and s.id = ds.idsolicitud and ds.idsolicitud =".$idsol;
        $sql.= " order by ds.fecha_sol desc";
        $query = $this->execQuery($sql);
        if($query)
             return ['data' => $query->getResultArray()];
        else
            return ['data' => []];
    }
     

    public function getDetailsFromDetails($id)
    {
        $solicitud = $this->select('solicitud_actualizacion.id_lugar, campos_actualizacion.campo, detalle_solic_act_lugar.*')
                        ->join('solicitud_actualizacion', 'solicitud_actualizacion.id = detalle_solic_act_lugar.idsolicitud')
                        ->join('campos_actualizacion', 'campos_actualizacion.id = detalle_solic_act_lugar.idcampo')
                        ->where('detalle_solic_act_lugar.id', $id)
                        ->first();
        return $solicitud;
    }
    
    public function getDetailsFromDetailsOthers($id)
    {
        $solicitud = $this->select('solicitud_actualizacion.id_lugar, detalle_solic_act_lugar.*')
                        ->join('solicitud_actualizacion', 'solicitud_actualizacion.id = detalle_solic_act_lugar.idsolicitud')
                        ->where('detalle_solic_act_lugar.id', $id)
                        ->first();
        return $solicitud;
    }
}