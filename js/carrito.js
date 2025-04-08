// Ir a la página de pago
document.getElementById('continuarCompra').addEventListener('click', function () {
    fetch('php/verificar_sesion.php') 
    .then(response => response.json())
    .then(data => {
        if (data.logueado) {
            // Si el usuario está logueado, ir a la página de pago
            window.location.href = 'php/Pago.php';
        } else {
            // Si no está logueado, redirigir al login
            redirigirALogin();
        }
    });
});

// Agregar al carrito con nombre
function agregarAlCarrito(cuponId, nombreCupon, precioCupon) {
    let carrito = JSON.parse(localStorage.getItem('carrito')) || [];

    const index = carrito.findIndex(item => item.id === cuponId);
    if (index === -1) {
        carrito.push({ id: cuponId, nombre: nombreCupon, cantidad: 1, precio: precioCupon });
    } else {
        carrito[index].cantidad += 1;
    }

    localStorage.setItem('carrito', JSON.stringify(carrito));
    actualizarCarrito();
}


// Actualizar badge del carrito
function actualizarCarrito() {
    let carrito = JSON.parse(localStorage.getItem('carrito')) || [];
    let total = carrito.reduce((sum, item) => sum + item.cantidad, 0);
    document.getElementById('badgeCarrito').textContent = total;
}

// Mostrar carrito
let carritoVisible = false;
document.getElementById('carritoFlotante').addEventListener('click', function () {
    carritoVisible = !carritoVisible;
    let carritoModal = document.getElementById('carritoModal');
    let body = document.body;

    carritoModal.style.display = carritoVisible ? 'block' : 'none';
    body.classList.toggle('carrito-visible', carritoVisible);

    if (carritoVisible) mostrarCarrito();
});

function mostrarCarrito() {
    let carrito = JSON.parse(localStorage.getItem('carrito')) || [];
    let listaCarrito = document.getElementById('listaCarrito');
    listaCarrito.innerHTML = '';

    carrito.forEach(function (item) {
        let li = document.createElement('li');
        li.innerHTML = `
            <strong>${item.nombre}</strong><br>
            Cantidad:
            <button onclick="cambiarCantidad(${item.id}, -1)">-</button>
            <span>${item.cantidad}</span>
            <button onclick="cambiarCantidad(${item.id}, 1)">+</button>
            <button onclick="borrarItem(${item.id})">🗑️</button>
        `;
        listaCarrito.appendChild(li);
    });
}

function cambiarCantidad(cuponId, cambio) {
    let carrito = JSON.parse(localStorage.getItem('carrito')) || [];
    let index = carrito.findIndex(item => item.id === cuponId);

    if (index !== -1) {
        carrito[index].cantidad += cambio;

        if (carrito[index].cantidad <= 0) {
            carrito.splice(index, 1);
        }

        localStorage.setItem('carrito', JSON.stringify(carrito));
        actualizarCarrito();
        mostrarCarrito();
    }
}

function borrarItem(cuponId) {
    let carrito = JSON.parse(localStorage.getItem('carrito')) || [];
    carrito = carrito.filter(item => item.id !== cuponId);
    localStorage.setItem('carrito', JSON.stringify(carrito));
    actualizarCarrito();
    mostrarCarrito();
}

// Cerrar carrito
document.getElementById('cerrarCarrito').addEventListener('click', function () {
    document.getElementById('carritoModal').style.display = 'none';
    document.body.classList.remove('carrito-visible');
    carritoVisible = false;
});

// Inicializar badge al cargar
actualizarCarrito();

// Redirección a login si no está autenticado
function redirigirALogin() {
    if (confirm("Debes iniciar sesión para agregar al carrito. ¿Deseas ir al login ahora?")) {
        window.location.href = "php/login.php";
    }
}