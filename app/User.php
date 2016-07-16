<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * App\User
 *
 * @mixin \Eloquent
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $remember_token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $role_level
 * @method static \Illuminate\Database\Query\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereRoleLevel($value)
 * @property string $username
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Post[] $posts
 * @method static \Illuminate\Database\Query\Builder|\App\User whereUsername($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User admin()
 * @method static \Illuminate\Database\Query\Builder|\App\User notAdmin()
 * @property-read mixed $avatar
 * @property-read \App\Role $role
 * @property string $bio
 * @method static \Illuminate\Database\Query\Builder|\App\User whereBio($value)
 */
class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'username', 'bio'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    //RELATIONS
    public function posts(){
        return $this->hasMany(Post::class);
    }
    public function role(){
        return $this->belongsTo(Role::class, 'role_level', 'level');
    }
    
    // Related attributes
    public function isAdmin(){
        return $this->role_level == 9;
    }
    public function owns(Post $post){
        return $this->id == $post->created_by;
    }

    //SCOPES
    public function scopeAdmin(){
        return $this->where('role_level', '=', 9);
    }
    public function scopeNotAdmin(){
        return $this->where('role_level', '!=', 9);
    }

    //Mutators
    public function getAvatarAttribute(){
        return 'https://www.gravatar.com/avatar/'. md5($this->email);
    }
}
