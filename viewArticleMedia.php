<?php
include './header.php';

$canView = false;
$viewError = '';

//get request to get article id;
if(isset($_SESSION['userID']) && $_SESSION['roleType'] != 'reader')
{
if (isset($_GET['artiID'])) {
    // do some actions here for validation and some other stuff
    $retrivedArtcl = new Article();
    $retrivedArtcl->setArticleID($_GET['artiID']);
    $retrivedArtcl->initAwithID();

    if ($retrivedArtcl->getArticleID() != null) {
        if ($_SESSION['userID'] == $retrivedArtcl->getUserID()) {
            //check the status if it is published u cant edit
            echo 'ok possible';
            $canView = true;
        }
        else
        {
            $viewError .= 'you cannot edit others articles .<br/>';
        }
    } else {
        $viewError .= 'the article ID was not found. <br/>';
    }



    
} else {
    $viewError .= 'No article id was selected.<br/>';
}
}
else
{
    $viewError .= 'You have to be logged in.<br/>';
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


<section <?php if ($canView) {
    echo 'id="articlesMediaPageBody"';
} else {
    echo 'hidden';
} ?>>
    <div class="container h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-xl-9">

                <h1 class="text-black mb-4">Article "" Media</h1>



                <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                    <a type="button" class="btn btn-primary btn-sm" href="addEditArticle.php">Add new Media</a>
                </div>

                <div class="card shadow" style="border-radius: 15px;">
                    <div class="card-body">

                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<section <?php if (!$canView) {
    echo 'id="articlesMediaPageBody"';
} else {
    echo 'hidden';
} ?>>
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