function ejecutarScript() {
    var php = "status=0";
    $.ajax({
		url: '/bd/status.php',
		type: 'POST',
		dataType: 'json',
		data: php,
	})
	.done(function(res) {
	    if (res == "online") {
			}
    });
}
function verificarYEjecutar() {
    const tiempoActual = new Date().getTime();
    const tiempoUltimaEjecucion = localStorage.getItem('ultimaEjecucion');
    if (!tiempoUltimaEjecucion || (tiempoActual - tiempoUltimaEjecucion >= 5 * 60 * 1000)) {
        ejecutarScript();
        localStorage.setItem('ultimaEjecucion', tiempoActual);
    }
}
verificarYEjecutar();