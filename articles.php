<?php
include './header.php';

if (isset($_SESSION['roleType']) && ($_SESSION['roleType'] == 'admin' || $_SESSION['roleType'] == 'author')) {
    //article stuff - gett all articles sorted by views
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

<!--if the user is an admin or author can view all his articales -->
<section <?php if (!(isset($_SESSION['roleType']) && ($_SESSION['roleType'] == 'admin' || $_SESSION['roleType'] == 'author'))) {
    echo 'hidden';
} else {
    echo 'id="articlesPageBody"';
} ?>>
    <div class="container h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-xl-9">

                <h1 class="text-black mb-4">All Articles (sorted by views)</h1>

                

                <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                    <a type="button" class="btn btn-primary btn-sm" href="addEditArticle.php">Compose a New Article</a>
                </div>

                <div class="card shadow" style="border-radius: 15px;">
                    <div class="card-body">

                    </div>
                </div>

            </div>
        </div>
    </div>
</section>


<section <?php if (isset($_SESSION['roleType']) && ($_SESSION['roleType'] == 'admin' || $_SESSION['roleType'] == 'author')) {
    echo 'hidden';
} else {
    echo 'id="articlesPageBody"';
} ?>>
    <div class="container h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-xl-10">

                <h1 class="text-black mb-4">All Articles (sorted by views)</h1>



                <div class="card shadow" style="border-radius: 15px;">

                    <p class="text-center">You cannot use this page unless you are an Author</p>
                    <!-- add login check here and login button -->
                </div>

            </div>
        </div>
    </div>
</section>

<script type="text/javascript">chnageSize();</script>