<?php

namespace App\Http\Controllers;
use Stripe;

use Illuminate\Http\Request;
use App\Doctor;
use App\Appointment;
use Illuminate\Support\Facades\Auth;
use App\Patient;
use Hash;

class PatientController extends Controller
{


    public function index() {
        $doctors = Doctor::paginate(5);
        return view('patient.index')->with(compact('doctors'));
    }

    public function booking() {
        $doctors = Doctor::get();
        return view('patient.booking')->with(compact('doctors'));
    }

    public function getDoctor(Request $request){
        $data = $request->all();
        $doctor = Doctor::where('id',$data['doctor_id'])->first();
        return json_encode($doctor);
    }

    public function bookNow(Request $request) {
        $data = $request->all();
        // echo "<pre>"; print_r($data); die;
        $book = Appointment::create([
            'patient_id'=> Auth::guard('web')->id(),
            'doctor_id'=>$data['doctor_id'],
            'price'=>$data['price'],
            'date'=>$data['date'],
            'symptoms'=>$data['symptoms'],
            'urgency_level'=>$data['urgency_level'],
        ]);

        if($book){
            $id = $book->id;
            return view('patient.stripe')->with(compact('id'));
        } else redirect()->back()->with('flash_message_error','Error Booking Appointment Try again');
    }

    public function bookNowInstance($id) {
        return view('patient.stripe')->with(compact('id'));
    }

    public function stripePost(Request $request) {
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        Stripe\Charge::create ([
                "amount" => 100 * 100,
                "currency" => "usd",
                "source" => $request->stripeToken,
                "description" => $request->desc
        ]);
        $get = Appointment::where('id',$request->id)->first();
        $update = $get->update([
            'payed'=>true,
        ]);
        if ($update){
            return redirect(route('booking'))->with('flash_message_success','Booking and Payment Successful');
        } else return redirect(route('booking'))->with('flash_message_error','Payment Failed');
    }

    public function appointments() {
        $appointments = Appointment::with('doctor')->where('patient_id',Auth::guard('web')->id())->get();
        return view('patient.appointments')->with(compact('appointments'));
    }

    public function showPasswordForm() {
        return view('patient.password');
    }


    //Ajax method to confirm inputted current password
    public function confirmPassword(Request $request){
        $current_password = $request->current_pwd;
        $chk_password = Auth::guard('web')->user()->password;
        // echo "<pre>"; print_r($chk_password); die;

        if(Hash::check($current_password,$chk_password)){
            return "true";
        }else {
            return "false";
        }
    }


    //Post method to effect change to admin password
    public function changePassword(Request $request) {
        $data = $request->all();
        $current_password = $data['current_password'];
        $chk_password = Auth::guard('web')->user()->password;
        // echo "<pre>"; print_r($chk_password); die;

        if(Hash::check($current_password,$chk_password)){
            $id = Auth::guard('web')->id();
            $patient = Patient::findOrFail($id);
            $patient->update([
                'password'=> Hash::make($data['password']),
            ]);
            return redirect()->back()->with('flash_message_success','Successfully Changed Password');
        }else {
            return redirect()->back()->with('flash_message_error','Incorrect Old Password');
        }

    }

    public function showProfile() {
        return view('patient.profile');
    }

    public function showEdit() {
        return view('patient.edit');
    }

    public function editProfile(Request $request) {
        $data = $request->all();
        // echo "<pre>"; print_r($data); die;
        $update = Auth::guard('web')->user()->update([
            'name'=>$data['name'],
            'phone'=>$data['phone'],
            'dob' => $data['dob'],
            'sex'=> $data['sex']
        ]);

        if($update){
            return redirect(route('patient.view'))->with('flash_message_success','Profile Updated');
        } else return redirect()->back()->with('flash_message_error','Unable to Update profile: Check Input details');
    }
}
