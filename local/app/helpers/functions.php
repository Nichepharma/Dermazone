<?php

/**
 * @param $date
 * @return null|string
 */
function dateFormat($date)
{
    if ($date != NULL) {
        $dateParts = explode('-', substr($date, 0, 10));
        return $dateParts[1] . '/' . $dateParts[2] . '/' . $dateParts[0];
    } else {
        return null;
    }
}

function pr($ar)
{
    echo '<pre style="text-align: left;direction: ltr;">';
    print_r($ar);
    echo '</pre>';
    exit();
}

function pr2($ar)
{

    echo '<pre style="text-align: left;direction: ltr;">';
    print_r($ar);
    echo '</pre>';
}

function date1($date = null)
{
    if ($date == null) $date = date('Y-m-d H:i:s');
    return date('d M. Y H:i A', strtotime($date));
}

function date2($date = null)
{
    if ($date == null) $date = date('Y-m-d H:i:s');
    return date('Y m d H:i:s', strtotime($date));
}

function db_date($date = null)
{
    if ($date == null)
        return date('Y-m-d H:i:s');

    return date('Y-m-d H:i:s', strtotime($date));
}

function timepicker_date($date = null)
{
    if ($date == null) $date = date('Y-m-d H:i:s');
    return date('Y-m-d h:i a', strtotime($date));
}

function date3($date = null)
{
    if ($date == null) $date = date('Y-m-d H:i:s');
    return date('Y-m-d', strtotime($date));
}

function date4($date = null)
{
    if ($date == null) $date = date('Y-m-d H:i:s');
    return date('d-m-Y h:i A', strtotime($date));
}

function date5($date = null)
{
    if ($date == null) $date = date('Y-m-d H:i:s');
    return date('d-m-Y h:i:s', strtotime($date));
}

function date6($date = null)
{
    if ($date != null) {
        return date('Y,m,d', strtotime($date));
    }
    return '';
}

function date7($date = null)
{
    if ($date != null) {
        return date('l d, M', strtotime($date));
    }
    return '';
}

function addDaytoDate($date, $days)
{

    $date = strtotime("+" . $days . " days", strtotime($date));
    return date("Y-m-d", $date);

}


function record_info($row)
{
    $data = translate('main.created at') . ": " . date3($row->created_at) . "\n";
    $data .= " \n " . translate('main.last updated') . ": " . date3($row->updated_at);

    if (isset($row->created_by)) {
        @$created_by = UserModel::find($row->created_by);
        if (isset($created_by->username)) $data .= " \n" . translate('main.created by') . ": " . $created_by->username;
    }

    if (isset($row->updated_by)) {
        @$updated_by = UserModel::find($row->created_by);
        if (isset($updated_by->username)) $data .= " \n" . translate('main.updated by') . ": " . @$updated_by->username;
    }


    return $data;
}

function record_info2($row)
{
//    pr2($row->toArray());
//    <td class="ltr"><div class="pull-left">{{ date1($user->created_at) }}</div></td>


    $data = "<table class='record-info'>";
    $data .= "<tr>";
    $data .= "<td><strong class='col-sm-5 text-olive'>" . translate('main.created at') . ":</strong> <div class='col-sm-7 ltr text-left'>" . date1($row->created_at) . "</div></td>";
    $data .= "<td><strong class='col-sm-5 text-olive'>" . translate('main.last updated') . ":</strong> <div class='col-sm-7 ltr text-left'>" . date1($row->updated_at) . "</td></tr>";
    $data .= "</tr>";

    $data .= "<tr>";
    $data .= "<td>";
    if (@isset($row['created_by'])) {
        if ($created_by = UserModel::find($row['created_by']))
            $data .= "<strong class='col-sm-5 text-olive'> " . translate('main.created by') . ":</strong> <div class='col-sm-7'>" . $created_by->username . "</div>";
    }
    $data .= "</td>";
    $data .= "<td>";
    if (@isset($row->updated_by)) {
        if ($updated_by = UserModel::find($row['updated_by']))
            $data .= "<strong class='col-sm-5 text-olive'> " . translate('main.updated by') . ":</strong> <div class='col-sm-7'>" . $updated_by->username . "</div>";
    }
    $data .= "</td>";
    $data .= "</tr>";


    $data .= "</table>";


    return $data;
}

function record_info3($row)
{
//    pr2($row->toArray());
    $data = "<div class='row record-ifo'><hr>";
    $data .= "<strong class='col-sm-3'> " . translate('main.created at') . ":</strong> <div class='col-sm-9'>" . date1($row->created_at) . "</div>";
    $data .= "<strong class='col-sm-3'> " . translate('main.last updated') . ":</strong> <div class='col-sm-9'>" . date1($row->updated_at) . "</div>";
    if (@isset($row['created_by'])) {
        $created_by = UserModel::find($row['created_by']);
        $data .= "<strong class='col-sm-3'> " . translate('main.created by') . ":</strong> <div class='col-sm-9'>" . $created_by->username . "</div>";
    }

    if (@isset($row->updated_by)) {
        $updated_by = UserModel::find($row['updated_by']);
        $data .= "<strong class='col-sm-3'> " . translate('main.updated by') . ":</strong> <div class='col-sm-9'>" . $updated_by->username . "</div>";
    }
    $data .= "</div>";


    return $data;
}

