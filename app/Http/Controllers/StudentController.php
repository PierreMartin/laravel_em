<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Student;

class StudentController extends Controller
{

    public function tag() {
        return Tag::all();
    }

    public function show() {
        return Student::all();
    }

    public function showStudent($id) {
        //return "Hello $id";
        return view('student', ['id' => $id]); // va chercher le fichier template 'student.blade.php'
    }





}
