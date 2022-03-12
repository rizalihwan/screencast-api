<?php

namespace App\Http\Controllers\Api\V1\Order;

use App\Http\Controllers\Controller;
use App\Http\Resources\Order\Cart\CartResource;
use App\Http\Services\Order\Cart\{CartCommands, CartQueries};
use App\Models\Screencast\Playlist;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    public function index()
    {
        try {
            return $this->respondWithData(
                true,
                'Data berhasil di dapatkan',
                200,
                CartResource::collection(CartQueries::getListCart())
            );
        } catch (Exception $ex) {
            throw new Exception($ex->getMessage(), $ex->getCode());
        }
    }

    public function addToCart(Playlist $playlist)
    {
        DB::beginTransaction();
        try {
            $data = request()->all();

            $validator = Validator::make(
                $data,
                [
                    'user_id' => 'exists:users,id',
                    'playlist_id' => 'exists:playlists,id',
                    'price' => 'required|numeric'
                ],
                [
                    'required' => ':attribute tidak boleh kosong',
                    'exists' => ':attribute tidak ditemukan.',
                    'numeric' => ':attribute yang dimasukan harus angka'
                ],
                [
                    'user_id' => 'User ID',
                    'playlist_id' => 'Playlist ID',
                    'price' => 'Price'
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

            if (auth()->user()->alreadyInCart($playlist)) {
                return $this->respondWithData(false, 'Playlist is already in the cart.', 405, []);
            }

            $data['playlist_id'] = $playlist->id;
            $record = CartCommands::create($data);

            DB::commit();
            return $this->respondWithData(true, 'Success saved data', 200, new CartResource($record));
        } catch (Exception $e) {
            DB::rollBack();
            return $this->respondErrorException($e, request());
        }
    }
}
