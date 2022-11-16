<style>
#modal-screen {
    position: fixed;
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100vw;
    height: 100vh;
    z-index: 1000;
    top: 0px;
    bottom: 0px;
    left: 0px;
    right: 0px;
    background-color: rgba(0,0,0,.7);
}

#modal-box {
    position: relative;
    background-color: var(--sub-color);
    padding: 2rem;
    width: 100%;
    border-radius: 2px;
    max-height: 100vh;
    max-width: 600px;
}

#modal-close {
    position: absolute;
    top: 20px;
    right: 20px;
    width: 25px;
    height: 25px;
    cursor: pointer;
}

#modal-header {
    font-size: 1.5rem;
    margin-bottom: 0.5rem;
    font-weight: 600;
    line-height: 1.2;
}

#modal-body {
    overflow-y: auto;
    overflow-x: hidden;
}

#modal-content {
    display: flex;
    flex-flow: column;
    max-height: calc(100vh - 4rem);
    padding: 4px;
}

.modal-text {
    font-size: 1.2rem;
    font-weight: 600;
}
</style>

<div id="modal-screen" class="d-none">
    <div id="modal-box"> 
        <div id="modal-close"> 
            <svg viewBox="0 0 40 40">
                <path class="close-x" d="M 10,10 L 30,30 M 30,10 L 10,30"></path>
            </svg>
        </div>
        <div id="modal-content">
        </div>
    </div>
</div>

<script>
function showModal() {
    $("#modal-screen").toggleClass("d-none", false);
}

function closeModal() {
    $("#modal-screen").toggleClass("d-none", true);
}

$("#modal-screen").mousedown(function(e) {
    if (e.target == e.currentTarget) {
        if (window.confirm("Are you sure to close?")) {
            closeModal();
        }
    }
});

$("#modal-close").click(function(e) {
    closeModal();
});
</script>