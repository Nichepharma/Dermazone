<?php
//namespace App\Http\Controllers;
use Illuminate\Support\Facades\Request;

class OperationsController extends BaseController
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

      switch ($action) {
        case 'create_product':
          $html = "<form method=POST action=operations123?action=post_product>
          Product Name : <input type=text name=\"product_name\" id=\"product_name\"> <br />
          Number Of Slides : <input type=text name=\"product_slides\" id=\"product_slides\"> <br />
          <input type=\"submit\">
          </form>";
          return $html;

        case 'post_product':
          $product = new Product;
          $product->name = Input::get('product_name');
          $product->slides = Input::get('product_slides');

                $product_id = DB::select("SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '" . Config::get('database.connections.mysql.database')  . "' AND TABLE_NAME = 'product'");
                $product_id = $product_id[0]->AUTO_INCREMENT;

                for($i=0; $i < $product->slides; $i++){
                  $productslide = new ProductSlide;
                  $productslide->product_id = $product_id;
                  $productslide->num = $i;
                  $productslide->name = "";
                  $productslide->cat = "";
                  $productslide->save();
                }

          $product->save();

          return Redirect::to('operations123');

        case 'edit_product':
          $products = DB::table('product')->get();
          foreach ($products as $product) {
            echo "{$product->id} - <a href=?action=edit_slides&product_id={$product->id}>{$product->name}</a><br />";
          }
          break;

        case 'edit_slides':
          $slides = DB::table('product_slide')
          ->where('product_id', Input::get('product_id'))
          ->get();
          echo "<form method=POST action=operations123?action=post_slides&product_id=" . Input::get('product_id') . ">
          <table border=1 align=center width=100%><tr><td>Number</td><td>Menu</td><td>Slide Name</td></tr>";
          foreach ($slides as $slide) {
            echo "<tr>
            <td>{$slide->num}</td>
            <td><input style=\"width:100%\" type=text value=\"{$slide->name}\" name=\"slide_name[$slide->num]\"></td>
            <td><input style=\"width:100%\" type=text value=\"{$slide->cat}\" name=\"slide_cat[$slide->num]\"></td>
            </tr>";
          }
          echo "</table><input type=\"submit\" align=center></form>";
          break;

        case 'post_slides':
          $slide_names = Input::get('slide_name');
          $slide_cats = Input::get('slide_cat');
          foreach ($slide_names as $key => $slide_name) {
            DB::table('product_slide')
            ->where('product_id', Input::get('product_id'))
            ->where('num', $key)
            ->update(array('name' => $slide_name, 'cat' => $slide_cats[$key]));
          }
          return Redirect::to('operations123');

        default:
          $html = "<html><head></head><body>
          <a href=?action=create_product>Create A New Product</a>
          <br /><br />
          <a href=?action=edit_product>Edit An Existing Product</a>
          </body></html>";
          return $html;
      }
    }

}
