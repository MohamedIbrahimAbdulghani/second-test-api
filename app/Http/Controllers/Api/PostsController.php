<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Posts;

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

}
