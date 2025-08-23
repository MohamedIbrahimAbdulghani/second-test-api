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
        // 1- Make Validation About Request Data
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:3',
            'body' => 'required|min:3',
        ]);
        if ($validator->fails()) {
            return $this->apiResponse(null, $validator->errors(), 400);
        }

        // 2- Create Data in database
        $post = Posts::create([
            'title' => $request->title,
            'body' => $request->body
        ]);
        if($post) {
            return $this->apiResponse(new PostResource($post), 'Add New Post Successful !', 201);
        } else {
            return $this->apiResponse(null, "Don't Save This Post", 400);
        }
    }


    public function update(Request $request, $id) {
        // 1- make validation about request
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:3',
            'body' => 'required|min:3'
        ]);
        if($validator->fails()) {
            return $this->apiResponse(null, $validator->errors(), 400);
        }
        // 2- Get a Post
        $post = Posts::find($id);

        // Check if post found or not
        if($post) {
            // 3- Make Update
            $post->update([
                'title' => $request->title,
                'body' => $request->body
            ]);
            return $this->apiResponse(new PostResource($post), 'Updated Successful !', 200);
        }
        else {
            return $this->apiResponse(null, 'Found Error, The Post Not Found', 404);
        }




    }




}
