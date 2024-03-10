<?php

use App\Http\Controllers\LanguageController;
use Google\Client;
/*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register web routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | contains the "web" middleware group. Now create something great!
  |
 */
// Route::get('/', function () {
//     return view('home');
// })->middleware('auth');
Auth::routes();
//
Route::redirect('/', '/login');
// Route::redirect('/dashboard', '/dashboard');
Auth::routes(['register' => false]);
Route::get('/resetpassword', 'UserController@resetpassword')->name('resetpassword');
Route::post('/proccessemail', 'UserController@proccessemail')->name('proccessemail');
Route::get('/resetyourpassword/{id}', 'UserController@resetyourpassword')->name('resetyourpassword');
Route::post('/processyourpassword', 'UserController@processyourpassword')->name('processyourpassword');

//Chnaged by HV
Route::get('/dashboard/graph_emp_lead/{id}', 'DashboardController@graph_emp_lead')->name('dashboard.graph_emp_lead');
Route::get('/dashboard/graph_emp_revenue/{id}', 'DashboardController@graph_emp_revenue')->name('dashboard.graph_emp_revenue');
Route::get('/dashboard/graph_emp_total_customers/{id}', 'DashboardController@graph_emp_total_customers')->name('dashboard.graph_emp_total_customers');
Route::post('/dashboard/graph_emp_lead_filter', 'DashboardController@graph_emp_lead_filter')->name('dashboard.graph_emp_lead_filter');
Route::post('/dashboard/graph_filter', 'DashboardController@graph_filter')->name('dashboard.graph_filter');
/* chnage password */
Route::get('/change-password', [App\Http\Controllers\HomeController::class, 'changePassword'])->name('change-password');
Route::post('/change-password', [App\Http\Controllers\HomeController::class, 'updatePassword'])->name('update-password');

