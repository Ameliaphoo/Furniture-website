//add hovered class to selected list item
let list=document.querySelectorAll(".navigation li");

function activeLink()
{
    list.forEach((item)=>
    {
        item.classList.remove("hovered");
    });
    this.classList.add("hovered");
}

list.forEach((item)=>item.addEventListener("mouseover",activeLink));

//Menu Toogle
let toggle=document.querySelector(".toggle");
let navigation=document.querySelector(".navigation");
let main=document.querySelector(".main");

toggle.onclick= function()
{
    navigation.classList.toggle("active");
    main.classList.toggle("active");
}

document.addEventListener("DOMContentLoaded", function() {
    const userAvatar = document.querySelector(".dropmenu");
    const dropdownMenu = document.querySelector(".dropdown-menu");

    userAvatar.addEventListener("click", function() {
        dropdownMenu.classList.toggle("hidden"); // Toggle visibility of the dropdown menu
    });
});