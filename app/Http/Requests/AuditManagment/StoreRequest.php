<?php
  
namespace App\Http\Requests\AuditManagment;
  
use Illuminate\Foundation\Http\FormRequest;
  
class StoreRequest extends FormRequest
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
                'audit_type' => 'required',
                'customer_id'=>'required',
                'schedule_date'=>'required',
                'schedule_time'=>'required',
                'schedule_notes'=>'required',
            ];
    }
}