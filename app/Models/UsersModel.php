<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{
    protected $table      = 'users';
    protected $primaryKey = 'users_id';
    protected $allowedFields = [
        'users_id',
        'users_name',
    ];

    public function getUserByID($users_id)
    {
        return $this->db
            ->table($this->table)
            ->where([$this->primaryKey => $users_id])
            ->get()
            ->getResultArray()[0];
    }

    public function deleteUserByID($users_id)
    {
        return $this->db
            ->table($this->table)
            ->delete([$this->primaryKey => $users_id]);
    }
}
