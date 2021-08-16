<?php

namespace App\Rules;

use App\Helpers\StringHelper;
use App\Helpers\ValidateBusinessNationalRegistry;
use App\Helpers\ValidateIndividualNationalRegistry;
use Illuminate\Contracts\Validation\Rule;

class NationalRegistryRule implements Rule
{
    function __construct()
    {
    }

    public function passes($attribute, $value): bool
    {
        $nationalRegistryWithoutMask = StringHelper::sanitize($value);

        if(
            strlen($nationalRegistryWithoutMask) >=
            ValidateBusinessNationalRegistry::BUSINESS_NATIONAL_REGISTRY_DEFAULT_SIZE
        ){
            return ValidateBusinessNationalRegistry::validate($value);
        }

        return ValidateIndividualNationalRegistry::validate($value);
    }

    public function message(): string
    {
        return 'Invalid national registry';
    }
}
