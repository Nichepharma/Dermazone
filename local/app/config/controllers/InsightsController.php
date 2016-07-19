<?php

class InsightsController extends BaseController
{

    protected $model;
    protected $my_model;
    protected $data;

    public function __construct(Visit $model)
    {
        parent::__construct();
        $this->model = $model;
        $this->my_model = 'Visit';
        $this->data['module'] = 'insight';
        $this->data['modules'] = 'insights';

    }


    public function getProducts()
    {
        $model = $this->model->whereRaw("DATE(date) between '".$this->data['startDate']."' and '".$this->data['endDate']."'");

        if (!$this->data['user']->is('admin')) {
            $model = $model->whereIn('user_id', $this->data['userChildren']);
        }

        $this->data['countCalls'] = $model->count('id');

        $calls = $model->get(['id', 'product_id'])->groupBy('product_id');
        $products = Product::lists('name', 'id');

        foreach ($products as $id => $name) {
            $this->data['products'][$id] = $name . ': 0';
            $this->data['calls'][$id] = 0;
        }
//        $this->data['calls'] = [];
//        return $calls;
        foreach ($calls as $productId => $productVisits) {
            $productVisits = count($productVisits);
            $this->data['products'][$productId] = $products[$productId] . ': ' . $productVisits;
            $this->data['calls'][$productId] = $productVisits;

        }
//        return $this->data['calls'];

        return View::make($this->data['modules'] . '.products', ['data' => $this->data]);
    }

    public function getProduct($productId)
    {

        $this->data['productId'] = $productId;

        $model = $this->model->whereRaw("DATE(date) between '".$this->data['startDate']."' and '".$this->data['endDate']."'");

        if (!$this->data['user']->is('admin')) {
            $model = $model->whereIn('user_id', $this->data['userChildren']);
        }

        // get products
        $allCalls = $model->get(['product_id']);
//        pr(DB::getQueryLog());
        $allCalls = arrayGroupBy($allCalls, 'product_id');
        $products = Product::lists('name', 'id');
        $this->data['productName'] = $products[$productId];

        foreach ($products as $id => $name) {
            $this->data['products'][$id] = $name . ': 0';
        }

        foreach ($allCalls as $callProductId => $productVisits) {
            $productVisits = count($productVisits);
            $this->data['products'][$callProductId] = $products[$callProductId] . ': ' . $productVisits;
        }


        // get calls for chosen product
        $calls = DB::table('visit')
            ->whereRaw("DATE(date) between '".$this->data['startDate']."' and '".$this->data['endDate']."'")
            ->where('product_id', $productId);

        if (!$this->data['user']->is('admin')) {
            $calls = $calls->whereIn('visit.user_id', $this->data['userChildren']);
        }

        $calls = $calls->join('customer', 'visit.customer_id', '=', 'customer.id')
            ->get(['visit.id', 'product_id', 'customer.type']);


        $customerTypes = CustomerType::lists(false);
        $this->data['calls'] = [];

        // group by customer type
        foreach (arrayGroupBy($calls, 'type') as $typeId => $typeVisits) {
            $typeVisits = count($typeVisits);
            $this->data['types'][$typeId] = $customerTypes[$typeId] . ': ' . $typeVisits;
            $this->data['calls'][] = $typeVisits;

        }


        // slide analysis
        // How many times slide used in visits for this product

        $slides = ProductSlide::where('product_id', $productId)->lists('cat', 'num');

        $calls = DB::table('visit')
            ->whereRaw("DATE(date) between '".$this->data['startDate']."' and '".$this->data['endDate']."'")
            ->where('visit.product_id', $productId);
        if (!$this->data['user']->is('admin')) {
            $calls = $calls->whereIn('visit.user_id', $this->data['userChildren']);
        }

        $calls = $calls->join('visit_slide', 'visit.id', '=', 'visit_slide.visit_id')
            ->get(['visit_slide.time', 'visit_slide.slide_id']);

        foreach (arrayGroupBy($calls, 'slide_id') as $slideId => $slideVisits) {
            $total_duration = 0;
            foreach ($slideVisits as $slideVisit) {
                $total_duration += $slideVisit->time;
            }
            if (isset($slides[$slideId])) {
                $this->data['slides'][$slides[$slideId]] += $total_duration;
            }
        }
        return View::make($this->data['modules'] . '.product', ['data' => $this->data]);
    }

