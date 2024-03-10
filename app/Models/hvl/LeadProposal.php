<?php

namespace App\Models\hvl;

use Illuminate\Database\Eloquent\Model;

class LeadProposal extends Model {

    protected $table = 'hvl_lead_proposals';
     const filePath = 'proposal/images';
    protected $fillable = [
        'lead_id',
        'proposal'

    ];
    public function getImageExtention(){
        return [    
            'gif',
            'jpg',
            'jpeg',
            'png'
        ];
    }
    public function isImage($fileName){
        $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        if (in_array($ext, $this->getImageExtention())) {
            return true;
        } else {
            return false;
        }
    }
    public function isDocument($fileName){
        $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        if (in_array($ext, ['docx'])) {
            return true;
        } else {
            return false;
        }
    }
    public function isPdf($fileName){
        $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        if (in_array($ext, ['pdf'])) {
            return true;
        } else {
            return false;
        }
    }
    
    
}
