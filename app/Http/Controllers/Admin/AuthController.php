<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminLoginRequest;
use App\Services\AuthAdminService;
use App\Services\AuthSellerService;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    public function __construct(protected AuthAdminService $authAdminService)
    {

    }
    public function index()
    {
        return view('admin.auth.login');
    }

    public function login(AdminLoginRequest $request)
    {
        $data = $request->afterValidation();
        $result = $this->authAdminService->login($data);
       
        if (!$result['status']) {
            return redirect()->back()->withErrors(['login_error' => $result['message']]);
        }
        return redirect()->route('admin.dashboard');


    }
}
