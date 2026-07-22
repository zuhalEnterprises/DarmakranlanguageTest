<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\District;
use App\Models\Streets;
use App\Models\Province;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CityController extends Controller {
	public function index( Request $request ) {
		$offset = $request->offset > 0 ? (int) $request->offset : 0;
		$mount  = $request->limit > 0 ? (int) $request->limit : 10;

		$model = City::where( 'active', 1 );
		$count = $model->get()->count();
		$model = $model->skip( $offset )->take( $mount )->get();

		return response( [
			'status' => 'success',
			'result' => [ 'cities' => $model, 'per_page' => $mount, 'total' => $count ]
		], config( 'StatusCode.SUCCESS' ) );
	}

	public function show( $id ) {
		$validator = Validator::make( [ 'id' => $id ], [
			'id' => 'required|exists:cities,id'
		] );

		if ( $validator->fails() ) {
			return response( [
				'status' => 'error',
				'result' => $validator->errors()
			], config( 'StatusCode.BAD_REQUEST' ) );
		}

		$model = City::find( $id );

		return response( [ 'status' => 'success', 'result' => $model ], config( 'StatusCode.SUCCESS' ) );
	}

    public function getDistricts($id)
    {
        $districts   = [ ];
        $validator = Validator::make(['id' => $id], [
            'id' => 'required|exists:cities,id'
        ]);
        if ($validator->fails()) {
            return response([
                'status' => 'error',
                'result' => $validator->errors()
            ], config('StatusCode.BAD_REQUEST'));
        }
        $districts = District::where('city_id',$id)->orderBy('village', 'asc')->orderBy('name', 'asc')->pluck('name','id' , 'village')->toArray();
        return response([ 'status' => 'success', 'result' => $districts ], config('StatusCode.SUCCESS'));
    }
    public function getDistricts2($id,$type=null)
    {
        $districts   = [ ];
        $validator = Validator::make(['id' => $id], [
            'id' => 'required|exists:cities,id'
        ]);
        if ($validator->fails()) {
            return response([
                'status' => 'error',
                'result' => $validator->errors()
            ], config('StatusCode.BAD_REQUEST'));
        }
        if(!empty($type)){
        $districts = District::where('city_id',$id)->where('village',$type)->orderBy('name', 'asc')->pluck('name','id')->toArray();
        }
        else
        {
            $districts = District::where('city_id',$id)->orderBy('village', 'asc')->orderBy('name', 'asc')->pluck('name','id','village')->toArray();
        }
        return response([ 'status' => 'success', 'result' => $districts ], config('StatusCode.SUCCESS'));
    }
    public function getDistricts1($id)
    {
        $districts   = [ ];
        $validator = Validator::make(['id' => $id], [
            'id' => 'required|exists:cities,id'
        ]);
        if ($validator->fails()) {
            return response([
                'status' => 'error',
                'result' => $validator->errors()
            ], config('StatusCode.BAD_REQUEST'));
        }

        $districts = District::where('city_id', $id)->orderBy('village', 'asc')->orderBy('name', 'asc')->get();//->pluck('name', 'id','village');//->toArray();
        //dd(getQuery($districts));

        $newDistricts = [];
        $index = 0;
        foreach ($districts as $item=>$value) {

            $newDistricts[] = [
                'name' => $value->name,
                'id' => $value->id,
                'village' => $value->village
            ];
            $index++;
        }

        // مرتب کردن آرایه `districts` بر اساس نام
        //$districts = $districts->sortBy('name');

        // اضافه کردن یک index جدید به آرایه `districts`



        return response([
            'status' => 'success',
            'result' => $newDistricts
        ], config('StatusCode.SUCCESS'));
    }

    public function getArea($id)
    {
        $districts   = [ ];
        $validator = Validator::make(['id' => $id], [
            'id' => 'required|exists:cities,id'
        ]);

        if ($validator->fails()) {
            return response([
                'status' => 'error',
                'result' => $validator->errors()
            ], config('StatusCode.BAD_REQUEST'));
        }

        $areacount = City::where('id',$id)->pluck('count_area')->first();

        return $areacount;
    }
    public function getAreaDistrict($id)
    {
        $districts   = [ ];
        $validator = Validator::make(['id' => $id], [
            'id' => 'required|exists:cities,id'
        ]);

        if ($validator->fails()) {
            return response([
                'status' => 'error',
                'result' => $validator->errors()
            ], config('StatusCode.BAD_REQUEST'));
        }
        $areas = District::whereIn('area', explode(',', $id))->pluck('id')->toArray();

        return response([ 'status' => 'success', 'result' => $areas ], config('StatusCode.SUCCESS'));
        $areacount = District::where('area',$id)->pluck('count_area')->first();

        return $areacount;
    }
    public function getCoaches(Request $request, $id)
    {
        $validator = Validator::make(['id' => $id], [
            'id' => 'required|exists:cities,id'
        ]);

        if ($validator->fails()) {
            return response([
                'status' => 'error',
                'result' => $validator->errors()
            ], config('StatusCode.BAD_REQUEST'));
        }

        $users = User::role('expert_coach')
            ->where('city_id',$id)
            ->where( 'is_admin', 0 )
            ->where( 'has_role', 1 )
            ->pluck('name','id')
            ->toArray();

        return response([ 'status' => 'success', 'result' => $users ], config('StatusCode.SUCCESS'));
    }
}
