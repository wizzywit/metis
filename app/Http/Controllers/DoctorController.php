<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Image;
use App\Doctor;
use File;
use App\Appointment;
use App\Mail\ScheduleMail;
use App\Mail\DoneMail;
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
        $appointments = Appointment::with('patient')->where(['doctor_id'=>Auth::guard('doctor')->id(),'payed'=>true, 'done'=>false])->get();
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
            'doctor_number'=> Auth::guard('doctor')->user()->phone,
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
        $appointments = Appointment::with('patient')->where(['doctor_id'=>Auth::guard('doctor')->id(),'payed'=>true, 'scheduled'=>true, 'done' => false])->get();
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


    public function todayAppointments() {
        $date = date('Y-m-d');
        $appointments = Appointment::with('patient')->where(['doctor_id'=>Auth::guard('doctor')->id(),'payed'=>true, 'scheduled'=>true, 'date'=>$date, 'done'=>false])->get();
        return view('doctor.today')->with(compact('appointments'));

    }

    public function viewAppointments() {
        $appointments = Appointment::with('patient')->where(['doctor_id'=>Auth::guard('doctor')->id(),'payed'=>true, 'scheduled'=>true, 'done'=>false])->get();
        return view('doctor.appointments')->with(compact('appointments'));
    }

    public function appointmentsCalender() {
        $events = [];
        $appointments = Appointment::with('patient')->where(['doctor_id'=>Auth::guard('doctor')->id(),'payed'=>true, 'scheduled'=>true, 'done'=>false])->get();
        foreach($appointments as $appointment){

            $events[] = [
                'title'=> $appointment->patient->name,
                'start' => $appointment->date.' '.$appointment->start_time ,
                'end' => $appointment->date.' '.$appointment->end_time ,
                'url' => route('doctor.appointments'),
            ];
        }

        return view('doctor.calender')->with(compact('events'));
    }

    public function endAppointment($id = null) {
        $appointment = Appointment::with('patient')->where('id',$id)->first();


        $data = array(
            'start_time'=> $appointment->start_time,
            'end_time' => $appointment->end_time,
            'date' => $appointment->date,
            'doctor' => Auth::guard('doctor')->user()->name,
            'doctor_number'=> Auth::guard('doctor')->user()->phone,
            'room_name'=> $appointment->room_name,
        );

        Mail::to($appointment->patient->email)->send(new DoneMail($data));
        if(Mail::failures()){
            return redirect()->back()->with('flash_message_error','Unable to Close Appointment, Notification Mail Failed to send');
        } else {
            $appointment->update([
                'done' => true,
            ]);

            return redirect()->back()->with('flash_message_success','Appointment Closed Successfully');

        }

    }

    public function doneAppointments() {
        $appointments = Appointment::with('patient')->where([
            'doctor_id'=>Auth::guard('doctor')->id(),
            'done'=>true
        ])->get();
        return view('doctor.done')->with(compact('appointments'));
    }

    public function viewAppointment($id = null){
        $appointment = Appointment::with('patient')->where('id',$id)->first();
        return view('doctor.view')->with(compact('appointment'));
    }

    public function deleteAppointment($id = null) {
        $appointment = Appointment::where('id',$id)->first()->delete();

        if($appointment){
            return redirect()->back()->with('flash_message_success','Appointment Successfully Deleted');
        } else {
            return redirect()->back()->with('flash_message_error','Appointment Deletion Failed');
        }

    }


}
