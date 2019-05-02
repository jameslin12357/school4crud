<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $teachers = DB::select('SELECT * FROM teachers ORDER BY date_created DESC');
        $count = DB::table('teachers')->count();
        $data = array(
            'teachers' => $teachers,
            'count' => $count,
            'title' => 'Teachers'
        );
        return view('teachers/index')->with($data);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $level = Auth::user()->level;
        if ($level === 1){
            $data = array(
                'title' => 'Create'
            );
            return view('teachers/new')->with($data);
        } else {
            return redirect('/');
        }

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $level = Auth::user()->level;
        if ($level === 1){
            $validatedData = $request->validate([
                'first_name' => 'required',
                'last_name' => 'required',
                'age' => 'required',
                'dob' => 'required',
                'email' => 'required',
                'phone_number' => 'required',
                'gender_id' => 'required',
                'address_id' => 'required'
            ]);
            $first_name = $request->input('first_name');
            $last_name = $request->input('last_name');
            $age = $request->input('age');
            $dob = $request->input('dob');
            $email = $request->input('email');
            $phone_number = $request->input('phone_number');
            $gender_id = $request->input('gender_id');
            $address_id = $request->input('address_id');
            DB::table('studentscourses')->insert(
                ['first_name' => $first_name, 'last_name' => $last_name,'age' => $age,'dob' => $dob,'email' => $email,'phone_number' => $phone_number,'gender_id' => $gender_id,'address_id' => $address_id
                ]
            );
            return redirect('/teachers')->with('success', 'Teacher created.');
        } else {
            return redirect('/');
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $level = Auth::user()->level;
        if ($level === 1){
            $teacher = DB::select('select * from teachers where id = ?', array($id));
            if (empty($teacher)) {
                return view('404');
            }
            $data = array(
                'title' => 'Edit',
                'teacher' => $teacher
            );
            return view('teachers/edit')->with($data);
        } else {
            return redirect('/');
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $level = Auth::user()->level;
        if ($level === 1){
            $teacher = DB::select('select * from teachers where id = ?', array($id));
            if (empty($teacher)) {
                return view('404');
            } else {
                $validatedData = $request->validate([
                    'first_name' => 'required',
                    'last_name' => 'required',
                    'age' => 'required',
                    'dob' => 'required',
                    'email' => 'required',
                    'phone_number' => 'required',
                    'gender_id' => 'required',
                    'address_id' => 'required'
                ]);
                $first_name = $request->input('first_name');
                $last_name = $request->input('last_name');
                $age = $request->input('age');
                $dob = $request->input('dob');
                $email = $request->input('email');
                $phone_number = $request->input('phone_number');
                $gender_id = $request->input('gender_id');
                $address_id = $request->input('address_id');
                DB::table('teachers')
                    ->where('id', $id)
                    ->update(['first_name' => $first_name, 'last_name' => $last_name,'age' => $age,'dob' => $dob,'email' => $email,'phone_number' => $phone_number,'gender_id' => $gender_id,'address_id' => $address_id
                    ]);
                return redirect('/teachers')->with('success', 'Teacher edited.');

            }
        } else {
            return redirect('/');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $level = Auth::user()->level;
        if ($level === 1){
            $teacher = DB::select('select * from teachers where id = ?', array($id));
            if (empty($teacher)) {
                return view('404');
            } else {
                DB::table('teachers')->where('id', '=', $id)->delete();
                return redirect('/teachers')->with('success', 'Teacher deleted.');
            }
        } else {
            return redirect('/');
        }
    }
}
