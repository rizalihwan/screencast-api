<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __invoke()
    {
        try {
            $user = Auth::check() ? $this->getUser() : null;
        } catch (\Exception $ex) {
            return "Error {$ex->getMessage()}";
        }

        return view('dashboard', compact('user'));
    }
}
