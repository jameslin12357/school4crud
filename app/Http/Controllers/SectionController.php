<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $sections = DB::select('SELECT * FROM sections ORDER BY date_created DESC');
        $count = DB::table('sections')->count();
        $data = array(
            'sections' => $sections,
            'count' => $count,
            'title' => 'Sections'
        );
        return view('sections/index')->with($data);
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
            return view('sections/new')->with($data);
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
                'start' => 'required',
                'end' => 'required'
            ]);
            $name = $request->input('name');
            $start = $request->input('start');
            $end = $request->input('end');
            DB::table('sections')->insert(
                ['name' => $name, 'start' => $start,'end' => $end
                ]
            );
            return redirect('/sections')->with('success', 'Section created.');
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
            $section = DB::select('select * from sections where id = ?', array($id));
            if (empty($section)) {
                return view('404');
            }
            $data = array(
                'title' => 'Edit',
                'section' => $section
            );
            return view('sections/edit')->with($data);
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
            $section = DB::select('select * from sections where id = ?', array($id));
            if (empty($section)) {
                return view('404');
            } else {
                $validatedData = $request->validate([
                    'name' => 'required',
                    'start' => 'required',
                    'end' => 'required'
                ]);
                $name = $request->input('name');
                $start = $request->input('start');
                $end = $request->input('end');
                DB::table('sections')
                    ->where('id', $id)
                    ->update(['name' => $name, 'start' => $start,'end' => $end]);
                return redirect('/sections')->with('success', 'Section edited.');

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
            $section = DB::select('select * from sections where id = ?', array($id));
            if (empty($section)) {
                return view('404');
            } else {
                DB::table('sections')->where('id', '=', $id)->delete();
                return redirect('/sections')->with('success', 'Section deleted.');
            }
        } else {
            return redirect('/');
        }
    }
}
