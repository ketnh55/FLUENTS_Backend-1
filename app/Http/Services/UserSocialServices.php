<?php
/**
 * Created by PhpStorm.
 * User: kate
 * Date: 3/15/2019
 * Time: 11:30 PM
 */

namespace App\Http\Services;
use App\Model\UserSocial;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserSocialServices
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function createOrGetSocailUser(Request $request)
    {
        /*
         * Check if user exists or not
         * */
        $userSocial = UserSocial::where(['platform_id' => $request->get('sns_account_id'), 'social_type'=>$request->get('social_type')])->first();
        if($userSocial)
        {
            $user = $userSocial->user;
            $user = User::with('user_socials')->findOrFail($user->id);

            return $user;
        }

        //if not
        $user = User::create([
            'email'=>$request->get('email'),
            'username'=>$request->get('username'),
            'avatar'=>$request->get('avatar'),
            'is_active'=>1
        ]);
        // create social user with main user
        $acc = new UserSocial([
            'platform_id' => $request->get('sns_account_id'),
            'social_type' => $request->get('social_type'),
            'sns_access_token' => $request->get('sns_access_token'),
            'email' => $request->get('email'),
            'link' => $request->get('link'),
            'avatar' => $request->get('avatar'),
            'username' => $request->get('username'),
        ]);
        $acc->user()->associate($user);
        $acc->save();
        $user = User::with('user_socials')->findOrFail($user->id);
        return $user;
    }

    public function updateUserInfo(User $user, Request $request)
    {
        $user = User::findOrFail($user->id);
        if($user->is_active != 1)
        {
            return response()->json(['error' => 'User is deactivated']);
        }
        if ($user->user_type !== null && $request->get('user_type') !== null)
        {
            return response()->json(['error' => 'User type was existed']);
        }
        $user->date_of_birth = $request->get('date_of_birth')==null?$user->date_of_birth:$request->get('date_of_birth');
        $user->gender = $request->get('gender')==null?$user->gender:$request->get('gender');
        $user->country = $request->get('country')==null?$user->country:$request->get('country');
        $user->location = $request->get('location')==null?$user->location:$request->get('location');
        $user->description = $request->get('description')==null?$user->description:$request->get('description');
        $user->user_type = $request->get('user_type')==null?$user->user_type:$request->get('user_type');
        $user->username = $request->get('username')==null?$user->username:$request->get('username');
        $user->email = $request->get('email')==null?$user->email:$request->get('email');
        $user->avatar = $request->get('avatar')==null?$user->avatar:$request->get('avatar');
        $user->category = $request->get('category')==null?$user->category:$request->get('category');
        $user->save();
        return response()->json(['update_user_info' => 'Success']);
    }

    public function linkToSns(User $user, Request $request)
    {
        $user = User::with('user_socials')->findOrFail($user->id);

        //check if user deactivate
        if($user->is_active != 1)
        {
            return response()->json(['error' => 'User is deactivated']);
        }

        //check if user linked to the same sns type before
        foreach($user->user_socials as $user_social)
        {
            if($user_social->social_type == $request->get('social_type'))
            {
                return response()->json(['error'=>'Duplicate user sns']);
            }
        }

        //check if sns account was linked to another account
        $user_socials = UserSocial::where(['platform_id'=>$request->get('sns_account_id'), 'social_type'=>$request->get('social_type')])->count();
        if($user_socials > 0)
        {
            return response()->json(['error'=>'user was existed']);
        }

        // create social user with main user
        $acc = new UserSocial([
            'platform_id' => $request->get('sns_account_id'),
            'social_type' => $request->get('social_type'),
            'sns_access_token' => $request->get('sns_access_token'),
            'email' => $request->get('email'),
            'link' => $request->get('link'),
            'avatar' => $request->get('avatar'),
            'username' => $request->get('username'),
        ]);
        $acc->user()->associate($user);
        $acc->save();
        return response()->json(['link_to_sns'=>'success', 'user'=>$user]);

    }
}