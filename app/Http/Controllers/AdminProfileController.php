<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use Auth;
use App\Employee;
use App\Module;
use Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\hrms\LeaveRequest;
use Carbon\Carbon;
use Validator;
use App\Models\Penalty;
use App\Models\Attendance\Attendance;
use App\Models\training\SimulationUserResult;

class AdminProfileController extends Controller {

    public function adminProfileUpdate(Request $request) {


        // $id = Auth::User()->id=='1';
        $id='122';
        $location = "public/uploads/profile/";

        if (($request->file('profile_images'))) {
            $file_profile = $request->file('profile_images');
           //$file_profile_ = time() . '_' . trim($file_profile->getClientOriginalName());
            
            $file_profile_ = str_replace(' ', '', time() . '_' . trim($file_profile->getClientOriginalName()));;
            
            $extension = $request->file('profile_images')->getClientOriginalExtension();
            
            
            $file_profile->move($location, $file_profile_);
            DB::table('users')->whereId($id)->update(['profile_image' => $file_profile_,]);
        }
        if($request->email){
            DB::table('users')->whereId($id)->update(['email' => $request->email]);
        }
        if (($request->file('background_images'))) {
            $file_banner = $request->file('background_images');
            //$background_images = time() . '_' . trim($file_banner->getClientOriginalName());
            
            $background_images = str_replace(' ', '', time() . '_' . trim($file_banner->getClientOriginalName()));;
            
            $extension = $file_banner->getClientOriginalExtension();
            $file_banner->move($location, $background_images);
            DB::table('users')->whereId($id)->update(['background_images' => $background_images,]);
        }
        if (($request->file('business_logo'))) {
            
            
            $file_business_logo = $request->file('business_logo');
            
            $bussniess_images = str_replace(' ', '', time() . '_' . trim($file_business_logo->getClientOriginalName()));;
            
            $extension = $file_business_logo->getClientOriginalExtension();
            $file_business_logo->move($location, $bussniess_images);
            DB::table('users')->whereId($id)->update(['business_logo' => $bussniess_images,]);
        }
        DB::table('users')->whereId($id)
                ->update([
                    'copyright_label' => $request->copyright_label,
                    'name' => $request->name,
//                    'profile_image' => $file_profile_,
//                    'background_images' => $background_images,
//                    'business_logo' => $bussniess_images,
                    'updated_at' => date('Y-m-d'),
        ]);
        return redirect()->back()->with('success', 'Profile Updated Successfully... !');
    }

    public function adminProfile(Request $request) {
        // $user_id = Auth::User()->id;
        $user_id = '122';
        $breadcrumbs = [
                ['link' => "/", 'name' => "Home"],
                ['name' => "View"],
        ];
        //Pageheader set true for breadcrumbs
        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true, 'isCustomizer' => true];

        $user = DB::table('users')->where('id', $user_id)->first();

        $location = "public/uploads/profile/";
        return view('admin.admin', [
            'pageConfigs' => $pageConfigs,
            'breadcrumbs' => $breadcrumbs,
            'location' => $location,
            'user' => $user
        ]);
    }

}
