<?php
/**
 * Created by PhpStorm.
 * User: kate
 * Date: 4/6/2019
 * Time: 10:57 AM
 */

namespace App\Http\Controllers\api;

use App\Http\Services\SnsInfoService;
use App\Http\Services\UserSocialServices;
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
    protected $userSocialService;

    public function __construct(SnsInfoService $snsInfoServices, UserSocialServices $userSocialService)
    {
        $this->snsInfoServices = $snsInfoServices;
        $this->userSocialService = $userSocialService;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_user_info(Request $request)
    {
        $user = JWTAuth::toUser($request->token);

        $user = User::with('user_socials')->with('categories')->findOrFail($user->id);
        if($user->is_active != 1)
        {
            return response()->json(['error' => 'User is deactivated']);
        }
        return response()->json(compact('user'));
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_category_info()
    {
        JWTAuth::parseToken()->authenticate();
        $category = Category::all();
        return response()->json($category);
    }

    public function get_sns_info()
    {
        $user = JWTAuth::parseToken()->authenticate();
        $info = $this->snsInfoServices->get_sns_info($user);
        return $info;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function deactive_acc(){
        $user = JWTAuth::parseToken()->authenticate();
        $ret = $this->userSocialService->deactive_user($user);
        return $ret;
    }
}