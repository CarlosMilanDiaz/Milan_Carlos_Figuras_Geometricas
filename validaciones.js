/* ============================================================
   validaciones.js
   Todo el JavaScript del proyecto en un único archivo.
   - Validación de formularios con eventos (blur y submit)
   - Mensajes de error en rojo creados y borrados con el DOM
   - Vista previa actualizada con el DOM
   ============================================================ */

/* ---------- Funciones comunes de mensajes de error (DOM) ---------- */

// Crea (o reutiliza) un <span> rojo justo debajo del campo y le pone el texto
function mostrarError(campo, mensaje) {
    let span = document.getElementById("error-" + campo.id);

    if (!span) {
        span = document.createElement("span");
        span.id = "error-" + campo.id;
        span.className = "mensaje-error";
        campo.insertAdjacentElement("afterend", span);
    }

    span.textContent = mensaje;
    campo.classList.add("invalido");
    campo.classList.remove("valido");
}

// Elimina del DOM el mensaje de error del campo
function borrarError(campo) {
    const span = document.getElementById("error-" + campo.id);
    if (span) {
        span.remove();
    }
    campo.classList.remove("invalido");
    campo.classList.add("valido");
}

/* ---------- Validaciones de cada tipo de campo ---------- */

// Selector de figura (index.php)
function validarFigura(campo) {
    const figurasPermitidas = ["Triángulo", "Rectángulo", "Cuadrado", "Círculo"];

    if (campo.value === "") {
        mostrarError(campo, "Debes seleccionar una figura.");
        return false;
    }
    if (!figurasPermitidas.includes(campo.value)) {
        mostrarError(campo, "La figura seleccionada no es válida.");
        return false;
    }
    borrarError(campo);
    return true;
}

// Lados / radio (datos.php)
function validarLado(campo) {
    const nombre = campo.dataset.nombre;               // "Lado 1", "Radio"...
    campo.value = campo.value.trim().replace(",", ".");  // aceptamos coma decimal
    const valor = campo.value;

    // Formato: número positivo con hasta 2 decimales (ej: 5, 5.5, 5.25)
    const formato = /^\d+(\.\d{1,2})?$/;

    if (valor === "") {
        mostrarError(campo, nombre + " es obligatorio.");
        return false;
    }
    if (!formato.test(valor)) {
        mostrarError(campo, nombre + " debe ser un número positivo con un máximo de 2 decimales (ej: 5 o 5.25).");
        return false;
    }
    if (parseFloat(valor) <= 0) {
        mostrarError(campo, nombre + " debe ser mayor que 0.");
        return false;
    }
    if (parseFloat(valor) > 10000) {
        mostrarError(campo, nombre + " no puede ser mayor que 10000.");
        return false;
    }

    borrarError(campo);
    return true;
}

// Desigualdad triangular: cada lado debe ser menor que la suma de los otros dos
function validarTriangulo() {
    const c1 = document.getElementById("lado1");
    const c2 = document.getElementById("lado2");
    const c3 = document.getElementById("lado3");

    const formato = /^\d+(\.\d{1,2})?$/;
    if (!formato.test(c1.value) || !formato.test(c2.value) || !formato.test(c3.value)) {
        return true; // hasta que los tres sean válidos no se comprueba
    }

    const a = parseFloat(c1.value);
    const b = parseFloat(c2.value);
    const c = parseFloat(c3.value);

    if (a + b <= c || a + c <= b || b + c <= a) {
        mostrarError(c3, "Con estos lados no se puede formar un triángulo (cada lado debe ser menor que la suma de los otros dos).");
        return false;
    }

    borrarError(c3);
    return true;
}

/* ---------- Vista previa con DOM (datos.php) ---------- */

function actualizarVistaPrevia(figura) {
    const caja = document.getElementById("vistaPrevia");
    const l1 = document.getElementById("lado1");
    const l2 = document.getElementById("lado2");
    const l3 = document.getElementById("lado3");
    const formato = /^\d+(\.\d{1,2})?$/;

    let texto = "Introduce valores válidos para ver la vista previa.";

    if (figura === "Círculo" && formato.test(l1.value)) {
        texto = "Círculo de radio " + l1.value;
    } else if (figura === "Cuadrado" && formato.test(l1.value)) {
        texto = "Cuadrado de lado " + l1.value;
    } else if (figura === "Rectángulo" && formato.test(l1.value) && formato.test(l2.value)) {
        texto = "Rectángulo de lados " + l1.value + " y " + l2.value;
    } else if (figura === "Triángulo" && formato.test(l1.value) && formato.test(l2.value) && formato.test(l3.value)) {
        texto = "Triángulo de lados " + l1.value + ", " + l2.value + " y " + l3.value;
    }

    caja.textContent = texto;
}

/* ---------- Inicio: se prepara cada página cuando carga el DOM ---------- */

document.addEventListener("DOMContentLoaded", function () {

    /* ----- Imagen de la figura: si no existe el archivo, se oculta ----- */
    const imagen = document.querySelector(".caja-imagen img");
    if (imagen) {
        const ocultar = function () { imagen.style.display = "none"; };
        imagen.addEventListener("error", ocultar);
        if (imagen.complete && imagen.naturalWidth === 0) {
            ocultar(); // el error pudo ocurrir antes de cargar este script
        }
    }

    /* ----- Página 1: index.php ----- */
    const formIndex = document.getElementById("formFigura");
    if (formIndex) {
        const selector = document.getElementById("tipoFigura");
        const aviso = document.getElementById("avisoFigura");

        // onblur: valida al salir del campo
        selector.addEventListener("blur", function () {
            validarFigura(selector);
        });

        // change: actualiza el texto de aviso con el DOM
        selector.addEventListener("change", function () {
            if (validarFigura(selector)) {
                aviso.textContent = "Has elegido: " + selector.value;
            } else {
                aviso.textContent = "";
            }
        });

        formIndex.addEventListener("submit", function (evento) {
            if (!validarFigura(selector)) {
                evento.preventDefault();
                selector.focus();
            }
        });
    }

    /* ----- Página 2: datos.php ----- */
    const formDatos = document.getElementById("formDatos");
    if (formDatos) {
        const figura = formDatos.dataset.figura;
        const campos = formDatos.querySelectorAll("input[type='text']");

        campos.forEach(function (campo) {
            // onblur: valida el campo al perder el foco
            campo.addEventListener("blur", function () {
                validarLado(campo);
                if (figura === "Triángulo") {
                    validarTriangulo();
                }
                actualizarVistaPrevia(figura);
            });
        });

        // Si la página carga con datos de la sesión, se muestra la vista previa
        actualizarVistaPrevia(figura);

        formDatos.addEventListener("submit", function (evento) {
            let todoCorrecto = true;
            let primerError = null;

            campos.forEach(function (campo) {
                if (!validarLado(campo)) {
                    todoCorrecto = false;
                    if (primerError === null) {
                        primerError = campo;
                    }
                }
            });

            if (figura === "Triángulo" && todoCorrecto && !validarTriangulo()) {
                todoCorrecto = false;
                primerError = document.getElementById("lado3");
            }

            if (!todoCorrecto) {
                evento.preventDefault();
                primerError.focus();
            }
        });
    }
});
