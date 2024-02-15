<?php

namespace App\Http\Controllers\Quotes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Responsable\Quotes\{QuoteShowFavsResponsable, QuoteStoreFavsResponsable, QuoteDeleteFavsResponsable};

class QuoteController extends Controller
{
    /**
     * Get all favorities quotes from the especified user.
     * 
     * @param int $user
     * @return void
     */
    public function getFavQuotes(int $user) {
        return new QuoteShowFavsResponsable($user);
    }

    /**
     * Store a fav quote.
     * 
     * @param mixed $quoteStoreFavsResponsable
     * @return void
     */
    public function storeFavQuotes(QuoteStoreFavsResponsable $quoteStoreFavsResponsable) {
        return $quoteStoreFavsResponsable;
    }

    /**
     * Store a fav quote.
     * 
     * @param int $quote
     * @return void
     */
    public function deleteFavQuotes(int $quote) {
        return new QuoteDeleteFavsResponsable($quote);
    }
}
