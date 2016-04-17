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
        $this->data['provinceId'] = $provinceId;

        $this->data['provinces'] = Province::select('name', 'id')->lists('name', 'id');
        $this->data['provinceId'] = $provinceId;

        if ($provinceId != null) {
            $this->data['reps'] = UserModel::select(['id', 'fullname'])->where('province_id',$provinceId)->lists('fullname', 'id');
        }

        return View::make($this->data['modules'] . '.provinces', ['data' => $this->data]);
    }

    public function getUserPlan($userId)
    {

        if (Input::has('from')) {
            $this->data['from'] = Input::get('from');
            $this->data['to'] = addDaytoDate($this->data['from'],5);


            $plans = DB::select("
    SELECT visit_plan.date , customer.name , customer.customer_type , customer.speciality , customer.customer_id,
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
    SELECT visit.date , customer.name , customer.customer_type , customer.speciality , customer.customer_id

    FROM `visit` ,
        (select name , customer_id , '1' as customer_type , speciality from doctor
        union all
        select name , customer_id , '3' as customer_type , '-' as speciality from hospital
        union all
        select name , customer_id , '2' as customer_type , '-' as speciality from pharmacy ) as customer

--    where user_id = {$userId}
    where date(visit.date) between date('{$this->data['from']}')
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
