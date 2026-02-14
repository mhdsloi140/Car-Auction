<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Http\Requests\SellerLoginRequest;
use App\Services\AuthSellerService;
use Illuminate\Http\Request;

class AuthSellerController extends Controller
{

    public function __construct(protected AuthSellerService $authSellerService)
    {

    }
    public function index()
    {
        return view('seller.auth.login');
    }
    public function login(SellerLoginRequest $request)
    {
        $data = $request->afterValidation();
        $result = $this->authSellerService->login($data);

        if (!$result['status']) {
            return redirect()->back()->withErrors(['login_error' => $result['message']]);
        }

        return redirect()->route('seller.dashboard');
    }
    public function logout()
    {
        auth()->logout();
        return redirect()->route('home');
    }

}
