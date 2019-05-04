<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ManufacturerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $manufacturers = DB::select('SELECT * FROM manufacturers ORDER BY date_created DESC');
        $count = DB::table('manufacturers')->count();
        $data = array(
            'manufacturers' => $manufacturers,
            'count' => $count,
            'title' => 'Manufacturers'
        );
        return view('manufacturers/index')->with($data);
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
            return view('manufacturers/new')->with($data);
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
                'contact_number' => 'required',
                'contact_person_first_name' => 'required',
                'contact_person_last_name' => 'required'
            ]);
            $name = $request->input('name');
            $contact_number = $request->input('contact_number');
            $contact_person_first_name = $request->input('contact_person_first_name');
            $contact_person_last_name = $request->input('contact_person_last_name');
            DB::table('customers')->insert(
                ['name' => $name, '$contact_number' => $contact_number,'$contact_person_first_name' => $contact_person_first_name,'$contact_person_last_name' => $contact_person_last_name
                ]
            );
            return redirect('/manufacturers')->with('success', 'Manufacturer created.');
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
            $manufacturer = DB::select('select * from manufacturers where id = ?', array($id));
            if (empty($manufacturer)) {
                return view('404');
            }
            $data = array(
                'title' => 'Edit',
                'manufacturer' => $manufacturer
            );
            return view('manufacturers/edit')->with($data);
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
            $manufacturer = DB::select('select * from manufacturers where id = ?', array($id));
            if (empty($manufacturer)) {
                return view('404');
            } else {
                $validatedData = $request->validate([
                    'name' => 'required',
                    'contact_number' => 'required',
                    'contact_person_first_name' => 'required',
                    'contact_person_last_name' => 'required'
                ]);
                $name = $request->input('name');
                $contact_number = $request->input('contact_number');
                $contact_person_first_name = $request->input('contact_person_first_name');
                $contact_person_last_name = $request->input('contact_person_last_name');
                DB::table('manufacturers')
                    ->where('id', $id)
                    ->update(['name' => $name, 'contact_number' => $contact_number,'contact_person_first_name' => $contact_person_first_name,'contact_person_last_name' => $contact_person_last_name
                    ]);
                return redirect('/manufacturers')->with('success', 'Manufacturer edited.');

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
            $manufacturer = DB::select('select * from manufacturers where id = ?', array($id));
            if (empty($manufacturer)) {
                return view('404');
            } else {
                DB::table('manufacturers')->where('id', '=', $id)->delete();
                return redirect('/manufacturers')->with('success', 'Manufacturer deleted.');
            }
        } else {
            return redirect('/');
        }
    }
}
