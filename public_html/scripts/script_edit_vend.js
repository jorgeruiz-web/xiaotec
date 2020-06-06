
/*document.getElementById('prueba').value=id;

/*

var recarga=localStorage.getItem("recarga");
if(recarga=='0')
{
    localStorage.setItem("recarga",'1');
    document.getElementById("forma_prueba").submit();
}

boton=document.querySelector("#descartar");
boton.addEventListener("click",function(){
    window.location.replace("vendedores.php");
});
*/

document.querySelector("#descartar").addEventListener("click",function(){
    window.history.back();
});

var rol=sessionStorage.getItem("rol");
if(rol!="admin")
{
    window.location.href="/vendedores.php";
}