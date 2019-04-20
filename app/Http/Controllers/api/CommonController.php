<?php
/**
 * Created by PhpStorm.
 * User: kate
 * Date: 4/6/2019
 * Time: 10:57 AM
 */

namespace App\Http\Controllers\api;

use App\Http\Services\SnsInfoService;
use App\Model\Category;
use App\Model\SNSInfo;
use JWTFactory;
use JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

class CommonController extends  Controller
{
    protected $snsInfoServices;

    public function __construct(SnsInfoService $snsInfoServices)
    {
        $this->snsInfoServices = $snsInfoServices;
    }

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

    public function get_sns_info()
    {
        $user = JWTAuth::parseToken()->authenticate();
        $info = $this->snsInfoServices->get_sns_info($user);
        return $info;
    }
}