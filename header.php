<html>
    <head>
        <title>TITLE - FIX</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
        <link href="style.css" rel="stylesheet" type="text/css">

        <script src="https://kit.fontawesome.com/d5bcc006a2.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js" integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ" crossorigin="anonymous"></script>
    </head>

    <body>


        <nav class="navbar navbar-expand-lg bg-body-tertiary" id="mainNavBar">
            <div class="container-fluid">

                <a class="navbar-brand" href="#">
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
                    </ul>




                    <div class="navbar-nav ml-auto">

                        <!-- Search menu -->
                        <ul class="navbar-nav">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </a>

                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDarkDropdownMenuLink">
                                    <li>
                                        <div class="row px-3" style="min-width: 500px;">
                                            <div class="col-mx-2">
                                                <form class="form" role="form" method="post" action="login" accept-charset="UTF-8" id="login-nav">
                                                    <div class="form-group mt-1 ">
                                                        <label class="sr-only" for="exampleInputEmail2">Username</label>
                                                        <input type="email" class="form-control" id="exampleInputEmail2" placeholder="Email address" required="">
                                                    </div>
                                                    <div class="form-group mt-1 ">
                                                          <input type="radio" id="html" name="fav_language" value="HTML">
                                                          <label for="html">HTML</label><br>
                                                          <input type="radio" id="css" name="fav_language" value="CSS">
                                                          <label for="css">CSS</label><br>
                                                          <input type="radio" id="javascript" name="fav_language" value="JavaScript">
                                                          <label for="javascript">JavaScript</label>
                                                    </div>
                                                    <div class="form-group mt-1">
                                                        <button type="submit" class="btn btn-primary btn-block">Sign in</button>
                                                    </div>

                                                </form>
                                            </div>
                                        </div>
                                    </li>


                                </ul>
                            </li>
                        </ul>


                        <!-- notification menu -->
                        <ul class="navbar-nav">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa fa-bell-o"></i>
                                    <span class="position-absolute top-0 start-50 translate-middle badge rounded-pill bg-danger">
                                        99
                                        <span class="visually-hidden">unread messages</span>
                                    </span>
                                </a>

                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDarkDropdownMenuLink">
                                    <li>
                                        <div class="row px-3" style="min-width: 500px;">
                                            <div class="col-mx-2">
                                                notifications
                                            </div>
                                        </div>
                                    </li>


                                </ul>
                            </li>
                        </ul>



                        <!-- login menu -->
                        <ul class="navbar-nav">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Account
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDarkDropdownMenuLink">


                                    <li>
                                        <div class="row px-3">
                                            <div class="col-md-12">
                                                <form class="form" role="form" method="post" action="login" accept-charset="UTF-8" id="login-nav">
                                                    <div class="form-group mt-1">
                                                        <label class="sr-only" for="exampleInputEmail2">Username</label>
                                                        <input type="email" class="form-control" id="exampleInputEmail2" placeholder="Email address" required="">
                                                    </div>
                                                    <div class="form-group mt-1">
                                                        <label class="sr-only" for="exampleInputPassword2">Password</label>
                                                        <input type="password" class="form-control" id="exampleInputPassword2" placeholder="Password" required="">
                                                        <div class="help-block text-right mt-1"><a href="">Forget password ?</a></div>
                                                    </div>
                                                    <div class="form-group mt-1">
                                                        <button type="submit" class="btn btn-primary btn-block">Sign in</button>
                                                    </div>

                                                </form>
                                            </div>

                                        </div>
                                    </li>

                                    <li class="dropdown-divider"></li>

                                    <li><a class="dropdown-item" href="#"><i class="fa-regular fa-user"></i> Action</a></li>
                                    <li><a class="dropdown-item" href="#">Another action</a></li>
                                    <li class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="#"><i class="fa-solid fa-right-from-bracket"></i> Something else here</a></li>
                                </ul>
                            </li>
                        </ul>


                    </div>

                </div>
            </div>
        </nav>





