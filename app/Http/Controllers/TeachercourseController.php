<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TeachercourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $teacherscourses = DB::select('SELECT * FROM teacherscourses ORDER BY date_created DESC');
        $count = DB::table('teacherscourses')->count();
        $data = array(
            'teacherscourses' => $teacherscourses,
            'count' => $count,
            'title' => 'Teacherscourses'
        );
        return view('teacherscourses/index')->with($data);
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
            return view('teacherscourses/new')->with($data);
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
                'student_id' => 'required',
                'course_id' => 'required'
            ]);
            $student_id = $request->input('student_id');
            $course_id = $request->input('course_id');
            DB::table('studentscourses')->insert(
                ['student_id' => $student_id,'course_id' => $course_id]
            );
            return redirect('/teacherscourses')->with('success', 'Teachercourse created.');
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
            $teachercourse = DB::select('select * from teacherscourses where id = ?', array($id));
            if (empty($teachercourse)) {
                return view('404');
            }
            $data = array(
                'title' => 'Edit',
                'teachercourse' => $teachercourse
            );
            return view('teacherscourses/edit')->with($data);
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
            $teachercourse = DB::select('select * from teacherscourses where id = ?', array($id));
            if (empty($teacher)) {
                return view('404');
            } else {
                $validatedData = $request->validate([
                    'student_id' => 'required',
                    'course_id' => 'required'
                ]);
                $student_id = $request->input('student_id');
                $course_id = $request->input('course_id');
                DB::table('teacherscourses')
                    ->where('id', $id)
                    ->update(                ['student_id' => $student_id,'course_id' => $course_id]
                    );
                return redirect('/teacherscourses')->with('success', 'Teachercourse edited.');

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
            $teachercourse = DB::select('select * from teacherscourses where id = ?', array($id));
            if (empty($teachercourse)) {
                return view('404');
            } else {
                DB::table('teacherscourses')->where('id', '=', $id)->delete();
                return redirect('/teacherscourses')->with('success', 'Teachercourse deleted.');
            }
        } else {
            return redirect('/');
        }
    }
}
