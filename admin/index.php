<?php 
    session_start();
    $Nonav='';
    $pageTitle = 'Login';
    include 'incls.php';

    if( $_SERVER['REQUEST_METHOD'] == 'POST' )
    {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $stmt = $con->prepare ( 
            "SELECT Id, Email , password ,FullName FROM users WHERE Email = ? AND password = ?"
        );
        $stmt->execute( array( $username , $password ) );
        $row = $stmt->fetch();
        $count = $stmt->rowCount();
        
        if( $count > 0 )
        {
            $_SESSION['Username'] = $username;
            $_SESSION['Id'] = $row['Id'];
            $_SESSION['Name'] = $row['FullName'];
            header('Location:dash.php');
            exit();
        }
    }
 
?>
 <!-- ============================================================================================ -->
    <header>
        <div class="nav">
            <div class="container">
                <div class="nav-top">
                    <h2>Egyption<span style="color:rgb(19, 34, 78)"> League</span></h2>
                    <ul class="ul-login">
                        <li class="log"><a href="#">Login</a></li>
                        <li class="sign"><a href="#">Sign Up</a></li>
                    </ul>
                </div>
                <div class="login">
                    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
                        <i class="fa fa-user fa-lg" style="margin-left:-15px;"></i>
                        <input type="text" name="username" placeholder="Username" autocomplete="off" /><br><br><br>
                        <i class="fa fa-lock fa-lg"style="margin-left:-15px;margin-top:-2px;"></i>
                        <input type="password" name="password" placeholder="Password"autocomplete="off" />
                        <i class="fa fa-chevron-right" style="margin-left:-55px;margin-top:-4px;"></i>
                        <input class="btn btn-block login-btn" type="submit" name="btn" value="Login"/>
                    </form>
                </div>
            </div>
            
        </div>
    </header>
 
 <!-- ============================================================================================ -->
