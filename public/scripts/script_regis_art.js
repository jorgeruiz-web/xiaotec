
document.getElementById("selec_foto").addEventListener("change",function(){
    foto=this.files[0];
    if(foto){
    if(foto.type=="image/jpeg"){
        const reader=new FileReader();
        reader.onload=function(e){
            console.log("xd");
            document.querySelector("#imagen_art").src=this.result;
            document.querySelector("#imagen_art").setAttribute("style","display:block;")
        };
        reader.readAsDataURL(foto);
    }else{
        alert("La imagen debe estar en formato Jpg/Jpeg");
    }
    
}
else{
    document.querySelector("#imagen_art").src="";
    document.querySelector("#imagen_art").removeAttribute("style");
}
});

document.querySelector(".imagen_registro").addEventListener("click",function(){
    document.getElementById('selec_foto').click();
});

document.querySelector("#boton_subir_foto").addEventListener("click",function(){
    document.querySelector("#selec_foto").click();
});

document.querySelector("#boton_registrar_art").addEventListener("click",function(){
    const image=document.querySelector("#selec_foto");
    if(image.files[0])
    {

    }else{
        alert("Debes seleccionar una imagen!!");
        event.preventDefault();
    }
});
const pantalla=document.querySelector(".pantalla");
document.querySelector("#mensaje_volver").addEventListener("click",function(){
    pantalla.removeAttribute("style");
});

document.querySelector("#icono_agregar_categoria").addEventListener("click",function(){
    pantalla.setAttribute("style","opacity:1;pointer-events:all;")
});

var botones_eliminar=document.querySelectorAll(".boton_eliminar");
for (let i = 0; i < botones_eliminar.length; i++) {
    const btn = botones_eliminar[i];
    btn.addEventListener("click",function(){
        var id=btn.parentElement.parentElement.children[0].innerHTML;
        document.querySelector("#forma_categoria").setAttribute("action","/registrar_articulo/acciones/?tipo=1&id_art_edi="+id);
    });
}

document.querySelector(".boton_agregar").addEventListener("click",function(){
    document.querySelector("#forma_categoria").setAttribute("action","/registrar_articulo/acciones/?tipo=0&nombre_cat="+document.querySelector("#nombre_cat").value);
    document.querySelector("#forma_categoria").setAttribute("method","POST");
    document.querySelector("#forma_categoria").submit();
});

var rol=sessionStorage.getItem("rol");
if(rol!="admin")
{
    document.querySelector(".pantalla").setAttribute("style","opacity:1; pointer-events:all;");
    document.querySelector(".mensaje_categorias").style.display="none";
    var error_rol=document.querySelector(".error_rol");
    error_rol.setAttribute("style","bottom:-10px;");
    setTimeout(function(){
        window.location.href="/articulos";
    }, 1500)
}