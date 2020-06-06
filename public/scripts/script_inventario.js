
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
    var rows=document.querySelector(".tabla").querySelectorAll(".row");
    if(nombre_filtro.length>0)
    {
    for (let i = 1; i < rows.length; i++) {
        const row = rows[i];
        var id=row.children[0].innerHTML;
        var nombre=row.children[1].innerHTML;
        console.log(id);
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

calcular_precios();

function calcular_precios(){
    var rows=document.querySelector("#articulos_inventario").querySelectorAll(".row");
    for (let i = 1; i < rows.length; i++) {
        const row = rows[i];
        var precio=parseInt(row.children[4].innerHTML.split("$")[1]);
        var stock=parseInt(row.children[3].innerHTML);
        console.log(precio+","+stock);
        var total=precio*stock;
        console.log(total);
        row.children[5].innerHTML="$"+total;
    }
}

calcular_todo();

function calcular_todo(){
    var rows=document.querySelector("#articulos_inventario").querySelectorAll(".row");
    var articulos=0;
    articulos=rows.length-1;
    var stock=0;
    var sin_stock=0;
    var total_inventario=0;
    for (let i = 1; i < rows.length; i++) {
        const row = rows[i];
        var stock_art=parseInt(row.children[3].innerHTML);
        var precio_inv=parseInt(row.children[5].innerHTML.split("$")[1]);
        if(stock_art<=10)
        {
            sin_stock+=1;
        }
        
        stock+= stock_art;
        total_inventario+=precio_inv;
        
       
    }
    document.querySelector("#info_articulos_activos").innerHTML=articulos;
    document.querySelector("#info_stock").innerHTML=stock;
    document.querySelector("#info_sin_stock").innerHTML=sin_stock;
    document.querySelector("#info_costo_inv").innerHTML=total_inventario;
}