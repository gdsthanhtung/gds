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
        $ctrl = Config::get('custom.route.slider.ctrl', 'slider');
        View::share('ctrl', $ctrl);
    }

    private function get_path_view(string $file = 'index'){
        return $this->path_view.$file;
    }

    //=====================================================

    public function show()
    {
        return view($this->get_path_view('index'));
    }

    public function edit(Request $request)
    {
        $data = [
            'id'    => $request->id,
            'name'  => $request->name
        ];
        return view($this->get_path_view('form'), $data);
    }

    public function delete(Request $request)
    {
        $data = [
            'id'    => $request->id
        ];
        return view($this->get_path_view('delete'), $data);
    }

    public function change_status(Request $request)
    {
        $data = [
            'id'    => $request->id,
            'status'  => $request->status
        ];
        view($this->get_path_view('change-status'), $data);
        sleep(2);
        return redirect()->route('slider');

    }
}
