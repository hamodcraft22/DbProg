<?php
include './header.php';

$canView = true;
$viewError = '';

$data = null;


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

                <h1 class="text-black mb-4">Search Results(sorted by views)</h1>


                <div class="card shadow" style="border-radius: 15px;">
                    <table class="table table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th class="text-center" scope="col">ID</th>
                                <th class="text-center" scope="col">Thumbnail</th>
                                <th class="text-center" scope="col">Title</th>
                                <th class="text-center" scope="col">Category</th>
                                <th class="text-center" scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            for ($i = 0; $i < count($data); $i++)
                            {
                                $newArtcl = new Article();
                                $newArtcl->setArticleID($data[$i]->articleID);
                                $newArtcl->initAwithID();

                                echo
                                '
                                        <tr>
                                            <th class="text-center" scope="row">' . $newArtcl->getArticleID() . '</th>
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