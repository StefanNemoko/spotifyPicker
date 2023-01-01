<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Http\Spotify\Spotify;

class ApiController extends Controller
{

    private $spotify;
    private $state;

    function __construct(){
        $this->spotify = new Spotify();
    }

    public function home(){
        $this->spotify->authenticateUser($this->state);
    }


    public function bearer(Request $request){
        $state = $request->state;
        $code = $request->code;
        $redirect_uri = $request->requestUri;

        $this->spotify->getAccessToken($code, $redirect_uri);
        var_dump($this->state);
        if(base64_decode($state) === $this->state){
            dd($code);
        }else{
            dd("TEST");
        }
        // met code kan je een access token ophalen.
    }

    private function generateState(){
        $seed = str_split(
            'abcdefghijklmnopqrstuvwxyz'
            .'ABCDEFGHIJKLMNOPQRSTUVWXYZ'
            .'0123456789!@#$%^&*()');
        shuffle($seed); // probably optional since array_is randomized; this may be redundant
        $rand = '';
        foreach (array_rand($seed, 24) as $k) $rand .= $seed[$k];
        $this->state = $rand;
    }

}
