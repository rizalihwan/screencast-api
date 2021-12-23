<?php

namespace App\Http\ViewComposers;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class DataGlobalComposer
{
    public function __construct()
    {
        $this->user = new Controller();
    }

    public function compose(View $view)
    {
        $view->with('user', $this->user->getUser());
        $view->with('playlistPage', 'Playlist Management');
    }
}
