<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Device;
use Validator;
class DeviceController extends Controller
{
    function list($id=null)
    {
        return $id?Device::find($id):Device::all();
    }

    function add(Request $request)
    {
        $device = new Device;
        $device->name = $request->name;
        $device->member_id = $request->member_id;
        $result = $device->save();

        if($result){
            return ["Result"=>"Data has been saved"];
        } else{
            return ["Result"=>"Operation failed"];
        }

    }

    function update(Request $request)
    {
        $device = Device::find($request->id);
        $device->name = $request->name;
        $device->member_id = $request->member_id;
        $result = $device->save();

        if($result){
            return ["Result"=>"Data has been updated"];
        } else{
            return ["Result"=>"Update Operation failed"];
        }
    }

    function search($name)
    {
        return Device::where("name", "like", "%".$name."%")->get();
    }

    function delete($id)
    {
        $device = Device::find($id);
        $result = $device->delete();
        if($result){
            return ["Result"=>"Device successfully deleted"];
        } else{
            return ["Result"=>"Failed to delete device"];
        }
    }

    function testData(Request $request)
    {
        $rules = array(
            "name" => "required|min:2|max:4",
            "member_id" => "required"
        );
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails())
        {
            return response()->json($validator->errors(), 401);
        }else {
            $device = new Device;
            $device->name = $request->name;
            $device->member_id = $request->member_id;
            $result = $device->save();
            if($result){
                return ["Result"=>"Device successfully added"];
            } else{
                return ["Result"=>"Failed to add device"];
            }
        }

    }

}
