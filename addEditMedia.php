<?php
include './header.php';

$canView = true;
$viewError = '';

$isEdit = false;

if (isset($_SESSION['userID']) && $_SESSION['roleType'] != 'reader')
{
    if (isset($_GET['artiID']))
    {
        // check that the article is not publised b3d
        $retrivedArtcl = new Article();
        $retrivedArtcl->setArticleID($_GET['artiID']);
        $retrivedArtcl->initAwithID();
        $articleID = $retrivedArtcl->getArticleID();

        if ($retrivedArtcl->getArticleID() != null)
        {
            if ($_SESSION['userID'] == $retrivedArtcl->getUserID() || ($_SESSION['roleType'] == 'admin'))
            {
                //check the status if it is published u cant edit
                $canView = true;

                if (isset($_GET['mediaID'])) 
                {
                    $isEdit = true;
                    
                    // extra validartion comes in from here for editiing media
                    
                    //save method is diifrent here 
                    if (isset($_POST['mediaSave']))
                    {
                        echo 'its a save from an edit';
                    }
                }
                else if (isset($_POST['mediaSave']))
                {
                    // here is where the actual save of the media and the image happens
                    
                    $name = $_POST['nameInput'];
                    
                    // add image errors and validation (upload errors missing from mid dont forget
                    $path = "assests/thumbnails//" . $_FILES['thumbnailInput']['name']; //unix path uses forward slash
                    move_uploaded_file($_FILES['thumbnailInput']['tmp_name'], $path);
                    
                    $type = end((explode(".", $name)));
                    
                    
                    $newMedia = new Media();
                    
                    $newMedia->setMediaName($name);
                    $newMedia->setMediaPath($path);
                    $newMedia->setMediaType($type);
                    $newMedia->setArticleID($articleID);
                    
                    $mediaID = $newMedia->saveMedia();
                    
                    if ($mediaID != false)
                    {
                        echo "<script>window.location.href='addEditMedia.php?artiID=$articleID"."mediaID=$mediaID';</script>";
                        exit;
                    }
                    
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
        $viewError .= 'No Article ID was provided .<br/>';
        $canView = false;
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
        document.getElementById('articleDocFormBody').setAttribute("style", "height:" + height);
    }


    window.addEventListener('resize', chnageSize);
</script>


<section <?php
if ($canView)
{
    echo 'id="articleDocFormBody"';
}
else
{
    echo 'hidden';
}
?>>
    <div class="container h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-xl-9">
                <form method="post" enctype="multipart/form-data">
                    <div class="card mb-4 shadow">
                        <div class="card-header py-3">
                            <h5 class="mb-0">Article "<?php if ($canView){echo $retrivedArtcl->getHeader();} ?>" Media</h5>
                        </div>
                        <div class="card-body ">

                            <!-- Text input -->
                            <div class="form-outline mb-4">
                                <label class="form-label" for="nameInput">Name</label>
                                <input type="text" id="nameInput" name="nameInput" class="form-control" placeholder="Media Name" required <?php if ($canView && $isEdit){echo 'value = "' . $retrivedArtcl->getTitle() . '"';} ?>/> 
                            </div>

                            <!-- Text input -->
                            <div class="form-outline mb-4">
                                <label class="form-label" for="fileInput">File</label>
                                <input type="file" id="fileInput" name="fileInput" class="form-control" required/> 
                            </div>


                            <button type="submit" name="mediaSave" id="mediaSave" value="mediaSave" class="btn btn-success btn-block">
                                Save
                            </button>
                            <a href="viewArticleDocs.php?artiID=<?php if ($canView){echo $retrivedArtcl->getArticleID();} ?>" name="document" id="document" class="btn btn-secondary btn-block">Back to Documents</a>



                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>



<section <?php
    if (!$canView)
    {
        echo 'id="articleDocFormBody"';
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