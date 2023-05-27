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
                    $documnets = new artiDocument();
                    $documnets->setArticleID($articleID);
                    $data = $documnets->getAllDocument();
                    
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

if (isset($_POST['deleteDocument']))
{
    $deleteDoc = new artiDocument();
    $deleteDoc->setDocumentID($_POST['deleteDocument']);
    $deleteDoc->initDwithID();
    $deleteDoc->deleteDoc();
    
    echo "<script>window.location.href='viewArticleDocs.php?artiID='$articleID';</script>";
    exit;
}
?>

<script type="text/javascript">
    function chnageSize()
    {
        var height = ((window.innerHeight) - (document.getElementById('mainNavBar').offsetHeight));
        document.getElementById('articlesDocsPageBody').setAttribute("style", "height:" + height);
    }


    window.addEventListener('resize', chnageSize);
    
    function checkForm()
    {
        return confirm('Are you sure you want to delete this Document?');
    }
</script>


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
                                    $newDoc = new artiDocument();
                                    $newDoc->setDocumentID($data[$i]->documentID);
                                    $newDoc->initDwithID();

                                    echo
                                    '
                                        <tr>
                                            <th class="text-center" scope="row">' . $newDoc->getDocumentID() . '</th>
                                            <td>' . $newDoc->getDocumentName() . '</td>
                                            <td class="text-center">' . $newDoc->getDocumentType() . '</td>
                                            <td class="text-center">
                                            <form method="post" onsubmit="return checkForm();">';

                                        echo '
                                                <a type="button" class="btn btn-primary" href="' . $newDoc->getDocumentPath() . '"><i class="fa-solid fa-file"></i></a>';
                                    

                                    echo '
                                                <a type="button" class="btn btn-success" href="addEditDoc.php?artiID='.$articleID.'&docID='.$newDoc->getDocumentID().'"><i class="fas fa-edit"></i></a>
                                                <button type="submit" class="btn btn-danger" name="deleteDocument" value="'.$newDoc->getDocumentID().'"><i class="far fa-trash-alt"></i></button>
                                                </form>
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