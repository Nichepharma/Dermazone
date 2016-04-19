<?php

class CustomersController extends BaseController
{

    protected $model;
    protected $my_model;
    protected $data;

    public function __construct(Customer $model)
    {
        parent::__construct();
        $this->model = $model;
        $this->my_model = 'Customer';
        $this->data['module'] = 'customer';
        $this->data['modules'] = 'customers';

    }


    public function getIndex()
    {

        if (Input::has('type')) {

            switch (Input::get('type')) {
                case 'doctors':

                    $sql = "SELECT `name`, `speciality`, `grade`, `doctor`.`id`, `doctor`.`customer_id` FROM `doctor` ";

                    if (!$this->data['user']->is('admin')) {
                        $sql .= " join `user_customer`
                                    on `user_customer`.`customer_id`=`doctor`.`customer_id`
                                     where `user_customer`.`user_id` in (" . toString($this->data['userChildren']) . ")";
                    }
//                    pr($sql);
                    $data['doctors'] = DB::select($sql);
                    break;

                case 'hospitals':
                    $sql = "SELECT `name`, `grade`, `hospital`.`id`, `doctor`.`customer_id` FROM `hospital`";
                    if (!$this->data['user']->is('admin')) {
                        $sql .= " join `user_customer`
                                    on `user_customer`.`customer_id`=`hospital`.`customer_id`
                                     where `user_customer`.`user_id` in (" . toString($this->data['userChildren']) . ")";
                    }

                    $data['hospitals'] = DB::select($sql);
                    break;

                case 'pharmacies':
                    $sql = "SELECT `name`, `class`, `pharmacy`.`id`, `pharmacy`.`customer_id` FROM `pharmacy`";
                    if (!$this->data['user']->is('admin')) {
                        $sql .= " join `user_customer`
                                    on `user_customer`.`customer_id`=`pharmacy`.`customer_id`
                                     where `user_customer`.`user_id` in (" . toString($this->data['userChildren']) . ")";
                    }

                    $data['pharmacies'] = DB::select($sql);

                    break;
            }

            return $data;
        }


        return View::make($this->data['modules'] . '.index', ['data' => $this->data]);
    }

    public function getCustomersVisits()
    {
        $sql = "select `customer_id`, count(`customer_id`) as visits
                  from `visit`
                  WHERE DATE(`visit`.`date`) BETWEEN '{$this->data['startDate']}' and '{$this->data['endDate']}'";
        if (!$this->data['user']->is('admin')) {
            $sql .= " and `visit`.`user_id` in (" . toString($this->data['userChildren']) . ")";
        }
        $sql .= "GROUP BY `visit`.`customer_id`";

        $data['visits'] = DB::select($sql);
        return $data;
    }

