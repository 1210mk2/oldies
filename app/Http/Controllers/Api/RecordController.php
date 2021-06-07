<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\ErrorException;
use App\Exceptions\NotFoundException;

use App\Models\Record;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Auth;
use DB;

class RecordController extends Controller
{
    protected $table_name;

    public function __construct()
    {
        $this->table_name = (new Record())->getTable();
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
        $id = $request->route()->parameter('record');

        $record = DB::table($this->table_name)
            ->where('id', $id)
            ->first();

        if (!$record) {
            throw new NotFoundException();
        }

        return response()->json($record, 200);
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

        $record = DB::table($this->table_name)
            ->where($data);

        if ($record->exists()) {
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
        $id = $request->route()->parameter('record');

        $record = DB::table($this->table_name)
            ->where('id', $id);

        if (!$record->exists()) {
            throw new NotFoundException();
        }

        $data = $this->getValidatedData($request);

        $result = $record->update($data);

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
        $id = $request->route()->parameter('record');

        $record = DB::table($this->table_name)
            ->where('id', $id);

        if (!$record->exists()) {
            throw new NotFoundException();
        }

        $result = $record->delete();

        if (!$result) {
            throw new ErrorException('not deleted');
        }

        return response()->json([], 200);
    }

    private function getValidatedData($request)
    {
        $validate_array = $request->only(['name', '_artist']);

        $validate_rules = [

            'name'          => 'required|max:256',
            '_artist'       => 'required|integer',
        ];

        $validator = Validator::make($validate_array, $validate_rules);

        if ($validator->fails()) {
            throw new ErrorException($validator->errors());
        }

        $relation_table_name = (new Record())->artist()->getRelated()->getTable();
        $artist = DB::table($relation_table_name)
            ->where('id', $validate_array['_artist'])
            ->count();

        if (!$artist) {
            throw new ErrorException('relation not found');
        }

        $data = $validate_array;

        return $data;
    }

}
