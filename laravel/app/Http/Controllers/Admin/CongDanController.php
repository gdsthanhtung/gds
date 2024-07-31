<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\CongDanModel as MainModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Http\Requests\CongDanRequest as MainRequest;
use App\Helpers\Notify;
use Config;

class CongDanController extends Controller
{
    private $mainModel;
    private $pathView;
    private $pathViewTemplate;
    private $moduleName = "congdan";
    private $pageTitle = "Công Dân";
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
        $searchField = $rq->input('searchField', 'all');
        $fieldAccepted = Config::get("custom.enum.selectionInModule.".$this->moduleName);

        $this->params['filter']['fieldAccepted'] = $fieldAccepted;
        $this->params['filter']['searchField'] = (in_array($searchField, $fieldAccepted)) ? $searchField : 'all';
        $this->params['filter']['searchValue'] = $rq->input('searchValue', '');

        $this->params['filter']['status'] = $rq->input('status', 'all');

        $data = $this->mainModel->listItems($this->params, ['task' => 'admin-list-items']);
        $countByStatus = $this->mainModel->countItems($this->params, ['task' => 'admin-count-items']);

        $shareData = [
            'data' => $data,
            'countByStatus' => $countByStatus,
            'params' => $this->params
        ];
        return view($this->getPathView('index'), $shareData);
    }

    public function form(Request $rq)
    {
        $data = [];
        $id = $rq->id;

        if($id){
             $params = [
                'id'    => $id
            ];
            $data = $this->mainModel->getItem($params, ['task' => 'get-item']);
        }

        if(!$data && $id)
            return redirect()->route($this->moduleName)->with('notify', ['type' => 'danger', 'message' => 'Id is invalid!']);

        $shareData = [
            'data' => $data,
            'id' => $id
        ];
        return view($this->getPathView('form'), $shareData);

    }

    public function delete(Request $rq)
    {
        $params = [
            'id'    => $rq->id
        ];
        $rs = $this->mainModel->delete($params);
        return redirect()->route($this->moduleName)->with('notify', Notify::export($rs));
    }

    public function change_status(Request $rq)
    {
        $params = [
            'id'    => $rq->id,
            'status'  => $rq->status
        ];

        $rs = $this->mainModel->saveItem($params, ['task' => 'change-status']);
        return redirect()->route($this->moduleName)->with('notify', Notify::export($rs));

    }

    public function save(MainRequest $rq)
    {
        if($rq->method() == 'POST'){
            $params = $rq->all();

            $rs = $this->mainModel->saveItem($params, ['task' => $params['task']]);
        }
        return redirect()->route($this->moduleName)->with('notify', Notify::export($rs));
    }
}
