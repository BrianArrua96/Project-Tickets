let precioSuma = 0,
    precio = 1,
    contador = 0,
    contadorSession = 0,
    contadorEntrada = 0,
    precioTotal = 0;
let entradasArray = [];
let entradas;
let sessiones;
let nuevoDivEntrada = true;
let FinEach = true;
let AñadirArray = true;

const divEntradas = document.getElementById("entradas");
const maxEntradas = document.getElementById("cantidad");
const mostrarMax = document.getElementById("escogerCantidad");
const buttonEntrada = document.getElementById("reservarEntrada");
const total = document.getElementById("precioTotal");
const DivListaEntradas = document.getElementById("listaEntradas");
const containerList = document.getElementById("containerList");
const divError = document.getElementById("errorCantidad");
const mensajeError = document.getElementById("mensajeError");

function pad(numero) {
    return numero < 10 ? "0" + numero : numero;
}

function convertirFormato(fechaHoraString) {
    const fechaHora = new Date(fechaHoraString);
    const año = fechaHora.getFullYear();
    const mes = pad(fechaHora.getMonth() + 1);
    const dia = pad(fechaHora.getDate());
    const hora = pad(fechaHora.getHours() - 5); // Ajuste de la diferencia horaria
    const minuto = pad(fechaHora.getMinutes());
    const segundo = pad(fechaHora.getSeconds());

    return `${año}-${mes}-${dia}T${hora}:${minuto}:${segundo}`;
}

function obtenerSiguienteHora(fechaHoraString) {
    const fechaHora = new Date(fechaHoraString);
    fechaHora.setHours(fechaHora.getHours() + 1);
    const año = fechaHora.getFullYear();
    const mes = pad(fechaHora.getMonth() + 1);
    const dia = pad(fechaHora.getDate());
    const hora = pad(fechaHora.getHours());
    const minuto = pad(fechaHora.getMinutes());
    const segundo = pad(fechaHora.getSeconds());

    return `${año}-${mes}-${dia} ${hora}:${minuto}:${segundo}`;
}

function compararFechas(a, b) {
    let fechaA = new Date(a.data);
    let fechaB = new Date(b.data);

    return fechaA - fechaB;
}

function crearEventos(Session) {
    let eventos = [];
    let cont = 1;
    // Crea eventos para diferentes horas en el día
    Session.forEach((fechaSession) => {
        let siguienteHora = obtenerSiguienteHora(fechaSession.data);
        let evento = {
            title: `${cont} Session`,
            start: `${convertirFormato(fechaSession.data)}`,
            end: `${convertirFormato(siguienteHora)}`,
        };
        eventos.push(evento);
        cont++;
    });
    return eventos;
}
function verMaximEntradas(max, Session, Entrada) {
    FinEach = true;
    if (entradasArray.length !== 0) {
        entradasArray.forEach((entrada) => {
            if (FinEach) {
                if (
                    entrada.contadorSession === Session &&
                    entrada.contadorEntrada === Entrada
                ) {
                    FinEach = false;
                    if (entrada.Maxcantidad <= 0) {
                        max = 0;
                    } else {
                        max = entrada.Maxcantidad;
                    }
                }
            }
        });
    }
    vermax(max);
    return max;
}
function vermax(entrada) {
    if (entrada <= 0) {
        mostrarMax.textContent = `Escoge otra entrada, esta entrada esta agotada`;
        maxEntradas.max = 0;
        cantidad = 0;
    } else {
        mostrarMax.textContent = `Escoge el numero de entradas (Max ${entrada})`;
    }
}

