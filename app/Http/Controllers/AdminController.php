<?php

namespace App\Http\Controllers;

use App\Models\Radio;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('dashboard');
    }

    public function players()
    {
        return view('dashboard');
    }
}
