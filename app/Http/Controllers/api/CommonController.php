<?php
/**
 * Created by PhpStorm.
 * User: kate
 * Date: 4/6/2019
 * Time: 10:57 AM
 */

namespace App\Http\Controllers\api;

use App\Model\Category;
use JWTFactory;
use JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

class CommonController extends  Controller
{
    public function get_user_info(Request $request)
    {
        $user = JWTAuth::toUser($request->token);
        $user = User::with('user_socials')->with('categories')->findOrFail($user->id);
        return response()->json(compact('user'));
    }

    public function get_category_info(Request $request)
    {
        JWTAuth::toUser($request->token);
        $category = Category::all();
        return response()->json($category);
    }
}