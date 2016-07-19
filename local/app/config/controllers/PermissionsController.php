<?php

class PermissionsController extends BaseController
{

    protected $model;
    protected $my_model;
    protected $data;

    public function __construct(PermissionModel $model)
    {
        parent::__construct();
        $this->model = $model;
        $this->my_model = 'PermissionModel';
        $this->data['module'] = 'permission';
        $this->data['modules'] = 'permissions';

    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
//        DB::table($this->model->getTable())->truncate();
//        foreach(all_routs() as $k=>$v){
//            foreach(all_actions() as $k2=>$v2) {
//                $input = ['action'=>$v2,'module'=>$v,'name'=>$v.'.'.$v2];
//                $this->model->create($input);
//            }
//        }
//
//
//        foreach(other_routes() as $module=>$actions){
//
//            foreach($actions as $action_name) {
//
//                $input = ['action'=>$action_name,'module'=>$module,'name'=>$module.'.'.$action_name];
//                $this->model->create($input);
//            }
//        }

        return $this->model->get();
//        return View::make('' . $this->data['modules'] . '.index', ['data' => $this->data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $routeCollection = Route::getRoutes();

        foreach ($routeCollection as $value) {

            if(strpos($value->getPath(),'/')===false){
                $routes[$value->getPath()] = $value->getPath();
            }
        }
        $this->data['routes'] = array_except(array_unique($routes),['home','login','profile','change_password','logout']);
//        pr2($this->data);

        return View::make('' . $this->data['modules'] . '.create', ['data' => $this->data]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {

        $input = array_except(Input::all(), ['_method']);


        $model = $this->model;
        $validation = Validator::make($input, $model::$rules);

        if ($validation->passes()) {
            if (Input::hasFile('img')) {
                if (Input::file('img')->isValid()) {
                    $random_name = create_random_name();
                    $extension = Input::file('img')->getClientOriginalExtension();
                    $img_name = $random_name . '.' . $extension;
                    if (Input::file('img')->move(public_path() . '/uploads', $img_name)) {
                        create_thumbnail(public_path() . '/uploads', $random_name, $extension, 350, 350);
                    }
                    $input['img'] = $img_name;
                }
            } else {
                unset($input['img']);
            }

            if (Input::hasFile('icon')) {
                if (Input::file('icon')->isValid()) {
                    $random_name = create_random_name();
                    $extension = Input::file('icon')->getClientOriginalExtension();
                    $icon_name = $random_name . '.' . $extension;
                    if (Input::file('icon')->move(public_path() . '/uploads', $icon_name)) {
                        create_thumbnail(public_path() . '/uploads', $random_name, $extension, 82, 82);
                    }
                    $input['icon'] = $icon_name;
                }
            } else {
                unset($input['icon']);
            }

            $InsertedID = $this->model->create($input)->id;

            Session::flash('alert', 'success');
            Session::flash('message', $this->data['module'] . ' Saved');
            return Redirect::route('' . $this->data['modules'] . '.index');
        }

        return Redirect::route('' . $this->data['modules'] . '.create')
            ->withInput()
            ->withErrors($validation);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        $this->data['model'] = $this->model->findOrFail($id);
        return View::make('' . $this->data['modules'] . '.show', ['data' => $this->data]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $this->data['routes'] = all_routs();
        $this->data['model'] = $this->model->find($id);
//        pr2($this->data['model']->toArray());

        return View::make('' . $this->data['modules'] . '.edit', ['data' => $this->data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        $input = array_except(Input::all(), ['_method']);


        $model = $this->model;
        $validation = Validator::make($input, $model::$rules);

        if ($validation->passes()) {

            if(isset($input['disabled']))
                $input['disabled']= 0;
            else
                $input['disabled']= 1;

            $model = $this->model->find($id);
            $model->update($input);

            Session::flash('alert', 'success');
            Session::flash('message', $this->data['module'] . ' Saved');
            return Redirect::route('' . $this->data['modules'] . '.index');
        }

        return Redirect::route('' . $this->data['modules'] . '.edit', $id)
            ->withInput()
            ->withErrors($validation);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        if ($this->model->findOrFail($id)->delete()) {
            Session::flash('alert', 'success');
            Session::flash('message', $this->data['module'] . ' Deleted');
        }

        return Redirect::route('' . $this->data['modules'] . '.index');
    }

    public function change_status()
    {
        if (Input::has('id')) {
            $record = $this->model->findOrFail(Input::get('id'));
            if ($record->active == 0) {
                $record->active = 1;
            } else {
                $record->active = 0;
            }
            $record->save();
            echo 'done';
        }
    }

}
