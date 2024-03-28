<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\FileUpload;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class FileUploadController extends Controller
{
   function ajaxFileUpload() {
    return view('ajax_file_upload');
   }

   function ajaxFileUploadPost(Request $request) {
    $validator = Validator::make($request->all(), [
        'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
      ]);
     //dd($request->all());
      if($validator->passes()) {
        $input = [];
        $input['file_name'] = time().'.'.$request->image->extension();
        $input['file_type'] = $request->image->extension();
        $request->image->move(public_path('images'), $input['file_name']);
        $input['file_path'] = 'public/images/'.$input['file_name'];
        $input['user_id']=Auth::user()->id;
        $fileData=FileUpload::create($input);
        return response()->json(['status'=>true, 'fileData'=>$fileData]);
      }


      return response()->json(['status'=>false, 'errors'=>$validator->errors()->all()]);
   }
   
}
