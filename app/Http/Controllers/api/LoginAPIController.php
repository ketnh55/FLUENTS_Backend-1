<?php

namespace App\Http\Controllers\api;

use App\Http\Services\UserSocialServices;
use App\Http\Controllers\Controller;
use App\Notifications\RegisterNotificationMail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
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
        //call crawl data by api
        $crawlSns = $this->crawlSnsData();
        if($crawlSns !== 200)
        {
            return response()->json(['error' =>'cannot crawl data']);
        }
        return response()->json(['token'=>$token, 'user'=>$user]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
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

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
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
            'categories' => 'sometimes|required|array',
            'password' => 'sometimes|required|string|min:6'

        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $user = JWTAuth::toUser($request->token);
        $ret = $this->socialAccountServices->updateUserInfo($user);
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


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function user_register_email(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $user = $this->socialAccountServices->register_by_email();
        if($user == null)
        {
            return response()->json(['error' => 'email was linked to other account']);
        }
        $token = JWTAuth::fromUser($user, ['exp' => Carbon::now()->addMinute(60)->timestamp]);
        $link = route('home', ['token' => $token]);
        $user->notify(new RegisterNotificationMail($link, 'Active account notification'));
        return response()->json(['status' => 'success']);
    }

    public function login_by_email(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if($user->is_active == 0){
                return response()->json(['message' => 'user is not active']);
            }
            $token = JWTAuth::fromUser($user);
            $user = User::with('user_socials')->with('categories')->findOrFail($user->id);
            $user->user_type !== null ? $user->require_update_info = 'false' :$user->require_update_info = 'true';
            return response()->json(['token'=>$token, 'user'=>$user]);
        }
    }

    public function reset_password(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $user = $this->socialAccountServices->checkIfUserExists($request->get('email'));
        if($user == null)
        {
            return response()->json(['error' => 'User is not existed']);
        }
        $token = JWTAuth::fromUser($user, ['exp' => Carbon::now()->addMinute(60)->timestamp]);
        $link = route('home', ['token' => $token]);
        $user->notify(new RegisterNotificationMail($link, 'Register password notification'));
        return response()->json('ok');
    }
}
