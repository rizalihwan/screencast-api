<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getUser()
    {
        return auth()->user();
    }

    public function respondRedirectMessage($route, $type, $content)
    {
        return redirect()->route($route)->with($type, $content);
    }

    public function respondWithErrors($route, $validator, $type)
    {
        return redirect()->route($route)->withErrors($validator, $type)->withInput();
    }

    public function overwritePriceFormat($request)
    {
        $price = preg_replace('/[Rp. ]/', '', $request);

        if (!is_numeric($price))
            throw new \Exception("The input price format entered must be numeric!", 400);
        else
            return $price;
    }

    public function generateSlug($data)
    {
        try {
            return (string) "scrcas_" . \Str::slug($data . '-' . strtolower(\Str::random(20))) . "_{$this->getUser()->id}";
        } catch (\Exception $ex) {
            throw new \Exception("Slug generate not responding! {$ex->getMessage} - Status Code : {$ex->getCode}");
        }
    }
}
