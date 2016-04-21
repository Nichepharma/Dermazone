<?php
//namespace App\Http\Controllers;
use Illuminate\Support\Facades\Request;

function ireturn($str, $msg = ""){
  if($msg != "" ){return "{\"data\":[{\"msg\":\"{$msg}\"}]}";}
  return "{\"data\":" .  $str . "}";
}

class DatalinkController extends BaseController
{
    protected $model;
    protected $my_model;
    protected $data;

    public function __construct(Customer $model)
    {
        parent::__construct();
        $this->forgetBeforeFilter('auth');
        $this->model = $model;
        $this->my_model = 'Datalink';
    }

    public function index(){
      $action = Input::get('action');
      $data_iOS = json_decode(Input::get('data'));

      //Saving Latest Request
      $myfile = fopen("local/app/controllers/latest.txt", "w");
      $txt = Input::get('action');
      fwrite($myfile, $txt);
      $txt = Input::get('data');
      fwrite($myfile, $txt);
      fclose($myfile);

      switch ($action) {
        case 'login':
          $iOS_user = $data_iOS->user;
          $iOS_pass = $data_iOS->pass;

          $response = UserModel::where(['username' => $iOS_user, 'pass' => $iOS_pass])->get(['id']);
          if ($response->count()){
            return ireturn(json_encode($response));;
          }else {
            return ireturn("[{\"id\":\"invalid\"}]");
          }

        case 'get_doctors':
          $customers = DB::table('user_customer')->where('user_id' , $data_iOS->rep_id)
          ->join('customer', 'user_customer.customer_id', '=', 'customer.id')
          ->join('doctor', 'customer.id', '=', 'doctor.customer_id')
          //->join('city', 'customer.city_id', '=', 'city.id')
          ->select('customer.id' , 'doctor.name' , 'doctor.speciality' , 'doctor.center')
          ->get();
          //full
          //{"id":"1","user_id":"2","customer_id":"1","type":"1","province_id":"1","city_id":"1","area_id":"0","created_at":"2016-04-06 05:12:23","updated_at":"2016-04-06 05:12:23","name":"Anas Gobran","speciality":"Purchaser","grade":"B","address":null,"phone":null,"email":null,"center":"Medica  Center ","best_time":null},
          return ireturn(json_encode($customers));

          case 'get_phs':
            $customers = DB::table('user_customer')->where('user_id' , $data_iOS->rep_id)
            ->join('customer', 'user_customer.customer_id', '=', 'customer.id')
            ->join('pharmacy', 'customer.id', '=', 'pharmacy.customer_id')
            //->join('city', 'customer.city_id', '=', 'city.id')
            ->select('customer.id' , 'pharmacy.name' , 'pharmacy.center')
            ->get();
            //full
            //{"id":"1","user_id":"2","customer_id":"1","type":"1","province_id":"1","city_id":"1","area_id":"0","created_at":"2016-04-06 05:12:23","updated_at":"2016-04-06 05:12:23","name":"Anas Gobran","speciality":"Purchaser","grade":"B","address":null,"phone":null,"email":null,"center":"Medica  Center ","best_time":null},
            return ireturn(json_encode($customers));

          case 'get_messages':
            $sql = "SELECT message.id as msgid, message.message as msg, user.fullname as Sender, message.date as noti_Date
              FROM message
              Join user on user.id = message.sender_id
              WHERE receiver_id={$data_iOS->rep_id}
              AND expiration_date > " . date('Y-m-d');
            //return $sql;
            $messages = DB::select($sql);
            return ireturn(json_encode($messages));

          case 'get_plan_init':
            $sql = "SELECT customer.id,customer.type, IFNULL(lv.lastvisit , 'No Visits') as lastvisit from user_customer
            JOIN customer on user_customer.customer_id=customer.id
            LEFT JOIN (select customer_id,max(date) as lastvisit from visit where user_id={$data_iOS->rep_id} group by customer_id) lv on customer.id=lv.customer_id
            WHERE user_id={$data_iOS->rep_id}";
            $results = DB::select($sql);
            return ireturn(json_encode($results));

        case 'insert_workshop':
          $workshop = new Workshop;
          $workshop->user_id = $data_iOS->user_id;

          $workshop->customer_id = $data_iOS->customer_id;
          $workshop_customers = explode("|", $data_iOS->customer_id);

          //Getting Current workshop ID
          $workshop_id = DB::select("SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '" . Config::get('database.connections.mysql.database')  . "' AND TABLE_NAME = 'workshop'");
          $workshop_id = $workshop_id[0]->AUTO_INCREMENT;

          foreach ($workshop_customers as $workshop_customer) {
            $workshopcustomer = new WorkshopCustomer;
            $workshopcustomer->workshop_id = $workshop_id;
            $workshopcustomer->customer_id = $workshop_customer;
            $workshopcustomer->save();
          }

          $workshop->workshop_date = date("Y-m-d H:i:s", strtotime($data_iOS->workshop_date));
          $workshop->samples = $data_iOS->sample;
          $workshop->product_id = $data_iOS->product_id;
          $workshop->subcat = $data_iOS->subcat;
          $workshop->comment = $data_iOS->comment;
          $workshop->save();
          return ireturn("", $data_iOS->workshop_date);

        case 'insert_visit':
          $visit = new Visit;
          $visit->user_id = $data_iOS->user_id;

          $visit->customer_id = $data_iOS->customer_id;
          $visit_customers = explode("|", $data_iOS->customer_id);
          $acc_times = explode("|", $data_iOS->acc);

          //Getting Current Visit ID
          $visit_id = DB::select("SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '" . Config::get('database.connections.mysql.database')  . "' AND TABLE_NAME = 'visit'");
          $visit_id = $visit_id[0]->AUTO_INCREMENT;

          foreach ($visit_customers as $visit_customer) {
            $visitcustomer = new VisitCustomer;
            $visitcustomer->visit_id = $visit_id;
            $visitcustomer->customer_id = $visit_customer;
            $visitcustomer->save();
          }
          $slide=0;
          foreach ($acc_times as $acc_time) {
            $visitslide = new VisitSlide;
            $visitslide->visit_id = $visit_id;
            $visitslide->slide_id = $slide++;
            $visitslide->product_id = $data_iOS->product_id;
            $visitslide->time = $acc_time;
            $visitslide->save();
          }
          $visit->product_id = $data_iOS->product_id;
          $visit->date = date("Y-m-d H:i:s", strtotime($data_iOS->visit_date));
          $visit->duration = $data_iOS->duration;
          $visit->samples = $data_iOS->sample;
          $visit->device = $data_iOS->device;
          $visit->comment = $data_iOS->comment;
          $visit->save();
          return ireturn("", $data_iOS->visit_date);

        case 'insert_plan':
        $user_id = $data_iOS->user_id;

        //Deleting the previous plan
        $date_start = date('Y-m-1', strtotime('-1 month'));
        $date_end = date('Y-m-t', strtotime('+1 month'));
        DB::table('visit_plan')
        ->where('visit_plan.user_id', $user_id)
        ->where('customer.type', $data_iOS->type)
        ->whereBetween('date', array($date_start, $date_end))
        ->leftJoin('customer', 'visit_plan.customer_id' , '=' , 'customer.id')
        ->delete();

        $customers = explode("|", $data_iOS->customers);
        $dates = explode("|", $data_iOS->dates);
        foreach ($customers as $key => $customer) {
          $visitplan = new VisitPlan;
          $visitplan->user_id = $user_id;
          $visitplan->customer_id = $customer;
          $visitplan->date = $dates[$key];
          $visitplan->save();
        }
        return ireturn("", "saved");

        case 'test':
          return json_encode("4");

        default:
          return "404";
      }
    }

}
