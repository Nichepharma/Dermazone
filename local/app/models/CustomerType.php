<?php

class CustomerType
{

    static function lists($singular = true)
    {

        if ($singular == true) {
            return array(
                1 => 'Private Market',
                2 => 'Pharmacy',
                3 => 'Hospital',
            );
        } else {
            return array(
                1 => 'Private Markets',
                2 => 'Pharmacies',
                3 => 'Hospitals',
            );
        }
    }

//	protected $table = "customer_type";
//	protected $guarded = [];
//	public static $rules = array(
//	);

}