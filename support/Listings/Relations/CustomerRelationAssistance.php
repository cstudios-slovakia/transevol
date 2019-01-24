<?php

namespace app\support\Listings\Relations;

use app\models\CustomerListings;

class CustomerRelationAssistance
{
    public function ownedCustomers() : array
    {
        $customers  = CustomerListings::find()->all();

        return $customers;
    }

    public static function ownedCustomersSelectOptions() : array
    {
        $selectOptions =  collect(
            (new static())->ownedCustomers()
        );
        return $selectOptions
            ->pluck('place_name','id')
            ->toArray();
    }

}