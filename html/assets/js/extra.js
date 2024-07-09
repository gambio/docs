const main = document.getElementsByClassName("md-nav md-nav--primary");
const bar = document.getElementsByClassName("md-sidebar__inner");
const side = document.getElementsByClassName("md-nav md-nav--secondary");


for (let i = 0; i < side.length; i++){
	bar[0].appendChild(side[i]);
}

const right = document.getElementsByClassName("md-nav md-nav--secondary");

right[1].style.display = "none";

main[0].style.display = "none";
