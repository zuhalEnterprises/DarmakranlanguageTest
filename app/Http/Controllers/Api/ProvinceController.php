<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProvinceController extends Controller {
	public function index( Request $request ) {
		$offset = $request->offset > 0 ? (int) $request->offset : 0;
		$mount  = $request->limit > 0 ? (int) $request->limit : 10;

		$model = Province::where( 'active', 1 );
		$count = $model->get()->count();
		$model = $model->get();//->skip( $offset )->take( $mount )

		return response( [
			'status' => 'success',
			'result' => [ 'provinces' => $model ]//, 'per_page' => $mount, 'total' => $count
		], config( 'StatusCode.SUCCESS' ) );
	}

	public function show( $id ) {
		$validator = Validator::make( [ 'id' => $id ], [
			'id' => 'required|numeric|exists:provinces,id'
		] );

		if ( $validator->fails() ) {
			return response( [
				'status' => 'error',
				'result' => $validator->errors()
			], config( 'StatusCode.BAD_REQUEST' ) );
		}

		$model = Province::find( $id );

		return response( [ 'status' => 'success', 'result' => $model ], config( 'StatusCode.SUCCESS' ) );
	}

    public function get_cities( $id ) {
        $province = Province::with('cities')->find( $id );
        if(!$province){
            return notFound();
        }

        return response( [ 'status' => 'success', 'result' => $province->cities ], config( 'StatusCode.SUCCESS' ) );
    }

	public function getCities( $id ) {
        $cities   = [ ];
		$province = Province::find( $id );
        if($province){
            $cities = $province->cities->pluck( 'name','id' )->toArray();

        }
		return response( [ 'status' => 'success', 'result' => $cities ], config( 'StatusCode.SUCCESS' ) );
	}

    public function getCities2( $id ) {
        $cities = City::where( 'province_id', $id )->where('active',1)->get();

        return response( [ 'status' => 'success', 'result' => $cities ], config( 'StatusCode.SUCCESS' ) );
    }

}
