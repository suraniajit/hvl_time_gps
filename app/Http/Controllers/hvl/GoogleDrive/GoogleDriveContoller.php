<?php

namespace App\Http\Controllers\hvl\GoogleDrive;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\GoogleMedia;
use App\GoogleUser;
use App\Http\Requests\GoogleDrive\GoogleDriveStoreRequest;
use App\Http\Requests\GoogleDrive\GoogleDriveUpdateRequest;

class GoogleDriveContoller extends Controller
{
    public function index(){
        $active_google_users = GoogleUser::where('default_connect',1)->first(); 
        $google_users = GoogleUser::paginate(5);
        return view('hvl.google_drive.index')
            ->with([
                'google_users'=>$google_users,
                'active_google_users'=>$active_google_users
            ]);
    }
    public function create(){
        return view('hvl.google_drive.create');
    }
    public function store(GoogleDriveStoreRequest $request) {
        //check it right or not
        if($request->default_connect){
            GoogleUser::where('default_connect','1')->update(['default_connect'=>'0']);        
        }
        $google_user = new GoogleUser();
        $google_user->mail_id = $request->mail;
        $google_user->client_id = $request->client_id;
        $google_user->client_secret = $request->client_secret;
        $google_user->refresh_token = $request->refresh_token;
        $google_user->default_connect = $request->default_connect;
        $google_user->folder_path = $request->folder_path;       
        $google_user->save();

        return redirect()->route('google_drive.index')->with('success', 'Successfully Google Drive Updated !');
    }

    public function edit($id) {
        $google_user = GoogleUser::where('id', '=', $id)
            ->first();
        return view('hvl.google_drive.edit', [
           'google_user'=>$google_user
        ]);
    }

    public function update(GoogleDriveUpdateRequest $request, $google_drive_id) {
        if($request->default_connect==1){
            GoogleUser::where('default_connect','1')->update(['default_connect'=>'0']);        
        }
        $google_user = GoogleUser::where('id', '=', $google_drive_id)->first();
        $google_user->mail_id = $request->mail;
        $google_user->client_id = $request->client_id;
        $google_user->client_secret = $request->client_secret;
        $google_user->refresh_token = $request->refresh_token;
        $google_user->default_connect = $request->default_connect;
        $google_user->folder_path = $request->folder_path;
        $google_user->save();  
        return redirect()->route('google_drive.index')->with('success', 'Successfully Google Drive Updated !');
    }
   
    function delete(Request $request) {
        /* single delete */
        $temp = EmailTemplate::find($request->input('id'));
        if ($temp->delete()) {
            return response()->json([
                'status'=>'Success',
                'message'=>'successfuly Template delete successfully'
            ]);
        }
        return response()->json([
            'status'=>'error',
            'message'=>'Template Not Found'
        ]);
    }

    function multidelete(Request $request) {
        /* multi delete */
        $email_template = new EmailTemplate();
        $flag = $email_template->whereIn('id',$request->input('ids'))->delete();
        if($flag){
            return response()->json([
                'status'=>'success',
                'message'=>'Successfuly Template delete successfully'
            ]);
        }
        return response()->json([
            'status'=>'error',
            'message'=>'something went to worng'
        ]);   
    }
}
