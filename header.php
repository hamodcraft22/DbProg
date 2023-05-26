<?php
include 'importClass.php';

// getting username and password from the log in form 
if (isset($_POST['loginForm']))
{
    $username = $_POST['usernameInput'];
    $password = $_POST['passwordInput'];

// setting the username and password to a user obj  
    $user = new User();
    $user->setUserName($username);
    $user->setPassword($password);

// if users login isnt successful display error message 
    if (!$user->login())
    {
        echo '<div class="alert alert-danger alert-dismissible fade show " role="alert">
                Wrong Username or Password, Please try again.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
    }
}


if (isset($_POST['searchForm']))
{
    $search = new Search();

    if (isset($_POST['serachBy']) && (($_POST['serachBy'] == 'ttlDesc') || ($_POST['serachBy'] == 'authName')))
    {
        $textInput = $_POST['searchTextInput'];
        $textSearchType = $_POST['searchType'];

        
        
        if ($textSearchType == 'all')
        {
            $textInput = $search->handleAll($textInput);
        }

        if ($textSearchType == 'none')
        {
            $textInput = $search->handleNone($textInput);
        }

        if ($textSearchType == 'first')
        {
            $textInput = $search->handleFirst($textInput);
        }

        if ($textSearchType == 'part')
        {
            $textInput = $search->handlePart($textInput);
        }

        if ($textSearchType == 'exact')
        {
            $textInput = $search->handleExact($textInput);
        }


        
        if ($_POST['serachBy'] == 'ttlDesc')
        {
            $_SESSION['serachOut'] = $search->byTitleDesc($textInput);
        }

        if ($_POST['serachBy'] == 'authName')
        {
            $_SESSION['serachOut'] = $search->byAuthor($textInput);
        }

        echo "<script>window.location.href='articlesResults.php';</script>";
        exit;
    }

    if (isset($_POST['serachBy']) && $_POST['serachBy'] == 'datePosted')
    {
        $dateInput = $_POST['dateSearchInput'];

        $_SESSION['serachOut'] = $search->byDate($dateInput);

        echo "<script>window.location.href='articlesResults.php';</script>";
        exit;
    }
    else if (isset($_POST['serachBy']) && $_POST['serachBy'] == 'dateRange')
    {
        $dateSatrtInput = $_POST['beginDateInput'];
        $dateEndInput = $_POST['endDateInput'];

        $_SESSION['serachOut'] = $search->byDateRange($dateSatrtInput, $dateEndInput);

        echo "<script>window.location.href='articlesResults.php';</script>";
        exit;
    }
}
?>

