<?php
include './header.php';

$canView = true;
$viewError = '';

$data = null;

if (isset($_SESSION['userID']) && $_SESSION['roleType'] != 'reader')
{
    if (isset($_GET['userID']))
    {
        if ($_GET['userID'] == $_SESSION['userID'] || $_SESSION['roleType'] == 'admin')
        {
            $canView = true;

            $article = new Article();
            $article->setUserID($_GET['userID']);
            $data = $article->getAllArtis();
        }
        else
        {
            $viewError .= 'you cannot edit other users articles. <br/>';
            $canView = false;
        }
    }
    else
    {
        if ($_SESSION['roleType'] == 'admin')
        {
            $article = new Article();
            $article->setUserID(null);
            $data = $article->getAllArtis();

            $canView = true;
        }
        else
        {
            $viewError .= 'you cannot edit other users articles. <br/>';
            $canView = false;
        }
    }
}
else
{
    $viewError .= 'You have to be logged in as an author to use this page.<br/>';
    $canView = false;
}
?>

<script type="text/javascript">
    function chnageSize()
    {
        var height = ((window.innerHeight) - (document.getElementById('mainNavBar').offsetHeight));
        document.getElementById('articlesPageBody').setAttribute("style", "height:" + height);
    }


    window.addEventListener('resize', chnageSize);
</script>


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
            <div class="col-xl-9">

                <h1 class="text-black mb-4">All Articles (sorted by views)</h1>



                <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                    <a type="button" class="btn btn-primary btn-sm" href="addEditArticle.php">Compose a New Article</a>
                    
                    <?php
                        if (isset($_SESSION['roleType']) && $_SESSION['roleType'] == 'admin' )
                        {
                            if (!(isset($_GET['userID'])))
                            {
                                $adminID = $_SESSION['userID'];
                                echo '<a type="button" class="btn btn-success btn-sm" href="articles.php?userID='.$adminID.'">My Articles</a>';
                            }
                            else
                            {
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
                            for ($i = 0; $i < count($data); $i++)
                            {
                                $newArtcl = new Article();
                                $newArtcl->setArticleID($data[$i]->articleID);
                                $newArtcl->initAwithID();

                                echo
                                '
                                        <tr>
                                            <th class="text-center" scope="row">' . $newArtcl->getArticleID() . '</th>
                                            <td class="text-center"><img style="height:50px" src="' . $newArtcl->getThumbnail() . '"></img></td>
                                            <td class="text-center">' . $newArtcl->getTitle() . '</td>
                                            <td class="text-center">' . $newArtcl->getCategory() . '</td>
                                            <td class="text-center">
                                                <a type="button" class="btn btn-primary"><i class="far fa-eye"></i></a>';

                                if ($newArtcl->getStatus() == 'saved')
                                {
                                    echo '
                                                <a type="button" class="btn btn-success" href="addEditArticle.php?artiID=' . $newArtcl->getArticleID() . '"><i class="fas fa-edit"></i></a>';
                                }

                                echo '
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

<section <?php
if (!$canView)
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