    public function getProductDoctors($productId)
    {

        $this->data['productId'] = $productId;

        $model = $this->model->whereRaw("DATE(date) between '".$this->data['startDate']."' and '".$this->data['endDate']."'");

        if (!$this->data['user']->is('admin')) {
            $model = $model->whereIn('user_id', $this->data['userChildren']);
        }

        // get products
        $allCalls = $model->get(['product_id']);
        $allCalls = arrayGroupBy($allCalls, 'product_id');
        $products = Product::lists('name', 'id');
        $this->data['productName'] = $products[$productId];

        foreach ($products as $id => $name) {
            $this->data['products'][$id] = $name . ': 0';
        }
        foreach ($allCalls as $callProductId => $productVisits) {
            $productVisits = count($productVisits);
            $this->data['products'][$callProductId] = $products[$callProductId] . ': ' . $productVisits;
        }


        // get calls for chosen product (for doctors)
        // divide by doctors speciality
        $calls = DB::table('visit')
            ->whereRaw("DATE(date) between '".$this->data['startDate']."' and '".$this->data['endDate']."'")
            ->where('product_id', $productId);

        if (!$this->data['user']->is('admin')) {
            $calls = $calls->whereIn('visit.user_id', $this->data['userChildren']);
        }

        $calls = $calls->join('doctor','visit.customer_id', '=', 'doctor.customer_id')
            ->get(['doctor.speciality','doctor.id']);

        $this->data['countCalls'] = count($calls);
        foreach($calls as $doctor){
            $doctorIds[$doctor->id] = $doctor->id;
        }
        $customerSpecialities = Doctor::distinct('speciality')->whereIn('id',$doctorIds)->get(['speciality']);

        foreach($customerSpecialities as $speciality){
            $specialities[$speciality->speciality] = $speciality->speciality;
            $this->data['specialities'][$speciality->speciality] =  array(
                'title'=>$speciality->speciality . ': 0',
                'visits'=> 0
            );
        }

        // group by doctor speciality
        foreach (arrayGroupBy($calls, 'speciality') as $speciality => $specialityVisits) {
            $specialityVisits = count($specialityVisits);
            $this->data['specialities'][$speciality] = array(
                'title'=> $specialities[$speciality] . ': ' . $specialityVisits,
                'visits'=> $specialityVisits
            );
        }


        // slide analysis
        // How many times slide used in visits for this product

        $slides = ProductSlide::where('product_id', $productId)->lists('cat', 'num');


        $calls = DB::table('visit')
            ->whereRaw("DATE(date) between '".$this->data['startDate']."' and '".$this->data['endDate']."'")
            ->where('visit.product_id', $productId);
        if (!$this->data['user']->is('admin')) {
            $calls = $calls->whereIn('visit.user_id', $this->data['userChildren']);
        }

        $calls = $calls->join('visit_slide', 'visit.id', '=', 'visit_slide.visit_id')
            ->get(['visit_slide.time', 'visit_slide.slide_id']);

        foreach (arrayGroupBy($calls, 'slide_id') as $slideId => $slideVisits) {
            $total_duration = 0;
            foreach ($slideVisits as $slideVisit) {
                $total_duration += $slideVisit->time;
            }
            if (isset($slides[$slideId])) {
                $this->data['slides'][$slides[$slideId]] += $total_duration;
            }
        }

        return View::make($this->data['modules'] . '.product_doctors', ['data' => $this->data]);
    }

    public function getUserProducts($userId)
    {
        $model = $this->model->whereRaw("DATE(date) between '".$this->data['startDate']."' and '".$this->data['endDate']."'")
            ->where('user_id', $userId);

        $this->data['theUser'] = UserModel::find($userId, ['id', 'fullname']);

        $this->data['countCalls'] = $model->count('id');

        $calls = $model->get(['id', 'product_id'])->groupBy('product_id');
        $products = Product::lists('name', 'id');

        $this->data['products'] = [];
        $this->data['calls'] = [];
        foreach ($calls as $productId => $productVisits) {
            $productVisits = count($productVisits);
            $this->data['products'][$productId] = $products[$productId] . ': ' . $productVisits;
            $this->data['calls'][] = $productVisits;

        }

        return View::make($this->data['modules'] . '.user_products', ['data' => $this->data]);
    }

