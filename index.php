<?php
include './header.php';
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
<video autoplay muted loop id="mainVideo">
    <source src="assests/mainVideo.webm" type="video/webm">
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

        <div id="contentDiv">

            <div class="card mb-3" >
                <div class="row g-0">
                    <div class="col-md-4">
                        <img src="..." class="img-fluid rounded-start" alt="...">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title">Card title</h5>
                            <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                            <p class="card-text"><small class="text-body-secondary">Last updated 3 mins ago</small></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-3" >
                <div class="row g-0">
                    <div class="col-md-4">
                        <img src="..." class="img-fluid rounded-start" alt="...">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title">Card title</h5>
                            <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                            <p class="card-text"><small class="text-body-secondary">Last updated 3 mins ago</small></p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </center>
</div>

<!-- run custom scripts after all the elements are loaded -->
<script>
    chnageSize();
</script>

<?php include './footer.html'; ?>