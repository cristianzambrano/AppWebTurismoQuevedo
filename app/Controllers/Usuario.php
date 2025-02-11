<?php

namespace App\Controllers;

use App\Models\usuario_model;
use App\Models\lugarturistico_model;


class Usuario extends BaseController
{

    public function login()
    {
            $data = [];
            $rules = [
                'cedula' => 'required|min_length[10]|max_length[20]|existsUser[cedula]',
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

                if ($user['rol'] == 'propietario_local') {
                    $lugarModel = new lugarturistico_model();
                    $lugares = $lugarModel->where('id_usrpropietario', $user['id'])->findAll();
                    
                    return view('login/login_lugar', ['user' => $user,'lugares' => $lugares]);

                } else {

                    session()->set('isLoggedIn', true);
                    return redirect()->to("panel");

                }

            }
     
    }

    public function seleccionarLugar(){
        
        if (!session()->has('rol') || !session()->has('user_id')) return redirect()->to('/unauthorized');
        if (session()->get('rol') !== 'propietario_local')        return redirect()->to('/unauthorized');


        $input = $this->getRequestInput($this->request);
        $lugarId = $input['lugar_id'];

        if (!isset($lugarId))         return $this->sendBadRequest('Parámetro ID requerido');
        if (!is_numeric($lugarId))    return $this->sendBadRequest('Parámetro ID numérico');
        if ($lugarId < 1)             return $this->sendBadRequest('Parámetro ID numérico mayor a 0');
    

        $lugarModel = new lugarturistico_model();
        $lugar = $lugarModel->find($lugarId);
        if ($lugar) {
                session()->set('lugar_id', $lugar['id']);
                session()->set('isLoggedIn', true);
                return redirect()->to("panel");

        } else {
                return $this->sendBadRequest('Parámetro ID No existe Lugar');
       }
    }

    private function setUserSession($user)
    {
        if(file_exists('assets/imgs/usuario/' . $user['foto']))
              $foto = $user['foto'];
        else  $foto = 'unknown.jpg';

        $data = [
            'user_id' => $user['id'],
            'cedula' => $user['cedula'],
            'nombres' => $user['nombres'],
            'apellidos' => $user['apellidos'],
            'foto' => $foto,
            'rol' => $user['rol'],
            'isLoggedIn' => false
        ];

        $model_usuario = new usuario_model();
        $data['menu_items'] = $model_usuario->get_menu_items_by_role($user['rol']);

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
