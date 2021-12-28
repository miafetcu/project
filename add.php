<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <?php
        include 'conn.php';
        $conn = OpenCon();

        $name=$lastname=$gender=$age=$bio="";
        $name_error=$lastname_error=$gender_error=$age_error=""; 


        if ($_SERVER["REQUEST_METHOD"] == "GET") {
          if (empty($_GET["fname"])) {
            $name_error='*Name is required';
          } else {
            $name = test_input($_GET["fname"]);
            // check if name only contains letters and whitespace
            if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
              $name_error = "*Only letters and white space allowed";
             }
          }
          if (empty($_GET["lname"])) {
              $lastname_error='*Last name is required';
          } else {
              $lastname = test_input($_GET["lname"]);
              // check if name only contains letters and whitespace
              if (!preg_match("/^[a-zA-Z-' ]*$/",$lastname)) {
                  $lastname_error = "*Only letters and white space allowed";
              }
          }  
          
          if (empty($_GET["gender"])) {
            $gender_error = '*Select your gender';
          } else {
            $gender = test_input($_GET["gender"]);
          }

          if (empty($_GET["age"])) {
            $age_error='*Age required';
        } else {
            $age = test_input($_GET["age"]);
            // check if name only contains letters and whitespace
            if (!preg_match("/^[1-9][0-9]?$|^100$/",$age)) {
                $age_error = "*Only numbers";
            }
        }  

         
          if (empty($_GET["bio"])) {
            $bio='';
          } else {
            $bio = test_input($_GET["bio"]);
        
          }
         
          
          if($name_error==""  && $lastname_error== ""  && $gender_error=="" && $age_error == "" && $bio!= "")
          {
            // echo "adding profile";
            //       die();              
                  $sql = "INSERT INTO register (fname,lname,age,gender,bio)
                  VALUES ('$name', '$lastname','$age','$gender','$bio')";
                  

                 
                  if($conn->query($sql)){
                     header("Location:added.html");//redirect to other page
                  }

              
          
            }
            
            //   echo "not adding";
            // }
          }
      

        function test_input($data) {
          $data = trim($data);
          $data = stripslashes($data);
          $data = htmlspecialchars($data);

          return $data;
        }

      CloseCon($conn);

  ?>
    <span id="page2" ">
    
        <div id="div-background">
        <form id="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"  method="GET" >
          <h2 id="introduction1">
            Welcome to Hogwart Houses! <br> 
          </h2>
            <h3 id="introduction2">
            Start your profile by completing with info... <br>
          </h3>
    
          <fieldset>
          <legend><span class="number">1</span>Your basic info</legend>
             <span class="error"><?php echo $name_error;?></span><br>
          <label for="lname" class="label" > First Name:</label><br>
             <input class="input" type="text" name="fname" required id="fname" value="<?= $name ?>"  ><br>
             <span class="error"><?php echo $name_error;?></span><br>
          <label for="lname" class="label" > Last name:</label><br>
             <input class="input" type="text" name="lname" required id="lname" value="<?= $lastname ?>"  ><br>
             <span class="error"><?php echo $lastname_error;?></span><br>
          <label for="gender"  class="label">Gender:</label><br>
          <select name="gender" >
                    <option value="" class="option1">Gender</option>
                    <option value="Female">Female</option>
                    <option value="Male">Male</option>
                </select>
                <br><span class="error"> <?php echo $gender_error;?></span>
            
          <label for="age" class="label">Age:</label><br>
             <input class="input" type="text" name="age" required id="age"  value="<?= $age ?>"><br>
             <span class="error"><?php echo $age_error;?></span> <br>
          </fieldset>

          <fieldset>
            <legend><span class="number">2</span>Your profile</legend>
          <label for="bio" class="label">Biography:</label><br>
          <input class="input" type="text" id="bio" name="bio" value="<?php echo $bio;?>"><br>
          
        </fieldset>
        <button type="submit" name="submit" id="submit-account" onclick="location.href='added.html';"">Create Account</button>
        
      </form>
    </div>
    </span>
    
</body>
</html>