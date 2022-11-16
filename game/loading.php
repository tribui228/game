<style>
#loading-screen {
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

.loader {
    border: 8px solid #f3f3f3;
    border-top: 8px solid #3498db;
    border-radius: 50%;
    width: 50px;
    height: 50px;
    animation: spin 2s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>

<div id="loading-screen" class="d-none">
    <div class="loader"> </div>
</div>

<script>
function showLoading() {
    $("#loading-screen").toggleClass("d-none", false);
}

function closeLoading() {
    $("#loading-screen").toggleClass("d-none", true);
}
</script>