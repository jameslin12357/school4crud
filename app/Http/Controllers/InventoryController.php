<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $inventories = DB::select('SELECT * FROM inventories ORDER BY date_created DESC');
        $count = DB::table('inventories')->count();
        $data = array(
            'inventories' => $inventories,
            'count' => $count,
            'title' => 'Inventories'
        );
        return view('inventories/index')->with($data);
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
            return view('inventories/new')->with($data);
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
                'stock' => 'required',
                'manufacturer_id' => 'required'
            ]);
            $name = $request->input('name');
            $description = $request->input('description');
            $stock = $request->input('stock');
            $manufacturer_id = $request->input('manufacturer_id');
            DB::table('customers')->insert(
                ['name' => $name, '$description' => $description,'stock' => $stock,'$manufacturer_id' => $manufacturer_id
                ]
            );
            return redirect('/inventories')->with('success', 'Inventory created.');
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
            $inventory = DB::select('select * from inventories where id = ?', array($id));
            if (empty($inventory)) {
                return view('404');
            }
            $data = array(
                'title' => 'Edit',
                'inventory' => $inventory
            );
            return view('inventories/edit')->with($data);
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
            $inventory = DB::select('select * from inventories where id = ?', array($id));
            if (empty($customer)) {
                return view('404');
            } else {
                $validatedData = $request->validate([
                    'name' => 'required',
                    'description' => 'required',
                    'stock' => 'required',
                    'manufacturer_id' => 'required'
                ]);
                $name = $request->input('name');
                $description = $request->input('description');
                $stock = $request->input('stock');
                $manufacturer_id = $request->input('manufacturer_id');
                DB::table('customers')
                    ->where('id', $id)
                    ->update(['name' => $name, '$description' => $description,'stock' => $stock,'$manufacturer_id' => $manufacturer_id
                    ]);
                return redirect('/inventories')->with('success', 'Inventory edited.');

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
            $inventory = DB::select('select * from inventories where id = ?', array($id));
            if (empty($inventory)) {
                return view('404');
            } else {
                DB::table('inventories')->where('id', '=', $id)->delete();
                return redirect('/inventories')->with('success', 'Inventory deleted.');
            }
        } else {
            return redirect('/');
        }
    }
}
