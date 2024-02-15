<?php

namespace App\Responsable\Quotes;

use Illuminate\Contracts\Support\Responsable;
use App\Models\Quote;
use Illuminate\Http\Response;
use App\Helpers\StandardResponse;
use App\Http\Resources\QuotesResource;
use App\Repositories\Quotes\QuoteRepository;
use App\Http\Requests\QuoteFavStoreRequest;
use Illuminate\Support\Collection;

class QuoteStoreFavsResponsable implements Responsable
{
    use StandardResponse;
    private array $data;
    protected QuoteRepository $repository;

    public function __construct(QuoteFavStoreRequest $request, QuoteRepository $repository = null) {
        $this->data = $request->validated();
        $this->repository = $repository ?? new QuoteRepository(new Quote());
    }

    public function toResponse($request) {
        $res = $this->repository->storeFavQuotes($this->data);
        return $this->storeResponse(QuotesResource::make($res), isset($res) ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }
}