<?php
  
namespace App\Http\Requests\AuditManagment;
  
use Illuminate\Foundation\Http\FormRequest;
  
class AuditGenerateStoreRequest extends FormRequest
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
                'description'   =>'required',
                'observation'   =>'required',
                'risk'          =>'required',
                'action'        =>'required',
            ];
    }
}