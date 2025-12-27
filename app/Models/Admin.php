<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $table = 'ADMIN';

    protected $primaryKey = 'AdminID';

    protected $fillable = ['UserName', 'Email', 'Password'];

    protected $hidden = ['Password'];

    public $timestamps = false;

    public function getAuthPassword(){
        return $this->Password;
    }
}
