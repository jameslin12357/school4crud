<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::resource('addresses', 'AddressController');
Route::resource('attendances', 'AttendanceController');
Route::resource('courses', 'CourseController');
Route::resource('departments', 'DepartmentController');
Route::resource('genders', 'GenderController');
Route::resource('rooms', 'RoomController');
Route::resource('sections', 'SectionController');
Route::resource('students', 'StudentController');
Route::resource('studentscourses', 'StudentcourseController');
Route::resource('teachers', 'TeacherController');
Route::resource('teacherscourses', 'TeachercourseController');
Route::resource('users', 'UserController');
