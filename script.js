function ajax(metodos, url) {
	var xmlhttp = new XMLHttpRequest();
	var respuesta = '';
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			imprimirTarjetas(JSON.parse(this.responseText))
		}
	};
	xmlhttp.open(metodos, url, true);
	xmlhttp.send();
	return respuesta;
}

ajax('GET', './empanada.php');


function imprimirTarjetas(datos) {
    document.querySelector('.empanadas').innerHTML=""
	for (i in datos.empanadas) {
		agregarTarjeta(datos.empanadas[i].fecha, datos.empanadas[i].cantidad);
    }
    document.querySelector("#total").innerHTML = datos.total;
    document.querySelector("#fechaModf").innerHTML = datos.fechaModificacion;
}

function crearTarjeta(fecha, cantidad) {
	let tarjeta = '<div class="tarjeta">';
	tarjeta += ' <div></div>';
	tarjeta += ' <p>' + fecha + '</p>';
	tarjeta += '<p>Cantidad <span>' + cantidad + '</span></p></div>';
	return tarjeta;
}

function agregarTarjeta(fecha, cantidad) {
	document.querySelector('.empanadas').innerHTML += crearTarjeta(fecha, cantidad);
}

document.querySelector('#registro').addEventListener('click', function(event) {
	event.preventDefault();
	const cantidad = document.querySelector('#cantidad').value;
	console.log(cantidad);
	console.log(cantidad);
	ajax('GET', './empanada.php?cantidad='+cantidad);
});
