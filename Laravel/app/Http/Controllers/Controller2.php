<?php
namespace App\Http\Controllers;
class Controller2 extends Controller
{
    public function print1()
    {
		  echo "Hello2";
    }

    public function print2()
    {
		  $data = array('data1' => "abc",'data2' => 5);
		  return view('view2p2', $data);
    }

    public function print3()
    {
		  $data = array('data1' => "abc",'data2' => 5, 'data3' => array('aaa' => 20, 'bbb' => 25), 'data4' => array('ccc' => array('ddd' => 35, 'eee' => 45)));
	  	return view('view2p3', $data);
    }

}
