<?php
include 'importClass.php';

// getting username and password from the log in form 
if (isset($_POST['loginForm'])) {
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


if (isset($_POST['searchForm'])) {

    echo 'serach form was submitted';
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

            function SearchValidation() {
                if (document.getElementById("ttlDesc").checked || document.getElementById("authName").checked) 
                {
                    let text = document.getElementById("searchTextInput");
                    
                    if (document.getElementById("ttlDesc").checked) 
                    {
                        if (text.value == "") 
                        {
                            text.style.borderColor = "red";
                            text.placeholder = "Required";
                        } else {
                            text.style.borderColor = "green";
                            text.placeholder = "TEXT";
                        }
                    } else {
                        let text = document.getElementById("searchTextInput");
                        if (text.value == "") {
                            text.style.borderColor = "red";
                            text.placeholder = "Required";
                        } else {
                            text.style.borderColor = "green";
                            text.placeholder = "TEXT";
                        }
                    }
                } else if (document.getElementById("datePosted").checked) {
                    let text = document.getElementById("dateSearchInput");
                    if (text.value == "") {
                        text.style.borderColor = "red";
                        text.placeholder = "Required";
                    } else {
                        text.style.borderColor = "green";
                        text.placeholder = "TEXT";
                    }
                    if (document.getElementById("dateRange").checked) {
                        let text = document.getElementById("beginDateInput");
                        let text2 = document.getElementById("endDateInput");
                        if (text.value == "") {
                            text.style.borderColor = "red";
                            text.placeholder = "Required";
                        } else {
                            text.style.borderColor = "green";
                            text.placeholder = "TEXT";
                        }
                        if (text2.value == "") {
                            text2.style.borderColor = "red";
                            text2.placeholder = "Required";
                        } else {
                            text2.style.borderColor = "green";
                            text2.placeholder = "TEXT";
                        }
                    }
                }
            }

            function LoginValidation() {
                let userName = document.getElementById("usernameInput");
                let password = document.getElementById("passwordInput");
                if (userName.value == "" && password.value == "") {
                    userName.style.borderColor = "red";
                    userName.placeholder = "Required";
                    password.style.borderColor = "red";
                    password.placeholder = "Required";
                } else if (userName.value == "" && password.value.length > 0) {
                    userName.style.borderColor = "red";
                    userName.placeholder = "Required";
                    password.style.borderColor = "green";
                    password.placeholder = "TEXT";
                } else if (password.value == "" && userName.value.length > 0) {
                    password.style.borderColor = "red";
                    password.placeholder = "Required";
                    userName.style.borderColor = "green";
                    userName.placeholder = "TEXT";
                } else {
                    userName.style.borderColor = "green";
                    password.style.borderColor = "green";
                    userName.placeholder = "TEXT";
                    password.placeholder = "TEXT";
                }
            }
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
                            <a class="nav-link" href="#">International</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="#">Local</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="#">Sports & Arts</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="#">Weather</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="#">Advertisement</a>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Cars</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Electric</a></li>
                                <li><a class="dropdown-item" href="#">Gas Monsters</a></li>
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
                                                <form class="form" role="form" method="post" accept-charset="UTF-8" id="search-nav">

                                                    <!-- text search -->
                                                    <div class="form-group mt-1" id="textSearchDiv">
                                                        <label for="searchText">Search Phrases</label><br>
                                                        <input type="text" class="form-control" id="searchTextInput" placeholder="Text" onblur="SearchValidation()">
                                                    </div>

                                                    <!-- spescific date search -->
                                                    <div class="form-group mt-1" id="dateSearchDiv">
                                                        <label for="dateSearch">Date</label><br>
                                                        <input type="date" class="form-control" id="dateSearchInput" onblur="SearchValidation()">
                                                    </div>

                                                    <!-- date range search -->
                                                    <div class="form-group mt-1" id="dateRangeDiv">
                                                        <label for="beginDate">Begin Date</label><br>
                                                        <input type="date" class="form-control" id="beginDateInput" placeholder="Text" onblur="SearchValidation()">
                                                        <label for="endDate">End Date</label><br>
                                                        <input type="date" class="form-control" id="endDateInput" placeholder="Text" onblur="SearchValidation()">
                                                    </div>

                                                    <div class="form-group mt-1 ">
                                                        <p>Search By</p>

                                                        <input type="radio" id="ttlDesc" name="serachBy" value="Title / Description" checked onclick="showHideSearch()">
                                                        <label for="css">Title / Heading</label><br>

                                                        <input type="radio" id="authName" name="serachBy" value="Author Name" onclick="showHideSearch()">
                                                        <label for="html">Author Name</label><br>

                                                        <input type="radio" id="datePosted" name="serachBy" value="Date of Post" onclick="showHideSearch()">
                                                        <label for="javascript">Date of Post</label>

                                                        <input type="checkbox" id="dateRange" name="serachBy" value="Date Range" onclick="showHideSearch()">
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
                                                            <form class="form" role="form" method="post" accept-charset="UTF-8" id="login-nav">
                                                                <div class="form-group mt-1">
                                                                    <input type="text" class="form-control" id="usernameInput" name="usernameInput" placeholder="Username" required="" onblur="LoginValidation()">
                                                                </div>
                                                                <div class="form-group mt-1">
                                                                    <input type="password" class="form-control" id="passwordInput" name="passwordInput" placeholder="Password" required="" onblur="LoginValidation()">
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

                                </ul>
                            </li>
                        </ul>


                    </div>

                </div>
            </div>
        </nav>

        <script>
            showHideSearch();
        </script>




