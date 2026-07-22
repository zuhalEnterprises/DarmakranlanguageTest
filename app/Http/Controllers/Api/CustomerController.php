<?php

namespace App\Http\Controllers\Api;

use App\helper\jdf;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerAppointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Morilog\Jalali\CalendarUtils;
use Morilog\Jalali\Jalalian;
use Verta;

class CustomerController extends Controller {
    function GUID()
    {
        return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    }
	public function store( Request $request) {
		$validator = Validator::make( $request->all(), [
			'name' => 'nullable|string',
			'phone'  => 'nullable|string'
		] );

		if ( $validator->fails() ) {
            return badRequest( $validator->errors() );
		}
        $inputs = $request->all();
        $inputs['guid'] = $this->GUID();
		$comment   = Customer::create($inputs);

		return response( [
			'status' => 'ok',
			'result' => 'دیدگاه شما ارسال شد، پس از بازبینی توسط مدیریت منتشر خواهد شد.'
		], config( 'StatusCode.SUCCESS' ) );
	}
    function convertNumbersToEnglish($string)
    {
        $persian = ['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹'];
        $arabic  = ['٠','١','٢','٣','٤','٥','٦','٧','٨','٩'];
        $english = ['0','1','2','3','4','5','6','7','8','9'];

        return str_replace($persian, $english, str_replace($arabic, $english, $string));
    }
    public function storeAppointment(Request $request)
{
    $validated = $request->validate([
        'name'       => 'nullable|string|max:250',
        'lang_id'    => 'nullable|string|max:50',
        'date'       => 'nullable|string',
        'mobile'     => 'nullable|string|max:30',
        'country_id' => 'nullable|integer',
        'email'      => 'nullable|email|max:100',
        'estate_id'  => 'nullable|integer',
    ]);

    if (!empty($validated['date'])) {
        try {
            // تبدیل اعداد فارسی به انگلیسی
            $dateStr = $this->convertNumbersToEnglish($validated['date']);
            // حالا تبدیل تاریخ شمسی به میلادی
            $jalaliDateTime = Jalalian::fromFormat('Y/m/d H:i', $dateStr);
            $validated['date'] = $jalaliDateTime->toCarbon()->format('Y-m-d H:i:s');

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'فرمت تاریخ اشتباه است.',
                'error' => $e->getMessage(),
            ], 422);
        }
    }

    $appointment = CustomerAppointment::create($validated);

    return response()->json([
        'message' => 'قرار با موفقیت ثبت شد.',
        'data'    => $appointment,
    ]);
}
}
