<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CustomerstaffinventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $customersstaffsinventories = DB::select('SELECT * FROM customersstaffsinventories ORDER BY date_created DESC');
        $count = DB::table('customersstaffsinventories')->count();
        $data = array(
            'customersstaffsinventories' => $customersstaffsinventories,
            'count' => $count,
            'title' => 'Customersstaffsinventories'
        );
        return view('customersstaffsinventories/index')->with($data);
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
            return view('customersstaffsinventories/new')->with($data);
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
                'customersstaffs_id' => 'required',
                'inventories_id' => 'required'
            ]);
            $customersstaffs_id = $request->input('customersstaffs_id');
            $inventories_id = $request->input('inventories');
            DB::table('customersstaffsinventories')->insert(
                ['customersstaffs_id' => $customersstaffs_id, 'inventories_id' => $inventories_id
                ]
            );
            return redirect('/customersstaffsinventories')->with('success', 'Customerstaffinventory created.');
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
            $customerstaffinventory = DB::select('select * from customersstaffsinventories where id = ?', array($id));
            if (empty($customerstaffinventory)) {
                return view('404');
            }
            $data = array(
                'title' => 'Edit',
                'customerstaffinventory' => $customerstaffinventory
            );
            return view('customersstaffsinventories/edit')->with($data);
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
            $customerstaffinventory = DB::select('select * from customersstaffsinventories where id = ?', array($id));
            if (empty($customerstaff)) {
                return view('404');
            } else {
                $validatedData = $request->validate([
                    'customersstaffs_id' => 'required',
                    'inventories_id' => 'required'
                ]);
                $customersstaffs_id = $request->input('customersstaffs_id');
                $inventories_id = $request->input('inventories');
                DB::table('customersstaffs')
                    ->where('id', $id)
                    ->update(['customersstaffs_id' => $customersstaffs_id, 'inventories_id' => $inventories_id
                    ]);
                return redirect('/customersstaffsinventories')->with('success', 'Customerstaffinventory edited.');

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
            $customerstaffinventory = DB::select('select * from customersstaffsinventories where id = ?', array($id));
            if (empty($customerstaffinventory)) {
                return view('404');
            } else {
                DB::table('customersstaffsinventories')->where('id', '=', $id)->delete();
                return redirect('/customersstaffsinventories')->with('success', 'Customerstaffinventory deleted.');
            }
        } else {
            return redirect('/');
        }
    }
}
