<?php

namespace App\Http\Controllers\hvl\Role;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExcelBulkUploadRequest;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Role;
use Auth;


class RoleBulkUploadController extends Controller {
    public function index(){
        if(Auth::user()->can('Access Role Bulkupload')){
            return view('hvl.role.bulk_upload');
        }else{
             abort(403, 'Access denied');
        }
    }    
    public function saveRoleManagementBulkUpload(ExcelBulkUploadRequest $request){
        $user = Auth::user();
        
        if(!$user->can('Access Role Bulkupload')){
           abort(403, 'Access denied');
        }
        $can_role_add = $user->can('Create Role Bulkupload'); 
        $can_role_edit = $user->can('Edit Role Bulkupload');
        $can_role_delete = $user->can('Delete Role Bulkupload');
        $line_no = 0;
        $flag = false;
        try{
            
            $create_data_array = [];
            $delete_data_array = [];
            DB::beginTransaction();
            $ExcelArray = Excel::toArray(new Controller(), $request->file('excel_file'));
            $prepare_data  = $this->setData($ExcelArray[0]);
            foreach($prepare_data as $ $line_no=>$row){
                if($row['action'] == 'ADD'){
                    if(!$can_role_add){
                        abort(403, 'Access Denied Multi Add Role '.($line_no+1));
                    }            
                    Role::create(
                        ['name' => $row['role']]
                    );
                }
                else if($row['action'] == 'DELETE'){
                    if(!$can_role_delete){
                        abort(403, 'Access Denied Multi delete Role '.($line_no+1));
                    }
                    $role1 = new Role();
                    $role1 = $role1->where('name',$row['role'])->first();
                    if(!$role1){
                        throw new \ErrorException('Role Not Found');
                    }
                    $role = new Role();
                    $role = $role->where('name',$row['role']);
                    $role->delete();
                }
                else if($row['action'] == 'EDIT'){
                    if(!$can_role_edit){
                        abort(403, 'Access Denied Multi Edit Role '.($line_no+1));
                    }
                    $role = new Role();
                    $role = $role->where('name',$row['role'])->first();
                    if(!$role){
                        throw new \ErrorException('Role Not Found');
                    }
                    $role->name = $row['new_role'];
                    $role->save();
                }
            }
            DB::commit();
            return redirect()->route('admin.role_bulkupload.index')->with('success', 'Data has been uploaded successfully');        
        }catch (\Exception $e) {
            DB::rollBack();
            return self::index($request)->withErrors("Please show a list of fields or row no = ".($line_no+1)." where error is ".$e->getMessage());
        }
    }
    public function setData($data){
        $response = [];
        foreach($data as $key=>$row){
            if($key == 0){
                continue;
            }
            if(trim(strtoupper($row[0])) == 'EDIT'){
                $response[] =   [
                    'action'=>trim(strtoupper($row[0])),
                    'role'=>trim($row[1]),
                    'new_role'=>trim($row[2])
                ];    
            }else{
                $response[] =   [
                'action'=>trim(strtoupper($row[0])),
                'role'=>trim($row[1]),
                ];
            }
            
        }
        return $response;
    }
}
