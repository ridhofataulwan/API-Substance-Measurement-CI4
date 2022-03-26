<?php

namespace App\Models;

use CodeIgniter\Model;

class RecordsModel extends Model
{
    protected $table      = 'records';
    protected $primaryKey = 'records_id';
    protected $allowedFields = [
        'records_id',
        'records_value',
        'records_timestamp',
        'records_experiments',
    ];

    public function getRecordsByExperimentsID($experiments_id)
    {
        return $this->db
            ->table($this->table)
            ->where([$this->primaryKey => $experiments_id])
            ->get()
            ->getResultArray();
    }
}
