<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//以下を書かないと、次のエラーが出る
//TypeError Argument 1 passed to Illuminate\Auth\SessionGuard::login() must be an instance of Illuminate\Contracts\Auth\Authenticatable, instance of App\User given, called in /Users/saitoshigeyuki/projects/trial/vendor/laravel/ui/auth-backend/RegistersUsers.php on line 36
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable //class User extends Model
{
    //対応するテーブル名がモデル名の複数形であれば、以下のように明示する必要はない
    //protected $table = 'users';
    //protected $timestamps = true;

    //以下のfillable〜を書いた理由は、react導入して--authしてからsqlエラーでたのを解消するため↓
    //SQLSTATE[HY000]: General error: 1364 Field 'email' doesn't have a default value 
    protected $fillable = ['nickname', 'email', 'password', 'profile_image'];
}
