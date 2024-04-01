<?php
namespace Gisuss\Quotes\Controllers;

use Illuminate\Http\Request;
use Gisuss\Quotes\Quotes;

class QuoteController
{
    protected Quotes $quote;

    public function __construct(Quotes $quote) {
        $this->quote = $quote;
    }

    public function showQuote(int $id) {
        $quote = $this->quote->justDoIt($id);

        return $quote;
    }
    
    public function randomQuotes(int $lot) {
        return $this->quote->randomQuotes($lot);
    }
    
    public function toFav(Request $request) {
        return $this->quote->toFav($request);
    }
    
    public function favs(int $user_id) {
        return $this->quote->favs($user_id);
    }
    
    public function toTrash(Request $request) {
        return $this->quote->toTrash($request);
    }
}