<?php
namespace App\Http\Controllers;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TopicController extends Controller
{
    public function all_topics(){
        $response = [
            'success'=>true,
            'data'=>Topic::all(),
        ];
        return response()->json($response);
    }

    public function add_topic(Request $request){
        $validator = Validator::make($request->all(),[
            'topic_name' => 'required',
            'category_id' => 'required',
        ]);
        if ($validator->fails()){
            $response =[
                'success'=>'false',
                'message'=>$validator->errors()
            ];
            return response()->json($response,404);
        }
        $input = $request->all();
        $topic = Topic::create($input);
        $response = [
            'success'=>true,
            'Topic Name'=>$topic->topic_name,
            'message'=>"Topic added successfully !"
        ];
        return response()->json($response,202);
    }

    public function delete_topic($id)
    {
        $topic = Topic::find($id);
        if ($$topic) {
            $topic->delete();
            $response = [
                'success'=>true,
                'message'=>"Topic deleted Successfully !"
            ];
            return response()->json($response);
        }
        else {
            $response = [
                'success'=>'false',
                'message'=>'Topic not found !'
            ];
        }
        return response()->json($response,202);
    }


    public function update_topic(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'topic_name' => 'required',
            'category_id' => 'required',
        ]);

        if ($validator->fails()) {
            $response = [
                'success' => false,
                'message' => $validator->errors()
            ];
            return response()->json($response, 400);
        }

        $topic = Topic::find($id);

        if (!$topic) {
            $response = [
                'success' => false,
                'message' => 'Topic not found!'
            ];
            return response()->json($response, 404);
        }
        $topic->topic_name = $request->input('topic_name');
        $topic->category_id = $request->input('category_id');
        $topic->save();
        $response = [
            'success' => true,
            'message' => 'Topic updated successfully',
            'data' => $topic
        ];
        return response()->json($response, 200);
    }
}