    public function getUserProduct($userId, $productId)
    {
        $this->data['productId'] = $productId;

        $model = $this->model->whereRaw("DATE(date) between '".$this->data['startDate']."' and '".$this->data['endDate']."'")
            ->where('user_id', $userId);

        $this->data['user'] = UserModel::find($userId, ['id', 'fullname']);

        // get products
        $allCalls = $model->get(['product_id']);
        $allCalls = arrayGroupBy($allCalls, 'product_id');
        $products = Product::get()->lists('name', 'id');
        $this->data['productName'] = $products[$productId];

        $this->data['products'] = [];
        foreach ($allCalls as $callProductId => $productVisits) {
            $productVisits = count($productVisits);
            $this->data['products'][$callProductId] = $products[$callProductId] . ': ' . $productVisits;
        }


        // get calls for chosen product
        // group by customer typ
        $calls = DB::table('visit')
            ->whereRaw("DATE(date) between '".$this->data['startDate']."' and '".$this->data['endDate']."'")
            ->where('product_id', $productId)
            ->where('user_id', $userId)
            ->join('customer', 'visit.customer_id', '=', 'customer.id')
            ->get(['visit.id', 'product_id', 'customer.type']);

        $customerTypes = CustomerType::lists();
        $this->data['calls'] = [];
        foreach (arrayGroupBy($calls, 'type') as $typeId => $typeVisits) {
            $typeVisits = count($typeVisits);
            $this->data['types'][$typeId] = $customerTypes[$typeId] . ': ' . $typeVisits;
            $this->data['calls'][] = $typeVisits;

        }


        // slide analysis
        // How many times slide used in visits for this product

        $slides = ProductSlide::where('product_id', $productId)
            ->get(['id', 'name'])
            ->lists('name', 'id');


        $calls = DB::table('visit')
            ->whereRaw("DATE(date) between '".$this->data['startDate']."' and '".$this->data['endDate']."'")
            ->where('visit.product_id', $productId)
            ->where('visit.user_id', $productId)
            ->where('visit_slide.slide_id', '!=', 0)
            ->join('visit_slide', 'visit.id', '=', 'visit_slide.visit_id')
            ->get(['visit.id', 'visit_slide.slide_id']);

        foreach (arrayGroupBy($calls, 'slide_id') as $slideId => $slideVisits) {
            $slideVisits = count($slideVisits);

            if (isset($slides[$slideId])) {
                $this->data['slides'][$slides[$slideId]] = $slideVisits;
            }
        }

//		return $this->data['slides'];

        return View::make($this->data['modules'] . '.user_product', ['data' => $this->data]);
    }


    public function getProvinces()
    {
        $provinceIds = Province::userProvinces($this->data['userChildren']);
        $provinces = Province::select('name', 'id');
        if (!$this->data['user']->is('admin')) {
            $provinces = $provinces->whereIn('id', $provinceIds);
        }
        $provinces = $provinces->lists('name', 'id');
        $calls = DB::table('visit')->whereRaw("DATE(date) between '".$this->data['startDate']."' and '".$this->data['endDate']."'");

        if (!$this->data['user']->is('admin')) {
            $calls = $calls->whereIn('user_id', $this->data['userChildren']);
        }

        $calls = $calls->join('customer', 'visit.customer_id', '=', 'customer.id')
            ->where('customer.province_id', '!=', 0)
            ->get(['customer.province_id']);

        $this->data['countCalls'] = count($calls);
        $this->data['provinces_menu'] = [];
        $this->data['provinces'] = [];
        $calls = arrayGroupBy($calls, 'province_id');
        $x = 0;
        $i = 0;
        foreach ($calls as $provinceId => $provinceVisits) {
            $provinceVisits = count($provinceVisits);

            if (isset($provinces[$provinceId])) {
                $provincesMenu[$provinceId] = $provinceVisits;
                $i++;

                if ($i == 10 || $i == 20 || $i == 30 || $i == 40) {
                    $x++;
                }
                $this->data['provinces'][$x][$provinces[$provinceId]] = $provinceVisits;
            }
        }

        foreach ($provinces as $id => $name) {
            if (isset($provincesMenu[$id])) {
                $this->data['provinces_menu'][$id] = $name . ': ' . $provincesMenu[$id];

            } else {
                $this->data['provinces_menu'][$id] = $name . ': 0';
            }

        }

//        pr($this->data['provinces_menu']);
//		pr( $this->data['provinces'] );

        return View::make($this->data['modules'] . '.provinces', ['data' => $this->data]);
    }

