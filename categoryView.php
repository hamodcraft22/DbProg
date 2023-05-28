<?php
include './header.php';

$canView = true;
$viewError = '';


if (isset($_GET['catID']))
{
    if ($_GET['catID'] < 1 || $_GET['catID'] > 7)
    {
        $canView = false;
        $viewError = 'The category is not found, please select another one';
    }
    else
    {
        $catID = $_GET['catID'];
        
        $article = new Article();
        $articles = $article->getPubArtis(null, null, $catID);
        
        if (count($articles) > 0)
        {
            $pageination = new Pagination();
            $pageination->totalRecords($articles);
            $pageination->setLimit(5);

            $totalPgs = $pageination->getTotal_pages();

            if (isset($_GET['pg']))
            {
                if ($_GET['pg'] < 1)
                {
                    echo "<script>window.location.href='categoryView.php?catID=$catID&pg=1';</script>";
                    exit;
                }
                else if ($_GET['pg'] > $pageination->getTotal_pages())
                {
                    echo "<script>window.location.href='categoryView.php?catID=$catID&pg=$totalPgs';</script>";
                    exit;
                }

                $pageination->setWhere($_GET['pg']);
                $start = $pageination->startIndex();
                $end = $pageination->getLimit();

                $articles = $article->getPubArtis($start, $end, $catID);

                if (count($articles) < 1)
                {
                    $canView = false;
                    $viewError .= "No articles are avalible for this category";
                }
            }
            else
            {
                echo "<script>window.location.href='categoryView.php?catID=$catID&pg=1';</script>";
                exit;
            }
        }
        else
        {
            $canView = false;
            $viewError .= "No articles are avalible for this category";
        }
    }
}
else
{
    $canView = false;
    $viewError .= 'no Catgory id, please try select a category';
}
?>

<!-- scripts and functions - fancy ocd stuff -->
<script type="text/javascript">
    function chnageSize()
    {
        var height = ((window.innerHeight) - (document.getElementById('mainNavBar').offsetHeight));
        document.getElementById('categoryDiv').setAttribute("style", "height:" + height);
    }


    window.addEventListener('resize', chnageSize);
</script>

<section <?php
if (!$canView)
{
    echo 'id="categoryDiv"';
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

<!-- Main Home Div's -->
<section <?php
if ($canView)
{
    echo 'id="categoryDiv"';
}
else
{
    echo 'hidden';
}
?>>
    <div class="container h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-lg-12 col-xl-11">

                <div>
                    <center>

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

                                echo '<a class="page-link" href="categoryView.php?catID=' . $catID . '&pg=1" tabindex="-1">First</a>
                    </li>';

                                for ($i = 0; $i < $pageination->getTotal_pages(); $i++)
                                {
                                    echo '<li class="page-item"><a class="page-link" href="categoryView.php?catID=' . $catID . '&pg=' . ($i + 1) . '">' . ($i + 1) . '</a></li>';
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
                        <a class="page-link" href="categoryView.php?catID=' . $catID . '&pg=' . $pageination->getTotal_pages() . '">Last</a>
                    </li>
                </ul>
            </nav>';
                            }
                            ?>






                        </div>
                    </center>
                </div>

            </div>
        </div>
    </div>

    <!-- run custom scripts after all the elements are loaded -->
    <script>
        chnageSize();
    </script>

    <?php include './footer.html'; ?>