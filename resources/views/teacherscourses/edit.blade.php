@extends('layouts.app')

@section('content')

    <div class="container pt-100">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <h3 class="login-heading mb-4 text-center">Edit teachercourse</h3>
                <form action="/teacherscourses/{{ $teachercourse[0]->id }}" method="post">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Teacher id" value="{{ old( 'teacher_id', $teachercourse[0]->teacher_id) }}" name="teacher_id" required>
                    </div>
                    @if ($errors->has('teacher_id'))
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('teacher_id') }}</strong>
                                    </span>
                    @endif

                    <div class="form-group">
                        <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Course id" value="{{ old( 'course_id', $teachercourse[0]->course_id) }}" name="course_id" required>
                    </div>
                    @if ($errors->has('course_id'))
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('course_id') }}</strong>
                                    </span>
                    @endif

                    <button type="submit" class="btn btn-primary btn-lg btn-block">Submit</button>

                </form>
            </div>
        </div>
    </div>

@endsection