<?php

namespace App\Http\Controllers;

use App\DiallingCode;
use App\Http\Requests\TwoFactorSettingsRequest;
use App\Services\Authy\Exceptions\RegistrationFailedException;
use Illuminate\Http\Request;

class TwoFactorSettingsController extends Controller
{
    public function index()
    {
    	$diallingCodes = DiallingCode::all();
    	return view('settings.twofactor', compact('diallingCodes'));
    }

    public function update(TwoFactorSettingsRequest $request)
    {
    	$user = $request->user();

    	$user->updatePhoneNumber(
    		$request->phone_number,
    		$request->phone_number_dialling_code
    	);

    	if (!$user->registeredForTwoFactorAuthentication()) {
    		try {
    			$authyId = \Authy::registerUser($user);
    			$user->authy_id = $authyId;
    		} catch (RegistrationFailedException $e) {
    			return redirect()->back();
    		}
    	}

    	$user->two_factor_type = $request->two_factor_type;
    	$user->save();

    	return redirect()->back(); 
    }
}
