<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CustomerStaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $customersstaffs = DB::select('SELECT * FROM customersstaffs ORDER BY date_created DESC');
        $count = DB::table('customersstaffs')->count();
        $data = array(
            'customersstaffs' => $customersstaffs,
            'count' => $count,
            'title' => 'Customersstaffs'
        );
        return view('customersstaffs/index')->with($data);
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
            return view('customersstaffs/new')->with($data);
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
                'customer_id' => 'required',
                'staff_id' => 'required'
            ]);
            $customer_id = $request->input('customer_id');
            $staff_id = $request->input('staff');
            DB::table('customersstaffs')->insert(
                ['$customer_id' => $customer_id, 'staff_id' => $staff_id
                ]
            );
            return redirect('/customersstaffs')->with('success', 'Customerstaff created.');
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
            $customerstaff = DB::select('select * from customersstaffs where id = ?', array($id));
            if (empty($customerstaff)) {
                return view('404');
            }
            $data = array(
                'title' => 'Edit',
                'customerstaff' => $customerstaff
            );
            return view('customersstaffs/edit')->with($data);
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
            $customerstaff = DB::select('select * from customersstaffs where id = ?', array($id));
            if (empty($customerstaff)) {
                return view('404');
            } else {
                $validatedData = $request->validate([
                    'customer_id' => 'required',
                    'staff_id' => 'required'
                ]);
                $customer_id = $request->input('customer_id');
                $staff_id = $request->input('staff_id');
                DB::table('customersstaffs')
                    ->where('id', $id)
                    ->update(['customer_id' => $customer_id, 'staff_id' => $staff_id
                    ]);
                return redirect('/customersstaffs')->with('success', 'Customerstaff edited.');

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
            $customerstaff = DB::select('select * from customersstaffs where id = ?', array($id));
            if (empty($customerstaff)) {
                return view('404');
            } else {
                DB::table('customersstaffs')->where('id', '=', $id)->delete();
                return redirect('/customersstaffs')->with('success', 'Customerstaff deleted.');
            }
        } else {
            return redirect('/');
        }
    }
}
