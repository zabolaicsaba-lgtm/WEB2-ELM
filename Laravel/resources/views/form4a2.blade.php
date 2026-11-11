<pre>
<?php  
    if(isset($request)){
        print_r($request->input());
        echo "Email: ".$request->input('email')."<br>";
        echo "Email: ".$request->email."<br>";
        echo "Name: ".$request->name."<br>";
        echo "Password: ".$request->passw."<br>";
        echo "City: ".$request->city."<br>";
        echo "Age: ".$request->age."<p>";
    }
?>
</pre>