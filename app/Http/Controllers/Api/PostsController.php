<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Posts;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    use apiResponseTrait;

    public function index() {
        $posts = Posts::all();
        return $this->apiResponse($posts, 'Success, Get All Posts', 200); // this function called by apiResponseTrait File
    }

    public function show($id) {
        $post = Posts::find($id);
        if($post) {
            return $this->apiResponse($post, 'Success Get Post By Id', 200); // this function called by apiResponseTrait File
        } else {
            return $this->apiResponse(null ,'Sorry This Post Is Not Found', 404); // this function called by apiResponseTrait File
        }
    }

}
