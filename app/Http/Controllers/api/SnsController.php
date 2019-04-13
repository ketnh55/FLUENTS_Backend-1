<?php
/**
 * Created by PhpStorm.
 * User: kate
 * Date: 4/6/2019
 * Time: 11:30 AM
 */

namespace App\Http\Controllers\api;

use JWTFactory;
use JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\UserSocialServices;
use App\Http\Requests\UserRegisterRequest;
use Validator;

class SnsController extends Controller
{
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
     */
    public function link_to_sns(UserRegisterRequest $request)
    {
        $user = JWTAuth::toUser($request->token);
        $validated = $request->validated();
        if (!$validated) {
            return response()->json($validated->errors());
        }
        $ret = $this->socialAccountServices->linkToSns($user, $request);

        return $ret;
    }

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
        $ret = $this->socialAccountServices->deleteSNSAcc($user, $request);
        return $ret;

    }
}