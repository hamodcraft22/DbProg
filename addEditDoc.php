<?php
include './header.php';

$canView = true;
$viewError = '';

$isEdit = false;

// if user is reader
if (isset($_SESSION['userID']) && $_SESSION['roleType'] != 'reader')
{
    if (isset($_GET['artiID']))
    {
        // check that the article is not publised b3d
        $retrivedArtcl = new Article();
        $retrivedArtcl->setArticleID($_GET['artiID']);
        $retrivedArtcl->initAwithID();
        $articleID = $retrivedArtcl->getArticleID();
        
        //if article exsits 
        if ($retrivedArtcl->getArticleID() != null)
        {
            //if user is admin or author
            if ($_SESSION['userID'] == $retrivedArtcl->getUserID() || ($_SESSION['roleType'] == 'admin'))
            {
                if ($retrivedArtcl->getStatus() != 'saved')
                {
                    //echo error msg
                    $viewError .= 'the article has been publised, you cannot edit it. <br/>';
                    $canView = false;
                }
                else
                {
                    //if select document 
                    if (isset($_GET['docID']))
                    {
                        $retrivedDoc = new artiDocument();
                        $retrivedDoc->setDocumentID($_GET['docID']);
                        $retrivedDoc->initDwithID();
                        $docID = $retrivedDoc->getDocumentID();
                        
                        //if doc exsits
                        if ($docID != null)
                        {
                            // get doc 
                            if ($retrivedDoc->getDocumentID() == $docID)
                            {
                                $canView = true;
                                $isEdit = true;

                                //save method is diifrent here 
                                if (isset($_POST['docSave']))
                                {
                                    $name = $_POST['nameInput'];
                                    $retrivedDoc->setDocumentName($name);
                                    $retrivedDoc->updateDocument();

                                    //update doc name 
                                    echo '<div class="alert alert-success alert-dismissible fade show botAlert" role="alert">
                Document name updated.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
                                }
                            }
                            else
                            {
                                //echo error msg
                                $viewError .= 'Document is not a part of the Same Article .<br/>';
                                $canView = false;
                            }
                        }
                        else
                        {
                            //echo error msg
                            $viewError .= 'Document was not found .<br/>';
                            $canView = false;
                        }
                    }
                    else if (isset($_POST['docSave']))
                    {
                        // here is where the actual save of the document and the image happens

                        $name = $_POST['nameInput'];

                        //if file > 2mb 
                        if ($_FILES['fileInput']['size'] > 2087152)
                        {
                            //echo error msg
                            $errors .= 'file larger then allowed size, 2MB max.<br/>';
                        }
                        else
                        {
                            // if not add it 
                            $path = "docs//" . $_FILES['fileInput']['name']; //unix path uses forward slash
                            move_uploaded_file($_FILES['fileInput']['tmp_name'], $path);
                            $type = end((explode(".", $path)));
                        }
                        
                        // if there is errorrrrrr
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

                        // if there is error format it this way
                        if ($errors != '')
                        {
                            echo '<div class="alert alert-danger alert-dismissible fade show botAlert" role="alert">
                '.$errors.'
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
                        }
                        else
                        {
                            // if no error add the doc 
                            $newDoc = new artiDocument();

                            $newDoc->setDocumentName($name);
                            $newDoc->setDocumentPath($path);
                            $newDoc->setDocumentType($type);
                            $newDoc->setArticleID($articleID);

                            $docID = $newDoc->saveDocument();

                            if ($docID != false)
                            {
                                // go to edit mode - removes image link allowes only name chnage

                                $isEdit = true;

                                echo "<script>window.location.href='addEditDoc.php?artiID=$articleID" . "&docID=$docID';</script>";
                                exit;
                            }
                            else
                            {
                                //echo error msg
                                $isEdit = false;
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
//    function to change body size
    function chnageSize()
    {
        var height = ((window.innerHeight) - (document.getElementById('mainNavBar').offsetHeight));
        document.getElementById('articleDocFormBody').setAttribute("style", "height:" + height);
    }


    window.addEventListener('resize', chnageSize);

    $(document).ready(function () {
        $('#docForm input').blur(function () {
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
                <form id="docForm" method="post" enctype="multipart/form-data">
                    <div class="card mb-4 shadow">
                        <div class="card-header py-3">
                            <h5 class="mb-0">Article "<?php
                                if ($canView)
                                {
                                    echo $retrivedArtcl->getHeader();
                                }
                                ?>" Document</h5>
                        </div>
                        <div class="card-body ">

                            <!-- Text input -->
                            <div class="form-outline mb-4">
                                <label class="form-label" for="nameInput">Title</label>
                                <input type="text" id="nameInput" name="nameInput" class="form-control" placeholder="Document Name" required <?php
                                if ($canView && $isEdit)
                                {
                                    echo 'value = "' . $retrivedDoc->getDocumentName() . '"';
                                }
                                else if (isset($_POST['nameInput']))
                                {
                                    echo 'value = "' . $_POST['nameInput'] . '"';
                                }
                                ?>/> 
                            </div>

                            <!-- file input -->
                            <div class="form-outline mb-4" <?php
                                 if ($isEdit)
                                 {
                                     echo 'hidden';
                                 }
                                 ?>>
                                <label class="form-label" for="fileInput">File</label>
                                <input type="file" id="fileInput" name="fileInput" class="form-control" <?php
                                if (!$isEdit)
                                {
                                    echo 'required';
                                }
                                 ?>/> 
                            </div>

<!--                            // save button-->
                            <button type="submit" name="docSave" id="docSave" class="btn btn-success btn-block">
                                Save
                            </button>
                            <a href="viewArticleDocs.php?artiID=<?php
                                if ($canView)
                                {
                                    echo $retrivedArtcl->getArticleID();
                                }
                                 ?>" name="document" id="document" class="btn btn-secondary btn-block">Back to Documents</a>



                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>





<script type="text/javascript">chnageSize();</script>