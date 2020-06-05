<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use File;
use Image;
use App\Doctor;
use App\Patient;
use App\Appointment;
use Auth;
use App\Admin;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    /**
     * show dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $appointments = Appointment::get()->count();
        $doctors = Doctor::get()->count();
        $patients = Patient::get()->count();
        $appointments_completed = Appointment::where('done',true)->get()->count();
        return view('admin.home')->with(compact('appointments','doctors','patients','appointments_completed'));
    }

    public function showPasswordForm() {
        return view('admin.password');
    }


    //Ajax method to confirm inputted current password
    public function confirmPassword(Request $request){
        $current_password = $request->current_pwd;
        $chk_password = Auth::guard('admin')->user()->password;
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
        $chk_password = Auth::guard('admin')->user()->password;
        // echo "<pre>"; print_r($chk_password); die;

        if(Hash::check($current_password,$chk_password)){
            $id = Auth::guard('admin')->id();
            $admin = Admin::findOrFail($id);
            $admin->update([
                'password'=> Hash::make($data['password']),
            ]);
            return redirect()->back()->with('flash_message_success','Successfully Changed Password');
        }else {
            return redirect()->back()->with('flash_message_error','Incorrect Old Password');
        }

    }


    /*Doctor's Methods
    ** all doctor's methods described here ---
    **
    **
    **
    **
    **
    */
    public function showDoctors() {
        $doctors = Doctor::orderBy('id','desc')->get();
        return view('admin.doctors.index')->with(compact('doctors'));
    }

    public function verifyDoctor($id = null) {
        $doctor = Doctor::where('id',$id)->first();
        $doctor->verified = true;
        $doctor->save();
        if ($doctor){
            return redirect(route('admin.doctors'));
        } else {
            return redirect(route('admin.doctors'))->with('flash_message_error','Failed to verify Doctor');
        }
    }

    public function viewDoctor($id = null) {
        $doctor = Doctor::where('id',$id)->first();
        return view('admin.doctors.view')->with(compact('doctor'));
    }

    public function showEditDoctorForm($id = null){
        $doctor = Doctor::where('id',$id)->first();
        return view('admin.doctors.edit')->with(compact('doctor'));
    }

    public function editDoctor(Request $request, $id = null){
        $data = $request->all();
        $doctor = Doctor::where('id',$id)->first();
        $doctor->name =$data['name'];
        $doctor->sex =$data['sex'];
        $doctor->speciality =$data['speciality'];
        $doctor->qualification =$data['qualification'];
        $doctor->phone =$data['phone'];
        $doctor->hospital =$data['hospital'];
        $save = $doctor->save();
        if($save){
            return redirect(route('admin.doctors'))->with('flash_message_success','Doctor Successfully Edited');
        } else return redirect(route('admin.doctors'))->with('flash_message_error','Doctor Unable to be updated');
    }

    public function refuteDoctor($id = null){
        $doctor = Doctor::where('id',$id)->first();
        $doctor->verified = false;
        $doctor = $doctor->save();
        if ($doctor){
            return redirect(route('admin.doctors'));
        } else {
            return redirect(route('admin.doctors'))->with('flash_message_error','Failed to refute Doctor');
        }
    }

    public function deleteDoctor($id = null) {
        $doctor = Doctor::where('id',$id)->first();
        $this->deleteImage($doctor->passport);
        $doctor = $doctor->delete();
        if ($doctor){
            return redirect()->back()->with('flash_message_success','Doctor Successfully Deleted');
        } else {
            return redirect()->back()->with('flash_message_error','Failed to Delete Doctor');
        }

    }

    public function deleteImage($image) {
        $url = 'images/doctors/'.$image;
        return File::delete($url);

    }


    //show create doctor form
    public function createDoctor()
    {
        return view('admin.doctors.create');
    }

    public function storeDoctor(Request $request)
    {
        $data = $request->all();
        $this->validate($request,[
            'passport'=> 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'password'=> 'required|confirmed',
            'email' => ['required', 'string', 'email', 'max:255', 'unique:doctors'],
        ]);

        // echo "<pre>"; print_r($data); die;
        if($file = $request->hasFile('passport')){
            $file = $request->file('passport');
            $ext = $file->getClientOriginalExtension();
            $destinationPath = 'images/doctors/';
            $dbFileName = date('YmdHis').".".$ext;
            $filePath = $destinationPath.$dbFileName;
            Image::make($file)->save($filePath);
            $data['passport'] = $dbFileName;
        }

        Doctor::create([
            'passport'=>$data['passport'],
            'password' => Hash::make($data['password']),
            'name' => $data['name'],
            'email' => $data['email'],
            'speciality' => $data['speciality'],
            'qualification' => $data['qualification'],
            'phone' => $data['phone'],
            'hospital' => $data['hospital'],
            'sex' => $data['sex'],
        ]);

        $url = route('admin.doctors');
        return back()->with('flash_message_success','Doctor Successfully added <a href="'.$url.'">view doctors</a>');
    }



    /*Patient Methods
    ** all patients methods described here ---
    **
    **
    **
    **
    **
    */
    public function showPatients() {
        $patients = Patient::orderBy('id','desc')->get();
        return view('admin.patients.index')->with(compact('patients'));
    }

    public function viewPatient($id = null) {
        $patient = Patient::where('id',$id)->first();
        return view('admin.patients.view')->with(compact('patient'));
    }

    public function showEditPatientForm($id = null){
        $patient = Patient::where('id',$id)->first();
        return view('admin.patients.edit')->with(compact('patient'));
    }

    public function editPatient(Request $request, $id = null){
        $data = $request->all();
        $patients = Patient::where('email',$data['email'])->count();
        $patient = Patient::where('id',$id)->first();
        if($patient->email == $data['email']){
            $patient->name =$data['name'];
            $patient->sex =$data['sex'];
            $patient->dob =$data['dob'];
            $patient->phone =$data['phone'];
            $save = $patient->save();
            if($save){
                return redirect(route('admin.patients'))->with('flash_message_success','Patient Successfully Edited');
            } else return redirect(route('admin.patients'))->with('flash_message_error','Patient Unable to be updated');
        } else if($patients < 1){
            $patient->name =$data['name'];
            $patient->sex =$data['sex'];
            $patient->dob =$data['dob'];
            $patient->phone =$data['phone'];
            $patient->email =$data['email'];
            $save = $patient->save();
            if($save){
                return redirect(route('admin.patients'))->with('flash_message_success','Patient Successfully Edited');
            } else return redirect(route('admin.patients'))->with('flash_message_error','Patient Unable to be updated');
        } else {
             return redirect()->back()->with('flash_message_error','Email Already exist');
        }
    }

    public function deletePatient($id = null) {
        $patient = Patient::where('id',$id)->first();
        $patient = $patient->delete();
        if ($patient){
            return redirect()->back()->with('flash_message_success','Patient Successfully Deleted');
        } else {
            return redirect()->back()->with('flash_message_error','Failed to Delete Patient');
        }

    }

    public function createPatient()
    {
        return view('admin.patients.create');
    }

    public function storePatient(Request $request)
    {
        $data = $request->all();
        // echo "<pre>"; print_r($data); die;
        $this->validate($request,[
            'password'=> 'required|confirmed',
            'email' => ['required', 'string', 'email', 'max:255', 'unique:patients'],
        ]);

        // echo "<pre>"; print_r($data); die;

        Patient::create([
            'dob'=>$data['dob'],
            'password' => Hash::make($data['password']),
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'sex' => $data['sex'],
        ]);

        $url = route('admin.patients');
        return back()->with('flash_message_success','Patient Successfully added <a href="'.$url.'">view patients</a>');
    }


    /*Appointments Methods
    ** all appointments methods described here ---
    **
    **
    **
    **
    **
    */
    public function showAppointments() {
        $appointments = Appointment::with('doctor')->with('patient')->orderBy('id','desc')->get();
        return view('admin.appointments.index')->with(compact('appointments'));
    }

    public function showAppointmentsCalender() {
        $events = [];
        $appointments = Appointment::with('doctor')->with('patient')->orderBy('id','desc')->get();

        foreach($appointments as $appointment){

            $events[] = [
                'title'=> $appointment->patient->name.' {'.$appointment->doctor->name. '}',
                'start' => $appointment->date.' '.$appointment->start_time ,
                'end' => $appointment->date.' '.$appointment->end_time ,
                'url' => route('admin.appointment.view',$appointment->id)
            ];
        }

        // echo "<pre>"; print_r($events); die;
        return view('admin.appointments.calender_index')->with(compact('events'));
    }

    public function viewAppointment($id = null) {
        $appointment = Appointment::where('id',$id)->first();
        return view('admin.appointments.view')->with(compact('appointment'));
    }

    public function showEditAppointmentForm($id = null){
        $doctors = Doctor::get();
        $patients = Patient::get();
        $appointment = Appointment::where('id',$id)->first();
        $appointment['start_time'] = date("h:i A",strtotime($appointment['start_time']));
        $appointment['end_time'] = date("h:i A",strtotime($appointment['end_time']));
        return view('admin.appointments.edit')->with(compact('appointment','doctors','patients'));
    }

    public function editAppointment(Request $request, $id = null){
        $data = $request->all();
        // echo "<pre>"; print_r($data); die;
            $appointment = Appointment::where('id',$id)->first();
            $data['start_time'] = date("H:i:s",strtotime($data['start_time']));
            $data['end_time'] = date("H:i:s",strtotime($data['end_time']));

            $appointment->patient_id =$data['patient_id'];
            $appointment->doctor_id =$data['doctor_id'];
            $appointment->symptoms =$data['symptoms'];
            $appointment->price =$data['price'];
            $appointment->urgency_level =$data['urgency_level'];
            $appointment->date =$data['date'];
            $appointment->start_time =$data['start_time'];
            $appointment->end_time =$data['end_time'];
            $save = $appointment->save();
            if($save){
                return redirect(route('admin.appointments'))->with('flash_message_success','Appointment Successfully Edited');
            } else return redirect(route('admin.appointments'))->with('flash_message_error','Appointment Unable to be updated');
    }

    public function deleteAppointment($id = null) {
        $appointment = Appointment::where('id',$id)->first();
        $appointment = $appointment->delete();
        if ($appointment){
            return redirect()->back()->with('flash_message_success','Appointment Successfully Deleted');
        } else {
            return redirect()->back()->with('flash_message_error','Failed to Delete Appointment');
        }

    }

    public function scheduleAppointment($id = null, $flag = null){
        $appointment = Appointment::where('id',$id)->first();
        if($flag == '1'){
            $appointment->scheduled = true;
        } else if($flag =='0'){
            $appointment->scheduled = false;
        }
        $save = $appointment->save();
        if($save){
            return redirect(route('admin.appointments'))->with('flash_message_success','Appointment Scheduled Successfully');
        } else return redirect(route('admin.appointments'))->with('flash_message_error','Appointment Unable to be Scheduled');
    }

    public function createAppointment()
    {
        $doctors = Doctor::get();
        $patients = Patient::get();
        return view('admin.appointments.create')->with(compact('doctors','patients'));
    }

    public function storeAppointment(Request $request)
    {
        $data = $request->all();
        // echo "<pre>"; print_r($data); die;
        $this->validate($request,[
            'patient_id'=> 'required',
            'doctor_id'=> 'required',
            'start_time'=> 'required',
            'date'=> 'required',
        ]);

        $data['start_time'] = date("H:i:s",strtotime($data['start_time']));
        $data['end_time'] = date("H:i:s",strtotime($data['end_time']));

        // echo "<pre>"; print_r($data); die;

        Appointment::create([
            'patient_id'=>$data['patient_id'],
            'doctor_id' =>$data['doctor_id'],
            'start_time' => $data['start_time'],
            'end_time' => $data['end_time'],
            'price' => $data['price'],
            'date' => $data['date'],
            'urgency_level' => $data['urgency_level'],
            'symptoms' => $data['symptoms'],
        ]);

        $url = route('admin.appointments');
        return back()->with('flash_message_success','Appointment Successfully Created <a href="'.$url.'">view Appointments</a>');
    }

}
