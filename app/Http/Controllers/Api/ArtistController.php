<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\ErrorException;
use App\Exceptions\NotFoundException;

use App\Models\Artist;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Auth;
use DB;

class ArtistController extends Controller
{
    protected $table_name;

    public function __construct()
    {
        $this->table_name = (new Artist())->getTable();
    }

    /**
     *
     * Display the specified resource.
     *
     * @param Request $request
     * @return Response
     * @throws NotFoundException
     */
    public function show(Request $request)
    {
        $id = $request->route()->parameter('artist');

        $artist = DB::table($this->table_name)
            ->where('id', $id)
            ->first();

        if (!$artist) {
            throw new NotFoundException();
        }

        return response()->json($artist, 200);
    }
    /**
     *
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     * @throws ErrorException
     */
    public function store(Request $request)
    {
        $data = $this->getValidatedData($request);

        $artist = DB::table($this->table_name)
            ->where($data);

        if ($artist->exists()) {
            throw new ErrorException('item exist');
        }

        $result = DB::table($this->table_name)
            ->insert($data);

        if (!$result) {
            throw new ErrorException('not inserted');
        }

        return response()->json([], 201);
    }


    /**
     *
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ErrorException
     * @throws NotFoundException
     */
    public function update(Request $request)
    {
        $id = $request->route()->parameter('artist');

        $artist = DB::table($this->table_name)
            ->where('id', $id);

        if (!$artist->exists()) {
            throw new NotFoundException();
        }

        $data = $this->getValidatedData($request);

        $result = $artist->update($data);

        if (!$result) {
            throw new ErrorException('not updated');
        }

        return response()->json([], 200);
    }

    /**
     *
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return Response
     * @throws ErrorException
     * @throws NotFoundException
     */
    public function destroy(Request $request)
    {
        $id = $request->route()->parameter('artist');

        $artist = DB::table($this->table_name)
            ->where('id', $id);

        if (!$artist->exists()) {
            throw new NotFoundException();
        }

        $result = $artist->delete();

        if (!$result) {
            throw new ErrorException('not deleted');
        }

        return response()->json([], 200);
    }

    private function getValidatedData($request)
    {
        $validate_array = $request->only(['name']);

        $validate_rules = [

            'name'          => 'required|max:256',
        ];

        $validator = Validator::make($validate_array, $validate_rules);

        if ($validator->fails()) {
            throw new ErrorException($validator->errors());
        }

        $data = $validate_array;

        return $data;
    }

}
