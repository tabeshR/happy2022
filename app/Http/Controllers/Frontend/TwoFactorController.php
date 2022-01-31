<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ActiveCode;
use App\Models\User;
use App\Notifications\SmsNotification;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TwoFactorController extends Controller
{
    public function index()
    {
        return view('profile.2fa.index');
    }

    public function settings(Request $request)
    {
        $data = $request->validate([
            'type' => 'required|in:off,sms',
            'mobile' => ['required_unless:type,off',Rule::unique('users')->ignore($request->user()->id)]
        ],
            [
                'mobile.required_unless' => "فیلد تلفن همراه الزامیست مگر اینکه فیلد وضعیت مقدارش غیرفعال باشد.",
                'type.in' => 'وضعیت انتخاب شده معتبر نیست'
            ]);
        if ($data['type'] == 'off') {
            $request->user()->update([
                'two_factor_type' => 'off'
            ]);
            alert()->success('احراز هویت دومرحله ای خاموش شد', '')->persistent('باشه');
            return back();
        } else if ($data['type'] == 'sms') {
            if ($request->user()->mobile == $data['mobile']) {
                $request->user()->update([
                    'two_factor_type' => 'sms'
                ]);
                alert()->success('احراز هویت دومرحله ای فعال شد', '')->persistent('باشه');
                return back();
            } else {
                // todo generate a code
                ActiveCode::deleteAllActiveCodes($request->user());
                $code = ActiveCode::generateCode($request->user());
                $request->user()->activeCode()->create([
                    'mobile' => $data['mobile'],
                    'code' => $code,
                    'expired_at' => now()->addMinutes(15)
                ]);
                $request->user()->notify(new SmsNotification($code,$data['mobile']));

                // todo create a session
                session()->flash('2fa', [
                    'mobile' => $data['mobile']
                ]);
                return redirect(route('2fa.verify.mobile'));
            }
        }
    }

    public function getVerifyMobile()
    {
        if (!session()->has('2fa')) {
            return back();
        }
        session()->reflash();
        return view('profile.2fa.verify-mobile');
    }

    public function postVerifyMobile(Request $request)
    {
        if (!session()->has('2fa')) {
            return back();
        }
        $data = $request->validate([
            'code' => 'required'
        ]);
        $status = ActiveCode::isValidCode($request->user(), $data['code'], session()->get('2fa.mobile'));
        if ($status) {
            $request->user()->update([
                'mobile' => session()->get('2fa.mobile'),
                'two_factor_type' => 'sms'
            ]);
            $request->user()->activeCode()->delete();
            alert()->success('احراز هویت دومرحله ای فعال شد')->persistent('باشه');
            ActiveCode::deleteAllActiveCodes($request->user());
        } else {
            session()->reflash();
            alert()->error('کد وارد شده معتبر نمیباشد')->persistent('باشه');
            return back();
        }
        return redirect(route('2fa.settings'));
    }

    public function getAuthCode()
    {
        auth()->logout();
        if (!session()->has('auth')) {
            return redirect(route('login'));
        }
        session()->reflash();
        return view('auth.2fa');
    }

    public function postAuthCode(Request $request)
    {

        if (!session()->has('auth')) {
            return redirect(route('login'));
        }
        $data = $request->validate([
            'code' => 'required'
        ]);
        $user = User::find(session()->get('auth.user_id'));
        if ($user) {
            $status = ActiveCode::isValidCode($user, $data['code'], session()->get('auth.mobile'));
            if ($status) {
                auth()->loginUsingId($user->id, session()->get('auth.remember'));
                return redirect(route('profile'));
            } else {
                auth()->logout();
                session()->reflash();
                alert()->error('کد وارد شده نامعتبر است')->persistent('باشه');
                return back();
            }
        } else {
            auth()->logout();
            alert()->error('حساب کاربری معتبر نمیباشد')->persistent('باشه');
            return redirect(route('login'));
        }
    }
}
