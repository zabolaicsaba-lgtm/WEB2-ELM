<?php 
namespace App\Http\Controllers;
use Illuminate\Http\Request;

class ControllerForm5 extends Controller
{
    public function PrintFormContent(Request $request) {
        $request->validate([
           'email'=>'required|email|min:8',
           'name'=>'required|max:15',
           'passw'=>'required',
           'age'=>'required',
        ]);
        // If the validation rules pass, your code will keep executing normally:
        return view('form5', compact('request'));
    }
}