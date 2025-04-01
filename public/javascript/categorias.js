//JS para cargar los datos de categoria en la tabla
//cargar los datoss
cargarCategorias();

function cargarCategorias() {
  const action = "cargarCategorias";
  fetch('../../controllers/php/categoria.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({ action })
  })
  .then(response => response.json())
  .then(data => {
    let tbody = document.getElementById('listaCategorias');
    tbody.innerHTML = '';
    data.forEach(categoria => {
      let tr = document.createElement('tr');
      tr.setAttribute('data-id', categoria.idCategoria); // Añade el data-id aquí
      tr.innerHTML = `
        <td>${categoria.idCategoria}</td>
        <td>${categoria.nombreCategoria}</td>
        <td>${categoria.descripcionCategoria}</td>
        <td>
          <button class="btn btn-warning" onclick="editarCategoria(${categoria.idCategoria})">Editar</button>
          <button class="btn btn-danger" onclick="eliminarCategoria(${categoria.idCategoria})">Eliminar</button>
        </td>
      `;
      tbody.appendChild(tr);
    });
  });
}

//eliminar los datos
function eliminarCategoria(idCategoria) {
  if (confirm("¿Estás seguro de eliminar esta categoría?")) {
    const action = "eliminarCategoria";
    const data = { action, idCategoria };
    fetch('../../controllers/php/categoria.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
      if (data.estado === 'exito') {
        alert("Categoría eliminada con éxito");
        cargarCategorias();
      } else {
        console.error('Error al eliminar la categoría:', data.mensaje);
      }
    })
    .catch(error => console.error('Error:', error));
  }
}

//editar los datos
function editarCategoria(idCategoria) {
  const fila = document.querySelector(`tr[data-id="${idCategoria}"]`);

  if (!fila) {
    console.error("No se encontró la fila para la categoría con ID:", idCategoria);
    return;
  }

  const nombre = fila.children[1].innerText;
  const descripcion = fila.children[2].innerText;

  document.getElementById("idCategoria").value = idCategoria;
  document.getElementById("nombreCategoria").value = nombre;
  document.getElementById("descripcionCategoria").value = descripcion;

  const modalEditar = new bootstrap.Modal(document.getElementById('modalEditar'));
  modalEditar.show();
}

document.getElementById("guardarCambios").addEventListener("click", function (e) {
  e.preventDefault();

  const idCategoria = document.getElementById("idCategoria").value;
  const nombreCategoria = document.getElementById("nombreCategoria").value;
  const descripcionCategoria = document.getElementById("descripcionCategoria").value;

  const data = {
    action: "editarCategoria",
    idCategoria,
    nombreCategoria,
    descripcionCategoria
  };

  fetch("../../controllers/php/categoria.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json"
    },
    body: JSON.stringify(data)
  })
  .then(response => response.json())
  .then(response => {
    if (response.estado === "exito") {
      alert("Categoría actualizada con éxito");

      const modalEditar = bootstrap.Modal.getInstance(document.getElementById("modalEditar"));
      modalEditar.hide();

      cargarCategorias();
    } else {
      alert("Error al actualizar la categoría");
      console.error(response.mensaje);
    }
  })
  .catch(error => console.error("Error:", error));
});
