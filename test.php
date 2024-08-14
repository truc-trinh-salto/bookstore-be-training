
<style>
    #hidden-social-container {
    width: 200px;
    height: 32px;
    position: relative;
    top: 20px;
    left: 40px;
    overflow: hidden;
}

#hidden-social {
    width: 145px;
    animation: 1s slide-right;
}

@keyframes slide-left {
    from {
        margin-left: 0%;
    }
    to {
        margin-left: -100%;
        display: none;
    }
}

.social-icon-2 {
    width: 25px;
}

.social-icon-p2 {
    width: 15px;
}
</style>

<button onclick="myFunction()">Click Me</button>


<div id="hidden-social-container">
    <div id="hidden-social"  style="display:none;">

        <span>A</span>

        <span>B</span>

        <span>C</span>

        <span>D</span>

        <span>E</span>
    </div>
</div>

<script>
    function myFunction() {
    var x = document.getElementById("hidden-social");

    x.addEventListener("animationend", function(e) {
        e.preventDefault();

        if(x.style.animationName == "slide-left") {
            x.style.display = "none";
        }
    });

    if (x.style.display === "none") {
        x.style.display = "block";
        x.style.animation = "1s slide-right";
    }
    else {
        x.style.animation = "1s slide-left";
    }
}
</script>