<?php

namespace App\Http\Controllers\Api;

use App\Services\SearchService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Auth;
use DB;

class SearchController extends Controller
{

    protected $_searchService;

    public function __construct()
    {
        $this->_searchService = new SearchService();
    }


    /**
     * @OA\Get(
     *      path="/search",
     *      tags={"Search"},
     *      summary="Search by all fields",
     *      @OA\Parameter(
     *          name="q",
     *          description="query string",
     *          required=true,
     *          in="query",
     *          @OA\Schema(type="string")
     *      ),
     *      @OA\Response(response=200, description="successful operation", @OA\JsonContent()),
     *      security={{ "token": {} }}
     *   )
     *
     *
     * @param Request $request
     * @return Response
     */
    public function search(Request $request)
    {
        $search_query = $request->input('q');

        $result = $this->_searchService->simpleSearch($search_query);

        return response()->json($result, 200);
    }

}
