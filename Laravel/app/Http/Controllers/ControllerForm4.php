<?php 
namespace App\Http\Controllers;
use Illuminate\Http\Request;
class ControllerForm4 extends Controller
{
    function printa(Request $request){
        return view('form4a2', compact('request'));
    }
    function printb(Request $request){
        return view('form4b', compact('request'));
    }
}