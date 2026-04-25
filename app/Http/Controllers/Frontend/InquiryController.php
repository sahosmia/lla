<?php
namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Models\Inquiry;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;


class InquiryController extends Controller
{
    public function index(){
        return view('frontend.contact-us');
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'         => 'required|string|max:255',
            'email'        => 'required|email',
            'phone'        => 'required|string|max:20',
            'inquiry_type' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $inquiry = Inquiry::create($request->all());

        // লারাভেলের ইভেন্ট ব্যবহার করা যেতে পারে (যেমন: নতুন ইনকোয়ারি আসলে অ্যাডমিনকে জানানো)
        // event(new \App\Events\NewInquiryReceived($inquiry));

        return redirect()->back()->with('success', 'Your inquiry has been submitted successfully.');
    }
}