<!-- start of html code -->
<html>
    <head>

        <title>The MAZS's</title>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">


        <!--link to stylesheet and boostrap link-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
        <link href="style.css" rel="stylesheet" type="text/css">

        <!--link to font file-->
        <script src="https://kit.fontawesome.com/d5bcc006a2.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js" integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

        <!-- scripts and functions - fancy ocd stuff -->
        <script type="text/javascript">

            function showHideSearch()
            {
                if (document.getElementById("ttlDesc").checked || document.getElementById("authName").checked)
                {
                    document.getElementById("textSearchDiv").style.display = 'block';
                    document.getElementById("searchTextInput").setAttribute("required", "");

                    document.getElementById("dateSearchDiv").style.display = 'none';
                    document.getElementById("dateSearchInput").removeAttribute("required");

                    document.getElementById("dateRangeDiv").style.display = 'none';
                    document.getElementById("beginDateInput").removeAttribute("required");
                    document.getElementById("endDateInput").removeAttribute("required");

                    document.getElementById("dateRange").style.display = 'none';
                    document.getElementById("dateRangeLbl").style.display = 'none';


                } else if (document.getElementById("datePosted").checked)
                {
                    document.getElementById("textSearchDiv").style.display = 'none';
                    document.getElementById("searchTextInput").removeAttribute("required");

                    document.getElementById("dateSearchDiv").style.display = 'block';
                    document.getElementById("dateSearchInput").setAttribute("required", "");

                    document.getElementById("dateRangeDiv").style.display = 'none';
                    document.getElementById("beginDateInput").removeAttribute("required");
                    document.getElementById("endDateInput").removeAttribute("required");

                    document.getElementById("dateRange").style.display = 'inline-block';
                    document.getElementById("dateRangeLbl").style.display = 'inline-block';

                    if (document.getElementById("dateRange").checked)
                    {
                        document.getElementById("textSearchDiv").style.display = 'none';
                        document.getElementById("dateSearchDiv").style.display = 'none';
                        document.getElementById("dateRangeDiv").style.display = 'block';

                        document.getElementById("searchTextInput").removeAttribute("required");
                        document.getElementById("dateSearchInput").removeAttribute("required");

                        document.getElementById("beginDateInput").setAttribute("required", "");
                        document.getElementById("endDateInput").setAttribute("required", "");
                    }
                }
            }

            $(document).ready(function(){
                $('#form input').blur(function(){
                    if(!$(this).val()){
                        $(this).attr("placeholder", "required");
                        $(this).css("border-color","red");
                    } else{
                        $(this).attr("placeholder", "text");
                        $(this).css("border-color","green");
                    }
                });
            });
        </script>
    </head>

    <body>

        <!--navigation bar -->
        <nav class="navbar navbar-expand-lg bg-body-tertiary" id="mainNavBar">
            <div class="container-fluid">

                <a class="navbar-brand" href="index.php">
                    <img src="assests/logo.png" alt="Bootstrap" height="50">
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 ">


                        <li class="nav-item">
                            <a class="nav-link" href="categoryView.php?catID=1">International</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="categoryView.php?catID=2">Local</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="categoryView.php?catID=3">Sports & Arts</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="categoryView.php?catID=4">Weather</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="categoryView.php?catID=5">Advertisement</a>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Cars</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="categoryView.php?catID=6">Electric</a></li>
                                <li><a class="dropdown-item" href="categoryView.php?catID=7">Gas Monsters</a></li>
                            </ul>
                        </li>

                        <?php
                        // function to check if the role of the user is admin then he has the admin menue                         
                        if (isset($_SESSION['roleType']) && $_SESSION['roleType'] == 'admin')
                        {
                            echo
                            '

                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Admin</a>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="users.php">Users</a></li>
                                            <li><a class="dropdown-item" href="articles.php">Articles</a></li>
                                        </ul>
                                    </li>
                                ';
                        }
                        ?>



                        <?php
                        // function to check if the role of the user is an author then he has the author menue
                        if (isset($_SESSION['roleType']) && $_SESSION['roleType'] == 'author')
                        {
                            $userID = $_SESSION['userID'];
                            echo
                            '
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Author</a>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="articles.php?userID=' . $userID . '">My Articles</a></li>
                                        </ul>
                                    </li>
                                ';
                        }
                        ?>

                    </ul>




                    <div class="navbar-nav ml-auto">

                        <!-- Search menu -->
                        <ul class="navbar-nav">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </a>

                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDarkDropdownMenuLink">
                                    <li>
                                        <div class="row px-3" style="min-width: 500px;">
                                            <div class="col-mx-2">
                                                <form class="form" id="form" role="form" method="post" accept-charset="UTF-8" id="search-nav">

                                                    <!-- text search -->
                                                    <div class="form-group mt-1" id="textSearchDiv">
                                                        <label for="searchTextInput">Search Phrases</label><br>
                                                        <input type="text" class="form-control" id="searchTextInput" name="searchTextInput" placeholder="Text">
                                                        <div>
                                                            <br>
                                                            <b>Find Results with: </b><br>
                                                            <input type="radio" name="searchType" value="any" checked> Any of these words<br>
                                                            <input type="radio" name="searchType" value="all"> All of these words<br>
                                                            <input type="radio" name="searchType" value="none"> None of these words<br>
                                                            <input type="radio" name="searchType" value="first"> Containing first but not second<br>
                                                            <input type="radio" name="searchType" value="part"> Part of this word<br>
                                                            <input type="radio" name="searchType" value="exact"> Exact Term<br>
                                                        </div>
                                                    </div>



                                                    <!-- spescific date search -->
                                                    <div class="form-group mt-1" id="dateSearchDiv">
                                                        <label for="dateSearchInput">Date</label><br>
                                                        <input type="date" class="form-control" id="dateSearchInput" name="dateSearchInput">
                                                    </div>

                                                    <!-- date range search -->
                                                    <div class="form-group mt-1" id="dateRangeDiv">
                                                        <label for="beginDate">Begin Date</label><br>
                                                        <input type="date" class="form-control" id="beginDateInput" placeholder="Text">
                                                        <label for="endDate">End Date</label><br>
                                                        <input type="date" class="form-control" id="endDateInput" placeholder="Text">
                                                        <label for="beginDateInput">Begin Date</label><br>
                                                        <input type="date" class="form-control" id="beginDateInput" name="beginDateInput" placeholder="Text">
                                                        <label for="endDateInput">End Date</label><br>
                                                        <input type="date" class="form-control" id="endDateInput" name="endDateInput" placeholder="Text">
                                                    </div>

                                                    <div class="form-group mt-1 ">
                                                        </br><b>Search By</b></br>

                                                        <input type="radio" id="ttlDesc" name="serachBy" value="ttlDesc" checked onclick="showHideSearch()">
                                                        <label for="ttlDesc">Title / Heading</label><br>

                                                        <input type="radio" id="authName" name="serachBy" value="authName" onclick="showHideSearch()">
                                                        <label for="authName">Author Name</label><br>

                                                        <input type="radio" id="datePosted" name="serachBy" value="datePosted" onclick="showHideSearch()">
                                                        <label for="datePosted">Date of Post</label>

                                                        <input type="checkbox" id="dateRange" name="serachBy" value="dateRange" onclick="showHideSearch()">
                                                        <label for="dateRange" id="dateRangeLbl">Date Range</label>
                                                    </div>

                                                    <div class="form-group mt-1">
                                                        <input type="hidden" name="searchForm" value="true">
                                                        <button type="submit" class="btn btn-primary btn-block">Search</button>
                                                    </div>


                                                </form>
                                            </div>
                                        </div>
                                    </li>


                                </ul>
                            </li>
                        </ul>


                        <!-- login menu -->
                        <ul class="navbar-nav">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                                    Account
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDarkDropdownMenuLink" style="min-width: 250px;">




                                    <?php
                                    if (!isset($_SESSION['userID']) || $_SESSION['userID'] == null)
                                    {
                                        echo '<li>
                                                    <div class="row px-3">
                                                        <div class="col-md-12">
                                                            <form class="form" id="form" role="form" method="post" accept-charset="UTF-8" id="login-nav">
                                                                <div class="form-group mt-1">
                                                                    <input type="text" class="form-control" id="usernameInput" name="usernameInput" placeholder="Username" required="">
                                                                </div>
                                                                <div class="form-group mt-1">
                                                                    <input type="password" class="form-control" id="passwordInput" name="passwordInput" placeholder="Password" required="">
                                                                </div>
                                                                <div class="form-group mt-1">
                                                                    <button type="submit" class="btn btn-primary btn-block">Sign in</button>
                                                                </div>
                                                                <input type="hidden" name="loginForm" value="true">
                                                            </form>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="dropdown-divider"></li>
                                                <li><a class="dropdown-item" href="register.php"><i class="fa-regular fa-user"></i> Sign up</a></li>';
                                    }
                                    ?>


<?php
if (isset($_SESSION['userID']) && $_SESSION['userID'] != null)
{
    echo
    '   <li><p class="dropdown-item">Welcome Back ' . $_SESSION['username'] . '!</p></li>
                                            <!--// add profile picture part here-->
                                            <li class="dropdown-divider"></li>
                                            <li><a class="dropdown-item" href="profile.php"><i class="fa-regular fa-user"></i> Profile</a></li>
                                            <li><a class="dropdown-item" href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> Log Out</a></li>
                                        ';
                                    }
                                    ?>
                                    <li><a class="dropdown-item"><i class="fa-solid"></i><div id="google_translate_element"></div></a></li>

                                </ul>
                            </li>
                        </ul>


                    </div>

                </div>
            </div>
        </nav>

        <script>
            showHideSearch();
            function googleTranslateElementInit() {
                new google.translate.TranslateElement({pageLanguage: 'en'}, 'google_translate_element');
            }
        </script>
<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>




