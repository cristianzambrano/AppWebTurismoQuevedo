<?php

namespace App\Controllers;

use App\Models\usuario_model;


class Usuario extends BaseController
{

    public function login()
    {
            $data = [];
            $rules = [
                'cedula' => 'required|min_length[10]|max_length[10]|existsUser[cedula]',
                'clave' => 'required|min_length[8]|max_length[20]|validateUser[cedula,clave]',
            ];

            $errors = [
                'cedula' => [
                    'required' => 'Ingrese su cédula',
                    'min_length' => 'Cédula debe contener 10 dígitos',
                    'max_length' => 'Clave debe contener máximo 20 dígitos',
                    'existsUser' => 'Usuario NO registrado'
                ],
                'clave' => [
                    'validateUser' => "Cédula y Clave no son correctas",
                    'required' => 'Ingrese una clave',
                    'min_length' => 'Clave debe contener mínimo 8 dígitos',
                    'max_length' => 'Clave debe contener máximo 20 dígitos'
                ]
                
            ];

            if (!$this->validate($rules, $errors)) {

                return view('login/login', ["validation" => $this->validator]);

            } else {
                $model = new usuario_model();

                $user = $model->where('cedula', $this->request->getVar('cedula'))
                                ->first();
                $this->setUserSession($user);                

                return redirect()->to("panel");

            }
     
    }

    private function setUserSession($user)
    {
        $data = [
            'user_id' => $user['id'],
            'cedula' => $user['cedula'],
            'nombres' => $user['nombres'],
            'apellidos' => $user['apellidos'],
            'isLoggedIn' => true,
        ];

        session()->set($data);
        return true;
    }

    /*public function register()
    {
        $data = [];

        if ($this->request->getMethod() == 'post') {
            //let's do the validation here
            $rules = [
                'name' => 'required|min_length[3]|max_length[20]',
                'phone_no' => 'required|min_length[9]|max_length[20]',
                'email' => 'required|min_length[6]|max_length[50]|valid_email|is_unique[tbl_users.email]',
                'password' => 'required|min_length[8]|max_length[255]',
                'password_confirm' => 'matches[password]',
            ];

            if (!$this->validate($rules)) {

                return view('register', [
                    "validation" => $this->validator,
                ]);
            } else {
                $model = new UserModel();

                $newData = [
                    'name' => $this->request->getVar('name'),
                    'phone_no' => $this->request->getVar('phone_no'),
                    'email' => $this->request->getVar('email'),
                    'password' => $this->request->getVar('password'),
                ];
                $model->save($newData);
                $session = session();
                $session->setFlashdata('success', 'Successful Registration');
                return redirect()->to(base_url('login'));
            }
        }
        return view('register');
    }*/

    public function privacy()
    {
        return view('privacy');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('login'));
    }
      
}
