<?php

namespace Christophrumpel\FairProductPrices\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Christophrumpel\FairProductPrices\FairProductPrices
 */
class FairProductPricesFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'fair-product-prices';
    }
}
