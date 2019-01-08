<?php

namespace app\models;

use app\support\helpers\LoggedInUserTrait;
use yii\base\Model;

class ListingsModel extends Model
{
    use LoggedInUserTrait;

    public $id;
    public $place_name;
    public $place_types_id;
    public $email;
    public $phone;
    public $city;
    public $street;
    public $zip;
    public $countries_id;
    public $companies_id;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        $listings = new Listings();
        $listingsRules  = $listings->rules();

        $address = new Addresses();
        $addressRules   = $address->rules();

        $rules = array_merge($listingsRules, $addressRules);

        return $rules;

    }

    public function attributeLabels()
    {
        $listings = new Listings();
        $listingsLabels  = $listings->attributeLabels();

        $address = new Addresses();
        $addressLabels  = $address->attributeLabels();

        return array_merge($listingsLabels, $addressLabels);
    }

    public function store($attributes = []) : bool
    {
        $company        = self::loggedInUserCompany();
        $this->companies_id  = $company->id;

        $addresses = new Addresses();
        $addresses->load($this->toArray(),'');
        $addresses->save();

        $listings = new Listings();
        $listings->load($this->toArray(),'');
        $listings->companies_id = $this->companies_id;
        $listings->link('addresses', $addresses);

        $saved = $listings->save();
        $this->id = $listings->id;

        return $saved;
    }


}