<?php

class HomeController extends BaseController
{

    protected $model;
    protected $my_model;
    protected $data;

    public function __construct()
    {
        parent::__construct();

        $this->data['page'] = 'home';
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function getIndex()
    {
        $this->data['page_title'] = 'Home';
        // get messages
        $this->data['messages'] = DB::select("select `message`, `date` from `message`
                                              WHERE `expiration_date` >= CURDATE()
                                              AND ( `receiver_type`=5
                                              OR (`receiver_type`=0 and receiver_id={$this->data['user']->id})
                                              OR (`receiver_type`=1 and receiver_id={$this->data['user']->area_id})
                                              OR (`receiver_type`=2 and receiver_id={$this->data['user']->city_id})
                                              OR (`receiver_type`=3 and receiver_id={$this->data['user']->province_id})
                                              OR (`receiver_type`=4 and receiver_id in (SELECT `super_id` FROM `user_supervisor` WHERE `user_id`={$this->data['user']->province_id}) )
                                              )");

        return View::make('index', ['data' => $this->data]);
    }

    public function postIndex()
    {
        $startDate = date3(Input::get('startDate'));
        $endDate = date3(Input::get('endDate'));

        if ($endDate > date3()) {
            $endDate = date3();
        }
        $threeMonthsBefore = date('Y-m-d', strtotime($endDate) - (60 * 60 * 24 * 30 * 3));

        if ($startDate < $threeMonthsBefore) {
            $startDate = $threeMonthsBefore;
        }

        if (!empty($startDate)) {
            Session::set('startDate', $startDate);
            $this->data['startDate'] = $startDate;
        }

        if (!empty($endDate)) {
            Session::set('endDate', $endDate);
            $this->data['endDate'] = $endDate;
        }
        return Redirect::to('insights/products');
    }

    public function postContact()
    {
        $input = Input::except('image');
//        pr($input);
        if($input['disabledSelect']=='Type of problem'){
            Session::flash('alert', 'danger');
            Session::flash('message', 'Please select the type of problem');
            return Redirect::to('/');

        }
        if(empty($input['message'])){
            Session::flash('alert', 'danger');
            Session::flash('message', 'Please write your message');
            return Redirect::to('/');
        }

        $supervisors = DB::select("SELECT `fullname`,`email` from `user` WHERE `id` in (SELECT `super_id` FROM `user_supervisor` WHERE `user_id`={$this->data['user']->id})");

        // send mail to each supervisor of this user
        foreach ($supervisors as $supervisor) {
            $data = array(
                'to' => $supervisor->email,
                'body' => "Tacit User\n" .
                    "Fullname Name : " . $this->data['user']->fullname . "\n" .
                    "Position : " . $this->data['userRole']->name . "\n" .
                    "User Id : " . $this->data['user']->id . "\n" .
                    "Feedback Type : " . $input['disabledSelect'] . "\n" .
                    "Feedback Message : " . $input['message'] . "\n" .
                    "supervisor name : " . $supervisor->fullname . "\n" .
                    "supervisor email : " . $supervisor->email . "\n" .
                    "user email : " . $this->data['user']->email

            );

            if(sendMail($data)){
                Session::flash('alert', 'success');
                Session::flash('message', 'Your message sent successfully.');

            }else{
                Session::flash('alert', 'danger');
                Session::flash('message', 'Your message wasn\'t sent. Please Try again later');
            }
        }
        return Redirect::to('/');
    }

    public function getTellFriend(){
        return View::make('others.tell_friend', ['data' => $this->data]);
    }

    public function postTellFriend(){
        return View::make('others.tell_friend', ['data' => $this->data]);
    }

}
