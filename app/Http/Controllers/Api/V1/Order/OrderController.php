<?php

namespace App\Http\Controllers\Api\V1\Order;

use App\Http\Controllers\Controller;
use App\Models\Order\Order;
use App\Models\Screencast\Playlist;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->algorithm = "sha512";
    }

    public function store()
    {
        $user = Auth::user();

        $order = $user->orders()->create([
            'trx_no' => "ORDER-" . time(),
            'playlist_ids' => $user->carts->pluck('playlist_id'),
            'total' => $user->carts->sum('price')
        ]);

        $params = [
            "enabled_payments" => [
                "credit_card", "cimb_clicks",
                "bca_klikbca", "bca_klikpay", "bri_epay", "echannel", "permata_va",
                "bca_va", "bni_va", "bri_va", "other_va", "gopay", "indomaret",
                "danamon_online", "akulaku", "shopeepay"
            ],
            "transaction_details" => [
                'order_id' => $order->trx_no,
                'gross_amount' => $order->total
            ],
            "customer_details" => $user,
            "expiry" => [
                "start_time" => now()->format('Y-m-d H:i:s T'),
                "unit" => "days",
                "duration" => 1
            ]
        ];

        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Basic ' . base64_encode(config('credentials.payment.server_key'))
        ];

        $url = "https://app.sandbox.midtrans.com/snap/v1/transactions";
        $response = Http::withHeaders($headers)->post($url, $params);

        return $response;
    }

    public function notificationHandler(Request $request)
    {
        $signature = hash($this->algorithm, $request->order_id . $request->status_code . $request->gross_amount . config('credentials.payment.server_key'));

        if($signature !== $request->signature_key) {
            return false;
        }

        $order = Order::where('trx_no', $request->order_id)->first();
        $user = User::find($order->user_id);

        foreach($order->playlist_ids as $playlistKey) {
            $playlist = Playlist::find($playlistKey);
            $user->buy_playlist($playlist);
        }

        $order->delete();
        $user->carts()->delete();

        return;
    }
}