function reiniciarEntradas() {
    contador = 0;
    containerList.innerHTML = " ";
    entradasArray.forEach((entrada) => {
        const DivEntrada = document.createElement("div");
        DivEntrada.id = contador;
        DivEntrada.classList.add("entrada-lista");
        containerList.appendChild(DivEntrada);

        const nuevoDiv = document.createElement("div");
        DivEntrada.appendChild(nuevoDiv);
        let entradaP = document.createElement("p");
        entradaP.textContent = `${entrada.nom}`;
        let cantidadP = document.createElement("p");
        cantidadP.textContent = `x${entrada.cantidad}`;

        nuevoDiv.appendChild(entradaP);
        nuevoDiv.appendChild(cantidadP);

        const btnBorrar = document.createElement("button");
        btnBorrar.id = contador;
        btnBorrar.type = "button";
        btnBorrar.classList.add("btn-red");
        btnBorrar.classList.add("btn");
        btnBorrar.textContent = "eliminar";
        // Añadir el nuevo div al container
        contador++;
        DivEntrada.appendChild(btnBorrar);
        btnBorrar.addEventListener("click", function () {
            let calculadorEntradasMaximas =
                entradasArray[DivEntrada.id].cantidad +
                entradasArray[DivEntrada.id].Maxcantidad;
            precioTotal -=
                parseInt(entradasArray[DivEntrada.id].cantidad) *
                parseFloat(entradasArray[DivEntrada.id].precio).toFixed(2);
            total.textContent = `Total: ${precioTotal}€`;
            if (
                parseInt(entradas[3]) ===
                parseInt(entradasArray[DivEntrada.id].contadorEntrada)
            ) {
                mostrarMax.textContent = `Escoge el numero de entradas (Max ${calculadorEntradasMaximas})`;
                maxEntradas.max = calculadorEntradasMaximas;
            }

            entradasArray.splice(parseInt(DivEntrada.id), 1);
            DivEntrada.remove();
            reiniciarEntradas();
        });
    });
}

function sessionSelect(ArraySession) {
    entradasArray.splice(0, entradasArray.length);
    containerList.innerHTML = " ";
    precioTotal = 0;
    total.textContent = `Total: ${precioTotal}€`;
    divEntradas.style.display = "grid";
    if (contadorSession !== 0) {
        document.getElementById(contadorSession).style.display = "none";
        document.getElementById(contadorSession).value = "";
        mostrarMax.textContent = " ";
    }
    contadorSession = parseInt(ArraySession.id);
    document.getElementById(contadorSession).style.display = "block";
    document
        .getElementById(contadorSession)
        .addEventListener("change", function () {
            entradas = document
                .getElementById(contadorSession)
                .value.split(`,`);
            precio = parseFloat(entradas[0]).toFixed(2);
            contadorEntrada = parseInt(entradas[3]);
            maxEntradas.max = verMaximEntradas(
                parseInt(entradas[1]),
                contadorSession,
                contadorEntrada
            );
        });
    sessiones = ArraySession;
}
function ActivarEntrada() {
    document.getElementById(contadorSession).style.display = "block";
}
function esNumero(valor) {
  return !isNaN(parseFloat(valor)) && isFinite(valor);
}

