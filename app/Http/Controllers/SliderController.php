<?php

namespace App\Http\Controllers;

//use App\Models\User;
//use Illuminate\View\View;

class SliderController extends Controller
{
    public function index(string $id)
    {
        return 'SliderController_show_'.$id;
    }

    public function edit(string $id, string $name)
    {
        return 'SliderController_edit_'.$id.'_'.$name;
    }

    public function delete(string $id)
    {
        return 'SliderController_delete_'.$id;
    }
}
