var rol=sessionStorage.getItem("rol");
document.querySelector("#vaciar").addEventListener("click",function(){
    if(rol=="admin")
    {
        document.querySelector(".pantalla").setAttribute("style","top:30px ;left:30px; opacity: 1; pointer-events:all;");
    }
    else{
        activar_error();
    }
});
document.querySelector("#cancelar").addEventListener("click",function(){
    document.querySelector(".pantalla").removeAttribute("style");
});

document.querySelector("#borrartodo").addEventListener("click",function(){
    window.location.href="/historial/eliminar";
});


function activar_error()
{
    var error_rol=document.querySelector(".error_rol");
    error_rol.setAttribute("style","bottom:-10px;");
    setTimeout(function(){
        error_rol.removeAttribute("style");
    }, 1500)
}

document.querySelector(".des_excel").addEventListener("click",function(){
    window.open('/historial/reporte');
});