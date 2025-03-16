<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ajax;
class AjaxController extends Controller
{
    public function getdata(){
        return Ajax::orderBy('id', 'desc')->get();
    }
    public function savedata(Request $request){
        $tbl = new Ajax();
        parse_str($request->input('data'), $formData);
        $tbl->username=$formData['username'];
        $tbl->email=$formData['email'];
        if(empty($formData['id']) || ($formData['id'] == ""))
            $tbl->save();
        else{
            $tbl=Ajax::find($formData['id']);
            $tbl->username=$formData['username'];
            $tbl->email=$formData['email'];
            $tbl->update();

        }
        echo $request->input('data');
    }



    public function editdata(Request $request){
        return Ajax::find($request->id);
    }

    public function deletedata(Request $request){
        return Ajax::where('id', $request->id)->delete();
        echo "data delete successfuly";
    }
}