buttonEntrada.addEventListener("click", function (e) {
    e.preventDefault;
    if(!esNumero(maxEntradas.max)){
      maxEntradas.max=entradas[1];
    }
    if (document.getElementById(contadorSession).value) {
        if (parseInt(maxEntradas.max) <= 0) {
            mensajeError.textContent = `Entradas Agotadas`;
            divError.style.display = "block";
            // Ocultar el div después de 3 segundos
            setTimeout(function () {
                divError.style.display = "none";
            }, 3000);
        } else if (parseInt(maxEntradas.max) < parseInt(maxEntradas.value)) {
            mensajeError.textContent = `La cantidad escogida supera la máxima, escoge un número inferior a ${maxEntradas.max}`;
            divError.style.display = "block";
            // Ocultar el div después de 3 segundos
            setTimeout(function () {
                divError.style.display = "none";
            }, 3000);
        } else if (parseInt(maxEntradas.value) <= 0) {
            mensajeError.textContent = "La cantidad escogida es inferior a 1";
            divError.style.display = "block";
            // Ocultar el div después de 3 segundos
            setTimeout(function () {
                divError.style.display = "none";
            }, 3000);
        } else if (maxEntradas.value > parseInt(entradas[1])) {
            mensajeError.textContent = `La cantidad escogida supera la máxima, escoge un número inferior a ${entradas[1]}`;
            divError.style.display = "block";
            // Ocultar el div después de 3 segundos
            setTimeout(function () {
                divError.style.display = "none";
            }, 3000);
        } else {
            divError.style.display = "none";
            AñadirArray=true;
            console.log("koala");
            entradasArray.forEach((Arrayes) => {
                FinEach = true;
                if (FinEach) {
                    if (parseInt(entradas[3]) === Arrayes.contadorEntrada) {
                      console.log("cada");
                        if (parseInt(maxEntradas.value) > parseInt(Arrayes.Maxcantidad)) {
                          mensajeError.textContent = `La cantidad escogida supera la máxima, escoge un número inferior a ${Arrayes.Maxcantidad}`;
                          divError.style.display = "block";
                          // Ocultar el div después de 3 segundos
                          setTimeout(function () {
                              divError.style.display = "none";
                          }, 3000);
                          FinEach = false;
                        AñadirArray=false;
                        } 
                    }
                }
            });
            if (AñadirArray) {
                let divReserva = {
                    session: sessiones.data,
                    nom: entradas[2],
                    cantidad: parseInt(maxEntradas.value),
                    contadorSession: contadorSession,
                    contadorEntrada: contadorEntrada,
                    Maxcantidad: parseInt(
                        parseInt(maxEntradas.max) - parseInt(maxEntradas.value)
                    ),
                    precio: precio,
                    nominal: entradas[4],
                };
                if (entradasArray.length > 0) {
                    FinEach = true;
                    entradasArray.forEach((entrada) => {
                        if (FinEach) {
                            if (
                                entrada.contadorSession ===
                                    divReserva.contadorSession &&
                                entrada.contadorEntrada ===
                                    divReserva.contadorEntrada
                            ) {
                                entrada.cantidad =
                                    entrada.cantidad + divReserva.cantidad;
                                entrada.Maxcantidad =
                                    entrada.Maxcantidad - divReserva.cantidad;
                                maxEntradas.max = entrada.Maxcantidad;
                                vermax(parseInt(maxEntradas.max));
                                nuevoDivEntrada = false;
                                FinEach = false;
                            } else {
                                nuevoDivEntrada = true;
                            }
                        }
                    });
                    if (nuevoDivEntrada === true) {
                        maxEntradas.max = divReserva.Maxcantidad;
                        vermax(maxEntradas.max);
                        entradasArray.push(divReserva);
                    }
                } else {
                    maxEntradas.max = divReserva.Maxcantidad;
                    vermax(maxEntradas.max);
                    entradasArray.push(divReserva);
                }
                DivListaEntradas.style.display = "block";
                precioSuma = precio * maxEntradas.value;
                precioTotal += precioSuma;
                reiniciarEntradas();
                total.textContent = `Total: ${precioTotal}€`;
            }
        }
    } else {
        mensajeError.textContent = "Escoge una entrada";
        divError.style.display = "block";
        // Ocultar el div después de 3 segundos
        setTimeout(function () {
            divError.style.display = "none";
        }, 3000);
    }
});

document.getElementById("bottonCompra").addEventListener("click", function (e) {
    e.preventDefault();
    document.getElementById("arrayEntradas").value =
        JSON.stringify(entradasArray);
    document.getElementById("inputTotal").value = precioTotal;
    if (sessiones.estado===true) {
      if (entradasArray.length > 0) {
        document.getElementById("ComprarEntrada").submit();
    }
    }else{
      document.getElementById("estado").style.display = "block";
      setTimeout(function () {
        document.getElementById("estado").style.display = "none";
      }, 5000);
    }
    

});
