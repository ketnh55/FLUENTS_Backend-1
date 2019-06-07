<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\User;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function getUserObject($id)
    {
        $user = User::with('user_socials')->with(array(
            'interest' => function($query){
                $query->orderBy('interest_name');
            },
            'profession' =>function($query){
                $query->orderBy('profession_name');
            },
        ))->findOrFail($id);
        return $user;

    }
}
