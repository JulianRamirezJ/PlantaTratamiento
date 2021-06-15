/*Animacion para el boton de descargar manual de usuario*/
var boton = document.querySelector("#manual");
function overmouse(){
	boton.style.width = "350px";
	boton.style.transition = "2s width linear";
}
function outmouse(){
    /*boton.style.cssText = "font-size: 1rem;background-color:#007bff;border: 1px solid transparent;padding: .375rem .75rem;border-radius: .25rem;line-height: 1.5;transition:all 2s linear";*/
    boton.style.width = "290px";
    boton.style.transition = "2s width linear";
}

/*Animacion para el boton de inciar sesión*/
var inicio = document.querySelector("#inicioses");
function overinicio(){
   inicio.style.padding = "80px";
   inicio.style.transition = "2s all linear"
}
function outinicio(){

}