@extends('layouts.app')

@section('content')

    <div class="container pt-100">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <h3 class="login-heading mb-4 text-center">Edit customerstaffinventory</h3>
                <form action="/customersstaffsinventories/{{ $customerstaffinventory[0]->id }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Customerstaff id" value="{{ old( 'customersstaffs_id', $customerstaffinventory[0]->customersstaffs_id) }}" name="customersstaffs_id" required>
                    </div>
                    @if ($errors->has('customersstaffs_id'))
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('customersstaffs_id') }}</strong>
                                    </span>
                    @endif

                    <div class="form-group">
                        <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Inventory id" value="{{ old( 'inventories_id', $customerstaffinventory[0]->inventories_id) }}" name="inventories_id" required>
                    </div>
                    @if ($errors->has('inventories_id'))
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('inventories_id') }}</strong>
                                    </span>
                    @endif



                    <button type="submit" class="btn btn-primary btn-lg btn-block">Submit</button>

                </form>
            </div>
        </div>
    </div>

@endsection