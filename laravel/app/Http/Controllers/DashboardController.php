<?php

namespace App\Http\Controllers;

//use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Config;

class DashboardController extends Controller
{
    private $path_view = 'admin.dashboard.';

    public function __construct(){
        View::share('ctrl', Config::get('custom.route.dashboard.ctrl', 'dashboard'));
    }

    private function get_path_view(string $file = 'index'){
        return $this->path_view.$file;
    }

    //=====================================================

    public function show()
    {
        return view($this->get_path_view('index'));
    }
}
