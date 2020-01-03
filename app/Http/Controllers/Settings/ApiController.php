<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Laravel\Passport\Passport;

class ApiController extends Controller
{

    public function clients()
    {
        $clientModel = new Passport::$clientModel;
        $clients = $clientModel->all();

        return view('settings.clients', ['clients' => $clients]);
    }
}
