<?php

namespace App\Http\Controllers;

use App\Models\User;
use Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Session;

class AuthController extends Controller
{
    public function index(): View
    {
        return view('auth.login');
    }

    public function registration(): View
    {
        return view('auth.registration');
    }

    public function postLogin(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->intended('percakapan')->withSuccess('You have Successfully loggedin');
        }

        return redirect('login')->withSuccess('Oppes! You have entered invalid credentials');
    }

    public function postRegistration(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6']);
        $data = $request->all();
        $check = $this->create($data);

        return redirect('percakapan')->withSuccess('Great! You have Successfully loggedin');
    }

    public function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']
            )]);
    }

    public function logout(): RedirectResponse
    {
        Session::flush();
        Auth::logout();

        return Redirect('login');
    }
}
