<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Src\GithubRequest;

class LoginController extends Controller
{
    public function getIndex(Request $request)
    {
        $data = [
            'client_id' => env('GITHUB_OAUTH_CLIENT_ID'),
        ];

        return view('welcome', $data);
    }

    public function getSuccess(Request $request)
    {
        if ($request->has('code')) {
            $response = (new GithubRequest)->getAccessToken($request->get('code'));

            //TODO check if scope is adequate
            if ($token = array_get($response, 'access_token')) {
                session(['token' => $token]);
                return redirect('/');
            }
        }

        //TODO show error
        dump($response);
    }

    public function getLogout(Request $request)
    {
        session()->forget('token');
        return redirect('/login');
    }
}
