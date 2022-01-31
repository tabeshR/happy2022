<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Class ActiveCode
 * @package App\Models
 * @method static string generateCode($user)
 * @method static string deleteAllActiveCodes($user)
 * @method static bool isValidCode($user,$code,$mobile)
 */
class ActiveCode extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'code', 'mobile', 'expired_at'
    ];
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeGenerateCode($query, $user)
    {
        do {
            $code = mt_rand(10000, 99999);
        } while ($this->active_code_is_exists($code, $user));
        return $code;
    }

    private function active_code_is_exists($code, $user)
    {
        return !!$user->activeCode()->where('code', $code)->where('expired_at', '>', now())->first();
    }

    public function scopeDeleteAllActiveCodes($query, $user)
    {
       return $user->activeCode()->delete();
    }

    public function scopeIsValidCode($query,$user,$code,$mobile)
    {
       return !! $user->activeCode()->where('code',$code)->where('expired_at','>',now())->where('mobile',$mobile)->first();
    }
}
