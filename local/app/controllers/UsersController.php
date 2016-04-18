<?php

use Toddish\Verify\Models\User;

class UsersController extends BaseController
{

    /**
     * User Repository
     *
     * @var User
     */
    protected $user;
    public $data = array();

    public function __construct(UserModel $user)
    {
        parent::__construct();
        $this->user = $user;

        $this->model = $user;
        $this->my_model = 'UserModel';
        $this->data['module'] = 'user';
        $this->data['modules'] = 'users';


    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        if (!$this->data['user']->is('admin')) {
            return '';
        }

            $model = $this->user->with('roles')->orderBy('id', 'asc');
        $users = $model->get();

        if (Input::get('role_id')) {
            foreach ($users as $key => $user) {
                $user_roles = [];
                foreach ($user->roles as $role) {
                    $user_roles[] = $role->id;
                }
                if (!in_array(Input::get('role_id'), $user_roles))
                    unset($users[$key]);
            }
        }

        $this->data['users'] = $users;
        $this->data['roles'] = RoleModel::where(['active' => 1, 'deleted' => 0])->get();

        return View::make('users.index', ['data' => $this->data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        if (!$this->data['user']->is('admin')) {
            return '';
        }
        $logged_user = new User;
        $logged_user->id = Auth::user()->id;

        $this->data['roles'] = RoleModel::where('deleted', 0)->get();
        $this->data['permissions'] = PermissionModel::all();
        $this->data['provinces'] = Province::lists('name', 'id');


        return View::make('users.create', ['data' => $this->data]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $input = array_except(Input::all(), ['_token', 'roles', 'image']);
        $validation = Validator::make($input, UserModel::$rules);

        if ($validation->passes()) {

            if (Input::hasFile('image')) {
                if (Input::file('image')->isValid()) {
                    $random_name = create_random_name();
                    $extension = Input::file('image')->getClientOriginalExtension();
                    $img_name = $random_name . '.' . $extension;
                    if (Input::file('image')->move(public_path() . '/uploads/' . $this->data['modules'] . '/images', $img_name)) {
                        create_thumbnail(public_path() . '/uploads/' . $this->data['modules'] . '/images', $random_name, $extension, 350, 350);
                    }
                    $input['image'] = $img_name;
                }
            }


            $user = new User;

            $input['verified'] = 1;
            foreach ($input as $key => $field) {
                $user->$key = $field;
            }
            $user->save();

            $roles = Input::get('roles');
            if (!empty($roles)) {
                $user_roles = Input::get('roles');
                $user->roles()->sync([$user_roles]);
            }


            return Redirect::route('users.index');
        }

        return Redirect::route('users.create')
            ->withInput()
            ->withErrors($validation);
//            ->with('message', trans('validation_errors'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        $user = $this->user->with('department')->findOrFail($id);
//        pr2($user->toArray());
        return View::make('users.show', compact('user'));
    }

    public function user_roles($user_id)
    {
        return $this->user->with('user_roles')->find($user_id);
    }

    public function user_level($user_id)
    {
        $roles = [];
        foreach ($this->user_roles($user_id)->user_roles as $user_role) {
            $role = RoleModel::select('level')->find($user_role->role_id);
            $roles[] = $role->level;
        }
        if (!empty($roles)) {
            return max($roles);
        } else {
            return '';
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        if (!$this->data['user']->is('admin')) {
            return '';
        }
        $logged_user = new User;
        $logged_user->id = Auth::user()->id;

        if ($logged_user->level($this->user_level($id), '<')) {
            Session::flash('alert', 'danger');
            Session::flash('message', translate('main.You don\'t have permission'));
            return Redirect::route('users.index');
        }

        $this->data['theUser'] = $this->user->find($id);
        $this->data['theUserRole'] = $this->data['theUser']->roles()->first();

        $this->data['allUsers'] = $this->user->where('id', '!=', $id)->lists('fullname', 'id');
        $this->data['supervisors'] = UserSupervisor::where('user_id', $id)->lists('super_id');
        $this->data['subUsers'] = UserSupervisor::where('super_id', $id)->lists('user_id');

        $this->data['userCustomers'] = UserCustomer::where('user_id', $id)->lists('customer_id');
        $this->data['allDoctors'] = Doctor::lists('name', 'customer_id');
        $this->data['allHospitals'] = Hospital::lists('name', 'customer_id');
        $this->data['allPharmacies'] = Pharmacy::lists('name', 'customer_id');

        $this->data['permissions'] = PermissionModel::all();
        $this->data['provinces'] = Province::lists('name', 'id');
        $this->data['cities'] = City::lists('name', 'id');
        $this->data['areas'] = Area::lists('name', 'id');

        $this->data['roles'] = RoleModel::where('deleted', 0)->get();


        if (is_null($this->data['user']))
            return Redirect::route('users.index');

        return View::make('users.edit', ['data' => $this->data]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function profile()
    {
        $user = $this->user->find(Auth::user()->id);
        $this->data['provinces'] = Country::lists('name', 'id');

        if (is_null($user)) {
            return Redirect::route('admin');
        }

        return View::make('users.profile', ['data' => $this->data, 'user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        $rules = UserModel::$rules;

        $rules['email'] = $rules['email'] . ',email,' . $id;
        $rules = array_except($rules, ['pass']);

        $input = array_except(Input::all(), ['_method', 'roles', 'profile', 'supervisors', 'subUsers', 'userDoctors', 'userHospitals', 'userPharmacies']);

        $validation = Validator::make($input, $rules);

        if ($validation->passes()) {

            if (!Input::get('profile')) {

                if (isset($input['disabled']))
                    $input['disabled'] = 0;
                else
                    $input['disabled'] = 1;
            }


            $user = $this->user->find($id);


            if ($user->update($input)) {
                $roles = Input::get('roles');
                if (!empty($roles)) {
                    $user_roles = Input::get('roles');
                    $user = new User;
                    $user->id = $id;
                    $user->roles()->sync([$user_roles]);
                }

                $supervisors = Input::get('supervisors');
                if (!empty($supervisors)) {
                    UserSupervisor::where('user_id', $id)->delete();
                    foreach ($supervisors as $supervisorId) {
                        UserSupervisor::firstOrCreate(['user_id' => $id, 'super_id' => $supervisorId]);
                    }
                }

                $subUsers = Input::get('subUsers');
                if (!empty($subUsers)) {
                    UserSupervisor::where('super_id', $id)->delete();
                    foreach ($subUsers as $userId) {
                        UserSupervisor::firstOrCreate(['super_id' => $id, 'user_id' => $userId]);
                    }
                }

                $userCustomers = @array_merge(Input::get('userDoctors'), Input::get('userHospitals'), Input::get('userPharmacies'));
                if (!empty($userCustomers)) {
                    UserCustomer::where('user_id', $id)->delete();
                    foreach ($userCustomers as $customerId) {
                        UserCustomer::firstOrCreate(['user_id' => $id, 'customer_id' => $customerId]);
                    }
                }

            }

            /** Set User Roles **/
            //Delete Current User Roles
            Session::flash('alert', 'success');
            Session::flash('message', translate('main.record saved'));

            if (Input::get('profile') == 1)
                return Redirect::route('profile');
            else
                return Redirect::route('users.index');
        }

        Session::flash('alert', 'danger');
        return Redirect::back()
            ->withInput()
            ->withErrors($validation);
//            ->with('message', 'Validation Errors');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id, $redirect = true)
    {
        $this->user->find($id)->delete();
        if ($redirect) {
            Session::flash('alert', 'success');
            Session::flash('message', translate('main.record deleted'));
        }
        return Redirect::route('users.index');
    }

    public function login()
    {
//        $user = new User;
//        $user->email = 'test@test.com';
//        $user->password = '123456';
//        $user->save();
        $previous_url = Session::get('previous_url', '/');

        //Clear the user registered session
        Session::remove('user_registered');

        if (Auth::check()) {
            return Redirect::home();
        }

        $inputAll = Input::all();

        if (!empty($inputAll)) {
            $input = Input::all();
            $validation = Validator::make($input, ['identifier' => 'required', 'password' => 'required']);
            if ($validation->passes()) {

                $user = UserModel::where(['email' => Input::get('identifier'), 'pass' => Input::get('password'), 'disabled' => 0])
                    ->orWhere(['username' => Input::get('identifier'), 'pass' => Input::get('password'), 'disabled' => 0])
                    ->first();
                if ($user) {
                    $remember = false;
                    if (Input::get('remember') == 'true') {
                        $remember = true;
//                            setcookie('user_id', $user->id, time() + 30 * 60 * 60 * 24);
                    }
                    Auth::loginUsingId($user->id, $remember);
//                    pr(Auth::user());

                    return Redirect::to($previous_url);

                } else {
                    Session::flash('alert', 'danger');
                    Session::flash('message', 'Invalid username or password');
                }

            }
            return Redirect::back()->withInput($input)->withErrors($validation);
        }


        return View::make('users.login');
    }

    public function logout()
    {
        Session::clear();
        Auth::logout();
        return Redirect::to('/');
    }

    public function postChangePassword()
    {
        Session::flash('alert', 'danger');
        Session::flash('message', translate('main.invalid password'));

        if (Input::get('new_password') !== '') {

            $user = $this->user->find(Input::get('user_id'));
            if ($user) {
                $user->update(['pass' => Input::get('new_password')]);
                Session::flash('alert', 'success');
                Session::flash('message', translate('main.password changed successfully'));
            }
        }


        return Redirect::back();
    }

    public function forget_password()
    {
        if (Input::all()) {
            $user = new UserModel;
            $user = $user->where(['email' => Input::get('identifier'), 'disabled' => 0])
                > orWhere(['username' => Input::get('identifier'), 'disabled' => 0])
                    ->first();
            if (empty($user)) {
                Session::flash('alert', 'danger');
                Session::flash('message', 'User associated to this account is not found');
                return Redirect::back();
            }
            $new_password = create_random_name(6);
            $user->pass = $new_password;
            $user->update();
            $options = array(
                'subject' => 'CRM | Reset your password',
//                'content' => '<p>Please reset your password <a href="' . url('reset_password') . '">here</a></p>',
                'content' => '<p>Please reset your new password is: ' . $new_password . '</p>',
            );
            send_user_email($user, $options);

            Session::flash('alert', 'success');
            Session::flash('message', 'Password has been reset successfully, check your email');
            return Redirect::to('login');
        }
        return View::make('users.forget_password');
    }

    public function reset_password()
    {
        if (Input::all()) {
            $user = new UserModel;
            $user = $user->where('email', Input::get('email'))->get()->first();
            if (empty($user)) {
                Session::flash('alert', 'danger');
                Session::flash('message', 'User associated to this account is not found');
                return Redirect::back();
            }
//            $user->password = '123456';
//            $user->update();
            return View::make('users.reset_password');
        }
    }

}