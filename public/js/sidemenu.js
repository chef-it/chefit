var originalContainerMargin = getComputedStyle(document.getElementById("container")).marginRight;

/* Set the width of the side navigation to 250px and the left margin of the page content to 250px and add a black background color to body */
function openMenu() {
    document.getElementById("container").style.marginRight = "150px";
    document.getElementById("sideMenu").style.width = "300px";

}

/* Set the width of the side navigation to 0 and the left margin of the page content to 0, and the background color of body to white */
function closeMenu() {
    document.getElementById("sideMenu").style.width = "0";
    document.getElementById("container").style.marginRight = originalContainerMargin;
    document.getElementById("sideMenu").style.right = "-1px";
    document.getElementById("sideMenu2").style.width = "0";
    document.getElementById("sideMenu2").style.right = "-1px";
}

/* Set the width of the side navigation to 250px and the left margin of the page content to 250px and add a black background color to body */
function openMenu2() {
    document.getElementById("sideMenu2").style.width = "200px";
    document.getElementById("sideMenu").style.right = "199px";
}

/* Set the width of the side navigation to 0 and the left margin of the page content to 0, and the background color of body to white */
function closeMenu2() {
    document.getElementById("sideMenu2").style.width = "0";
    document.getElementById("sideMenu").style.right = "-1px";
}

function selectVendor() {
    document.getElementById("vendor").value
}