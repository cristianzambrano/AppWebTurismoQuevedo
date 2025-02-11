<?php

namespace App\Controllers;


class Errors  extends BaseController
{

    public function unauthorized()
    {
        return view('errors/unauthorized');
    }
      
}
