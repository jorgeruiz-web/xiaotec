var vendedores= document.querySelector(".consignacion").querySelector(".tabla").getElementsByClassName("row");
var vendedor_select=Array("","");
for (let i = 1; i < vendedores.length; i++) {
    const vendedor = vendedores[i];

    if(tipo!="edit"){
    vendedor.addEventListener("click",function(){
        activar_art();
        vendedor.getElementsByTagName("i")[0].setAttribute("style","opacity:1;");   
        vendedor.setAttribute("style","background-color: #ebebeb;border-left: solid 1px #262d373b;border-right: solid 1px #262d373b;");
        vendedor.setAttribute("data-seleccion","true");
        var nombre=vendedor.getElementsByClassName("row_item")[1].innerHTML;
        
        var id=vendedor.getElementsByClassName("row_item")[0].innerHTML;
        vendedor_select[0]=id;
        vendedor_select[1]=nombre;
        
        for (let j = 1; j < vendedores.length; j++) {
            const vend2 = vendedores[j];
            if(vend2!=vendedor)
            {
                vend2.removeAttribute("style");
                vend2.setAttribute("data-seleccion","false");
                vend2.querySelector("i").removeAttribute("style");
            }
        }
    });
}
}
var check_anony=document.querySelector("#anony");
check_anony.addEventListener("change",function(){
    if(check_anony.checked)
    {
       document.querySelector("#contado_nombre").disabled=true;
    }
    else{
        document.querySelector("#contado_nombre").disabled=false;
    }
});

document.querySelector("#aceptar").addEventListener("click",function(){
    //VALIDACIONES
    if(total!=0)
    {
        switch (tipo) {
            case "Consignacion":
                if(vendedor_select[0]!="")
                {
                    mandar_articulos();
                    mostrar_confirmacion();  
                }
                else{
                    alert("Debes seleccionar un vendedor");
                }
                break;
        
            case "Contado":
                var nomb=document.querySelector("#contado_nombre").value
                var anony_check=document.querySelector("#anony");
                if(nomb.length>0||anony_check.checked)
                {
                    if(!anony_check.checked)
                    {
                    vendedor_select[1]=nomb;
                    }else{
                        vendedor_select[1]="Anonimo";
                    }
                    mandar_articulos();
                    mostrar_confirmacion_contado();
                    
                }
                else{
                    alert("Debes llenar los datos del cliente");
                }
                break;
        }
        
    }
    else{
        alert("Seleccione primero los articulos a llevar");
    }
    
    
});

function mandar_articulos()
{
    var receptor= document.querySelector(".articulos_confirmar");
    receptor.innerHTML="";
    var sel_row=document.querySelector(".sel").getElementsByClassName("row");
    var input_tipo=document.querySelector("#confirmar_tipo_venta");
    var input_id=document.querySelector("#confirmar_id_cliente");
    if(document.querySelector("#check1").checked)
    {
        var id_vend;
        input_tipo.value="consignacion";
        document.querySelector("#confirmar_tipo_venta").innerHTML="Confirmar Consignación";
        var rows_vendedores= document.querySelector(".vendedores_tabla").querySelectorAll(".row");
        for (let i = 1; i < rows_vendedores.length; i++) {
            const row_vend = rows_vendedores[i];
            if(row_vend.getAttribute("data-seleccion")=="true")
            {
                id_vend=row_vend.children[1].innerHTML;
                break;
            }
        }
        input_id.value=id_vend;
    }
    else{
        if(document.querySelector("#anony").checked)
        {
            input_id.value="Anonimo";
        }
        else{
            input_id.value=document.querySelector("#contado_nombre").value;
        }
        input_tipo.value="contado";
        document.querySelector("#confirmar_tipo_venta").innerHTML="Confirmar Venta Contado";
        
    }
    
    for (let i = 1; i < sel_row.length; i++) {
        const row = sel_row[i];
        var id=row.children[0].innerHTML;
        var cantidad=row.children[2].querySelector(".cant").innerHTML;
        receptor.innerHTML=receptor.innerHTML+' <input value="'+id+'" id="art_id_'+id+'" name="conf_articulos[id]['+(i-1)+']" type="text">'
        +'<input value="'+cantidad+'" id="art_cant_'+id+'" name="conf_articulos[cantidad]['+(i-1)+']" type="text">'
        
    }
}

function mostrar_confirmacion()
{
    
    document.querySelector(".pantalla").setAttribute("style","opacity:1; pointer-events:all;");
    document.querySelector(".mensaje_confirmar").querySelector("#conf_total").innerHTML="$"+total;                
    document.querySelector(".mensaje_confirmar").querySelector("#conf_vend").innerHTML=vendedor_select[1]; 
    document.querySelector(".mensaje_confirmar").querySelector("#conf_venta").innerHTML="Consignar";  
    document.querySelector(".mensaje_confirmar").querySelector("#conf_tipo").innerHTML="Vendedor";   
}

function mostrar_confirmacion_contado()
{
    document.querySelector(".pantalla").setAttribute("style","opacity:1; pointer-events:all;");
    document.querySelector(".pantalla").querySelector(".mensaje_confirmar").querySelector("#conf_total").innerHTML="$"+total;                
    document.querySelector(".pantalla").querySelector(".mensaje_confirmar").querySelector("#conf_vend").innerHTML=vendedor_select[1];
    document.querySelector(".mensaje_confirmar").querySelector("#conf_venta").innerHTML="Vender";  
    document.querySelector(".mensaje_confirmar").querySelector("#conf_tipo").innerHTML="Cliente";       
}

document.querySelector("#conf_cancelar").addEventListener("click",function(){
    document.querySelector(".pantalla").removeAttribute("style");
    
});


function limpiar()
{
    vendedor_select[0]="";
    vendedor_select[1]="";
    for (let j = 1; j < vendedores.length; j++) {
        const vend2 = vendedores[j];
        
        vend2.removeAttribute("style");
        vend2.querySelector("i").removeAttribute("style");
        
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
    var rows=document.querySelector(".vendedores_tabla").querySelectorAll(".row");
    if(nombre_filtro.length>0)
    {
    for (let i = 1; i < rows.length; i++) {
        console.log(nombre_filtro);
        const row = rows[i];
        var id=row.children[1].innerHTML;
        var nombre=row.children[2].innerHTML;
        var telefono=row.children[3].innerHTML;
        var test=new RegExp(nombre_filtro.toUpperCase());
        var resul1=test.test(id.toUpperCase());
        var resul2=test.test(nombre.toUpperCase());
        var resul3=test.test(telefono.toUpperCase());
        if(!resul1&&!resul2&&!resul3)
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