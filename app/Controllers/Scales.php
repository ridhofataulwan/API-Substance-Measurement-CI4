<?php

namespace App\Controllers;

use App\Models\ScalesModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;

use function PHPUnit\Framework\countOf;

class Scales extends ResourceController
{
    use ResponseTrait;
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function __construct()
    {
        helper(['form', 'url', 'auth']);
        $this->ScalesModel = new ScalesModel();
    }
    public function getScalesAll()
    {
        $data = $this->ScalesModel->findAll();
        $response = [
            'countOfScales'   => count($data),
            'scales' => $data
        ];
        return $this->respond($response, 200);
    }
    public function getScaleByID($scales_id)
    {
        $data = $this->ScalesModel->getScaleByID($scales_id);
        return $this->respond($data, 200);
    }
    public function getScaleByCustom($custom_param, $custom_value)
    {
        $data = $this->ScalesModel->getScaleByCustom($custom_param, $custom_value);
        return $this->respond($data, 200);
    }

    public function insertScale()
    {
        $data = [
            'scales_device' => $this->request->getPost('scales_device'),
            'scales_name' => $this->request->getPost('scales_name'),
            'scales_state' => 'off', //scales_state awal insert pasti off
        ];
        $this->ScalesModel->insert($data);
        $response = [
            'status'   => 201,
            'error'    => null,
            'messages' => [
                'success' => 'Data Saved'
            ]
        ];
        return $this->respondCreated($response, 201);
    }

    public function updateScaleByID()
    {
        $putData = $this->request->getRawInput();
        $data = [
            'scales_device' => $putData['scales_device'],
            'scales_name' => $putData['scales_name'],
            //apakah update jika ada field yang tidak dibuat, akan tidak error di database?
        ];
        // Update Scale by ID 
        $this->ScalesModel->update($putData['scales_id'], $data); //ambil data id ne dari hidden form pas melakukan update
        $response = [
            'status'   => 204,
            'error'    => null,
            'messages' => [
                'success' => 'Scales ' . $putData['scales_id'] . ' is updated',
            ]
        ];
        return $this->respond($response, 204);
    }
    public function setScaleStateOnByID($scales_id)
    {
        $data = [
            'scales_state' => 'on',
        ];
        // Update State into ON 
        $this->ScalesModel->update($scales_id, $data);
        $response = [
            'status'   => 204,
            'error'    => null,
            'messages' => [
                'success' => 'Scale ' . $scales_id . ' State is ON',
                'id' => $scales_id,
                'scales_state' => $data['scales_state'],
            ]
        ];
        return $this->respond($response, 204);
    }
    public function setScaleStateOffByID($scales_id)
    {
        $data = [
            'scales_state' => 'off',
        ];
        // Update State into OFF 
        $this->ScalesModel->update($scales_id, $data);
        $response = [
            'status'   => 204,
            'error'    => null,
            'messages' => [
                'success' => 'Scale ' . $scales_id . ' State is OFF',
                'id' => $scales_id,
                'scales_state' => $data['scales_state'],
            ]
        ];
        return $this->respond($response, 204);
    }
    public function deleteScaleByID($scales_id)
    {
        $this->ScalesModel->deleteScaleByID($scales_id);
        $response = [
            'status'   => 204,
            'error'    => null,
            'messages' => [
                'success' => 'Scale ' . $scales_id . ' is deleted',
            ]
        ];
        return $this->respond($response, 204);
    }
}
