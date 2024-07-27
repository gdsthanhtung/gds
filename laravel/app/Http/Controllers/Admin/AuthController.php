<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\UserModel as MainModel;
use Illuminate\Support\Facades\View;
use App\Http\Requests\AuthRequest as MainRequest;
use App\Helpers\Notify;
use Config;

class AuthController extends Controller
{
    private $mainModel;
    private $pathView;
    private $pathViewTemplate;
    private $moduleName = "auth";

    public function __construct(){
        $this->mainModel = new MainModel();
        $this->pathView = "admin.pages.$this->moduleName.";
        $this->pathViewTemplate = "admin.templates.";

        $ctrl = Config::get("custom.route.$this->moduleName.ctrl");
        View::share(['ctrl' => $ctrl, 'pathView' => $this->pathView, 'pathViewTemplate' => $this->pathViewTemplate]);
    }

    private function getPathView(string $file = 'index'){
        return $this->pathView.$file;
    }

    //=====================================================

    public function show(MainRequest $rq){
        return view($this->getPathView('login'));
    }

    public function do_login(MainRequest $rq){
        $target = 'auth';
        if($rq->method() == 'POST'){
            $params = [
                'email'    => $rq->email,
                'password'  => $rq->password
            ];
            $rs = $this->mainModel->getItem($params, ['task' => 'do-login']);
        }
        if($rs) {
            $rq->session()->put('userInfo', $rs);
            $target = ($rs['level'] == 'admin') ? 'dashboard' : '/';
        }
        return redirect()->route($target)->with('notify', Notify::export($rs, ['sMsg' => 'Đăng nhập thành công!', 'eMsg' => 'Đăng nhập thất bại!']));
    }

    public function logout(MainRequest $rq){
        $rs = false;
        if ($rq->session()->has('userInfo')) {
            $rq->session()->forget('userInfo');
            $rs = true;
        }
        return redirect()->route('/')->with('notify', Notify::export($rs, ['sMsg' => 'Đăng xuất thành công!', 'eMsg' => 'Đăng xuất thất bại!']));
    }
}
