<?php 
 

?>
 <header>
    <div class="nav-dash">
        <div class="up">   
            <div class="container">
                <div class="system">
                    <h2><a href="dash.php?do=home&userid=<?php echo $_SESSION['Id'];?>">Egyption League</a></h2>
                    <ul class="system-ul">
                        <li><a href="dash.php?do=team&userid=<?php echo $_SESSION['Id'];?>">Team</a></li>
                        <li><a href="dash.php?do=player&userid=<?php echo $_SESSION['Id'];?>">Player</a></li>
                        <li><a href="dash.php?do=Matchs&userid=<?php echo $_SESSION['Id'];?> &comp=1">Matchs</a></li>
                        <li><a href="dash.php?do=Scores&userid=<?php echo $_SESSION['Id'];?>">Scores</a></li>
                        <li><a href="dash.php?do=Rank&userid=<?php echo $_SESSION['Id'];?>">Rank</a></li>
                    </ul>
                </div>      
                <div class="dropdown">
                        <button class="btn btn-default dropdown-toggle btn-main" type="button" id="dropdownMenu1"
                         data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            Setting
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                            <li><a href="dash.php?do=Edit&page=profile&userid=<?php echo $_SESSION['Id'];?>">Edit Profile</a></li>
                            <li><a href="#">Security</a></li>
                            <li><a href="index.php">Logout</a></li> 
                        </ul>
                </div>  
            </div> 
        </div>
    </div>
</header>
 