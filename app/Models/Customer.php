<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Customer extends Authenticatable
{
    use Notifiable;

    protected $table = 'CUSTOMER';

    protected $primaryKey = 'CustomerID';

    protected $fillable = ['Username', 'Password', 'FirstName', 'LastName', 'Email', 'PhoneNumber', 'ShippingAddress'];

    protected $hidden = ['Password'];

    public $timestamps = false;
    public function getAuthPassword(){
        return $this->Password;
    }
}
