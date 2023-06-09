<?php
include './header.php';

$canView = false;
$canComment = false;
$viewError = '';

$videoArray = array('ogm', 'wmv', 'mpg', 'webm', 'ogv', 'mov', 'asx', 'mpeg', 'mp4', 'm4v', 'avi');
$audioArray = array('opus', 'flac', 'weba', 'wav', 'ogg', 'm4a', 'oga', 'mid', 'mp3', 'aiff', 'wma', 'au');

if (isset($_GET['artiID']))
{
    $retrivedArtcl = new Article();
    $retrivedArtcl->setArticleID($_GET['artiID']);
    $retrivedArtcl->initAwithID();
    $articleID = $retrivedArtcl->getArticleID();

    if ($retrivedArtcl->getArticleID() != null)
    {
        if ($retrivedArtcl->getStatusID() == 4)
        {
            $viewError .= 'the article was deleted. <br/>';
            $canView = false;
        }
        else if ($retrivedArtcl->getStatusID() == 1)
        {
            $viewError .= 'the article is not Published. <br/>';
            $canView = false;
        }
        else if ($retrivedArtcl->getStatusID() == 5)
        {
            $viewError .= 'the article was removed by an administrator. <br/>';
            $canView = false;
        }
        else
        {
            // here is where the actual page is diplayed
            $canView = true;

            $retrivedArtcl->increaseViews();

            $media = new Media();
            $media->setArticleID($articleID);
            $medias = $media->getAllMedia();

            $documnt = new artiDocument();
            $documnt->setArticleID($articleID);
            $docs = $documnt->getAllDocument();

            $comment = new Comment();
            $comment->setArticleID($articleID);
            $commetns = $comment->getAllComms();

            if (isset($_POST['likeButton']))
            {
                $retrivedArtcl->increaseRate();
                echo '<div class="alert alert-success alert-dismissible fade show botAlert" role="alert">
                You have liked the article.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
            }
            else if (isset($_POST['dislikeButton']))
            {
                $retrivedArtcl->decreaseRate();
                echo '<div class="alert alert-success alert-dismissible fade show botAlert" role="alert">
                You have disliked the article.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
            }

            if (isset($_SESSION['userID']))
            {
                //if any user is logged in, they can add a comment
                $canComment = true;

                if (isset($_POST['commentPost']))
                {
                    // do validation here for comment
                    $commentTitle = $_POST['ctitleInput'];
                    $commentBody = $_POST['cBodyInput'];

                    $newUserComment = new Comment();
                    $newUserComment->setCommentTitle($commentTitle);
                    $newUserComment->setCommentBody($commentBody);
                    $newUserComment->setUserID($_SESSION['userID']);
                    $newUserComment->setArticleID($articleID);

                    if ($newUserComment->saveCom())
                    {
                        echo "<script>window.location.href='viewArticle.php?artiID=$articleID';</script>";
                        exit;
                    }
                    else
                    {
                        echo '<div class="alert alert-danger alert-dismissible fade show botAlert" role="alert">
                ' . $errors . '
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
                    }
                }
            }
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
    $canView = false;
    $viewError = 'No Article was selected';
}

if (isset($_POST['deleteCom']))
{
    $deleteComment = new Comment();
    $deleteComment->setCommentID($_POST['deleteCom']);
    $deleteComment->initCwithID();
    if ($_SESSION['roleType'] == 'admin')
    {
        $deleteComment->adminDeleteCom();
    }
    else
    {
        $deleteComment->deleteCom();
    }

    echo "<script>window.location.href='viewArticle.php?artiID=$articleID';</script>";
    exit;
}
?>

<script type="text/javascript">
    function chnageSize()
    {
        var height = ((window.innerHeight) - (document.getElementById('mainNavBar').offsetHeight));
        document.getElementById('articlePageBody').setAttribute("style", "height:" + height);
    }

    function checkForm()
    {
        return confirm('Are you sure you want to delete this comment?');

    }

    window.addEventListener('resize', chnageSize);
</script>


<section <?php
if (!$canView)
{
    echo 'id="articlePageBody"';
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

<!-- implemnted from https://mdbootstrap.com/snippets/standard/mdbootstrap/2515550 -->

<!--Main layout-->
<main class="mt-4 mb-5" <?php
if (!$canView)
{
    echo 'hidden';
}
?>>
    <div class="container">
        <!--Grid row-->
        <div class="row">

            <!--Grid column-->
            <div class="col-md-4 mb-4">
                <!--Section: Sidebar-->
                <section class="sticky-top" style="top: 80px;">
                    <!--Section: Ad-->
                    <section class="text-center border-bottom pb-4 mb-4">
                        <div class="bg-image mb-4">
                            <img src="<?php echo $retrivedArtcl->getThumbnail() ?>" class="img-fluid" />
                        </div>
                        <h5><?php echo $retrivedArtcl->getTitle() ?></h5>

                        <p>
                            <?php echo $retrivedArtcl->getHeader() ?>
                        </p>

                    </section>
                    <!--Section: Ad-->

                    <!--Section: Video-->
                    <section class="text-center">
                        <h5 class="mb-4">Download Documents</h5>

                        <?php
                        if (count($docs) >= 1)
                        {
                            for ($i = 0; $i < count($docs); $i++)
                            {

                                $newDoc = new artiDocument();
                                $newDoc->setDocumentID($docs[$i]->documentID);
                                $newDoc->initDwithID();

                                echo
                                '
                                    <div class="m-1">
                                        <a role="button" class="btn btn-primary" href="' . $newDoc->getDocumentPath() . '" target="_blank">Download File "' . $newDoc->getDocumentName() . '"<i class="fas fa-download ms-2"></i></a>
                                    </div>
                                ';
                            }
                        }
                        else
                        {
                            echo
                            '
                                    <div class="m-1">
                                        <p>No Documents Avalible</p>
                                    </div>
                                ';
                        }
                        ?>

                    </section>
                    <!--Section: Video-->
                </section>
                <!--Section: Sidebar-->
            </div>
            <!--Grid column-->

            <!--Grid column-->
            <div class="col-md-8 mb-4">
                <!--Section: Post data-mdb-->
                <section class="border-bottom mb-4">

                    <!-- image slides -->
                    <div id="carouselExample" class="carousel slide">
                        <div class="carousel-inner">

                            <?php
                            for ($i = 0; $i < count($medias); $i++)
                            {

                                $newMedia = new Media();
                                $newMedia->setMediaID($medias[$i]->mediaID);
                                $newMedia->initMwithID();

                                if ($i == 0)
                                {
                                    echo '<div class="carousel-item active">';
                                }
                                else
                                {
                                    echo '<div class="carousel-item">';
                                }

                                if (in_array($newMedia->getMediaType(), $videoArray))
                                {
                                    echo
                                    '
                                            
                                                <video autoplay muted loop style="width: 100%" class="d-block w-100 img-fluid shadow-2-strong rounded-5 mb-4"><source src="' . $newMedia->getMediaPath() . '"></video>
                                            </div>
                                        ';
                                }
                                else if (in_array($newMedia->getMediaType(), $audioArray))
                                {
                                    echo
                                    '
                                                <audio><source src="' . $newMedia->getMediaPath() . '"></audio>
                                            </div>
                                        ';
                                }
                                else
                                {
                                    echo
                                    '
                                                <img class="d-block w-100 img-fluid shadow-2-strong rounded-5 mb-4" src="' . $newMedia->getMediaPath() . '" alt="' . $newMedia->getMediaName() . '">
                                            </div>
                                        ';
                                }
                            }
                            ?>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                    <!-- image slides -->

                    <form method="post">
                        <div class="row align-items-center mb-4">
                            <div class="col-lg-6 text-center text-lg-start mb-3 m-lg-0">
                                <span> Published <u><?php echo $retrivedArtcl->getDate() ?></u> </span> by <u><?php echo $retrivedArtcl->getUserFullName() ?></u></span>
                            </div>

                            <div class="col-lg-6 text-center text-lg-end">
                                <button type="submit" name="likeButton" class="btn btn-primary px-3 me-1" style="background-color: #3b5998;">
                                    <i class="fa-solid fa-thumbs-up"></i>
                                </button>
                                <button type="submit" name="dislikeButton" class="btn btn-primary px-3 me-1" style="background-color: #FF4122;">
                                    <i class="fa-solid fa-thumbs-down"></i>
                                </button>
                            </div>

                        </div>
                    </form>
                </section>
                <!--Section: Post data-mdb-->

                <!--Section: Text-->
                <section class="border-bottom py-4 mb-4">
                    <p>
                        <?php echo $retrivedArtcl->getBody() ?>
                    </p>
                </section>
                <!--Section: Text-->


                <!--Section: Comments-->

                <section class="border-bottom mb-3">
                    <p class="text-center"><strong>Comments: <?php echo count($commetns) ?></strong></p>

                    <?php
                    for ($i = 0; $i < count($commetns); $i++)
                    {
                        $newComment = new Comment();
                        $newComment->setCommentID($commetns[$i]->commentID);
                        $newComment->initCwithID();

                        if ($newComment->getStatusID() == 2)
                        {
                            $newUser = new User();
                            $newUser->setUserID($newComment->getUserID());
                            $newUser->initWithID();
                            $userCommentRole = $newUser->getRole();
                            echo
                            '
                                <div class="row mb-4">
                                    <div>
                                        <p class="mb-2"><strong>' . $newComment->getCommentTitle() . '</strong> By ' . $newComment->getUserFullName() . '</p>
                                        <p class="text-muted mb-2">' . $newComment->getCommentDate() . '</p>
                                        <p>' . $newComment->getCommentBody() . '</p>
                            ';

                            if (($_SESSION['roleType'] == 'admin' && ($userCommentRole != 'admin')) || ($_SESSION['userID'] == $newUser->getUserID()))
                            {
                                echo '<form method="post" onsubmit="return checkForm();"><button type="submit" name="deleteCom" value="' . $newComment->getCommentID() . '" class="btn btn-danger"><i class="far fa-trash-alt"></i></button></form>';
                            }

                            echo '</div>
                                </div>';
                        }
                        else if ($newComment->getStatusID() == 4)
                        {
                            echo
                            '
                                <div class="row mb-4">
                                    <div>
                                        <p class="mb-2"><strong>This comment was deleted</p>
                                    </div>
                                </div>';
                        }
                        else if ($newComment->getStatusID() == 5)
                        {
                            echo
                            '
                                <div class="row mb-4">
                                    <div>
                                        <p class="mb-2"><strong>This comment was removed by an administrator</p>
                                    </div>
                                </div>';
                        }
                    }
                    ?>





                </section>
                <!--Section: Comments-->


                <!--Section: Reply if the user is logged in they can comment-->

                <section <?php
                if (!$canComment)
                {
                    echo 'hidden';
                }
                ?>>
                    <p class="text-center"><strong>Leave a Comments</strong></p>

                    <form method="post">
                        <!-- Name input -->
                        <div class="form-outline mb-4">
                            <label class="form-label" for="ctitleInput">Title</label>
                            <input type="text" id="ctitleInput" name="ctitleInput" required class="form-control" />
                        </div>

                        <!-- Message input -->
                        <div class="form-outline mb-4">
                            <label class="form-label" for="cBodyInput">Comment</label>
                            <textarea class="form-control" id="cBodyInput" required name="cBodyInput" rows="4"></textarea>
                        </div>

                        <!-- Submit button -->
                        <button type="submit" name="commentPost" class="btn btn-primary btn-block mb-4">
                            Publish
                        </button>
                    </form>
                </section>

                <section <?php
                if ($canComment)
                {
                    echo 'hidden';
                }
                ?>>
                    <p class="text-center"><strong>Please login to leave a comment</strong></p>
                    <p class="text-center"></p>
                </section>

                <!--Section: Reply-->
            </div>
            <!--Grid column-->


        </div>
        <!--Grid row-->
    </div>
</main>
<!--Main layout-->



<script type="text/javascript">chnageSize();</script>