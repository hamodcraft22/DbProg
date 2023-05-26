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
                    
                    $media = new Media();
                    $media->setArticleID($articleID);
                    $data = $media->getAllMedia();
                    
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
        document.getElementById('articlesMediaPageBody').setAttribute("style", "height:" + height);
    }


    window.addEventListener('resize', chnageSize);
</script>


<section <?php
if (!$canView)
{
    echo 'id="articlesMediaPageBody"';
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


<section <?php
if ($canView)
{
    echo 'id="articlesMediaPageBody"';
}
else
{
    echo 'hidden';
}
?>>
    <div class="container h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-xl-9">

                <h1 class="text-black mb-4">Article "<?php if ($canView)
    {
        echo $retrivedArtcl->getHeader();
    } ?>" Media</h1>



                <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                    <a type="button" class="btn btn-primary btn-sm" href="addEditMedia.php?artiID=<?php if ($canView)
    {
        echo $articleID;
    } ?>">Add new Media</a>
                    <a type="button" class="btn btn-secondary btn-sm" href="addEditArticle.php?artiID=<?php if ($canView)
    {
        echo $articleID;
    } ?>">Back to Article</a>
                </div>

                <div class="card shadow" style="border-radius: 15px;">
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th class="text-center" scope="col">ID</th>
                                    <th scope="col">Media Name</th>
                                    <th class="text-center" scope="col">Preview</th>
                                    <th class="text-center" scope="col">Type</th>
                                    <th class="text-center" scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                for ($i = 0; $i < count($data); $i++)
                                {
                                    $newMedia = new Media();
                                    $newMedia->setMediaID($data[$i]->mediaID);
                                    $newMedia->initMwithID();

                                    echo
                                    '
                                        <tr>
                                            <th class="text-center" scope="row">' . $newMedia->getMediaID() . '</th>
                                            <td>' . $newMedia->getMediaName() . '</td>';
                                            
                                            if ($newMedia->getMediaType() != 'ogm' && $newMedia->getMediaType() != 'wmv' && $newMedia->getMediaType() != 'mpg' && $newMedia->getMediaType() != 'webm' && $newMedia->getMediaType() != 'ogv' && $newMedia->getMediaType() != 'mov' && $newMedia->getMediaType() != 'asx' && $newMedia->getMediaType() != 'mpeg' && $newMedia->getMediaType() != 'mp4' && $newMedia->getMediaType() != 'm4v' && $newMedia->getMediaType() != 'avi')
                                            {
                                                echo '<td class="text-center"><a href="'.$newMedia->getMediaPath().'"><img style="height:50px" src="' . $newMedia->getMediaPath() . '"></a></td>';
                                            }
                                            else
                                            {
                                                echo '<td class="text-center"><a href="'.$newMedia->getMediaPath().'"><video autoplay muted loop style="height:50px"><source src="' . $newMedia->getMediaPath() . '"></video></a></td>';
                                            }
                                    
                                    echo
                                            '<td class="text-center">' . $newMedia->getMediaType() . '</td>
                                            <td class="text-center">';

                                    echo '
                                                <a type="button" class="btn btn-success" href="addEditMedia.php?artiID='.$articleID.'&mediaID='.$newMedia->getMediaID().'"><i class="fas fa-edit"></i></a>
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




<script type="text/javascript">chnageSize();</script>