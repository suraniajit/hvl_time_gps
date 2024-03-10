<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GoogleUser extends Model
{
    protected $table='google_drive_users';
    protected $fillable=[
        'mail_id',
        'client_id',
        'client_secret',
        'refresh_token',
        'default_connect',
        'folder_path',
    ];   
}
