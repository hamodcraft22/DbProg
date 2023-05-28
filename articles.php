<?php
include './header.php';

$canView = true;
$viewError = '';

$data = null;

// if user or reader 
if (isset($_SESSION['userID']) && $_SESSION['roleType'] != 'reader')
{
    // get user id
    if (isset($_GET['userID']))
    {
        // if user is admin 
        if ($_GET['userID'] == $_SESSION['userID'] || $_SESSION['roleType'] == 'admin')
        {
            $canView = true;

            $article = new Article();
            $article->setUserID($_GET['userID']);
            $data = $article->getAllArtis();

             // if filter option selected 
            if (isset($_POST['filterArticle']))
            {
                // sort articales to dates 
                $dateSatrtInput = $_POST['beginDateInput'];
                $dateEndInput = $_POST['endDateInput'];

                $data = $article->getAllbyDate($dateSatrtInput, $dateEndInput);
            }
        }
        else
        {
            //echo error msg
            $viewError .= 'you cannot edit other users articles. <br/>';
            $canView = false;
        }
    }
    else
    {
        // if user is admin 
        if ($_SESSION['roleType'] == 'admin')
        {
            
            //get all articales 
            $article = new Article();
            $article->setUserID(null);
            $data = $article->getAllArtis();

            // if filter is selected 
            if (isset($_POST['filterArticle']))
            {
                $dateSatrtInput = $_POST['beginDateInput'];
                $dateEndInput = $_POST['endDateInput'];

                $data = $article->getAllbyDate($dateSatrtInput, $dateEndInput);
            }

            $canView = true;
        }
        else
        {
            //echo error msg
            $viewError .= 'you cannot edit other users articles. <br/>';
            $canView = false;
        }
    }
}
else
{
    //echo error msg
    $viewError .= 'You have to be logged in as an author to use this page.<br/>';
    $canView = false;
}
// if home articale is selected 
if (isset($_POST['homeArticle']))
{
    // remove from category and set to home 
    $deleteArticle = new Article();
    $deleteArticle->setArticleID($_POST['homeArticle']);
    $deleteArticle->initAwithID();
    $deleteArticle->setHome();
}

// if delete button is clicked 
if (isset($_POST['deleteArticle']))
{
    // deleteee
    $deleteArticle = new Article();
    $deleteArticle->setArticleID($_POST['deleteArticle']);
    $deleteArticle->initAwithID();
    // if admin 
    if ($_SESSION['roleType'] == 'admin')
    {
        // set admin deleted 
        $deleteArticle->setAdminDeleted();
    }
    else
    {
        //user deleted 
        $deleteArticle->setDeleted();
    }
}
?>

<!--script for buttons -->
<script type="text/javascript">
    function chnageSize()
    {
        var height = ((window.innerHeight) - (document.getElementById('mainNavBar').offsetHeight));
        document.getElementById('articlesPageBody').setAttribute("style", "height:" + height);
    }

    var isDelete = false;
    var isHome = false;
// delete 
    function setDelete()
    {
        isDelete = true;
    }
// set home button 
    function setHome()
    {
        isHome = true;
    }
// check delete 
    function checkForm()
    {
        if (isDelete)
        {
            return confirm('Are you sure you want to delete the article?');
        } else if (isHome)
        {
            return confirm('Are you sure you want to want to set the article for the home page?');
        } else
        {
            return false;
        }
    }
//print button
    const handlePrint = () => {
        var actContents = document.body.innerHTML;
        document.body.innerHTML = actContents;
        window.print();
    };

    window.addEventListener('resize', chnageSize);
</script>


<section <?php
if (!$canView)
{
    echo 'id="articlesPageBody"';
}
else
{
    echo 'hidden';
}
// error banner formatting 
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

