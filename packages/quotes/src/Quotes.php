<?php

namespace Gisuss\Quotes;

use App\Models\Quote;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Response;

class Quotes {
    public function justDoIt(int $id) {
        $bool = false;
        $response = [];
        $res = Http::get('https://dummyjson.com/quotes/'. $id);

        if ($res) {
            $bool = true;
            $response[] = [
                'id' => $res['id'],
                'quote' => $res['quote'],
                'author' => $res['author'],
            ];
        }

        return response()->json([
            'message' => $bool ? 'Success' : 'Failed',
            'data' => $response,
            'success' => $bool,
        ], $bool ? HttpResponse::HTTP_OK : HttpResponse::HTTP_NOT_FOUND);
    }
    
    public function randomQuotes(int $lot) {
        $response = [];
        $bool = true;

        for ($i=0; $i < $lot; $i++) {
            if ($bool) {
                $res = Http::get('https://dummyjson.com/quotes/random');
    
                if ($res->status() <> 200) {
                    $bool = false;
                }
    
                $response[] = [
                    'id' => $res['id'],
                    'quote' => $res['quote'],
                    'author' => $res['author'],
                ];
            }
        }

        return response()->json([
            'message' => $bool ? 'Success' : 'Failed',
            'data' => $response,
            'success' => $bool,
        ], $bool ? HttpResponse::HTTP_OK : HttpResponse::HTTP_NOT_FOUND);
    }

    public function toFav(Request $request) {
        $bool = false;

        $res = Quote::create([
            'user_id' => $request->user_id,
            'quote_id' => $request->quote_id
        ]);

        if ($res) {
            $bool = true;
        }

        return response()->json([
            'message' => $bool ? 'Quote stored successfully' : 'An error occurred while storing the quote.',
            'success' => $bool,
        ], $bool ? HttpResponse::HTTP_OK : HttpResponse::HTTP_NOT_FOUND);
    }

    public function favs(int $user_id) {
        $bool = false;
        $quotesData = [];
        $quotes = Quote::where('user_id', $user_id)->get();

        if ($quotes) {
            $bool = true;
            foreach ($quotes as $quote) {
                $res = Http::get('https://dummyjson.com/quotes/'. $quote->quote_id);
                $quotesData[] = [
                    'id' => $res['id'],
                    'quote' => $res['quote'],
                    'author' => $res['author'],
                ];
            }
        }

        return response()->json([
            'message' => $bool ? 'Quotes obtained successfully' : 'An error occurred while obtaining the quotes.',
            'data' => $quotesData,
            'success' => $bool,
        ], $bool ? HttpResponse::HTTP_OK : HttpResponse::HTTP_NOT_FOUND);
    }

    public function toTrash(Request $request) {
        $bool = false;
        $quote = Quote::where('quote_id', $request->quote_id)->where('user_id', $request->user_id)->first();

        if ($quote) {
            $quote->delete();
            $bool = true;
        }

        return response()->json([
            'message' => $bool ? 'Quote deleted successfully' : 'An error occurred while deleting the quote.',
            'success' => $bool,
        ], $bool ? HttpResponse::HTTP_OK : HttpResponse::HTTP_NOT_FOUND);
    }
}