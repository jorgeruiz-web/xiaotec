

var botones_aceptar= document.querySelector(".info_facturacion").getElementsByTagName("button");
botones_aceptar[1].disabled=true;

var editores=document.querySelectorAll(".editor");
for (let i = 0; i < editores.length; i++) {
    const edit = editores[i];
    
    edit.addEventListener("click",function(){
        
        cambiar_cant(edit.parentElement,edit.innerHTML);
        agregar_art_vend();
    });
}

function cambiar_cant(padre, tipo)
{
    var input_cant= padre.getElementsByTagName("div")[0];
    var cant_actual=parseInt(input_cant.innerHTML);
    var cant_limite= parseInt(padre.parentElement.getElementsByClassName("row_item")[3].innerHTML);
    switch (tipo) {
        case "+":
            cant_actual+=1;
            if(cant_actual>=cant_limite)
            {
                cant_actual=cant_limite;
            }
            break;
    
        case "-":
            cant_actual-=1;
            if(cant_actual<=0)
            {
                cant_actual=0;
            }
            break;
    }
    calcular_total(padre.parentElement, cant_actual);
    input_cant.innerHTML=cant_actual;   
}

function agregar_art_vend()
{
    const articulos_vendidos=document.querySelector(".articulos_vendidos");
    articulos_vendidos.innerHTML="";
    var rows=document.querySelector(".articulos").querySelector(".tabla").querySelectorAll(".row");
    var cont=0;
    for (let i = 1; i < rows.length; i++) {
        const row = rows[i];
        var cant= parseInt(row.children[4].querySelector(".cant").innerHTML);
        if(cant>0){
            var id=row.children[0].innerHTML;
            articulos_vendidos.innerHTML+= '<input value="'+id+'" id="art_id_'+id+'" name="conf_articulos[id]['+cont+']" type="text">'
            +'<input value="'+cant+'" id="art_cant_'+id+'" name="conf_articulos[cantidad]['+cont+']" type="text"> <div class="break"></div>';
            cont++;
        }    
    }
    
}

var info_comi= parseInt(document.querySelector("#info_comision").innerHTML.split("%")[0]);
var precio_pagar;

function calcular_total(row, cantidad_vendida){
    var precio_unidad=parseInt(row.getElementsByClassName("row_item")[2].innerHTML.split("$")[1]);
    var total=precio_unidad*cantidad_vendida;
    var porcentaje_pagar=100-info_comi;
    
    row.getElementsByClassName("total_total")[0].innerHTML="$"+total;
    row.getElementsByClassName("pre_total")[0].innerHTML="$"+Math.round((total*(porcentaje_pagar/100)));
    row.getElementsByClassName("com_final")[0].innerHTML="$"+Math.round((total*(info_comi/100)));
    facturar_venta();
}
facturar_venta();
function facturar_venta()
{
    var total=0;
    var tabla= document.getElementsByClassName("articulos")[0].getElementsByClassName("tabla")[0];
    var tabla_rows=tabla.getElementsByClassName("row");
    for (let i = 1; i < tabla_rows.length; i++) {
        const row_tabla = tabla_rows[i];
        var precio=parseInt(row_tabla.getElementsByClassName("total_total")[0].innerHTML.split("$")[1]);
        total+=precio;
    }
    calcular_comision(total);
    precio_pagar=total;
    var porcentaje_pagar=100-info_comi;
    document.querySelector("#total_facturacion").innerHTML="$"+Math.round( (total*(porcentaje_pagar/100)));
    document.querySelector("#comision_facturacion").innerHTML="$"+Math.round( (total*(info_comi/100)));
    document.querySelector("#venta_facturacion").innerHTML="$"+total;
    if(total>0)
    {
       
        botones_aceptar[0].disabled=false;
        botones_aceptar[1].disabled=false;
    }
    else{
        botones_aceptar[1].disabled=true;
    }
}

