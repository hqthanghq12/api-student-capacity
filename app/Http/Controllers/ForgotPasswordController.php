<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    protected User $user;
    public function __contruct(User $user)
    {
        $this->user = $user;
    }
}
