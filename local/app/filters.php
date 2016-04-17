<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function ($request) {
    //
});


App::after(function ($request, $response) {
    //
});


Config::set('user_statuses', ['1' => 'Active', '0' => 'InActive']);
Config::set('rows_per_page', ['5' => '5', '10' => '10', '15' => '15', '20' => '20', '100' => '100']);
Config::set('form_elements', ['text' => 'text', 'textarea' => 'textarea', 'list' => 'list']);

//titles_con
Config::set('titles', [
    '' => ' ',
    '0' => ' ',
    '1' => 'Dr.',
    '2' => 'Miss',
    '3' => 'Mr.',
    '4' => 'Mrs.',
    '5' => 'Ms.',
    '6' => 'Eng.',
    '7' => 'Board',
    '8' => 'Company',
    '9' => 'Institutes Presidents',
]);

Config::set('titles_ar', [
    '' => ' ',
    '0' => ' ',
    '1' => 'دكتور',
    '2' => 'انسة',
    '3' => 'أستاذ',
    '4' => 'مدام',
    '5' => 'أستاذه',
    '6' => 'مهندس',
    '7' => 'مجلس',
    '8' => 'شركة',
    '9' => 'معاهد الرؤساء',
]);


//Config::set('titles_ar', ['' => ' ', '1' => 'أستاذ', '2' => 'أنسة', '3' => 'مدام', '4' => 'دكتور', '4' => 'مهندس']);

Config::set('fav', ['1' => 'Favourite', '0' => 'Not Favourite']);//'' => 'All',
Config::set('fav_ar', ['1' => 'مفضلون', '0' => 'غير مفضلون']);//'' => 'الجميع',

Config::set('activity_status_arr', ['0' => 'Pending', '1' => 'Completed']);
Config::set('activity_status_arr_ar', ['0' => 'فى اإنتظار', '1' => 'إنتهت']);

Config::set('activity_priority_arr', ['0' => 'Low', '1' => 'Average', '2' => 'High']);
Config::set('activity_priority_arr_ar', ['0' => 'ضعيفة', '1' => 'متوسطة', '2' => 'عالية']);

Config::set('activity_type_arr', ['0' => 'Task', '1' => 'Call', '2' => 'Meeting']);
Config::set('activity_type_arr_ar', ['0' => 'مهمة', '1' => 'إتصال', '2' => 'مقابلة']);

Config::set('activity_call_type_arr', ['0' => 'Outgoing call', '1' => 'Incoming call']);
Config::set('activity_call_type_arr_ar', ['0' => 'مكالمة ضادرة', '1' => 'مكالمة واردة']);

Config::set('activity_with_arr', ['0' => 'Contact', '1' => 'Account']);
Config::set('activity_with_arr_ar', ['0' => 'عميل', '1' => 'شركة']);

//Config::set('titles', ['0' => translate('main.mr').'1', '1' => translate('miss').'.', '2' => translate('mrs').'.', '3' => translate('dr').'.']);

//contact_statuses
Config::set('contact_statuses', ['1' => 'Lead', '2' => 'Opportunity', '3' => 'Contact']);
Config::set('contact_statuses_ar', ['1' => 'غير عميل', '2' => 'عميل محتمل', '3' => 'عميل دائم']);

//contact_types
Config::set('contact_types', ['1' => 'Buyer', '2' => 'Vendor']);
Config::set('contact_types_ar', ['1' => 'مشترى', '2' => 'مورد']);

//Config::set('user_positions', ['1' => 'Manager', '2' => 'Sales']);

Config::set('shared_routes', ['home', 'login', 'signup', 'profile', 'change_password', 'logout', 'login_post', 'sms_templates.select_active',]);//,'permissions','notes','files'

Config::set('langs', ['en' => 'English', 'ar' => 'العربية']);


//Config::set('smtp_username', 'gamal@think-ds.com');
//Config::set('smtp_password', 'Bpk6Vj-jJNyKwPBy2JYM8w');
//Config::set('mandrill_password', 'sOLhN2yehH4KHKHLvfNcKA');

//Config::set('smtp_username', 'gamal@think-ds.com');
//Config::set('smtp_password', 'Bpk6Vj-jJNyKwPBy2JYM8w');
//Config::set('mandrill_password', Auth::user()->mandrill_password);


//pr2(Config::get('mandrill_password'));

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function () {

    /*
     * Check login
     */
    if (Auth::guest()) {
        if (Request::ajax()) {
            return Response::make('Unauthorized', 401);
        } else {
            return Redirect::guest('login');
        }
    }


    /*
     * Check Permissions
     */

    // get all permissions
    $permissions = PermissionModel::select('name')->remember(30)->get()->lists('name');
    $permissions[] = 'HomeController@getIndex';

    // get the logged user
    $user = new UserModel();
    $user->id = Auth::user()->id;


    /*
     * This block used in case activating user permissions
    // get all current route
    $current_action =  str_replace('App\Http\Controllers\\', '', \Route::getCurrentRoute()->getActionName());
    if (in_array($current_action, $permissions)) {
        if (!$user->can($current_action)) {

            // if user dont have permission redirect to moe
            if (!Request::ajax()) {
                Session::flash('message', translate('main.you don\'t have permission'));
                return Redirect::back();

            } else {
                echo '<p class="well-lg">'.translate('main.you don\'t have permission').'</p>';
                return false;
            }
        }

    }
*/

    /*
     * Check for chosen date
     */

//    if(!Session::has('startDate') || !Session::has('endDate')){
//        if(!in_array($current_action,['HomeController@postIndex','HomeController@getIndex'])){
////            return Redirect::to('home');
//        }
//    }

    // User allowed.. continue to request..
});


Route::filter('auth.basic', function () {
    return Auth::basic();
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function () {
    if (Auth::check()) return Redirect::to('/');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function () {
    if (Session::token() !== Input::get('_token')) {
        throw new Illuminate\Session\TokenMismatchException;
    }
});


//
//Route::filter('auth', function()
//{
//	if (Auth::guest())
//	{
//		if (Request::ajax()) {
//			return Response::make('Unauthorized', 401);
//		}
//		else {
//			return Redirect::guest('login');
//		}
//	}
//
//	if(Auth::check())
//	{
//		if(!UserModel::has_perm('super_admin'))
//		{
//			return 'Access denied';
//		}
//	}
//});