Route::group(['middleware' => 'auth'], function () {

    //    admin profile
    Route::get('/admin-profile-page', 'AdminProfileController@adminProfile')->name('admin-profile-page');
    Route::post('/admin-profile-update', 'AdminProfileController@adminProfileUpdate')->name('admin.profile.update');

//Chnaged by HV
    // Route::get('/', 'HomeController@index')->name('home');
    Route::redirect('/', '/dashboard');

    // Route::get('/', 'DashboardController@index')->name('dashboard.index');
    Route::get('/home', 'HomeController@index')->name('home');

    Route::get('/dashboard', 'DashboardController@index')->name('dashboard.index');
    Route::post('/dashboard', 'DashboardController@index')->name('dashboard.filter');
    // Route::get('/dashboard_update', 'DashboardController@index')->name('dashboard.index');
//chart
    Route::get('chart-line', 'ChartController@chartLine');
    Route::get('chart-line-ajax', 'ChartController@chartLineAjax');

//chart
    Route::resource('module', 'ModuleController');
    Route::resource('users', 'UserController');
    Route::resource('roles', 'RoleController');

    Route::get('roles/view/{id}', 'RoleController@view')->name('roles.view');
    Route::get('role/assign', 'AssignRoleController@create')->name('role.assign');
    Route::get('role/all_view', 'AssignRoleController@all_view')->name('role.all_view');
    Route::post('role/assign/store', 'AssignRoleController@store')->name('role.assign.store');
//create customer login system
    Route::get('customer_login_system', 'hvl\CustomerLoginSystem\CustomerLoginSystemCrud@index')->name('customer.login_system.index');
    Route::get('customer_login_system/create', 'hvl\CustomerLoginSystem\CustomerLoginSystemCrud@create')->name('customer.login_system.create');
    Route::post('customer_login_system/store', 'hvl\CustomerLoginSystem\CustomerLoginSystemCrud@store')->name('customer.login_system.store');
    Route::get('customer_login_system/{id}', 'hvl\CustomerLoginSystem\CustomerLoginSystemCrud@edit')->name('customer.login_system.edit');
    Route::post('customer_login_system/update', 'hvl\CustomerLoginSystem\CustomerLoginSystemCrud@update')->name('customer.login_system.update');
    Route::post('customer_login_system/delete', 'hvl\CustomerLoginSystem\CustomerLoginSystemCrud@removeData')->name('customer.login_system.delete');
    Route::post('customer_login_system/massdelete', 'hvl\CustomerLoginSystem\CustomerLoginSystemCrud@massRemove')->name('customer.login_system.massdelete');
    Route::get('customer_login_system/show/{id}', 'hvl\CustomerLoginSystem\CustomerLoginSystemCrud@show')->name('customer.login_system.show');

    Route::group(['prefix' => 'modules/module/'], function () {
// Save filters
        Route::post('savefilter/store', 'SaveFilterController@store')->name('savefilter.store');
        Route::post('savefilter/update/', 'SaveFilterController@update')->name('savefilter.update');
        Route::delete('savefilter/destroy', 'SaveFilterController@destroy')->name('savefilter.destroy');
// Mail
        Route::post('mail/sendcsv', 'MailController@sendCSV')->name('mail.sendcsv');
        Route::post('mail/sendcsv1', 'MailController@sendCSV1')->name('mail.sendcsv1');
        Route::post('mail/sendaudit', 'MailController@sendaudit')->name('mail.sendaudit');
// Employees
        Route::post('employees/store', 'EmployeeController@employeeStore')->name('employees.store');
        Route::put('employees/update', 'EmployeeController@employeeUpdate')->name('employees.update');
// Departments
        Route::post('departments/store', 'DepartmentController@departmentStore')->name('departments.store');
        Route::put('departments/update', 'DepartmentController@departmentUpdate')->name('departments.update');
// Team
        Route::post('teams/store', 'TeamController@teamStore')->name('teams.store');
        Route::put('teams/update', 'TeamController@teamUpdate')->name('teams.update');
// Designation
        Route::post('designations/store', 'DesignationController@designationStore')->name('designations.store');
        Route::put('designations/update', 'DesignationController@designationUpdate')->name('designations.update');
// Lead
        // Route::post('lead/store', 'LeadController@leadStore')->name('lead.store');
        // Route::put('lead/update', 'LeadController@leadUpdate')->name('lead.update');
//        route::get('/holiday_leave/{id}/{date}', 'hrms\LeaveRequestController@holiday_leave')->name('holiday.leave');
        route::get('/lead/{lead_id}/{date}', 'LeadController@leadsStatus')->name('leads.status');
// Modules
        Route::get('{name}', 'ModuleCRUDController@index')->name('modules.module');
        Route::get('{name}/create', 'ModuleCRUDController@create')->name('modules.module.create');
        Route::post('store', 'ModuleCRUDController@store')->name('modules.module.store');
        Route::delete('{name}/{id}', 'ModuleCRUDController@destroy')->name('modules.module.destroy');
        Route::get('{name}/{id}', 'ModuleCRUDController@show')->name('modules.module.show');
        Route::get('{name}/{id}/edit', 'ModuleCRUDController@edit')->name('modules.module.edit');
        Route::put('update', 'ModuleCRUDController@update')->name('modules.module.update');
        Route::post('massdestroy', 'ModuleCRUDController@massDestroy')->name('modules.module.massdestroy');
    });
//--------------------------------------------------------------------------------------
// User profile Route
    // User profile Route
//    Route::resource('user-profile-page', 'UserController');
    Route::get('/user-profile-page', 'UserProfileController@userProfile')->name('user-profile-page');
    Route::get('/profile-image', 'UserProfileController@userProfileImage')->name('profile-image');
    Route::post('/ajax_upload/action', 'UserProfileController@action')->name('ajaxupload.action');
    Route::get('/user-profile/show_employee/{id}', 'UserProfileController@show_employee')->name('user-profile.show_employee');
//     Route::get('{name}/{id}', 'ModuleCRUDController@show')->name('modules.module.show');
// Authentication Route
    Route::get('/user-login', 'AuthenticationController@userLogin');
    Route::get('/user-register', 'AuthenticationController@userRegister');
    Route::get('/user-forgot-password', 'AuthenticationController@forgotPassword');
    Route::get('/user-lock-screen', 'AuthenticationController@lockScreen');
    Route::get('/user-logout', 'AuthenticationController@userlogout')->name('userlogout');
// Misc Route
    Route::get('/page-404', 'MiscController@page404');
    Route::get('/page-maintenance', 'MiscController@maintenancePage');
    Route::get('/page-500', 'MiscController@page500');
// Data Table Route
    Route::get('/table-data-table', 'DataTableController@dataTable');
// Charts Route
    Route::get('/charts-chartjs', 'ChartController@chartJs');
    Route::get('/charts-chartist', 'ChartController@chartist');
    Route::get('/charts-sparklines', 'ChartController@sparklines');
// locale route
    Route::get('lang/{locale}', [LanguageController::class, 'swap']);
    /*     * **********************************Attendance END************************** */
    Route::get('/hrms/country/', 'hrms\CountryController@index')->name('hrms.country');
    Route::get('/hrms/country/create', 'hrms\CountryController@create')->name('hrms.country.create');
    Route::get('/hrms/country/getdata', 'hrms\CountryController@getdata')->name('hrms.country.getdata');
    Route::get('/hrms/country/edit/{id}', 'hrms\CountryController@edit')->name('hrms.country.edit');
    Route::post('/hrms/country/update/{id}', 'hrms\CountryController@update')->name('hrms.country.update');
    Route::post('/hrms/country/store', 'hrms\CountryController@store')->name('hrms.country.store');
    Route::get('/hrms/country/delete', 'hrms\CountryController@delete')->name('hrms.country.delete');
    Route::get('/hrms/country/multidelete', 'hrms\CountryController@multidelete')->name('hrms.country.multidelete');
    Route::get('/hrms/country/getcountrycode', 'hrms\CountryController@getcountrycode')->name('hrms.country.getcountrycode');
    Route::get('/hrms/country/validname', 'hrms\CountryController@validname')->name('hrms.country.validname');
    Route::get('/hrms/country/editvalidname', 'hrms\CountryController@editvalidname')->name('hrms.country.editvalidname');

    Route::get('/state/', 'hrms\StateController@index')->name('state.index');
    Route::get('/state/create', 'hrms\StateController@create')->name('state.create');
    Route::post('/state/store', 'hrms\StateController@store')->name('state.store');
    Route::post('/state/update/{id}', 'hrms\StateController@update')->name('state.update');
    Route::get('/state/edit/{id}', 'hrms\StateController@edit')->name('state.edit');
    Route::get('/state/getdata', 'hrms\StateController@getdata')->name('state.getdata');
    Route::get('/state/validname', 'hrms\StateController@validname')->name('state.validname');
    Route::get('/state/editvalidname', 'hrms\StateController@editvalidname')->name('state.editvalidname');
    Route::get('/state/delete', 'hrms\StateController@delete')->name('state.delete');
    Route::get('/state/multidelete', 'hrms\StateController@multidelete')->name('state.multidelete');

    Route::get('/city', 'hrms\CityController@index')->name('city.index');
    Route::get('/city/create', 'hrms\CityController@create')->name('city.create');
    Route::post('/city/store', 'hrms\CityController@store')->name('city.store');
    Route::post('/city/update/{id}', 'hrms\CityController@update')->name('city.update');
    Route::get('/city/edit/{id}', 'hrms\CityController@edit')->name('city.edit');
    // Route::get('/city/delete/{id}', 'hrms\CityController@delete')->name('city.delete');
    Route::get('/city/delete', 'hrms\CityController@delete')->name('city.delete');
    Route::get('/city/multidelete', 'hrms\CityController@multidelete')->name('city.multidelete');
    Route::get('/city/validname', 'hrms\CityController@validname')->name('city.validname');
    Route::get('/city/editvalidname', 'hrms\CityController@editvalidname')->name('city.editvalidname');
    Route::get('/city/getdata', 'hrms\CityController@getdata')->name('city.getdata');
    Route::get('/city/getstate', 'hrms\CityController@getstate')->name('city.getstate');
    Route::get('/city/getCity', 'hrms\CityController@getCity')->name('city.getCity');
//Theme Customizer
    Route::post('/customizerdefault', 'ColorPickerController@customizerdefault')->name('customizerdefault');
    Route::get('/getcustomizerdata', 'ColorPickerController@getcustomizerdata')->name('getcustomizerdata');
    Route::post('/storecustomizer', 'ColorPickerController@storecustomizer')->name('storecustomizer');
    //HVL Activity
//  Lead Master routes
    Route::get('/lead-master', 'hvl\leadmaster\LeadMasterController@index')->name('lead.index');
    Route::post('/lead-master', 'hvl\leadmaster\LeadMasterController@index')->name('lead.index.filter');
    Route::get('/lead-master/create', 'hvl\leadmaster\LeadMasterController@create')->name('lead.create');
    Route::post('/lead-master/store', 'hvl\leadmaster\LeadMasterController@store')->name('lead.store');
    Route::get('/lead-master/edit/{id}', 'hvl\leadmaster\LeadMasterController@edit')->name('lead.edit');
    Route::post('/lead-master/update/{id}', 'hvl\leadmaster\LeadMasterController@update')->name('lead.update');
    Route::get('/lead-master/show/{id}', 'hvl\leadmaster\LeadMasterController@show')->name('lead.show');
    Route::get('/lead-master/delete', 'hvl\leadmaster\LeadMasterController@removedata')->name('lead.delete');
    Route::post('/lead-master/massdelete', 'hvl\leadmaster\LeadMasterController@massremove')->name('lead.massdelete');
    Route::post('/lead-master/get-date-lead', 'hvl\leadmaster\LeadMasterController@date_wise_lead')->name('lead.date_wise');
    Route::post('/lead-master/import_leads', 'hvl\leadmaster\LeadMasterController@import_lead')->name('lead-import-excel');
    Route::post('/lead-master/proposal/image', 'hvl\leadmaster\LeadMasterController@saveProposal')->name('lead.proposal.save');
    Route::post('/lead-master/download_leads', 'hvl\leadmaster\LeadMasterController@getDownloadLeads')->name('lead.download_lead');
    Route::post('/lead-master/sheet/mail/', 'hvl\leadmaster\LeadMasterController@sendLeadExcelSheet')->name('lead.mail_sheet');

//  Customer Master Routes
    Route::get('/customer-master/approve/{id}', 'hvl\leadmaster\LeadMasterController@add_toCustomer')->name('lead.approve');
    Route::post('/customer-master/updateCustomer/{id}', 'hvl\leadmaster\LeadMasterController@update_toCustomer')->name('customer.approveUpdate');
    Route::get(
            '/customer-master',
            'hvl\customermaster\CustomerMasterController@index'
    )->name('customer.index');
    Route::post(
            '/customer-master',
            'hvl\customermaster\CustomerMasterController@index'
    )->name('customer.index');

    Route::get('/customer-master/create', 'hvl\customermaster\CustomerMasterController@create')->name('customer.create');
    Route::post('/customer-master/store', 'hvl\customermaster\CustomerMasterController@store')->name('customer.store');
    Route::get('/customer-master/edit/{id}', 'hvl\customermaster\CustomerMasterController@edit')->name('customer.edit');
    Route::post('/customer-master/update/{id}', 'hvl\customermaster\CustomerMasterController@update')->name('customer.update');
    Route::get('/customer-master/delete', 'hvl\customermaster\CustomerMasterController@removedata')->name('customer.delete');
    Route::post('/customer-master/massdelete', 'hvl\customermaster\CustomerMasterController@massremove')->name('customer.massdelete');
    Route::post('/customer-master/contract', 'hvl\customermaster\CustomerMasterController@add_contract')->name('customer.contract');
    Route::post('/customer-master/update-contract', 'hvl\customermaster\CustomerMasterController@edit_contract')->name('customer.edit-contract');
    Route::get('/customer-master/show/{id}', 'hvl\customermaster\CustomerMasterController@show')->name('customer.view');
    Route::get('/customer-master/delete-contract', 'hvl\customermaster\CustomerMasterController@delete_contract')->name('customer.contract_delete');
    Route::get('/customer-master/view-activity/{id}', 'hvl\customermaster\CustomerMasterController@view_activity')->name('customer.view-activity');
    Route::get('/customer-master/get-branch-customer', 'hvl\customermaster\CustomerMasterController@get_customer')->name('customer.get_customer');
    Route::get('/customer-master/delete-customer', 'hvl\customermaster\CustomerMasterController@delete_customer')->name('delete-customer');
    Route::post('/customer-master/bulk-remove-customer', 'hvl\customermaster\CustomerMasterController@bulk_remove_customer')->name('bulk-remove-customer');
    Route::get('/customer-master/customer-report', 'hvl\customermaster\CustomerMasterController@customer_report')->name('customer.customer-report');
    Route::post('/customer-master/download_customer', 'hvl\customermaster\CustomerMasterController@getDownloadCustomers')->name('customer.download_customer');
    Route::post('/customer-master/sheet/mail/', 'hvl\customermaster\CustomerMasterController@sendCustomerExcelSheet')->name('customer.mail_sheet');

    Route::post('/activity-master/jobcards_store_ajax_base', 'hvl\activitymaster\ActivityMasterController@jobcards_store_ajax_base')->name('activity.jobcards_store_ajax_base');

    Route::post('/activity-master/HVI_ajax_store', 'hvl\activitymaster\ActivityMasterController@HVI_ajax_store')->name('activity.HVI_ajax_store');
    Route::get('/activity-master', 'hvl\activitymaster\ActivityMasterController@index')->name('activity.index');
    Route::post('/activity-master', 'hvl\activitymaster\ActivityMasterController@index')->name('activity.index.filter');

    Route::post('/activity-master/service_report_image', 'hvl\activitymaster\ActivityMasterServiceController@saveImage')->name('activity.service.image');
    Route::post('/activity-master/service_report/save', 'hvl\activitymaster\ActivityMasterServiceController@saveAndUpdateForm')->name('activity.service.save');
    Route::get('/activity-master/service_report/{activity_id}', 'hvl\activitymaster\ActivityMasterServiceController@getActivityServieForm')->name('activity.service.form_data');
    Route::get('/activity-master/service_report_default_infomation/{activity_id}', 'hvl\activitymaster\ActivityMasterServiceController@getActivityServieFormInfo')->name('activity.service.form_data');
    Route::post('/activity-master/service_report/move', 'hvl\activitymaster\ActivityMasterServiceController@moveServiceReport')->name('activity.service.save');
    
    Route::post('/activity-master/download_activity', 'hvl\activitymaster\ActivityMasterController@getDownloadActivity')->name('activity.download_excel');
    Route::post('/activity-master/sheet/mail/', 'hvl\activitymaster\ActivityMasterController@sendActivityExcelSheet')->name('activity.mail_sheet');

    // relaince form
    Route::post('/activity-master/relaince_service_report/save', 'hvl\activitymaster\ActivityMasterServiceController@saveAndUpdateRelainceServiceForm')->name('activity.relaince_service.save');
    Route::get('/activity-master/relaince_service_report/{activity_id}', 'hvl\activitymaster\ActivityMasterServiceController@getActivityRelainceServiceForm')->name('activity.relaince_service.form_data');
    // end relaince form data
    
    
    Route::get('/activity-master/getCustomerReport/', 'hvl\activitymaster\ActivityMasterController@getCustomerReport')->name('activity.getCustomerReport');
    Route::post('/activity-master/activity-master/activity_store', 'hvl\activitymaster\ActivityMasterController@activity_store')->name('activity.activity_store');
    Route::get('/activity-master/hvi_hisrty_delete', 'hvl\activitymaster\ActivityMasterController@hvi_hisrty_delete')->name('activity.hvi_hisrty_delete');
    Route::get('/activity-master/edit_activity/{id}', 'hvl\activitymaster\ActivityMasterController@edit_activity')->name('activity.edit_activity');
    Route::get('/activity-master/show_activity/{id}', 'hvl\activitymaster\ActivityMasterController@show_activity')->name('activity.show_activity');
    Route::post('/activity-master/update_activity/{id}', 'hvl\activitymaster\ActivityMasterController@update_activity')->name('activity.update_activity');
    Route::get('/activity-master/create', 'hvl\activitymaster\ActivityMasterController@create_activity')->name('activity.create_activity');
    Route::post('/activity-master/activity_superadmin_store', 'hvl\activitymaster\ActivityMasterController@activity_superadmin_store')->name('activity.activity_superadmin_store');
    Route::post('/activity-master/jobcards_store', 'hvl\activitymaster\ActivityMasterController@jobcards_store')->name('activity.addbefore_pic');
    Route::post('/activity-master/audit_store', 'hvl\activitymaster\ActivityMasterController@audit_store')->name('activity.auditreport');
    Route::post('/activity-master/massdelete', 'hvl\activitymaster\ActivityMasterController@massdelete')->name('activity.massdelete');
    Route::get('/activity-master/delete_image', 'hvl\activitymaster\ActivityMasterController@delete_image')->name('activity.image_delete');
    Route::get('/activity/getcustomer', 'hvl\activitymaster\ActivityMasterController@get_customer')->name('activity.get_customer');
    Route::post('/activity-master/get_date_data', 'hvl\activitymaster\ActivityMasterController@get_date_data')->name('activity.get_date_data');
    Route::get('/activity-master/get-branch-customer', 'hvl\activitymaster\ActivityMasterController@get_index_customer');
    Route::post('/activity-master/get-branch-customer', 'hvl\activitymaster\ActivityMasterController@get_index_customer_details')->name('get_customer_index_details');
//Route::get('/activity-master/delete_after', 'hvl\activitymaster\ActivityMasterController@delete_after_image')->name('activity.afterimage_delete');
    Route::get('/activity-master/get-customer-status', 'hvl\activitymaster\ActivityMasterController@get_status')->name('get_status');
//routes to impot activity data using excel
    Route::get('/import-activity', 'hvl\activitymaster\ActivityMasterController@import_activity_view');
    Route::post('/customer-master/import_customers', 'hvl\customermaster\CustomerMasterController@import_customer')->name('customer.import-excel');
    Route::post('/customer-master/export_customers', 'hvl\customermaster\CustomerMasterController@export_all_customer')->name('customer.export-all');
    Route::post('/activity-master/import_activity', 'hvl\activitymaster\ActivityMasterController@import_activity')->name('activity-import-excel');
    Route::post('/activity-master/export_activity', 'hvl\activitymaster\ActivityMasterController@export_all_activity')->name('activity.export-all');
    Route::get('/activity-master/download_activity_report/{activity_id}',
                    'hvl\activitymaster\ActivityMasterServiceController@downloadReportPdf')
            ->name('admin.activity.download_activity_report');

    //billing system
    Route::prefix('employee_billing')->group(function () {
        Route::get('/', [
            'as' => 'admin.billing.index',
            'uses' => 'hvl\Employee\BillingController@index',
                // 'middleware' => 'can:admin.payment.index'
        ]);

        Route::post('/', [
            'as' => 'admin.billing.filters',
            'uses' => 'hvl\Employee\BillingController@filters',
                // 'middleware' => 'can:admin.payment.filters'
        ]);
    });

    Route::get('/branch-customer', 'hvl\BranchCustomerController@index')->name('branch-customer');
    Route::get('/branch-customer/create', 'hvl\BranchCustomerController@create')->name('branch-customer.create');
    Route::post('/branch-customer/store', 'hvl\BranchCustomerController@store')->name('branch-customer.store');
    Route::get('/branch-customer/edit/{id}', 'hvl\BranchCustomerController@edit')->name('branch-customer.edit');
    Route::post('/branch-customer/update/{id}', 'hvl\BranchCustomerController@update')->name('branch-customer.update');
    Route::get('/branch-customer/delete', 'hvl\BranchCustomerController@delete')->name('branch-customer.delete');
    Route::get('/branch-customer/getbranch', 'hvl\BranchCustomerController@get_branch');
    Route::post('/branch-customer/getbranchcustomer', 'hvl\BranchCustomerController@branch_customer');
    Route::get('/customer/dashboad', 'hvl\CustomerLoginSystem\CustomerDashboard@getDashboard')->name('customer.dashboad.index')->middleware('can:Access Customer Dashboad');
    Route::post('/customer/dashboad/sendmail/activitystatus', 'MailController@sendCustomerActivityStatus')->name('customer.mail.activitystatus')->middleware('can:Access Customer Dashboad');
    Route::get('/customer/service/history/{customer_id}', 'hvl\customermaster\CustomerActivityHistoryController@index')->name('customer.services.history');
    Route::get('/customer/audit/{customer_id}', [
        'as' => 'admin.customer.audit_list',
        'uses' => 'hvl\AuditManagement\AuditController@getCustomerAudit',
            // 'middleware' => 'can:audit dashboard'
    ]);
    Route::post('/customer/audit/{customer_id}', [
        'as' => 'admin.customer.audit_list',
        'uses' => 'hvl\AuditManagement\AuditController@getCustomerAudit',
    ]);
    Route::post('/customer/send_audit_mail', [
        'as' => 'admin.customer.send_customer_audit',
        'uses' => 'hvl\AuditManagement\AuditGenerateController@sendCustomerAuditReport',
        'middleware' => 'can:audit send_mail'
    ]);

    Route::post('/customer/service/batchupdate/batchsupdate/{batch}', 'hvl\customermaster\CustomerActivityHistoryController@batchsupdate')->name('customer.services.batchsupdate');
    Route::get('/customer/service/batchupdate/{batch_id}/{customer_id}/{batchname}/{frequency}/{total_activities}', 'hvl\customermaster\CustomerActivityHistoryController@batchupdate')->name('customer.services.batchupdate');

    //for bulk upload made by surani ajit
    // for customer bulkupload
    Route::get('/admin/customermaster/bulkupload', 'hvl\customermaster\CustomerBulkUploadController@index')->name('admin.customermaster_bulkupload.index')->middleware('can:Access Customer Bulkupload');
    Route::post('/admin/customermaster/bulkupload', 'hvl\customermaster\CustomerBulkUploadController@saveCustomerManagementBulkUpload')->name('admin.customermaster_bulkupload.save')->middleware('can:Access Customer Bulkupload');

    // for employee bulkupload
    Route::get('/admin/employee_master/bulkupload', 'hvl\Employee\EmployeesBulkUploadController@index')->name('admin.employeemaster_bulkupload.index')->middleware('can:Access Employee Bulkupload');
    Route::post('/admin/employee_master/bulkupload', 'hvl\Employee\EmployeesBulkUploadController@saveEmployeeManagementBulkUpload')->name('admin.employeemaster_bulkupload.save')->middleware('can:Access Employee Bulkupload');

    // for leadmaster bulkupload
    Route::get('/admin/leadmaster/bulk_upload', 'hvl\leadmaster\LeadBulkUploadController@index')->name('admin.leadmaster_bulkupload.index')->middleware('can:Access Lead Bulkupload');
    Route::post('/admin/leadmaster/bulk_upload', 'hvl\leadmaster\LeadBulkUploadController@saveLeadManagementBulkUpload')->name('admin.leadmaster_bulkupload.save')->middleware('can:Access Lead Bulkupload');

    // for role bulkuploadre
    Route::get('/admin/role/bulkupload', 'hvl\Role\RoleBulkUploadController@index')->name('admin.role_bulkupload.index')->middleware('can:Access Role Bulkupload');
    Route::post('/admin/role/bulkupload', 'hvl\Role\RoleBulkUploadController@saveRoleManagementBulkUpload')->name('admin.role_bulkupload.save')->middleware('can:Access Role Bulkupload');
    //end bluk upload
    Route::get('/admin/activity/bulk_update_upload', 'hvl\activitymaster\ActivityBulkUpdateController@index')->name('admin.activity_bulk_update.index');//->middleware('can:Access Role Bulkupload');
    Route::post('/admin/activity/bulk_update_upload', 'hvl\activitymaster\ActivityBulkUpdateController@updateActivityStartdateEnddate')->name('admin.activity_bulk_update.save');//->middleware('can:Access Role Bulkupload');
    //end bluk upload
    
});

