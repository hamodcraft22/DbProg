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
                if ($retrivedArtcl->getStatus() != 'saved')
                {
                    $viewError .= 'the article has been publised, you cannot edit it. <br/>';
                    $canView = false;
                }
                else
                {
                    $canView = true;
                    $isEdit = true;
                    $imageChnage = false;

                    //save method is diifrent here 
                    if (isset($_POST['save']))
                    {
                        // add check to see if foto is here
                        echo 'its a save from an edit';

                        $article = new Article();
                        $article->setArticleID($articleID);
                        $article->initAwithID();

                        $errors = '';

                        $header = $_POST['headerInput'];
                        $title = $_POST['titleInput'];
                        $body = $_POST['bodyInput'];
                        $catID = $_POST['categoryInput'];

                        // add image errors and validation (upload errors missing from mid dont forget)

                        if (isset($_FILES['thumbnailInput']['name']) && $_FILES['thumbnailInput']['name'] != null)
                        {
                            echo 'image chnaged';
                            $imageChnage = true;
                            $name = "assests/thumbnails//" . $_FILES['thumbnailInput']['name'];
                            move_uploaded_file($_FILES['thumbnailInput']['tmp_name'], $name);
                            $thumbnail = $name;
                        }



                        if ($errors == '')
                        {


                            $article->setHeader($header);
                            $article->setTitle($title);
                            $article->setBody($body);
                            $article->setCategoryID($catID);
                            if ($imageChnage)
                            {
                                $article->setThumbnail($thumbnail);
                            }
                            $article->setUserID($_SESSION['userID']);
                            $article->setStatusID(1);
                            $article->updateArti();

                            echo "<script>window.location.href='addEditArticle.php?artiID=$articleID';</script>";
                            exit;
                        }
                        else
                        {
                            echo 'Fee error';
                        }
                    }
                    else if (isset($_POST['publish']))
                    {
                        $errors = '';

                        $article = new Article();
                        $article->setArticleID($articleID);
                        $article->initAwithID();

                        $media = new Media();
                        $media->setArticleID($articleID);
                        $medias = $media->getAllMedia();

                        $documnt = new artiDocument();
                        $documnt->setArticleID($articleID);
                        $docs = $documnt->getAllDocument();

                        $countOfImages = 0;
                        $countOfVidAud = 0;

                        for ($m = 0; $m<count($medias); $m++)
                        {
                            
                            $mediaCheck = new Media();
                            $mediaCheck->setMediaID($medias[$m]->mediaID);
                            $mediaCheck->initMwithID();
                            
                            if ($newMedia->getMediaType() != 'ogm' && $newMedia->getMediaType() != 'wmv' && $newMedia->getMediaType() != 'mpg' && $newMedia->getMediaType() != 'webm' && $newMedia->getMediaType() != 'ogv' && $newMedia->getMediaType() != 'mov' && $newMedia->getMediaType() != 'asx' && $newMedia->getMediaType() != 'mpeg' && $newMedia->getMediaType() != 'mp4' && $newMedia->getMediaType() != 'm4v' && $newMedia->getMediaType() != 'avi')
                            {
                                $countOfImages = $countOfImages +1;
                            }
                        }
                        
                        if (count($medias) < 2)
                        {
                            $errors .= 'you need at least one image for the article .<br/>';
                        }

                        if (count($docs) < 1)
                        {
                            $errors .= 'you need at least one document for the article .<br/>';
                        }


                        if ($errors == '')
                        {

                            $article->setStatusID(2);
                            $article->updateArti();
                            $article->setPubDate();
                            echo 'its a publish from edit all done';

                            $userID = $_SESSION['userID'];
                            echo "<script>window.location.href='articles.php?userID=$userID';</script>";
                            exit;
                        }
                        else
                        {
                            echo $errors;
                        }
                    }
                    else if (isset($_POST['media']))
                    {
                        echo "<script>window.location.href='viewArticleMedia.php?artiID=$articleID';</script>";
                        exit;
                    }
                    else if (isset($_POST['document']))
                    {
                        echo "<script>window.location.href='viewArticleDocs.php?artiID=$articleID';</script>";
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
    else if (isset($_POST['save']))
    {
        $errors = '';

        $header = $_POST['headerInput'];
        $title = $_POST['titleInput'];
        $body = $_POST['bodyInput'];
        $catID = $_POST['categoryInput'];

        // add image errors and validation (upload errors missing from mid dont forget)

        $name = "assests/thumbnails//" . $_FILES['thumbnailInput']['name']; //unix path uses forward slash
        move_uploaded_file($_FILES['thumbnailInput']['tmp_name'], $name);

        $thumbnail = $name;

        if ($errors == '')
        {
            $article = new Article();

            $article->setHeader($header);
            $article->setTitle($title);
            $article->setBody($body);
            $article->setCategoryID($catID);
            $article->setThumbnail($thumbnail);
            $article->setUserID($_SESSION['userID']);
            $article->setStatusID(1);

            $resultID = $article->saveArti();

            if ($resultID != false)
            {
                echo $resultID;
                echo 'ok done';

                echo "<script>window.location.href='addEditArticle.php?artiID=$resultID';</script>";
                exit;
            }
            else
            {
                echo 'add error';
            }
        }
        else
        {
            echo 'Fee error';
        }
    }
    else if (isset($_POST['publish']))
    {
        // this just chnages the status to published and puts the date
        echo 'you need to save before you can go';
    }
    else if (isset($_POST['media']))
    {
        // error to user telling him it needs to be saved first
        echo 'you need to save before you can go';
    }
    else if (isset($_POST['document']))
    {
        // error to user telling him it needs to be saved first
        echo 'you need to save before you can go';
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
        document.getElementById('articleFormBody').setAttribute("style", "height:" + height);
    }


    window.addEventListener('resize', chnageSize);

    $(document).ready(function () {
        $('#articleForm input').blur(function () {
            if (!$(this).val()) {
                $(this).attr("placeholder", "required");
                $(this).css("border-color", "red");
            } else {
                $(this).attr("placeholder", "text");
                $(this).css("border-color", "green");
            }
        });
        $('#bodyInput').blur(function () {
            if (!$(this).val()) {
                $(this).attr("placeholder", "required");
                $(this).css("border-color", "red");
            } else {
                $(this).attr("placeholder", "text");
                $(this).css("border-color", "green");
            }
        });
        $('#categoryInput').blur(function () {
            if (!$(this).val()) {
                $(this).attr("placeholder", "required");
                $(this).css("border-color", "red");
            } else {
                $(this).attr("placeholder", "text");
                $(this).css("border-color", "green");
            }
        });
    });
</script>

<section <?php
if (!$canView)
{
    echo 'id="articleFormBody"';
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
    echo 'id="articleFormBody"';
}
else
{
    echo 'hidden';
}
?>>
    <div class="container h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-lg-12 col-xl-11">

                <form id="articleForm"method="post" enctype="multipart/form-data">
                    <div class="row py-4">


                        <div class="col-md-4 mb-4">
                            <div class="card mb-4 shadow">
                                <div class="card-header py-3">
                                    <h5 class="mb-0">Article details</h5>
                                </div>


                                <div class="card-body">

                                    <!-- Text input -->
                                    <div class="form-outline mb-4">
                                        <label class="form-label" for="headerInput">Header</label>
                                        <input type="text" id="headerInput" name="headerInput" class="form-control" placeholder="Main Header" required" <?php
if ($canView && $isEdit)
{
    echo 'value = "' . $retrivedArtcl->getHeader() . '"';
}
else if (isset($_POST['headerInput']))
{
    echo 'value = "' . $_POST['headerInput'] . '"';
}
?>/>
                                    </div>


                                    <div class="form-outline mb-4">
                                        <label class="form-label" for="form7Example3">Category</label>
                                        <select name="categoryInput" id="categoryInput" class="form-control" required>
                                            <option disabled selected=""></option>
<?php
if ($canView)
{
    $arcObj = new Article();
    $categories = $arcObj->getAllCategories();

    for ($i = 0; $i < count($categories); $i++)
    {
        if ($isEdit && ($retrivedArtcl->getCategoryID() == $categories[$i]->categoryID))
        {
            echo '<option selected value="' . $categories[$i]->categoryID . '">' . $categories[$i]->catgoryName . '</option>';
        }
        else
        {
            echo '<option value="' . $categories[$i]->categoryID . '">' . $categories[$i]->catgoryName . '</option>';
        }
    }
}
?>

                                        </select>
                                    </div>

                                            <?php
                                            if (isset($_GET['artiID']))
                                            {
                                                echo '<div class="form-outline mb-4"><img style="max-height:100px"  src=\'' . $retrivedArtcl->getThumbnail() . '\'></div>';
                                            }
                                            ?>

                                    <div class="form-outline mb-4">
                                        <label class="form-label" for="thumbnailInput">Thumbnail</label>
                                        <input class="form-control" type="file" accept="image/*"  id="thumbnailInput" name="thumbnailInput" <?php
                                    if (!(isset($_GET['artiID'])))
                                    {
                                        echo 'required';
                                    }
                                    ?>/>
                                    </div>

                                    <button type="submit" name="save" id="save" class="btn btn-primary btn-lg btn-block">
                                        Save
                                    </button>

                                    <button type="submit" name="publish" id="publish" class="btn btn-success btn-lg btn-block">
                                        Publish
                                    </button>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-8 mb-4">

                            <div class="card mb-4">
                                <div class="card-header py-3">
                                    <h5 class="mb-0">Article Body</h5>
                                </div>
                                <div class="card-body shadow">

                                    <!-- Text input -->
                                    <div class="form-outline mb-4">
                                        <label class="form-label" for="titleInput">Title</label>
                                        <input type="text" id="titleInput" name="titleInput" class="form-control" placeholder="Sub Header" required <?php
                                    if ($isEdit && $canView)
                                    {
                                        echo 'value = "' . $retrivedArtcl->getTitle() . '"';
                                    }
                                    ?>/> 
                                    </div>

                                    <!-- Message input -->
                                    <div class="form-outline mb-4">
                                        <label class="form-label" for="bodyInput">Body</label>
                                        <textarea class="form-control" id="bodyInput" name="bodyInput" <?php
                                    if (isset($_GET['artiID']))
                                    {
                                        echo 'rows="10"';
                                    }
                                    else
                                    {
                                        echo 'rows="5"';
                                    }
                                    ?> required><?php
                                        if ($isEdit && $canView)
                                        {
                                            echo $retrivedArtcl->getBody();
                                        }
                                        ?></textarea>
                                    </div>

                                    <button type="submit" name="media" id="media" class="btn btn-info btn-block" formnovalidate>
                                        View / Edit Article Media
                                    </button>
                                    <button type="submit" name="document" id="document" class="btn btn-info btn-block" formnovalidate>
                                        View / Edit Article Documents
                                    </button>



                                </div>
                            </div>
                        </div>


                    </div>
                </form>


            </div>
        </div>
    </div>
</section>


<script type="text/javascript">chnageSize();</script>