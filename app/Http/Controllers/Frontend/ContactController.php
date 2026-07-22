<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function submitContact(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'nullable',
            'email' => 'nullable|email',
            'mobile' => 'required',
            'message' => 'required'
        ]);
        if ($validator->fails()) {
            return back()->with(['errors' => $validator->errors()]);
        }

        $contact = Contact::create($request->all());

        return back()->with('success', 'پیام شما با موفقیت ارسال شد.');
    }


}
