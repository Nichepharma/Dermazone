<?php

class BaseController extends Controller
{

    protected $data;

    public function __construct()
    {
        // set the data to use in all controllers and views

        ini_set("memory_limit", "-1");

        $beforeFilter = array('login', 'logout', 'reset_password', 'forget_password', 'signup');
        $path = Request::path();
        if (!Auth::check() && !in_array($path, $beforeFilter)) {
            Session::put('previous_url', $path);
        }

        $this->beforeFilter('auth', array('except' => $beforeFilter));

        if (Input::has('startDate') && Input::has('endDate')) {
            Session::set('startDate', Input::get('startDate'));
            Session::set('endDate', Input::get('endDate'));
        }

        if (!Session::has('startDate') || !Session::has('endDate')) {
            Session::set('startDate', date('Y-m-d', strtotime("-2 month")));
            Session::set('endDate', date('Y-m-d'));
        }
        //testing.....
//        Session::set('startDate', '2015-04-02');
//        Session::set('endDate', '2015-07-01');

        $this->data['startDate'] = Session::get('startDate');
        $this->data['endDate'] = Session::get('endDate');

        if (!Request::ajax()) {
            $this->data['page_title'] = '';
            $this->data['modules'] = '';
        }

        if (Auth::check()) {
            // get the logged user
            $user = new UserModel();
            $user = $user->find(Auth::user()->id, ['id', 'fullname', 'username', 'email', 'area_id', 'city_id', 'province_id']);

            $userChildren = Session::get('userChildren');
            if (empty($userChildren)) {
                UserSupervisor::createTree(UserSupervisor::where('super_id', $user->id)->get(['user_id']));
                Session::put('userChildren', UserSupervisor::$userSubs);
            }
            $this->data['userChildren'] = $userChildren;
            $this->data['userChildren'][$user->id] = $user->id;

            $this->data['user'] = $user;
            $this->data['userRole'] = $user->roles()->first();
        }


    }

    /**
     * Setup the layout used by the controller.
     *
     * @return void
     */
    protected function setupLayout()
    {
        if (!is_null($this->layout)) {
            $this->layout = View::make($this->layout);
        }
    }

}
