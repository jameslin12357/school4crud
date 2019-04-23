<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $rooms = DB::select('SELECT * FROM rooms ORDER BY date_created DESC');
        $count = DB::table('rooms')->count();
        $data = array(
            'rooms' => $rooms,
            'count' => $count,
            'title' => 'Rooms'
        );
        return view('rooms/index')->with($data);
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
            return view('rooms/new')->with($data);
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
                'number' => 'required'
            ]);
            $number = $request->input('number');
            DB::table('rooms')->insert(
                ['number' => $number
                ]
            );
            return redirect('/rooms')->with('success', 'Room created.');
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
            $room = DB::select('select * from rooms where id = ?', array($id));
            if (empty($room)) {
                return view('404');
            }
            $data = array(
                'title' => 'Edit',
                'room' => $room
            );
            return view('rooms/edit')->with($data);
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
            $room = DB::select('select * from rooms where id = ?', array($id));
            if (empty($room)) {
                return view('404');
            } else {
                $validatedData = $request->validate([
                    'number' => 'required'
                ]);
                $number = $request->input('number');
                DB::table('rooms')
                    ->where('id', $id)
                    ->update(['number' => $number]);
                return redirect('/rooms')->with('success', 'Room edited.');

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
            $room = DB::select('select * from rooms where id = ?', array($id));
            if (empty($room)) {
                return view('404');
            } else {
                DB::table('rooms')->where('id', '=', $id)->delete();
                return redirect('/rooms')->with('success', 'Room deleted.');
            }
        } else {
            return redirect('/');
        }
    }
}
