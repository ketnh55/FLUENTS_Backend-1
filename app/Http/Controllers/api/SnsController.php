<?php
/**
 * Created by PhpStorm.
 * User: kate
 * Date: 4/6/2019
 * Time: 11:30 AM
 */

namespace App\Http\Controllers\api;


use App\Notifications\UpdateSocialAccountsMail;
use JWTFactory;
use JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\UserSocialServices;
use App\Http\Requests\UserRegisterRequest;
use Carbon\Carbon;
use Validator;

class SnsController extends Controller
{
    use CrawlDataSupporter;
    protected $socialAccountServices;

    /**
     * LoginAPIController constructor.
     * @param UserSocialServices $socialAccountServices
     */
    public function __construct(UserSocialServices $socialAccountServices)
    {
        $this->socialAccountServices = $socialAccountServices;
    }

    /**
     * @param UserRegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function link_to_sns(UserRegisterRequest $request)
    {
        $user = JWTAuth::toUser($request->token);
        $validated = $request->validated();
        if (!$validated) {
            return response()->json($validated->errors());
        }
        $ret = $this->socialAccountServices->linkToSns($user);
        $crawlSns = $this->crawlSnsData();
        if($crawlSns !== 200)
        {
            return response()->json(['error' =>__('validation.cannot_crawl_data')], 500);
        }

        $token = JWTAuth::fromUser($user, ['exp' => Carbon::now()->addMinute(60)->timestamp]);
        $user->notify(new UpdateSocialAccountsMail($token, __('mail_message.update_social_account_title'), $user));

        return $ret;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete_sns_user(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'social_type' => 'required|numeric|min:1|max:4',
            'sns_account_id' => 'required|digits_between:1,30',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $user = JWTAuth::toUser($request->token);
        $ret = $this->socialAccountServices->deleteSNSAcc($user);
        return $ret;

    }

    /**
     * @param UserRegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function check_sns_accout(UserRegisterRequest $request)
    {
        $user = JWTAuth::toUser($request->token);
        $validated = $request->validated();
        if (!$validated) {
            return response()->json($validated->errors(), 400);
        }
        $ret = $this->socialAccountServices->check_sns_account($user);
        return $ret;

    }
}