Route::prefix('customer_audit')->middleware('auth')->group(function () {
    Route::get('/dashboard', [
        'as' => 'admin.audit.dashboard',
        'uses' => 'hvl\AuditManagement\AuditController@dashboard',
        'middleware' => 'can:audit dashboard'
    ]);
    Route::post('/dashboard', [
        'as' => 'admin.audit.dashboard',
        'uses' => 'hvl\AuditManagement\AuditController@dashboard',
        'middleware' => 'can:audit dashboard'
    ]);
    Route::post('/customer/list', [
        'as' => 'admin.audit.getBranchCustomers',
        'uses' => 'hvl\AuditManagement\AuditController@getBranchCustomers',
    ]);
    Route::get('/', [
        'as' => 'admin.audit.index',
        'uses' => 'hvl\AuditManagement\AuditController@index',
        'middleware' => 'can:index audit'
    ]);

    Route::post('/', [
        'as' => 'admin.audit.filter',
        'uses' => 'hvl\AuditManagement\AuditController@index',
        'middleware' => 'can:index audit'
    ]);

    Route::get('/create', [
        'as' => 'admin.audit.create',
        'uses' => 'hvl\AuditManagement\AuditController@create',
        'middleware' => 'can:create audit'
    ]);

    Route::post('/save', [
        'as' => 'admin.audit.save',
        'uses' => 'hvl\AuditManagement\AuditController@store',
        'middleware' => 'can:create audit'
    ]);

    Route::get('/edit/{id}', [
        'as' => 'admin.audit.edit',
        'uses' => 'hvl\AuditManagement\AuditController@edit',
        'middleware' => 'can:edit audit'
    ]);

    Route::get('/view/{id}', [
        'as' => 'admin.audit.view',
        'uses' => 'hvl\AuditManagement\AuditController@show',
        'middleware' => 'can:read audit'
    ]);

    Route::post('/update/{id}', [
        'as' => 'admin.audit.update',
        'uses' => 'hvl\AuditManagement\AuditController@update',
        'middleware' => 'can:edit audit'
    ]);

    Route::get('/delete', [
        'as' => 'admin.audit.delete',
        'uses' => 'hvl\AuditManagement\AuditController@destroy',
        'middleware' => 'can:delete audit'
    ]);
    Route::post('/massdelete', [
        'as' => 'admin.audit.massdelete',
        'uses' => 'hvl\AuditManagement\AuditController@destroyMultiple',
        'middleware' => 'can:delete audit'
    ]);

    Route::prefix('/generate/{audit_id}')->group(function () {
        Route::get('/', [
            'as' => 'admin.audit_generate.index',
            'uses' => 'hvl\AuditManagement\AuditGenerateController@index',
            'middleware' => 'can:generate audit'
        ]);
        Route::get('/pdf', [
            'as' => 'admin.audit_generate.pdf',
            'uses' => 'hvl\AuditManagement\AuditGenerateController@getPrintPdf',
            'middleware' => 'can:generate audit'
        ]);
        Route::post('/save_signature', [
            'as' => 'admin.audit_generate.save_sign',
            'uses' => 'hvl\AuditManagement\AuditGenerateController@saveSignature',
            'middleware' => 'can:take audit generate signature'
        ]);

        Route::post('/save', [
            'as' => 'admin.audit_generate.save',
            'uses' => 'hvl\AuditManagement\AuditGenerateController@store',
            'middleware' => 'can:create_audit_generate'
        ]);
        Route::get('audit_detail/edit/{generate_id}', [
            'as' => 'admin.audit_generate.edit',
            'uses' => 'hvl\AuditManagement\AuditGenerateController@edit',
            'middleware' => 'can:edit audit_generate'
        ]);
        Route::post('/update', [
            'as' => 'admin.audit_generate.update',
            'uses' => 'hvl\AuditManagement\AuditGenerateController@update',
            'middleware' => 'can:edit audit_generate'
        ]);
        Route::post('/delete/{generate_id}', [
            'as' => 'admin.audit_generate.delete',
            'uses' => 'hvl\AuditManagement\AuditGenerateController@destroy',
            'middleware' => 'can:delete audit_generate'
        ]);
    });
    Route::get('/audit_generate/{audit_generate_id}/images', [
        'as' => 'admin.audit_generate.image_list',
        'uses' => 'hvl\AuditManagement\AuditGenerateController@getGalleryImage',
        'middleware' => 'can:edit audit_generate'
    ]);
    Route::get('/audit_generate/images/delete/{id}', [
        'as' => 'admin.audit_generate.image_delete',
        'uses' => 'hvl\AuditManagement\AuditGenerateController@galleryImageDelete',
        'middleware' => 'can:edit audit_generate'
    ]);
    Route::post('/audit_generate/gallery/images/temp_delete', [
        'as' => 'admin.audit_generate.temp_delete',
        'uses' => 'hvl\AuditManagement\AuditGenerateController@tempDelete',
            // 'middleware' => 'can:edit audit_generate'
    ]);
    Route::post('/audit_generate/gallery/images/save', [
        'as' => 'admin.audit_generate.image_save',
        'uses' => 'hvl\AuditManagement\AuditGenerateController@imageSave',
        'middleware' => 'can:edit audit_generate'
    ]);
});

