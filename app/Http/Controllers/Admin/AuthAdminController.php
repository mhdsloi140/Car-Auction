<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminLoginRequest;
use App\Services\AuthAdminService;
use Illuminate\Http\Request;

class AuthAdminController extends Controller
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
  public function logout()
  {
     auth()->logout();
     return redirect()->route('home');
  }


}
