<?php
namespace App\Http\Controllers\Mq;


use App\Http\Controllers\Controller;

class MqController extends Controller
{

    public function index(){

        require_once __DIR__.'/vendor/autoload.php';

    }

}