function creation_info($row)
{
    $user_do = "";

    if (isset($row->created_by)) {
        $created_by = UserModel::find($row->created_by);
        $user_do .= "<strong class='col-sm-3'> " . translate('main.created by') . ":</strong> <div class='col-sm-9'>" . $created_by->username . "</div>";
    }

    return "<div class='row record-ifo'>
                <strong class='col-sm-3'> " . translate('main.created at') . ":</strong> <div class='col-sm-9'>" . $row->created_at . "</div>
                " . $user_do . "
           </div>";
}

function all_routs()
{
    $routeCollection = Route::getRoutes();
    foreach ($routeCollection as $value) {
        if (strpos($value->getPath(), '/') === false) {
            $routes[$value->getPath()] = $value->getPath();
        }
    }
    return array_except(array_unique($routes), Config::get('shared_routes'));
}


function multiQuery($sql = NULL)
{
    if ($sql) {
        $connections = Config::get('database.connections')['mysql'];
        $connection = mysqli_connect($connections['host'], $connections['username'], $connections['password'], $connections['database']);

        if ($connection) {
            if (mysqli_multi_query($connection, $sql))
                return true;
            else
                return mysqli_error($connection);
        } else {
            return "Connection Failed";
        }
    }
    return false;
}

function create_random_name($length = 15)
{

    $time = time();
    $random = rand(1, 100000);
    $divide = $time / $random;
    $encryption = md5($divide);
    $name_enc = substr($encryption, 0, $length);

    return $name_enc;
}


use Imagine\Image\Box;
use Imagine\Image\ImageInterface;

function create_thumbnail($path, $filename, $extension, $width = 320, $height = 200)
{
    $mode = ImageInterface::THUMBNAIL_OUTBOUND;
    $size = new Box($width, $height);

    $thumbnail = Imagine::open("{$path}/{$filename}.{$extension}")->thumbnail($size, $mode);
    $destination = "{$filename}.{$extension}";

    $thumbnail->save("{$path}/thumbs/{$destination}");
}

function getSetting($settingItem)
{
    return Setting::select('value')->whereItem($settingItem)->first()->value;
}


function getPage($pageName)
{
    return Page::whereName($pageName)->first();
}


function url_exists($url)
{
    $file_headers = @get_headers($url);
    if ($file_headers[0] == 'HTTP/1.1 404 Not Found') {
        return false;
    }
    return true;

}

function getEqual($valType, $valIndex)
{
    if ($valType == 'status_class') {
        $valArray = array('1' => 'success', '0' => 'danger');
    } elseif ($valType == 'visitCaseClass') {
        $valArray = array('visited' => 'success', 'none' => 'danger');
    } elseif ($valType == 'status_toggle') {
        $valArray = array('1' => 'on', '0' => 'off');
    } elseif ($valType == 'status') {
        $valArray = Config::get('user_statuses');
    } elseif ($valType == 'disabled_class') {
        $valArray = array('0' => 'success', '1' => 'danger');
    } elseif ($valType == 'disabled_toggle') {
        $valArray = array('0' => 'on', '1' => 'off');
    } elseif ($valType == 'disabled') {
        $valArray = array('0' => 'Active', '1' => 'InActive');
    } elseif ($valType == 'fav_star') {
        $valArray = array('0' => 'fa-star-o', '1' => 'fa-star');
    } elseif ($valType == 'boolean') {
        $valArray = array('0' => 'false', '1' => 'true');
    } elseif ($valType == 'boolean_reverse') {
        $valArray = array('false' => '0', 'true' => '1');
    }


    if (array_key_exists($valIndex, $valArray)) {
        return $valArray[$valIndex];
    } else {
        return $valIndex;
    }
}


function page_title($str)
{
    return ucfirst(str_replace('_', ' ', $str));
}

function page_name($str)
{
    return str_replace(' ', '_', trim($str));
}


function t($string)
{
    return translate('main.' . $string);
}

function translate($string)
{

    if (Lang::has($string)) {
        return trans($string);
    }
    return page_title(str_replace(['main.', 'validation.', 'mail.'], '', $string));
}


function arrayGroupBy($arr, $field)
{
    $result = array();
    foreach ($arr as $data) {
        $id = $data->$field;
        if (isset($result[$id])) {
            $result[$id][] = $data;
        } else {
            $result[$id] = array($data);
        }
    }
    return $result;
}

function arrayIndexBy($arr, $field)
{
    $result = array();
    foreach ($arr as $data) {
        $id = $data->$field;
        $result[$id] = $data;
    }
    return $result;
}

function sendMail($data)
{
//    require 'PHPMailer-master/PHPMailerAutoload.php';

    $objMail = new PHPMailer();

    $objMail->From = "nichepharma_accountservice@tacitapp.com";
    $objMail->FromName = "nichepharma";


//    $objMail->AddAddress("gems.webs1@gmail.com.com", "Recipient's Name");
    $objMail->AddAddress("customer.service@tacitapp.com", "Recipient's Name");
    $objMail->AddAddress($data['to'], "Recipient's Name");
    $objMail->Subject = "Contact Form Submission";
    $objMail->Body = $data['body'];

    $objMail->Host = "localhost";
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $objMail->AddAttachment($_FILES['image']['tmp_name'], $_FILES['image']['name']);
    }

    $objMail->Send();
}

function toString($ar){
    $string = '';
    foreach($ar as $item){
        $string .= $item .',';
    }
    return rtrim($string,',');
}