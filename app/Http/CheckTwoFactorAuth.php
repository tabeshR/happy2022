<?php


namespace App\Http;


use App\Models\ActiveCode;
use App\Notifications\SmsNotification;

trait CheckTwoFactorAuth
{
    function check($user)
    {
        if ($user->two_factor_type === 'sms') {
            ActiveCode::deleteAllActiveCodes($user);
            $code = ActiveCode::generateCode($user);
            $user->activeCode()->create([
                'code' => $code,
                'expired_at' => now()->addMinutes(10),
                'mobile' => $user->mobile
            ]);
            $user->notify(new SmsNotification($code,$user->mobile));
            session()->flash('auth', [
                'mobile' => $user->mobile,
                'user_id' => $user->id,
                'type' => $user->two_factor_type,
                'remember' => request()->has('remember')
            ]);
            return redirect(route('auth.2fa'));
        } else if ($user->two_factor_type === 'off') {
            return false;
        }
    }
}
