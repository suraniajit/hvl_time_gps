<?php

namespace App\Models\hvl;

use Illuminate\Database\Eloquent\Model;

class LeadMaster extends Model {

    protected $table = 'hvl_lead_master';
    protected $dates = ['create_date', 'follow_date'];
    protected $fillable = [
        'company_type',
        'last_company_name',
        'f_name',
        'email',
        'email_2',
        'phone',
        'employee_id',
        'owner',
        'create_date',
        'follow_date',
        'status',
        'rating',
        'lead_source',
        'industry',
        'address',
        'comment',
        'credit_value',
        'is_active',
        'revenue',
        'lead_size',
        'comment_2',
        'comment_3'
    ];
    const large = 1;
    const medium = 2;
    const small = 3;
    
    const ACTIVE = 0;
    const INACTIVE = 1;
     
    
    
    const large_text = 'Large';
    const medium_text = 'Medium';
    const small_text = 'Small';
    
    const ACTIVE_TEXT = 'Active';
    const INACTIVE_TEXT = 'Inactive';
    
    public function getLeadSizeOption(){
        return [
            self::large     =>  self::large_text,
            self::medium    =>  self::medium_text,
            self::small     =>  self::small_text  
        ];
    }     
    public function getLeadSizeText($code){
        $option = $this->getLeadSizeOption();
        return $option[$code];
    }

    public function getIsActiveOption(){
        return [
            self::ACTIVE     =>  self::ACTIVE_TEXT,
            self::INACTIVE    =>  self::INACTIVE_TEXT,
        ];
    }     
    public function getIsActiveText($code){
        $option = $this->getIsActiveOption();
        if(isset($option[$code])){
            return $option[$code];
        } 
        return "";
    }

}
