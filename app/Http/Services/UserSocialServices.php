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
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;

class UserSocialServices
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function createOrGetSocailUser()
    {
        /*
         * Check if user exists or not
         * */
        $userSocial = UserSocial::where(['platform_id' => Input::get('sns_account_id'), 'social_type'=>Input::get('social_type')])->first();
        if($userSocial)
        {
            $user = $userSocial->user;
            $user = User::with('user_socials')->with('categories')->findOrFail($user->id);
            return $user;
        }

        //if not
        $user = User::create([
            'email'=>Input::get('email'),
            'username'=>Input::get('username'),
            'avatar'=>Input::get('avatar'),
            'is_active'=>1
        ]);
        // create social user with main user
        $acc = new UserSocial([
            'platform_id' => Input::get('sns_account_id'),
            'social_type' => Input::get('social_type'),
            'sns_access_token' => Input::get('sns_access_token'),
            'email' => Input::get('email'),
            'link' => Input::get('link'),
            'avatar' => Input::get('avatar'),
            'username' => Input::get('username'),
            'secret_token' => Input::get('secret_token'),
            'refresh_token' => Input::get('refresh_token'),
        ]);
        $acc->user()->associate($user);
        $acc->save();
        $user = User::with('user_socials')->with('categories')->findOrFail($user->id);
        return $user;
    }

    public function updateUserInfo(User $user)
    {
        //$user = User::findOrFail($user->id);
        $user->date_of_birth = Input::get('date_of_birth')==null?$user->date_of_birth:Carbon::createFromFormat('m-d-Y', Input::get('date_of_birth'));
        $user->gender = Input::get('gender')==null?$user->gender:Input::get('gender');
        $user->country = Input::get('country')==null?$user->country:Input::get('country');
        $user->location = Input::get('location')==null?$user->location:Input::get('location');
        $user->description = Input::get('description')==null?$user->description:Input::get('description');
        $user->user_type = Input::get('user_type')==null?$user->user_type:Input::get('user_type');
        $user->username = Input::get('username')==null?$user->username:Input::get('username');
        $user->email = Input::get('email')==null?$user->email:Input::get('email');
        $user->avatar = Input::get('avatar')==null?$user->avatar:Input::get('avatar');
        $user->first_name = Input::get('first_name')==null?$user->first_name:Input::get('first_name');
        $user->last_name = Input::get('last_name')==null?$user->last_name:Input::get('last_name');
        $user->password = Input::get('password')==null?$user->password:Hash::make(Input::get('password'));
        if(Input::get('categories') !== null)
        {
            $user->categories()->sync(Input::get('categories'));
        }

        $user->save();

    }

    public function linkToSns(User $user)
    {
        $user = User::with('user_socials')->findOrFail($user->id);

        //check if user deactivate
        if($user->is_active != 1)
        {
            return response()->json(['error' => __('validation.user_not_active')], 412);
        }

        //check if sns account was linked to another account
        $user_socials = UserSocial::where(['platform_id'=>Input::get('sns_account_id'), 'social_type'=>Input::get('social_type')]);
        if($user_socials->count() > 0)
        {
            $user_socials->first()->delete();
        }

        // create social user with main user
        $acc = new UserSocial([
            'platform_id' => Input::get('sns_account_id'),
            'social_type' => Input::get('social_type'),
            'sns_access_token' => Input::get('sns_access_token'),
            'email' => Input::get('email'),
            'link' => Input::get('link'),
            'avatar' => Input::get('avatar'),
            'username' => Input::get('username'),
            'secret_token' => Input::get('secret_token'),
            'refresh_token' => Input::get('refresh_token'),
        ]);
        $acc->user()->associate($user);
        $acc->save();
        $user = User::with('user_socials')->with('categories')->findOrFail($user->id);
        return response()->json(['message'=>__('response_message.status_success'), 'user'=>$user]);

    }

    /**
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function check_sns_account(User $user)
    {
        //check if user deactivate
        if($user->is_active != 1)
        {
            return response()->json(['error' => __('validation.user_not_active')], 412);
        }

        //check if sns account was linked to another account
        $user_socials = UserSocial::where(['platform_id'=>Input::get('sns_account_id'), 'social_type'=>Input::get('social_type')])->count();
        if($user_socials > 0)
        {
            return response()->json(['message'=>__('validation.sns_was_linked_to_another')], 413);
        }

        return response()->json(['message'=>__('response_message.status_success')]);
    }

    /**
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteSNSAcc(User $user)
    {
        $user = User::find($user->id);
        //check if user deactivate
        if($user->is_active != 1)
        {
            return response()->json(['error' => __('validation.user_is_deactivated')]);
        }

        //Check if social user belong user
        $count_sns_acc = $user->user_socials()->where(['platform_id' => Input::get('sns_account_id'), 'social_type' => Input::get('social_type')])->count();
        if($count_sns_acc > 0)
        {
            $user->user_socials()->where(['platform_id' => Input::get('sns_account_id'), 'social_type' => Input::get('social_type')])->delete();
            return response()->json(['message'=>__('response_message.status_success')]);
        }
        return response()->json(['error' => __('validation.user_not_exists')]);
    }

    /**
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function deactive_user(User $user)
    {
        $user = User::find($user->id);
        $user->delete();
        return response()->json(['message'=>__('response_message.status_success')]);
    }

    public function register_by_email()
    {
        $email = Input::get('email');
        $password = Input::get('password');
        $numberOfEmail = User::whereEmail($email)->count();
        if($numberOfEmail > 0)
        {
            //return response()->json(['error' => 'email was linked to other account']);
            return null;
        }
        $user = new User();
        $user->email = $email;
        $user->password = Hash::make($password);
        $user ->is_active = 0;
        $user->save();
        return $user;
    }

    public function checkIfUserExists(string $email)
    {
        $user = User::whereEmail($email)->first();
        return $user;
    }


}