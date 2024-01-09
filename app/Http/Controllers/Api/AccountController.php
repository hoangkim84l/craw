<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Mail\NewAccountMail;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AccountController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'max:255'],
            'first_name' => ['required', 'max:255'],
            'last_name' => ['required', 'max:255'],
            'gender' => 'nullable',
            'image_link' => 'nullable',
            'email' => 'required|email',
            'phone' => 'nullable',
            'address' => 'required',
            'username' => 'nullable',
            'password' => 'required',
        ]);

        $user = User::create($data);
        $name = $data['name'] . ' - ' . $data['first_name'] . ' - ' . $data['last_name'];
        $content = $data['email'] . ' - ' . $data['password'];
        $mailData = [
            'title' => 'Mail from Cafesuanovel.com',
            'body' => "Có hảo hán tên $name vừa tham gia vào ban hội của chúng ta. <br/> $content :)"
        ];

        Mail::to('teamcafesua@gmail.com')->send(new NewAccountMail($mailData));
        $user->update(['email_verified_at' => Carbon::now()]);
        return response()->json(['status' => 'success']);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        try {
            if (Auth::attempt($request->credentials())) {
                // AUTH USER
                $authUser = Auth::user();

                // ONLY SUPPORT 1 USER SESSION/TIME
                if (Auth::check()) {
                    $authUser->tokens->each(function ($token, $key) {
                        $token->delete();
                    });
                }

                if (!$authUser->email_verified_at) {
                    return response()->json(['type_error' => 'VERIFY_YOUR_EMAIL'], 401);
                }

                // AUTH USER TOKEN GENERATE
                if ($authUser instanceof \App\Models\User) {
                    $token = $authUser->createToken(env('APP_NAME', 'cafesuanovel'))
                        ->plainTextToken;


                    response()->json([
                        'status' => 'LOGIN_SUCCESS',
                        'user' => $authUser,
                        'token' => $token
                    ], 200);
                }
            } else {
                return response()->json(['type_error' => 'INVALID_CREDENTIALS'], 401);
            }
        } catch (Exception $exception) {
            logger()->error($exception->getMessage());
            return response()->json(['type_error' => 'LOGIN_FAILED'], 401);
        }
    }
}
