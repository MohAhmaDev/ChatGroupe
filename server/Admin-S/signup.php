<?php
    session_start();
    include_once "../php/config.php";
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $name_user = mysqli_real_escape_string($conn, $_POST['name_user']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    if(!empty($fname) && !empty($lname) && !empty($email) && !empty($password) && !empty($name_user)){
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            $sql = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");
            if(mysqli_num_rows($sql) > 0)
            {
                echo "$email - This email already exist!";
            }
            else
            {
                $new_img_name = "icone.png";
                $ran_id = rand(time(), 100000000);
                $status = "Offline now";
                $encrypt_pass = password_hash($password, PASSWORD_BCRYPT, ['cost' => 14]);
                $insert_query1 = mysqli_query($conn, "INSERT INTO users (unique_id, fname, lname, email, password, img, status)
                VALUES ({$ran_id}, '{$fname}','{$lname}', '{$email}', '{$encrypt_pass}', '{$new_img_name}', '{$status}')");
                $insert_query2 = mysqli_query($conn, "INSERT INTO user_chat (name_user, mail_user, mdp_user)
                VALUES ('{$name_user}', '{$email}','{$encrypt_pass}')");
                if($insert_query1 && $insert_query2)
                {
                    $select_sql2 = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");
                    if(mysqli_num_rows($select_sql2) > 0)
                    {
                        echo "success registre";
                    }
                    else
                    {
                        echo "This email address not Exist!";
                    }
                }
                else
                {
                    echo "Something went wrong. Please try again!";
                }

            }
        }
        else
        {
            echo "$email is not a valid email!";
        }
    }
    else
    {
        echo "All input fields are required!";
    }
?>