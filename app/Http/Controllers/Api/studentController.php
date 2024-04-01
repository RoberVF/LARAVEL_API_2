<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Student;
use Illuminate\Support\Facades\Validator;

class studentController extends Controller
{
    public function index()
    {
        $students = Student::all();

        if($students -> isEmpty()){
            $data = [
                'message' => 'No students founds!',
                'status' => 200
            ];
            return response() -> json($data, 404);
        }

        $data = [
            'students' => $students,
            'status' => 200
        ];

        return response() -> json($data, 200);
    }

    public function store(Request $request)
    {
        // Primero validar que el dato sea correcto
        $validator = Validator::make($request -> all(), [
            'name' => 'required | max:255',
            'email' => 'required | email | unique:student',
            'phone' => 'required | digits:9',
            'language' => 'required' 
        ]);

        if($validator -> fails()) {
            $data = [
                'message' => 'Error on data validation :(',
                'error' => $validator -> errors(),
                'status' => 400
            ];
            return response() -> json($data, 400);
        }

        // Si no hay error, creamos el Student
        $student = Student::create([
            'name' => $request -> name,
            'email' => $request -> email,
            'phone' => $request -> phone,
            'language' => $request -> language 
        ]);

        if(!$student) {
            $data = [
                'message' => 'Error creating the student :(',
                'status' => 500
            ];
            return response() -> json($data, 500);
        }

        $data = [
            'student' => $student,
            'status' => 201
        ];

        return response() -> json($data, 201);
    }

    public function show($id)
    {
        $student = Student::find($id);

        if(!$student){
            $data = [
                "message" => "Student not found",
                "status" => 404
            ];

            return response() -> json($data, 404);
        }

        $data = [
            "student" => $student,
            "status" => 200
        ];
        
        return response() -> json($data, 200);
    }

    public function destroy($id)
    {
        $student = Student::find($id);

        if(!$student){
            $data = [
                "message" => "Student not found",
                "status" => 404
            ];

            return response() -> json($data, 404);
        }

        $student -> delete();
        
        $data = [
            "message" => "Student deleted",
            "status" => 201
        ];

        return response() -> json($data, 201);
    }

    public function update (Request $request, $id)
    {
        $student = Student::find($id);

        if(!$student){
            $data = [
                "message" => "Student not found",
                "status" => 404
            ];

            return response() -> json($data, 404);
        }

        $validator = Validator::make($request -> all(), [
            'name' => 'required | max:255',
            'email' => 'required | email | unique:student',
            'phone' => 'required | digits:9',
            'language' => 'required' 
        ]);

        if($validator -> fails()){
            $data = [
                'message' => 'Error on data validation',
                'errors' => $validator -> errors(),
                'status' => 400
            ];

            return response() -> json($data, 400);
        }

        $student -> name = $request -> name;
        $student -> email = $request -> email;
        $student -> phone = $request -> phone;
        $student -> language = $request -> language;
        
        $student -> save();

        $data = [
            'student' => $student,
            'message' => "Student updated!",
            'status' => 201
        ];

        return response() -> json($data, 201);
    } 


    public function updatePartial(Request $request, $id)
    {
        $student = Student::find($id);

        if(!$student){
            $data = [
                'message' => 'Student not found',
                'status' => 404
            ];

            return response() -> json($data, 404);
        }

        $validator = Validator::make($request -> all(), [
            [
                'name' => 'max:255',
                'email' => 'email | unique:student',
                'phone' => 'digits:9',
                'language' => ''
            ]
        ]);

        if($validator -> fails()) {
            $data = [
                'message' => 'Error on data validation',
                'errors' => $validator -> errors(),
                'status' => 400
            ];

            return response() -> json($data, 400);
        }

        // Solo actualizar un campo
        if($request -> has('name')) {
            $student -> name = $request -> name;
        }
        if($request -> has('email')) {
            $student -> email = $request -> email;
        }
        if($request -> has('phone')) {
            $student -> phone = $request -> phone;
        }
        if($request -> has('language')) {
            $student -> language = $request -> language;
        }
        
        $student -> save();

        $data = [
            'student' => $student,
            'message' => 'Student updated',
            'status' => 200
        ];

        return response() -> json($data, 200);

    }
}