/* expense 03-10-2023 upload by Hitesh */
Route::get('/expense/', 'expense\ExpenseMasterController@index')->name('expense');
Route::get('/expense/index/{id}', 'expense\ExpenseMasterController@index')->name('expense.index');
Route::get('/expense/create', 'expense\ExpenseMasterController@create')->name('expense.create');
Route::post('/expense/store', 'expense\ExpenseMasterController@store')->name('expense.store');
Route::post('/expense/edit', 'expense\ExpenseMasterController@edit')->name('expense.edit');
Route::get('/expense/edit/{id}', 'expense\ExpenseMasterController@edit')->name('expense.edit');
Route::post('/expense/update/{id}', 'expense\ExpenseMasterController@update')->name('expense.update');
Route::get('/expense/expense_settings/', 'expense\ExpenseMasterController@expense_settings_view')->name('expense.expense_settings');
Route::post('/expense/expense_settings_update/{id}', 'expense\ExpenseMasterController@expense_settings_update')->name('expense.expense_settings_update');
Route::get('/expense/view/{id}', 'expense\ExpenseMasterController@view')->name('expense.view');
Route::get('/expense/view_expances/{id}', 'expense\ExpenseMasterController@view_expances')->name('expense.view_expances');
Route::get('/expense/getsubcategory', 'expense\ExpenseMasterController@getSubCategory')->name('expense.getsubcategory');
Route::get('/expense/getvehicalRat', 'expense\ExpenseMasterController@getvehicalRat')->name('expense.getvehicalRat');
Route::get('/expense/mass_move_save', 'expense\ExpenseMasterController@mass_move_save')->name('expense.mass_move_save');
Route::get('/expense/search', 'expense\ExpenseMasterController@search')->name('expense.search');
Route::get('/expense/search_details/{id}', 'expense\ExpenseMasterController@search_details')->name('expense.search_details');
Route::get('/expense/expense_master/{id}', 'expense\ExpenseMasterController@expense_master')->name('expense.expense_master');
Route::post('/expense/updateByAccount/{id}', 'expense\ExpenseMasterController@updateByAccount')->name('expense.updateByAccount');
Route::post('/expense/updateByManager/{id}', 'expense\ExpenseMasterController@updateByManager')->name('expense.updateByManager');
Route::post('/expense/multi_updateByManager/{id}', 'expense\ExpenseMasterController@multi_updateByManager')->name('expense.multi_updateByManager');
Route::post('/expense/multi_updateByAcount/{id}', 'expense\ExpenseMasterController@multi_updateByAcount')->name('expense.multi_updateByAcount');
Route::get('/expense/move_save/', 'expense\ExpenseMasterController@move_save')->name('expense.move_save');
Route::get('/expense/massremove', 'expense\ExpenseMasterController@massremove')->name('expense.massremove');
Route::get('/expense/removedata', 'expense\ExpenseMasterController@destroy')->name('expense.removedata');
Route::get('/expense/remove_document', 'expense\ExpenseMasterController@expense_document_delete')->name('expense.remove_document');

