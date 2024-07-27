<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Config;

class DashboardController extends Controller
{
    private $pathView;
    private $pathViewTemplate;
    private $moduleName = "dashboard";

    public function __construct(){
        $this->pathView = "admin.pages.$this->moduleName.";
        $this->pathViewTemplate = "admin.templates.";
        $ctrl = Config::get("custom.route.$this->moduleName.ctrl");
        View::share(['ctrl' => $ctrl, 'pathView' => $this->pathView, 'pathViewTemplate' => $this->pathViewTemplate]);
    }

    private function getPathView(string $file = 'index'){
        return $this->pathView.$file;
    }

    //=====================================================

    public function show(Request $rq)
    {
        return view($this->getPathView('index'));
    }
}