    public function getProvince($provinceId)
    {
        $this->data['provinceId'] = $provinceId;

        $cities = City::where('province_id', $provinceId)->lists('name', 'id');

        $calls = DB::table('visit')->whereRaw("DATE(date) between '".$this->data['startDate']."' and '".$this->data['endDate']."'");

        if (!$this->data['user']->is('admin')) {
            $calls = $calls->whereIn('user_id', $this->data['userChildren']);
        }


        $calls = $calls->join('customer', 'visit.customer_id', '=', 'customer.id')
            ->where('customer.city_id', '!=', 0)
            ->where('customer.province_id', $provinceId)
            ->get(['customer.city_id']);

        $this->data['countCalls'] = count($calls);
        $this->data['provinces_menu'] = [];
        $this->data['provinces'] = [];

        $calls = arrayGroupBy($calls, 'city_id');
        $x = 0;
        $i = 0;
        foreach ($calls as $cityId => $cityVisits) {
            $cityVisits = count($cityVisits);

            if (isset($cities[$cityId])) {
                $citiesMenu[$cityId] = $cities[$cityId] . ': ' . $cityVisits;
                $i++;

                if ($i == 10 || $i == 20 || $i == 30 || $i == 40) {
                    $x++;
                }
                $this->data['cities'][$x][$cities[$cityId]] = $cityVisits;
            }
        }
//        return $cities;
//        return $this->data['cities'];
        foreach ($cities as $id => $name) {
            if (isset($citiesMenu[$id])) {
                $this->data['cities_menu'][$id] = $name . ': ' . $citiesMenu[$id];

            } else {
                $this->data['cities_menu'][$id] = $name . ': 0';
            }

        }

        $provinceIds = Province::userProvinces($this->data['userChildren']);
        $provinces = Province::select('name', 'id');
        if (!$this->data['user']->is('admin')) {
            $provinces = $provinces->whereIn('id', $provinceIds);
        }
        $provinces = $provinces->lists('name', 'id');


        $calls = DB::table('visit')->whereRaw("DATE(date) between '".$this->data['startDate']."' and '".$this->data['endDate']."'");

        if (!$this->data['user']->is('admin')) {
            $calls = $calls->whereIn('user_id', $this->data['userChildren']);
        }


        $calls = $calls->join('customer', 'visit.customer_id', '=', 'customer.id')
            ->where('customer.province_id', '!=', 0)
            ->get(['customer.province_id']);
        $calls = arrayGroupBy($calls, 'province_id');
        foreach ($calls as $provinceId => $provinceVisits) {
            $provinceVisits = count($provinceVisits);

            if (isset($provinces[$provinceId])) {
                $provincesMenu[$provinceId] = $provinces[$provinceId] . ': ' . $provinceVisits;
            }
        }

        foreach ($provinces as $id => $name) {
            if (isset($provincesMenu[$id])) {
                $this->data['provinces_menu'][$id] = $provincesMenu[$id];

            } else {
                $this->data['provinces_menu'][$id] = $name . ': 0';
            }

        }

        return View::make($this->data['modules'] . '.province', ['data' => $this->data]);
    }

    public function getCity($provinceId, $cityId)
    {
        $this->data['provinceId'] = $provinceId;
        $this->data['cityId'] = $cityId;
        $cities = City::where('province_id', $provinceId)->lists('name', 'id');


        $calls = DB::table('visit')->whereRaw("DATE(date) between '".$this->data['startDate']."' and '".$this->data['endDate']."'");

        if (!$this->data['user']->is('admin')) {
            $calls = $calls->whereIn('user_id', $this->data['userChildren']);
        }

        $calls = $calls->join('customer', 'visit.customer_id', '=', 'customer.id')
            ->where('customer.province_id', $provinceId)
            ->where('customer.city_id', '!=', 0)
            ->get(['customer.city_id']);

        $calls = arrayGroupBy($calls, 'city_id');
        $this->data['cities_menu'] = [];
        foreach ($calls as $cityId => $cityVisits) {
            $cityVisits = count($cityVisits);

            if (isset($cities[$cityId])) {
                $citiesMenu[$cityId] = $cities[$cityId] . ': ' . $cityVisits;
            }
        }

        foreach ($cities as $id => $name) {
            if (isset($citiesMenu[$id])) {
                $this->data['cities_menu'][$id] = $citiesMenu[$id];

            } else {
                $this->data['cities_menu'][$id] = $name . ': 0';
            }

        }

        $areas = Area::where('city_id', $cityId)->lists('name', 'id');
        $calls = DB::table('visit')->whereRaw("DATE(date) between '".$this->data['startDate']."' and '".$this->data['endDate']."'");

        if (!$this->data['user']->is('admin')) {
            $calls = $calls->whereIn('user_id', $this->data['userChildren']);
        }


        $calls = $calls->join('customer', 'visit.customer_id', '=', 'customer.id')
            ->where('customer.city_id', $cityId)
            ->where('customer.area_id', '!=', 0)
            ->get(['customer.area_id']);
//        pr($calls);

        $this->data['countCalls'] = count($calls);
        $this->data['provinces_menu'] = [];
        $this->data['provinces'] = [];

        $calls = arrayGroupBy($calls, 'area_id');
        $x = 0;
        $i = 0;
        foreach ($calls as $areaId => $areaVisits) {
            $areaVisits = count($areaVisits);

            if (isset($areas[$areaId])) {
                $this->data['areas_menu'][$areaId] = $areas[$areaId] . ': ' . $areaVisits;
                $i++;

                if ($i == 10 || $i == 20 || $i == 30 || $i == 40) {
                    $x++;
                }
                $this->data['areas'][$x][$areas[$areaId]] = $areaVisits;
            }
        }

//		return $this->data['areas'];
        return View::make($this->data['modules'] . '.city', ['data' => $this->data]);
    }

