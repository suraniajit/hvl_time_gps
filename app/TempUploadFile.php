<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TempUploadFile extends Model
{
    protected $table='temp_upload_files';
    const IMAGEPATH = 'temp/img/audit_gallery/';
    protected $fillable=[
        'path',
        'file',
        'delete_at'
    ];
    
    public function getImage($image){
        return $this->getImagePath().$image;
    }
    public function getImagePath(){
        return self::IMAGEPATH;
    }
}
