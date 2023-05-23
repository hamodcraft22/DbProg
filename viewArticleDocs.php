<?php
include './header.php';

$canView = true;
$viewError = '';

//get request to get article id;
if (isset($_SESSION['userID']) && $_SESSION['roleType'] != 'reader')
{
    if (isset($_GET['artiID']))
    {
        $retrivedArtcl = new Article();
        $retrivedArtcl->setArticleID($_GET['artiID']);
        $retrivedArtcl->initAwithID();
        $articleID = $retrivedArtcl->getArticleID();

        if ($retrivedArtcl->getArticleID() != null)
        {
            if ($_SESSION['userID'] == $retrivedArtcl->getUserID() || $_SESSION['roleType'] == 'admin')
            {
                if ($retrivedArtcl->getStatus() != 'saved')
                {
                    
                    $viewError .= 'the article has been publised, you cannot edit it. <br/>';
                    $canView = false;
                }
                else
                {
                    // here is where the stuff should happen
                    $canView = true;
                }
            }
            else
            {
                $viewError .= 'you cannot edit others articles .<br/>';
                $canView = false;
            }
        }
        else
        {
            $viewError .= 'the article ID was not found. <br/>';
            $canView = false;
        }
    }
    else
    {
        $viewError .= 'No article id was selected.<br/>';
        $canView = false;
    }
}
else
{
    $viewError .= 'You have to be logged in as an author.<br/>';
    $canView = false;
}
?>

<script type="text/javascript">
    function chnageSize()
    {
        var height = ((window.innerHeight) - (document.getElementById('mainNavBar').offsetHeight));
        document.getElementById('articlesDocsPageBody').setAttribute("style", "height:" + height);
    }


    window.addEventListener('resize', chnageSize);
</script>


<section <?php
if ($canView)
{
    echo 'id="articlesDocsPageBody"';
}
else
{
    echo 'hidden';
}
?>>
    <div class="container h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-xl-9">

                <h1 class="text-black mb-4">Article "<?php if($canView){echo $retrivedArtcl->getHeader();} ?>" Documents</h1>



                <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                    <a type="button" class="btn btn-primary btn-sm" href="addEditDoc.php?artiID=<?php if($canView){echo $articleID;} ?>">Add new Documents</a>
                    <a type="button" class="btn btn-secondary btn-sm" href="addEditArticle.php?artiID=<?php if($canView){echo $articleID;} ?>">Back to Article</a>
                </div>

                <div class="card shadow" style="border-radius: 15px;">
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th class="text-center" scope="col">ID</th>
                                    <th scope="col">Document Name</th>
                                    <th class="text-center" scope="col">Type</th>
                                    <th class="text-center" scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                for ($i = 0; $i < count($data); $i++)
                                {
                                    $newUser = new User();
                                    $newUser->setUserID($data[$i]->userID);
                                    $newUser->initWithID();

                                    echo
                                    '
                                        <tr>
                                            <th class="text-center" scope="row">' . $newUser->getUserID() . '</th>
                                            <td>' . $newUser->getFullname() . '</td>
                                            <td class="text-center">' . $newUser->getUsername() . '</td>
                                            <td class="text-center">';

                                    if ($newUser->getRole() != 'reader')
                                    {
                                        echo '
                                                <a type="button" class="btn btn-primary" href="articles.php?userID=' . $newUser->getUserID() . '"><i class="fa-solid fa-clipboard"></i></a>';
                                    }

                                    echo '
                                                <a type="button" class="btn btn-success" href="profile.php?id=' . $newUser->getUserID() . '"><i class="fas fa-edit"></i></a>
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
    </div>
</section>

<section <?php
if (!$canView)
{
    echo 'id="articlesDocsPageBody"';
}
else
{
    echo 'hidden';
}
?>>
    <div class="container h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-xl-10">

                <h1 class="text-black mb-4">Error</h1>



                <div class="card shadow" style="border-radius: 15px;">

                    <p class="text-center"><?php echo $viewError; ?></p>
                    <!-- add login check here and login button -->
                </div>

            </div>
        </div>
    </div>
</section>

<script type="text/javascript">chnageSize();</script>