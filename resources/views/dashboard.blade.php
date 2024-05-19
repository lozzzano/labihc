@extends('layouts.app')

@section('content')


<div class="container-fluid" style="padding-left:0px!important; padding-right:0px!important;">
    <!-- Navbar with shopping cart and login link -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light" style="background-color: transparent !important;">
        <div class="container-fluid">

            <a class="navbar-brand" href="{{ url('/cart') }}" id="cart-icon">
                <i class="bi-cart-fill me-1"></i>
                <span id="cart-count">(0)</span>
            </a>

            <!-- Search Bar -->
            <form class="d-flex" style="margin: 0 auto;">
                <input class="form-control me-2" type="search" placeholder="Buscar" aria-label="Buscar" style="border-radius:10px; border-color:#52616B!important;">
                <button class="btn btn-outline-success" style="color:#52616B!important; border-color:#52616B!important;" type="submit">Buscar</button>
            </form>

            <!-- Login Link -->
            <a class="navbar-text" href="{{ url('/perfil-usuario') }}" style="margin-left: 6px; margin-right:6px;">
                <i class="bi-person-fill"></i>
            </a>
            |
            <a class="navbar-text" href="{{ url('/profile') }}" style="margin-left: 6px;">
                <i class="bi bi-gear-fill"></i>
            </a>

        </div>
    </nav>

    <!-- Categories Buttons -->
    <div class="row" style="padding-top: 20px;">

        <div class="col-md item">
            <img src="/images/comida-rapida.webp" alt="" style="height:5em;" class="img-fluid mx-auto">
            <button type="button" class="btn btn-light" style="color:#52616B; border:none;">Comida rápida</button>
        </div>
        <div class="col-md item">
            <img src="/images/snacks.webp" alt="" style="height:5em;" class="img-fluid mx-auto">
            <button type="button" class="btn btn-light" style="color:#52616B; border:none;">Snacks</button>
        </div>
        <div class="col-md item">
            <img src="/images/articulos-escolares.png" alt="" style="height:5em;" class="img-fluid mx-auto">
            <button type="button" class="btn btn-light" style="color:#52616B; border:none;">Artículos escolares</button>
        </div>

    </div>


</div>

<!-- Products List -->
<div class="container mt-3" style="padding-top:20px;">
    @foreach($productos as $producto)

    <!-- Product Card -->
    <div class="card mb-4 shadow-sm">
        <div class="row" style="padding:10px;">

            <!-- Column for Image -->
            <div class="col-md-4">

                <div style="height: 200px; width: 100%; overflow: hidden; display: flex; align-items: center; justify-content: center;">
                    <!-- Imagen del producto -->
                    <img src="{{ asset('storage/' . $producto->imagen_producto) }}" class="img-fluid" alt="{{ $producto->nombre_producto }}" style="max-height: 100%; border: 1px solid;">
                </div>

            </div>

            <!-- Column for Product Name and Description -->
            <div class="col-md-4">
                <h5 class="card-title item-info"><b>{{ $producto->nombre_producto }}</b></h5>
                <p class="card-text item-info">{{ $producto->descripcion_producto }}</p>
                <p class="card-text item-info">Categoría: {{$producto->categoria->nombre_categoria}}</p>
                <div class="input-group">
                    <button class="btn btn-outline-secondary decrement-quantity" data-producto-id="{{ $producto->id }}" type="button" style="border: none !important;">-</button>
                    <input type="text" class="form-control text-center quantity-input" value="1" min="1" data-producto-id="{{ $producto->id }}" s style="max-width: 60px; border: none !important;">
                    <button class="btn btn-outline-secondary increment-quantity" data-producto-id="{{ $producto->id }}" type="button" style="border: none !important;">+</button>
                </div>

                <a href="#" class="btn btn-primary btn-block item-carrito" data-producto-id="{{ $producto->id }}" data-precio="{{ $producto->precio_producto }}" data-vendedor-id="{{ $producto->id_usuario }}" style="padding: .3em; width: 10em !important;">Agregar al carrito</a>
            </div>

            <!-- Column for Seller Info and Price -->
            <div class="col-md-4 text-center">
                <!-- Botón de información del vendedor -->
                <button type="button" class="btn btn-info" style="width: auto; margin-bottom: 8px; background-color:#52616B!important;" data-bs-toggle="modal" data-bs-target="#sellerModal{{ $producto->id }}">
                    <i class="bi-info-circle"></i> Vendedor
                </button>
                <!-- Precio del producto -->
                <p class="card-text" style="font-size: 1.5rem; margin-bottom: 0;">${{ $producto->precio_producto }}</p>
            </div>


        </div>
    </div>
    <!-- Seller Info Modal -->
    <div class="modal fade" id="sellerModal{{ $producto->id }}" tabindex="-1" aria-labelledby="sellerModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="sellerModalLabel">Información del Vendedor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Seller information here -->
                    <p>Nombre del vendedor: {{$producto->user->name}}</p>
                    <p>Matrícula: {{$producto->user->matricula}}</p>
                    <p>Fecha publicación: {{$producto->created_at}}</p>
                    <p>Fecha de edición: {{$producto->updated_at}}</p>
                </div>
            </div>
        </div>
    </div>

    @endforeach
