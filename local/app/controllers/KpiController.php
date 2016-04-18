<?php

class KpiController extends BaseController
{

    protected $model;
    protected $my_model;
    protected $data;

    public function __construct(Visit $model)
    {
        parent::__construct();
        $this->model = $model;
        $this->my_model = 'Visit';
        $this->data['module'] = 'kpi';
        $this->data['modules'] = 'kpi';

    }

    public function getIndex()
    {
        $provinceIds = Province::userProvinces($this->data['userChildren']);
        $provinces = Province::select('name', 'id');
        if (!$this->data['user']->is('admin')) {
            $provinces = $provinces->whereIn('id', $provinceIds);
        }
        $this->data['provinces'] = $provinces->lists('name', 'id');

        $reps = UserModel::select(['id', 'fullname']);
        if (!$this->data['user']->is('admin')) {
            $reps = $reps->whereIn('id', $this->data['userChildren']);
        }
        if (Input::has('province')) {
            $reps = $reps->where('province_id', Input::get('province'));
        }
        $this->data['reps'] = $reps->lists('fullname', 'id');


        $provinceId = Input::get('province');
        $userId = Input::get('rep');

        $this->data['userId'] = $userId;
        $this->data['provinceId'] = $provinceId;


        if (!empty($userId)) {
            // filter by rep
            if(!$this->data['user']->is('admin') && !in_array($userId,$this->data['userChildren'])){
                return '';
            }

            $sql = "select count(id) as total from customer where type=1 and id in (SELECT customer_id from user_customer where user_id=$userId)";
            $allDoctors = DB::select($sql);



            $sql = "select count(DISTINCT customer_id) as visited
                                      from visit
                                      where customer_id in (SELECT customer_id from user_customer where user_id=$userId)
                                      and date(visit.date) between '{$this->data['startDate']}' and '{$this->data['endDate']}'";
            $coveredDoctors = DB::select($sql);



            $sql = "select speciality,grade
                                      from doctor
                                      where customer_id in (SELECT DISTINCT customer_id
                                                           from visit
                                                           where user_id=$userId
                                                           and date(visit.date) between '{$this->data['startDate']}' and '{$this->data['endDate']}')";
            $coveredDoctorsDetails = DB::select($sql);

        } elseif (!empty($provinceId)) {
            // filter by province

            if (!$this->data['user']->is('admin')) {
                $sql = "select count(`customer`.`id`) as total from `customer`
                        join `user_customer` on `user_customer`.`customer_id`=`customer`.`id`
                        where `user_customer`.`user_id` in (" . toString($this->data['userChildren']) . ")
                            and `customer`.`type`=1
                            and `customer`.`province_id`=$provinceId";
            }else{
                $sql = "select count(`id`) as total from `customer` where `type`=1 AND `province_id`=$provinceId";
            }

            $allDoctors = DB::select($sql);



            $sql = "select count(DISTINCT customer_id) as visited
                                      from visit
                                      JOIN customer
                                      on visit.customer_id=customer.id
                                      where date(visit.date) between '{$this->data['startDate']}' and '{$this->data['endDate']}'";
            if (!$this->data['user']->is('admin')) {
                $sql .= " AND `visit`.`user_id` in (" . toString($this->data['userChildren']) . ")";
            }
            $coveredDoctors = DB::select($sql);


            $sql = "select speciality,grade
                                      from doctor
                                      where customer_id in (SELECT DISTINCT customer_id
                                                           from visit
                                                           where customer_id IN (SELECT id from customer WHERE province_id=$provinceId)
                                                           and date(visit.date) between '{$this->data['startDate']}' and '{$this->data['endDate']}'";
            if (!$this->data['user']->is('admin')) {
                $sql .= " AND `visit`.`user_id` in (" . toString($this->data['userChildren']) . ")";
            }
            $sql .= ")";
            $coveredDoctorsDetails = DB::select($sql);

        } else {
            // no filters
            if (!$this->data['user']->is('admin')) {
                $sql = "select count(`customer`.`id`) as total from `customer`
                        join `user_customer` on `user_customer`.`customer_id`=`customer`.`id`
                        where `user_customer`.`user_id` in (" . toString($this->data['userChildren']) . ") and `customer`.`type`=1";
            }else{
                $sql = "select count(`id`) as total from `customer` where `type`=1";
            }
            $allDoctors = DB::select($sql);


            $sql = "select count(DISTINCT customer_id) as visited
                    from visit
                    where date(visit.date) between '{$this->data['startDate']}' and '{$this->data['endDate']}'";
            if (!$this->data['user']->is('admin')) {
                $sql .= " AND `visit`.`user_id` in (" . toString($this->data['userChildren']) . ")";
            }
            $coveredDoctors = DB::select($sql);


            $sql = "select speciality,grade
                                      from doctor
                                      where customer_id in (SELECT DISTINCT customer_id
                                                           from visit
                                                           where date(visit.date) between '{$this->data['startDate']}' and '{$this->data['endDate']}'";

            if (!$this->data['user']->is('admin')) {
                $sql .= " AND `visit`.`user_id` in (" . toString($this->data['userChildren']) . ")";
            }
            $sql .= ")";
            $coveredDoctorsDetails = DB::select($sql);
        }

        $this->data['coveredDoctors'] = $coveredDoctors[0]->visited;
        $this->data['unCoveredDoctors'] = $allDoctors[0]->total - $this->data['coveredDoctors'];

        $this->data['coveredDoctorsBySpeciality'] = [];
        $this->data['coveredDoctorsByGrade'] = [];

        foreach (arrayGroupBy($coveredDoctorsDetails, 'speciality') as $speciality => $doctors) {
            $this->data['coveredDoctorsBySpeciality'][$speciality] = count($doctors);
        }

        foreach (arrayGroupBy($coveredDoctorsDetails, 'grade') as $grade => $doctors) {
            $this->data['coveredDoctorsByGrade'][$grade] = count($doctors);
        }

//        pr(DB::getQueryLog());
//        return $this->data['coveredDoctorsByGrade'];

        return View::make($this->data['modules'] . '.index', ['data' => $this->data]);
    }


}
