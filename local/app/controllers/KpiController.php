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
        $this->data['page_title'] = 'KPI';

        $provinceIds = Province::userProvinces($this->data['userChildren']);
        $provinces = Province::select('name', 'id');
        if (!$this->data['user']->is('admin')) {
            $provinces = $provinces->whereIn('id', $provinceIds);
        }
        $this->data['provinces'] = $provinces->lists('name', 'id');

        $reps = UserModel::select(['user.id', 'fullname']);
        if (!$this->data['user']->is('admin')) {
            $reps = $reps->whereIn('user.id', $this->data['userChildren']);
        }
        if (Input::has('province')) {
            $reps = $reps->where('province_id', Input::get('province'));
        }
        $reps->where('role_user.role_id', 3)
        ->leftJoin('role_user', 'user.id', '=', 'role_user.user_id');

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

            $this->data['customers_type'] = 1;
            if ($allDoctors[0]->total==0){
              $sql = "select count(id) as total from customer where type=2 and id in (SELECT customer_id from user_customer where user_id=$userId)";
              $allDoctors = DB::select($sql);
              $this->data['customers_type'] = 2;
            }


            $sql = "SELECT count(DISTINCT customer_id) as visited
                                      from visit
                                      JOIN customer on visit.customer_id = customer.id and customer.type={$this->data['customers_type']}
                                      where customer_id in (SELECT customer_id from user_customer where user_id=$userId)
                                      and user_id=$userId
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

        if(!empty($userId)){
          $userIdCustomized = $userId;
        }else{
          $userIdCustomized = 'user_id';
        }

        //for samples table
        $sql = "SELECT SUM( t.samples ) AS sum, product.name AS product_name
        FROM (

        SELECT product_id, samples, user_id
        FROM visit
        where date(visit.date) between '{$this->data['startDate']}' and '{$this->data['endDate']}'
        UNION ALL
        SELECT product_id, samples, user_id
        FROM workshop
        where date(workshop.workshop_date) between '{$this->data['startDate']}' and '{$this->data['endDate']}'
        )t
        JOIN product ON t.product_id = product.id
        WHERE user_id =$userIdCustomized
        GROUP BY product_id";
        $this->data['sumreport'] = DB::select($sql);

        //For sub-samples
        $sql = "SELECT SUM(t.samples) AS sum, product.name AS product_name, t.samples_type
        FROM (
        SELECT product_id, samples, samples_type, user_id
        FROM visit
        where date(visit.date) between '{$this->data['startDate']}' and '{$this->data['endDate']}'
        UNION ALL
        SELECT product_id, samples, samples_type, user_id
        FROM workshop
        where date(workshop.workshop_date) between '{$this->data['startDate']}' and '{$this->data['endDate']}'
        )t
        JOIN product ON t.product_id = product.id
        WHERE user_id =$userIdCustomized
        GROUP BY product_id,t.samples_type";
        $this->data['subsamples'] = DB::select($sql);
        /*
        $sql = "SELECT SUM(visit.samples) AS sum, product.name AS product_name, samples_type
        FROM visit
        JOIN product ON visit.product_id = product.id
        WHERE user_id =$userIdCustomized
        GROUP BY product_id,samples_type";
        $this->data['subsamples'] = DB::select($sql);
        */

        $dStart = new DateTime($this->data['startDate']);
        $dEnd  = new DateTime($this->data['endDate']);
        $dDiff = $dStart->diff($dEnd);
        $working_days = $dDiff->days;
        if($working_days > 5){
          $working_days *= (5/7);
        }

        $sql = "SELECT ROUND(count(visit.user_id)/(13 * $working_days)) as total
              from (select DISTINCT user_id,customer_id, date(date) as date from visit) visit
              where date(visit.date) between '{$this->data['startDate']}' and '{$this->data['endDate']}'";
        $this->data['rate_total'] = DB::select($sql);

        if(!empty($userId)){
          $sql = "SELECT ROUND(count(visit.user_id)/$working_days) as total
                from (select DISTINCT user_id,customer_id, date(date) as date from visit) visit
                where date(visit.date) between '{$this->data['startDate']}' and '{$this->data['endDate']}'
                AND user_id={$userId}";
          $this->data['rate_rep'] = DB::select($sql);
        }




//        pr(DB::getQueryLog());
//        return $this->data['coveredDoctorsByGrade'];

        return View::make($this->data['modules'] . '.index', ['data' => $this->data]);
    }


}
