<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Illuminate\Auth\MustVerifyEmail;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Spatie\Permission\Traits\HasRoles;
/**
 * Class User.
 *
 * @package namespace App\Entities;
 */
class User extends Model implements Transformable, AuthorizableContract, AuthenticatableContract, CanResetPasswordContract
{
    use TransformableTrait,HasApiTokens,Notifiable,HasRoles,Authenticatable, Authorizable, CanResetPassword, MustVerifyEmail;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','name','username','email', 'password','gender','address','phone_number','department','birth_day','birth_place'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    /**
     * @var mixed
     */
    private $updated_at;
    /**
     * @var mixed
     */
    private $created_at;
    /**
     * @var mixed
     */
    private $birth_place;
    /**
     * @var mixed
     */
    private $birth_day;
    /**
     * @var mixed
     */
    private $department;
    /**
     * @var mixed
     */
    private $phone_number;
    /**
     * @var mixed
     */
    private $address;
    /**
     * @var mixed
     */
    private $gender;
    /**
     * @var mixed
     */
    private $name;
    /**
     * @var mixed
     */
    private $id;

    public function posts(){
        return $this->hasMany('App\Entities\Post', 'user_id', 'id');
    }

}
