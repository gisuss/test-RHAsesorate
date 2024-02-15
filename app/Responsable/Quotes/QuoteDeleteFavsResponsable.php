<?php

namespace App\Responsable\Quotes;

use Illuminate\Contracts\Support\Responsable;
use App\Models\Quote;
use Illuminate\Http\Response;
use App\Helpers\StandardResponse;
use App\Http\Resources\QuotesResource;
use App\Repositories\Quotes\QuoteRepository;
use Illuminate\Support\Collection;

class QuoteDeleteFavsResponsable implements Responsable
{
    use StandardResponse;
    private int $quote;
    protected QuoteRepository $repository;

    public function __construct(int $quote, QuoteRepository $repository = null) {
        $this->quote = $quote;
        $this->repository = $repository ?? new QuoteRepository(new Quote());
    }

    public function toResponse($request) {
        $res = $this->repository->deleteFavQuotes($this->quote);
        return $this->destroyResponse(($res['succes'] === true) ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }
}