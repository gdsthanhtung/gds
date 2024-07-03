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
        $searchField = $request->input('searchField', 'all');
        $fieldAccepted = Config::get("custom.enum.selectionInModule.".$this->moduleName);

        $this->params['filter']['fieldAccepted'] = $fieldAccepted;
        $this->params['filter']['searchField'] = (in_array($searchField, $fieldAccepted)) ? $searchField : 'all';
        $this->params['filter']['searchValue'] = $request->input('searchValue', '');

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

    public function form(Request $request)
    {
        $data = [];
        $id = $request->id;

        if($id){
             $params = [
                'id'    => $id
            ];
            $data = $this->mainModel->getItem($params, ['task' => 'get-item']);
        }

        if(!$data && $id)
            return redirect()->route('slider')->with('notify', ['type' => 'danger', 'message' => 'Slider id is invalid!']);

        $shareData = [
            'data' => $data,
            'id' => $id
        ];
        return view($this->getPathView('form'), $shareData);

    }

    public function delete(Request $request)
    {
        $params = [
            'id'    => $request->id
        ];
        $rs = $this->mainModel->delete($params);
        $notify = ($rs) ? ['type' => 'success', 'message' => 'Delete successfully!'] : ['type' => 'danger', 'message' => 'Delete failed!'];
        return redirect()->route('slider')->with('notify', $notify);
    }

    public function change_status(Request $request)
    {
        $params = [
            'id'    => $request->id,
            'status'  => $request->status
        ];

        $rs = $this->mainModel->saveItem($params, ['task' => 'change-status']);
        $notify = ($rs) ? ['type' => 'success', 'message' => 'Update successfully!'] : ['type' => 'danger', 'message' => 'Update failed!'];
        return redirect()->route('slider')->with('notify', $notify);

    }

    public function save(Request $request)
    {
        return 'Saved!';

    }
}
