<?php
include './header.php';

$user = new User();

$user->setUserID($_SESSION['userID']);
$user->initWithID();


if (isset($_SESSION['roleType']) && $_SESSION['roleType'] == 'admin')
{
    if (isset($_GET['id']))
    {
        $user->setUserID($_GET['id']);
        $user->initWithID();
    }
}



//add part to edit user with id from get method

if (isset($_POST['profileForm']))
{
    $fullname = $_POST['fullNameInput'];
    $email = $_POST['emailInput'];
    $phone = $_POST['numberInput'];
    
    //add validiation here
    
    $user->setFullname($fullname);
    $user->setEmail($email);
    $user->setPhone($phone);
    
    if ($user->updateUser())
    {
       
        echo 'update done';
    }
    else
    {
        echo 'error in saving, try again';
    }
}

?>

<script type="text/javascript">
    function chnageSize()
    {
        var height = ((window.innerHeight) - (document.getElementById('mainNavBar').offsetHeight));
        document.getElementById('profilePageBody').setAttribute("style", "height:" + height);
    }


    window.addEventListener('resize', chnageSize);
</script>

<section <?php if(!(isset($_GET['id']) && isset($_SESSION['roleType']) && $_SESSION['roleType'] != 'admin')){echo 'hidden';} else {echo 'id="profilePageBody"';}  ?>>
    <div class="container h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-xl-9">

                <h1 class="text-black mb-4">Profile</h1>

                <div class="card shadow" style="border-radius: 15px;">
                    
                    <p class="text-center">You cannot edit other's information</p>

                </div>

            </div>
        </div>
    </div>
</section>

<!-- implemented from  mdbootstrap.com -->
<!-- https://mdbootstrap.com/docs/standard/extended/registration/ -->

<section <?php if ((!(isset($_SESSION['roleType']) && $_SESSION['roleType'] == 'admin')) && (isset($_GET['id']))){echo 'hidden';} else {echo 'id="profilePageBody"';} ?>>
    <div class="container h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-xl-9">

                <h1 class="text-black mb-4">Profile</h1>

                <div class="card shadow" style="border-radius: 15px;">
                    <div class="card-body">
                        <form method="post">
                        <div class="row align-items-center pt-4 pb-3">
                            <div class="col-md-3 ps-5">
                                <h6 class="mb-0">Full name</h6>
                            </div>
                            <div class="col-md-9 pe-5">
                                <input type="text" class="form-control form-control-lg" id="fullNameInput" name="fullNameInput" placeholder="Full Name" required value="<?php echo $user->getFullname(); ?>"/>
                            </div>
                        </div>

                        <hr class="mx-n3">
                        <div class="row align-items-center py-3">
                            <div class="col-md-3 ps-5">
                                <h6 class="mb-0">Email address</h6>
                            </div>
                            <div class="col-md-9 pe-5">
                                <input type="email" class="form-control form-control-lg" id="emailInput" name="emailInput" placeholder="Email Addres" required value="<?php echo $user->getEmail(); ?>"/>
                            </div>
                        </div>
                        
                        <hr class="mx-n3">
                        <div class="row align-items-center py-3">
                            <div class="col-md-3 ps-5">
                                <h6 class="mb-0">Phone Number</h6>
                            </div>
                            <div class="col-md-9 pe-5">
                                <input type="number" class="form-control form-control-lg" id="numberInput" name="numberInput" placeholder="Phone Number" required value="<?php echo $user->getPhone(); ?>"/>
                            </div>
                        </div>





                        <hr class="mx-n3">
                        <div class="px-5 py-4">
                            <button type="submit" class="btn btn-primary btn-lg">Update</button>
                            <a href="index.php" role="button" class="btn btn-secondary btn-lg">Cancel</a>
                            <input type="hidden" name="profileForm" value="true">
                        </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>



<script type="text/javascript">chnageSize();</script>