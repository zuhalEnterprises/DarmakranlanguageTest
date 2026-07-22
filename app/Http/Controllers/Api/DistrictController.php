<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\District;
use App\Models\Street;
use App\Models\Province;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class DistrictController extends Controller {
	public function index( Request $request ) {
		$offset = $request->offset > 0 ? (int) $request->offset : 0;
		$mount  = $request->limit > 0 ? (int) $request->limit : 10;
		$model = District::where( 'active', 1 );
		$count = $model->get()->count();
		$model = $model->skip( $offset )->take( $mount )->get();
		return response( [
			'status' => 'success',
			'result' => [ 'districts' => $model, 'per_page' => $mount, 'total' => $count ]
		], config( 'StatusCode.SUCCESS' ) );
	}
	public function show( $id ) {
		$validator = Validator::make( [ 'id' => $id ], [
			'id' => 'required|exists:districts,id'
		] );
		if ( $validator->fails() ) {
			return response( [
				'status' => 'error',
				'result' => $validator->errors()
			], config( 'StatusCode.BAD_REQUEST' ) );
		}
		$model = District::find( $id );
		return response( [ 'status' => 'success', 'result' => $model ], config( 'StatusCode.SUCCESS' ) );
	}
    public function getStreets($id)
    {
        $streets   = [ ];
        $validator = Validator::make(['id' => $id], [
            'id' => 'required|exists:districts,id'
        ]);
        if ($validator->fails()) {
            return response([
                'status' => 'error',
                'result' => $validator->errors()
            ], config('StatusCode.BAD_REQUEST'));
        }
        $streets = Street::where('district_id',$id)->pluck('name','id')->toArray();
        return response([ 'status' => 'success', 'result' => $streets ], config('StatusCode.SUCCESS'));
    }

}
