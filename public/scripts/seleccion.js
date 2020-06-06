var path = window.location.pathname;
var page = path.split("/").pop();
page=page.split(".")[0];
console.log(page);
var elementos=document.getElementsByClassName("elemento");
for (let i = 0; i < elementos.length; i++) {
    const element = elementos[i];
    if (page==element.id) {
        element.classList.add("seleccion");
        element.parentElement.classList.add("abierto");
        element.children[0].querySelector(".ele2").style.color="var(--boton-aceptar)";
        if(element.parentElement.classList[0]=="submenu")
        {
            element.parentElement.parentElement.children[0].children[0].getElementsByTagName("span")[0].innerHTML="-";
            element.parentElement.parentElement.style.backgroundColor="#343e4d";
        }
    }
    else{
        switch (page) {
            case "liquidar_venta":
                document.querySelector("#consignacion").classList.add("seleccion");
                document.querySelector("#consignacion").parentElement.classList.add("abierto");
                break;
            case "nueva_venta":
                document.querySelector("#consignacion").classList.add("seleccion");
                document.querySelector("#consignacion").parentElement.classList.add("abierto");
                break;
            case "edit_vend":
                document.querySelector("#vendedores").classList.add("seleccion");
                break;
            default:
                element.classList.remove("seleccion");
                break;
        }
        
    }
}

var menus= document.querySelectorAll(".elemento");
for (let i = 0; i < menus.length; i++) {
    const menu = menus[i];
    if(menu.children.length>1)
    {
        menu.addEventListener("click",function(){
            var submenu=menu.children[1];
            console.log(submenu.classList);
            if(submenu.classList.length>1)
            {
                submenu.classList.remove("abierto");
                menu.children[0].children[0].getElementsByTagName("span")[0].innerHTML="+";
            }
            else{
            submenu.classList.add("abierto");
            menu.children[0].children[0].getElementsByTagName("span")[0].innerHTML="-";
            }
        });
    }
}


document.querySelector("#imagen_logo_menu").addEventListener("click",function(){
    window.location.href="/inicio";
});