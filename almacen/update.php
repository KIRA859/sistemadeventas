<?php
include('../app/config.php');
include('../layout/sesion.php');
include('../layout/parte1.php');
?>

<!-- Content Wrapper -->
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <h1 class="m-0">Actualizar producto</h1>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Llene los datos con cuidado</h3>
                </div>
                <div class="card-body">
                    <form id="formActualizarProducto" onsubmit="event.preventDefault(); actualizarProducto();">
                        <input type="hidden" id="id_producto" value="<?php echo $_GET['id']; ?>">
                        <input type="hidden" id="id_usuario" value="<?php echo $id_usuario_sesion; ?>">
                        <div class="row">
                            <!-- Columna izquierda: formulario -->
                            <div class="col-md-9">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Código:</label>
                                            <input type="text" class="form-control" id="codigo_visible" disabled>
                                            <input type="hidden" id="codigo" name="codigo">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Categoría:</label>
                                            <select name="id_categoria" id="id_categoria" class="form-control" required></select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Nombre del producto:</label>
                                            <input type="text" name="nombre" id="nombre" class="form-control" required>
                                        </div>
                                    </div>
                                </div>

                                <!-- Más campos -->
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Usuario</label>
                                            <input type="text" class="form-control" value="<?php echo $email_sesion; ?>" disabled>
                                            <input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $id_usuario_sesion; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="">Descripción del producto:</label>
                                            <textarea name="descripcion" id="descripcion" cols="30" rows="2" class="form-control"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <!-- Stock y precios -->
                                <div class="row">
                                    <div class="col-md-2">
                                        <label for="">Stock:</label>
                                        <input type="number" name="stock" id="stock" class="form-control" required>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="">Stock mínimo:</label>
                                        <input type="number" name="stock_minimo" id="stock_minimo" class="form-control" value="0">
                                    </div>
                                    <div class="col-md-2">
                                        <label for="">Stock máximo:</label>
                                        <input type="number" name="stock_maximo" id="stock_maximo" class="form-control" value="1000">
                                    </div>
                                    <div class="col-md-2">
                                        <label for="">Precio compra:</label>
                                        <input type="number" name="precio_compra" id="precio_compra" class="form-control" step="0.01" required>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="">Precio venta:</label>
                                        <input type="number" name="precio_venta" id="precio_venta" class="form-control" step="0.01" required>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="">Fecha ingreso:</label>
                                        <input type="date" name="fecha_ingreso" id="fecha_ingreso" class="form-control" required>
                                    </div>
                                </div>
                            </div>

                            <!-- Columna derecha: imagen -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Imagen del producto</label>
                                    <input type="file" name="image" class="form-control" id="file" accept="image/*">
                                    <input type="hidden" id="imagen_actual" value="">
                                    <br>
                                    <output id="list" class="border p-2 d-block text-center" style="min-height: 200px;">
                                        <p class="text-muted">Vista previa aquí</p>
                                    </output>
                                </div>
                            </div>
                        </div>

                        <hr>
                        <div class="form-group">
                            <a href="index.php" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-success">Actualizar producto</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Cargar datos iniciales del producto y categorías
    document.addEventListener("DOMContentLoaded", () => {
        const idProducto = document.getElementById("id_producto").value;

        // Obtener categorías
        fetch("<?php echo $URL; ?>/api/almacen/create.php")
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    const select = document.getElementById("id_categoria");
                    select.innerHTML = "";
                    data.categories.forEach(c => {
                        const option = document.createElement("option");
                        option.value = c.id_categoria;
                        option.textContent = c.nombre_categoria;
                        select.appendChild(option);
                    });
                }
            });

        // Obtener datos del producto
        fetch("<?php echo $URL; ?>/api/almacen/show.php?id=" + idProducto)
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    const p = data.producto;
                    document.getElementById("codigo").value = p.codigo;
                    document.getElementById("codigo_visible").value = p.codigo;
                    document.getElementById("nombre").value = p.nombre;
                    document.getElementById("descripcion").value = p.descripcion;
                    document.getElementById("stock").value = p.stock;
                    document.getElementById("stock_minimo").value = p.stock_minimo;
                    document.getElementById("stock_maximo").value = p.stock_maximo;
                    document.getElementById("precio_compra").value = p.precio_compra;
                    document.getElementById("precio_venta").value = p.precio_venta;
                    document.getElementById("fecha_ingreso").value = p.fecha_ingreso;
                    document.getElementById("id_categoria").value = p.id_categoria;

                    // Guardar imagen actual en el hidden
                    if (p.imagen) {
                        document.getElementById("imagen_actual").value = p.imagen;
                        document.getElementById("list").innerHTML =
                            `<img src="<?php echo $URL; ?>/almacen/img_productos/${p.imagen}" width="100%">`;
                    }
                }
            });
    });

    // Convertir imagen a base64
    function convertImageToBase64(file, callback) {
        const reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = () => callback(reader.result);
        reader.onerror = error => callback(null, error);
    }

    // Mostrar vista previa cuando el usuario selecciona una nueva imagen
    document.getElementById("file").addEventListener("change", function(evt) {
        const file = evt.target.files[0];
        if (file && file.type.match("image.*")) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById("list").innerHTML =
                    `<img src="${e.target.result}" width="100%">`;
            };
            reader.readAsDataURL(file);
        }
    });

    // Enviar actualización al API
    function actualizarProducto() {
        const formData = {
            id_producto: document.getElementById("id_producto").value,
            codigo: document.getElementById("codigo").value,
            nombre: document.getElementById("nombre").value,
            descripcion: document.getElementById("descripcion").value,
            stock: parseInt(document.getElementById("stock").value),
            stock_minimo: parseInt(document.getElementById("stock_minimo").value) || 0,
            stock_maximo: parseInt(document.getElementById("stock_maximo").value) || 0,
            precio_compra: parseFloat(document.getElementById("precio_compra").value),
            precio_venta: parseFloat(document.getElementById("precio_venta").value),
            fecha_ingreso: document.getElementById("fecha_ingreso").value,
            id_categoria: parseInt(document.getElementById("id_categoria").value),
            id_usuario: parseInt(document.getElementById("id_usuario").value),
            imagen: null
        };

        //Guardar imagen actual si no se sube una nueva
        const imagenActual = document.getElementById("imagen_actual").value;
        if (imagenActual) {
            formData.imagen_actual = imagenActual;
        }

        const imageFile = document.getElementById("file").files[0];
        if (imageFile) {
            convertImageToBase64(imageFile, (base64Image, error) => {
                if (error) {
                    alert("Error al procesar la imagen: " + error);
                    return;
                }
                formData.imagen = base64Image;
                enviarDatos(formData);
            });
        } else {
            enviarDatos(formData);
        }
    }

    function enviarDatos(formData) {
        fetch("<?php echo $URL; ?>/api/almacen/update.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(formData)
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    alert("Producto actualizado correctamente");
                    window.location.href = "index.php";
                } else {
                    alert("Error: " + data.error);
                }
            })
            .catch(err => {
                console.error("Error:", err);
                alert("Error al conectar con el servidor");
            });
    }
</script>

<?php include('../layout/mensajes.php'); ?>
<?php include('../layout/parte2.php'); ?>