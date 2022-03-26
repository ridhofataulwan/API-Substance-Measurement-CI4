<?php

namespace App\Controllers;

use App\Models\ExperimentsModel;
use CodeIgniter\RESTful\ResourceController;

class Experiments extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function __construct()
    {
        helper(['form', 'url', 'auth']);
        $this->ExperimentsModel = new ExperimentsModel();
    }

    public function getExperimentsAll()
    {
        $data = $this->ExperimentsModel->findAll();
        $response = [
            'countOfExperiments'   => count($data),
            'experiments' => $data
        ];
        return $this->respond($response, 200);
    }
    public function getExperimentByID($experiments_id)
    {
        $data = $this->ExperimentsModel->getExperimentByID($experiments_id);
        return $this->respond($data, 200);
    }
    public function getExperimentsByUser($users_id)
    {
        $data = $this->ExperimentsModel->getExperimentsByUser($users_id);
        $response = [
            'countOfExperiments'   => count($data),
            'experiments' => $data
        ];
        return $this->respond($response, 200);
    }
    public function insertExperiment()
    {
        $data = [
            'experiments_name' => $this->request->getPost('experiments_name'),
            'experiments_desc' => $this->request->getPost('experiments_desc'),
            'experiments_state' => $this->request->getPost('experiments_state'),
            'experiments_user' => $this->request->getPost('experiments_user'),
            'experiments_scales' => $this->request->getPost('experiments_scales'),
        ];
        $this->ExperimentsModel->insert($data);
        $response = [
            'status'   => 201,
            'error'    => null,
            'messages' => [
                'success' => 'Experiment ' . $this->request->getPost('experiments_name') . ' created'
            ]
        ];
        return $this->respondCreated($response, 201);
    }
    public function updateExperimentByID()
    {
        $putData = $this->request->getRawInput();
        $data = [
            'experiments_id' => $putData['experiments_id'],
            'experiments_name' => $putData['experiments_name'],
            'experiments_desc' => $putData['experiments_desc'],
            'experiments_user' => $putData['experiments_user'],
            'experiments_scales' => $putData['experiments_scales'],
        ];
        $this->ExperimentsModel->update($putData['experiments_id'], $data);
        $response = [
            'status'   => 204,
            'error'    => null,
            'messages' => [
                'success' => 'Experiment ' . $putData['experiments_name'] . ' updated'
            ]
        ];
        return $this->respond($response);
    }
    public function setExperimentsStateDoingByID($experiments_id)
    {
        $data = [
            'experiments_state' => 'doing',
        ];
        $this->ExperimentsModel->update($experiments_id, $data);
        $response = [
            'status'   => 204,
            'error'    => null,
            'messages' => [
                'success' => 'Experiment ' . $experiments_id . ' State is Doing'
            ]
        ];
        return $this->respond($response);
    }
    public function setExperimentsStateFinishedByID($experiments_id)
    {
        $data = [
            'experiments_state' => 'finished',
        ];
        $this->ExperimentsModel->update($experiments_id, $data);
        $response = [
            'status'   => 204,
            'error'    => null,
            'messages' => [
                'success' => 'Experiment ' . $experiments_id . ' State is Finished'
            ]
        ];
        return $this->respond($response);
    }
    public function deleteExperimentByID($experiments_id)
    {
        $this->ExperimentsModel->delete($experiments_id);
        $response = [
            'status'   => 204,
            'error'    => null,
            'messages' => [
                'success' => 'Experiment ' . $experiments_id . ' is deleted',
            ]
        ];
        return $this->respond($response);
    }
}
