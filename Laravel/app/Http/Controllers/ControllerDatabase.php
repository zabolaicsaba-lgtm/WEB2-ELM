<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
class ControllerDatabase extends Controller
{
    public function read()
    {
      $workers = DB::table('workers')->where('age', "<" , '38')->get();
      // It's correct too: $workers = DB::select('select * from workers Where age<38');
      foreach ($workers as $worker) 
        print $worker->first_name."<br>";
    }
	
    public function write()
    {
      DB::table('workers')->insert([['first_name' => 'Steve', 'last_name' => 'Cooper', 'age' => 32]]);
      echo "Database write is ready.";
    }

}
