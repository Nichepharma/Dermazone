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
        $this->data['page_title'] = 'All Customers';

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

        if(UserRole::where('user_id', $this->data['user']->id)->get(['role_id'])[0]->role_id == 6){
          $this->data['canImport'] = true;
        }else {
          $this->data['canImport'] = false;
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
        $this->data['page_title'] = 'Doctor: '.$this->data['record']->name;

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
        $this->data['page_title'] = 'Pharmacy: '.$this->data['record']->name;

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
        //$this->data['visitSlides'] = VisitSlide::where('visit_id',$id)->get();

        $slides = ProductSlide::where('product_id', $this->data['visit']->product_id)->lists('cat', 'num');
        $calls = DB::table('visit')->where('visit.id' , $id)
        ->join('visit_slide', 'visit.id' , '=', 'visit_slide.visit_id')
        ->get(['visit_slide.time', 'visit_slide.slide_id']);

        $this->data['slides']['corrector'] = 0;
        foreach (arrayGroupBy($calls, 'slide_id') as $slideId => $slideVisits) {
            $total_duration = 0;
            foreach ($slideVisits as $slideVisit) {
              $total_duration += $slideVisit->time;
            }
            if (isset($slides[$slideId])) {
                $this->data['slides'][$slides[$slideId]] += $total_duration;
            }
        }
        //return $this->data['slides'];

        $this->data['slides'];
        $this->data['customer'] = Customer::find($this->data['visit']->customer_id);
        $this->data['area'] = Area::find($this->data['customer']->area_id);
//        return $this->data['customer'];

        switch ($this->data['customer']->type) {
            case 1:
                $this->data['doctor'] = Doctor::where('customer_id',$this->data['customer']->id)->first();
                $this->data['page_title'] = 'Visit for Doctor: '.$this->data['record']->name;
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
                        $speciality = trim(modifySpec($importedItem['speciality']));
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

function modifySpec($sp){
 //if there is a dots abbrevations remove them

 if (strpos($sp,'.') !== false){
  $sp = str_replace(".", "", $sp);

 }
 if(stripos($sp, 'res') === 0){
      $sp = str_replace("res", "", $sp);
 }
 if(stripos($sp, 'reg') === 0){
      $sp = str_replace("reg", "", $sp);
 }
  $sp = trim($sp);

 // check thta or is on the beginning of the string
if(stripos($sp, 'or') === 0){
return "ORS";
}
elseif(stripos($a,'code') !== false ){
return "NO CODE";
}
elseif(stripos($sp, 'u') === 0){
return "U";
}

elseif(stripos($sp, 's') === 0 || stripos($sp, 'gs') === 0 || (stripos($sp, 'g') === 0 && stripos($sp, 'su') !== false)) {
return "S";
}
elseif(stripos($sp, 'gy') === 0 || stripos($sp, 'ob') === 0){
return "GYN";
}
elseif(stripos($sp, 'PU') === 0 || stripos($sp, 'ch') === 0 || stripos($sp, 'resp') === 0 || stripos($sp, 'Pn') === 0 ){
return "PUD";
}
 elseif(stripos($sp, 'family') !== false || stripos($sp, 'F') === 0){
return "FP";
}
elseif(stripos($sp, 'ent') === 0 || stripos($sp, 'e n') === 0 || stripos($sp, 'ear') === 0 || stripos($sp, 'ORT') === 0 || stripos($sp, 'OTo') === 0){
return "ENT";
}

elseif(stripos($sp, 'Den') !== false || stripos($sp, 'oral') !== false || stripos($sp, 'dont') !== false || stripos($sp, 'Dn') === 0){
return "DEN";
}

// general practitioner
//
elseif(stripos($sp, "gp") === 0 || stripos($sp, "gb") === 0 ||(stripos($sp, 'gener') !== false && (stripos($sp, 's') === false || stripos($sp, 'phys') !== false || stripos($sp, 'scop') !== false))){
return "GP";
}
// internal medicine
elseif(stripos($sp, 'im') === 0 || stripos($sp, 'int') !== false){
return "IM";
}
elseif(stripos($sp, 'Rh') === 0 || stripos($sp, 'Ru') === 0){
return "RHU";
}

elseif(stripos($sp, 'PD') !== false || stripos($sp, 'Ped') === 0 || stripos($sp, "paed") === 0|| stripos($sp, "pead") === 0){
return "PD";
}

//check there is  no overlapping with immunity
//infection disease

 elseif(stripos($sp, 'i') === 0 && stripos($sp, 'im') == false && stripos($sp, 'ig') == false &&  stripos($sp, 'int') == false && stripos($sp, 'ic') == false){
return "ID";
}
// no overlapping with NS
//neuro

elseif(stripos($sp, 'N') === 0 && stripos($sp, 'sur') == false && stripos($sp, 'Ns') !== 0 && stripos($sp, 'nep') !== 0){
return "N";
}

 elseif(stripos($sp, "ns") === 0||(stripos($sp, 'N') === 0 && stripos($sp, 'sur') !== false) ){
return "NS";
}
 elseif(stripos($sp, 'end') === 0 ){
return "END";
}
 elseif(stripos($sp, 'an') === 0 ){
return "AN";
}
 elseif(stripos($sp, 'cc') === 0 || stripos($sp, 'care') !== false || stripos($sp, 'ic') === 0){
return "CCU";
}
elseif(stripos($sp, 'car') === 0 || stripos($sp, 'CD') === 0 || stripos($sp, 'crd') === 0){
return "CD";
}
elseif(strcasecmp($sp, "ntr") == 0|| stripos($sp, 'nu') === 0 || stripos($sp, 'diet') !== false){
return "NTR";
}
elseif(strcasecmp($sp, "ge") == 0 || stripos($sp, 'Ga') === 0 || stripos($sp, 'GIT') !== false || strcasecmp($sp, "gi") == 0 ){
return "GE";
}
//immunity
 elseif(strcasecmp($sp, "ig") == 0 || stripos($sp, 'imm') === 0 ){
return "IG";
}
 elseif(stripos($sp, 'dia') === 0 ){
return "DIA";
}
//plastic surgeon
elseif(strcasecmp($sp, "ps") == 0 || stripos($sp, 'PL') === 0 || stripos($sp, 'cos') === 0){
return "PS";
}
elseif(stripos($sp, 'OP') === 0 ){
return "OPH";
}
elseif(strcasecmp($sp, "vs") == 0 ||  (stripos($sp, 'v') === 0 &&  stripos($sp, 'sur') !== false )){
return "VS";
}
elseif(strcasecmp($sp, "v") == 0 ||  (stripos($sp, 'v') === 0 &&  stripos($sp, 'sur') == false )){
return "V";
}
elseif(stripos($sp, 'em') === 0 || strcasecmp($sp, "er") == 0 ){
return "EM";
}
elseif(stripos($sp, 'nep') === 0 ){
return "NEP";
}
//psychiatric
 elseif(strcasecmp($sp, "p") == 0 ||  stripos($sp, 'psy') === 0 ){
return "P";
}
 elseif(stripos($sp, 'ph') === 0 ){
return "PH";
}
  elseif(strcasecmp($sp, "D") == 0 || stripos($sp, 'Der') !== false || strcasecmp($sp, "Dr") == 0 ){
return "D";
}
// we did write in on database
else  if(stripos($sp, 'tr') === 0){
return "TRS";
}
  else  if(stripos($sp, 'h') === 0){
return "HEM";
}

 else  if(stripos($sp, 'micro') === 0 || strcasecmp($sp, "mm") == 0 ){
return "MM";
}
 elseif(stripos($sp, 'on') === 0 ){
return "ON";
}
 elseif(stripos($sp, 'med') === 0 ){
return "MED";
}
else
 return "No Code";

}
