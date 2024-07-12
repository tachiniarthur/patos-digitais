<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RequestRegisterUser;
use App\Services\UserService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class RegisterUserController extends Controller
{
    public function __construct(
        public UserService $userService
    ) {
        
    }

    public function index()
    {
        return Inertia::render('Auth/Register');
    }

    public function store(RequestRegisterUser $request): RedirectResponse
    {
        $user = $this->userService->createUser($request->validated());

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('login');
    }
}