var tipo;
var quitar;
var codigos=new Array();
var precios=new Array();
var total=0;
var inputs= document.getElementsByClassName("check");



for (let i = 0; i < inputs.length; i++) {
    const inp = inputs[i];
    
    inp.addEventListener("change",function(){
        
        tipo=(inp.parentElement.children[1].innerHTML);
        limpiar();
        if(inp.checked)
        {
            for (let j = 0; j < inputs.length; j++) {
                const inp_aux = inputs[j];
                if(inp!=inp_aux)
                {
                    inp_aux.checked=false;
                }
                else{
                    
                    desocultar(tipo);
                }
            }
        }
        else{
            inp.checked=true;
        }
    });
}

function activar_art()
{
    document.querySelector(".articulos").className="articulos";
    document.querySelector(".botones").className="botones";
}
function desactivar_art()
{
    document.querySelector(".articulos").className="articulos oculto";
    document.querySelector(".botones").className="botones oculto";
}

function desocultar(ti)
{
    if(ti=="Consignacion")
    {
        document.querySelector(".consignacion").className="consignacion";
        document.querySelector(".contado").className="contado oculto";
        desactivar_art();
    }
    else{
        document.querySelector(".contado").className="contado";
        document.querySelector(".consignacion").className="consignacion oculto";
        activar_art();
    }
}
//SELECCIONAR PRODUCTOS
rows= document.querySelector('.artic').children;

for (let i = 1; i < rows.length; i++) {
    const row_selec = rows[i];
    row_selec.addEventListener("click",function(){
        //ELIMINAR MENSAJE
        if(document.querySelector(".mensaje")!=null)
        {
            var cant_clss=document.querySelector(".mensaje").classList.length;
            console.log(cant_clss);
            if(cant_clss==1){
                document.querySelector(".mensaje").setAttribute("class","mensaje quitar_mensaje");
            }
            else{
                var padre=document.querySelector(".mensaje").parentElement;
                padre.removeChild(document.querySelector(".mensaje"));
            }
        }
        var codigo=row_selec.children[1].innerHTML;
        var nombre=row_selec.children[2].innerHTML;
        var precio=row_selec.children[3].innerHTML;
        var stock=row_selec.children[4].innerHTML;
        tabla=document.querySelector('.sel');
        tabla.innerHTML=tabla.innerHTML+'<div class="row">'+
        '<div class="row_item">'+codigo+'</div>'+
        '<div style="width:35%" class="row_item">'+nombre+'</div>'+
        '<div style="width:15%" class="row_item">'+
            '<span style="margin-right: 2px;" class="editor">-</span>'+
            '<div data-cant="'+stock+'" class="cant">1</div>'+
            '<span style="margin-left: 2px;" class="editor">+</span>'+
        '</div>'+
        '<div class="row_item">'+precio+'</div>'+
        '<div style="width: 10%" class="row_item eliminar"> &times; </div>'+
        '</div>';
        row_selec.className="row quitar";
        row_selec.setAttribute("style","border-bottom:none; min-height: 0px; align-items:normal;");
        leer_editores();
        total+=parseInt(precio.split('$')[1]);
        document.querySelector("#total_selec").innerHTML="$"+total;
    });
}



//SUMAR INPUTS
leer_editores();
function leer_editores()
{
    quitar=document.getElementsByClassName("eliminar");
    leer_quitar();
    var editores=document.getElementsByClassName("editor");
    for (let i = 0; i < editores.length; i++) {
        const edit =  editores[i];
        edit.addEventListener("click",function(){
            var max=parseInt(edit.parentElement.querySelector(".cant").getAttribute("data-cant"));
            const tipo=edit.innerHTML;
            var cant=edit.parentElement.getElementsByTagName("div")[0].innerHTML;
            
            switch (tipo) {
                case '+':
                    
                    cant=parseInt(cant)+1;
                    if(cant>max)
                    {
                        cant=max;
                        alert("No Stock");
                    }
                    break;
            
                case '-':
                    cant=parseInt( cant)-1;
                    break;
            }
            if(cant<1)cant=1;
            if(cant>999)cant=999;
            edit.parentElement.getElementsByTagName("div")[0].innerHTML=cant;
            calcular_precio(edit.parentElement);
        });
    }
}
function calcular_precio(padre){
   
    var codigo=padre.parentElement.children[0].innerHTML;
    var pre;
    for (let i = 0; i < codigos.length; i++) {
        const code_guardado = codigos[i];
        if(code_guardado==codigo)
        {
            pre=precios[i].split('$')[1];
        }
    }

    
    var cant=padre.getElementsByTagName("div")[0].innerHTML;
    
   
    var total=pre*cant;
    padre.parentElement.children[3].innerHTML='$'+parseInt(total);
    
    calcular_total();
    
}
function calcular_total()
{
    total=0;
    var sel_row=document.querySelector(".sel").getElementsByClassName("row");
    for (let i = 1; i < sel_row.length; i++) {
        const row_sel = sel_row[i];
        var pre=row_sel.children[3].innerHTML.split('$')[1];
        console.log(pre);
        total+=parseInt(pre);
    }
    document.querySelector("#total_selec").innerHTML="$"+total;
}
function leer_quitar(){
    for (let i = 0; i < quitar.length; i++) {
        const quit = quitar[i];
        quit.addEventListener("click",function(){
            const padre=quit.parentElement;
            var id=padre.children[0].innerHTML;
            var prec=padre.children[3].innerHTML.split("$")[1];
            total-=parseInt(prec);
            document.querySelector("#total_selec").innerHTML="$"+total;
            reaparecer(id);
            padre.parentElement.removeChild(padre);
        });
    }
}
function reaparecer(id){
    for (let i = 0; i < rows.length; i++) {
        const row = rows[i];
        var id_row=row.children[1].innerHTML;
        if(id==id_row)
        {
            row.className="row";
            row.setAttribute("style","");
        }
    }
}


guardar_datos();
function guardar_datos()
{
    const articulos=document.getElementsByClassName("artic")[0].getElementsByClassName("row");
    
    for (let i = 1; i < articulos.length; i++) {
        const art = articulos[i];
        codigos.push( art.querySelector(".cod_pro").innerHTML);
        precios.push( art.querySelector(".pre_pro").innerHTML);
    }
    
}



var tipo=sessionStorage.getItem("tipo");
if(tipo=="edit")
{
    var id=sessionStorage.getItem("id");
    var nombre=sessionStorage.getItem("nombre");
    document.querySelector("#check1").checked=true;
    document.querySelector(".informacion").setAttribute("style","display:none;")
    document.querySelector(".consignacion").setAttribute("class","consignacion bordeado");
    document.querySelector(".articulos").setAttribute("class","articulos");
    document.querySelector(".botones").setAttribute("class","botones");
    var tabla=document.querySelector(".consignacion").querySelector(".tabla");
    tabla.setAttribute("style","display:none;");
    document.querySelector(".consignacion").querySelector(".busqueda").setAttribute("style","display:none;");
}

document.querySelector("#cancelar").addEventListener("click",function(){
    window.history.back();
});