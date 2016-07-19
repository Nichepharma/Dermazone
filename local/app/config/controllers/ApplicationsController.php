<?php

class ApplicationsController extends BaseController
{

    protected $model;
    protected $my_model;
    protected $data;

    public function __construct()
    {
        parent::__construct();

        $this->data['page'] = 'home';
    }

    public function getIndex()
    {
        return View::make('applications.index', ['data' => $this->data]);
    }

}