Route::get('/expense_document/{id}', 'expense\ExpenseMasterController@expense_document')->name('expense.expense_document');


//expense_report 20-11-2023
Route::get('/expense_report/', 'expense\ExpenseReportController@index')->name('expense_report');
Route::get('/expense_report/search_details/', 'expense\ExpenseReportController@search_details')->name('expense_report.search_details');
Route::get('/expense_report/search_by_employee/{id}', 'expense\ExpenseReportController@search_by_employee')->name('expense_report.search_by_employee');
//expence history 04-02-2023
Route::get('/report_history_index', 'expense\ExpenseReportController@report_history_index')->name('expense_history.report_history_index');
Route::get('/report_history_details/{id}', 'expense\ExpenseReportController@report_history_details')->name('expense_history.report_history_details');
Route::get('/report_history_by_report_details/{id}/{report_name}', 'expense\ExpenseReportController@report_history_by_report_details')->name('expense_history.report_history_by_report_details');
Route::get('/report_history_search_step_1/', 'expense\ExpenseReportController@report_history_search_step_1')->name('expense_history.report_history_search_step_1');
Route::get('/report_history_search_step_2/', 'expense\ExpenseReportController@report_history_search_step_2')->name('expense_history.report_history_search_step_2');
Route::get('/report_history_search_step_3/', 'expense\ExpenseReportController@report_history_search_step_3')->name('expense_history.report_history_search_step_3');
Route::post('/report_history_download', 'expense\ExpenseReportController@report_history_download')->name('expense_history.report_history_download');

