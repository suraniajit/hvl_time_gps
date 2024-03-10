<?php
  
namespace App\Http\Requests\GoogleDrive;
  
use Illuminate\Foundation\Http\FormRequest;
  
class GoogleDriveStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
  
    /** 
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
                'mail'=>'required|email|unique:google_drive_users,mail_id',
                'client_id'=>'required',
                'client_secret'=>'required',
                'refresh_token'=>'required',
                'default_connect'=>'required',
                'folder_path'=>'required'
            ];
    }
     public function messages()
    {
        return [
            
            
        ];
    }
}