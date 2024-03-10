<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class GoogleMedia extends Model
{
    protected $table='google_drive_media_files';
    protected $fillable=[
        'drive_id',
        'media_code',
        'media_path',
        'file_name',
    ];
}
