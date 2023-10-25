<?php

namespace MVC\controller;

use MVC\core\Application;
use MVC\core\Controller;
use MVC\core\Request;
use MVC\model\User;

class AuthController extends Controller
{
    public function login()
    {
        $this->setLayout('auth');
        return $this->render('login');
    }

    public function register(Request $request)
    {
        $user = new User();
        if($request->isPost()){
            $user->loaddata($request->getBody());
            if($user->validate() && $user->save()){
                Application::$app->session->setFlash('success' , 'thank you');
                Application::$app->response->redirect('/');
            }
            return $this->render('register' , [
                'model' => $user
            ]);
        }
        $this->setLayout('auth');
        return $this->render('register' , [
            'model' => $registerModel
            ]);
    }
}