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
                    if (isset($_GET['docID']))
                    {
                        $retrivedDoc = new artiDocument();
                        $retrivedDoc->setDocumentID($_GET['docID']);
                        $retrivedDoc->initDwithID();
                        $docID = $retrivedDoc->getDocumentID();
                        
                        if ($docID != null)
                        {
                            if ($retrivedDoc->getDocumentID() == $docID)
                            {
                                $canView = true;
                                $isEdit = true;
                                
                                // extra validartion comes in from here for editiing documents 
                                //save method is diifrent here 
                                if (isset($_POST['docSave']))
                                {
                                    $name = $_POST['nameInput'];
                                    $retrivedDoc->setDocumentName($name);
                                    $retrivedDoc->updateDocument();
                                    
                                    echo 'update slayed';
                                }
                            }
                            else
                            {
                                $viewError .= 'Document is not a part of the Same Article .<br/>';
                                $canView = false;
                            }
                        }
                        else
                        {
                            $viewError .= 'Document was not found .<br/>';
                            $canView = false;
                        }

                    }
                    else if (isset($_POST['docSave']))
                    {
                        // here is where the actual save of the document and the image happens

                        $name = $_POST['nameInput'];

                        // add image errors and validation (upload errors missing from mid dont forget
                        $path = "docs//" . $_FILES['fileInput']['name']; //unix path uses forward slash
                        move_uploaded_file($_FILES['fileInput']['tmp_name'], $path);

                        $type = end((explode(".", $path)));

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
                            $isEdit = false;
                            echo 'FEE SAVE ERRORRR TRY AGAIN';
                        }
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
                <form method="post" enctype="multipart/form-data">
                    <div class="card mb-4 shadow">
                        <div class="card-header py-3">
                            <h5 class="mb-0">Article "<?php if ($canView){echo $retrivedArtcl->getHeader();} ?>" Document</h5>
                        </div>
                        <div class="card-body ">

                            <!-- Text input -->
                            <div class="form-outline mb-4">
                                <label class="form-label" for="nameInput">Title</label>
                                <input type="text" id="nameInput" name="nameInput" class="form-control" placeholder="Document Name" required <?php if ($canView && $isEdit){echo 'value = "' . $retrivedDoc->getDocumentName() . '"';} ?>/> 
                            </div>

                            <!-- file input -->
                            <div class="form-outline mb-4" <?php if ($isEdit){echo 'hidden';} ?>>
                                <label class="form-label" for="fileInput">File</label>
                                <input type="file" id="fileInput" name="fileInput" class="form-control" <?php if (!$isEdit){echo 'required';} ?>/> 
                            </div>


                            <button type="submit" name="docSave" id="docSave" class="btn btn-success btn-block">
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





<script type="text/javascript">chnageSize();</script>