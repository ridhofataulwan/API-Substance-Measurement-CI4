<?php

namespace App\Controllers;

use App\Models\ExperimentsModel;
use App\Models\RecordsModel;
use CodeIgniter\RESTful\ResourceController;

class Records extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function __construct()
    {
        helper(['form', 'url', 'auth']);
        $this->RecordsModel = new RecordsModel();
        $this->ExperimentsModel = new ExperimentsModel();
    }

    public function getRecordsByExperimentsID($experiments_id)
    {
        $data = $this->RecordsModel->getRecordsByExperimentsID($experiments_id);
        return $this->respond($data, 200);
    }

    public function insertRecord($device, $value, $timestamp)
    {
        $get = $this->ExperimentsModel->getExperimentsScalesByState('doing', 'on', $device);
        $data = [
            'records_value' => $value,
            'records_timestamp' => $timestamp,
            'records_experiments' => $get['experiments_id'],
        ];
        $this->RecordsModel->insert($data);
        $response = [
            'status'   => 201,
            'error'    => null,
            'messages' => [
                'success' => 'Record succsesful created',
            ]
        ];
        return $this->respondCreated($response, 201);
    }
}
