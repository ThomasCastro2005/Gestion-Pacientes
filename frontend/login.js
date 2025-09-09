const apiUrl = 'http://127.0.0.1:8000/api';

const loginForm = document.getElementById('loginForm');

function mostrarMensaje(tipo, mensaje) {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${tipo} alert-dismissible fade show`;
    alertDiv.role = "alert";
    alertDiv.innerHTML = `${mensaje}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>`;
    document.getElementById('alertContainer').appendChild(alertDiv);
    setTimeout(() => alertDiv.remove(), 4000);
}

loginForm.addEventListener('submit', (e) => {
    e.preventDefault();
    const data = {
        email: document.getElementById('email').value,
        password: document.getElementById('password').value
    };

    axios.post(`${apiUrl}/login`, data)
        .then(res => {
            mostrarMensaje('success', 'Login exitoso');
            // Guardar token en localStorage
            localStorage.setItem('token', res.data.token);

            // Redirigir al frontend de pacientes
            window.location.href = 'index.html';
        })
        .catch(err => {
            mostrarMensaje('danger', 'Credenciales incorrectas');
        });
});