</div>



</div>

</div>

@endsection

<!-- Bootstrap core JS-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Core theme JS-->
<script src="{{ asset('js/scripts-temp.js') }}"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
<!-- Core theme CSS (includes Bootstrap)-->
<link href="{{ asset('css/styles-temp.css') }}" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Incluir SweetAlert CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
<!-- Incluir SweetAlert JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>
    $(document).ready(function() {

        let currentSellerId = null;

        updateCartCountOnPageLoad();

        $('.decrement-quantity').on('click', function() {
            var productId = $(this).data('producto-id');
            var $quantityInput = $('.quantity-input[data-producto-id="' + productId + '"]');
            var currentQuantity = parseInt($quantityInput.val(), 10);
            var newQuantity = currentQuantity - 1;
            $quantityInput.val(newQuantity > 0 ? newQuantity : 1);
        });

        $('.increment-quantity').on('click', function() {
            var productId = $(this).data('producto-id');
            var $quantityInput = $('.quantity-input[data-producto-id="' + productId + '"]');
            var currentQuantity = parseInt($quantityInput.val(), 10);
            var newQuantity = currentQuantity + 1;
            $quantityInput.val(newQuantity);
        });


        // Función para actualizar el contador del carrito
        function updateCartCount(count) {
            $('#cart-count').text(`(${count})`);
        }

        // Evento clic para agregar un producto al carrito
        $('.item-carrito').on('click', function(e) {
            e.preventDefault();
            var productoId = $(this).data('producto-id');
            var quantity = $('.quantity-input[data-producto-id="' + productoId + '"]').val();
            var precio = $(this).data('precio'); // Asumiendo que el precio está disponible como un data-attribute

            var sellerId = $(this).data('vendedor-id'); // Asume que tienes un data-attribute para el ID del vendedor

            if (currentSellerId !== null && currentSellerId !== sellerId) {
                alert("Solo puedes agregar productos del mismo vendedor. Elíminalo tu carrito si deseas agregar productos de otro vendedor.");
                return;
            }
            currentSellerId = sellerId;

            console.log('Cantidad a agregar:', quantity); // Esto debería mostrarte la cantidad que estás enviando 
            console.log('precio:', precio);
            console.log('id:', productoId);

            var producto = {
                id: productoId,
                cantidad: quantity,
                precio: precio
            };

            // Realiza la solicitud AJAX al servidor
            $.ajax({
                url: '/cart/add', // Asegúrate de que esta URL es correcta y accesible
                method: 'POST',
                cache: false,
                data: {
                    _token: "{{ csrf_token() }}",
                    producto_id: productoId,
                    cantidad: quantity, // Asegúrate de que esto se está enviando correctamente
                    precio: precio,
                },
                success: function(response) {
                    // Aquí actualizas el contador basado en la respuesta del servidor
                    console.log('Total items after addition:', response.totalItems);
                    updateCartCount(response.totalItems);
                    console.log('id pt2:', productoId);

                },
                error: function() {
                    alert('Hubo un error al agregar el producto al carrito.');
                }
            });
        });

        // Evento clic para el ícono del carrito que muestra el contenido con SweetAlert
        $('#cart-icon').click(function(e) {
            e.preventDefault();

            // Realizar solicitud AJAX al servidor para obtener los items del carrito
            $.ajax({
                url: '/cart/content', // Endpoint que devuelve el contenido del carrito
                method: 'GET',
                cache: false,
                success: function(response) {
                    // Procesar respuesta para mostrar el contenido en SweetAlert
                    console.log(response);

                    console.log(response.items);

                    var cartItemsHtml = "<table class='table'>";
                    cartItemsHtml += `<thead><tr class="info-items"><th>Producto</th><th>Precio c/u</th><th>Cantidad</th><th>Eliminar</th></tr></thead><tbody>`;
                    var total = calcularTotal(response.items);

                    $.each(response.items, function(id, item) {
                        cartItemsHtml += `<tr class="info-items">
                <td>${item.nombre}</td>
                <td>$${item.precio}</td>
                <td>${item.cantidad}</td>
                <td><button class="btn btn-danger remove-item" data-id="${item.id}"><i class="bi bi-trash"></i></button></td>
            </tr>`;
                    });

                    cartItemsHtml += "</tbody></table>";
                    cartItemsHtml += `<div class="total">Total: $${total}</div>`;
                    // Agregar selección de método de pago
                    cartItemsHtml += `<select id='payment-method' class='form-control' style='width:50%; margin: 0 auto;'>
            <option value='efectivo'>Efectivo</option>
            <option value='transferencia'>Transferencia</option>
        </select>`;
                    cartItemsHtml += `<button id="empty-cart" class="btn btn-warning" style="width: 50%; margin-top: 10px;">Vaciar Carrito</button>`;

                    Swal.fire({
                        title: "Tu Carrito",
                        html: cartItemsHtml, // SweetAlert acepta nodos DOM como contenido
                        showCancelButton: true,
                        confirmButtonText: 'Confirmar pedido',
                        cancelButtonText: 'Seguir comprando',
                        customClass: {
                            confirmButton: 'btn-success',
                            cancelButton: 'btn-secondary'
                        },
                        preConfirm: () => {
                            return {
                                items: response.items,
                                metodoPago: document.getElementById('payment-method').value
                            }
                        }
                    }).then((result) => {
                        if (result.isConfirmed && result.value) {
                            enviarPedido(result.value.items, result.value.metodoPago);
                        }
                    });
                },
                error: function() {
                    swal("Error", "No se pudo obtener el contenido del carrito.", "error");
                }
            }); //fin ajax

        });
    });

    function enviarPedido(items, metodoPago) {
        console.log('Items enviarPedido: ', items);
        let precioTotal = calcularTotal(items); // Asume que tienes una función para calcular el total

        $.ajax({
            url: '/crear-pedido',
            type: 'POST',
            data: {
                items: items,
                precioTotal: precioTotal,
                metodoPago: metodoPago,
                _token: "{{ csrf_token() }}" // Asegúrate de incluir el token CSRF
            },
            success: function(response) {
                console.log(response);
                if (response.status === 'success') {
                    currentSellerId = null;
                    console.log('Carrito vaciado. currentSellerId:', currentSellerId); // Confirmación en consola
                    Swal.fire('¡Pedido confirmado!', response.message, 'success');
                    items = [];
                    $('#cart-count').text(`(${response.newCartCount})`);

                } else {
                    Swal.fire('Error', response.message, 'error');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error status:', status);
                console.error('Error message:', xhr.responseText);
                Swal.fire('Error', 'Hubo un problema al crear el pedido.', 'error');
            }
        });
    }

    function calcularTotal(items) {
        let total = 0;
        // Convierte el objeto 'items' en un arreglo si no lo es.
        const itemsArray = Array.isArray(items) ? items : Object.values(items);
        console.log('Items en calcular total:', itemsArray); // Verificar cómo se ve ahora itemsArray

        itemsArray.forEach(item => {
            total += item.precio * item.cantidad;
        });

        return total;
    }

    function updateCartCountOnPageLoad() {
        $.ajax({
            url: '/cart/count',
            method: 'GET',
            success: function(response) {
                $('#cart-count').text(`(${response.count})`); // Asegúrate de que la respuesta tiene la propiedad 'count'
            },
            error: function() {
                console.log('No se pudo obtener la cuenta del carrito.');
            }
        });
    }

    $(document).on('click', '.remove-item', function() {
        var itemId = $(this).data('id');
        $.ajax({
            url: `/cart/remove/${itemId}`,
            method: 'POST',
            data: {
                _token: "{{ csrf_token() }}",
                id: itemId
            },
            success: function(response) {
                Swal.fire('Eliminado!', 'Ítem eliminado del carrito.', 'success');
                // Actualiza el carrito o recarga la visualización del carrito aquí
                $('#cart-count').text(`(${response.newCartCount})`);
            },
            error: function() {
                Swal.fire('Error', 'No se pudo eliminar el ítem.', 'error');
            }
        });
    });

    $(document).on('click', '#empty-cart', function() {
        $.ajax({
            url: '/cart/empty',
            method: 'POST',
            data: {
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                currentSellerId = null;
                console.log('Carrito vaciado. currentSellerId:', currentSellerId); // Confirmación en consola
                Swal.fire('Carrito Vacío!', response.message, 'success');
                // Recarga la visualización del carrito aquí
                $('#cart-count').text(`(${response.newCartCount})`);


            },
            error: function() {
                Swal.fire('Error', 'No se pudo vaciar el carrito.', 'error');
            }
        });
    });
</script>



<style>
    .collapse {
        visibility: visible !important;
    }

    .opciones-items {
        display: flex !important;
    }

    .item button {
        display: flex;
        margin: 0 auto;
    }

    .item-info {
        padding-top: 10px;
    }

    .item-carrito {
        margin-top: 10px;
        width: 60% !important;
    }

    .btn-info {
        color: #fff !important;
        background-color: #138496 !important;
        border-color: #117a8b !important;
    }

    .btn-success {
        background-color: green !important;
    }

    /* Estilos para botones dentro de la lista de carrito en Swal */
    .remove-item {
        margin-left: 10px;
        border: none;
        background: transparent;
        color: red;
        cursor: pointer;
    }

    #empty-cart {
        width: 50%;
        background-color: #ff4444;
        color: white;
        text-align: center;
        padding: 8px;
        margin-top: 10px;
        border-radius: 5px;
    }

    .lista-items {
        padding: 5px;
    }

    button {
        transition: background-color 0.3s, color 0.3s;
    }

    .remove-item {
        padding: 4px 8px !important;
    }

    .info-items {
        text-align: center;
    }
</style>
</body>