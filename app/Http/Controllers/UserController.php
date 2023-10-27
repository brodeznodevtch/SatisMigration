<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UserController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | UserController
    |--------------------------------------------------------------------------
    |
    | This controller handles the manipualtion of user
    |
    */

    /**
     * Shows profile of logged in user
     */
    public function getProfile(): View
    {
        $user_id = request()->session()->get('user.id');
        $user = User::where('id', $user_id)->first();

        $config_languages = config('constants.langs');
        $languages = [];
        foreach ($config_languages as $key => $value) {
            $languages[$key] = $value['full_name'];
        }

        return view('user.profile', compact('user', 'languages'));
    }

    public function getFirstSession(): View
    {
        $user_id = request()->session()->get('user.id');
        $user = User::where('id', $user_id)->first();

        $config_languages = config('constants.langs');
        $languages = [];
        foreach ($config_languages as $key => $value) {
            $languages[$key] = $value['full_name'];
        }

        return view('auth.start', compact('user', 'languages'));
    }

    /**
     * updates user profile
     */
    public function updateProfile(Request $request): RedirectResponse
    {
        //Redirect back if demo application
        if (config('app.env') == 'demo') {
            $output = ['success' => 0,
                'msg' => 'This feature is disabled in demo',
            ];

            return redirect('user/profile')->with('status', $output);
        }

        try {
            $user_id = $request->session()->get('user.id');
            $input = $request->only(['first_name', 'last_name', 'email', 'language']);
            $user = User::where('id', $user_id)->update($input);

            //update session
            $input['id'] = $user_id;
            $business_id = request()->session()->get('user.business_id');
            $input['business_id'] = $business_id;
            session()->put('user', $input);

            $output = ['success' => 1,
                'msg' => 'Profile updated successfully',
            ];
        } catch (\Exception $e) {
            \Log::emergency('File:'.$e->getFile().'Line:'.$e->getLine().'Message:'.$e->getMessage());

            $output = ['success' => 0,
                'msg' => 'Something went wrong, please try again',
            ];
        }

        return redirect('user/profile')->with('status', $output);
    }

    /**
     * updates user password
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        //Redirect back if demo application
        if (config('app.env') == 'demo') {
            $output = ['success' => 0,
                'msg' => 'This feature is disabled in demo',
            ];

            return redirect('user/profile')->with('status', $output);
        }

        try {
            $user_id = $request->session()->get('user.id');
            $user = User::where('id', $user_id)->first();

            if (Hash::check($request->input('current_password'), $user->password)) {
                $user->password = Hash::make($request->input('new_password'));
                $user->save();
                $output = ['success' => 1,
                    'msg' => 'Password updated successfully',
                ];
            } else {
                $output = ['success' => 0,
                    'msg' => 'You have entered wrong password',
                ];
            }
        } catch (\Exception $e) {
            \Log::emergency('File:'.$e->getFile().'Line:'.$e->getLine().'Message:'.$e->getMessage());

            $output = ['success' => 0,
                'msg' => 'Something went wrong, please try again',
            ];
        }

        return redirect('user/profile')->with('status', $output);
    }

    public function updatePasswordFirst(Request $request): RedirectResponse
    {
        //Redirect back if demo application
        if (config('app.env') == 'demo') {
            $output = ['success' => 0,
                'msg' => 'This feature is disabled in demo',
            ];

            return redirect('user/profile')->with('status', $output);
        }

        try {
            $user_id = $request->session()->get('user.id');
            $user = User::where('id', $user_id)->first();

            if (Hash::check($request->input('current_password'), $user->password)) {
                $user->password = Hash::make($request->input('new_password'));
                $user->status = 'active';
                $user->save();
                $output = ['success' => 1,
                    'msg' => 'Password updated successfully',
                ];
            } else {
                $output = ['success' => 0,
                    'msg' => 'You have entered wrong password',
                ];
            }
        } catch (\Exception $e) {
            \Log::emergency('File:'.$e->getFile().'Line:'.$e->getLine().'Message:'.$e->getMessage());

            $output = ['success' => 0,
                'msg' => 'Something went wrong, please try again',
            ];
        }

        return redirect('home')->with('status', $output);
    }

    public function getCurrentUser(Request $request)
    {
        return $request->user();
    }
}
