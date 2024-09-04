<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\HopDongModel as MainModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Http\Requests\HopDongRequest  as MainRequest;
use App\Helpers\Notify;
use Config;

use App\Models\CongDanModel;
use App\Models\PhongTroModel;
use PDF;

class HopDongController extends Controller
{
    private $mainModel;
    private $pathView;
    private $pathViewTemplate;
    private $moduleName = "hopdong";
    private $pageTitle = "Hợp Đồng";
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

        $nkInHopDong = ($data) ? $this->mainModel->assignNK($data->toArray()['data']) : [];

        $shareData = [
            'data' => $data,
            'countByStatus' => $countByStatus,
            'params' => $this->params,
            'nkInHopDong' => $nkInHopDong
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
            return redirect()->route($this->moduleName)->with('notify', ['type' => 'danger', 'message' => $this->pageTitle.' id is invalid!']);

            $congDanModel = new CongDanModel();
            $dataCongDan = $congDanModel->listItems([], ['task' => 'admin-list-items-to-select']);

            $phongTroModel = new PhongTroModel();
            $dataPhongTro = $phongTroModel->listItems([], ['task' => 'admin-list-items-to-select']);

            $nkInHopDong = ($data) ? $this->mainModel->assignNK([$data->toArray()]) : [];

        $shareData = [
            'data' => $data,
            'id' => $id,
            'dataCongDan' => $dataCongDan,
            'dataPhongTro' => $dataPhongTro,
            'nkInHopDong' => $nkInHopDong
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

            $task = ($params['id'] == null) ? 'add' : 'edit';

            $rs = $this->mainModel->saveItem($params, ['task' => $task]);
        }
        return redirect()->route($this->moduleName)->with('notify', Notify::export($rs));
    }

    public function export(Request $rq)
    {
        $id = $rq->id;
        $task = $rq->task;
        $thoiHanONho = $rq->thoiHanONho;
        $thoiHanTuNgay = $rq->thoiHanTuNgay;

        $params = [
            'id' => $id
        ];

        if($task == 'hdtn' && $id){
            $data = $this->mainModel->getItem($params, ['task' => 'get-item-with-chu-ho']);
            $nkInHopDong = ($data) ? $this->mainModel->assignNK([$data]) : [];

            $shareData = [
                'id' => $id,
                'data' => $data,
                'nkInHopDong' => $nkInHopDong,
                'thoiHanONho' => $thoiHanONho,
                'thoiHanTuNgay' => $thoiHanTuNgay
            ];

            //return view($this->getPathView('export_hdtn'), $shareData);

            $pdf = PDF::loadView($this->getPathView('export_hdtn'), $shareData);
            return $pdf->stream()->header('Content-Type','application/pdf');
            return $pdf->download('hop-dong-thue-nha.pdf');
        }

        return redirect()->route($this->moduleName)->with('notify', ['type' => 'danger', 'message' => 'Bad Request!']);
    }
}
