<html>

<head>
    <meta charset='utf-8'>
    <link rel='stylesheet' href='style.css'>
</head>
<link href='//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css' rel='stylesheet'>
<link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
<link href='https://fonts.cdnfonts.com/css/minecraft-4' rel='stylesheet'>

<body>

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
    $db = mysqli_connect("localhost", "root", "", "myjnia");

    session_start();
    if (isset($_POST['profile'])) {
        header("Location: profil.php");
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
    if (isset($_SESSION['idu'])) {
        $id = $_SESSION['idu'];
        $zap5 = "select * from users where idu = $id";
        $que5 = mysqli_query($db, $zap5);
        if ($row = mysqli_fetch_array($que5)) {
            if ($row['karnet'] != null and $row['karnet'] != 0) {
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
        if (isset($_SESSION['idu'])) {
            $_SESSION['kupkarnet'] = $_POST['karnet'];
            $nazwakarnetu = $_POST['karnet'];
            $zap4 = "select idk from karnety where nazwa ='$nazwakarnetu'";
            $que4 = mysqli_query($db, $zap4);
            if ($row = mysqli_fetch_array($que4)) {
                $_SESSION['idkupkarnet'] = $row['idk'];
            }
            header("Location:potwkarnetu.php");
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
            <div class='icon-div-chosen'><img src='house.png' class='icon'></div>
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
                    <a href='admin.php' class='menu-button'><div class='icon-div'><img src='admin.png' class='icon'></div><div class='button-text-div'><span class='button-text'>
                     Admin</span></div></a>
                ";
        }
        ?>



    </div>

    <div class='main'>
        <div class='naglowek'>
            PIXEL CAR WASH
        </div>
        <div class='content-div historia'>
            Nasza firma jest wiodacym na swiecie producentem myjni samochodowych i
            liderem innowacji w branzy. Pixel Car Wash oferuje myjnie samochodowe dostosowane do wszystkich potrzeb i wymagan,
            poczawszy od myjni portalowych poprzez myjnie tunelowe i myjnie samoobslugowe az po myjnie pojazdow uzytkowych,
            takie jak na przyklad myjnie samochodow ciezarowych. WashTec powstala w roku 2000 w wyniku fuzji firm California Kleindienst
            i Wesumat AG. Dzisiaj przedsiebiorstwo ma swoja glowna siedzibe w Augsburgu i
            zatrudnia w ponad 80 krajach powyzej 1 700 pracownikow, w wiekszosci uznanych specjalistow w dziedzinie myjni samochodowych.
        </div>
        <div class='title-break'>
            DOSTEPNE KARNETY
        </div>
        <div class='content-div' style="background-color: #262423; padding-top:20px; padding-bottom:20px;">
            <form method="POST">
                <div class='karnety'>
                    <?php
                    if (isset($_SESSION['czykarnet'])) {
                        if ($_SESSION['czykarnet'] == false) {

                            echo "
                    <label class='karnet iron'>
                        <img src='iron.png'>
                        <br>
                        <div class='karnet-text'> CENA<br> 200 <img class='emerald' src='emerald.png'> / Mies<br><br><span class='karnet-tytul'>IRON</span></div>
                        <input type='radio' class='radiokarnet' name='karnet' value='Iron'>
                    </label>

                    <label class='karnet gold'>
                        <img src='gold.png'>
                        <br>
                        <div class='karnet-text'> CENA<br> 400 <img class='emerald' src='emerald.png'> / Mies<br><br><span class='karnet-tytul'>GOLD</span></div>
                        <input type='radio' class='radiokarnet' name='karnet' value='Gold'>
                    </label>

                    <label class='karnet diax'>
                        <img src='diax.jpg'>
                        <br>
                        <div class='karnet-text'> CENA<br> 999 <img class='emerald' src='emerald.png'> / Mies<br><br><span class='karnet-tytul'>DIAX</span></div>
                        <input type='radio' class='radiokarnet' name='karnet' value='Diax'>
                    </label>
                ";
                        } else {
                            echo "
                    <label";
                            if ($_SESSION['ktorykarnet'] == 1) {
                                echo " style='border: 3px red solid'";
                            } else {
                                echo " style='filter: brightness(0.5);'";
                            }
                            echo " class='karnet iron'>
                        <img src='iron.png'>
                        <br>
                        <div class='karnet-text'> CENA<br> 200 <img class='emerald' src='emerald.png'> / Mies<br><br><span class='karnet-tytul'>IRON</span></div>
                        <input disabled type='radio' class='radiokarnet' name='karnet' value='Iron'>
                    </label>
                

                    <label";
                            if ($_SESSION['ktorykarnet'] == 2) {
                                echo " style='border: 3px red solid'";
                            } else {
                                echo " style='filter: brightness(0.5);'";
                            }
                            echo "
                    class='karnet gold'>
                        <img src='gold.png'>
                        <br>
                        <div class='karnet-text'> CENA<br> 400 <img class='emerald' src='emerald.png'> / Mies<br><br><span class='karnet-tytul'>GOLD</span></div>
                        <input disabled type='radio' class='radiokarnet' name='karnet' value='Gold'>
                    </label>

                    <label";
                            if ($_SESSION['ktorykarnet'] == 3) {
                                echo " style='border: 3px red solid'";
                            } else {
                                echo " style='filter: brightness(0.5);'";
                            }
                            echo "
                    class='karnet diax'>
                        <img src='diax.jpg'>
                        <br>
                        <div class='karnet-text'> CENA<br> 999 <img class='emerald' src='emerald.png'> / Mies<br><br><span class='karnet-tytul'>DIAX</span></div>
                        <input disabled type='radio' class='radiokarnet' name='karnet' value='Diax'>
                    </label>
                ";
                        }
                    } else {
                        echo "
                    <label class='karnet iron'>
                        <img src='iron.png'>
                        <br>
                        <div class='karnet-text'> CENA<br> 200 <img class='emerald' src='emerald.png'> / Mies<br><br><span class='karnet-tytul'>IRON</span></div>
                        <input type='radio' class='radiokarnet' name='karnet' value='Iron'>
                    </label>

                    <label class='karnet gold'>
                        <img src='gold.png'>
                        <br>
                        <div class='karnet-text'> CENA<br> 400 <img class='emerald' src='emerald.png'> / Mies<br><br><span class='karnet-tytul'>GOLD</span></div>
                        <input type='radio' class='radiokarnet' name='karnet' value='Gold'>
                    </label>

                    <label class='karnet diax'>
                        <img src='diax.jpg'>
                        <br>
                        <div class='karnet-text'> CENA<br> 999 <img class='emerald' src='emerald.png'> / Mies<br><br><span class='karnet-tytul'>DIAX</span></div>
                        <input type='radio' class='radiokarnet' name='karnet' value='Diax'>
                    </label>
                ";
                    }
                    ?>
                </div>
                <input id="kupkarnet" name="kupkarnet" type="submit" disabled style="margin-left:40%; width:20%; height: 50px; margin-top:20px; font-size:130%" value="KUP KARNET">

            </form>
        </div>
        <div class='title-break'>
            Cechy karnetow
        </div>
        <div class="content-div">

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
            if (karnetyclick[i].style.borderColor == "red") {
                niedodawajlistenerow = true;
            }
        }
        if (niedodawajlistenerow == false) {
            for (let i = 0; i < karnetyclick.length; i++) {
                karnetyclick[i].addEventListener("click", czykarnetzaznaczony);
            }
        }
    </script>
</body>

</html>