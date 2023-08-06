<?php
namespace App\Http\Controllers;
use App\Models\Request as Req;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RequestController extends Controller
{
    public function all_requests(){
        $response = [
            'success'=>true,
            'data'=>Req::all(),
        ];
        return response()->json($response);
    }

    public function add_request(Request $request){
        $validator = Validator::make($request->all(),[
            'user_id' => 'required',
            'topic_name' => 'required',
        ]);
        if ($validator->fails()){
            $response =[
                'success'=>'false',
                'message'=>$validator->errors()
            ];
            return response()->json($response,404);
        }
        $input = $request->all();
        $req = Req::create($input);
        $response = [
            'success'=>true,
            'Topic Name'=>$req->topic_name,
            'message'=>"Request added but pending for review !"
        ];
        return response()->json($response,202);
    }

    public function delete_request($id)
    {
        $req = Req::find($id);
        if ($req) {
            $req->delete();
            $response = [
                'success'=>true,
                'message'=>"New Request deleted Successfully !"
            ];
            return response()->json($response);
        }
        else {
            $response = [
                'success'=>'false',
                'message'=>'Request not found !'
            ];
        }
        return response()->json($response,202);
    }


    public function update_request(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'topic_name' => 'required',
        ]);

        if ($validator->fails()) {
            $response = [
                'success' => false,
                'message' => $validator->errors()
            ];
            return response()->json($response, 400);
        }

        $req = Req::find($id);

        if (!$req) {
            $response = [
                'success' => false,
                'message' => 'Request not found!'
            ];
            return response()->json($response, 404);
        }
        $req->user_id = $request->input('user_id');
        $req->topic_name = $request->input('topic_name');
        $req->save();
        $response = [
            'success' => true,
            'message' => 'Request updated successfully',
            'data' => $req
        ];
        return response()->json($response, 200);
    }
}
