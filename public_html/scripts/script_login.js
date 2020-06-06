var error=document.querySelector(".error");
if(error!=null)
{
    setTimeout(function() { 
        error.setAttribute("style","max-height:0px; padding:0; opacity:0;");
    }, 1500);
}