    public function getDoctor($customerId)
    {
        $this->data['record'] = Doctor::where('customer_id',$customerId)->first();

        $customer = Customer::find($customerId, ['province_id', 'city_id', 'area_id']);
        if (!empty($customer->province_id)) {
            $this->data['recordProvince'] = Province::find($customer->province_id, ['name'])->name;
        }
        if (!empty($customer->city_id)) {
            $this->data['recordCity'] = City::find($customer->city_id, ['name'])->name;
        }
        if (!empty($customer->area_id)) {
            $this->data['recordArea'] = Area::find($customer->area_id, ['name'])->name;
        }

        $customerVisits = DB::select("select *, MONTH (`visit`.`date`) as month from `visit`
                  WHERE `customer_id`=" . $customerId . "
                  AND DATE(`visit`.`date`) BETWEEN '{$this->data['startDate']}' and '{$this->data['endDate']}'");

        $this->data['customerVisits'] = arrayGroupBy($customerVisits,'month');

        return View::make($this->data['modules'] . '.doctor', ['data' => $this->data]);
    }

    public function getPharmacy($customerId)
    {
        $this->data['record'] = Pharmacy::where('customer_id',$customerId)->first();

        $customer = Customer::find($customerId, ['province_id', 'city_id', 'area_id']);
        if (!empty($customer->province_id)) {
            $this->data['recordProvince'] = Province::find($customer->province_id, ['name'])->name;
        }
        if (!empty($customer->city_id)) {
            $this->data['recordCity'] = City::find($customer->city_id, ['name'])->name;
        }
        if (!empty($customer->area_id)) {
            $this->data['recordArea'] = Area::find($customer->area_id, ['name'])->name;
        }

        $customerVisits = DB::select("select *, MONTH (`visit`.`date`) as month from `visit`
                  WHERE `customer_id`=" . $customerId . "
                  AND DATE(`visit`.`date`) BETWEEN '{$this->data['startDate']}' and '{$this->data['endDate']}'");

        $this->data['customerVisits'] = arrayGroupBy($customerVisits,'month');

        return View::make($this->data['modules'] . '.pharmacy', ['data' => $this->data]);
    }

    public function getVisit($id)
    {
        $this->data['visit'] = Visit::find($id);
        $this->data['visitProduct'] = Product::find($this->data['visit']->product_id);
        $this->data['visitRep'] = UserModel::find($this->data['visit']->user_id,['fullname']);
        //$VisitSlide->{'product_id'} = $this->data['visit']->product_id;
        $this->data['visitSlides'] = VisitSlide::where('visit_id',$id)->get();
        //$this->data['visitSlides'] = DB::select("select * from visit_slide");

        $this->data['customer'] = Customer::find($this->data['visit']->customer_id);
        $this->data['area'] = Area::find($this->data['customer']->area_id);
//        return $this->data['customer'];

        switch ($this->data['customer']->type) {
            case 1:
                $this->data['doctor'] = Doctor::where('customer_id',$this->data['customer']->id)->first();
                return View::make($this->data['modules'] . '.doctor_visit', ['data' => $this->data]);
                break;
            case 2:
                $this->data['pharmacy'] = Pharmacy::where('customer_id',$this->data['customer']->id)->first();
//                return $this->data['pharmacy'];
                return View::make($this->data['modules'] . '.pharmacy_visit', ['data' => $this->data]);
                break;
        }
        return $this->data['customer'];

    }

    public function postImport()
    {
        if (Input::hasFile('file') && Input::file('file')->isValid()) {
            $random_name = create_random_name();
            $extension = Input::file('file')->getClientOriginalExtension();

            $file_name = $this->data['modules'] . '-' . $random_name . '.' . $extension;

            if (Input::file('file')->move(public_path() . '/uploads/imports', $file_name)) {

                $path = public_path() . '/uploads/imports/' . $file_name;

                Import::selectSheetsByIndex(0)->load($path, function ($reader) {

//                    pr($reader->noHeading()->toArray());
//                    pr($reader->toArray());

                    foreach ($reader->toArray() as $importedItem) {

                        $provinces = Province::lists('name', 'id');
                        $cities = City::lists('name', 'id');
                        $users = UserModel::lists('fullname', 'id');
                        $speciality = trim($importedItem['speciality']);
                        // check if province exists or insert it
                        if (in_array(trim($importedItem['province']), $provinces)) {
                            $provinceId = array_search(trim($importedItem['province']), $provinces);
                        } else {
                            $provinceId = Province::create(['name' => trim($importedItem['province'])])->id;
                        }

                        // check if city exists or insert it
                        if (in_array(trim($importedItem['city']), $cities)) {
                            $cityId = array_search(trim($importedItem['city']), $cities);
                        } else {
                            $cityId = City::create(['name' => trim($importedItem['city']), 'province_id' => $provinceId])->id;
                        }


                        // check if user exists or insert it
                        if (in_array(trim($importedItem['med_rep']), $users)) {
                            $userId = array_search(trim($importedItem['med_rep']), $users);
                        } else {
                            $userName = UserModel::makeUsername(trim($importedItem['med_rep']));
                            $userId = UserModel::create([
                                'fullname' => trim($importedItem['med_rep']),
                                'username' => $userName,
                                'pass' => $userName . '123456',
                                'province_id' => $provinceId,
                                'city_id' => $cityId
                            ])->id;
                        }

                        $customerName = trim($importedItem['physician_name']);
                        if (empty($customerName)) continue;

                        if ($speciality == 'Pharmacist') {
                            // This is a pharmacy

                            // check if pharmacy exists or insert him
                            $pharmacyData = array(
                                'name' => $customerName,
                                'center' => trim($importedItem['center']),
                                'class' => trim($importedItem['class']),
                            );

                            $pharmacy = Pharmacy::where($pharmacyData)->first(['customer_id']);

                            if ($pharmacy) {
                                $customerId = $pharmacy->customer_id;

                            } else {
                                $customerId = Customer::create(['type' => 2, 'province_id' => $provinceId, 'city_id' => $cityId])->id;
                                $pharmacyData['customer_id'] = $customerId;

                                Pharmacy::create($pharmacyData);
                            }


                        } else {
                            // This is a doctor


                            // check if doctor exists or insert him
                            $doctorData = array(
                                'name' => $customerName,
                                'center' => trim($importedItem['center']),
                                'grade' => trim($importedItem['class']),
                            );


                            $doctor = Doctor::where($doctorData)->first(['customer_id']);

                            if ($doctor) {
                                $customerId = $doctor->customer_id;

                            } else {
                                $customerId = Customer::create(['type' => 1, 'province_id' => $provinceId, 'city_id' => $cityId])->id;
                                $doctorData['customer_id'] = $customerId;
                                $doctorData['speciality'] = $speciality;

                                Doctor::create($doctorData);
                            }


                        }

                        // check if doctor related to user or insert
                        $userCustomerData = ['user_id' => $userId, 'customer_id' => $customerId];
                        $userCustomer = UserCustomer::where($userCustomerData)->first(['customer_id']);
                        if (!$userCustomer) {
                            UserCustomer::create($userCustomerData);
                        }
                    }


                })->get();
            }

            return Redirect::back();
        }


        return View::make($this->data['modules'] . '.import', ['data' => $this->data]);
    }

}
