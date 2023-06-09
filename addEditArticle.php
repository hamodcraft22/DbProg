<?php
include './header.php';

//array of media types 
$mediaArray = array('ogm', 'wmv', 'mpg', 'webm', 'ogv', 'mov', 'asx', 'mpeg', 'mp4', 'm4v', 'avi', 'opus', 'flac', 'weba', 'wav', 'ogg', 'm4a', 'oga', 'mid', 'mp3', 'aiff', 'wma', 'au');

$canView = true;
$viewError = '';

$isEdit = false;

// if user is an author or admin 
if (isset($_SESSION['userID']) && $_SESSION['roleType'] != 'reader')
{
    if (isset($_GET['artiID']))
    {
        // check that the article is not publised b3d
        $retrivedArtcl = new Article();
        $retrivedArtcl->setArticleID($_GET['artiID']);
        $retrivedArtcl->initAwithID();
        $articleID = $retrivedArtcl->getArticleID();
        
        //if articale exsits 
        if ($retrivedArtcl->getArticleID() != null)
        {
            // if user is an author or admin get all articles 
            if ($_SESSION['userID'] == $retrivedArtcl->getUserID() || ($_SESSION['roleType'] == 'admin'))
            {   
                // if article is published 
                if ($retrivedArtcl->getStatus() != 'saved')
                {   
                    // echo cannot edit
                    $viewError .= 'the article has been publised, you cannot edit it. <br/>';
                    $canView = false;
                }
                else
                {
                    $canView = true;
                    $isEdit = true;
                    $imageChnage = false;

                    //save method is diifrent here 
                    // if save button is clicked 
                    if (isset($_POST['save']))
                    {
                        
                        // add article with functions 
                        $article = new Article();
                        $article->setArticleID($articleID);
                        $article->initAwithID();

                        $errors = '';

                        $header = $_POST['headerInput'];
                        $title = $_POST['titleInput'];
                        $body = $_POST['bodyInput'];
                        $catID = $_POST['categoryInput'];
                        
                        // if all colums are full 
                        if (isset($_FILES['thumbnailInput']['name']) && $_FILES['thumbnailInput']['name'] != null)
                        {
                            $imageChnage = true;
                            // if file is more than 2mb 
                            if ($_FILES['thumbnailInput']['size'] > 2087152)
                            {   
                                //echo error msg 
                                $errors .= 'thumbnail larger then allowed size, 2MB max.<br/>';
                            }
                            else
                            {   
                                // else upload the file 
                                $name = "assests/thumbnails//" . $_FILES['thumbnailInput']['name']; //unix path uses forward slash
                                move_uploaded_file($_FILES['thumbnailInput']['tmp_name'], $name);
                            }
                            // if there is no img 
                            if ($_FILES['thumbnailInput']['error'] > 0)
                            {
                                //echo error msg
                                $errors .= $_FILES['thumbnailInput']['error'];
                            }
                            
                            //set thubnail to name of img 
                            $thumbnail = $name;
                        }
                        
                        //if header missing 
                        if ($header == '')
                        {   
                            //echo error msg
                            $errors .= 'Article Header Mising.<br/>';
                        }
                        // if title missing 
                        if ($title == '')
                        {
                            //echo error msg
                            $errors .= 'Article Title Mising.<br/>';
                        }
                        
                        // if no body
                        if ($body == '')
                        {
                            //echo error msg
                            $errors .= 'Article Body Mising.<br/>';
                        }
                        
                        // if no category selected 
                        if ($catID == '')
                        {
                            //echo error msg
                            $errors .= 'Category Mising.<br/>';
                        }
                        
                        //if there is no errors 
                        if ($errors == '')
                        {

                            //add articale and set attributes 
                            $article->setHeader($header);
                            $article->setTitle($title);
                            $article->setBody($body);
                            $article->setCategoryID($catID);
                            // id change in thumbnail
                            if ($imageChnage)
                            {
                                // set new img 
                                $article->setThumbnail($thumbnail);
                            }
                            // add articale under the user id 
                            $article->setUserID($_SESSION['userID']);
                            $article->setStatusID(1);
                            $article->updateArti();

                            echo "<script>window.location.href='addEditArticle.php?artiID=$articleID';</script>";
                            exit;
                        }
                        else
                        {
                            //add error here
                            echo '<div class="alert alert-danger alert-dismissible fade show botAlert" role="alert">
                '.$errors.'
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
                        }
                    }// if clciked publish 
                    else if (isset($_POST['publish']))
                    {
                        $errors = '';

                        //set articale and media and doc attributes 
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
                        
                        // go thro media loop 
                        for ($m = 0; $m < count($medias); $m++)
                        {
                            // check that there is media 
                            $mediaCheck = new Media();
                            $mediaCheck->setMediaID($medias[$m]->mediaID);
                            $mediaCheck->initMwithID();

                            // go thro media and check how many 
                            if (in_array($mediaCheck->getMediaType(), $mediaArray))
                            {
                                $countOfVidAud = $countOfVidAud + 1;
                            }
                            else
                            {
                                $countOfImages = $countOfImages + 1;
                            }
                        }
                        
                        // check count of img if less than 1 
                        if ($countOfImages < 1)
                        {
                            //echo error msg
                            $errors .= 'you need at least one image for the article .<br/>';
                        }
                        // check count of vid if less than  1
                        if ($countOfVidAud < 1)
                        {
                            //echo error msg
                            $errors .= 'you need at least one Video/Audio for the article .<br/>';
                        }

                        // if no errors 
                        if ($errors == '')
                        {
                            //set attributes 
                            $article->setStatusID(2);
                            $article->updateArti();
                            $article->setPubDate();

                            $userID = $_SESSION['userID'];
                            echo "<script>window.location.href='articles.php?userID=$userID';</script>";
                            exit;
                        }
                        else
                        {
                            //add error here
                            echo '<div class="alert alert-danger alert-dismissible fade show botAlert" role="alert">
                '.$errors.'
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
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
                //echo error msg
                $viewError .= 'you cannot edit others articles .<br/>';
                $canView = false;
            }
        }
        else
        {
            //echo error msg
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

        // if thumbnail pic more than 2mb 
        if ($_FILES['thumbnailInput']['size'] > 2087152)
        {
            //echo error msg
            $errors .= 'thumbnail larger then allowed size, 2MB max.<br/>';
        }
        else
        {
            // if less than add 
            $name = "assests/thumbnails//" . $_FILES['thumbnailInput']['name']; //unix path uses forward slash
            move_uploaded_file($_FILES['thumbnailInput']['tmp_name'], $name);
        }

        if ($_FILES['thumbnailInput']['error'] > 0)
        {
            //echo error msg
            $errors .= $_FILES['thumbnailInput']['error'];
        }

        $thumbnail = $name;
        
        // if header is missing 
        if ($header == '')
        {
            //echo error msg
            $errors .= 'Article Header Mising.<br/>';
        }

        //if title is missing
        if ($title == '')
        {
            //echo error msg
            $errors .= 'Article Title Mising.<br/>';
        }

        //if body is missing 
        if ($body == '')
        {
            //echo error msg
            $errors .= 'Article Body Mising.<br/>';
        }
        
        //if category not selected 
        if ($catID == '')
        {
            //echo error msg
            $errors .= 'Category Mising.<br/>';
        }
        
        // if no file selected 
        if ($_FILES['thumbnailInput']['tmp_name'] == '')
        {
            //echo error msg
            $errors .= 'Article Image Mising.<br/>';
        }

        // if no errors 
        if ($errors == '')
        {
            // add the articale 
            $article = new Article();

            $article->setHeader($header);
            $article->setTitle($title);
            $article->setBody($body);
            $article->setCategoryID($catID);
            $article->setThumbnail($thumbnail);
            $article->setUserID($_SESSION['userID']);
            $article->setStatusID(1);

            $resultID = $article->saveArti();
            
            // if nothing wrong add and redirect back 
            if ($resultID != false)
            {
                echo "<script>window.location.href='addEditArticle.php?artiID=$resultID';</script>";
                exit;
            }
            else
            {
                //echo error msg
                
                echo '<div class="alert alert-danger alert-dismissible fade show botAlert" role="alert">
                '.$errors.'
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
            }
        }
        else
        {
            echo '<div class="alert alert-danger alert-dismissible fade show botAlert" role="alert">
                '.$errors.'
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        }
    }
    //if exitted without saving 
    else if (isset($_POST['publish']))
    {
        echo '<div class="alert alert-danger alert-dismissible fade show botAlert" role="alert">
                you need to save before you can go.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
    }
    else if (isset($_POST['media']))
    {
        echo '<div class="alert alert-danger alert-dismissible fade show botAlert" role="alert">
                you need to save before you can go.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
    }
    else if (isset($_POST['document']))
    {
        echo '<div class="alert alert-danger alert-dismissible fade show botAlert" role="alert">
                you need to save before you can go.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
    }
}
else
{
    //trying to access without having privilige 
    $viewError .= 'You have to be logged in as an author to use this page.<br/>';
    $canView = false;
}
?>

<script type="text/javascript">
    
    //function to change body size 
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
// if user can view display form 
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

<!--//form body-->
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
                                            //category display
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
                                        else if (isset($_POST['titleInput']))
                                        {
                                            echo 'value = "' . $_POST['titleInput'] . '"';
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
                                                      else if (isset($_POST['bodyInput']))
                                                      {
                                                          echo $_POST['bodyInput'];
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