<?php
namespace App\Helpers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class Resource {
    public static function delete($dirName, $file){
        $rs = Storage::disk('global')->delete($dirName.'/'.$file);
        return ($rs) ? $rs : false;
    }

    public static function uploadImage($dirName, $image, $type = 'default')
    {
        $imageName = Carbon::now()->format('ymdhisu').'.'.$image->clientExtension();
        $img = Image::read($image->getPathname());

        switch ($type) {
            case 'avatar':
                $w = 512; $h = 512;
                break;

            case 'cccd':
                $w = 1600; $h = 1600;
                break;

            default:
                $w = 1280; $h = 1280;
                break;
        }

        $rs = $img->scale($w, $h, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        })->save(public_path("images/".$dirName).'/'.$imageName);

        //Move original file to somewhere
        //$destinationPath = public_path('/images');
        //$image->move($destinationPath, $imageName);

        return ($rs) ? $imageName : false;
    }
}
