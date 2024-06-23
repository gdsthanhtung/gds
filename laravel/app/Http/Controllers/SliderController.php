<?php

namespace App\Http\Controllers;

use App\Models\SliderModel as MainModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Config;

class SliderController extends Controller
{
    private $mainModel;
    private $pathView;
    private $pathViewTemplate;
    private $moduleName = "slider";
    private $params = [];

    public function __construct(){
        $this->mainModel = new MainModel();
        $this->pathView = "admin.pages.$this->moduleName.";
        $this->pathViewTemplate = "admin.templates.";

        $this->params["pagination"]['perPage'] = 2;

        $ctrl = Config::get("custom.route.$this->moduleName.ctrl");
        View::share(['ctrl' => $ctrl, 'pathView' => $this->pathView, 'pathViewTemplate' => $this->pathViewTemplate]);
    }

    private function getPathView(string $file = 'index'){
        return $this->pathView.$file;
    }

    //=====================================================

    public function show(Request $request)
    {
        $this->params['filter']['status'] = $request->input('status', 'all');

        $data = $this->mainModel->listItems($this->params, ['task' => 'admin-list-items']);
        $countByStatus = $this->mainModel->countItems($this->params, ['task' => 'admin-count-items']);

        $shareData = [
            'data' => $data,
            'countByStatus' => $countByStatus,
            'params' => $this->params
        ];
        return view($this->getPathView('index'), $shareData);
    }

    public function edit(Request $request)
    {
        $data = [
            'id'    => $request->id,
            'name'  => $request->name
        ];
        return view($this->getPathView('form'), $data);
    }

    public function delete(Request $request)
    {
        $data = [
            'id'    => $request->id
        ];
        return view($this->getPathView('delete'), $data);
    }

    public function change_status(Request $request)
    {
        $data = [
            'id'    => $request->id,
            'status'  => $request->status
        ];
        view($this->getPathView('change-status'), $data);
        sleep(2);
        return redirect()->route('slider');

    }
}
