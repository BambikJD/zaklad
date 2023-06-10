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
    if(!isset($_SESSION['adm'])){
        header("Location: index.php");
    }

    if (isset($_POST['log-out'])) {
        session_destroy();
        header("Location: index.php");
    }

    if (isset($_POST['reg-in'])) {
        header("Location: register.php");
    }

    if (isset($_POST['kupkarnet'])) {
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
    if(isset($_POST['dodaj'])){
        $nazwa = $_POST['nazwausl'];
        $cena = $_POST['cenausl'];
        $zap19 = "INSERT INTO `uslugi` (`iduslugi`, `nazwa`, `cena`) VALUES (NULL, '$nazwa', '$cena')";
        mysqli_query($db, $zap19);
    }

    if(isset($_POST['aktu'])){
        foreach($_SESSION['listaiduslug'] as $ele){
            $cenanowa = $_POST[$ele];
            $zap20 = "UPDATE `uslugi` SET `cena` = '$cenanowa' WHERE `uslugi`.`iduslugi` = $ele";
            mysqli_query($db, $zap20);
        }
    }

    if(isset($_POST['usunusluge'])){
        $iddousu = $_POST['usluga'];
        $zap18 = "delete from uslugi where iduslugi = $iddousu";
        mysqli_query($db, $zap18);
    }

    if(isset($_POST['wyczysc'])){
        $datateraz = date("Y-m-d");
        $zap17 = "delete from wizyty where data <'$datateraz'";
        mysqli_query($db,$zap17);
    }


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
    ?>
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
        <a href="index.php" class='menu-button'>
            <div class='icon-div'><img src='house.png' class='icon'></div>
            <div class='button-text-div'><span class='button-text'> HOME</span></div>
        </a>
        <?php
       if (isset($_SESSION['zal'])) {
        if ($_SESSION['zal'] == true) {
            if (!isset($_SESSION['adm']) and !isset($_SESSION['pra'])) {
                echo "
                <a href='wizyty.php' class='menu-button'><div class='icon-div'><img src='booking.png' class='icon'></div><div class='button-text-div'><span class='button-text'>
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
                <a href='admin.php' class='menu-button'><div class='icon-div-chosen'><img src='admin.png' class='icon'></div><div class='button-text-div'><span class='button-text'>
                 Admin</span></div></a>
            ";
    }
        ?>

    </div>

    <div class='main'>
        <div class='naglowek'>
            Panel admina
        </div>
        Usun przestarzale wizyty <form method="POST"><input type="submit" value="wyczysc" name="wyczysc"></form>
        <div class="title-break">Uslugi</div>
        <div class='content-div'>
        <form method="POST">
            <table class="uslugi" style="border-collapse: collapse">
           
            <tr style="color:red"><td>ID</td><td>Nazwa uslugi</td><td>Cena</td><td style="color:orange; text-align: center">Wyb.</td></tr>
            <?php
            $zap16 = "select * from uslugi";
            $que16 = mysqli_query($db, $zap16);
            $_SESSION['listaiduslug'] = [];
            while($row = mysqli_fetch_array($que16)){
                $iduslugi = $row['iduslugi'];
                $nazwa = $row['nazwa'];
                $cena = $row['cena'];
                array_push($_SESSION['listaiduslug'], $iduslugi);
                echo "<tr><td>$iduslugi</td><td>$nazwa</td><td><input type='number' name='$iduslugi' value=$cena></td><td><input style='transform: scale(1.5); margin-left:35px' type='radio' name='usluga' value=$iduslugi></td></tr>";
            }  
            ?>
          
            </table>
            <div style="width:50%; float:left">
                <input type="submit" name="usunusluge" value="usun"><br><br>
                <input type="submit" name="aktu" value="zapisz"><br><br>
                <input type="submit" name="dodaj" value="dodaj">
                <input type="text" name="nazwausl" placeholder="podaj nazwe uslugi">
                <input type="number" name="cenausl" placeholder="podaj cene">
            </div>
            </form>
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

        karnetyclick = document.getElementsByClassName("karnet");
        for (let i = 0; i < karnetyclick.length; i++) {
            karnetyclick[i].addEventListener("click", czykarnetzaznaczony)
        }
    </script>
</body>

</html>