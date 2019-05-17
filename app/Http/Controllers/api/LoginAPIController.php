<?php

namespace App\Http\Controllers\api;

use App\Http\Services\UserSocialServices;
use App\Http\Controllers\Controller;
use JWTFactory;
use JWTAuth;
use Validator;
use Response;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRegisterRequest;
use GuzzleHttp\Client;

class LoginAPIController extends Controller
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
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function user_register_api(UserRegisterRequest $request)
    {
        $validated = $request->validated();
        if (!$validated) {
            return response()->json($validated->errors());
        }

        try
        {
            $user = $this->socialAccountServices->createOrGetSocailUser($request);
            if($user->is_active != 1)
            {
                return response()->json(['error' => 'User is deactivated']);
            }

        }
        catch (\Exception $e)
        {
            return response()->json(['error' => $e->getMessage()]);
        }
        $token = JWTAuth::fromUser($user);
        $user->user_type !== null ? $user->require_update_info = 'false' :$user->require_update_info = 'true';
        $ret = $this->socialAccountServices->linkToSns($user, $request);

        //call crawl data by api
        $body = [
            'platform_id' => $request->get('sns_account_id'),
            'sns_access_token' => $request->get('sns_access_token'),
            'social_type' => (int)$request->get('social_type'),
            'secret_token' => $request->get('secret_token')
        ];

        $client = new Client();
        $response = $client->request('POST', 'https://python-api.fluents.app/api/social-data/add-new-platform', ['json' => $body]);
        //call api fail
        if($response->getStatusCode() !== 200)
        {
            return response()->json(['error' =>'cannot crawl data']);
        }


        return response()->json(['token'=>$token, 'user'=>$user]);
    }

    public function user_login_api(Request $request)
    {
        $user = JWTAuth::toUser($request->token);
        $user = User::with('user_socials')->with('categories')->findOrFail($user->id);
        if($user->is_active != 1)
        {
            return response()->json(['error' => 'User is deactivated']);
        }
        $user->user_type !== null ? $user->require_update_info = 'false' :$user->require_update_info = 'true';
        return response()->json(["allow_access"=>"true", 'user' => $user]);
    }

    public function user_update_info_api(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date_of_birth' => 'sometimes|required|date_format:m-d-Y',
            'gender' => 'sometimes|required|string',
            'country' => 'sometimes|required|string',
            'location' => 'sometimes|required|string',
            'description' => 'sometimes|required|string',
            'user_type' => 'sometimes|required|numeric|min:1|max:2',
            'username' => 'sometimes|required|string',
            'email' => 'sometimes|required|string|email|max:255',
            'avatar' => 'sometimes|required|string',
            'categories' => 'sometimes|required|array'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $user = JWTAuth::toUser($request->token);
        $ret = $this->socialAccountServices->updateUserInfo($user, $request);
        return $ret;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */

    public function logout_out()
    {
        JWTAuth::invalidate(JWTAuth::getToken());
        return response()->json(['logout' => 'success']);
    }

}
