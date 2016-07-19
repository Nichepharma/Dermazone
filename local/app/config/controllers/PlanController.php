<?php

class PlanController extends BaseController
{

    protected $model;
    protected $my_model;
    protected $data;

    public function __construct(Visit $model)
    {
        parent::__construct();
        $this->model = $model;
        $this->my_model = 'Visit';
        $this->data['module'] = 'plan';
        $this->data['modules'] = 'plan';

    }


    public function getIndex($provinceId = null)
    {
        $this->data['page_title'] = 'Plan';
        $this->data['provinceId'] = $provinceId;

        $provinces = Province::select('name', 'id');
        if (!$this->data['user']->is('admin')) {
            $provinceIds = Province::userProvinces($this->data['userChildren']);
            $provinces = $provinces->whereIn('id', $provinceIds);
        }
        $this->data['provinces'] = $provinces->lists('name', 'id');

        $this->data['provinceId'] = $provinceId;

        if ($provinceId != null) {
            $reps = UserModel::select(['user.id', 'fullname']);
            if (!$this->data['user']->is('admin')) {
                $reps = $reps->whereIn('user.id', $this->data['userChildren']);
            }

            //$this->data['reps'] = $reps->where('province_id',$provinceId)->lists('fullname', 'id');
            $this->data['reps'] = $reps->where('province_id', $provinceId)->where('role_user.role_id', 3)
            ->leftJoin('role_user', 'user.id', '=', 'role_user.user_id')
            ->lists('fullname', 'id');
        }

        return View::make($this->data['modules'] . '.provinces', ['data' => $this->data]);
    }

    public function getUserPlan($userId)
    {
        $this->data['page_title'] = 'User Plan';

        if (Input::has('from')) {
            $this->data['from'] = Input::get('from');
            $this->data['to'] = addDaytoDate($this->data['from'],5);


            $plans = DB::select("
    SELECT DATE(visit_plan.date) as date , customer.name , customer.customer_type , customer.speciality , customer.customer_id,
    case
        when exists (select id from visit v where v.customer_id = visit_plan.customer_id and date(visit_plan.date) = date(v.date) and visit_plan.user_id = v.user_id) then
            'visited'
        else
            'none'
    end as visited

    FROM
        `visit_plan` ,
        (select name , customer_id , '1' as customer_type , speciality from doctor
        union all
        select name , customer_id , '3' as customer_type , '-' as speciality from hospital
        union all
        select name , customer_id , '2' as customer_type , '-' as speciality from pharmacy ) as customer

    where user_id = {$userId}
        and date(visit_plan.date) between date('{$this->data['from']}')
        and date( '{$this->data['to']}')
        and customer.customer_id = visit_plan.customer_id
    order by  FIELD(customer.customer_type,3,1,2) , date ,   FIELD(visited ,'visited','none')");


            $visits = DB::select("
    SELECT DATE(visit.date) as date , customer.name , customer.customer_type , customer.speciality , customer.customer_id

    FROM `visit` ,
        (select name , customer_id , '1' as customer_type , speciality from doctor
        union all
        select name , customer_id , '3' as customer_type , '-' as speciality from hospital
        union all
        select name , customer_id , '2' as customer_type , '-' as speciality from pharmacy ) as customer

    where visit.user_id = {$userId}
    and date(visit.date) between date('{$this->data['from']}')
        and date( '{$this->data['to']}')
        and customer.customer_id = visit.customer_id
        and not exists (select id from visit_plan where visit_plan.customer_id = visit.customer_id and date(visit.date) = date(visit_plan.date) and visit.user_id = visit_plan.user_id)");
            $this->data['plan'] = arrayGroupBy($plans, 'customer_type');
            $this->data['visits'] = arrayGroupBy($visits, 'customer_type');
//            return $this->data['visits'];
            return View::make($this->data['modules'] . '.user_plan_table', ['data' => $this->data]);

        }

        $this->data['userId'] = $userId;
        $this->data['user'] = UserModel::find($userId, ['id', 'fullname']);

//        $start = new DateTime($this->data['startDate']);
//        $end = new DateTime($this->data['endDate']);
//        $interval = DateInterval::createFromDateString('1 month');
//        $period = new DatePeriod($start, $interval, $end);
//        $this->data['months'] = [];
//        foreach ($period as $dt) {
//            $this->data['months'][$dt->format("n")] = $dt->format("M Y");
//        }
//		return $this->data['months'];

        return View::make($this->data['modules'] . '.user_plan', ['data' => $this->data]);
    }


}
