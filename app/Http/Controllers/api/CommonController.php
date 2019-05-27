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
use App\Notifications\CloseFluentsAccMail;
use JWTFactory;
use JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Carbon\Carbon;

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
            return response()->json(['error' => __('validation.user_is_deactivated')]);
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
    public function request_deactive_acc(){
        $user = JWTAuth::parseToken()->authenticate();
        $user->is_deactive_requested = true;

        //Send mail to user to confirm deactive account
        $token = JWTAuth::fromUser($user, ['exp' => Carbon::now()->addDays(60)->timestamp]);
        $user->notify(new CloseFluentsAccMail($token, __('mail_message.close_fluent_account_title'), $user));
        return response()->json(['message' => __('response_message.status_success')]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function deactive_acc(){
        $user = JWTAuth::parseToken()->authenticate();
        if(JWTAuth::parseToken()->getPayload()->get('iss') == route('request_deactive'))
        {
            $ret = $this->userSocialService->deactive_user($user);
            JWTAuth::invalidate(JWTAuth::getToken());
            return $ret;
        }

        return response()->json(['message' => __('validation.invalid_request')], 400);



    }
}