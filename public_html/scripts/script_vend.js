var botones=document.getElementsByClassName("editar");
var rol=sessionStorage.getItem("rol");
for (let i = 0; i < botones.length; i++) {
    const element = botones[i];
    element.addEventListener('click',function(){
        if(rol=="admin")
        {
            var id=element.parentElement.parentElement.children[0].innerHTML;
            localStorage.setItem("id_vend",id);
            localStorage.setItem("recarga",'0');
            location.href = "edit_vend?"+"id="+id;
        }
        else{
            activar_error();
        }

    });
}

var bool_actual_agregar=0;

document.querySelector("#agregar_visualizar").addEventListener("click",function(){
    var formulario= document.querySelector(".agregar").getElementsByTagName("form")[0];
    if(bool_actual_agregar==0)
    {
        bool_actual_agregar=1;
        this.innerHTML="Ocultar "+ '<i class="fas fa-eye-slash"></i>';
        formulario.removeAttribute("class");
    }
    else{
        this.innerHTML="Visualizar "+'<i class="fas fa-eye"></i>';
        bool_actual_agregar=0;
        formulario.setAttribute("class","oculto");
    }
    
   
});

var pantalla=document.querySelector(".pantalla");

document.querySelector("button[name=eliminar_cancelar]").addEventListener("click",function(){
    pantalla.removeAttribute("style");
});

var botones_eliminar=document.querySelectorAll(".eliminar");
for (let i = 0; i < botones_eliminar.length; i++) {
    
    
    const boton_eliminar = botones_eliminar[i];
    boton_eliminar.addEventListener("click",function(){
        if(rol=="admin")
        {
            var row=boton_eliminar.parentElement.parentElement;
            var id=row.children[0].innerHTML;
            var nombre=row.children[1].innerHTML;
            document.querySelector("#eliminar_nombre").innerHTML=nombre;
            document.querySelector("input[name=nombre_oculto]").value=id;
            pantalla.setAttribute("style","opacity:1;pointer-events:all;") 
            forma_eliminar= document.querySelector("#form_eliminar");
            forma_eliminar.action="/vendedores/eliminar?id_vend="+boton_eliminar.value;
        }
        else{
            activar_error();
        }
        
    });
}

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
        var rows=document.querySelector(".usuarios").querySelectorAll(".row");
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
        var rows=document.querySelector(".usuarios").querySelectorAll(".row");
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

document.querySelector("#boton_agregar").addEventListener("click",function(){
  
    if(rol=="admin")
    {
        if(document.querySelector("#nombre").value!=""&&document.querySelector("#direccion").value!=""&&
        document.querySelector("#telefono").value!=""&&document.querySelector("#rfc").value!="")
        {
            this.parentElement.parentElement.submit();
        }
        else{
            alert("jaja");
        }
    }
    else{
      activar_error();
    }
});

function activar_error()
{
    var error_rol=document.querySelector(".error_rol");
    error_rol.setAttribute("style","bottom:-10px;");
    setTimeout(function(){
        error_rol.removeAttribute("style");
    }, 1500)
}

var estados=document.querySelectorAll(".estados_vend");
for (let i = 0; i < estados.length; i++) {
    const estado= estados[i];
    if(estado.innerHTML=="activo"){
        estado.setAttribute("style","color:green");
        estado.innerHTML="Activo";
    }
    else{
        estado.setAttribute("style","color:var(--filtro-hover)");
        estado.innerHTML="Baja";
    }
}

document.querySelector(".des_excel").addEventListener("click",function(){
    window.open('/vendedores/reporte');
});