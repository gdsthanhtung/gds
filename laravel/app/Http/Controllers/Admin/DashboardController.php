<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Config;

class DashboardController extends Controller
{
    private $pathView;
    private $moduleName = "dashboard";

    public function __construct(){
        $this->pathView = "admin.pages.$this->moduleName.";
        $ctrl = Config::get("custom.route.$this->moduleName.ctrl");
        View::share(['ctrl' => $ctrl, 'pathView' => $this->pathView]);
    }

    private function getPathView(string $file = 'index'){
        return $this->pathView.$file;
    }

    //=====================================================

    public function show(Request $rq)
    {
        if ($rq->session()->has('userInfo')) {
            $user = $rq->session()->get('userInfo');
            echo "<pre>";
            print_r($user);
            echo "</pre>";
        }
        return view($this->getPathView('index'));
    }
}
