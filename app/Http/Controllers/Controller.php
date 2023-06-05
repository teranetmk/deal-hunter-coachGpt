<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getPhone($phone) {

        $ac = substr($phone, 0, 3);
        $prefix = substr($phone, 3, 3);
        $suffix = substr($phone, 6);

        return "{$ac}-{$prefix}-{$suffix}";
    }

    public function getCode(){
        $length = 8;
        $str = '123ABCDEFGHIJKLMN456OPQRSTUVWXYZabcefghijklmnop789qrstuvwxyz0';

        $code =  substr(str_shuffle($str), 0, $length);
        $ac = substr($code, 0, 4);
        $bc = substr($code, 4, 8);
        return "{$ac}-{$bc}";
    }
}
