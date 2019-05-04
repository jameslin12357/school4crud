@extends('layouts.app')

@section('content')

    <div class="container pt-100">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <h3 class="login-heading mb-4 text-center">Create manufacturer</h3>
                <form action="/manufacturers" method="post">
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
                        <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Contact number" value="{{ old('contact_number') }}" name="contact_number" required>
                    </div>
                    @if ($errors->has('contact_number'))
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('contact_number') }}</strong>
                                    </span>
                    @endif

                    <div class="form-group">
                        <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Contact person first name" value="{{ old('contact_person_first_name') }}" name="contact_person_first_name" required>
                    </div>
                    @if ($errors->has('contact_person_first_name'))
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('contact_person_first_name') }}</strong>
                                    </span>
                    @endif

                    <div class="form-group">
                        <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Contact person last name" value="{{ old('contact_person_last_name') }}" name="contact_person_last_name" required>
                    </div>
                    @if ($errors->has('contact_person_last_name'))
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('contact_person_last_name') }}</strong>
                                    </span>
                    @endif



                    <button type="submit" class="btn btn-primary btn-lg btn-block">Submit</button>

                </form>
            </div>
        </div>
    </div>

@endsection