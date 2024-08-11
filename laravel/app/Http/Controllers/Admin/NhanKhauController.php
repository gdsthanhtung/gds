<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\NhanKhauModel as MainModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Http\Requests\NhanKhauRequest  as MainRequest;
use App\Helpers\Notify;
use Config;

use App\Models\CongDanModel;
use App\Models\PhongTroModel;

class NhanKhauController extends Controller
{
    private $mainModel;
    private $pathView;
    private $pathViewTemplate;
    private $moduleName = "nhankhau";
    private $pageTitle = "Nhân Khẩu";
    private $params = [];

    public function __construct(){
        $this->mainModel = new MainModel();
        $this->pathView = "admin.pages.$this->moduleName.";
        $this->pathViewTemplate = "admin.templates.";

        $this->params["pagination"]['perPage'] = 10;

        $ctrl = Config::get("custom.route.$this->moduleName.ctrl");
        View::share([
            'ctrl' => $ctrl,
            'pathView' => $this->pathView,
            'pathViewTemplate' => $this->pathViewTemplate,
            'pageTitle' => $this->pageTitle
        ]);
    }

    private function getPathView(string $file = 'index'){
        return $this->pathView.$file;
    }

    //=====================================================

    public function show(Request $rq)
    {
        // Do something ...
    }

    public function form(Request $rq)
    {
        // Do something ...
    }

    public function delete(Request $rq)
    {
        // Do something ...
    }

    public function change_status(Request $rq)
    {
        // Do something ...
    }

    public function save(MainRequest $rq)
    {
        if($rq->method() == 'POST'){
            $params = $rq->all();
            $rs = $this->mainModel->save($params);
        }
        return redirect()->route('hopdong')->with('notify', Notify::export($rs));
    }
}
