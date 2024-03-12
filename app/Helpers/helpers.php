<?php
 // Code within app\Helpers\Helper.php
namespace App\Helpers;
use Config;
use Illuminate\Support\Str;
use App\User;
use App\GoogleMedia;
use App\GoogleUser;
use Illuminate\Support\Facades\Http;
use Google\Client;
use Google\Service\Drive;
use Google\Service\DriveFile;
use App\Helpers\Filesystem;
use App\SystemLog;
use Illuminate\Support\Facades\DB;
use Auth;
use DateTime;

class Helper
{
    public static function applClasses()
    {
        // default data value
        $dataDefault = [
            'mainLayoutType' => 'vertical-modern-menu',
            'pageHeader' => false,
            'bodyCustomClass' => '',
            'navbarLarge' => true,
            'navbarBgColor' => '',
            'isNavbarDark' => null,
            'isNavbarFixed' => true,
            'activeMenuColor' => '',
            'isMenuDark' => null,
            'isMenuCollapsed' => false,
            'activeMenuType' => '',
            'isFooterDark' => null,
            'isFooterFixed' => false,
            'templateTitle' => '',
            'isCustomizer' => true,
            'defaultLanguage'=>'en',
            'largeScreenLogo' => 'images/logo/materialize-logo-color.png',
            'smallScreenLogo' => 'images/logo/materialize-logo.png',
            'isFabButton'=>false, 
            'direction' => env('MIX_CONTENT_DIRECTION', 'ltr'),
        ];
        // if any key missing of array from custom.php file it will be merge and set a default value from dataDefault array and store in data variable
        $data = array_merge($dataDefault, config('custom.custom'));
        // $fullURL = request()->fullurl();
        // $data = [];
        // if (App()->environment() === "production") { 
        //     for ($i = 1; $i < 6; $i++) {
        //         $contains = Str::contains($fullURL, "demo-" . $i);
        //         if ($contains === true) {
        //             $data = config("demo-".$i.".custom");
        //         }
        //     }
        // }
        // $data = array_merge($dataDefault, $data);
        // all available option of materialize template
        $allOptions = [
            'mainLayoutType' => array('vertical-modern-menu', 'vertical-menu-nav-dark', 'vertical-gradient-menu', 'vertical-dark-menu', 'horizontal-menu'),
            'pageHeader' => array(true, false),
            'navbarLarge' => array(true, false),
            'isNavbarDark' => array(null, true, false),
            'isNavbarFixed' => array(true, false),
            'isMenuDark' => array(null, true, false),
            'isMenuCollapsed' => array(true, false),
            'activeMenuType' => array('sidenav-active-square'=>'sidenav-active-square', 'sidenav-active-rounded'=>'sidenav-active-rounded', 'sidenav-active-fullwidth'=>'sidenav-active-fullwidth'),
            'isFooterDark' => array(null, true, false),
            'isFooterFixed' => array(false, true),
            'isCustomizer' => array(true, false),
            'isFabButton'=> array(false, true), 
            'defaultLanguage'=>array('en'=>'en','fr'=>'fr','de'=>'de','pt'=>'pt'),
            'direction' => array('ltr'=>'ltr', 'rtl'=>'rtl'),
        ];
        //if any options value empty or wrong in custom.php config file then set a default value
        foreach ($allOptions as $key => $value) {
            if (gettype($data[$key]) === gettype($dataDefault[$key])) {
                if (is_string($data[$key])) {
                    $result = array_search($data[$key], $value);
                    if (empty($result)) {
                        $data[$key] = $dataDefault[$key];
                    }
                }
            } else {
                if (is_string($dataDefault[$key])) {
                    $data[$key] = $dataDefault[$key];
                } elseif (is_bool($dataDefault[$key])) {
                    $data[$key] = $dataDefault[$key];
                } elseif (is_null($dataDefault[$key])) {
                    is_string($data[$key]) ? $data[$key] = $dataDefault[$key] : '';
                }
            }
        }
        // if any of template logo is not set or empty is set to default logo
        if (empty($data['largeScreenLogo'])) {
            $data['largeScreenLogo'] = $dataDefault['largeScreenLogo'];
        }
        if (empty($data['smallScreenLogo'])) {
            $data['smallScreenLogo'] = $dataDefault['smallScreenLogo'];
        }
        //mainLayoutTypeClass array contain default class of body element
        $mainLayoutTypeClass = [
            'vertical-modern-menu' => 'vertical-layout vertical-menu-collapsible page-header-dark vertical-modern-menu 2-columns',
            'vertical-menu-nav-dark' => 'vertical-layout page-header-light vertical-menu-collapsible vertical-menu-nav-dark 2-columns',
            'vertical-gradient-menu' => 'vertical-layout page-header-light vertical-menu-collapsible vertical-gradient-menu 2-columns',
            'vertical-dark-menu' => 'vertical-layout page-header-light vertical-menu-collapsible vertical-dark-menu 2-columns',
            'horizontal-menu' => 'horizontal-layout page-header-light horizontal-menu 2-columns',
        ];
        //sidenavMain array contain default class of sidenav
        $sidenavMain = [
            'vertical-modern-menu' => 'sidenav-main nav-expanded nav-lock nav-collapsible',
            'vertical-menu-nav-dark' => 'sidenav-main nav-expanded nav-lock nav-collapsible navbar-full',
            'vertical-gradient-menu' => 'sidenav-main nav-expanded nav-lock nav-collapsible gradient-45deg-deep-purple-blue sidenav-gradient ',
            'vertical-dark-menu' => 'sidenav-main nav-expanded nav-lock nav-collapsible',
            'horizontal-menu' => 'sidenav-main nav-expanded nav-lock nav-collapsible sidenav-fixed hide-on-large-only',
        ];
        //sidenavMainColor array contain sidenav menu's color class according to layout types
        $sidenavMainColor = [
            'vertical-modern-menu' => 'sidenav-light',
            'vertical-menu-nav-dark' => 'sidenav-light',
            'vertical-gradient-menu' => 'sidenav-dark',
            'vertical-dark-menu' => 'sidenav-dark',
            'horizontal-menu' => '',
        ];
        //activeMenuTypeClass array contain active menu class of sidenav according to layout types
        $activeMenuTypeClass = [
            'vertical-modern-menu' => 'sidenav-active-square',
            'vertical-menu-nav-dark' => 'sidenav-active-rounded',
            'vertical-gradient-menu' => 'sidenav-active-rounded',
            'vertical-dark-menu' => 'sidenav-active-rounded',
            'horizontal-menu' => '',
        ];
        //navbarMainClass array contain navbar's default classes
        $navbarMainClass = [
            'vertical-modern-menu' => 'navbar-main navbar-color nav-collapsible no-shadow nav-expanded sideNav-lock',
            'vertical-menu-nav-dark' => 'navbar-main navbar-color nav-collapsible sideNav-lock gradient-shadow',
            'vertical-gradient-menu' => 'navbar-main navbar-color nav-collapsible sideNav-lock',
            'vertical-dark-menu' => 'navbar-main navbar-color nav-collapsible sideNav-lock',
            'horizontal-menu' => 'navbar-main navbar-color nav-collapsible sideNav-lock',
        ];
        //navbarMainColor array contain navabar's color classes according to layout types
        $navbarMainColor = [
            'vertical-modern-menu' => 'navbar-dark gradient-45deg-indigo-purple',
            'vertical-menu-nav-dark' => 'navbar-dark gradient-45deg-purple-deep-orange',
            'vertical-gradient-menu' => 'navbar-light',
            'vertical-dark-menu' => 'navbar-light',
            'horizontal-menu' => 'navbar-dark gradient-45deg-light-blue-cyan',
        ];
        //navbarLargeColor array contain navbarlarge's default color classes
        $navbarLargeColor = [
            'vertical-modern-menu' => 'gradient-45deg-indigo-purple',
            'vertical-menu-nav-dark' => 'blue-grey lighten-5',
            'vertical-gradient-menu' => 'blue-grey lighten-5',
            'vertical-dark-menu' => 'blue-grey lighten-5',
            'horizontal-menu' => 'blue-grey lighten-5',
        ];
        //mainFooterClass array contain Footer's default classes
        $mainFooterClass = [
            'vertical-modern-menu' => 'page-footer footer gradient-shadow',
            'vertical-menu-nav-dark' => 'page-footer footer gradient-shadow',
            'vertical-gradient-menu' => 'page-footer footer',
            'vertical-dark-menu' => 'page-footer footer',
            'horizontal-menu' => 'page-footer footer gradient-shadow',
        ];
        //mainFooterColor array contain footer's color classes
        $mainFooterColor = [
            'vertical-modern-menu' => 'footer-dark gradient-45deg-indigo-purple',
            'vertical-menu-nav-dark' => 'footer-dark gradient-45deg-purple-deep-orange',
            'vertical-gradient-menu' => 'footer-light',
            'vertical-dark-menu' => 'footer-light',
            'horizontal-menu' => 'footer-dark gradient-45deg-light-blue-cyan',
        ];
        //  above arrary override through dynamic data
        $layoutClasses = [
            'mainLayoutType' => $data['mainLayoutType'],
            'mainLayoutTypeClass' => $mainLayoutTypeClass[$data['mainLayoutType']],
            'sidenavMain' => $sidenavMain[$data['mainLayoutType']],
            'navbarMainClass' => $navbarMainClass[$data['mainLayoutType']],
            'navbarMainColor' => $navbarMainColor[$data['mainLayoutType']],
            'pageHeader' => $data['pageHeader'],
            'bodyCustomClass' => $data['bodyCustomClass'],
            'navbarLarge' => $data['navbarLarge'],
            'navbarLargeColor' => $navbarLargeColor[$data['mainLayoutType']],
            'navbarBgColor' => $data['navbarBgColor'],
            'isNavbarDark' => $data['isNavbarDark'],
            'isNavbarFixed' => $data['isNavbarFixed'],
            'activeMenuColor' => $data['activeMenuColor'],
            'isMenuDark' => $data['isMenuDark'],
            'sidenavMainColor' => $sidenavMainColor[$data['mainLayoutType']],
            'isMenuCollapsed' => $data['isMenuCollapsed'],
            'activeMenuType' => $data['activeMenuType'],
            'activeMenuTypeClass' => $activeMenuTypeClass[$data['mainLayoutType']],
            'isFooterDark' => $data['isFooterDark'],
            'isFooterFixed' => $data['isFooterFixed'],
            'templateTitle' => $data['templateTitle'],
            'isCustomizer' => $data['isCustomizer'],
            'largeScreenLogo' => $data['largeScreenLogo'],
            'smallScreenLogo' => $data['smallScreenLogo'],
            'defaultLanguage'=>$allOptions['defaultLanguage'][$data['defaultLanguage']],
            'mainFooterClass' => $mainFooterClass[$data['mainLayoutType']],
            'mainFooterColor' => $mainFooterColor[$data['mainLayoutType']],
            'isFabButton'=>$data['isFabButton'],
            'direction' => $data['direction'],
        ];
         // set default language if session hasn't locale value the set default language
         if(!session()->has('locale')){
            app()->setLocale($layoutClasses['defaultLanguage']);
        }
        return $layoutClasses;
    }
    // updatesPageConfig function override all configuration of custom.php file as page requirements.
    public static function updatePageConfig($pageConfigs)
    {
        $demo = 'custom';
        $custom = 'custom';
        if (isset($pageConfigs)) {
            if (count($pageConfigs) > 0) {
                foreach ($pageConfigs as $config => $val) {
                    Config::set($demo . '.' . $custom . '.' . $config, $val);
                }
            }
        }
    }
    public function transformDate($value, $format = 'Y-m-d')
    {
        try {
            return \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value));
        } catch (\ErrorException $e) {
             throw new \ErrorException($value.' :Date Forment Issue');
            return \Carbon\Carbon::createFromFormat($format, $value);
        }
    }
    public function getSuperAdmin(){
        $user = User::where('id',122)->first();
        if($user){
            return $user->email;
        }
        return false;
    }
    public function paginateLink($model)
    {
        if($model->lastPage() == 1)
            return '';
        $per_page_first_item_number =  ($model->perPage()*($model->currentPage()-1)+1);
        $per_page_last_item_number =  ((($model->perPage()*($model->currentPage()-1)) + ($model->perPage()) ) < $model->total())?($model->perPage()*($model->currentPage()-1)) + ($model->perPage()):$model->total();
        
        $nav_string ='<nav><div class="row"><div class="col-sm-12 col-md-5">';
        $nav_string = $nav_string.'Showing  '.$per_page_first_item_number.' to '.$per_page_last_item_number.' of '.$model->total().' entries';
        $nav_string =$nav_string.'</div><div class="col-sm-12 col-md-7"><div class="paginate_linkes">';
        $nav_string =$nav_string.'<ul class="pagination">';
        if($model->lastPage()>6){
            if($model->currentPage() != 1)
            {
                $nav_string =$nav_string. '<li class="page-item x"   aria-label="&laquo; Previous">
                                                <button  class="page-link" onclick="loadPageGrid(this)" data-page-url="'.$model->url(1).'" >&lsaquo;&lsaquo;</button>
                                            </li>';
    
                $nav_string =$nav_string. '<li class="page-item x"  aria-label="&laquo; Previous">
                                                <button  class="page-link" onclick="loadPageGrid(this)" data-page-url="'.$model->previousPageUrl().'" >&lsaquo;</button>
                                            </li>';
            }
           for($i = $model->currentPage()-1;$i <= $model->currentPage()+2;$i++)
           {
                if($i==0)
                    continue;
                if($i>$model->lastPage())
                    break;

                $is_active = ($model->currentPage()==$i)?'active':'';
                $nav_string = $nav_string.'<li class="page-item '.$is_active.'">';
                if($model->currentPage()==$i){
                    $nav_string = $nav_string .'<span class="page-link">'.$i.'</span>';
                }else{
                    $nav_string = $nav_string.'<button  class="page-link" onclick="loadPageGrid(this)" data-page-url="'.$model->url($i).'" >'.$i.'</button>';
                }
                $nav_string = $nav_string.'</li>';
               
           }
            if($model->currentPage() != $model->lastPage())
            {
                $nav_string =$nav_string. '<li class="page-item x"  aria-label="&laquo; Previous">
                                                <button  class="page-link" onclick="loadPageGrid(this)" data-page-url="'.$model->nextPageUrl().'" >&gt</button>
                                            </li>';
                $nav_string =$nav_string. '<li class="page-item x"  aria-label="&laquo; Previous">
                                                <button  class="page-link" onclick="loadPageGrid(this)" data-page-url="'.$model->url($model->lastPage()).'" >&gt;&gt;</button>
                                            </li>';
            }
           
        }else{
            if($model->currentPage() != 1)
            {
            $nav_string =$nav_string. '<li class="page-item x"  aria-label="&laquo; Previous">
                <button  class="page-link" onclick="loadPageGrid(this)" data-page-url="'.$model->previousPageUrl().'" >&lsaquo;</button>
            </li>';
            }
            for($i = 1;$i <= $model->lastPage();$i++)
            {   
                $is_active = ($model->currentPage()==$i)?'active':'';
                $nav_string = $nav_string.'<li class="page-item '.$is_active.'">';
                if($model->currentPage()==$i){
                    $nav_string = $nav_string .'<span class="page-link">'.$i.'</span>';
                }else{
                    $nav_string = $nav_string.'<button  class="page-link" onclick="loadPageGrid(this)" data-page-url="'.$model->url($i).'" >'.$i.'</button>';
                }
                $nav_string = $nav_string.'</li>';
            }
            if($model->currentPage() != $model->lastPage())
            {
                $nav_string =$nav_string. '<li class="page-item x"  aria-label="&laquo; Previous">
                                                <button  class="page-link" onclick="loadPageGrid(this)" data-page-url="'.$model->nextPageUrl().'" >&gt</button>
                                            </li>';
                
            }
           
        } 
        $nav_string =$nav_string.'</div></ul></div></nav>';
        return  $nav_string;
    }
    public function perPageLimit($model)
    {
        $nav_string = '';
        if($model->lastPage() == 1)
            return '';
        // for per page limite 
        $nav_string =$nav_string.'<nav><ul class="pagination">
        <select>';
        foreach(config('app.pagination_per_page') as $row){
            $nav_string =$nav_string.'<option>'.$row.'</option>';
        }
        $nav_string =$nav_string.'</select>';
        $nav_string =$nav_string.'</ul></nav>';
        // for per page limite 
        

        return  $nav_string;
    }

    public function getGoogleDriver($drive_id){
        $db_google_client = GoogleUser::where('id',$drive_id)->first();
        $google_drive_client = new Client();
        $google_drive_client->setClientId($db_google_client->client_id);//'1081355800236-hch7j7lmjdholgfemamd8btpjd718jmg.apps.googleusercontent.com');
        $google_drive_client->setClientSecret($db_google_client->client_secret);//'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');
        $google_drive_client->refreshToken($db_google_client->refresh_token);//'1//04-aoJuX48tIcCgYIARAAGAQSNwF-L9IrYbdJf2a87dhFn3a5_85j6xISK-PR1xXGaXRkZidTjw58Bxik7X4ZG1PFO9BKfDxTjLM');
        $service = new \Google_Service_Drive($google_drive_client);
        $adapter = new \Hypweb\Flysystem\GoogleDrive\GoogleDriveAdapter($service,$db_google_client->folder_path);
        $file_system = new Filesystem($adapter); 
        return  $file_system;
    }
    public function getFileCode(){
            $id= GoogleMedia::max('id')+1;
            return 'file-'.$id;        
    }
    public function uploadGoogleFile($google_drive_file,$file_param=null){
        try{
            $db_google_client = GoogleUser::where('default_connect',1)->first();
            if(isset($file_param['file_name'])){
                $file_name = $file_param['file_name'];
            }else{
                $file_name = date('ymdhis_').$google_drive_file->getClientOriginalName();
            }            
            $google_drive = $this->getGoogleDriver( $db_google_client->id);
            $file_upload_result = $google_drive->put($file_name,file_get_contents($google_drive_file)); 
            if(is_array($file_upload_result)){
                $google_media = new GoogleMedia();
                $google_media->drive_id = $db_google_client->id;
                $google_media->media_code = $this->getFileCode();
                $google_media->media_path = $file_upload_result['path'];
                $google_media->file_name =$file_upload_result['name'];
                $google_media->save();
                return [
                    'status'=>'success',
                    'message'=>'fileupload successful',
                    'data'=>[
                        'file_google_path'=>$file_upload_result['path'],
                        'file_size'=>$file_upload_result['size'],
                        'file_google_filename'=>$file_upload_result['name'],
                    ]
                ];
            }    
            return false;
        }catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getGoogleDriveImage($file_name){
         try{
            if($file_name==null){
                return '';
            }

            $google_media = GoogleMedia::where('file_name',$file_name)->first();
            if(!$google_media){
                return "https://hvl.probsoltech.com/public/uploads/profile/1678275604_hvl-logo.png";
            }
            $google_media = GoogleMedia::where('file_name',$file_name)->first();
            return "https://drive.google.com/thumbnail?id=".$google_media->media_path."&sz=w1000";
        }catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    /*
    public function test1 ($file_name){
        try{
            if($file_name==null){
                return '';
            }
            $google_media = GoogleMedia::where('file_name',$file_name)->first();
            if(!$google_media){
                // return "https://hvl.probsoltech.com/public/uploads/profile/1678275604_hvl-logo.png";
            }
            $google_drive = $this->getGoogleDriver($google_media->drive_id);
            // $file_upload_result = $google_drive->readStream($google_media->); 

            return "https://drive.google.com/thumbnail?id=".$google_media->media_path."&sz=w1000";
        }catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    */
    /*
    try{
        $db_google_client = GoogleUser::where('default_connect',1)->first();
        if(isset($file_param['file_name'])){
            $file_name = $file_param['file_name'];
        }else{
            $file_name = date('ymdhis_').$google_drive_file->getClientOriginalName();
        }            
        $google_drive = $this->getGoogleDriver( $db_google_client->id);
        $file_upload_result = $google_drive->put($file_name,file_get_contents($google_drive_file)); 
      
    }
    */
    public function AddSystemLog($param){
        $user = Auth::user();
        $activity_log = new SystemLog();
        $activity_log->module = $param['module'];
        $activity_log->action = $param['action'];
        $activity_log->action_by = $user->name;
        $activity_log->action_user_id = $user->id;
        $activity_log->user_understand_data = (isset($param['user_understand_data']))?json_encode($param['user_understand_data']):null;
        $activity_log->system_data = (isset($param['system_data']))?json_encode($param['system_data']):null;
        $activity_log->save();
    }
    public function getTotalTime($start,$end){
        $time1 = strtotime($start);
        $time2 = strtotime($end);
        return ($time2-$time1);
    }



   
   

}
