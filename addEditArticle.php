<?php
include './header.php';

$isEdit = false;
$article = new Article();

if (isset($_GET['artiID']))
{
    $articleID = $_GET['artiID'];
    // first validate the id and add the booleans for the check later
    echo 'its an edit';
    $isEdit = true;
    $article->setArticleID($articleID);
    $article->initAwithID();
    
    //save method is diifrent here 
    if (isset($_POST['save']))
    {
        echo 'its a save from an edit';
    }
    else if (isset($_POST['publish']))
    {
        echo 'its a publish from edit';
    }
    else if (isset ($_POST['media']))
    {
        echo 'ok going to the media page';
        
        echo "<script>window.location.href='viewArticleMedia.php?artiID=$articleID';</script>";
            exit;
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
}
else if (isset($_POST['media']))
{
    // error to user telling him it needs to be saved first
    echo 'you need to save before you can go';
}
?>

<script type="text/javascript">
    function chnageSize()
    {
        var height = ((window.innerHeight) - (document.getElementById('mainNavBar').offsetHeight));
        document.getElementById('articleFormBody').setAttribute("style", "height:" + height);
    }


    window.addEventListener('resize', chnageSize);
</script>



<section id="articleFormBody">
    <div class="container h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-lg-12 col-xl-11">

                <form method="post" enctype="multipart/form-data">
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
                                        <input type="text" id="headerInput" name="headerInput" class="form-control" placeholder="Main Header" required <?php if($isEdit){echo 'value = "'.$article->getHeader().'"';}else if (isset ($_POST['headerInput'])){echo 'value = "'.$_POST['headerInput'].'"';} ?>/>
                                    </div>


                                    <div class="form-outline mb-4">
                                        <label class="form-label" for="form7Example3">Category</label>
                                        <select name="categoryInput" id="categoryInput" class="form-control" required >
                                            <option disabled selected=""></option>
                                            <?php
                                                $arcObj = new Article();
                                                $categories = $arcObj->getAllCategories();
                                                
                                                for ($i = 0; $i<count($categories); $i++)
                                                {
                                                    if($isEdit && ($article->getCategoryID() == $categories[$i]->categoryID))
                                                    {
                                                        echo '<option selected value="'.$categories[$i]->categoryID.'">'.$categories[$i]->catgoryName.'</option>';
                                                    }
                                                    else
                                                    {
                                                        echo '<option value="'.$categories[$i]->categoryID.'">'.$categories[$i]->catgoryName.'</option>';
                                                    }
                                                }
                                            ?>
                                            
                                        </select>
                                    </div>

                                    <div class="form-outline mb-4">
                                        <label class="form-label" for="thumbnailInput">Thumbnail</label>
                                        <input type="file" accept="image/*"  id="thumbnailInput" name="thumbnailInput"  required/>
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
                                        <input type="text" id="titleInput" name="titleInput" class="form-control" placeholder="Sub Header" required <?php if($isEdit){echo 'value = "'.$article->getTitle().'"';} ?>/> 
                                    </div>

                                    <!-- Message input -->
                                    <div class="form-outline mb-4">
                                        <label class="form-label" for="bodyInput">Body</label>
                                        <textarea class="form-control" id="bodyInput" name="bodyInput" rows="5" required> <?php if($isEdit){echo $article->getBody();} ?> </textarea>
                                    </div>

                                    <button type="submit" name="media" id="media" class="btn btn-info btn-block" formnovalidate>
                                        View / Edit Article Media
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