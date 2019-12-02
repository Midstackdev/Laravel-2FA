<?php

namespace App\Http\Controllers;

use App\DiallingCode;
use Illuminate\Http\Request;

class TwoFactorSettingsController extends Controller
{
    public function index()
    {
    	$diallingCodes = DiallingCode::all();
    	return view('settings.twofactor', compact('diallingCodes'));
    }

    public function update()
    {
    	dd('settings.twofactor');
    }
}