//expance_account
Route::get('/expance_action/', 'expense\ExpenseMasterController@expance_action')->name('expance_action');
Route::get('/expance_action/expance_action_search/', 'expense\ExpenseMasterController@expance_action_search')->name('expance_action.expance_action_search');

/* expense */
Route::get('/account/', 'expense\AccountMasterController@index')->name('account');
Route::get('/account/create', 'expense\AccountMasterController@create')->name('account.create');
Route::post('/account/store', 'expense\AccountMasterController@store')->name('account.store');
Route::get('/account/edit/{id}', 'expense\AccountMasterController@edit')->name('account.edit');
Route::post('/account/update/{id}', 'expense\AccountMasterController@update')->name('account.update');
Route::get('/account/delete', 'expense\AccountMasterController@delete')->name('account.delete');
Route::get('/account/view/{id}', 'expense\AccountMasterController@view_allExpanceActions')->name('account.view');



/* category */
Route::get('/category/', 'expense\CategoryController@index')->name('category');
Route::get('/category/create', 'expense\CategoryController@create')->name('category.create');
Route::get('/category/getdata', 'expense\CategoryController@getdata')->name('category.getdata');
Route::get('/category/edit/{id}', 'expense\CategoryController@edit')->name('category.edit');
Route::post('category/update/{id}', 'expense\CategoryController@update')->name('category.update');
Route::post('category/store', 'expense\CategoryController@store')->name('category.store');
Route::get('/category/delete', 'expense\CategoryController@delete')->name('category.delete');
Route::get('/category/multidelete', 'expense\CategoryController@multidelete')->name('category.multidelete');
Route::get('/category/getcategorycode', 'expense\CategoryController@getcategorycode')->name('category.getcategorycode');
Route::get('/category/validname', 'expense\CategoryController@validname')->name('category.validname');
Route::get('/category/editvalidname', 'expense\CategoryController@editvalidname')->name('category.editvalidname');
/* category */


