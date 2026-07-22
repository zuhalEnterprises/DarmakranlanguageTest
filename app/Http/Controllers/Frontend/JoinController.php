<?php
namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JoinController extends Controller {

    public function Join(Request $request)
    {
        return view('join.index_v2');
    }
    public function flexibility(Request $request) {
        return view('join.flexibility_v2');
    }
    public function Consultantestate(Request $request) {
        return view('join.Consultantestate_v2');
    }
    public function commissionPayment(Request $request) {
        return view('join.commissionPayment_v2');
    }
    public function networkhuman(Request $request) {
        return view('join.networkhuman_v2');
    }
    public function knowledgeskills(Request $request) {
        return view('join.knowledgeskills_v2');
    }
    public function Expertconsultant(Request $request) {
        return view('join.Expertconsultant_v2');
    }
    public function Marketing(Request $request) {
        return view('join.marketing_v2');
    }
    public function Technology(Request $request) {
        return view('join.Technology_v2');
    }
    public function Growthprogress(Request $request) {
        return view('join.Growthprogress_v2');
    }
     public function services(Request $request) {
        return view('join.services_v2');
    }
    public function event(Request $request) {
        return view('join.event_v2');
    }
    public function financialIndependence(Request $request) {
        return view('join.financialIndependence_v2');
    }
    public function successPlace(Request $request) {
        return view('join.successPlace_v2');
    }

}

?>
