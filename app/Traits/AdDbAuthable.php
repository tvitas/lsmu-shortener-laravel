<?php
namespace App\Traits;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Traits\AdAuthable;
use App\User;


trait AdDbAuthable
{
    use AdAuthable;

    public function authenticate(Request $request, User $user)
    {

        $validated = $request->validate(
            [
                $this->username() => 'required|string|max:255',
                'password' => 'required|string|max:255'
            ]
        );

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            $this->sendLockoutResponse($request);
        }

        if ($validated) {
            $this->inputUser = $request->input($this->username(), '');
            $this->inputPass = $request->input('password', '');
            $this->adUser = $this->inputUser;
            $this->adPass = $this->inputPass;

            if (Str::contains($this->inputUser, '@')) {
                $this->adUser = substr($this->inputUser, 0, strpos($this->inputUser,'@'));
            }

            // Try AD authentification
            if ($this->adAttempt()) {
                $userId = User::where($this->username(), $this->inputUser)->pluck('id')->all();
                if (empty($userId)) {
                    $userId = null;
                }
                // If AD auth pass, try local DB auth with entered credentials
                if (Auth::attempt(
                    [
                        $this->username() => $this->inputUser,
                        'password' => $this->inputPass,
                        'active' => true
                    ])) {

                    return redirect()->intended($this->redirectTo)->with('success', __('Welcome') . ' ' . $this->adCn);

                // If user changed passwd on AD or we don't have local account
                } else {

                    // Update existing or create new local user
                    User::updateOrCreate(
                        [
                            'id' => $userId,
                        ],
                        [
                            'name' => $this->adCn,
                            $this->username() => trim($this->inputUser),
                            'password' => Hash::make($this->inputPass),
                        ]
                    );
                    // ... and authentificate from DB
                    if (Auth::attempt(
                        [
                            $this->username() => $this->inputUser,
                            'password' => $this->inputPass,
                            'active' => true,
                        ])) {
                        return redirect()
                            ->intended($this->redirectTo)
                            ->with('success', __('Welcome') . ' ' . Auth::user()->name);
                    // Something wrong with...
                    } else {
                        $this->incrementLoginAttempts($request);
                        return redirect(route('login'))
                            ->withInput()
                            ->with('danger', __('Unknown credentials'));
                    }
                }
            // User is not AD user, but, maybe, we have local account?
            } else {

                if (Auth::attempt(
                    [
                        $this->username() => $this->inputUser,
                        'password' => $this->inputPass,
                        'active' => true,
                    ])) {
                    return redirect()
                        ->intended($this->redirectTo)
                        ->with('success', __('Welcome') . ' ' . Auth::user()->name);

                } else {
                    $this->incrementLoginAttempts($request);
                    return redirect(route('login'))->withInput()->with('danger', __('Unknown credentials'));
                }
            }
        }
        // Unknown auth error...
        return redirect(route('login'))->withInput()->with('warning', __('Authentification error. Try again later'));
    }
}