    public function getAccumulative($provinceId = null)
    {

        if (Input::has('getRepsDetails')) {

            $sql = "select distinct `user_id` from `comment` where type=1";
            if (!$this->data['user']->is('admin')) {
                $sql .= " AND `user_id` IN (" . toString($this->data['userChildren']) . ")";
            }

            $data['comments'] = DB::select($sql);


            $sql = "select `user_id`, count(*) AS `calls`
                    from `visit`
                    WHERE DATE(`visit`.`date`) BETWEEN '{$this->data['startDate']}' and '{$this->data['endDate']}'";
            if (!$this->data['user']->is('admin')) {
                $sql .= " and `visit`.`user_id` in (" . toString($this->data['userChildren']) . ")";
            }
            $sql .= "GROUP BY `user_id`, `customer_id`, date";

            $visits = DB::select($sql);

            $visits = arrayGroupBy($visits, 'user_id');

            foreach ($visits as $userId => $userVisits) {
                $data['repsData'][$userId]['visits'] = count($userVisits);

                foreach ($userVisits as $userVisit) {
                    $data['repsData'][$userId]['calls'] += $userVisit->calls;
                }

            }

            return $data;
        }

        if (Input::has('getUserComments')) {
            $result = Comment::where('type', 1)->where('user_id', Input::get('getUserComments'))->get(['comment', 'date']);
            $comments = '';
            foreach ($result as $comment) {
                $comments .= '<b>' . $comment->comment . '</b> on ' . $comment->date . '<br>';
            }
            return $comments;
        }


        $this->data['provinceId'] = $provinceId;

        $provinceIds = Province::userProvinces($this->data['userChildren']);

        $provinces = Province::select('name', 'id');
        if (!$this->data['user']->is('admin')) {
            $provinces = $provinces->whereIn('id', $provinceIds);
        }
        $this->data['provinces'] = $provinces->lists('name', 'id');

        $this->data['provinceId'] = $provinceId;

        if ($provinceId==null)
        {
          $provinceId = 'province_id';
          $this->data['provinceId'] = "0";
        }
        if ($provinceId != null) {

            $sql = "SELECT user.id, user.fullname from user
            LEFT JOIN role_user on user.id = role_user.user_id
            WHERE province_id=$provinceId AND (role_user.role_id=3 OR user.id in (10, 14))";

            if (!$this->data['user']->is('admin')) {
                $sql .= " and `user`.`id` in (" . toString($this->data['userChildren']) . ")";
            }

            $this->data['reps'] = DB::select($sql);
//            pr($this->data['reps']);


        }

        return View::make($this->data['modules'] . '.accumlative', ['data' => $this->data]);
    }

    public function postSubmitComment()
    {
        $input = Input::all();

        if (Comment::create($input)) {
            return 'success';
        }

    }

