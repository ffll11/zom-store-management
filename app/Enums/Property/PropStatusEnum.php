<?php

namespace App\Enums\Property;
use App\Traits\EnumToArray;
enum PropStatusEnum:string {
   use EnumToArray;

    case ACTIVE = 'active';
    case INACTIVE = 'inactive';


    //
}