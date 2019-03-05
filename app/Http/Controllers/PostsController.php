<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Posts;

class PostsController extends Controller
{
    public $successStatus = 200;
    //Index untuk menampilkan list data
    public function index(){
        return Posts::all();
    }

    public function getPostDetails($id)
    {
        $posts = Posts::find((int)$id);
        return response()->json(['success' => $posts], $this->successStatus);
    }   
    
}
