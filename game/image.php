<style>
#image-screen {
    position: fixed;
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100vw;
    height: 100vh;
    z-index: 1001;
    top: 0px;
    bottom: 0px;
    left: 0px;
    right: 0px;
    background-color: rgba(0,0,0,.7);
}

#image-box {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    height: 100%;
}

#image-box > img {
    width: 80vw;
    min-height: 20vh;
    max-height: 80vh;
}

#image-box.vertical > img {
    width: unset;
    min-width: 100px;
}

#image-close {
    position: absolute;
    top: 20px;
    right: 20px;
    width: 25px;
    height: 25px;
    cursor: pointer;
}
</style>

<div id="image-screen" class="d-none">
    <div id="image-close"> 
        <svg viewBox="0 0 40 40">
            <path class="close-x" style="stroke: white" d="M 10,10 L 30,30 M 30,10 L 10,30"></path>
        </svg>
    </div>
    <div id="image-box"> 
        <img id="image-img" src="/game/img/game/background_game_1.png">
    </div>
</div>

<script>
function showImageWithSrc(src) {
    $("#image-img").attr("src", src);
    $("#image-box").toggleClass("vertical", false);
    $("#image-screen").toggleClass("d-none", false);
}

function showImageWithVerticalSrc(src) {
    $("#image-img").attr("src", src);
    $("#image-box").toggleClass("vertical", true);
    $("#image-screen").toggleClass("d-none", false);
}

function closeImage() {
    $("#image-screen").toggleClass("d-none", true);
}

$("#image-box").click(function (e) {
    if (e.currentTarget == e.target) {
        closeImage();
    }
})

$("#image-close").click(function (e) {
    closeImage();
})
</script>