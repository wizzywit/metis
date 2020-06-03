<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Image;
use App\Doctor;
use File;
use App\Appointment;
use App\Mail\ScheduleMail;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;


class DoctorController extends Controller
{
    //
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:doctor');

    }

    /**
     * show dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $appointments = Appointment::with('patient')->where(['doctor_id'=>Auth::guard('doctor')->id(),'payed'=>true])->get();
        return view('doctor.home')->with(compact('appointments'));
    }

    public function showPasswordForm() {
        return view('doctor.password');
    }


    //Ajax method to confirm inputted current password
    public function confirmPassword(Request $request){
        $current_password = $request->current_pwd;
        $chk_password = Auth::guard('doctor')->user()->password;
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
        $chk_password = Auth::guard('doctor')->user()->password;
        // echo "<pre>"; print_r($chk_password); die;

        if(Hash::check($current_password,$chk_password)){
            $id = Auth::guard('doctor')->id();
            $admin = Doctor::findOrFail($id);
            $admin->update([
                'password'=> Hash::make($data['password']),
            ]);
            return redirect()->back()->with('flash_message_success','Successfully Changed Password');
        }else {
            return redirect()->back()->with('flash_message_error','Incorrect Old Password');
        }

    }

    public function showScheduleForm($id = null) {
        $appointment = Appointment::with('patient')->where('id',$id)->first();
        return view('doctor.schedule')->with(compact('appointment'));
    }

    public function schedule(Request $request, $id = null ){
        $appointment = Appointment::with('patient')->where('id',$id)->first();
        // echo "<pre>"; print_r($request->all()); die;
        $data = array(
            'start_time'=> $request->start_time,
            'end_time' => $request->end_time,
            'date' => $request->date,
            'doctor' => Auth::guard('doctor')->user()->name,
            'room_name'=> $request->room_name,
        );

        Mail::to($request->email)->send(new ScheduleMail($data));
        if(Mail::failures()){
            return redirect()->back()-with('flash_message_error','Unable to send Email Notifaction to Patient, Please Try again');
        } else {
            $appointment->update([
                'date' => $request->date,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'scheduled' => true,
                'room_name' => $request->room_name
            ]);

            return redirect(route('doctor.dashboard'))->with('flash_message_success', $request->name.'Appointment Successfully Booked');

        }



    }

    public function showProfile() {
        return view('doctor.profile');
    }

    public function showEdit() {
        return view('doctor.edit');
    }

    public function editProfile(Request $request) {
        $data = $request->all();
        // echo "<pre>"; print_r($data); die;
        $update = null;
        $request->validate([
            'passport' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048|dimensions:min_width=480,min_height=768',
        ]);
        if($file = $request->hasFile('passport')){
            // echo "has file upload"; die;
            $this->deleteImage(Auth::guard('doctor')->user()->passport);
            $file = $request->file('passport');
            $ext = $file->getClientOriginalExtension();
            $destinationPath = 'images/doctors/';
            $dbFileName = date('YmdHis').".".$ext;
            $filePath = $destinationPath.$dbFileName;
            Image::make($file)->save($filePath);
            $data = $request->all();
            $data['passport'] =  $dbFileName;

            $update = Auth::guard('doctor')->user()->update([
                'name'=>$data['name'],
                'phone'=>$data['phone'],
                'speciality' => $data['speciality'],
                'qualification' => $data['qualification'],
                'hospital' => $data['hospital'],
                'sex'=> $data['sex'],
                'passport' => $data['passport'],
            ]);
        } else {
            // echo "no file upload"; die;
            $update = Auth::guard('doctor')->user()->update([
                'name'=>$data['name'],
                'phone'=>$data['phone'],
                'speciality' => $data['speciality'],
                'qualification' => $data['qualification'],
                'hospital' => $data['hospital'],
                'sex'=> $data['sex']
            ]);
        }


        if($update){
            return redirect(route('doctor.view'))->with('flash_message_success','Profile Updated');
        } else return redirect()->back()->with('flash_message_error','Unable to Update profile: Check Input details');
    }

    public function deleteImage($image) {
        $url = 'images/doctors/'.$image;
        return File::delete($url);

    }

    public function showRooms() {
        $appointments = Appointment::with('patient')->where(['doctor_id'=>Auth::guard('doctor')->id(),'payed'=>true, 'scheduled'=>true])->get();
        return view('doctor.room')->with(compact('appointments'));
    }

    public function videoHome(Request $request)
    {
        $data = $request->all();
        $appointment = Appointment::with('patient')->where(['id'=> $data['room']])->first();
        $meeting = $appointment['room_name'];
        $string = preg_replace('/\s+/', '-', $appointment['room_name']);
        $channel = strtolower($string);
        $appointment = [
            "meeting" => $channel,
            "patient_id" => $appointment->patient->id,
            "patient_name" => $appointment->patient->name
        ];
        return view('doctor.video')->with(compact('appointment'));
    }


}
