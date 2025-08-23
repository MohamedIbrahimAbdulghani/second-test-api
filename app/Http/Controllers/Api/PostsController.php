<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Posts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostsController extends Controller
{
    use apiResponseTrait;

    public function index() {
        $posts = Posts::all();
        // in this case i used PostResource::collection() function => to return specific fields from the table not all fields form the table ('Posts table')
        return $this->apiResponse(PostResource::collection($posts), 'Success, Get All Posts', 200); // this function called by apiResponseTrait File
    }

    public function show($id) {
        $post = Posts::find($id);
        if($post) {
            // in this case i used PostResource and take object from this because i want returned specific fields from table not all fields from this table ('Posts table')
            return $this->apiResponse(new PostResource($post), 'Success Get Post By Id', 200); // this function called by apiResponseTrait File
        } else {
            return $this->apiResponse(null ,'Sorry This Post Is Not Found', 404); // this function called by apiResponseTrait File
        }
    }

    public function store(Request $request) {
        // $request->validate([
        //     'title' => 'required|min:3',
        //     'body' => 'required|min:3'
        // ]);

        // this to make validation about form
        $validator = Validator::make($request->all(),[
            'title' => 'required|min:3',
            'body' => 'required|min:3'
        ]);
        // this is to show errors if request not send or if it can bad request
        if($validator->fails()) {
            return $this->apiResponse(null, $validator->errors(), 400);
        }

        $post = Posts::create([
            'title' => $request->title,
            'body' => $request->body,
        ]);
        if($post) {
            // in this case i used PostResource and take object from this because i want returned specific fields from table not all fields from this table ('Posts table')
            return $this->apiResponse(new PostResource($post), 'Success Added New Post', 200); // this function called by apiResponseTrait File
        } else {
            return $this->apiResponse(null ,'Found Error! The Post Not Save', 400); // this function called by apiResponseTrait File
        }
    }


}
