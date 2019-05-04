@extends('layouts.app')

@section('content')

    <div class="container pt-100">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <h3 class="login-heading mb-4 text-center">Create customerstaffinventory</h3>
                <form action="/customersstaffsinventories" method="post">
                    @csrf
                    <div class="form-group">
                        <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Customerstaff id" value="{{ old('customersstaffs_id') }}" name="customersstaffs_id" required>
                    </div>
                    @if ($errors->has('customersstaffs_id'))
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('customersstaffs_id') }}</strong>
                                    </span>
                    @endif

                    <div class="form-group">
                        <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Inventory id" value="{{ old('inventory_id') }}" name="inventory_id" required>
                    </div>
                    @if ($errors->has('inventory_id'))
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('inventory_id') }}</strong>
                                    </span>
                    @endif




                    <button type="submit" class="btn btn-primary btn-lg btn-block">Submit</button>

                </form>
            </div>
        </div>
    </div>

@endsection