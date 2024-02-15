<?php

namespace App\Repositories\Quotes;

use App\Models\{Quote, User};
use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\{Collection,Str};
use Illuminate\Support\Facades\{Hash,Auth, Response as FacadesResponse};
use Illuminate\Http\{Response,Request};

class QuoteRepository extends Repository
{
    public function __construct(Quote $model, array $relations = [])
    {
        parent::__construct($model, $relations);
    }

    public function favQuotes(int $user_id) {
        $data = [];
        $quotesData = [];
        $quotes = $this->model->where('user_id', $user_id)->get();

        if ($quotes) {
            foreach ($quotes as $quote) {
                $quotesData[] = [
                    $quote->quote_id
                ];
            }
        }
        
        $data = [
            'quotes' => $quotesData
        ];

        return $data;
    }

    public function storeFavQuotes(array $data) {
        return $this->model->create([
            'user_id' => $data['user_id'],
            'quote_id' => $data['quote_id']
        ]);
    }

    public function deleteFavQuotes(int $quote_id) {
        $quote = $this->model->where('quote_id', $quote_id)->first();
        $quote->delete();

        $data = [
            'succes' => true,
            'message' => 'Quote successfully deleted.',
            'code' => Response::HTTP_OK,
        ];

        return $data;
    }

    public function paginate($relations = null, $paginate = 20, $filtersColumns = []) {
        return (!empty($relations))
            ? $this->model::with($relations)->orderBy('id', 'desc')->paginate($paginate)
            : $this->model::orderBy('id', 'desc')->paginate($paginate);
    }
}
