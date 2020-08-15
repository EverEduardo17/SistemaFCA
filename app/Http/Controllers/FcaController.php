<?php

namespace App\Http\Controllers;

class FcaController extends Controller
{
    private $flash;

    public function __construct(){
        $this->flash = array();
    }

    public function addFlash($type, $message){
        $this->flash[] = [
            'type'    => $type,
            'message' => $message
        ];
    }

    public function setFlash($flash){
        $this->flash = $flash;
    }

    public function getFlash(){
        return $this->flash;
    }
}
