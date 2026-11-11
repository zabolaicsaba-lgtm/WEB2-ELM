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
<!doctype html>
<html>
 <head>
  <meta charset="UTF-8">
  <title>Laravel</title>
 </head>
 <body>
	<form method="post" action="form4b">
                @csrf                
                <label>E-mail:</label><input type="email" name="email" required><br>
                <label>Name:</label><input type="text" name="name" pattern="[A-Z,a-z, ]{8}[A-Z,a-z, ]*" required><br>
                <label>Password:</label><input type="password" name="passw" pattern="{6,12}" required><br>
                <label>City:</label>
                <select name="city">
                        <option value="1">London</option>
                        <option value="2">Paris</option>
                        <option value="3">Berlin</option>
                        <option value="4">Rome</option>
                </select><br>
                <label>Age:</label><input type="number" name="age" min="10" max="120" required><br>
                <label></label><input type="submit" value="Send">
	</form>
 </body>
</html>