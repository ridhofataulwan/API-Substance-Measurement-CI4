<?php

namespace App\Controllers;

use App\Models\UsersModel;
use CodeIgniter\RESTful\ResourceController;

class Users extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function __construct()
    {
        helper(['form', 'url', 'auth']);
        $this->UsersModel = new UsersModel();
    }
    public function getUsersAll()
    {
        $data = $this->UsersModel->findAll();
        $response = [
            'countOfUsers'   => count($data),
            'users' => $data
        ];
        return $this->respond($response, 200);
    }
    public function getUserByID($users_id)
    {
        $data = $this->UsersModel->getUserByID($users_id);
        return $this->respond($data, 200);
    }

    public function insertUser()
    {
        $data = [
            'users_name' => $this->request->getPost('users_name'),
        ];
        $this->UsersModel->insert($data);
        $response = [
            'status'   => 201,
            'error'    => null,
            'messages' => [
                'success' => 'Data Saved'
            ]
        ];
        return $this->respondCreated($response, 201);
    }

    public function updateUserByID()
    {
        $putData = $this->request->getRawInput();
        $data = [
            'users_name' => $putData['users_name'],
            //apakah update jika ada field yang tidak dibuat, akan tidak error di database?
        ];
        // Update Users by ID 
        $this->UsersModel->update($putData['users_id'], $data); //ambil data id ne dari hidden form pas melakukan update
        $response = [
            'status'   => 204,
            'error'    => null,
            'messages' => [
                'success' => 'Users ' . $putData['users_id'] . ' is updated',
            ]
        ];
        return $this->respond($response);
    }

    public function deleteUserByID($users_id)
    {
        $this->UsersModel->deleteUserByID($users_id);
        $response = [
            'status'   => 204,
            'error'    => null,
            'messages' => [
                'success' => 'Users ' . $users_id . ' is deleted',
            ]
        ];
        return $this->respond($response);
    }
}
