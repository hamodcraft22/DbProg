<?php
include './header.php';

$canView = true;
$viewError = '';

$isEdit = false;

// if user or readeer
if (isset($_SESSION['userID']) && $_SESSION['roleType'] != 'reader')
{
    // if articale is selected 
    if (isset($_GET['artiID']))
    {
        //get articale 
        // check that the article is not publised b3d
        $retrivedArtcl = new Article();
        $retrivedArtcl->setArticleID($_GET['artiID']);
        $retrivedArtcl->initAwithID();
        $articleID = $retrivedArtcl->getArticleID();

        // if articale exsits 
        if ($retrivedArtcl->getArticleID() != null)
        {
            // if user is admin or author 
            if ($_SESSION['userID'] == $retrivedArtcl->getUserID() || ($_SESSION['roleType'] == 'admin'))
            {
                // if articale is saved not published 
                if ($retrivedArtcl->getStatus() != 'saved')
                {
                    //echo error msg
                    $viewError .= 'the article has been publised, you cannot edit it. <br/>';
                    $canView = false;
                }
                else
                {
                    // articale not published 
                    // get selected media 
                    if (isset($_GET['mediaID']))
                    {
                        //add media 
                        $retrivedMedia = new Media();
                        $retrivedMedia->setMediaID($_GET['mediaID']);
                        $retrivedMedia->initMwithID();
                        $mediID = $retrivedMedia->getMediaID();
                        
                       // if it exsits
                        if ($mediID != null)
                        {
                            //if it belongs to the articale selected 
                            if ($retrivedMedia->getArticleID() == $articleID)
                            {
                                $canView = true;
                                $isEdit = true;

                                //  only allows changing name
                                //save method is diifrent here 
                                if (isset($_POST['mediaSave']))
                                {
                                    $name = $_POST['nameInput'];
                                    $retrivedMedia->setMediaName($name);
                                    $retrivedMedia->updateMedia();

                                    echo '<div class="alert alert-success alert-dismissible fade show botAlert" role="alert">
                Media name updated.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
                                }
                            }
                            else
                            {
                                //echo error msg
                                $viewError .= 'Media is not a part of the Same Article .<br/>';
                                $canView = false;
                            }
                        }
                        else
                        {
                            //echo error msg
                            $viewError .= 'Media was not found .<br/>';
                            $canView = false;
                        }
                    }
                    // if selected media 
                    else if (isset($_POST['mediaSave']))
                    {
                        // here is where the actual save of the media and the image happens
                        $errors = '';

                        $name = $_POST['nameInput'];

                        // file > 2mb 
                        if ($_FILES['fileInput']['size'] > 2087152)
                        {
                            //echo error msg
                            $errors .= 'file larger then allowed size, 2MB max.<br/>';
                        }
                        else
                        {
                            // else add media 
                            $path = "media//" . $_FILES['fileInput']['name']; //unix path uses forward slash
                            move_uploaded_file($_FILES['fileInput']['tmp_name'], $path);
                            $type = end((explode(".", $path)));
                        }
                        
                        // if there is errors
                        
                        if ($_FILES['fileInput']['error'] != 0)
                        {
                            $fileError .= $_FILES['fileInput']['error'];
                            
                            if ($fileError == 1)
                            {
                                //echo error msg
                                $errors .= 'The uploaded file exceeds the upload limit, 2 mb max';
                            }
                            
                            if ($fileError == 2)
                            {
                                //echo error msg
                                $errors .= 'The uploaded file exceeds the upload limit, 2 mb max';
                            }
                            
                            if ($fileError == 3)
                            {
                                //echo error msg
                                $errors .= 'The uploaded file was only partially uploaded';
                            }
                            
                            if ($fileError == 4)
                            {
                                //echo error msg
                                $errors .= 'No file was uploaded';
                            }
                            
                            if ($fileError == 6)
                            {
                                //echo error msg
                                $errors .= 'Missing a temporary folder';
                            }
                            
                            if ($fileError == 7)
                            {
                                //echo error msg
                                $errors .= 'Failed to write file to disk.';
                            }
                            
                            if ($fileError == 8)
                            {
                                //echo error msg
                                $errors .= 'A PHP extension stopped the file upload.';
                            }
                        }

                        // if there is error this is the bootstrap formatting 
                        if ($errors != '')
                        {
                            echo '<div class="alert alert-danger alert-dismissible fade show botAlert" role="alert">
                '.$errors.'
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
                        }
                        else
                        {
                            // no errors, add media 
                            $newMedia = new Media();

                            $newMedia->setMediaName($name);
                            $newMedia->setMediaPath($path);
                            $newMedia->setMediaType($type);
                            $newMedia->setArticleID($articleID);

                            $mediaID = $newMedia->saveMedia();

                            // media id not belong 
                            if ($mediaID != false)
                            {
                                // go to edit mode - removes image link allowes only name chnage

                                $isEdit = true;

                                echo "<script>window.location.href='addEditMedia.php?artiID=$articleID" . "&mediaID=$mediaID';</script>";
                                exit;
                            }
                            else
                            {
                                $isEdit = false;
                                //echo error msg
                                echo '<div class="alert alert-danger alert-dismissible fade show botAlert" role="alert">
                '.$errors.'
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
                            }
                        }
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
    else
    {
        //echo error msg
        $viewError .= 'No Article ID was provided .<br/>';
        $canView = false;
    }
}
else
{
    //echo error msg
    $viewError .= 'You have to be logged in as an author to use this page.<br/>';
    $canView = false;
}
?>

<script type="text/javascript">
    //function to change body size 
    function chnageSize()
    {
        var height = ((window.innerHeight) - (document.getElementById('mainNavBar').offsetHeight));
        document.getElementById('articleDocFormBody').setAttribute("style", "height:" + height);
    }


    window.addEventListener('resize', chnageSize);

    $(document).ready(function () {
        $('#mediaForm input').blur(function () {
            if (!$(this).val()) {
                $(this).attr("placeholder", "required");
                $(this).css("border-color", "red");
            } else {
                $(this).attr("placeholder", "text");
                $(this).css("border-color", "green");
            }
        });
    });

    var uploadField = document.getElementById("file");

    fileInput.onchange = function () {
        if (this.files[0].size > 2097152) {
            alert("File is too big!");
            this.value = "";
        }
        ;
    };
</script>


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
    <!--error formatting banner--> 
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
    echo 'id="articleDocFormBody"';
}
else
{
    echo 'hidden';
}
?>>
    <!--body formatting card-->
    <div class="container h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-xl-9">
                <form id="mediaForm" method="post" enctype="multipart/form-data">
                    <div class="card mb-4 shadow">
                        <div class="card-header py-3">
                            <h5 class="mb-0">Article "<?php
                                if ($canView)
                                {
                                    echo $retrivedArtcl->getHeader();
                                }
                                ?>" Media</h5>
                        </div>
                        <div class="card-body ">

                            <!-- Text input -->
                            <div class="form-outline" mb-4">
                                <label class="form-label" for="nameInput">Name</label>
                                <input type="text" id="nameInput" name="nameInput" class="form-control" placeholder="Media Name" required <?php
                                if ($canView && $isEdit)
                                {
                                    echo 'value = "' . $retrivedMedia->getMediaName() . '"';
                                }
                                else if (isset($_POST['nameInput']))
                                {
                                    echo 'value = "' . $_POST['nameInput'] . '"';
                                }
                                ?>/> 
                            </div>

                            <!-- Text input -->
                            <div class="form-outline mb-4" <?php
                            if ($isEdit)
                            {
                                echo 'hidden';
                            }
                            ?> >
                                <label class="form-label" for="fileInput">File</label>
                                <input type="file" id="fileInput" name="fileInput" accept="audio/*,video/*,image/*" class="form-control" <?php
                                if (!$isEdit)
                                {
                                    echo 'required';
                                }
                                ?>/> 
                            </div>

                            <!--save  button format-->
                            <button type="submit" name="mediaSave" id="mediaSave" value="mediaSave" class="btn btn-success btn-block">
                                Save
                            </button>
                            <a href="viewArticleMedia.php?artiID=<?php
                            if ($canView)
                            {
                                echo $retrivedArtcl->getArticleID();
                            }
                            ?>" name="document" id="document" class="btn btn-secondary btn-block">Back to Media</a>



                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>





<script type="text/javascript">chnageSize();</script>