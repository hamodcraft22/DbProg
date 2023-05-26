<?php
include './header.php';

$article = new Article();
$articles = $article->getPubArtis(null, null, null);

if (count($articles) > 0)
{
    $pageination = new Pagination();
    $pageination->totalRecords($articles);
    $pageination->setLimit(10);

    $totalPgs = $pageination->getTotal_pages();

    if (isset($_GET['pg']))
    {
        if ($_GET['pg'] < 1)
        {
            echo "<script>window.location.href='index.php?pg=1';</script>";
            exit;
        }
        else if ($_GET['pg'] > $pageination->getTotal_pages())
        {
            echo "<script>window.location.href='index.php?pg=$totalPgs';</script>";
            exit;
        }

        $pageination->setWhere($_GET['pg']);
        $start = $pageination->startIndex();
        $end = $pageination->getLimit();

        $articles = $article->getPubArtis($start, $end, null);
    }
    else
    {
        echo "<script>window.location.href='index.php?pg=1';</script>";
        exit;
    }
}
?>

<!-- scripts and functions - fancy ocd stuff -->
<script type="text/javascript">
    function chnageSize()
    {
        var height = ((window.innerHeight) - (document.getElementById('mainNavBar').offsetHeight));
        document.getElementById('mainDiv').setAttribute("style", "height:" + height);
    }

    function blurVideo()
    {
        let num = (window.scrollY / window.innerHeight) * 8;
        if (num <= 8)
        {
            document.getElementById('mainVideo').style.webkitFilter = 'blur(' + num + 'px)';
        }
    }

    window.addEventListener('resize', chnageSize);
    window.addEventListener('scroll', blurVideo);
</script>

<!-- home Video/Image - chosen news Media (add image part) -->
<video autoplay="autoplay" loop="loop" muted playsinline defaultMuted id="mainVideo">
    <source src="assests/mainVideo.mp4" type="video/mp4">
</video>

<!-- Main Home Div's -->
<div id="homeDiv">
    <center>
        <div id="mainDiv">
            <div id="mainTitle">
                <h2 class="text-white invert text-center">
                    this should be the title sdfsdf dsfds fdsfsdf dsfsdfd sfsdfsdf	
                </h2>
            </div>

            <center>
                <div id="mainButtons">

                    <div>
                        <p style="text-align: center;">this should be header.&nbsp;</p>
                    </div>
                    <div>
                        <a id="articalButton" class="btn btn-outline-light" role="button" href="/electric/celestiq">
                            Read Full Article
                        </a>
                    </div>

                </div>
            </center>
        </div>

        <!-- the part where all articles are -->
        <div id="contentDiv">

            <?php
            for ($i = 0; $i < count($articles); $i++)
            {
                $newArtcl = new Article();
                $newArtcl->setArticleID($articles[$i]->articleID);
                $newArtcl->initAwithID();

                echo

                '
                    <div class="card mb-3" >
                        <div class="row g-0">
                            <div class="col-md-4 d-flex align-items-center justify-content-center">
                                <img src="' . $newArtcl->getThumbnail() . '" class="img-fluid rounded-start homeCardImage text-center" alt="' . $newArtcl->getTitle() . '">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title">' . $newArtcl->getTitle() . '</h5>
                                    <p class="card-text">' . $newArtcl->getHeader() . '</p>
                                    <p class="card-text"><small class="text-body-secondary">Published date: ' . $newArtcl->getDate() . '</small></p>
                                    <a id="articalButton" class="btn btn-outline-dark" role="button" href="viewArticle.php?artiID=' . $newArtcl->getArticleID() . '">Read More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    ';
            }
            ?>

            <?php
            if (count($articles) > 0)
            {
                echo '<nav aria-label="Page navigation example">
                <ul class="pagination justify-content-center">';

                if (isset($_GET['pg']) && ($_GET['pg'] == 1))
                {
                    echo '<li class="page-item disabled">';
                }
                else
                {
                    echo '<li class="page-item">';
                }

                echo '<a class="page-link" href="index.php?pg=1" tabindex="-1">First</a>
                    </li>';

                for ($i = 0; $i < $pageination->getTotal_pages(); $i++)
                {
                    echo '<li class="page-item"><a class="page-link" href="index.php?pg=' . ($i + 1) . '">' . ($i + 1) . '</a></li>';
                }

                if (isset($_GET['pg']) && (($_GET['pg']) == ($pageination->getTotal_pages())))
                {
                    echo '<li class="page-item disabled">';
                }
                else
                {
                    echo '<li class="page-item">';
                }

                echo '
                        <a class="page-link" href="index.php?pg=' . $pageination->getTotal_pages() . '">Last</a>
                    </li>
                </ul>
            </nav>';
            }
            ?>






        </div>
    </center>
</div>

<!-- run custom scripts after all the elements are loaded -->
<script>
    chnageSize();
</script>

<?php include './footer.html'; ?>