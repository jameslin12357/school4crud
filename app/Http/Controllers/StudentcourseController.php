<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StudentcourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $studentscourses = DB::select('SELECT * FROM studentscourses ORDER BY date_created DESC');
        $count = DB::table('studentscourses')->count();
        $data = array(
            'studentscourses' => $studentscourses,
            'count' => $count,
            'title' => 'Studentscourses'
        );
        return view('studentscourses/index')->with($data);
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
            return view('studentscourses/new')->with($data);
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
                'grade' => 'required',
                'student_id' => 'required',
                'course_id' => 'required'
            ]);
            $grade = $request->input('grade');
            $student_id = $request->input('student_id');
            $course_id = $request->input('course_id');
            DB::table('studentscourses')->insert(
                ['grade' => $grade, 'student_id' => $student_id,'course_id' => $course_id
                ]
            );
            return redirect('/studentscourses')->with('success', 'Studentcourse created.');
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
            $studentcourse = DB::select('select * from studentscourses where id = ?', array($id));
            if (empty($studentcourse)) {
                return view('404');
            }
            $data = array(
                'title' => 'Edit',
                'studentcourse' => $studentcourse
            );
            return view('studentscourses/edit')->with($data);
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
            $studentcourse = DB::select('select * from studentscourses where id = ?', array($id));
            if (empty($studentcourse)) {
                return view('404');
            } else {
                $validatedData = $request->validate([
                    'grade' => 'required',
                    'student_id' => 'required',
                    'course_id' => 'required'
                ]);
                $grade = $request->input('grade');
                $student_id = $request->input('student_id');
                $course_id = $request->input('course_id');
                DB::table('studentscourses')
                    ->where('id', $id)
                    ->update(['grade' => $grade, 'student_id' => $student_id,'course_id' => $course_id
                    ]);
                return redirect('/studentscourses')->with('success', 'Studentcourse edited.');

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
            $studentcourse = DB::select('select * from studentscourses where id = ?', array($id));
            if (empty($studentcourse)) {
                return view('404');
            } else {
                DB::table('studentscourses')->where('id', '=', $id)->delete();
                return redirect('/studentscourses')->with('success', 'Studentcourse deleted.');
            }
        } else {
            return redirect('/');
        }
    }
}
