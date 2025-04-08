document.getElementById("btn_registro").addEventListener("click", registro);
document.getElementById("btn_login").addEventListener("click", login);
window.addEventListener("resize", ancho);
//Declarando varibales
var formulario_login = document.querySelector('.formulario__login');
var formulario_registro = document.querySelector('.formulario__registro');
var contenedor_login_registro = document.querySelector('.contenedor__login-registro');
var caja_login = document.querySelector('.caja__login');
var caja_registro = document.querySelector('.caja__registro');

 function ancho()   {
    if(window.innerWidth > 850){
        caja_registro.style.display = "block";
        caja_login.style.display = "block";
    }else{
        caja_registro.style.display = "block";
        caja_registro.style.opacity = "1";
        caja_login.style.display = "none";
        formulario_login.style.display = "block";
        formulario_registro.style.display = "none";
        contenedor_login_registro.style.left = "0px";
    }
 }
ancho();
function registro(){
    if(window.innerWidth > 850){
    formulario_registro.style.display = "block";
    contenedor_login_registro.style.left = "410px";
    formulario_login.style.display = "none";
    caja_login.style.opacity = "1";
    caja_registro.style.opacity = "0";
    }else{
    formulario_registro.style.display = "block";
    contenedor_login_registro.style.left = "0px";
    formulario_login.style.display = "none";
    caja_registro.style.display = "none";
    caja_login.style.display = "block";
    caja_login.style.opacity = "1";
    }
}
function login(){
    if(window.innerWidth > 850){
    formulario_registro.style.display = "none";
    contenedor_login_registro.style.left = "10px";
    formulario_login.style.display = "block";
    caja_login.style.opacity = "0";
    caja_registro.style.opacity = "1";
    }else{
    formulario_registro.style.display = "none";
    contenedor_login_registro.style.left = "0px";
    formulario_login.style.display = "block";
    caja_registro.style.display = "block";
    caja_login.style.display = "none";
    }
}