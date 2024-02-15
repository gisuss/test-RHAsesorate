<?php

namespace App\Responsable\Quotes;

use Illuminate\Contracts\Support\Responsable;
use App\Models\Quote;
use Illuminate\Http\Response;
use App\Helpers\StandardResponse;
use App\Http\Resources\QuotesResource;
use App\Repositories\Quotes\QuoteRepository;
use Illuminate\Support\Collection;

class QuoteShowFavsResponsable implements Responsable
{
    use StandardResponse;
    protected $user;
    protected QuoteRepository $repository;

    public function __construct(int $user, QuoteRepository $repository = null) {
        $this->setUser($user);
        $this->repository = $repository ?? new QuoteRepository(new Quote());
    }

    public function toResponse($request) {
        $quotes = $this->repository->favQuotes($this->user);
        return $this->showResponse(QuotesResource::make($quotes), isset($quotes) ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }

    private function setUser($user) {
        $this->user = $user;
    }
}