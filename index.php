<?php
include './header.php';
?>

<!-- MOVE TO HOME PAGE -->
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

<!-- MOVE TO HOME PAGE -->
<video autoplay muted loop id="mainVideo">
    <source src="assests/mainVideo.webm" type="video/webm">
</video>

<!-- MOVE TO HOME PAGE -->
<div>
    <div id="mainDiv" style="height: 50%">
        make this a top part (main stuff)
    </div>

    <center>
        <div id="contentDiv" style="width: 80%; height: 1800px; background-color: rgba(0,0,0,0.6); box-shadow: 0 0 12px 10px rgba(0, 0, 0, 0.6);">

        </div>
    </center>
</div>

<!-- run custom scripts after all the elements are loaded -->
<script>chnageSize();</script>

<?php include './footer.html'; ?>