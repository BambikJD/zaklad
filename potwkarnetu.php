<html>
    <head>
        <meta charset='utf-8'>
        <link rel='stylesheet' href='style.css'>
    </head>
    <link href='//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
    <link href='https://fonts.cdnfonts.com/css/minecraft-4' rel='stylesheet'>
    <body>
        <?php
         $db = mysqli_connect("localhost", "root", "", "myjnia");
        session_start();
        
        if(isset($_POST['log-out'])){
            session_destroy();
            header("Location: index.php");
        }

        if(isset($_POST['reg-in'])){
            header("Location: register.php");
        }

        if(isset($_POST['kupkarnet'])){
            $idu = $_SESSION['idu'];
            $idk = $_SESSION['idkupkarnet'];
            $data = date("Y-m-d");
            $zap3 = "UPDATE `users` SET `karnet` = '$idk', `datakarnetu` = '$data' WHERE `users`.`idu` = $idu";
            mysqli_query($db, $zap3);
            header("Location: index.php");
        }
        ?>
        <div class='background animation'>
            <img src='tlo5.jpeg' style='width:100%'>
        </div>
        <div class='background animation'>
            <img src='tlo2.jpeg' style='width:100%'>
        </div>
        <div class='background animation'>
            <img src='tlo3.jpeg' style='width:100%'>
        </div>
        <div class='background animation'>
            <img src='tlo4.jpeg' style='width:100%'>
        </div>
        <div class='background animation'>
            <img src='tlo1.jpeg' style='width:100%'>
        </div>
        <div class='background animation'>
            <img src='tlo6.jpeg' style='width:100%'>
        </div>
        
        <?php
       

        if(isset($_POST['log-in'])){
            $login = $_POST['login'];
            $haslo = $_POST['password'];
            $zap1 = "select * from users where login = '$login' and haslo = '$haslo'";
            $que1 = mysqli_query($db, $zap1);
            if($row = mysqli_fetch_array($que1)){
                $_SESSION['zal'] = True;
                $_SESSION['imie'] = $row['imie'];
                $_SESSION['nazw'] = $row['nazwisko'];
                $_SESSION['klasa'] = "Uzytkownik";
                if($row['pracownik'] == True){
                    $_SESSION['pra'] = True;
                    $_SESSION['klasa'] = "Pracownik";
                }
                if($row['admin'] == True){
                    $_SESSION['adm'] = True;
                    $_SESSION['klasa'] = "Admin";
                }
                
                
               
            } else {
                echo "<div class='error'>
                SPROBOJ PONOWNIE
                </div>";
            }
        }
        ?>
        <div class='login-container'>
            <form method='POST'>
                <?php
                if(!isset($_SESSION['zal']) or $_SESSION['zal'] == False){
                echo "
                <input name='login' type='text' id='login' placeholder='Wpisz swoj login'>
                <input name='password' type='password' id='password' placeholder='Podaj haslo'>
                <input type='submit' class='log-in' name='log-in' value='ZALOGUJ'>
                <input type='submit' class='reg-in' name='reg-in' value='REJESTRUJ'>
                ";
                } else {
                    $klasa = $_SESSION['klasa'];
                    $imie = $_SESSION['imie'];
                    $nazw = $_SESSION['nazw'];
                    echo "<div class='zalogowany'> Zalogowano<br> <span style='color:red'> $klasa</span><br>";
                    echo "<span style='color:darkturquoise'> $imie $nazw</span></div>";
                    echo "
                    <input type='submit' class='log-in' style='margin-top:-4%'  name='log-out' value='WYLOGUJ'>
                    <input type='submit' class='reg-in' style='margin-top:-4%'  name='profile' value='PROFIL'>
                    ";
                }
                ?>
            </form>
        </div>

        <div id='menu' class='menu'>
        <a href="index.php" class='menu-button'><div class='icon-div'><img src='house.png' class='icon'></div><div class='button-text-div'><span class='button-text'> HOME</span></div></a>
            <?php
             if (isset($_SESSION['zal'])) {
                if ($_SESSION['zal'] == true) {
                    if (!isset($_SESSION['adm']) and !isset($_SESSION['pra'])) {
                        echo "
                        <a href='wizyty.php' class='menu-button'><div class='icon-div-chosen'><img src='booking.png' class='icon'></div><div class='button-text-div'><span class='button-text'>
                         WIZYTY</span></div></a>
                        ";
    
                        echo "
                        <a href='profil.php' class='menu-button'><div class='icon-div'><img src='edit.png' class='icon'></div><div class='button-text-div'><span class='button-text'>
                         Profil</span></div></a>
                        ";
                    }
                } else {
                    echo "
                        <a class='menu-button'><div class='icon-div'><img src='user.png' class='icon'></div><div class='button-text-div'><span class='button-text'>
                         REJESTRACJA</span></div></a>
                        ";
                }
            } else {
                echo "
                    <a href='register.php' class='menu-button'><div class='icon-div'><img src='user.png' class='icon'></div><div class='button-text-div'><span class='button-text'>
                     REJESTRACJA</span></div></a>
                    ";
            }
    
            if (isset($_SESSION['adm'])) {
                echo "
                        <a href='admin.php' class='menu-button'><div class='icon-div'><img src='admin.png' class='icon'></div><div class='button-text-div'><span class='button-text'>
                         Admin</span></div></a>
                    ";
            }
            ?>
        
        
        </div>

        <div class='main'>
            <div class='naglowek'>
              POTWIERDZENIE SUBSKRYPCJI
            </div>
            <div class='content-div historia'>
            Oswiadczam, ze zapoznalem sie z regulaminem, i zobowiazuje sie do miesiecznych platnosci powiazanych z subskrypcja w postaci karnetu<br>
            
                <table class="potwkarntab"> 
                    <tr><td>
            Poziom karnetu: </td><td> <?php echo $_SESSION['kupkarnet']?></td></tr>
            <tr><td>Data:</td><td> <?php echo date("Y-m-d"); ?></td></tr>
            <tr><td>Koszt:</td><td> <?php $wybranykarnet = $_SESSION['kupkarnet']; $zap2 = "select * from karnety where nazwa like '%$wybranykarnet%'";
            $que2 = mysqli_query($db, $zap2); if($row = mysqli_fetch_array($que2)){
                echo $row['cena'];
            }?> </td></tr>
                </table>
                <div style="float:left; margin-left:10%">
                <form method="POST">
                <label>Potwierdz <input type="checkbox" required></label><br>
                <input id="kupkarnet" name="kupkarnet" type="submit"  style=" height: 50px; margin-top:20px; font-size:130%" value="KUP KARNET">
                </form>    
            </div>
            

            </div>
            
            
        </div>
        
      
        <script>
            let slideIndex = 0;

            showSlides();

            function showSlides(){
                let i;
                let slides = document.getElementsByClassName('background');
                for(i = 0; i < slides.length; i++){
                    slides[i].style.display = 'none';
                }
                slideIndex ++;
                if(slideIndex > slides.length){
                    slideIndex = 1;
                }

                slides[slideIndex-1].style.display = 'block';

                setTimeout(showSlides, 8000);
            }
            
            function czykarnetzaznaczony(){
                
                karnetyradio = document.getElementsByClassName("radiokarnet");
                karnetyclick = document.getElementsByClassName("karnet");
                var czy = false;
                for( let i = 0; i < karnetyradio.length; i++){
                    if(karnetyradio[i].checked == true){
                        if(karnetyclick[i].style.borderColor == "red"){
                            czy = false;
                            karnetyradio[i].checked = false;
                            karnetyclick[i].style.borderStyle = "none";
                            
                        } else {
                            czy = true;
                            karnetyclick[i].style.border = "4px";
                            karnetyclick[i].style.borderStyle = "solid";
                            karnetyclick[i].style.borderColor = "red";
                        }
                    } else {
                        karnetyclick[i].style.border = "none";
                    }

                
                };
                if(czy == true){
                    document.getElementById("kupkarnet").removeAttribute("disabled");
                } else if(czy == false){
                    document.getElementById("kupkarnet").setAttribute("disabled", "");
                }

            }

            karnetyclick = document.getElementsByClassName("karnet");
            for(let i = 0; i <karnetyclick.length; i++){
                karnetyclick[i].addEventListener("click",czykarnetzaznaczony )
            }
        </script>
    </body>
</html>