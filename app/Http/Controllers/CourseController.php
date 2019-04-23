<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
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
        $courses = DB::select('SELECT * FROM courses ORDER BY date_created DESC');
        $count = DB::table('courses')->count();
        $data = array(
            'courses' => $courses,
            'count' => $count,
            'title' => 'Courses'
        );
        return view('courses/index')->with($data);
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
            return view('courses/new')->with($data);
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
                'name' => 'required',
                'description' => 'required',
                'section_id' => 'required',
                'department_id' => 'required',
                'room_id' => 'required'
            ]);
            $name = $request->input('name');
            $description = $request->input('description');
            $section_id= $request->input('section_id');
            $department_id = $request->input('department_id');
            $room_id = $request->input('room_id');
            DB::table('courses')->insert(
                ['name' => $name, 'description' => $description, 'section_id' => $section_id, 'department_id' => $department_id, 'room_id' => $name
                ]
            );
            return redirect('/courses')->with('success', 'Course created.');
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
            $course = DB::select('select * from courses where id = ?', array($id));
            if (empty($course)) {
                return view('404');
            }
            $data = array(
                'title' => 'Edit',
                'course' => $course
            );
            return view('courses/edit')->with($data);
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
            $course = DB::select('select * from courses where id = ?', array($id));
            if (empty($course)) {
                return view('404');
            } else {
                $validatedData = $request->validate([
                    'name' => 'required',
                    'description' => 'required',
                    'section_id' => 'required',
                    'department_id' => 'required',
                    'room_id' => 'required'
                ]);
                $name = $request->input('name');
                $description = $request->input('description');
                $section_id= $request->input('section_id');
                $department_id = $request->input('department_id');
                $room_id = $request->input('room_id');
                DB::table('courses')
                    ->where('id', $id)
                    ->update(['name' => $name, 'description' => $description, 'section_id' => $section_id, 'department_id' => $department_id, 'room_id' => $room_id]);
                return redirect('/courses')->with('success', 'Course edited.');

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
            $course = DB::select('select * from courses where id = ?', array($id));
            if (empty($course)) {
                return view('404');
            } else {
                DB::table('courses')->where('id', '=', $id)->delete();
                return redirect('/courses')->with('success', 'Courses deleted.');
            }
        } else {
            return redirect('/');
        }
    }
}
