export function toggleMenu() {
    var $hamburger = $(".hamburger");

    $hamburger.on("click", function(e) {
        $hamburger.toggleClass("is-active");
    });
};