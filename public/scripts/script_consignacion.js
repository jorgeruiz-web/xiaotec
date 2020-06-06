var ver=sessionStorage.getItem("ver");
if(ver=="1")
{
    try {
        sessionStorage.setItem("ver","0");
        calcular_totales();
        document.getElementById("pantalla").setAttribute("style","left:30px; top:30px;opacity:1;pointer-events:all;");
        btn_volver= document.getElementById("btn_volver");
        set_estado();
        btn_volver.addEventListener("click",function(){
        btn_volver.parentElement.parentElement.removeAttribute("style");
        });
    } catch (error) {
        document.getElementById("pantalla").removeAttribute("style");
        console.log(error);
    }
   

}

function set_estado()
{
    var ver_aux=document.querySelector("#estado_ver");
    if(ver_aux.innerHTML=="ATRASADO")
    {
        ver_aux.setAttribute("style","color:var(--filtro-hover)");
    }
    else if (ver_aux.innerHTML=="LIQUIDA HOY")
    {
        ver_aux.setAttribute("style","color:var(--boton-aceptar)");
    }

}

botones= document.getElementsByClassName("ver_articulos");
for (let i = 0; i < botones.length; i++) {
    const btn = botones[i];
    btn.addEventListener("click",function(){
        
        llenar_datos(this.parentElement);
    });
}

function llenar_datos( padre){
    var id=padre.querySelector(".ver_articulos").getAttribute("data-id");
    padre.querySelector(".id_forma").value=id;
    sessionStorage.setItem("ver","1");
    padre.submit();
    //CARGAR DATOS DE BASE DE DATOS Y LLENAR EN TABLA//
    
}

function calcular_totales()
{
    var total_de_totales=0;
    var rows_ver= document.querySelector(".articulos_ver").querySelectorAll(".row");
    for (let i = 1; i < rows_ver.length; i++) {
        const row_ver = rows_ver[i];
        var cant=parseInt(row_ver.children[2].innerHTML);
        var precio=parseInt(row_ver.children[3].innerHTML.split("$")[1]);
        var total=cant*precio;
        total_de_totales+=total;
        row_ver.children[4].innerHTML="$"+(total);
    }
    document.querySelector("#total_ver").innerHTML="$"+total_de_totales;
}



botones_accion_liquidar=document.getElementsByClassName("btn_liquidar");
for (let i = 0; i < botones_accion_liquidar.length; i++) {
    const btn = botones_accion_liquidar[i];
    btn.addEventListener("click",function(){
        this.parentElement.submit();
    });
}

botones_editar=document.querySelectorAll(".btn_editar");
for (let i = 0; i < botones_editar.length; i++) {
    const boton_editar = botones_editar[i];
    boton_editar.addEventListener("click",function(){
        sessionStorage.setItem("tipo","edit");
        this.parentElement.action="liquidar_venta/?id="+this.getAttribute("data-id=");
        this.parentElement.submit();
    });
}

document.querySelector("#boton_nueva_venta").addEventListener("click",function(){
    sessionStorage.setItem("tipo","");
});

document.querySelector(".bus").addEventListener("click",function(){
    var nombre=document.querySelector("#busqueda_nombre").value;
    var filtros_act=document.querySelector(".filtros_act");
    if(filtros_act.children.length>0)
    {
        borrar_filtros(filtros_act);
    }
    crear_filtro(nombre,filtros_act);
    
});
resetear_filtros(document.querySelector(".filtros_act"));
function resetear_filtros(padre)
{
    if(padre.children.length>0){
    padre.querySelector(".filtro").addEventListener("click",function(){
        padre.removeChild(this);
        activar_filtros(padre);
    });
    activar_filtros(padre);
}
}

function borrar_filtros(padre)
{
    padre.removeChild(padre.children[0]);
}
function crear_filtro(filtro, padre)
{
    padre.innerHTML='<button class="filtro">'+filtro+' <span>&times;</span></button>';
    resetear_filtros(padre);
    
}

function activar_filtros(padre)
{
    if(padre.children.length>0){
        var nombre_filtro=padre.querySelector(".filtro").innerHTML.split(" ")[0];
        var rows=document.querySelector(".consigna").querySelectorAll(".row");
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
        var rows=document.querySelector(".consigna").querySelectorAll(".row");
        for (let i = 1; i < rows.length; i++) {
            const row = rows[i];
            row.style.display="flex";
        }
    }
}

//BOTON BUSCAR
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

var row_contador=document.querySelector(".consigna").querySelectorAll(".row").length;
if(row_contador<=1)
{
    document.querySelector(".filtros").style.display="none";
    document.querySelector(".consigna").style.display="none";
}

estados_consi=document.querySelectorAll(".estados_consi");
for (let i = 0; i < estados_consi.length; i++) {
    const estados = estados_consi[i];
    if(estados.innerHTML=="ATRASADO")
    {
        estados.setAttribute("style","color:var(--filtro-hover)");
    }
    else if (estados.innerHTML=="LIQUIDA HOY")
    {
        estados.setAttribute("style","color:var(--boton-aceptar)");
    }
}