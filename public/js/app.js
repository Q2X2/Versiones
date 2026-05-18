function login(){

let texto = document.getElementById("loginInput").value;

if(texto === "TurnosTrabajadores"){
    window.location.href="turnos.html";
}

else if(texto.length < 6){
    window.location.href="estado-vehiculo.html";
}

else if(texto.length >=6 && texto.length <12){
    window.location.href="registro-vehiculo.html";
}

else{
    alert("Entrada no válida");
}

}