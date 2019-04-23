<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DepartmentController extends Controller
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
        $departments = DB::select('SELECT * FROM departments ORDER BY date_created DESC');
        $count = DB::table('departments')->count();
        $data = array(
            'departments' => $departments,
            'count' => $count,
            'title' => 'Departments'
        );
        return view('departments/index')->with($data);
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
            return view('departments/new')->with($data);
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
                'teacher_id' => 'required'
            ]);
            $name = $request->input('name');
            $description = $request->input('description');
            $teacher_id= $request->input('teacher_id');
            DB::table('departments')->insert(
                ['name' => $name, 'description' => $description, 'teacher_id' => $teacher_id
                ]
            );
            return redirect('/departments')->with('success', 'Department created.');
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
            $department = DB::select('select * from departments where id = ?', array($id));
            if (empty($department)) {
                return view('404');
            }
            $data = array(
                'title' => 'Edit',
                'department' => $department
            );
            return view('departments/edit')->with($data);
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
            $department = DB::select('select * from departments where id = ?', array($id));
            if (empty($department)) {
                return view('404');
            } else {
                $validatedData = $request->validate([
                    'name' => 'required',
                    'description' => 'required',
                    'teacher_id' => 'required'
                ]);
                $name = $request->input('name');
                $description = $request->input('description');
                $teacher_id= $request->input('teacher_id');
                DB::table('departments')
                    ->where('id', $id)
                    ->update(['name' => $name, 'description' => $description, 'teacher_id' => $teacher_id]);
                return redirect('/departments')->with('success', 'Department edited.');

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
            $department = DB::select('select * from departments where id = ?', array($id));
            if (empty($department)) {
                return view('404');
            } else {
                DB::table('departments')->where('id', '=', $id)->delete();
                return redirect('/departments')->with('success', 'Department deleted.');
            }
        } else {
            return redirect('/');
        }
    }
}
