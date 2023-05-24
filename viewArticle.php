<?php
include './header.php';

$canView = false;
$canComment = false;
$viewError = '';

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
            $viewError .= 'the article is not avalabile. <br/>';
            $canView = false;
        }
        else
        {
            // here is where the actual page is diplayed
            $canView = true;

            $media = new Media();
            $media->setArticleID($articleID);
            $medias = $media->getAllMedia();

            $documnt = new artiDocument();
            $documnt->setArticleID($articleID);
            $docs = $documnt->getAllDocument();
            
            if (isset($_POST['likeButton']))
            {
                echo 'you have liked this article!';
                $retrivedArtcl->increaseRate();
            }
            else if (isset ($_POST['dislikeButton']))
            {
                echo 'you have disliked this article!';
                $retrivedArtcl->decreaseRate();
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
?>

<script type="text/javascript">
    function chnageSize()
    {
        var height = ((window.innerHeight) - (document.getElementById('mainNavBar').offsetHeight));
        document.getElementById('articlePageBody').setAttribute("style", "height:" + height);
    }


    window.addEventListener('resize', chnageSize);
</script>


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

                                if ($newMedia->getMediaType() != 'ogm' && $newMedia->getMediaType() != 'wmv' && $newMedia->getMediaType() != 'mpg' && $newMedia->getMediaType() != 'webm' && $newMedia->getMediaType() != 'ogv' && $newMedia->getMediaType() != 'mov' && $newMedia->getMediaType() != 'asx' && $newMedia->getMediaType() != 'mpeg' && $newMedia->getMediaType() != 'mp4' && $newMedia->getMediaType() != 'm4v' && $newMedia->getMediaType() != 'avi')
                                {
                                    echo
                                    '
                                            <div class="carousel-item active">
                                                <img class="d-block w-100 img-fluid shadow-2-strong rounded-5 mb-4" src="' . $newMedia->getMediaPath() . '" alt="' . $newMedia->getMediaName() . '">
                                            </div>
                                        ';
                                }
                                else
                                {
                                    echo
                                    '
                                            <div class="carousel-item active">
                                                <video autoplay muted loop style="width: 100%" class="d-block w-100 img-fluid shadow-2-strong rounded-5 mb-4"><source src="' . $newMedia->getMediaPath() . '"></video>
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
                    <p class="text-center"><strong>Comments: 3</strong></p>

                    <!-- Comment -->
                    <div class="row mb-4">


                        <div>
                            <p class="mb-2"><strong>Marta Dolores</strong></p>
                            <p class="text-muted mb-2"><strong>date</strong></p>
                            <p>
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Distinctio est ab iure
                                inventore dolorum consectetur? Molestiae aperiam atque quasi consequatur aut?
                                Repellendus alias dolor ad nam, soluta distinctio quis accusantium!
                            </p>
                        </div>
                    </div>


                    <!-- Comment -->
                    <div class="row mb-4">


                        <div>
                            <p class="mb-2"><strong>Valeria Groove</strong></p>
                            <p>
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Distinctio est ab iure
                                inventore dolorum consectetur? Molestiae aperiam atque quasi consequatur aut?
                                Repellendus alias dolor ad nam, soluta distinctio quis accusantium!
                            </p>
                        </div>
                    </div>

                    <!-- Comment -->
                    <div class="row mb-4">


                        <div>
                            <p class="mb-2"><strong>Antonia Velez</strong></p>
                            <p>
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Distinctio est ab iure
                                inventore dolorum consectetur? Molestiae aperiam atque quasi consequatur aut?
                                Repellendus alias dolor ad nam, soluta distinctio quis accusantium!
                            </p>
                        </div>
                    </div>
                </section>
                <!--Section: Comments-->

                <!--Section: Reply-->
                <section>
                    <p class="text-center"><strong>Leave a Comments</strong></p>

                    <form>
                        <!-- Name input -->
                        <div class="form-outline mb-4">
                            <input type="text" id="form4Example1" class="form-control" />
                            <label class="form-label" for="form4Example1">Title</label>
                        </div>

                        <!-- Message input -->
                        <div class="form-outline mb-4">
                            <textarea class="form-control" id="form4Example3" rows="4"></textarea>
                            <label class="form-label" for="form4Example3">Comment</label>
                        </div>

                        <!-- Submit button -->
                        <button type="submit" class="btn btn-primary btn-block mb-4">
                            Publish
                        </button>
                    </form>
                </section>
                <!--Section: Reply-->
            </div>
            <!--Grid column-->

            <!--Grid column-->
            <div class="col-md-4 mb-4">
                <!--Section: Sidebar-->
                <section class="sticky-top" style="top: 80px;">
                    <!--Section: Ad-->
                    <section class="text-center border-bottom pb-4 mb-4">
                        <div class="bg-image hover-overlay ripple mb-4">
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
                            for ($i = 0; $i < count($docs); $i++)
                            {

                                $newDoc = new artiDocument();
                                $newDoc->setDocumentID($docs[$i]->documentID);
                                $newDoc->initDwithID();
                                
                                echo 
                                '
                                    <div class="m-1">
                                        <a role="button" class="btn btn-primary" href="'.$newDoc->getDocumentPath().'" target="_blank">Download File "'.$newDoc->getDocumentName().'"<i class="fas fa-download ms-2"></i></a>
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
        </div>
        <!--Grid row-->
    </div>
</main>
<!--Main layout-->

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

<script type="text/javascript">chnageSize();</script>