/* subsubcategory */
Route::get('/subcategory/', 'expense\SubCategoriesController@index')->name('subcategory');
Route::get('/subcategory/create', 'expense\SubCategoriesController@create')->name('subcategory.create');
Route::get('/subcategory/getdata', 'expense\SubCategoriesController@getdata')->name('subcategory.getdata');
Route::get('/subcategory/edit/{id}', 'expense\SubCategoriesController@edit')->name('subcategory.edit');
Route::post('subcategory/update/{id}', 'expense\SubCategoriesController@update')->name('subcategory.update');
Route::post('subcategory/store', 'expense\SubCategoriesController@store')->name('subcategory.store');
Route::get('/subcategory/delete', 'expense\SubCategoriesController@delete')->name('subcategory.delete');
Route::get('/subcategory/multidelete', 'expense\SubCategoriesController@multidelete')->name('subcategory.multidelete');
Route::get('/subcategory/getsubcategorycode', 'expense\SubCategoriesController@getsubcategorycode')->name('subcategory.getsubcategorycode');
Route::get('/subcategory/validname', 'expense\SubCategoriesController@validname')->name('subcategory.validname');
Route::get('/subcategory/validname_', 'expense\SubCategoriesController@validname_')->name('subcategory.validname_');
Route::get('/subcategory/editvalidname', 'expense\SubCategoriesController@editvalidname')->name('subcategory.editvalidname');
/* subsubcategory */

