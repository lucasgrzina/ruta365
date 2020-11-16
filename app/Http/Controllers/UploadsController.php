<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AppBaseController;
use App\Http\Controllers\Traits\FileUploadTrait;
use Illuminate\Http\Request;
use App\Helpers\FileUploadHelper;

class UploadsController extends AppBaseController
{
    use FileUploadTrait;

    public function storeFile(Request $request)
    {
    	$file = $this->saveFile($request,'file','tmp');
    	return $this->sendResponse([
    		'file' => $file,
    		'path' => FileUploadHelper::fullUrl('tmp',$file)
    	], trans('api.success'));
    }

    public function storeImage(Request $request)
    {
    	$file = $this->saveImage($request,'file','tmp');
    	return $this->sendResponse(['file' => $file], trans('api.success'));
    }    
}
