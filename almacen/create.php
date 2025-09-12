<?php
include ('../app/config.php');
include ('../layout/sesion.php');
include ('../layout/parte1.php');
?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Registro de un nuevo producto</h1>
                </div></div></div></div>
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Llene los datos con cuidado</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>

                        <div class="card-body" style="display: block;">
                            <div class="row">
                                <div class="col-md-12">

                                    <form id="formCrearProducto">

                                        <div class="row">
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
                                                            <div style="display: flex">
                                                                <select name="id_categoria" id="id_categoria" class="form-control" required>
                                                                    </select>
                                                                <a href="<?php echo $URL;?>/categorias" class="btn btn-primary"><i class="fa fa-plus"></i></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="">Nombre del producto:</label>
                                                            <input type="text" name="nombre" id="nombre" class="form-control" required>
                                                        </div>
                                                    </div>
                                                </div>

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


                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label for="">Stock:</label>
                                                            <input type="number" name="stock" id="stock" class="form-control" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label for="">Stock mínimo:</label>
                                                            <input type="number" name="stock_minimo" id="stock_minimo" class="form-control" value="0">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label for="">Stock máximo:</label>
                                                            <input type="number" name="stock_maximo" id="stock_maximo" class="form-control" value="1000">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label for="">Precio compra:</label>
                                                            <input type="number" name="precio_compra" id="precio_compra" class="form-control" step="0.01" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label for="">Precio venta:</label>
                                                            <input type="number" name="precio_venta" id="precio_venta" class="form-control" step="0.01" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label for="">Fecha de ingreso:</label>
                                                            <input type="date" name="fecha_ingreso" id="fecha_ingreso" class="form-control" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="">Imagen del producto</label>
                                                    <input type="file" name="image" class="form-control" id="file" accept="image/*">
                                                    <br>
                                                    <output id="list">
                                                        
                                                    </output>
                                                </div>
                                            </div>
                                        </div>

                                        <hr>
                                        <div class="form-group">
                                            <a href="index.php" class="btn btn-secondary">Cancelar</a>
                                            <button type="button" id="btnGuardar" onclick="crearProducto()" class="btn btn-primary">Guardar producto</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div></div>
    </div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    fetch('<?php echo $URL; ?>/api/almacen/create.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Asignar el próximo código de producto
                document.getElementById('codigo_visible').value = data.next_code;
                document.getElementById('codigo').value = data.next_code;

                // Poblar el select de categorías
                const categoriaSelect = document.getElementById('id_categoria');
                categoriaSelect.innerHTML = ''; // Limpiar opciones existentes
                data.categories.forEach(categoria => {
                    const option = document.createElement('option');
                    option.value = categoria.id_categoria;
                    option.textContent = categoria.nombre_categoria;
                    categoriaSelect.appendChild(option);
                });
            } else {
                alert('Error al cargar los datos iniciales: ' + data.message);
            }
        })
        .catch(error => console.error('Error:', error));
});
</script>


<script>
    function archivo(evt) {
        var files = evt.target.files; // FileList object
        // Obtenemos la imagen del campo "file".
        for (var i = 0, f; f = files[i]; i++) {
            //Solo admitimos imágenes.
            if (!f.type.match('image.*')) {
                continue;
            }
            var reader = new FileReader();
            reader.onload = (function(theFile) {
                return function(e) {
                    // Insertamos la imagen
                    document.getElementById("list").innerHTML = ['<img class="thumb thumbnail" src="', e.target.result, '" width="100%" title="', escape(theFile.name), '"/>'].join('');
                };
            })(f);
            reader.readAsDataURL(f);
        }
    }
    document.getElementById('file').addEventListener('change', archivo, false);
</script>

<script>
// Función para convertir imagen a base64
function convertImageToBase64(file, callback) {
    const reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onload = () => callback(reader.result);
    reader.onerror = error => callback(null, error);
}

// Función principal para crear el producto
function crearProducto() {
    // Validar campos requeridos
    const requiredFields = ['nombre', 'stock', 'precio_compra', 'precio_venta', 'fecha_ingreso'];
    let isValid = true;
    
    requiredFields.forEach(field => {
        const element = document.getElementById(field);
        if (!element.value.trim()) {
            element.classList.add('is-invalid');
            isValid = false;
        } else {
            element.classList.remove('is-invalid');
        }
    });
    
    if (!isValid) {
        alert('Por favor, complete todos los campos requeridos.');
        return;
    }

    // Obtener todos los valores del formulario
    const formData = {
        codigo: document.getElementById('codigo').value,
        nombre: document.getElementById('nombre').value,
        descripcion: document.getElementById('descripcion').value,
        stock: parseInt(document.getElementById('stock').value),
        stock_minimo: parseInt(document.getElementById('stock_minimo').value) || 0,
        stock_maximo: parseInt(document.getElementById('stock_maximo').value) || 1000,
        precio_compra: parseFloat(document.getElementById('precio_compra').value),
        precio_venta: parseFloat(document.getElementById('precio_venta').value),
        fecha_ingreso: document.getElementById('fecha_ingreso').value,
        id_categoria: parseInt(document.getElementById('id_categoria').value),
        id_usuario: parseInt(document.getElementById('id_usuario').value),
        imagen: null // Inicializamos la imagen como nula
    };

    // Obtener la imagen si existe
    const imageInput = document.getElementById('file');
    const imageFile = imageInput.files[0];

    if (imageFile) {
        // Si hay imagen, convertir a base64 y luego enviar
        convertImageToBase64(imageFile, (base64Image, error) => {
            if (error) {
                alert('Error al procesar la imagen: ' + error);
                return;
            }
            formData.imagen = base64Image;
            enviarDatosAlAPI(formData);
        });
    } else {
        // Si no hay imagen, enviar directamente
        enviarDatosAlAPI(formData);
    }
}

// Función para enviar datos a la API
function enviarDatosAlAPI(formData) {
    // Mostrar indicador de carga
    const btnGuardar = document.getElementById('btnGuardar');
    const originalText = btnGuardar.innerHTML;
    btnGuardar.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Guardando...';
    btnGuardar.disabled = true;

    // Enviar solicitud al API
    fetch('<?php echo $URL; ?>/api/almacen/create.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Mostrar mensaje de éxito
            alert('Producto creado correctamente');
            // Redirigir a la lista de productos
            window.location.href = 'index.php';
        } else {
            // Mostrar error
            alert('Error: ' + data.message);
            btnGuardar.innerHTML = originalText;
            btnGuardar.disabled = false;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al conectar con el servidor');
        btnGuardar.innerHTML = originalText;
        btnGuardar.disabled = false;
    });
}
</script>


<?php 
include ('../layout/mensajes.php');
include ('../layout/parte2.php');
?>