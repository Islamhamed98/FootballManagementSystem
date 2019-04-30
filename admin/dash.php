<?php
ob_start();

session_start();

if(isset($_SESSION['Username']))
{
    $pageTitle = 'dashboard';
    include 'incls.php';
    
    $do = isset( $_GET['do'] ) ? $_GET['do'] : 'home';
    $userid = isset( $_GET['userid'] ) ? $_GET['userid'] : 1;
    $pageName = isset($_GET['page']) ? $_GET['page'] : 'home';
    $search = isset($_POST['search']) ? $_POST['search'] : 'home';
    

    $stmt = $con->prepare( "SELECT * FROM users WHERE Id = ? " );
    $stmt->execute( array( $userid ) );
    $rows = $stmt->fetch();
    $Name = $_SESSION['Name'];

     if($rows['Group_id'] == 1)
         $hidden="";
     else 
         $hidden ="none";
         
  if ( $do == 'team' )
    {
        $stmt = $con->prepare( "SELECT * FROM team ORDER BY points DESC " );
        $stmt->execute();
        $rows = $stmt->fetchAll();
       
    ?>
    <div class="team"  id="clicker"> 
        <div class="container">
            <div class="main table-responsive">
                <h2 class="text-center" style="font-family:sans;margin-bottom:25px;">The Teams Of Egyption League</h2> 
                <table class="main-table text-center table table-bordered">
                  <tr class="main-th">
                    <th>Club</th>
                    <th>Captain</th>
                    <th>Scores</th>
                    <th>Points</th>
                    <th style="display:<?php echo $hidden;?>">Edit / Delete Team</th>
                  </tr>
                  <?php 
                    foreach( $rows as $row ){
                        echo '<tr style="background-color:#1e272e;color:#FFF;font-weight:bold;">';
                            echo '<td>' . $row['Name'] . '</td>';
                            echo '<td>' . $row['Captain'] . '</td>';
                            echo '<td>' . $row['Total_Scores'] . '</td>';
                            echo '<td>' .$row['points'] . '</td>';
                            if($hidden == "none")
                            {
                                // echo '<td>' . "<a style='margin-right:10px;'class='btn btn-primary' href='dash.php?do=Edit&userid='" . $row['Id'] . "><i class='fa fa-edit'></i> Edit</a>" . "<a class='btn btn-danger' href='dash.php?do=Edit&userid='" . $row['Id'] . "><i class='fa fa-delete'></i> Delete</a>"   . '</td>';
                            }
                            else {
                                    
                                $id =$row['Id'];
                                echo '<td>';
                                    echo '<a href="dash.php?do=Edit&page=team&userid='.$id.'" class="btn btn-primary  search-btn-admin" style="margin-right:7px;padding-right:19px;"> <i class="fa fa-edit"></i> Edit </a>' . '<a href="dash.php?do=Delete&page=team&userid='.$id.'" class="btn btn-danger search-btn-admin" style="margin-left:5px; "> <i class="fa fa-trash"></i> Delete </a>';
                                 echo '</td>';

                            }
                        echo '</tr>';
                    }
                  ?>
                </table>
                  
                   <a href="dash.php?do=add&page=team" class="btn btn-primary text-center"
                    style="font-weight:bold;letter-spacing:.7px;margin-left:400px;width:200px;font-size:15px;font-family:sans-serif;margin-top:27px;background-color:#0a3d62;border-radius:30px; display:<?php echo $hidden; ?>;font-size:15px;font-family:sans-serif"><i class="fa fa-plus"  style="padding-right:10px;" ></i> Add Team </a>
                   
                    <form style="margin-top:-60px;" action="?do=SEARCH&page=team" method='POST' > 
                        <label for="search" class="search-label">Your Team</label>
                        <input style=" border-radius:25px;"id="search" type="text" name="search" class="form-control search-input" placeholder="Search" autocomplete="off">
                        <input class="btn btn-danger search-btn" type="submit" value="SEARCH" />
                    </form>
                  
            </div>
       </div>   
    </div>
 
    <?php }  
    else if( $do == 'player' )
    {
        $stmt = $con->prepare( "SELECT * FROM player ORDER BY Score DESC" );
        $stmt->execute();
        $rows = $stmt->fetchAll();

        ?>
        <div class="team player" style="margin-top:-50px;"> 
            <div class="container">
                <div class="main table-responsive">
                   <h2 class="text-center" style="font-family:sans;margin-bottom:25px;margin-top:45px;padding-top:10px">The Players Of Egyption League</h2> 
                   <table class="main-table text-center table table-bordered">
                      <tr class="main-th">
                        <th>Name</th>
                        <th>Club</th>
                        <th>Score</th>
                        <th>Number</th>
                        <th>Position</th>
                        <th style="display:<?php echo $hidden;?>">Edit / Delete Player</th>
                       </tr>
                      <?php 
                        foreach( $rows as $row ){
                            $statment = $con->prepare(" SELECT * FROM team WHERE Id = ? ");
                            $statment->execute( array ( $row['team_id'] ) );
                            $Name_club = $statment->fetch();
                            echo '<tr style="background-color:#1e272e;color:#FFF;font-weight:bold;">';
                                echo '<td>' . $row['Name'] . '</td>';
                                echo '<td>' . $Name_club['Name'] . '</td>';
                                echo '<td>' . $row['Score'] . '</td>';
                                echo '<td>' . $row['Number'] . '</td>';
                                echo '<td>' . $row['position'] . '</td>';
                                if($hidden == "none")
                                {
                                    // echo '<td>' . "<a style='margin-right:10px;'class='btn btn-primary' href='dash.php?do=Edit&userid='" . $row['Id'] . "><i class='fa fa-edit'></i> Edit</a>" . "<a class='btn btn-danger' href='dash.php?do=Edit&userid='" . $row['Id'] . "><i class='fa fa-delete'></i> Delete</a>"   . '</td>';
                                }
                                else {
                                        
                                    $id =$row['Id'];
                                    echo '<td>';
                                        echo '<a href="dash.php?do=Edit&page=player&userid='.$id.'" class="btn btn-primary search-btn-admin" style="margin-right:7px;padding-right:19px;"> <i class="fa fa-edit"></i> Edit </a>' . '<a href="dash.php?do=Delete&page=player&userid='.$id.'" class="btn btn-danger search-btn-admin" style="margin-left:5px; "> <i class="fa fa-trash"></i> Delete </a>';
                                     echo '</td>';

                                    }
                            echo '</tr>'; 
                        }
                      ?>
                     </table>
                        <a href="dash.php?do=add&page=player" class="btn btn-block search-btn search-btn-add btn-primary text-center"
                        style="font-weight:bold;margin-top:27px;letter-spacing:.7px;margin-left:400px;width:210px;margin-top:5px;font-size:15px;font-family:sans-serif;background-color:#0a3d62;border-radius:30px;
                        display:<?php echo $hidden; ?>"><i class="fa fa-plus" style="padding-right:20px;"></i> Add Player </a>
                 
                        <form style="margin-top:-60px;" action="?do=SEARCH&page=player" method='POST' > 
                        <label for="search" class="search-label">Your Team</label>
                        <input style=" border-radius:25px;" id="search" type="text" name="search" class="form-control search-input" placeholder="Search" autocomplete="off">
                        <input class="btn btn-danger search-btn" type="submit" value="SEARCH" />
                    </form>   
                </div>
           </div>   
        </div>
    
    
    <?php }

    else if( $do == 'Matchs' )
    {
        $comp=isset($_GET['comp']) ? $_GET['comp'] : 1;
        $stmt = $con->prepare( "SELECT * FROM matchs WHERE Competition = ? " );
        $stmt->execute( array( $comp ) );
        $rows = $stmt->fetchAll();
        if($comp == 1) $Num = "First";
        else if($comp == 2) $Num = "Second";
        else $Num = "Third";

     ?>
        <div class="team"> 
            <div class="container">
                <div class="main table-responsive" style="height:600px;">
                    <h2 class="text-center" style="color:#FFF;font-family:sans;">The <?php echo $Num;?> Competitions Matchs</h2>
                    <table class="main-table text-center table table-bordered">
                        <tr class="main-th">
                            <th>Team Home</th>
                            <th>Team Away</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Refree</th>
                            <th>Stadium</th>
                            <th style="display:<?php echo $hidden;?>">Edit / Delete Match</th>
                        </tr>
                        <?php 

                            foreach( $rows as $row ){
                                echo '<tr style="background-color:#1e272e;color:#FFF;font-weight:bold;">';
                                    echo '<td>' . $row['Team_Home'] . '</td>';
                                    echo '<td>' . $row['Team_Away'] . '</td>';
                                    echo '<td>' . $row['date'] . '</td>';
                                    echo '<td>' . $row['Time'] . '</td>';
                                    echo '<td>' . $row['Refree'] . '</td>';
                                    echo '<td>' . $row['Stadium'] . '</td>';
                                    if($hidden == "none")
                                    {
                                        // echo '<td>' . "<a style='margin-right:10px;'class='btn btn-primary' href='dash.php?do=Edit&userid='" . $row['Id'] . "><i class='fa fa-edit'></i> Edit</a>" . "<a class='btn btn-danger' href='dash.php?do=Edit&userid='" . $row['Id'] . "><i class='fa fa-delete'></i> Delete</a>"   . '</td>';
                                    }
                                    else {
                                            
                                        $id =$row['Id'];
                                        echo '<td>';
                                            echo '<a href="dash.php?do=Edit&page=match&userid='.$id.'" class="btn btn-primary  search-btn-admin" style="margin-right:7px;padding-right:19px;width:130px;margin-top:21px;"> <i class="fa fa-edit"></i> Edit </a>' . '<a href="dash.php?do=Delete&page=match&userid='.$id.'" class="btn btn-danger search-btn search-btn-admin" style="margin-left:5px; "> <i class="fa fa-trash"></i> Delete </a>';
                                         echo '</td>';
                                        }
                                echo '</tr>';
                            }

                        ?>
                  
                    </table>
                    <a href="dash.php?do=add&page=match" class="btn btn-block btn-primary text-center"
                        style="font-weight:bold;margin-top:27px;letter-spacing:.7px; margin-top:5px;font-size:15px;font-family:sans-serif;background-color:#0a3d62;border-radius:30px;
                        display:<?php echo $hidden; ?>"><i class="fa fa-plus" style="padding-right:20px;"></i> Add Player </a>
                    <div class="div-btns">
                        <button class="btn btn-block search-btn-admin btn-comp1"><a href="dash.php?do=Matchs&comp=2">The Second Competition Matchs</a></button>
                        <button class="btn btn-block search-btn-admin btn-comp2"><a href="dash.php?do=Matchs&comp=3">The Third Competition Matchs</a></button>
                    </div>
               </div>
            </div>   
        </div>
    <?php }
    else if( $do == 'Scores'){

        $stmt = $con->prepare( "SELECT * FROM player ORDER BY Score DESC" );
        $stmt->execute();
        $rows = $stmt->fetchAll();

        ?>
        <div class="team player"> 
            <div class="container">
                <div class="main table-responsive">
                    <h2 class="text-center" style="font-family:sans;margin-bottom:25px;">The Top Players Score Of Egyption League</h2> 
                    <table class="main-table text-center table table-bordered">
                      <tr class="main-th">
                        <th>Name</th>
                        <th>Club</th>
                        <th>Score</th>
                        <th>Rank</th> 
                        <th style="display:<?php echo $hidden;?>">Edit / Delete Score </th>
                       </tr>
                      <?php 
                      $i = 1;
                        foreach( $rows as $row ){
                            $statment = $con->prepare(" SELECT * FROM team WHERE Id = ? ");
                            $statment->execute( array ( $row['team_id'] ) );
                            $Name_club = $statment->fetch();
                            echo '<tr style="background-color:#1e272e;color:#FFF;font-weight:bold;">';
                                echo '<td>' . $row['Name'] . '</td>';
                                echo '<td>' . $Name_club['Name'] . '</td>';
                                echo '<td>' . $row['Score'] . '</td>';
                                echo '<td>' . $i++ . '</td>';
                                if($hidden == "none")
                                {
                                    // echo '<td>' . "<a style='margin-right:10px;'class='btn btn-primary' href='dash.php?do=Edit&userid='" . $row['Id'] . "><i class='fa fa-edit'></i> Edit</a>" . "<a class='btn btn-danger' href='dash.php?do=Edit&userid='" . $row['Id'] . "><i class='fa fa-delete'></i> Delete</a>"   . '</td>';
                                }
                                else {
                                        
                                    $id =$row['Id'];
                                    echo '<td>';
                                        echo '<a href="dash.php?do=Edit&page=scores&userid='.$id.'" class="btn btn-primary search-btn-admin search-btn-admin" style="margin-right:7px;padding-right:19px;"> <i class="fa fa-edit"></i> Edit </a>' . '<a href="dash.php?do=Delete&page=scores&userid='.$id.'" class="btn btn-danger search-btn-admin" style="margin-left:5px; "> <i class="fa fa-trash"></i> Delete </a>';
                                     echo '</td>';
                                }
                            echo '</tr>';
                        }
                      ?>
                    </table>
                </div>
           </div>   
        </div>
    
<?php 
    }
    else if( $do == 'Rank' ){
        $stmt = $con->prepare( "SELECT * FROM team ORDER BY points DESC " );
        $stmt->execute();
        $rows = $stmt->fetchAll();
   
    ?>
    <div class="team"> 
        <div class="container">
            <div class="main table-responsive">
            <h2 class="text-center" style="font-family:sans">The Top Teams Of Egyption League</h2> 
                <table class="main-table text-center table table-bordered">
                  <tr class="main-th">
                    <th>Club</th>
                    <th>Scores</th>
                    <th>Points</th>
                    <th style="display:<?php echo $hidden;?>">Edit / Delete Rank</th>
                    
                  </tr>
                  <?php 
                    foreach( $rows as $row ){
                        echo '<tr style="background-color:#1e272e;color:#FFF;font-weight:bold;">';
                            echo '<td>' . $row['Name'] . '</td>';
                            echo '<td>' . $row['Total_Scores'] . '</td>';   
                            echo '<td>' . $row['points'] . '</td>';  
                      
                            if($hidden == "none")
                            {
                                // echo '<td>' . "<a style='margin-right:10px;'class='btn btn-primary' href='dash.php?do=Edit&userid='" . $row['Id'] . "><i class='fa fa-edit'></i> Edit</a>" . "<a class='btn btn-danger' href='dash.php?do=Edit&userid='" . $row['Id'] . "><i class='fa fa-delete'></i> Delete</a>"   . '</td>';
                            }
                            else {
                                    
                                $id =$row['Id'];
                                echo '<td>';
                                    echo '<a href="dash.php?do=Edit&page=rank&userid='.$id.'" class="btn btn-primary search-btn-admin" style="margin-right:7px;padding-right:19px;"> <i class="fa fa-edit"></i> Edit </a>' . '<a href="dash.php?do=Delete&page=rank&userid='.$id.'" class="btn btn-danger search-btn-admin" style="margin-left:5px; "> <i class="fa fa-trash"></i> Delete </a>';
                                 echo '</td>';
                        }
                        echo '</tr>';
                    }
                  ?>
                </table>
            </div>
       </div>   
    </div>

<?php
    }
    else if($do == 'home')
    {
       
       ?>
         <div class="components">
             <div class="row">
                 <div class="col-sm-12">
                     <div id="my-slider" class="carousel slide" data-ride="carousel">

                        <!-- indicators dot nov -->
                          <!-- Wrapper for slides  -->
                            <div class="carousel-inner" role="listbox">
                                    <!-- Number Of Slides -->
                                    <div class="item active">
                                    <img src="Layout/images/foot.jpeg"/>
                                    <div class="carousel-caption main-car">
                                        <h2 id="type">Welcome <span class="span-user" ><?php echo $Name;?> </span>In The First Sports Website In The World Cup</h2>
                                        <p>Lorem Ipsum simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s simply dummy text of the printing.</p>
                                    </div>
                                </div>
                                <div class="item">
                                    <img src="Layout/images/pexels-photo-104675.jpeg" alt="football"/>
                                    <div class="carousel-caption main-car">
                                        <h2>Welcome In The First Sports Website In The World Cup</h2>
                                        <p>Lorem Ipsum simply dummy text of the printing and typesetting industry. Lorem Ipsum has been.</p>
                                    </div>
                                </div>
                                <div class="item">
                                    <img src="Layout/images/photo_edited.jpg"/>
                                    <div class="carousel-caption main-car" style="color:#1c2d15">
                                        <h2>Welcome In The First Sports Website In The World Cup</h2>
                                        <p style="color:#FFF">Lorem Ipsum simply dummy text of the printing and typesetting industry. Lorem  </p>
                                    </div>
                                </div>
                            </div>
                        <!-- Controls or next and prev buttons -->
                        <a class="left carousel-control" href="#my-slider" role="button" data-slide="prev" style="margin-top:-90px;">
                                    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                                    <span class="sr-only">Previuos</span>
                            </a>  
                            <a class="right carousel-control" href="#my-slider" role="button" data-slide="next"style="margin-top:-90px;">
                                    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                                    <span class="sr-only">Previuos</span>
                            </a>
                     </div>
                 </div>
             </div>
         </div>

       <?php 
    }
    else if($do == 'add')
    {  
        if($pageName == 'team') // Add    
        {  ?>
           
              <form class="edit-form" action="?do=Update&page=team" method="POST">
                <div class="form-group">
                    <label for="exampleInputEmail1">Name Of Team</label>
                    <input type="text" class="form-control" name="TeamName" id="exampleInputEmail1" placeholder="Enter The Name Of Team">
                    <small style="color:#FFF" id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Name Of Captain</label>
                    <input type="text" class="form-control"  name="CaptainName"  id="exampleInputPassword1" placeholder="Enter The Name Of Captain">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Score Of Team</label>
                    <input type="text" class="form-control" name="TeamScore" id="exampleInputPassword1" placeholder="Enter The Score Of Team">
                </div>
         
                <button type="submit" class="btn btn-block btn-primary " style="font-family:sans-serif;font-weight:bold;padding-right:20px;margin-top:20px;"><i  class="fa fa-plus"></i> Add</button> 
            </form>

        <?php }
          else if( $pageName == 'player') // Add  
          { ?>

              <form class="edit-form" action="?do=Update&page=player">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Name Of Player</label>
                        <input type="text" class="form-control" name="NamePlayer" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter The Name Of Player">
                        <small style="color:#FFF" id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Name Of Team</label>
                        <input type="text" class="form-control" name="TeamPlayer" id="exampleInputPassword1" placeholder="Enter The Name Of Team">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Score Of Player</label>
                        <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Enter The Score Of Player">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Rank Of Player</label>
                        <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Enter The Rank Of Player">
                    </div>
                
                    <button type="submit" class="btn btn-block btn-primary " style="font-family:sans-serif;font-weight:bold;padding-right:20px;margin-top:20px;"><i  class="fa fa-plus"></i> Add</button> 
            </form>



          <?php } 
          else if($pageName == 'match')
          { ?>

                <form class="edit-form">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Team Home</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter The First Team">
                        <small style="color:#FFF" id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1"> Team Away</label>
                        <input type="text" class="form-control" id="exampleInputPassword1" placeholder= "Enter The Second Team">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Name Of Stadium</label>
                        <input type="text" class="form-control" id="exampleInputPassword1" placeholder= "Enter The Name Of Stadium">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Name Of Refree</label>
                        <input type="text" class="form-control" id="exampleInputPassword1" placeholder= "Enter The Name Of Refree">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Date Of Match</label>
                        <input type="text" class="form-control" id="exampleInputPassword1" placeholder= "Enter The Date Of Match">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Time Of Match</label>
                        <input type="text" class="form-control" id="exampleInputPassword1" placeholder= "Enter The Time Of Match">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Competition</label>
                        <input type="text" class="form-control" id="exampleInputPassword1" placeholder= "Enter The Time Of Competition">
                    </div>
        
                    <button type="submit" class="btn btn-block btn-primary " style="font-family:sans-serif;font-weight:bold;padding-right:20px;margin-top:20px;"><i  class="fa fa-plus"></i>  Add</button> 
                </form>

          <?php }

     }
    else if($do == 'Edit')
    {
        if($pageName == 'player')
        { 
            $stmt = $con->prepare("SELECT * FROM player WHERE Id = ? ");
            $stmt->execute(array( $userid ));
            $row = $stmt->fetch();
            $count = $stmt->rowCount();
            if($count > 0)
            {  
            ?>
            <form class="edit-form">
                <div class="form-group">
                    <label for="exampleInputEmail1">Name Of Player</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="<?php echo $row['Name']?>">
                    <small style="color:#FFF" id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Number Of Player</label>
                    <input type="text" class="form-control" id="exampleInputPassword1" placeholder="<?php echo $row['Number']?>">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Age Of Player</label>
                    <input type="text" class="form-control" id="exampleInputPassword1" placeholder="<?php echo $row['Age']?>">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Team Name</label>
                    <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Enter The Team Of Player">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Position Of Player</label>
                    <input type="text" class="form-control" id="exampleInputPassword1" placeholder="<?php echo $row['position']?>">
                </div>

                <button type="submit" class="btn btn-block btn-danger " style="font-family:sans-serif;font-weight:bold;padding-right:20px;margin-top:20px;"><i  class="fa fa-edit"></i> Edit</button> 
            </form>


       <?php 
            }
        }
        else if ( $pageName == 'team')
        {
            $stmt = $con->prepare("SELECT * FROM team WHERE Id = ? ");
            $stmt->execute(array( $userid ));
            $row = $stmt->fetch();
            $count = $stmt->rowCount();
            if($count > 0)
            {  
            ?>
                <form class="edit-form">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Name Of Team</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="<?php echo $row['Name'];?>">
                        <small style="color:#FFF" id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Name Of Captain</label>
                        <input type="text" class="form-control" id="exampleInputPassword1" placeholder="<?php echo $row['Captain'];?>">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Total Scores</label>
                        <input type="text" class="form-control" id="exampleInputPassword1" placeholder="<?php echo $row['Total_Scores'];?>">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Team Points</label>
                        <input type="text" class="form-control" id="exampleInputPassword1" placeholder="<?php echo $row['points'];?>">
                    </div>
        
                    <button type="submit" class="btn btn-block btn-danger " style="font-family:sans-serif;font-weight:bold;padding-right:20px;margin-top:20px;"><i  class="fa fa-edit"></i> Edit</button> 
                </form>


        <?php 
            }
        }  
        else if( $pageName == 'match') 
        {
            $stmt = $con->prepare("SELECT * FROM matchs WHERE Id = ? ");
            $stmt->execute(array( $userid ));
            $row = $stmt->fetch();
            $count = $stmt->rowCount();
            if($count > 0)
            {  
            ?>
                <form class="edit-form">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Team Home</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="<?php echo $row['Team_Home'];?>">
                        <small style="color:#FFF" id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1"> Team Away</label>
                        <input type="text" class="form-control" id="exampleInputPassword1" placeholder= "<?php echo $row['Team_Away'];?>">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Name Of Stadium</label>
                        <input type="text" class="form-control" id="exampleInputPassword1" placeholder="<?php echo $row['Stadium'];?>">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Name Of Refree</label>
                        <input type="text" class="form-control" id="exampleInputPassword1" placeholder="<?php echo $row['Refree'];?>">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Date Of Match</label>
                        <input type="text" class="form-control" id="exampleInputPassword1" placeholder="<?php echo $row['date'];?>">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Time Of Match</label>
                        <input type="text" class="form-control" id="exampleInputPassword1" placeholder="<?php echo $row['Time'];?>">
                    </div>
        
                    <button type="submit" class="btn btn-block btn-danger " style="font-family:sans-serif;font-weight:bold;padding-right:20px;margin-top:20px;"><i  class="fa fa-edit"></i> Edit</button> 
                </form>

        <?php 
            }
        }

         else if( $pageName == 'scores' )
         { 
            $stmt = $con->prepare("SELECT * FROM player WHERE Id = ? ");
            $stmt->execute(array( $userid ));
            $row = $stmt->fetch();
            $count = $stmt->rowCount();
            if($count > 0)
            { 
            ?> 
             <form class="edit-form">
                <div class="form-group">
                    <label for="exampleInputEmail1">Name Of Player</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="<?php echo $row['Name']?>">
                    <small style="color:#FFF" id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Name Of Team</label>
                    <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Enter The Name Of Team">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Score Of Player</label>
                    <input type="text" class="form-control" id="exampleInputPassword1" placeholder="<?php echo $row['Score'];?>">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Rank Name</label>
                    <input type="text" class="form-control" id="exampleInputPassword1" placeholder="<?php echo $row['Rank'];?>">
                </div>
         
                <button type="submit" class="btn btn-block btn-danger " style="font-family:sans-serif;font-weight:bold;padding-right:20px;margin-top:20px;"><i  class="fa fa-edit"></i> Edit</button> 
            </form>

         <?php
            } 
        }
          else if( $pageName == 'rank' )
          { 
            $stmt = $con->prepare("SELECT * FROM team WHERE Id = ? ");
            $stmt->execute(array( $userid ));
            $row = $stmt->fetch();
            $count = $stmt->rowCount();
            if($count > 0)
            {  
            ?> 

            <form class="edit-form">
                <div class="form-group">
                    <label for="exampleInputEmail1">Name Of Team</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="<?php echo $row['Name'];?>">
                    <small style="color:#FFF" id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Score Of Team</label>
                    <input type="text" class="form-control" id="exampleInputPassword1" placeholder="<?php echo $row['Total_Scores'];?>">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Rank Of Team</label>
                    <input type="text" class="form-control" id="exampleInputPassword1" placeholder="<?php echo $row['points'];?>">
                </div>
        
                <button type="submit" class="btn btn-block btn-danger " style="font-family:sans-serif;font-weight:bold;padding-right:20px;margin-top:20px;"><i  class="fa fa-edit"></i> Edit</button> 
            </form>
         <?php
            } 
        }
       
        else if($pageName == 'profile')
         { 
            $stmt = $con->prepare("SELECT * FROM users WHERE Id = ? ");
            $stmt->execute(array( $_SESSION['Id'] ));
            $row = $stmt->fetch();
            $count = $stmt->rowCount();
            if($count > 0)
            {
            ?>
              <form class="edit-form">
                     <div class="form-group">
                        <label for="exampleInputPassword1">Email</label>
                        <input type="email" class="form-control" id="exampleInputPassword1" placeholder="<?php echo $row['Email'];?>">
                        <small style="color:#FFF" id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Password</label>
                        <input type="password" class="form-control" id="exampleInputPassword1" placeholder="<?php echo   $row['password'];?>">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Full Name</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="<?php echo $row['FullName'];?>">
                   </div>
                   <button type="submit" class="btn btn-block btn-danger " style="font-family:sans-serif;font-weight:bold;padding-right:20px;margin-top:20px;"><i  class="fa fa-edit"></i> Edit</button> 
            </form>

        <?php 
        }
       }

    }
    else if( $do == 'Delete') // delete
    {
        if($pageName == 'team')
        {
            $stmt = $con->prepare("DELETE FROM team WHERE Id = ? ");
            $stmt->execute(array( $userid )); 
            echo '<div class="alert alert-danger" style="position:absolute;top:100px;left:50px;width:800px;">';
               echo  'The Team Has Been Deleted  Successfully  :(< ';
             echo '</div>';
         }
        else if($pageName == 'player')
        {
            $stmt = $con->prepare("DELETE FROM player WHERE Id = ? ");
            $stmt->execute( array( $userid )); 
            echo '<div class="alert alert-danger" style="position:absolute;top:100px;left:50px;width:800px;">';
               echo  'The Team Has Been Deleted  Successfully  :(< ';
             echo '</div>';
        }
        else if( $pageName == 'scores' )
        {
            $stmt = $con->prepare("DELETE FROM player WHERE Id = ? ");
            $stmt->execute(array( $userid )); 
            echo '<div class="alert alert-danger" style="position:absolute;top:100px;left:50px;width:800px;">';
               echo  'The Team Has Been Deleted  Successfully  :(< ';
             echo '</div>';
        }
        else if( $pageName == 'match' )
        {
            $stmt = $con->prepare("DELETE FROM matchs WHERE Id = ? ");
            $stmt->execute(array( $userid )); 
            echo '<div class="alert alert-danger" style="position:absolute;top:100px;left:50px;width:800px;">';
               echo  'The Team Has Been Deleted  Successfully  :(< ';
             echo '</div>';
   
        }
        else if($pageName == 'rank')
        {
            $stmt = $con->prepare("DELETE FROM team WHERE Id = ? ");
            $stmt->execute(array( $userid )); 
            echo '<div class="alert alert-danger" style="position:absolute;top:100px;left:50px;width:800px;">';
               echo  'The Team Has Been Deleted  Successfully  :(< ';
             echo '</div>';
   
        }
    
    }   
    else if($do == 'SEARCH')
    {
        // Search 
        if($search != NULL)
        {  
            if($pageName == 'team')
            {
                $stmt=$con->prepare("SELECT * FROM team WHERE Name = ? ");
                $stmt->execute( array( $search ) );
                $rows=$stmt->fetchAll();
                if( $stmt->rowCount() > 0)
                { ?> 

                <div class="team"  id="clicker"> 
                    <div class="container">
                        <div class="main table-responsive">
                            <h2 class="text-center" style="font-family:sans">The Teams Of Egyption League</h2> 
                            <table class="main-table text-center table table-bordered">
                            <tr class="main-th">
                                <th>Club</th>
                                <th>Captain</th>
                                <th>Scores</th>
                                <th>Points</th>
                                <th style="display:<?php echo $hidden;?>">Edit / Delete Team</th>
                            </tr>
                            <?php 
                                foreach( $rows as $row ){
                                    echo '<tr style="background-color:#1e272e;color:#FFF;font-weight:bold;">';
                                        echo '<td>' . $row['Name'] . '</td>';
                                        echo '<td>' . $row['Captain'] . '</td>';
                                        echo '<td>' . $row['Total_Scores'] . '</td>';
                                        echo '<td>' .$row['points'] . '</td>';
                                        if($hidden == "none")
                                        {
                                            // echo '<td>' . "<a style='margin-right:10px;'class='btn btn-primary' href='dash.php?do=Edit&userid='" . $row['Id'] . "><i class='fa fa-edit'></i> Edit</a>" . "<a class='btn btn-danger' href='dash.php?do=Edit&userid='" . $row['Id'] . "><i class='fa fa-delete'></i> Delete</a>"   . '</td>';
                                            echo $hidden;
                                        }
                                        else {
                                            echo $hidden;
                                            $id =$row['Id'];
                                            echo '<td>';
                                                echo '<a href="dash.php?do=Edit&page=scores&userid='.$id.'" class="btn btn-primary search-btn-admin search-btn-admin" style="margin-right:7px;padding-right:19px;"> <i class="fa fa-edit"></i> Edit </a>' . '<a href="dash.php?do=Delete&page=scores&userid='.$id.'" class="btn btn-danger search-btn-admin" style="margin-left:5px; "> <i class="fa fa-trash"></i> Delete </a>';
                                             echo '</td>';
                                        }

                                    echo '</tr>';
                                }
                            ?>
                            </table>
                            
                               <a href="dash.php?do=add" class="btn btn-block btn-primary text-center"
                                style="font-weight:bold;margin-top:27px;letter-spacing:.7px; margin-top:5px;font-size:15px;font-family:sans-serif;background-color:#0a3d62;border-radius:30px;
                                display:'<?php echo $hidden; ?>'"><i class="fa fa-plus" style="padding-right:20px;"></i> Add Team </a>
                            
                                <form style="margin-top:-60px;" method='POST' > 
                                    <label for="search" class="search-label">Your Team</label>
                                    <input id="search" type="text" name="search" class="form-control search-input" placeholder="Search" autocomplete="off">
                                    <a href="dash.php?do=SEARCH&page=team" class="btn btn-primary search-btn">SEARCH  <i class="fa fa-search" style="margin-left:10px;color:#FFF"></i> </a> 
                                    <!-- <i class="fa fa-search" style="position:absolute;top:758px;left:850px;"></i> -->
                                </form>
                                <!-- <i class="fa fa-search" style="position:absolute;top:564px;left:850px;"></i> -->
                            </div>
                         </div>   
                    </div>
                

                <?php 
                 }
            else {
                    echo '<div class="alert alert-danger" style="position:absolute;top:100px;width:800px">';
                        echo 'Sorry The Team NOT Found Try Again :( ';
                    echo '</div>';
                 }
            }
            else if($pageName == 'player')
            {

                $stmt=$con->prepare("SELECT * FROM player WHERE Name = ? ");
                $stmt->execute( array( $search ) );
                $rows=$stmt->fetchAll();
                if( $stmt->rowCount() > 0)
                {  
                 ?>
                <div class="team player" style="margin-top:-50px;"> 
                    <div class="container">
                        <div class="main table-responsive">
                           <h2 class="text-center" style="font-family:sans;margin-bottom:25px;margin-top:45px;padding-top:10px">The Players Of Egyption League</h2> 
                           <table class="main-table text-center table table-bordered">
                              <tr class="main-th">
                                <th>Name</th>
                                <th>Club</th>
                                <th>Score</th>
                                <th>Number</th>
                                <th>Position</th>
                                <th style="display:<?php echo $hidden;?>">Edit / Delete Player</th>
                               </tr>
                              <?php 
                                foreach( $rows as $row ){
                                    $statment = $con->prepare(" SELECT * FROM team WHERE Id = ? ");
                                    $statment->execute( array ( $row['team_id'] ) );
                                    $Name_club = $statment->fetch();
                                    echo '<tr style="background-color:#1e272e;color:#FFF;font-weight:bold;">';
                                        echo '<td>' . $row['Name'] . '</td>';
                                        echo '<td>' . $Name_club['Name'] . '</td>';
                                        echo '<td>' . $row['Score'] . '</td>';
                                        echo '<td>' . $row['Number'] . '</td>';
                                        echo '<td>' . $row['position'] . '</td>';
                                        if($hidden == "none")
                                        {
                                            // echo '<td>' . "<a style='margin-right:10px;'class='btn btn-primary' href='dash.php?do=Edit&userid='" . $row['Id'] . "><i class='fa fa-edit'></i> Edit</a>" . "<a class='btn btn-danger' href='dash.php?do=Edit&userid='" . $row['Id'] . "><i class='fa fa-delete'></i> Delete</a>"   . '</td>';
                                        }
                                        else {
                                                
                                            $id =$row['Id'];
                                            echo '<td>';
                                                echo '<a href="dash.php?do=Edit&page=player&userid='.$id.'" class="btn btn-primary search-btn-admin" style="margin-right:7px;padding-right:19px;"> <i class="fa fa-edit"></i> Edit </a>' . '<a href="dash.php?do=Delete&page=player&userid='.$id.'" class="btn btn-danger search-btn-admin" style="margin-left:5px; "> <i class="fa fa-trash"></i> Delete </a>';
                                             echo '</td>';
        
                                            }
                                    echo '</tr>'; 
                                }
                              ?>
                             </table>
                                <a href="dash.php?do=add&page=player" class="btn btn-block search-btn search-btn-add btn-primary text-center"
                                style="font-weight:bold;margin-top:27px;letter-spacing:.7px;margin-left:400px;width:210px;margin-top:5px;font-size:15px;font-family:sans-serif;background-color:#0a3d62;border-radius:30px;
                                display:<?php echo $hidden; ?>"><i class="fa fa-plus" style="padding-right:20px;"></i> Add Player </a>
                         
                                <form style="margin-top:-60px;" action="?do=SEARCH&page=player" method='POST' > 
                                <label for="search" class="search-label">Your Team</label>
                                <input style=" border-radius:25px;" id="search" type="text" name="search" class="form-control search-input" placeholder="Search" autocomplete="off">
                                <input class="btn btn-danger search-btn" type="submit" value="SEARCH" />
                            </form>   
                        </div>
                   </div>   
                </div>
            <?php }
            
        }










        }

    }
 




}
else  {
    echo 'No Username';
}

 



ob_end_flush();
?>
 