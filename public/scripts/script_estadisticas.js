

//GRAFICA

var equis2=equis;


var trace1 = {
    x: equis,
    y: ye,
    type: 'scatter',
    name: "Consignacion"
  };
  
  var trace2 = {
    x: equis,
    y: ye2,
    type: 'scatter',
    name: "Contado"
  };
  
  var data = [trace1, trace2];
  
Plotly.newPlot("grafico",data);


////
var sel_dias=document.querySelector("#sel_dias");
sel_dias.addEventListener("change",function(){
  sessionStorage.setItem("dias",this.value);
  window.location.href="/estadisticas?dias="+this.value;
});

sumar_ventar();

function sumar_ventar()
{
  var ventas_consi=parseFloat(document.querySelector("#ingresos_consi").innerHTML.split('$')[1]);
  var ventas_conta=parseFloat(document.querySelector("#ingresos_conta").innerHTML.split('$')[1]);
  var total=ventas_consi+ventas_conta;
  document.querySelector("#ingresos_total").innerHTML="$"+total;
}

var dias=sessionStorage.getItem("dias");
if(dias==null)dias=7;

var opciones=document.querySelector("#sel_dias").querySelectorAll("option");
for (let i = 0; i < opciones.length; i++) {
  const opcion = opciones[i];
  if(opcion.value==dias)
  {
    opcion.setAttribute("selected","selected");
  }
  else{
    opcion.removeAttribute("selected");
  }
}
