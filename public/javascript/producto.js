 // Obtener categorías y proveedores
    fetch("../../controllers/php/cat_prov.php")
    .then(response => response.json())
    .then(data => {
   // Llenar select de categorías
    var selectCategorias = document.getElementById("categoriaProducto");
    data.categorias.forEach(categoria => {
        var option = document.createElement("option");
        option.value = categoria.idCategoria;
        option.text = categoria.nombreCategoria;
        selectCategorias.add(option);
    });

   // Llenar select de proveedores
    var selectProveedores = document.getElementById("proveedorProducto");
    data.proveedores.forEach(proveedor => {
        var option = document.createElement("option");
        option.value = proveedor.idProveedor;
        option.text = proveedor.nombreProveedor;
        selectProveedores.add(option);
    });
})
.catch(error => console.error("Error:", error));
// Guardar producto
function guardarProducto() {
    var nombreProducto = document.getElementById("nombreProducto").value;
    var descripcionProducto = document.getElementById("descripcionProducto").value;
    var precioProducto = document.getElementById("precioProducto").value;
    var cantidadProducto = document.getElementById("cantidadProducto").value;
    var categoriaProducto = document.getElementById("categoriaProducto").value;
    var proveedorProducto = document.getElementById("proveedorProducto").value;
    var imagenProducto = document.getElementById("imagenProducto").files[0];

    var formData = new FormData();
    formData.append("nombreProducto", nombreProducto);
    formData.append("descripcionProducto", descripcionProducto);
    formData.append("precioProducto", precioProducto);
    formData.append("cantidadProducto", cantidadProducto);
    formData.append("categoriaProducto", categoriaProducto);
    formData.append("proveedorProducto", proveedorProducto);
    formData.append("imagenProducto", imagenProducto);

fetch("../../controllers/php/registrar_prod.php", {
    method: "POST",
    body: formData
    })
    .then(response => response.text())
    .then(data => {
    alert(data);
    })
.catch(error => console.error("Error:", error));
}