    public function getAccumulativeDetails($userId)
    {
        if (!$this->data['user']->is('admin') && !in_array($userId, $this->data['userChildren'])) {
            return '';
        }

        if (Input::has('type')) {

            $visited = [];
            switch (Input::get('type')) {
                case 'doctors':
                    $data['areas'] = json_encode(Area::lists('name', 'id'));

                    $sql = "SELECT DISTINCT `customer`.`id` as customer_id, `name`, `speciality`, `grade`,`customer`.`area_id`,
                                            MONTH (`visit`.`date`) as month, DAY (`visit`.`date`) as day,
											WEEK(`visit`.`date`, 5) - WEEK(DATE_SUB(`visit`.`date`, INTERVAL DAYOFMONTH(`visit`.`date`) - 1 DAY), 5) + 1 as week
											FROM `doctor`
											JOIN `visit`
											ON `visit`.`customer_id`=`doctor`.`customer_id`
											JOIN `customer`
											ON `customer`.`id`=`doctor`.`customer_id`
											WHERE `visit`.`user_id`=$userId
											AND DATE(`visit`.`date`) BETWEEN '{$this->data['startDate']}' and '{$this->data['endDate']}'";
                    $visits = DB::select($sql);
                    $visits = arrayGroupBy($visits, 'customer_id'); // group by customer to prevent repeating
                    foreach($visits as $customerId=>$customerVisits){
                        $visitsDetails = [];
                        // collect customer Visits
                        $n_visits = 0;
                        foreach($customerVisits as $visit){
                            $visitsDetails[] = array(
                                'month'=>$visit->month,
                                'day'=>$visit->day,
                                'week'=>$visit->week,
                            );
                            $n_visits++;
                        }

                        switch ($n_visits) {
                      		case 0:
                      			$n_visits = "None";
                      			break;
                      		case 1:
                      			$n_visits = "Once";
                      			break;
                      		case 2:
                      			$n_visits = "Twice";
                      			break;
                      		case ($n_visits > 2 && $n_visits < 10):
                      			$n_visits = "High";
                      			break;
                      		case ($n_visits >= 10):
                      			$n_visits = "Very Active";
                      			break;
                      	}

                        $visited[] = array(
                            'customer_id'=>$customerId,
                            'name'=>$customerVisits[0]->name,
                            'grade'=>$customerVisits[0]->grade,
                            'speciality'=>$customerVisits[0]->speciality,
                            'area_id'=>$customerVisits[0]->area_id,
                            'n_visits'=>$n_visits,
                            'visits'=>$visitsDetails
                        );

                    }

                    $sql = "SELECT `customer`.`id` as customer_id, `name`, `speciality`, `grade`,`customer`.`area_id`
                            FROM `doctor`
                            JOIN `customer` ON `customer`.`id`=`doctor`.`customer_id`
                            JOIN `user_customer` ON `user_customer`.`customer_id`=`doctor`.`customer_id`
                            WHERE `user_customer`.`user_id`=$userId
                            AND `doctor`.`customer_id` NOT IN (SELECT DISTINCT `customer_id` from `visit`
                                                      WHERE user_id=$userId
                                                      AND DATE(`visit`.`date`) BETWEEN '{$this->data['startDate']}' and '{$this->data['endDate']}')";
                    $nonVisited = DB::select($sql);
                    $data['doctors'] = array_merge($visited,$nonVisited);

                    break;
                case 'hospitals':
                    $sql = "SELECT `customer`.`id` as customer_id, `name`, `grade`,`customer`.`area_id`, MONTH (`visit`.`date`) as month, DAY (`visit`.`date`) as day,
											WEEK(`visit`.`date`, 5) - WEEK(DATE_SUB(`visit`.`date`, INTERVAL DAYOFMONTH(`visit`.`date`) - 1 DAY), 5) + 1 as week
											FROM `hospital`
											JOIN `visit`
											ON `visit`.`customer_id`=`hospital`.`customer_id`
											JOIN `customer`
											ON `customer`.`id`=`hospital`.`customer_id`
											WHERE `visit`.`user_id`=$userId
											AND DATE(`visit`.`date`) BETWEEN '{$this->data['startDate']}' and '{$this->data['endDate']}'";


                    $visits = DB::select($sql);
                    $visits = arrayGroupBy($visits, 'customer_id'); // group by customer to prevent repeating

                    foreach($visits as $customerId=>$customerVisits){
                        $visitsDetails = [];
                        // collect customer Visits
                        foreach($customerVisits as $visit){
                            $visitsDetails[] = array(
                                'month'=>$visit->month,
                                'day'=>$visit->day,
                                'week'=>$visit->week,
                            );
                        }
                        $visited[] = array(
                            'customer_id'=>$customerId,
                            'name'=>$customerVisits[0]->name,
                            'class'=>$customerVisits[0]->class,
                            'area_id'=>$customerVisits[0]->area_id,
                            'visits'=>$visitsDetails
                        );

                    }

                    $sql = "SELECT `customer`.`id` as customer_id, `name`, `grade`,`customer`.`area_id`
                            FROM `hospital`
                            JOIN `customer` ON `customer`.`id`=`hospital`.`customer_id`
                            JOIN `user_customer` ON `user_customer`.`customer_id`=`hospital`.`customer_id`
                            WHERE `user_customer`.`user_id`=$userId
                            AND `customer`.`id` NOT IN (SELECT DISTINCT `customer_id` from `visit`
                                                      WHERE user_id=$userId
                                                      AND DATE(`visit`.`date`) BETWEEN '{$this->data['startDate']}' and '{$this->data['endDate']}')";
                    $nonVisited = DB::select($sql);
                    $data['hospitals'] = array_merge($visited,$nonVisited);
                    break;
                case 'pharms':

                    $sql = "SELECT distinct `customer`.`id` as customer_id, `name`, `class`,`customer`.`area_id`,
                                            MONTH (`visit`.`date`) as month,
                                            DAY (`visit`.`date`) as day,
											WEEK(`visit`.`date`, 5) - WEEK(DATE_SUB(`visit`.`date`, INTERVAL DAYOFMONTH(`visit`.`date`) - 1 DAY), 5) + 1 as week
											FROM `pharmacy`
											JOIN `user_customer`
											ON `user_customer`.`customer_id`=`pharmacy`.`customer_id`
											JOIN `visit`
											ON `visit`.`customer_id`=`pharmacy`.`customer_id`
											JOIN `customer`
											ON `customer`.`id`=`pharmacy`.`customer_id`
											WHERE `user_customer`.`user_id`=$userId
                      AND visit.user_id =$userId
											AND DATE(`visit`.`date`) BETWEEN '{$this->data['startDate']}' and '{$this->data['endDate']}'";
                    $visits = DB::select($sql);
                    $visits = arrayGroupBy($visits, 'customer_id'); // group by customer to prevent repeating

                    foreach($visits as $customerId=>$customerVisits){
                        $visitsDetails = [];
                        // collect customer Visits
                        $n_visits = 0;
                        foreach($customerVisits as $visit){
                            $visitsDetails[] = array(
                                'month'=>$visit->month,
                                'day'=>$visit->day,
                                'week'=>$visit->week,
                            );
                            $n_visits++;
                        }

                        switch ($n_visits) {
                      		case 0:
                      			$n_visits = "None";
                      			break;
                      		case 1:
                      			$n_visits = "Once";
                      			break;
                      		case 2:
                      			$n_visits = "Twice";
                      			break;
                      		case ($n_visits > 2 && $n_visits < 10):
                      			$n_visits = "High";
                      			break;
                      		case ($n_visits >= 10):
                      			$n_visits = "Very Active";
                      			break;
                      	}

                        $visited[] = array(
                            'customer_id'=>$customerId,
                            'name'=>$customerVisits[0]->name,
                            'class'=>$customerVisits[0]->class,
                            'area_id'=>$customerVisits[0]->area_id,
                            'n_visits'=>$n_visits,
                            'visits'=>$visitsDetails
                        );

                    }

                    $sql = "SELECT `customer`.`id` as customer_id, `name`, `class`,`customer`.`area_id`,`customer`.`id`,`user_customer`.`user_id`
                            FROM `pharmacy`
                            JOIN `customer` ON `customer`.`id`=`pharmacy`.`customer_id`
                            JOIN `user_customer` ON `user_customer`.`customer_id`=`pharmacy`.`customer_id`
                            WHERE `user_customer`.`user_id`=$userId
                            AND `customer`.`id` NOT IN (SELECT DISTINCT `customer_id` from `visit`
                                                      WHERE user_id=$userId
                                                      AND DATE(`visit`.`date`) BETWEEN '{$this->data['startDate']}' and '{$this->data['endDate']}')";
                    $nonVisited = DB::select($sql);
                    $data['pharms'] = array_merge($visited,$nonVisited);
                    break;

                case 'workshops':

                    $sql = "SELECT *,product.name as product_name,doctor.name as doctor_name from workshop
                    JOIN doctor on workshop.customer_id = doctor.customer_id
                    JOIN product on workshop.product_id=product.id
                    Where workshop.user_id ={$userId}
                    AND DATE(workshop.workshop_date) BETWEEN '{$this->data['startDate']}' and '{$this->data['endDate']}'";
                    $workshops = DB::select($sql);
                    $data['workshops'] = $workshops;
                    break;

                case 'promoters':

                    $sql = "SELECT *,productp.name as product_name,productp_cat.name as cat from promoter
                    JOIN productp on promoter.productp_id=productp.id
                    Join productp_cat on productp.cat = productp_cat.id
                    Where promoter.user_id ={$userId}
                    AND DATE(promoter.date) BETWEEN '{$this->data['startDate']}' and '{$this->data['endDate']}'
                    Order By Date desc";
                    $promoters = DB::select($sql);
                    $data['promoters'] = $promoters;
                    break;

                case "sumreport":
                    $sql = "SELECT
                            COALESCE(sum(case when type=1 then 1 end), 0) as doctors,
                            COALESCE(sum(case when type=2 then 1 end), 0) as phs,
                            COALESCE(sum(case when type='w' then 1 end), 0) as workshops
                            FROM
                            (select visit.user_id, visit.date, customer.type from visit join customer on visit.customer_id=customer.id
                            UNION ALL SELECT workshop.user_id, workshop.workshop_date as date , 'w' as type from workshop) t
                            where t.user_id={$userId}
                            AND DATE(t.date) BETWEEN '{$this->data['startDate']}' and '{$this->data['endDate']}'";
                    $data['sumreportOverall'] = DB::select($sql);

                    $sql = "SELECT count(doctor.id) as num, doctor.speciality as spec from user_customer
                    Join doctor on user_customer.customer_id=doctor.customer_id
                    Where user_customer.user_id={$userId}
                    Group by doctor.speciality";
                    $sumreport = DB::select($sql);
                    $data['sumreport'] = $sumreport;

                    $sql = "SELECT count(doctor.id) as total from user_customer
                    Join doctor on user_customer.customer_id=doctor.customer_id
                    Where user_customer.user_id={$userId}";
                    $sumreportTotal = DB::select($sql);
                    $data['sumreportTotal'] = $sumreportTotal;
                    break;
            }

            return $data;
        }

        $this->data['userId'] = $userId;
        $this->data['userData'] = UserModel::find($userId, ['id', 'fullname']);

        $start = new DateTime($this->data['startDate']);
        $end = new DateTime($this->data['endDate']);
        $interval = DateInterval::createFromDateString('1 month');
        $period = new DatePeriod($start, $interval, $end);
        $this->data['months'] = [];
        foreach ($period as $dt) {
            $this->data['months'][$dt->format("n")] = $dt->format("M Y");
        }

        $lastMonth = date('n', strtotime($this->data['endDate']));
        if (!isset($this->data['months'][$lastMonth])) {
            $this->data['months'][$lastMonth] = date('M Y', strtotime($this->data['endDate']));
        }


        if(UserRole::where('user_id', $userId)->get(['role_id'])[0]->role_id == 10){
            $this->data['IsPromoter'] = true;
        }

        return View::make($this->data['modules'] . '.accumlative_details', ['data' => $this->data]);
    }

