<?php
include './header.php';

// if the reg form is submitted create new user with following attributes 
if (isset($_POST['registerForm'])) {
    $isAuthor = false;
    $errors = '';

    $user = new User();

    $fullname = $_POST['fullNameInput'];
    $username = $_POST['usernameInput'];
    $email = $_POST['emailInput'];
    $phone = $_POST['numberInput'];
    $password = $_POST['passwordInput'];
    $passwordRpt = $_POST['passwordReInput'];

    // if the user checks author option make him an author 
    if (isset($_POST['authorChoice'])) {
        $isAuthor = true;
    }

    // maybe add some validation here 

    $user->setUserName($username);

    // checks if the name is available 
    if (!$user->checkUsername()) 
    {
        //error message if name isnt available 
        echo  ' <div class="alert alert-danger alert-dismissible fade show " role="alert">'.
        $errors.'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
        
    }
    
    // checks if the password matches the pssword in the repeat field 
    if ($password != $passwordRpt) 
    {
        //error message if password doesnt match
        $errors .= 'passwords are not matching.</br>';
    }
    
    // if there is no error create user 
    if ($errors == '')
    {
        $user->setFullname($fullname);
        $user->setPassword($password);
        $user->setEmail($email);
        $user->setPhone($phone);
        $user->setPassword($password);
        
        // set role as an author if its selected 
        if ($isAuthor)
        {
            $user->setRoleID(3);
        }
        else // else just give him a noremal user role
        {
            $user->setRoleID(2);
        }
        
        // checks if registration is succesful 
        if ($user->register())
        {
            // if it is succesful log in the user and redirect him to the index page
            if ($user->login())
            {
                echo "<script>window.location.href='index.php';</script>";
                exit;
            }
        }
        else
        {
            echo 'issue no reg';
                
            
            
            
            
        }
    }
    else
    {
        echo 'errors :';
        echo $errors;
    }
}
?>

<script type="text/javascript">
    function chnageSize()
    {
        var height = ((window.innerHeight) - (document.getElementById('mainNavBar').offsetHeight));
        document.getElementById('regPageBody').setAttribute("style", "height:" + height);
    }


    window.addEventListener('resize', chnageSize);
</script>


<!-- implemented from  mdbootstrap.com -->
<!-- https://mdbootstrap.com/docs/standard/extended/registration/ -->

<section id="regPageBody">
    <div class="container h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-lg-12 col-xl-11">
                <div class="card shadow text-black" style="border-radius: 25px;">
                    <div class="card-body p-md-5">
                        <div class="row justify-content-center">
                            <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">

                                <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Sign up</p>

                                <form class="mx-1 mx-md-4" method="post" >

                                    <div class="d-flex flex-row align-items-center mb-4">
                                        <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                                        <div class="form-outline flex-fill mb-0">
                                            <input type="text" id="fullNameInput" name="fullNameInput" class="form-control" placeholder="Full Name" required/>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-row align-items-center mb-4">
                                        <i class="fa-regular fa-user fa-lg me-3 fa-fw"></i>
                                        <div class="form-outline flex-fill mb-0">
                                            <input type="text" id="usernameInput" name="usernameInput" class="form-control" placeholder="Username" required/>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-row align-items-center mb-4">
                                        <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                                        <div class="form-outline flex-fill mb-0">
                                            <input type="email" id="emailInput" name="emailInput" class="form-control" placeholder="Email Addres" required/>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-row align-items-center mb-4">
                                        <i class="fa-solid fa-phone fa-lg me-3 fa-fw"></i>
                                        <div class="form-outline flex-fill mb-0">
                                            <input type="number" id="numberInput" name="numberInput" class="form-control" placeholder="Phone Number" required/>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-row align-items-center mb-4">
                                        <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                                        <div class="form-outline flex-fill mb-0">
                                            <input type="password" id="passwordInput" name="passwordInput" class="form-control" placeholder="Password" required/>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-row align-items-center mb-4">
                                        <i class="fas fa-key fa-lg me-3 fa-fw"></i>
                                        <div class="form-outline flex-fill mb-0">
                                            <input type="password" id="passwordReInput" name="passwordReInput" class="form-control" placeholder="Repeat Password" required/>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-row align-items-center mb-4">
                                        <i class="fas fa-book fa-lg me-3 fa-fw"></i>
                                        <div class="form-outline flex-fill mb-0">
                                            <input type="checkbox" id="authorChoice" name="authorChoice" value="true">
                                            <label for="authorChoice"> Register as an Author?</label><br>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                        <button type="submit" class="btn btn-primary btn-lg">Register</button>
                                    </div>

                                    <input type="hidden" name="registerForm" value="true">
                                </form>

                            </div>
                            <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">

                                <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-registration/draw1.webp"
                                     class="img-fluid" alt="Sample image">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">chnageSize();</script>