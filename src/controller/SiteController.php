<?php

namespace MVC\controller;

use MVC\core\Application;
use MVC\core\Controller;
use MVC\core\Request;

class SiteController extends Controller
{
    public function  home()
    {
        $params = ['name' => 'Pouria'];
        return $this->render('home',$params);
    }
    public function contact()
    {
        return $this->render('contact');
    }
    public function handleContact(Request $request)
    {
        $body = $request->getBody();
    }
}