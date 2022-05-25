<?php

namespace App\Models;

use CodeIgniter\Model;

class ExperimentsModel extends Model
{
    protected $table      = 'experiments';
    protected $primaryKey = 'experiments_id';
    protected $allowedFields = [
        'experiments_id',
        'experiments_name',
        'experiments_desc',
        'experiments_state',
        'experiments_user',
        'experiments_scales',
    ];

    public function getExperimentByID($experiments_id)
    {
        /*
        return $this->db
            ->table($this->table)
            ->where([$this->primaryKey => $experiments_id])
            ->get()
            ->getResultArray();
        */
        // Bisa pakai atas atau yang bawah (Bawah lebih simple)
        return $this
            ->where([$this->primaryKey => $experiments_id])
            ->first();
    }

    public function getExperimentsByUser($users_id)
    {
        return $this->db
            ->table($this->table)->join('users', 'experiments.experiments_user=users.users_id')
            ->where(['users_id' => $users_id])
            ->get()
            ->getResultArray();
    }

    public function deleteExperimentByID($experiments_id)
    {
        return $this->db
            ->table($this->table)
            ->delete([$this->primaryKey => $experiments_id]);
    }

    // Dipake buat mencari state experiments
    public function getExperimentsScalesByState($experiments_state, $scales_state, $scales_device)
    {
        return $this
            ->table($this->table)->join('scales', 'experiments.experiments_scales=scales.scales_id')
            ->where(['experiments_state' => $experiments_state])
            ->where(['scales_state' => $scales_state])
            ->where(['scales_device' => $scales_device])
            ->first();
    }
}
