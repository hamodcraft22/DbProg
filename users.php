<?php
include './header.php';

// if the user is an admin display all the users 
if (isset($_SESSION['roleType']) && $_SESSION['roleType'] == 'admin')
{
    $user = new User();
    $data = $user->getAllUsers(null);    
    // add a form to filter by type
}


?>

<!--function to change body size-->
<script type="text/javascript">
    function chnageSize()
    {
        var height = ((window.innerHeight) - (document.getElementById('mainNavBar').offsetHeight));
        document.getElementById('usersPageBody').setAttribute("style", "height:" + height);
    }


    window.addEventListener('resize', chnageSize);
</script>

<!--if the user is an admin display all users page -->
<section <?php if(!(isset($_SESSION['roleType']) && $_SESSION['roleType'] == 'admin')){echo 'hidden';} else {echo 'id="usersPageBody"';} ?>>
    <div class="container h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-xl-10">

                <h1 class="text-black mb-4">All Users</h1>

                <div class="card shadow" style="border-radius: 15px;">

                    <table class="table table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th class="text-center" scope="col">ID</th>
                                <th scope="col">Full Name</th>
                                <th class="text-center" scope="col">Username</th>
                                <th class="text-center" scope="col">Email</th>
                                <th class="text-center" scope="col">Role</th>
                                <th class="text-center" scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            <?php
                            
                                // loop to show all users in a table 
                                for ($i = 0; $i < count($data); $i++)
                                {
                                    $newUser = new User();
                                    $newUser->setUserID($data[$i]->userID);
                                    $newUser->initWithID();
                                    
                                    echo 
                                    '
                                        <tr>
                                            <th class="text-center" scope="row">'.$newUser->getUserID().'</th>
                                            <td>'.$newUser->getFullname().'</td>
                                            <td class="text-center">'.$newUser->getUsername().'</td>
                                            <td class="text-center"><a href="mailto:'.$newUser->getEmail().'">Send</a></td>
                                            <td class="text-center">'.$newUser->getRole().'</td>
                                            <td class="text-center">';
                                    
                                    // if the user is not a reader allow him to view each users articales 
                                    if ($newUser->getRole() != 'reader')
                                    {
                                        echo '
                                                <a type="button" class="btn btn-primary" href="articles.php?userID='.$newUser->getUserID().'"><i class="fa-solid fa-clipboard"></i></a>';
                                    }
                                    
                                    echo '
                                                <a type="button" class="btn btn-success" href="profile.php?id='.$newUser->getUserID().'"><i class="fas fa-edit"></i></a>
                                                <a type="button" class="btn btn-danger"><i class="far fa-trash-alt"></i></a>
                                            </td>
                                        </tr>
                                    ';
                                }
                            ?>
                            
                            

                        </tbody>
                    </table>

                </div>

            </div>
        </div>
    </div>
</section>

<!--if the user is not an admin echo page cannot be accessed by him -->
<section <?php if((isset($_SESSION['roleType']) && $_SESSION['roleType'] == 'admin')){echo 'hidden';} else {echo 'id="usersPageBody"';}  ?>>
    <div class="container h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-xl-10">

                <h1 class="text-black mb-4">All Users</h1>

                <div class="card shadow" style="border-radius: 15px;">
                    
                    <p class="text-center">You cannot use this page unless you are an Admin</p>
                    
                </div>

            </div>
        </div>
    </div>
</section>


<script type="text/javascript">chnageSize();</script>