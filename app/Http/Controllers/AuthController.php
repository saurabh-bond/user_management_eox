<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;


class AuthController extends Controller
{
        
        /**
         * This method is used to autheticate a user and provide access token
         * @param Request $request
         * @return validation error and redirect to login view
         * @author Saurabh Kumar <saurabhkumar3012official@gmail.com>
         * @since 19th May 2021
         */
        public function login(Request $request)
        {
                // Check if user is already login, redirect to users-list page
                if (Auth::check()) {
                        return redirect('users-list');
                }
                
                if ($request->isMethod('post')) {
                        
                        // Validating inputs
                        $validator = Validator::make($request->all(), [
                                'email' => 'required|email',
                                'password' => 'required|string|min:6',
                        ]);
                        
                        if ($validator->fails()) {
                                if ($validator->fails()) {
                                        return redirect('login')
                                                ->withErrors($validator)
                                                ->withInput();
                                }
                        }
                        
                        // Validating login attempts
                        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                                return redirect('login')
                                        ->withErrors("User is not authorized to login.")
                                        ->withInput();
                        }
                        
                        return redirect('users-list');
                }
                return view('login');
        }
        
        /**
         * This method is for user logout
         * @author Saurabh Kumar <saurabhkumar3012official@gmail.com>
         * @since 23rd May 2021
         */
        public function logout()
        {
                Auth::logout();
                return redirect('/');
        }
        
}
