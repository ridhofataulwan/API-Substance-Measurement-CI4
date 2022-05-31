<?php

namespace App\Models;

use CodeIgniter\Model;

class ScalesModel extends Model
{
    protected $table      = 'scales';
    protected $primaryKey = 'scales_id';
    protected $allowedFields = [
        'scales_id',
        'scales_device',
        'scales_name',
        'scales_state',
    ];

    public function getScaleByID($scales_id)
    {
        return $this->db
            ->table($this->table)
            ->where([$this->primaryKey => $scales_id])
            ->get()
            ->getResultArray()[0];
    }

    public function getScaleByCustom($custom_param, $custom_value)
    {
        /*Custom Param tinggal menambahkan id, device, name, dan state saja
        Tidak perlu pakai "scales_"
        */
        return $this->db
            ->table($this->table)
            ->where(['scales_' . $custom_param => $custom_value])
            ->get()
            ->getResultArray();
    }

    public function deleteScaleByID($scales_id)
    {
        return $this->db
            ->table($this->table)
            ->delete([$this->primaryKey => $scales_id]);
    }
}
