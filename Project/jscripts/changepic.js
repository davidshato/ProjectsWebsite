"use-strict";
window.onload = imgDisplay();
function imgDisplay(){
    var arr = ["../images/painter.jpg", "../images/lion.jpg", "../images/horse.jpg"];
    var randomNum = Math.floor( ( Math.random() * 3 ) );
    //var img = document.getElementsByTagName('img').src;
    
    document.getElementsByTagName('img')[0].src = "imgs/" + arr[randomNum];
     document.getElementsByTagName('img')[0].alt = arr[randomNum];
} 

