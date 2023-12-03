<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

class Create_PW extends ResourceController
{
    use ResponseTrait;

    public function index()
    {
        helper(array('text'));
        //Insisalisasi model yang digunakan


        for ($i = 0; $i < 569; $i++) {
            $pass = random_string('alnum', 5);
            echo $pass . " = " . password_hash($pass, PASSWORD_BCRYPT) . "<br>";
        }
    }
}
