<?php
include './header.php';

$canView = true;
$viewError = '';

$data = $_SESSION['serachOut'];

//if there is data 
if (count($data)<1)
{
    $canView = false;
    $viewError = 'No results were found';
}

?>

<script type="text/javascript">
    function chnageSize()
    {
        var height = ((window.innerHeight) - (document.getElementById('mainNavBar').offsetHeight));
        document.getElementById('articlesPageBody').setAttribute("style", "height:" + height);
    }


    window.addEventListener('resize', chnageSize);
</script>


<section <?php
if (!$canView)
{
    echo 'id="articlesPageBody"';
}
else
{
    echo 'hidden';
}
//error banner formatting 
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


<!--if the user is an admin or author can view all his articales -->
<section <?php
if ($canView)
{
    echo 'id="articlesPageBody"';
}
else
{
    echo 'hidden';
}
?>>
    <div class="container h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-xl-9">

                <h1 class="text-black mb-4">Search Results (<?php if(isset($_GET['mv'])){echo 'Top 5 views';}else{echo 'sorted by Date';} ?>)</h1>


                <div class="card shadow" style="border-radius: 15px;">
                    <table class="table table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th class="text-center" scope="col">Thumbnail</th>
                                <th class="text-center" scope="col">Title</th>
                                <th class="text-center" scope="col">Category</th>
                                <th class="text-center" scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!--loop to get artical results-->
                            <?php
                            for ($i = 0; $i < count($data); $i++)
                            {
                                $newArtcl = new Article();
                                $newArtcl->setArticleID($data[$i]->articleID);
                                $newArtcl->initAwithID();

                                echo
                                '
                                        <tr>
                                            <td class="text-center"><img style="height:50px" src="' . $newArtcl->getThumbnail() . '"></img></td>
                                            <td class="text-center">' . $newArtcl->getTitle() . '</td>
                                            <td class="text-center">' . $newArtcl->getCategory() . '</td>
                                            <td class="text-center">
                                                <a type="button" href="viewArticle.php?artiID=' . $newArtcl->getArticleID() . '" class="btn btn-primary"><i class="far fa-eye"></i></a>
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
</section>




<script type="text/javascript">chnageSize();</script>