<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Inertia\Inertia;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->isAdmin()) {
            return Inertia::render('admin/dashboard', [
                'services' => Service::all(),
                'stats' => [
                    'total_services' => Service::count()
                ]
            ]);
        }

        return Inertia::render('customer/dashboard', [
            'services' => Service::active()->get(),
        ]);
    }
}
