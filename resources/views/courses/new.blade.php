@extends('layouts.app')

@section('content')

<div class="container pt-100">
    <div class="row">
        <div class="col-lg-6 offset-lg-3">
            <h3 class="login-heading mb-4 text-center">Create course</h3>
            <form action="/courses" method="post">
                @csrf
                <div class="form-group">
                    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Name" value="{{ old('name') }}" name="name" required>
                </div>
                @if ($errors->has('name'))
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                @endif
                <div class="form-group">
                    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Description" value="{{ old('description') }}" name="description" required>
                </div>
                @if ($errors->has('description'))
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                @endif
                <div class="form-group">
                    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Section id" value="{{ old('section_id') }}" name="section_id" required>
                </div>
                @if ($errors->has('section_id'))
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('section_id') }}</strong>
                                    </span>
                @endif
                <div class="form-group">
                    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Department id" value="{{ old('department_id') }}" name="department_id" required>
                </div>
                @if ($errors->has('department_id'))
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('department_id') }}</strong>
                                    </span>
                @endif
                <div class="form-group">
                    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Room id" value="{{ old('room_id') }}" name="room_id" required>
                </div>
                @if ($errors->has('room_id'))
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('room_id') }}</strong>
                                    </span>
                @endif


                <button type="submit" class="btn btn-primary btn-lg btn-block">Submit</button>

</form>
</div>
</div>
</div>

@endsection