function calcular_comision(total)
{
    if(tipo_liquidacion=="parcial")
    {
        info_comi="45";
    }
    else{
        if (total<=1500) {
            info_comi=45;
        }
        else if(total<3000)
        {
            info_comi=50;
        }
        else{
            info_comi=55;
        }
    }
    document.querySelector("#info_comision").innerHTML=info_comi+"%";
}

var tipo_liquidacion="completa";
var checkbox=document.querySelectorAll("input[type=checkbox]");
checkbox[1].checked=true;
for (let i = 0; i < checkbox.length; i++) {
    const check = checkbox[i];
    check.addEventListener("change",function(){
        tipo_liquidacion=check.id.split("_")[0];
        facturar_venta();
        if(tipo_liquidacion=="parcial")
        {
            document.querySelector(".abono").removeAttribute("style");
            
        }
        else{
            document.querySelector(".abono").setAttribute("style","max-height: 0px;")
        }
        for (let j = 0; j < checkbox.length; j++) {
            const check2 = checkbox[j];
            if(check2!=check)
            {
                check2.checked=false;
            }
        }
    });
}

//BOTONES




document.querySelector("#cancelar_confirmacion").addEventListener("click",function(){
    document.querySelector(".pantalla").removeAttribute("style");
});
document.querySelector("#aceptar_confirmacion").addEventListener("click",function(){

        
});

document.querySelector("#aceptar_facturacion").addEventListener("click",function(){
    facturar_venta();
    var info=document.querySelector(".informacion");
    
    var comi_vend=document.querySelector("#comision_facturacion").innerHTML.split('$')[1];
    document.querySelector("#comision_vendedor").value=comi_vend;
    var nombre=info.querySelector("#info_vend").innerHTML;
    var id=document.querySelector("#num_liquidar").innerHTML;
    precio_pagar=(precio_pagar*((100-info_comi)/100));
    var info_mensaje=document.querySelector(".mensaje_confirmar");
    info_mensaje.querySelector("#confirmar_id").innerHTML=id;
    info_mensaje.querySelector("#confirmar_nombre").innerHTML=nombre;
    info_mensaje.querySelector("#confirmar_tipo").value=tipo_liquidacion;
    if(tipo_liquidacion=="parcial")
    {
        var cant_abonar= parseInt(document.querySelector("#cantidad_abono").value);
        
        if(cant_abonar==0||cant_abonar>precio_pagar||cant_abonar=="")
        {
            if(parseInt(cant_abonar)>parseInt(precio_pagar))
            {
                document.querySelector(".error_parcial").innerHTML="El abono debe ser menor al pago total";
            }
            else{
                document.querySelector(".error_parcial").innerHTML="Ingrese la cantidad a abonar";
            }
            document.querySelector(".error_parcial").removeAttribute("style");
            setTimeout(function() { 
                document.querySelector(".error_parcial").setAttribute("style","max-height:0px;");
             }, 1500);
        }
        else{
            document.querySelector("#confirmar_deuda_label").removeAttribute("style");
            document.querySelector("#confirmar_deuda").value=Math.round((precio_pagar-cant_abonar));
            info_mensaje.querySelector("#confirmar_total").value=Math.round(cant_abonar);
            document.querySelector(".pantalla").setAttribute("style","opacity:1;pointer-events:all;");
            document.querySelector("#label_convenio").style.display="block";
            document.querySelector("#convenio_deuda").innerHTML=document.querySelector("#confirmar_deuda").value;
        }
    }
    else{
        document.querySelector("#label_convenio").style.display="none";
        document.querySelector("#confirmar_deuda_label").setAttribute("style","display:none;");
        info_mensaje.querySelector("#confirmar_total").value= Math.round(precio_pagar);
        document.querySelector(".pantalla").setAttribute("style","opacity:1;pointer-events:all;");
    }
   
    

    
});
console.log(document.querySelector("#cancelar_facturacion"));
document.querySelector("#cancelar_facturacion").addEventListener("click",function(){
    //VOLVER A PAGINA ANTERIOR
    window.history.back();
});

