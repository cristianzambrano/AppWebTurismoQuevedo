<?php

namespace App\Models;

use CodeIgniter\Model;

class camposactualizacion_model  extends Model
{
    protected $table = 'campos_actualizacion';
    protected $primaryKey = 'id';
    protected $allowedFields = ['campo', 'titulo'];

    public function getCampoNombre($campoId)
    {
        $registro = $this->find($campoId);
        if (!$registro)      return null;

        return $registro['campo'];
    }
}
