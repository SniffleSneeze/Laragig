<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    // show register / create form
    public function create(): Factory|View|Application
    {
        return view('users.register');
    }

    // create new user
    public function store(Request $request): Redirector|Application|RedirectResponse
    {
        $formFields = $request->validate(
            [
                'name'     => ['required', 'min:3'],
                'email'    => ['required', 'email', Rule::unique('users','email')],
                'password' => 'required|confirmed|min:6',
            ]
        );

        // hash password
        $formFields['password'] = bcrypt($formFields['password']);

        // create user
        $user = User::create($formFields);

        // login
        auth()->login($user);
        return redirect('/')->with('message', 'User created and logged in!');
    }

    // logout user
    public function logout(Request $request): Redirector|Application|RedirectResponse
    {
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('message', 'You have been logout');
    }

    // show login form
    public function login(): Factory|View|Application
    {
        return view('users.login');
    }

    // authenticate user
    public function authenticate(Request $request): Redirector|Application|RedirectResponse
    {
        $formFields = $request->validate(
            [
                'email'    => ['required', 'email'],
                'password' => 'required',
            ]
        );

        if(auth()->attempt($formFields)) {
            $request->session()->regenerate();

            return redirect('/')->with('message', 'you are now logged in');
        }

        return back()->withErrors(['email'=> 'Invalid Credentials'])->onlyInput('email');
    }
}
