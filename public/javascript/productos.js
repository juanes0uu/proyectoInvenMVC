cargarProductos();
function cargarProductos() {
  const action = "cargarProductos";
  fetch('../../controllers/php/producto.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({
      action
    })
  })
  .then(response => response.json())
  .then(data => {
    let tbody = document.getElementById('listaProductos');
    tbody.innerHTML = '';
data.forEach(producto => {
let tr = document.createElement('tr');
tr.setAttribute('data-id', producto.idProducto); // Añade el data-id aquí
tr.innerHTML = `
<td>${producto.idProducto}</td>
<td><img src="${producto.imagenProducto}" width="50"></td>
<td>${producto.nombreProducto}</td>
<td>${producto.descripcionProducto}</td>
<td>${producto.precioProducto}</td>
<td>${producto.cantidadProducto}</td>
<td>${producto.nombreCategoria}</td>
<td>${producto.nombreProveedor}</td>
<td>
  <button class="btn btn-warning" onclick="editarProducto(${producto.idProducto})">Editar</button>
  <button class="btn btn-danger" onclick="eliminarProducto(${producto.idProducto})">Eliminar</button>
</td>
`;
tbody.appendChild(tr);
});
  });
}

function eliminarProducto(idProducto) {
if (confirm("¿Estás seguro de eliminar este producto?")) {
const action = "eliminarProducto";
const data = { action, idProducto };

fetch('../../controllers/php/producto.php', {
  method: 'POST',
  headers: {
    'Content-Type': 'application/json'
  },
  body: JSON.stringify(data)
})
.then(response => response.json())
.then(data => {
  if (data.estado === 'exito') {
    cargarProductos();
    const tr = document.querySelector(`tr[data-id="${idProducto}"]`);
    tr.remove();
  } else {
    console.error('Error al eliminar el producto:', data.mensaje);
  }
})
.catch(error => console.error('Error:', error));
}
}

function editarProducto(idProducto) {
// Obtener la fila correspondiente usando el data-id
const fila = document.querySelector(`tr[data-id="${idProducto}"]`);

if (!fila) {
console.error("No se encontró la fila para el producto con ID:", idProducto);
return;
}

// Extraer valores de la fila
const nombre = fila.children[2].innerText;
const descripcion = fila.children[3].innerText;
const precio = fila.children[4].innerText;
const cantidad = fila.children[5].innerText;

// Rellenar los inputs del formulario
document.getElementById("idProducto").value = idProducto;
document.getElementById("nombreProducto").value = nombre;
document.getElementById("descripcionProducto").value = descripcion;
document.getElementById("precioProducto").value = precio;
document.getElementById("cantidadProducto").value = cantidad;

// Mostrar el modal
const modalEditar = new bootstrap.Modal(document.getElementById('modalEditar'));
modalEditar.show();
}

document.getElementById("guardarCambios").addEventListener("click", function (e) {
e.preventDefault();

// Recolecta los valores del formulario
const idProducto = document.getElementById("idProducto").value;
const nombreProducto = document.getElementById("nombreProducto").value;
const descripcionProducto = document.getElementById("descripcionProducto").value;
const precioProducto = document.getElementById("precioProducto").value;
const cantidadProducto = document.getElementById("cantidadProducto").value;

// Prepara los datos a enviar
const data = {
action: "editarProducto",
idProducto,
nombreProducto,
descripcionProducto,
precioProducto,
cantidadProducto,
};

// Envía los datos al servidor
fetch("../../controllers/php/producto.php", {
method: "POST",
headers: {
  "Content-Type": "application/json",
},
body: JSON.stringify(data),
})
.then((response) => response.json())
.then((response) => {
  if (response.estado === "exito") {
    alert("Producto actualizado con éxito");

    // Cierra el modal
    const modalEditar = bootstrap.Modal.getInstance(
      document.getElementById("modalEditar")
    );
    modalEditar.hide();

    // Recargar la tabla
    cargarProductos();
  } else {
    alert("Error al actualizar el producto");
    console.error(response.mensaje);
  }
})
.catch((error) => console.error("Error:", error));
});