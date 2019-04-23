<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $attendances = DB::select('SELECT * FROM attendances ORDER BY date_created DESC');
        $count = DB::table('attendances')->count();
        $data = array(
            'attendances' => $attendances,
            'count' => $count,
            'title' => 'Attendances'
        );
        return view('attendances/index')->with($data);
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
            return view('attendances/new')->with($data);
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
                'student_id' => 'required'
            ]);
            $student_id = $request->input('student_id');
            DB::table('attendances')->insert(
                ['student_id' => $student_id
                ]
            );
            return redirect('/attendances')->with('success', 'Attendance created.');
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
            $attendance = DB::select('select * from attendances where id = ?', array($id));
            if (empty($attendance)) {
                return view('404');
            }
            $data = array(
                'title' => 'Edit',
                'attendance' => $attendance
            );
            return view('attendances/edit')->with($data);
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
            $attendance = DB::select('select * from attendances where id = ?', array($id));
            if (empty($attendance)) {
                return view('404');
            } else {
                $validatedData = $request->validate([
                    'student_id' => 'required'
                ]);
                $student_id = $request->input('student_id');
                DB::table('attendances')
                    ->where('id', $id)
                    ->update(['student_id' => $student_id]);
                return redirect('/attendances')->with('success', 'Attendance edited.');

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
            $attendance = DB::select('select * from attendances where id = ?', array($id));
            if (empty($attendance)) {
                return view('404');
            } else {
                DB::table('attendances')->where('id', '=', $id)->delete();
                return redirect('/attendances')->with('success', 'Attendance deleted.');
            }
        } else {
            return redirect('/');
        }
    }
}
