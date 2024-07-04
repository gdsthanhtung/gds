<?php
namespace App\Helpers;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class Resource {
    public static function upload($dirName, $file){
        $newName = Carbon::now()->format('ymdhisu').'.'.$file->clientExtension();
        $rs = $file->storeAs($dirName, $newName, 'global');
        return ($rs) ? $newName : false;
    }

    public static function delete($dirName, $file){
        $rs = Storage::disk('global')->delete($dirName.'/'.$file);
        return ($rs) ? $rs : false;
    }
}
