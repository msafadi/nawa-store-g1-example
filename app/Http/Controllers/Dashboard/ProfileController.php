<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Intl\Countries;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('dashboard.profile', [
            'user' => $user,
            'countries' => Countries::getNames(config('app.locale')),
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'birthday' => 'nullable|date|before:today',
            'country_code' => 'required|size:2',
        ]);

        $user = Auth::user();
        $user->profile->fill($request->all())->save();

        return redirect()->back()->with('success', 'Profile Updated!');
    }
}
