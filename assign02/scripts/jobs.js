window.addEventListener('load',
    function () {
        document.querySelector('#II222').addEventListener("click", () => {
            this.applyForJob('II222')
        });
        document.querySelector('#DEB1L').addEventListener("click", () => {
            this.applyForJob('DEB1L')
        });
    }, false
);

function applyForJob(referenceNumber) {
    localStorage.setItem('referenceNumber', referenceNumber);
}