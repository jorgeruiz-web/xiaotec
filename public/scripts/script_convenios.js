var estado_visualizar=0;
document.querySelector(".finalizados").setAttribute("style"," max-height: 0; padding:0; flex-wrap:nowrap");
var botones_porcentaje=document.querySelector(".info_abonar").querySelector(".porcentajes").getElementsByTagName("a");
for (let i = 0; i < botones_porcentaje.length; i++) {
    const porce = botones_porcentaje[i];
    porce.addEventListener("click",function(){
        var porcentaje=porce.innerHTML.split("%")[0];
        var deuda_act=document.querySelector("#info_abono_deuda_act").innerHTML.split("$")[1];
        document.querySelector("#info_abono_abono").value=Math.round(deuda_act*(porcentaje/100));
    });
}

document.querySelector(".info_cancelar").addEventListener("click",function(){
    document.querySelector(".pantalla").removeAttribute("style");
});

var botones_abonar=document.querySelectorAll(".boton_abonar");
for (let i = 0; i < botones_abonar.length; i++) {
    const boton_abonar = botones_abonar[i];
    boton_abonar.addEventListener("click",function(){
        
        var row=boton_abonar.parentElement.parentElement;
        var id=row.children[0].innerHTML;
        var nombre=row.children[1].innerHTML;
        var deuda=row.children[4].innerHTML;
        
        var pantalla_abono= document.querySelector(".pantalla").querySelector(".info_abonar");
        pantalla_abono.querySelector("#info_abono_id").value=id;
        pantalla_abono.querySelector("#info_abono_nombre").innerHTML=nombre;
        pantalla_abono.querySelector("#info_abono_deuda_act").innerHTML=deuda;
       

        pantalla_abono.parentElement.setAttribute("style","opacity:1; pointer-events:all;");
        pantalla_abono.parentElement.querySelector(".ver_abonos").setAttribute("style","opacity:0;pointer-events:none;");
        document.querySelector(".mensaje_eliminar").setAttribute("style","opacity:0;pointer-events:none;");
        pantalla_abono.parentElement.querySelector(".info_abonar").removeAttribute("style");
    });
}





var botones_ver_abonos=document.querySelectorAll(".boton_ver_abonos");
for (let i = 0; i < botones_ver_abonos.length; i++) {
    const boton_ver_abonos =  botones_ver_abonos[i];
    boton_ver_abonos.addEventListener("click",function(){
        sessionStorage.setItem("ver",1);
        if(this.getAttribute("data-tipo")=="fin")
        {
            sessionStorage.setItem("fin",1);
        }
        else{
            sessionStorage.setItem("fin",0);
        }
        this.parentElement.children[0].submit();
    });
}

var ver= sessionStorage.getItem("ver");
if(ver==1)
{
    sessionStorage.setItem("ver",0);
    if(sessionStorage.getItem("fin")==1)
    {
        estado_visualizar=1;
        document.querySelector(".finalizados").removeAttribute("style");
        sessionStorage.setItem("fin",0)
    }

    
    
    calcular_abonos();
    prender_ver();
}

function prender_ver()
{
    document.querySelector(".pantalla").setAttribute("style","opacity:1; pointer-events:all;");
    document.querySelector(".info_abonar").setAttribute("style","opacity:0;pointer-events:none;");
    document.querySelector(".mensaje_eliminar").setAttribute("style","opacity:0;pointer-events:none;");
    document.querySelector(".ver_abonos").removeAttribute("style");

    document.querySelector(".ver_abonos_boton_volver").addEventListener("click",function(){
        document.querySelector(".pantalla").removeAttribute("style");
    });
}

function calcular_abonos()
{
    var abonos=document.querySelector(".ver_abonos").querySelector(".tabla").querySelectorAll(".row");
    var deuda=parseInt(document.querySelector("#ver_abonos_deuda_ini").innerHTML.split('$')[1]);
    var aux_actual=deuda;
    for (let i = 1; i < abonos.length; i++) {
        const abo = abonos[i];
        var cant_abono=parseInt(abo.children[1].innerHTML.split("$")[1]);
        var restante=aux_actual-cant_abono;
        abo.children[2].innerHTML="$"+restante;
        aux_actual=restante;
        
    } 
    if(aux_actual>0)
    {
        document.querySelector("#ver_abonos_estado").innerHTML="Pendiente";
        document.querySelector("#ver_abonos_deuda_act").innerHTML="$"+aux_actual;
    }
    else{
        document.querySelector("#ver_abonos_estado").innerHTML="Pagado";
        document.querySelector("#ver_abonos_estado").style.color="green";
        document.querySelector("#ver_abonos_deuda_act").parentElement.style.display="none";

    }
    
}



document.querySelector("#finalizados_visualizar").addEventListener("click",function(){
    
    if(estado_visualizar==0)
    {
        estado_visualizar=1;
        this.innerHTML="Ocultar "+'<i class="fas fa-eye-slash"></i>';
        document.querySelector(".finalizados").removeAttribute("style");
    }
    else{
        estado_visualizar=0;
        this.innerHTML="Visualizar "+'<i class="fas fa-eye"></i>';
        document.querySelector(".finalizados").setAttribute("style"," max-height: 0; padding:0; flex-wrap:nowrap; transform: translateY(-20px);");
    }
    
});

//ABONAR
document.querySelector(".info_Aceptar").addEventListener("click",function(){
    var deuda= parseInt(document.querySelector(".info_Aceptar").parentElement.querySelector("#info_abono_deuda_act").innerHTML.split("$")[1]);
    var abono=parseInt(document.querySelector("#info_abono_abono").value);
    console.log(abono);
    if(abono!=""&&abono!=NaN&&abono>0)
    {
        if(abono>deuda)
        {
            alert("No puedes abonar mayor a la deuda");
        }
        else{
            this.parentElement.submit();
        }
    }
    else{
        alert("Introduzca la cantidad a abonar");
    }
   
});

var botones_eliminar=document.querySelectorAll(".boton_eliminar");

for (let i = 0; i < botones_eliminar.length; i++) {
    const boton_eliminar = botones_eliminar[i];
    boton_eliminar.addEventListener("click",function(){
        var id=this.getAttribute("data-id");
        document.querySelector("#mensaje_id").innerHTML=id;
        document.querySelector(".pantalla").setAttribute("style","opacity:1; pointer-events:all;");

        document.querySelector(".mensaje_eliminar").action="/convenios/eliminar?id="+id;
        document.querySelector(".mensaje_eliminar").removeAttribute("style");
        document.querySelector(".info_abonar").setAttribute("style","opacity:0;pointer-events:none;");
        document.querySelector(".ver_abonos").setAttribute("style","opacity:0;pointer-events:none;");

    });
}

document.querySelector("#mensaje_cancelar").addEventListener("click",function(){
    document.querySelector(".pantalla").removeAttribute("style");
});


var rows_act=document.querySelector(".activos").querySelectorAll(".row");
for (let i = 1; i < rows_act.length; i++) {
    const row = rows_act[i];
    var deuda=parseInt(row.children[2].innerHTML.split('$')[1]);
    var abonos=parseInt(row.children[3].innerHTML.split('$')[1]);
    row.children[4].innerHTML='$'+(deuda-abonos);
}

var row_contador=document.querySelector(".activos").querySelectorAll(".row").length;
if(row_contador<=1)
{
    estado_visualizar=1;
    document.querySelector("#finalizados_visualizar").innerHTML="Ocultar "+'<i class="fas fa-eye-slash"></i>';
    document.querySelector(".finalizados").removeAttribute("style");

    document.querySelector(".activos").style.display="none";
}