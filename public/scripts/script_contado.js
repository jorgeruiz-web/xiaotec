if(document.querySelector("#btn_volver")){
document.querySelector("#btn_volver").addEventListener("click",function(){
    document.querySelector(".pantalla").removeAttribute("style");
});


var pantalla= document.querySelector(".pantalla");
var condi=sessionStorage.getItem("ver");
if(condi=="1")
{
    pantalla.setAttribute("style","opacity:1;pointer-events:all;");
    var detalles= document.querySelector(".pantalla").querySelector(".detalles");
    pantalla.querySelector(".detalles").removeAttribute("style");
    pantalla.querySelector(".mensaje_archivar").setAttribute("style","opacity:0;pointer-events:none;");
    detalles.querySelector("#detalles_id").innerHTML=id_venta;
    sessionStorage.setItem("ver","0");
    
}
else if(condi=="2")
{
   pantalla.setAttribute("style","opacity:1;pointer-events:all;");
   pantalla.querySelector(".mensaje_archivar").removeAttribute("style");

   var id_archivar=sessionStorage.getItem("id_archivar")

   var forma_archivar= document.querySelector("#forma_archivar");
   forma_archivar.querySelector("#nombre_oculto").value=id_archivar;

   pantalla.querySelector(".detalles").setAttribute("style","opacity:0;pointer-events:none;");
   sessionStorage.setItem("ver","0");
   document.querySelector("#mensaje_id").innerHTML=id_archivar;
  
}
else{
    document.querySelector(".pantalla").removeAttribute("style");
}

document.querySelector("button[name=eliminar_cancelar]").addEventListener("click",function(){
    this.parentElement.parentElement.parentElement.setAttribute("style","opacity:0;pointer-events:none;");
});
contar_totales();
}

function contar_totales()
{
    var rows=document.querySelector(".artic").querySelectorAll(".row");
    for (let i = 1; i < rows.length; i++) {
        const row= rows[i];
        var cantidad=parseInt(row.querySelector(".row_cantidad").innerHTML);
        var precio=parseInt(row.querySelector(".row_precio").innerHTML.split('$')[1]);
        var total=cantidad*precio;
        row.querySelector(".row_total").innerHTML='$'+total;
    }
}
var botones_ver=document.querySelectorAll(".boton_ver");
for (let i = 0; i < botones_ver.length; i++) {
    const btn = botones_ver[i];
    btn.addEventListener("click",function(){
        var id=btn.parentElement.parentElement.children[0].innerHTML;
        document.querySelector("#id_venta").value=id;
        document.querySelector("#tipo_venta").value='ver';
        sessionStorage.setItem("ver","1");
        
        document.querySelector("#forma_id").submit();
    });
}
var padre_filtros=document.querySelector(".filtros_act");
document.querySelector(".bus").addEventListener("click",function(){
    var busqueda=document.querySelector("#busqueda_nombre").value;
    
    if(busqueda!=NaN&&busqueda!=null&&busqueda.length>0)
    {
        borrar_filtros();
        padre_filtros.innerHTML= '<button class="filtro">'+busqueda+'<span>&times;</span></button>';
        document.querySelector("#busqueda_nombre").value="";
        activar_filtros(busqueda);
        reinciar_filtro();
    }
});

function borrar_filtros()
{
    if(padre_filtros.children.length>0){
        padre_filtros.removeChild(padre_filtros.children[0]);
    }
}

reinciar_filtro();
function reinciar_filtro(){
    if(document.querySelectorAll(".filtro").length>0)
    {
        document.querySelector(".filtro").addEventListener("click",function(){
            this.parentElement.removeChild(this);
            activar_filtros("");
        });
    }
}

function activar_filtros(nombre_filtro){
    var rows=document.querySelector(".liquidaciones").querySelectorAll(".row");
    if(nombre_filtro.length>0)
    {
    for (let i = 1; i < rows.length; i++) {
        const row = rows[i];
        var id=row.children[0].innerHTML;
        var nombre=row.children[1].innerHTML;
        var test=new RegExp(nombre_filtro.toUpperCase());
        var resul1=test.test(id.toUpperCase());
        var resul2=test.test(nombre.toUpperCase());
        console.log(resul1+","+resul2);
        if(!resul1&&!resul2)
        {
            row.style.display="none";
        }
        else{
            row.style.display="flex";
        }
    }
}
else{
    for (let i = 0; i < rows.length; i++) {
        const row = rows[i];
        row.style.display="flex";
    }
}
}

botones_archivar=document.querySelectorAll(".boton_archivar");
for (let i = 0; i < botones_archivar.length; i++) {
    const btn = botones_archivar[i];
    btn.addEventListener("click",function(){
        var id=this.getAttribute("data-id");
        document.querySelector("#id_venta").value=id;
        sessionStorage.setItem("ver","2");
        sessionStorage.setItem("id_archivar",id);
        document.querySelector("#forma_id").submit();
    });
}



var input = document.getElementById("busqueda_nombre");

// Execute a function when the user releases a key on the keyboard
input.addEventListener("keyup", function(event) {
  // Number 13 is the "Enter" key on the keyboard
  if (event.keyCode === 13) {
    // Cancel the default action, if needed
    event.preventDefault();
    // Trigger the button element with a click
    document.querySelector(".bus").click();
  }
});

document.querySelector("#archivados").addEventListener("click",function(){
    window.location.href="archivados";
});