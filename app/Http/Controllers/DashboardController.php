<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function redirect()
    {
        $role = Auth::user()->role->name;

        return match ($role) {

            'ADMIN' => redirect()->route('admin.dashboard'),

            'AGENT' => redirect()->route('agent.dashboard'),

            'USER' => redirect()->route('user.dashboard'),

            default => abort(403),
        };
    }
}