/* * ********Email Template END******* */

/* * ******** testing ******* */

Route::get('/drive', function () {
    $client = new Client();
    $client->setClientId('261604861415-ski3gmvbclgmd9sb5pikgnrp7bl5tmv2.apps.googleusercontent.com');
    $client->setClientSecret('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');
    $client->setRedirectUri('https://hvl.probsoltech.com/google-drive/callback');
    $client->setScopes([
        'https://www.googleapis.com/auth/drive',
        'https://www.googleapis.com/auth/drive.file',
    ]);
    $url = $client->createAuthUrl();
    return redirect($url);
});

Route::get('/google-drive/callback', function () {
    // return request('code');
    $client = new Client();
    $client->setClientId('261604861415-ski3gmvbclgmd9sb5pikgnrp7bl5tmv2.apps.googleusercontent.com');
    $client->setClientSecret('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');
    $client->setRedirectUri('https://hvl.probsoltech.com/google-drive/callback');
    $code = request('code');
    $access_token = $client->fetchAccessTokenWithAuthCode($code);
    return $access_token;
});

Route::get('upload_google', function () {
    $client = new Client();
    $access_token = 'ya29.a0AfB_byBX4n0rwLYiLyWoqiSxBkkTbINm_oN5xyl8StwxRBmCDMNcdOyntv0K4IkjEoHDA-nOhJpDk1NwTaSk9DB-TPMWbhWWlDZGTs6l3QfrN6vQ7ZvUEYfjEV7D7Ar4s1zY6ibczXs2WMuEoX_ncqluokJJR37vFZwIaCgYKAV0SARESFQHGX2Miyp--ZA4yq68UpdRXGZFQRw0171';

    $client->setAccessToken($access_token);
    $service = new Google\Service\Drive($client);
    $file = new Google\Service\Drive\DriveFile();

    DEFINE("TESTFILE", 'testfile-small.txt');
    if (!file_exists(TESTFILE)) {
        $fh = fopen(TESTFILE, 'w');
        fseek($fh, 1024 * 1024);
        fwrite($fh, "!", 1);
        fclose($fh);
    }

    $file->setName("Hello World!");
    $service->files->create(
        $file,
        array(
            'data' => file_get_contents(TESTFILE),
            'mimeType' => 'application/octet-stream',
            'uploadType' => 'multipart'
        )
    );
});
/* * ******** end testing ******* */
/* * ********google drive user crud******* */
/* ************ google drive crud ****/
Route::get('/google_drive', 'hvl\GoogleDrive\GoogleDriveContoller@index')->name('google_drive.index');
Route::get('/google_drive/create', 'hvl\GoogleDrive\GoogleDriveContoller@create')->name('google_drive.create');
Route::post('google_drive/store', 'hvl\GoogleDrive\GoogleDriveContoller@store')->name('google_drive.store');
Route::get('/google_drive/edit/{id}', 'hvl\GoogleDrive\GoogleDriveContoller@edit')->name('google_drive.edit');
Route::post('google_drive/update/{id}', 'hvl\GoogleDrive\GoogleDriveContoller@update')->name('google_drive.update');
/************** end google drive ************* */
    Route::get('system_log', 'SystemLogController@show')->name('system_log view');
Route::get('system_log/detail/{id}', 'SystemLogController@detail')->name('system_log detail');
// stop watch 
Route::get('start_stop_watch', 'StopWatchController@startTime')->name('start_stop_watch');
Route::get('stop_stop_watch', 'StopWatchController@stopTime')->name('stop_stop_watch');






