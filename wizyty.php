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
    if (isset($_POST['log-in'])) {
        $login = $_POST['login'];
        $haslo = $_POST['password'];
        $zap1 = "select * from users where login = '$login' and haslo = '$haslo'";
        $que1 = mysqli_query($db, $zap1);
        if ($row = mysqli_fetch_array($que1)) {
            $_SESSION['zal'] = True;
            $_SESSION['imie'] = $row['imie'];
            $_SESSION['nazw'] = $row['nazwisko'];
            $_SESSION['klasa'] = "Uzytkownik";
            $_SESSION['idu'] = $row['idu'];
            if ($row['pracownik'] == True) {
                $_SESSION['pra'] = True;
                $_SESSION['klasa'] = "Pracownik";
            }
            if ($row['admin'] == True) {
                $_SESSION['adm'] = True;
                $_SESSION['klasa'] = "Admin";
            }
        } else {
            echo "<div class='error'>
                SPROBOJ PONOWNIE
                </div>";
        }
    }
    if(isset($_SESSION['idu'])){
        $id = $_SESSION['idu'];
        $zap5 = "select * from users where idu = $id";
        $que5 = mysqli_query($db, $zap5);
        if($row = mysqli_fetch_array($que5)){
            if($row['karnet'] != null or $row['karnet'] != 0){
            $_SESSION['czykarnet'] = true;
            $_SESSION['ktorykarnet'] = $row['karnet'];
            
        } else {
            $_SESSION['czykarnet'] = false;
        }
    }
    }

    if (isset($_POST['log-out'])) {
        session_destroy();
        header("Location: index.php");
    }

    if (isset($_POST['reg-in'])) {
        header("Location: register.php");
    }

    if (isset($_POST['kupkarnet'])) {
        $_SESSION['kupkarnet'] = $_POST['karnet'];
        $nazwakarnetu = $_POST['karnet'];
        $zap4 = "select idk from karnety where nazwa ='$nazwakarnetu'";
        $que4 = mysqli_query($db, $zap4);
        if($row = mysqli_fetch_array($que4)){
            $_SESSION['idkupkarnet'] = $row['idk'];
        }
        header("Location:potwkarnetu.php");
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


    <div class='login-container'>
        <form method='POST'>
            <?php
            if (!isset($_SESSION['zal']) or $_SESSION['zal'] == False) {
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
                echo "<div class='zalogowany'> Zalogowano <span style='color:red'><br> $klasa</span><br>";
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
        <a href="index.php" class='menu-button'>
            <div class='icon-div'><img src='house.png' class='icon'></div>
            <div class='button-text-div'><span class='button-text'> HOME</span></div>
        </a>
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
            WIZYTY
        </div>
        <div class='content-div'>
            <?php
            if(isset($_POST['umow'])){
                $dataumow = $_POST['dataumow'];
                $godzumow = $_POST['godzumow'];
                $idu = $_SESSION['idu'];
                $zap10 = "INSERT INTO `wizyty` (`idw`, `cena`, `idu`, `data`, `godzina`) VALUES (NULL, 'karnet', '$id', '$dataumow', '$godzumow')";
                mysqli_query($db, $zap10);
            }

            if(isset($_POST['umowbezk'])){
                $dataumow = $_POST['dataumowbez'];
                $godzumow = $_POST['godzumowbez'];
                $idu = $_SESSION['idu'];
                $cenafi = 0;
                foreach($_SESSION['uslugi'] as $ele){
                    if(isset($_POST[$ele])){
                        $cenafi += $_POST[$ele];
                    }
                }
                if($cenafi != 0){
                $zap10 = "INSERT INTO `wizyty` (`idw`, `cena`, `idu`, `data`, `godzina`) VALUES (NULL, '$cenafi', '$id', '$dataumow', '$godzumow')";
                mysqli_query($db, $zap10);
                }
            }

            if(isset($_POST['usunwiz'])){
                $listaid = [];
                $zap11 = "select idw from wizyty";
                $que11 = mysqli_query($db, $zap11);
                while($row = mysqli_fetch_array($que11)){
                    $idw = $row['idw'];
                    array_push($listaid, $idw);
                }
                $zaznaczone = [];
                foreach($listaid as $ele){
                    if(isset($_POST[$ele])){
                        array_push($zaznaczone, $ele);
                    }
                }

                foreach($zaznaczone as $ele2){
                    $zap12 = "delete from wizyty where idw = $ele2";
                    mysqli_query($db, $zap12);
                }
            }




                echo "<div class='dane-lewa'>";
                $dzis = date("Y-m-d");
                $mieszamies = date("m")+1;
                if($mieszamies == 13){
                    $mieszamies = 1;
                }
                $zamies = date("Y-").$mieszamies.date("-d");
                $id = $_SESSION['idu'];
                $zap8 = "select users.karnet, karnety.nazwa, karnety.iloscwizyt from users, karnety where users.karnet = karnety.idk and users.idu = $id";
                $que8 = mysqli_query($db, $zap8);
                if($row = mysqli_fetch_array($que8)){
                    if($row['karnet'] != null and $row['karnet'] != 0){
                    echo"<div style='width:100%; border-bottom: 3px solid red;padding-bottom:10px' > Poziom karnetu:<span> ".$row['nazwa']."</span>";
                    $makswizyt = $row['iloscwizyt'];
                    echo "<br>Ilosc max wizyt miesiecznie:<span> ".$row['iloscwizyt']."</span></div><br><br>";
                    $zap9 = "select cena, data, idw, godzina from wizyty where idu = $id and data between '$dzis' and '$zamies' order by data";
                    $que9 = mysqli_query($db, $zap9);
                    $iloscwizytjuz = 0;
                    $iloscwizytjuzbezkarnetu = 0;
                    echo "<form method='POST'>";
                    echo "<input type='submit' style='margin-bottom:20px;' value = 'anuluj wizyte' name='usunwiz'><br>";
                    while($row = mysqli_fetch_array($que9)){
                        if($row['cena'] != "karnet"){
                            $iloscwizytjuzbezkarnetu += 1;
                        } else {
                            $iloscwizytjuz += 1;
                        }
                        if($iloscwizytjuz + $iloscwizytjuzbezkarnetu > 0){
                        $data = $row['data'];
                        $idw = $row['idw'];
                        $cena = $row['cena'];
                        
                        if($row['cena'] != "karnet"){
                            echo "<label>- (<span>$cena</span> zl) Data: <span>".$row['data']." </span>godzina: <span>".$row['godzina']."</span><input type='checkbox' class='radiowizyty' name='$idw' value='$idw'></label><br>"; 

                        } else {
                            echo "<label>- (K) Data: <span>".$row['data']." </span>godzina: <span>".$row['godzina']."</span><input type='checkbox' class='radiowizyty' name='$idw' value='$idw'></label><br>"; 

                        }
                        }
                    }
                    echo "</form>";
                    echo "<br>Ilosc wizyt w ciagu nastepnego miesiaca z karnetem: <span>$iloscwizytjuz</span><br>";
                    echo "<br>Ilosc wizyt w ciagu nastepnego miesiaca poza karnetem: <span>$iloscwizytjuzbezkarnetu</span><br>";
                    if($iloscwizytjuz < $makswizyt){
                    echo "<form method='POST'><input style='margin-top:15px'type='date' required name='dataumow'> <input required type='time' name='godzumow'> <input type='submit' class='umow' value='umow' name='umow'></form>";
                    }
                }
                } else {
                        echo "Poziom karnetu: Brak";
                        $zap9 = "select cena, data, idw, godzina from wizyty where idu = $id and data between '$dzis' and '$zamies' order by data";
                    $que9 = mysqli_query($db, $zap9);
                    $iloscwizytjuz = 0;
                    $iloscwizytjuzbezkarnetu = 0;
                    echo "<form method='POST'>";
                    echo "<input type='submit' style='margin-top:20px;' value = 'anuluj wizyte'  name='usunwiz'><br>";
                    while($row = mysqli_fetch_array($que9)){
                        $data = $row['data'];
                        $idw = $row['idw'];
                        $cena = $row['cena'];
                        if($row['cena'] != "karnet"){
                            $iloscwizytjuzbezkarnetu += 1;
                        } else {
                            $iloscwizytjuz += 1;
                        }
                        if($iloscwizytjuzbezkarnetu> 0){
                        $data = $row['data'];
                        $idw = $row['idw'];
                        echo "<label>- (<span>$cena</span> zl) Data: <span>".$row['data']." </span>godzina: <span>".$row['godzina']."</span><input type='checkbox' class='radiowizyty' name='$idw' value='$idw'></label><br>"; 
                        echo "</form>";

                        }
                    }
                    echo "<br>Ilosc wizyt w ciagu nastepnego miesiaca poza karnetem: <span>$iloscwizytjuzbezkarnetu</span><br>";
                    }
                
                    echo "</div>";
            ?>

            <div class="dane-prawa">
                <div style='width:100%;font-size:150%; border-bottom: 3px solid red;padding-bottom:10px'>
                    Umawianie wizyt poza karnetem<br>
                    ponizej znajduje sie <span>cennik</span>

                    <br><form method='POST'><input style='margin-top:15px'type='date' required name='dataumowbez'> <input required type='time' name='godzumowbez'> <input type='submit' class='umow' value='umow' name='umowbezk'>
                    <ul>
                        <?php
                            $zap13 = "select * from uslugi";
                            $que13 = mysqli_query($db, $zap13);
                            $_SESSION['uslugi'] = [];
                            while($row = mysqli_fetch_array($que13)){
                                $usluga = $row['nazwa'];
                                $cenau = $row['cena'];
                                $iduslugi = $row['iduslugi'];
                                array_push($_SESSION['uslugi'], $usluga);
                                echo "<li><label><input type='checkbox' name='$usluga' value='$cenau'>$usluga <span>$cenau</span><label>";
                            }    
                            echo "</form>";
                        ?>   
                    </ul>
                </div>
            </div>
        </div>
        
    </div>


    <script>
        let slideIndex = 0;

        showSlides();

        function showSlides() {
            let i;
            let slides = document.getElementsByClassName('background');
            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = 'none';
            }
            slideIndex++;
            if (slideIndex > slides.length) {
                slideIndex = 1;
            }

            slides[slideIndex - 1].style.display = 'block';

            setTimeout(showSlides, 8000);
        }

        function czykarnetzaznaczony() {

            karnetyradio = document.getElementsByClassName("radiokarnet");
            karnetyclick = document.getElementsByClassName("karnet");
            var czy = false;
            for (let i = 0; i < karnetyradio.length; i++) {
                if (karnetyradio[i].checked == true) {
                    if (karnetyclick[i].style.borderColor == "red") {
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
            if (czy == true) {
                document.getElementById("kupkarnet").removeAttribute("disabled");
            } else if (czy == false) {
                document.getElementById("kupkarnet").setAttribute("disabled", "");
            }

        }
        var niedodawajlistenerow = false;
        karnetyclick = document.getElementsByClassName("karnet");
        for (let i = 0; i < karnetyclick.length; i++) {
            if(karnetyclick[i].style.borderColor == "red"){
                niedodawajlistenerow = true;
            }
        }
        if(niedodawajlistenerow == false){
            for (let i = 0; i < karnetyclick.length; i++) {
                karnetyclick[i].addEventListener("click", czykarnetzaznaczony);
        }
        }
    </script>
</body>

</html>