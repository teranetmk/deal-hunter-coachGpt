<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

class TemplateFile extends Controller
{
    //
    public function downloadTemplate()
    {
        $headers = array (
            "Content-Type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=FileUploadTemplate.csv",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );
        return Response::download('template/UploadFileTemplate.csv', 'UploadFileTemplate.csv', $headers);
    }
}
