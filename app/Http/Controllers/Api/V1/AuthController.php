<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Auth\UserResource;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    protected function bannedPassword($request)
    {
        $password = ['password', '12345678', '87654321', 'qwertyuio', 'admin12345'];

        if (in_array($request, $password)) {
            return true;
        }

        return false;
    }

    public function register(Request $request)
    {
        try {
            $data = $request->all();

            $validator = Validator::make(
                $data,
                [
                    'name' => 'required|string|min:3|max:50',
                    'email' => 'required|email|unique:users,email',
                    'password' => 'required|min:8'
                ],
                [
                    'required' => ':attribute tidak boleh kosong',
                    'unique' => ':attribute yang dimasukan sudah ada',
                    'max' => ':attribute yang dimasukan maksimal :max karakter',
                    'min' => ':attribute yang dimasukan minimal :min karakter'
                ],
                [
                    'name' => 'Nama',
                    'email' => 'E-Mail',
                    'password' => 'Password'
                ]
            );

            if ($validator->fails()) {
                $errors = collect();
                foreach ($validator->errors()->getMessages() as $key => $value) {
                    foreach ($value as $error) {
                        $errors->push($error);
                    }
                }
                return $this->respondValidationError($errors, 'Validation Error!');
            }

            if ($this->bannedPassword($data['password'])) {
                return response(['ERROR' => true, 'MESSAGE' => 'Password yang dimasukan tidak di izinkan!', 'STATUS_CODE' => 400], 500);
            }

            $data['password'] = Hash::make($request->password);
            $user = User::create($data);
            $token = $user->createToken("userToken");

            return $this->respondWithData(true, "Success saved data.", 200, [
                'user' => new UserResource($user),
                'token_login' => [
                    'token_for_prefix' => $token->accessToken,
                    'token' => $token->plainTextToken
                ]
            ]);
        } catch (Exception $e) {
            return $this->respondErrorException($e, request());
        }
    }
}
