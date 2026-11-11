<?php  
    if(isset($request)){
        echo "<h1>Results</h1>";
        echo "Email: ".$request->email."<br>";
        echo "Name: ".$request->name."<br>";
        echo "Password: ".$request->passw."<br>";
        echo "City: ".$request->city."<br>";
        echo "Age: ".$request->age."<p>";
    }
?>
<!doctype html>
<html>
 <head>
  <meta charset="UTF-8">
  <title>Laravel</title>
 </head>
 <body>
	<form method="post" action="form5">
                @csrf        
                @if (count($errors) > 0)
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                @endif   
                <h1>Form</h1>   
                @if ($errors->has('email'))<strong>{{ $errors->first('email') }}</strong><br>@endif   
                <label>E-mail:</label><input type="text" name="email"><br>
                @if ($errors->has('name'))<strong>{{ $errors->first('name') }}</strong><br>@endif
                <label>Name:</label><input type="text" name="name"><br>
                @if ($errors->has('passw'))<strong>{{ $errors->first('passw') }}</strong><br>@endif
                <label>Password:</label><input type="password" name="passw"><br>
                <label>City:</label>
                <select name="city">
                        <option value="1">London</option>
                        <option value="2">Paris</option>
                        <option value="3">Berlin</option>
                        <option value="4">Rome</option>
                </select><br>
                @if ($errors->has('age'))<strong>{{ $errors->first('age') }}</strong><br>@endif
                <label>Age:</label><input type="number" name="age"><br>
                <label></label><input type="submit" value="Send">
	</form>
 </body>
</html>