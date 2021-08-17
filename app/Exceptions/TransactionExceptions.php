<?php

namespace App\Exceptions;

use Illuminate\Http\Response;

class TransactionExceptions
{
    public static function valueGreaterThanAvailableValueInWallet()
    {
        return CustomHttpException::new()
            ->setMessage('Value above the amount on the wallet.')
            ->setHttpCode(Response::HTTP_UNAUTHORIZED);
    }

    public static function sameUserIdAsPayerAndPayee()
    {
        return CustomHttpException::new()
            ->setMessage('Payee and Payer cant be the same user.')
            ->setHttpCode(Response::HTTP_UNAUTHORIZED);
    }

    public static function shopkeeperCantMakeATransaction()
    {
        return CustomHttpException::new()
            ->setMessage('A shopkeer cant make a transaction')
            ->setHttpCode(Response::HTTP_UNAUTHORIZED);
    }

    public static function unauthorizedTransaction()
    {
        return CustomHttpException::new()
            ->setMessage('The transaction is not authorized.')
            ->setHttpCode(Response::HTTP_UNAUTHORIZED);
    }
}
