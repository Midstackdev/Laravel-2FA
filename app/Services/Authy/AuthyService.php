<?php

namespace App\Services\Authy;

use App\Services\Authy\Exceptions\{SmsRequestFailedException, InvalidTokenException, RegistrationFailedException};
use App\User;
use Authy\AuthyApi;


class AuthyService
{
	private $cient;

	public function __construct(AuthyApi $client)
	{
		$this->client = $client;
	}

	public function registerUser(User $user)
	{
		$user = $this->client->registerUser(
			$user->email,
			$user->phoneNumber->phone_number,
			$user->phoneNumber->diallingCode->dialling_code
		);

		if (!$user->ok()) {
			throw new RegistrationFailedException;
		}

		return $user->id();
	}

	public function verifyToken($token, User $user = null)
	{
		try {
			$verification = $this->client->verifyToken(
				$user ? $user->auth_id : request()->session()->get('authy.authy_id'),
				$token
			);

		} catch (AuthyFormatException $e) {
			throw new InvalidTokenException;
		}

		if (!$verification->ok()) {
			throw new InvalidTokenException;
		}

		return true;
	}

	public function requestSms(User $user)
	{
		$request = $this->client->requestSms($user->authy_id, [
			'force' => true,
		]);

		if (!$request->ok()) {
			throw new SmsRequestFailedException;
		}
	}
}