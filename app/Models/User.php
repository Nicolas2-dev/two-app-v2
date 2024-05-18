<?php
/**
 * Two - User
 *
 * @author  Nicolas Devoy
 * @email   nicolas@nicodev.fr 
 * @version 1.0.0
 * @date    15 Fevrier 2023
 */

namespace App\Models;


use Two\Auth\Traits\UserTrait;
use Two\Auth\Contracts\UserInterface;
use Two\Auth\Traits\AuthorizableTrait;
use Two\Database\ORM\Model as BaseModel;


class User extends BaseModel implements UserInterface
{
    use UserTrait, AuthorizableTrait;

    //
    protected $table = 'users';

    protected $primaryKey = 'id';

    protected $fillable = array('username', 'password', 'realname', 'email', 'activation_code');

    protected $hidden = array('password', 'remember_token');

}