    public function getInterval($provinceId = null, $userId = null)
    {

        $provinceIds = Province::userProvinces($this->data['userChildren']);
        $provinces = Province::select('name', 'id');
        if (!$this->data['user']->is('admin')) {
            $provinces = $provinces->whereIn('id', $provinceIds);
        }
        $this->data['provinces'] = $provinces->lists('name', 'id');

        $this->data['provinceId'] = $provinceId;

        if ($userId != null) {
            // Show the interval page for this user

            $this->data['provinceId'] = $provinceId;
            $this->data['userId'] = $userId;

            $this->data['totalDoctorsVisit'] = 0;

            $sql = "SELECT DATE (`visit`.`date`) as day
											FROM `visit`
											JOIN `customer`
											ON `visit`.`customer_id`=`customer`.`id`
											WHERE `visit`.`user_id`=$userId
											AND `customer`.`type`=1
											AND `visit`.`date` >='" . db_date($this->data['startDate']) . "'
											AND `visit`.`date`<='" . db_date($this->data['endDate']) . "'";

            if (!$this->data['user']->is('admin')) {
                $sql .= " and `visit`.`user_id` in (" . toString($this->data['userChildren']) . ")";
            }

            $doctors_visit = DB::select($sql);
            $doctors_visit = arrayGroupBy($doctors_visit, 'day');
            foreach ($doctors_visit as $date => $visits) {
                $doctors_visit_count = count($visits);
                $this->data['totalDoctorsVisit'] += $doctors_visit_count;
                $this->data['doctors_visit'][$date] = $doctors_visit_count;
            }


            /*
                        $this->data['totalHospitalsVisit'] = 0;
                        $hospitals_visit = DB::select("SELECT DATE (`visit`.`date`) as day
                                                        FROM `visit`
                                                        JOIN `customer`
                                                        ON `visit`.`customer_id`=`customer`.`id`
                                                        WHERE `visit`.`user_id`=$userId
                                                        AND `customer`.`type`=2
                                                        AND `visit`.`date` >='" . db_date($this->data['startDate']) . "'
                                                        AND `visit`.`date`<='" . db_date($this->data['endDate']) . "'");
                        $hospitals_visit = arrayGroupBy($hospitals_visit, 'day');
                        foreach ($hospitals_visit as $date => $visits) {
                            $hospitals_visit_count = count($visits);
                            $this->data['totalHospitalsVisit'] += $hospitals_visit_count;
                            $this->data['hospitals_visit'][date6($date)] = $hospitals_visit_count;
                        }
            */


            return View::make($this->data['modules'] . '.interval_user', ['data' => $this->data]);


        } else if ($userId == null && $provinceId != null) {
            // show users under this province

            $this->data['provinceId'] = $provinceId;
            $reps = UserModel::where('province_id', $provinceId)->where('role_user.role_id', 3)
                ->leftJoin('role_user', 'user.id', '=', 'role_user.user_id');

            if (!$this->data['user']->is('admin')) {
                $reps = $reps->whereIn('user.id', $this->data['userChildren']);
            }

            $this->data['reps'] = $reps->get(['user.id', 'fullname']);

        }

//	return $this->data['reps'];

        return View::make($this->data['modules'] . '.interval', ['data' => $this->data]);
    }


}
