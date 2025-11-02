document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("productoForm");

  // Cargar datos dinámicos
  cargarBodegas();
  cargarMonedas();

  // Evento de envío del formulario
  form.addEventListener("submit", function (event) {
    event.preventDefault(); // Prevenir envío normal
    if (validarFormulario()) {
      enviarProducto(); // Enviar los datos al servidor si todo es válido
    }
  });

  activarLimpiezaDeErrores();
});

//Validación del formulario
function validarFormulario() {
  document
    .querySelectorAll(".error")
    .forEach((span) => (span.textContent = ""));

  const codigo = document.getElementById("codigo").value.trim();
  const nombre = document.getElementById("nombre").value.trim();
  const precio = document.getElementById("precio").value.trim();
  const descripcion = document.getElementById("descripcion").value.trim();
  const bodega = document.getElementById("bodega").value;
  const sucursal = document.getElementById("sucursal").value;
  const moneda = document.getElementById("moneda").value;
  const materialesSeleccionados = document.querySelectorAll(
    'input[name="materiales[]"]:checked'
  );

  let valido = true;

  //Validar Código
  const regexCodigoCaracteres = /^[A-Za-z\d]+$/;
  const regexCodigoFormato = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{5,15}$/;

  if (codigo === "") {
    mostrarError("codigo", "El código del producto no puede estar en blanco.");
    valido = false;
  } else if (!regexCodigoCaracteres.test(codigo)) {
    mostrarError("codigo", "No puede contener caracteres especiales.");
    valido = false;
  } else if (!regexCodigoFormato.test(codigo)) {
    mostrarError(
      "codigo",
      "Debe tener letras y números, entre 5 y 15 caracteres."
    );
    valido = false;
  }

  //Validar Nombre
  if (nombre === "") {
    mostrarError("nombre", "El nombre del producto no puede estar en blanco.");
    valido = false;
  } else if (nombre.length < 2 || nombre.length > 50) {
    mostrarError(
      "nombre",
      "El nombre del producto debe tener entre 2 y 50 caracteres."
    );
    valido = false;
  }

  //Validar Precio
  const regexPrecio = /^\d+(\.\d{1,2})?$/;
  if (precio === "") {
    mostrarError("precio", "El precio del producto no puede estar en blanco.");
    valido = false;
  } else if (!regexPrecio.test(precio) || parseFloat(precio) <= 0) {
    mostrarError(
      "precio",
      "El precio del producto debe ser un número positivo con hasta dos decimales."
    );
    valido = false;
  }

  //Validar Materiales
  if (
    materialesSeleccionados.length < 2 ||
    materialesSeleccionados.length > 2
  ) {
    mostrarError(
      "materiales",
      "Debe seleccionar al menos dos materiales para el producto."
    );
    valido = false;
  }

  // Validar Bodega
  if (bodega === "") {
    mostrarError("bodega", "Debe seleccionar una bodega.");
    valido = false;
  }

  // Validar Sucursal
  if (sucursal === "") {
    mostrarError(
      "sucursal",
      "Debe seleccionar una sucursal para la bodega seleccionada."
    );
    valido = false;
  }

  // Validar Moneda
  if (moneda === "") {
    mostrarError("moneda", "Debe seleccionar una moneda para el producto.");
    valido = false;
  }

  // Validar Descripción
  if (descripcion === "") {
    mostrarError(
      "descripcion",
      "La descripción del producto no puede estar en blanco."
    );
    valido = false;
  } else if (descripcion.length < 10 || descripcion.length > 1000) {
    mostrarError(
      "descripcion",
      "La descripción del producto debe tener entre 10 y 1000 caracteres."
    );
    valido = false;
  }

  return valido;
}

// Mostrar error debajo del campo
function mostrarError(campo, mensaje) {
  document.getElementById(`error-${campo}`).textContent = mensaje;
}

// Limpiar errores al corregir campos
function activarLimpiezaDeErrores() {
  const camposTexto = ["codigo", "nombre", "precio", "descripcion"];
  const selects = ["bodega", "sucursal", "moneda"];
  const checkboxes = document.querySelectorAll('input[name="materiales[]"]');

  camposTexto.forEach((id) => {
    const input = document.getElementById(id);
    input.addEventListener("input", () => {
      document.getElementById(`error-${id}`).textContent = "";
    });
  });

  selects.forEach((id) => {
    const select = document.getElementById(id);
    select.addEventListener("change", () => {
      document.getElementById(`error-${id}`).textContent = "";
    });
  });

  checkboxes.forEach((checkbox) => {
    checkbox.addEventListener("change", () => {
      document.getElementById("error-materiales").textContent = "";
    });
  });
}

// Enviar producto
function enviarProducto() {
  const form = document.getElementById("productoForm");
  const formData = new FormData(form);
  const resultado = document.getElementById("resultado");

  fetch("php/agregar_producto.php", {
    method: "POST",
    body: formData,
  })
    .then((res) => res.json())
    .then((data) => {
      resultado.className = "";
      if (data.status === "ok") {
        resultado.textContent = data.mensaje;
        resultado.classList.add("ok");
        form.reset();
      } else {
        resultado.textContent = data.mensaje;
        resultado.classList.add("error");
      }

      // Oculta el mensaje luego de 5 segundos
      setTimeout(() => {
        resultado.textContent = "";
        resultado.className = "";
      }, 5000);
    })
    .catch(() => {
      resultado.textContent = "Error al enviar los datos al servidor.";
      resultado.classList.add("error");
    });
}

// Cargar bodegas y sucursales
function cargarBodegas() {
  const bodegaSelect = document.getElementById("bodega");
  const sucursalSelect = document.getElementById("sucursal");

  fetch("php/obtener_datos.php?accion=bodegas")
    .then((res) => res.json())
    .then((data) => {
      if (data.error) return alert("Error al cargar bodegas: " + data.error);
      data.forEach((b) => {
        bodegaSelect.innerHTML += `<option value="${b.id}">${b.nombre}</option>`;
      });
    })
    .catch(() => alert("No se pudieron cargar las bodegas."));

  bodegaSelect.addEventListener("change", () => {
    const id = bodegaSelect.value;
    sucursalSelect.innerHTML = '<option value="">--</option>';
    if (!id) return;

    fetch(`php/obtener_datos.php?accion=sucursales&bodega_id=${id}`)
      .then((res) => res.json())
      .then((data) => {
        if (data.error)
          return alert("Error al cargar sucursales: " + data.error);
        data.forEach((s) => {
          sucursalSelect.innerHTML += `<option value="${s.id}">${s.sucursal}</option>`;
        });
      })
      .catch(() => alert("No se pudieron cargar las sucursales."));
  });
}

// Cargar monedas
function cargarMonedas() {
  const monedaSelect = document.getElementById("moneda");

  fetch("php/obtener_datos.php?accion=monedas")
    .then((res) => res.json())
    .then((data) => {
      if (data.error) return alert("Error al cargar monedas: " + data.error);
      data.forEach((m) => {
        monedaSelect.innerHTML += `<option value="${m.codigo}">${m.codigo}</option>`;
      });
    })
    .catch(() => alert("No se pudo cargar la moneda."));
}
