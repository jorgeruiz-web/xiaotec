var infos= document.querySelectorAll(".info");
for (let i = 0; i < infos.length; i++) {
    const info = infos[i];
    info.addEventListener("click",function(){
        this.getElementsByTagName("button")[0].click();
    });
}