<!--if the user is an admin or author can view all his articales -->
<section <?php
if ($canView)
{
    echo 'id="articlesPageBody"';
}
else
{
    echo 'hidden';
}
?>>
    <div class="container h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-xl-10">

                <h1 class="text-black mb-4">All Articles (sorted by reviews)</h1>


                <div class="form-row">
                    <form method="post" action="articles.php">
                        <div class="row">
                            <div class="col">
                                <label for="beginDateInput">Begin Date</label><br>
                                <input type="date" class="form-control" id="beginDateInput" name="beginDateInput" placeholder="Text" required>
                            </div>
                            <div class="col">
                                <label for="endDateInput">End Date</label><br>
                                <input type="date" class="form-control" id="endDateInput" name="endDateInput" placeholder="Text" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="form-control" name="filterArticle" id="filterArticle" class="btn btn-primary">Filter</button>
                        </div>
                    </form>
                </div>

                <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                    <a type="button" class="btn btn-primary btn-sm" href="addEditArticle.php">Compose a New Article</a>

                    <?php
                    // if admin 
                    if (isset($_SESSION['roleType']) && $_SESSION['roleType'] == 'admin')
                    {
                        if (!(isset($_GET['userID'])))
                        {
                            $adminID = $_SESSION['userID'];
                            echo '<a type="button" class="btn btn-success btn-sm" href="articles.php?userID=' . $adminID . '">My Articles</a>';
                        }
                        else
                        {
                            // get all articles 
                            echo '<a type="button" class="btn btn-success btn-sm" href="articles.php">All Articles</a>';
                        }
                    }
                    ?>
                </div>

                <div class="card shadow" style="border-radius: 15px;">
                    <table class="table table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th class="text-center" scope="col">ID</th>
                                <th class="text-center" scope="col">Thumbnail</th>
                                <th class="text-center" scope="col">Title</th>
                                <th class="text-center" scope="col">Category</th>
                                <th class="text-center" scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            // loop thro all and get status 
                            for ($i = 0; $i < count($data); $i++)
                            {
                                $newArtcl = new Article();
                                $newArtcl->setArticleID($data[$i]->articleID);
                                $newArtcl->initAwithID();

                                if ($newArtcl->getStatus() == 'deleted' || $newArtcl->getStatus() == 'adminDelete')
                                {
                                    echo '<tr class="table-danger">';
                                }
                                if ($newArtcl->getStatus() == 'homed')
                                {
                                    echo '<tr class="table-warning">';
                                }
                                else
                                {
                                    echo '<tr>';
                                }

                                echo
                                '
                                        
                                            <th class="text-center" scope="row">' . $newArtcl->getArticleID() . '</th>
                                            <td class="text-center"><img style="height:50px" src="' . $newArtcl->getThumbnail() . '"></img></td>
                                            <td class="text-center">' . $newArtcl->getTitle() . '</td>
                                            <td class="text-center">' . $newArtcl->getCategory() . '</td>
                                            <form method="post" onsubmit="return checkForm();">
                                            <td class="text-center">
                                                <a type="button" href="viewArticle.php?artiID=' . $newArtcl->getArticleID() . '" class="btn btn-primary"><i class="far fa-eye"></i></a>';

                                if ($newArtcl->getStatus() == 'saved')
                                {
                                    echo '
                                                <a type="button" class="btn btn-success" href="addEditArticle.php?artiID=' . $newArtcl->getArticleID() . '"><i class="far fa-edit"></i></a>';
                                }

                                if ($newArtcl->getStatus() == 'published')
                                {
                                    echo '
                                                <button type="submit" class="btn btn-warning" name="homeArticle" onclick="setHome();" value="' . $newArtcl->getArticleID() . '"><i class="fa-solid fa-house"></i></button>';
                                }

                                if (($newArtcl->getStatus() != 'homed' && $newArtcl->getStatus() != 'deleted' && $newArtcl->getStatus() != 'adminDelete' && ($_SESSION['roleType'] == 'admin' || $_SESSION['userID'] == $newArtcl->getUserID())))
                                {
                                    echo '      <button type="submit" class="btn btn-danger" name="deleteArticle" onclick="setDelete();" value="' . $newArtcl->getArticleID() . '"><i class="fa-solid fa-trash-alt"></i></button>';
                                }

                                echo '
                                                
                                            </td>
                                            </form>
                                        </tr>
                                    ';
                            }
                            ?>



                        </tbody>
                    </table>

                </div>
                </br>
                <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                    <input value='Print' type='button' class="btn btn-success" onclick='handlePrint()' />
                </div>

            </div>
        </div>
    </div>
</section>




<script type="text/javascript">chnageSize();</script>