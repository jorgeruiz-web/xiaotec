var rol=sessionStorage.getItem("rol");
var articulos=document.getElementsByClassName('boton_edicion');
var pantalla=document.querySelector('.pantalla');
/*BOTON DESCARTAR*/
document.querySelector("#descartar_edicion").addEventListener("click",function(){
    pantalla.setAttribute("style","");
});
/*BOTON GUARDAR*/

for (let i = 0; i < articulos.length; i++) {
    const art = articulos[i];
    art.addEventListener("click",function(){
        var info=(art.parentElement.getElementsByTagName("span"));
        var precio=info[1].innerHTML;
        var id=info[0].innerHTML;
        var stock=art.parentElement.querySelector('.art_stock').value;
        var categoria=art.parentElement.querySelector('.art_categoria').value;
        precio=precio.split("$")[1];
        var nombre=art.parentElement.getElementsByTagName("h3")[0].innerHTML;
        

        var imagen=art.parentElement.parentElement.getElementsByClassName("imagen")[0].getElementsByClassName("imagen_art")[0].src;
        
        document.querySelector('#precio_edicion').value=precio;
        document.querySelector('#nombre_edicion').value=nombre;
        document.querySelector('#img_edit').src=imagen;
        document.querySelector('#cantidad_edicion').value=stock;
        document.querySelector('#id_edicion').value=id;
        set_selected(categoria);
        
        pantalla.setAttribute("style","opacity:1;pointer-events:all;");

    });
    
}

function set_selected(texto)
{
    var select1=document.querySelector("#categoria_edicion");
    var opciones=select1.getElementsByTagName("option");
    for (let i = 0; i < opciones.length; i++) {
        const opcion = opciones[i];
        if(opcion.value.toUpperCase()==texto.toUpperCase())
        {
            opcion.setAttribute("selected","true");
            
        }
        else
        {
            opcion.removeAttribute("selected");
        }
    }
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
    var rows=document.querySelector(".articulos").querySelectorAll(".articulo");
    if(nombre_filtro.length>0)
    {
    for (let i = 0; i < rows.length; i++) {
        const row = rows[i];
        var id=row.getElementsByClassName("info_art")[0].children[3].innerHTML;
        var nombre=row.getElementsByClassName("info_art")[0].children[0].innerHTML;
        var test=new RegExp(nombre_filtro.toUpperCase());
        var resul1=test.test(id.toUpperCase());
        var resul2=test.test(nombre.toUpperCase());
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

var articulos_focus=document.querySelectorAll(".articulo");
console.log(articulos_focus);
for (let i = 0; i < articulos_focus.length; i++) {
    const art = articulos_focus[i];
    art.addEventListener("click",function(){
        if(rol=="admin")
        {
            art.querySelector(".info_art").getElementsByTagName("button")[0].click();
        }
        else{
            activar_error();
        }
    });
}

document.querySelector("#eliminar_edicion").addEventListener("click",function(){
    document.querySelector(".confirmar_cambios").setAttribute("style","max-height:100px;");
    document.querySelector("#tipo_boton_edicion").value="eliminar";
    document.querySelector("#lbl_tipo").innerHTML="¿Eliminar?"
    apagar_inputs();
});

document.querySelector("#confirmar_no").addEventListener("click",function(){
    document.querySelector(".confirmar_cambios").removeAttribute("style");
    
    prender_inputs();
});

document.querySelector("#guardar_edicion").addEventListener("click",function(){
    document.querySelector(".confirmar_cambios").setAttribute("style","max-height:100px;");
    document.querySelector("#tipo_boton_edicion").value="editar";
    document.querySelector("#lbl_tipo").innerHTML="¿Guardar?"
  //  apagar_inputs();
});

function apagar_inputs()
{
  
    document.querySelector('#precio_edicion').disabled=true;
    document.querySelector('#nombre_edicion').disabled=true;
    document.querySelector('#img_edit').disabled=true;
    document.querySelector('#cantidad_edicion').disabled=true;
    document.querySelector('#categoria_edicion').disabled=true;
}
function prender_inputs(){
    document.querySelector('#precio_edicion').disabled=false;
    document.querySelector('#nombre_edicion').disabled=false;
    document.querySelector('#img_edit').disabled=false;
    document.querySelector('#cantidad_edicion').disabled=false;
    document.querySelector('#categoria_edicion').disabled=false;
}

//imagen_editar
document.querySelector(".imagen_edicion").addEventListener("click",function(){
    document.querySelector("#imagen_edicion").click();
});

document.getElementById("imagen_edicion").addEventListener("change",function(){
    foto=this.files[0];
    if(foto){
    if(foto.type=="image/jpeg"){
        const reader=new FileReader();
        reader.onload=function(e){
            document.querySelector("#img_edit").src=this.result;
        };
        reader.readAsDataURL(foto);
    }else{
        alert("La imagen debe estar en formato Jpg/Jpeg");
    }
    
}
else{
    document.querySelector("#img_edit").src="";
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
document.querySelector(".des_excel").addEventListener("click",function(){
    window.open('/articulos/reporte');
});