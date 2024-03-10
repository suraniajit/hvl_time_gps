<?php

namespace App\Models\hvl;

use Illuminate\Database\Eloquent\Model;

class ActivityServiceReport extends Model {

    protected $table = 'activity_service_reports';
    const IMAGE_PATH = 'public/uploads/activitymaster/service/signature';
    protected $fillable = [
        'activity_id',
        'service_spacification',
        'in_time',
        'out_time',
        'technican_name',
        'technican_sign_image',
        'client_sign_image',
        'client_name',
        'client_mobile'
    ];
    
}
