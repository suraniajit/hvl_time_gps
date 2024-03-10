<?php
namespace App\Http\Requests\GoogleDrive;  

use Illuminate\Foundation\Http\FormRequest;
  
class GoogleDriveUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
  
    public function rules()
    {
        return [
                'mail'=>'required|email|unique:google_drive_users,mail_id,'. $this->id,
                'client_id'=>'required',
                'client_secret'=>'required',
                'refresh_token'=>'required',
                'default_connect'=>'required',
                'folder_path'=>'required',
            ];
    }

    public function messages()
    {
        return [
            
            
        ];
    }
}