//JS para cargar los datos de proveedor en la tabla
//cargar los datos
cargarProveedores();

function cargarProveedores() {
const action = "cargarProveedores";
fetch('../../controllers/php/proveedor.php', {
method: 'POST',
headers: {
  'Content-Type': 'application/json'
},
body: JSON.stringify({ action })
})
.then(response => response.json())
.then(data => {
let tbody = document.getElementById('listaProveedores');
tbody.innerHTML = '';
data.forEach(proveedor => {
  let tr = document.createElement('tr');
  tr.setAttribute('data-id', proveedor.idProveedor); // Asegúrate de asignar este atributo
  tr.innerHTML = `
    <td>${proveedor.idProveedor}</td>
    <td>${proveedor.nombreProveedor}</td>
    <td>${proveedor.direccionProveedor}</td>
    <td>${proveedor.telefonoProveedor}</td>
    <td>${proveedor.correoProveedor}</td>
    <td>
      <button class="btn btn-warning" onclick="editarProveedor(${proveedor.idProveedor})">Editar</button>
      <button class="btn btn-danger" onclick="eliminarProveedor(${proveedor.idProveedor})">Eliminar</button>
    </td>
  `;
  tbody.appendChild(tr);
});
});
}

function eliminarProveedor(idProveedor) {
if (confirm("¿Estás seguro de eliminar este proveedor?")) {
const action = "eliminarProveedor";
const data = { action, idProveedor };

fetch('../../controllers/php/proveedor.php', {
  method: 'POST',
  headers: {
    'Content-Type': 'application/json'
  },
  body: JSON.stringify(data)
})
.then(response => response.json())
.then(data => {
  if (data.estado === 'exito') {
    alert("Proveedor eliminado con éxito");
    cargarProveedores();
  } else {
    console.error('Error al eliminar el proveedor:', data.mensaje);
  }
})
.catch(error => console.error('Error:', error));
}
}

function editarProveedor(idProveedor) {
  const fila = document.querySelector(`tr[data-id="${idProveedor}"]`);

  if (!fila) {
    console.error("No se encontró la fila para el proveedor con ID:", idProveedor);
    return;
  }

  const nombre = fila.children[1].innerText;
  const direccion = fila.children[2].innerText;
  const telefono = fila.children[3].innerText;
  const correo = fila.children[4].innerText;

  document.getElementById("idProveedor").value = idProveedor;
  document.getElementById("nombreProveedor").value = nombre;
  document.getElementById("direccionProveedor").value = direccion;
  document.getElementById("telefonoProveedor").value = telefono;
  document.getElementById("correoProveedor").value = correo;

  const modalEditar = new bootstrap.Modal(document.getElementById('modalEditar'));
  modalEditar.show();
}

document.getElementById("guardarCambios").addEventListener("click", function (e) {
  e.preventDefault();

  const idProveedor = document.getElementById("idProveedor").value;
  const nombreProveedor = document.getElementById("nombreProveedor").value;
  const direccionProveedor = document.getElementById("direccionProveedor").value;
  const telefonoProveedor = document.getElementById("telefonoProveedor").value;
  const correoProveedor = document.getElementById("correoProveedor").value;

  const data = {
    action: "editarProveedor",
    idProveedor,
    nombreProveedor,
    direccionProveedor,
    telefonoProveedor,
    correoProveedor
  };

  fetch("../../controllers/php/proveedor.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json"
    },
    body: JSON.stringify(data)
  })
  .then(response => response.json())
  .then(response => {
    if (response.estado === "exito") {
      alert("Proveedor actualizado con éxito");

      const modalEditar = bootstrap.Modal.getInstance(document.getElementById("modalEditar"));
      modalEditar.hide();

      cargarProveedores();
    } else {
      alert("Error al actualizar el proveedor");
      console.error(response.mensaje);
    }
  })
  .catch(error => console.error("Error:", error));
});