<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Posts;
use Illuminate\Support\Facades\Auth;
use Validator;

class PassportController extends Controller
{
    public $successStatus = 200;
    
    /**
    * login api
    *
    * @return \Illuminate\Http\Response
    */
    public function login(Request $request){   
        $validator = Validator::make($request->all(), [
            'username' => 'required',            
            'password' => 'required',            
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        if(Auth::attempt(['username' => request('username'), 'password' => request('password')])){
            $user = Auth::user();
            $success['token'] =  $user->createToken('MyApp')->accessToken;
            return response()->json(['success' => $success], $this->successStatus);
        }
        else{
            return response()->json(['error'=>'Unauthorised'], 401);
        }
    }
    
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',            
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);            
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyApp')->accessToken;
        //$success['name'] =  $user->name;
        return response()->json(['success'=>$success], $this->successStatus);
    }

    //Create data new posts
    public function createPost(request $request){

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }

        $input = $request->all();
        $posts = Posts::create($input);
        return response()->json(['success' => $posts], $this->successStatus);       
    }

    //Update data Posts
    public function UpdatePost(request $request, $id){
        $posts = Posts::find((int)$id);   
        $user = Auth::user();          
        if(!empty($posts))
        {        
            $validator = Validator::make($request->all(), [
                'title' => 'required',
                'content' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(['error'=>$validator->errors()], 401);
            }

            $title = $request->title;
            $content = $request->content;            
            //$update_by = $request->update_by;
            
            $posts->title = $title;
            $posts->content = $content;            
            //$posts->update_by = $update_by;
            $posts->save();
            
            return response()->json(['success' => $posts], $this->successStatus);
        }        
    }

    /**
     * details api
     *
     * @return \Illuminate\Http\Response
     */
    public function getDetails()
    {
        $user = Auth::user();
        return response()->json(['success' => $user], $this->successStatus);
    }
}
