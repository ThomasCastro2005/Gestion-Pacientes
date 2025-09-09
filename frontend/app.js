// app.js
        let pacientes = [];
        let pacientesOriginales = [];
        let municipios = []; // Todos los municipios
        let currentPage = 1;
        const rowsPerPage = 5;

        const apiUrl = 'http://127.0.0.1:8000/api'; // Ajusta según tu backend
        const token = localStorage.getItem('token'); // Token JWT guardado tras login

        // -----------------------------
        // Cargar datos de selects
        // -----------------------------
        async function cargarSelects() {
            try {
                const [tiposDocRes, generosRes, departamentosRes, municipiosRes] = await Promise.all([
                    axios.get(`${apiUrl}/tipos_documento`, { headers: { Authorization: `Bearer ${token}` } }),
                    axios.get(`${apiUrl}/generos`, { headers: { Authorization: `Bearer ${token}` } }),
                    axios.get(`${apiUrl}/departamentos`, { headers: { Authorization: `Bearer ${token}` } }),
                    axios.get(`${apiUrl}/municipios`, { headers: { Authorization: `Bearer ${token}` } })
                ]);

                municipios = municipiosRes.data; // Guardamos todos los municipios

                // Cargar tipos de documento
                const tipoSelect = document.getElementById('paciente_tipo_documento');
                tiposDocRes.data.forEach(t => tipoSelect.appendChild(new Option(t.nombre, t.id)));

                // Cargar géneros
                const generoSelect = document.getElementById('paciente_genero');
                generosRes.data.forEach(g => generoSelect.appendChild(new Option(g.nombre, g.id)));

                // Cargar departamentos
                const departamentoSelect = document.getElementById('paciente_departamento');
                departamentosRes.data.forEach(d => departamentoSelect.appendChild(new Option(d.nombre, d.id)));

                // Filtrar municipios cuando cambia el departamento
                departamentoSelect.addEventListener('change', (e) => {
                    const deptoId = parseInt(e.target.value);
                    const municipioSelect = document.getElementById('paciente_municipio');
                    municipioSelect.innerHTML = '<option value="" disabled selected>Selecciona un municipio</option>'; // Limpiar y añadir opción por defecto
                    municipios
                        .filter(m => m.departamento_id === deptoId)
                        .forEach(m => municipioSelect.appendChild(new Option(m.nombre, m.id)));
                });

            } catch (error) {
                showAlert('Error al cargar los datos de los selects', 'danger');
                console.error(error);
            }
        }

        // -----------------------------
        // Obtener pacientes
        // -----------------------------
        async function fetchPacientes() {
            try {
                const res = await axios.get(`${apiUrl}/pacientes`, { headers: { Authorization: `Bearer ${token}` } });
                pacientes = res.data;
                pacientesOriginales = [...pacientes];
                renderTable();
                setupPagination();
            } catch (error) {
                showAlert('Error al cargar los pacientes', 'danger');
                console.error(error);
            }
        }

        // -----------------------------
        // Renderizar tabla
        // -----------------------------
        function renderTable() {
            const tableBody = document.getElementById('pacientesTableBody');
            tableBody.innerHTML = '';

            const start = (currentPage - 1) * rowsPerPage;
            const end = start + rowsPerPage;
            const pageItems = pacientes.slice(start, end);

            pageItems.forEach(paciente => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${paciente.id}</td>
                    <td>${paciente.nombre}</td>
                    <td>${paciente.correo}</td>
                    <td>${paciente.numero_documento}</td>
                    <td>${paciente.tipo_documento ? paciente.tipo_documento.nombre : ''}</td>
                    <td>${paciente.genero ? paciente.genero.nombre : ''}</td>
                    <td>${paciente.departamento ? paciente.departamento.nombre : ''}</td>
                    <td>${paciente.municipio ? paciente.municipio.nombre : ''}</td>
                    <td>
                        <button class="btn btn-sm btn-warning me-1" onclick="editarPaciente(${paciente.id})">Editar</button>
                        <button class="btn btn-sm btn-danger" onclick="eliminarPaciente(${paciente.id})">Eliminar</button>
                    </td>
                `;
                tableBody.appendChild(row);
            });
        }

        // -----------------------------
        // Paginación
        // -----------------------------
        function setupPagination() {
            const container = document.getElementById('paginationContainer');
            container.innerHTML = '';

            const pageCount = Math.ceil(pacientes.length / rowsPerPage);
            for (let i = 1; i <= pageCount; i++) {
                const btn = document.createElement('button');
                btn.textContent = i;
                btn.className = 'btn btn-outline-primary btn-sm me-1';
                if (i === currentPage) btn.classList.add('active');
                btn.addEventListener('click', () => {
                    currentPage = i;
                    renderTable();
                    setupPagination();
                });
                container.appendChild(btn);
            }
        }

        // -----------------------------
        // Mostrar alertas
        // -----------------------------
        function showAlert(message, type = 'success') {
            const alertContainer = document.getElementById('alertContainer');
            const alert = document.createElement('div');
            alert.className = `alert alert-${type} alert-dismissible fade show`;
            alert.innerHTML = `
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            alertContainer.appendChild(alert);
            setTimeout(() => alert.remove(), 3000);
        }

        // -----------------------------
        // Limpiar formulario
        // -----------------------------
        function limpiarFormulario() {
            document.getElementById('paciente_id').value = '';
            document.getElementById('paciente_nombre').value = '';
            document.getElementById('paciente_email').value = '';
            document.getElementById('paciente_numero_documento').value = '';
            document.getElementById('paciente_tipo_documento').value = '';
            document.getElementById('paciente_genero').value = '';
            document.getElementById('paciente_departamento').value = '';
            document.getElementById('paciente_municipio').innerHTML = '<option value="" disabled selected>Selecciona un municipio</option>'; // Limpiar opciones y añadir la opción por defecto
            document.getElementById('pacienteModalLabel').textContent = 'Crear Paciente';
        }

        // -----------------------------
        // Búsqueda de pacientes
        // -----------------------------
        document.getElementById('buscarPaciente').addEventListener('input', (e) => {
            const query = e.target.value.toLowerCase();
            pacientes = pacientesOriginales.filter(p =>
                p.nombre.toLowerCase().includes(query) ||
                p.correo.toLowerCase().includes(query) ||
                p.numero_documento.includes(query)
            );
            currentPage = 1;
            renderTable();
            setupPagination();
        });

        // -----------------------------
        // Editar paciente
        // -----------------------------
        function editarPaciente(id) {
            const paciente = pacientesOriginales.find(p => p.id === id);
            if (!paciente) return showAlert('Paciente no encontrado', 'danger');

            const modal = new bootstrap.Modal(document.getElementById('pacienteModal'));
            modal.show();

            document.getElementById('pacienteModalLabel').textContent = 'Editar Paciente';
            document.getElementById('paciente_id').value = paciente.id;
            document.getElementById('paciente_nombre').value = paciente.nombre;
            document.getElementById('paciente_email').value = paciente.correo;
            document.getElementById('paciente_numero_documento').value = paciente.numero_documento;
            document.getElementById('paciente_tipo_documento').value = paciente.tipo_documento ? paciente.tipo_documento.id : '';
            document.getElementById('paciente_genero').value = paciente.genero ? paciente.genero.id : '';
            document.getElementById('paciente_departamento').value = paciente.departamento ? paciente.departamento.id : '';

            // Filtrar municipios según departamento
            const deptoId = paciente.departamento ? paciente.departamento.id : null;
            const municipioSelect = document.getElementById('paciente_municipio');
            municipioSelect.innerHTML = '<option value="" disabled selected>Selecciona un municipio</option>';
            municipios
                .filter(m => m.departamento_id === deptoId)
                .forEach(m => municipioSelect.appendChild(new Option(m.nombre, m.id)));
            document.getElementById('paciente_municipio').value = paciente.municipio ? paciente.municipio.id : '';
        }

        // -----------------------------
        // Eliminar paciente
        // -----------------------------
        function eliminarPaciente(id) {
            if (!confirm('¿Deseas eliminar este paciente?')) return;

            axios.delete(`${apiUrl}/pacientes/${id}`, { headers: { Authorization: `Bearer ${token}` } })
                .then(res => {
                    showAlert('Paciente eliminado correctamente');
                    fetchPacientes();
                })
                .catch(err => {
                    showAlert('Error al eliminar paciente', 'danger');
                    console.error(err);
                });
        }

        // -----------------------------
        // Crear o actualizar paciente
        // -----------------------------
        document.getElementById('pacienteForm').addEventListener('submit', (e) => {
            e.preventDefault();
            const id = document.getElementById('paciente_id').value;

            // Evitar enviar campos vacíos o inválidos
            const tipo_documento_id = parseInt(document.getElementById('paciente_tipo_documento').value);
            const genero_id = parseInt(document.getElementById('paciente_genero').value);
            const departamento_id = parseInt(document.getElementById('paciente_departamento').value);
            const municipio_id = parseInt(document.getElementById('paciente_municipio').value);

            // Validación de campos de selección para evitar el error 422
            if (isNaN(tipo_documento_id) || isNaN(genero_id) || isNaN(departamento_id) || isNaN(municipio_id)) {
                showAlert('Por favor, selecciona una opción en todos los campos requeridos.', 'danger');
                return;
            }

            const data = {
                nombre: document.getElementById('paciente_nombre').value.trim(),
                correo: document.getElementById('paciente_email').value.trim(),
                numero_documento: document.getElementById('paciente_numero_documento').value.trim(),
                tipo_documento_id: tipo_documento_id,
                genero_id: genero_id,
                departamento_id: departamento_id,
                municipio_id: municipio_id
            };

            const request = id
                ? axios.put(`${apiUrl}/pacientes/${id}`, data, { headers: { Authorization: `Bearer ${token}` } })
                : axios.post(`${apiUrl}/pacientes`, data, { headers: { Authorization: `Bearer ${token}` } });

            request
                .then(res => {
                    showAlert(`Paciente ${id ? 'actualizado' : 'creado'} correctamente`);
                    fetchPacientes();
                    bootstrap.Modal.getInstance(document.getElementById('pacienteModal')).hide();
                    limpiarFormulario();
                })
                .catch(err => {
                    if (err.response && err.response.status === 422) {
                        // Mostrar errores de validación
                        const errors = err.response.data.errors || {};
                        const messages = Object.values(errors).flat().join(', ');
                        showAlert(`Error de validación: ${messages}`, 'danger');
                    } else {
                        showAlert(`Error al ${id ? 'actualizar' : 'crear'} paciente`, 'danger');
                    }
                    console.error(err);
                });
        });

        // -----------------------------
        // Logout
        // -----------------------------
        document.getElementById('btnCerrarSesion').addEventListener('click', () => {
            axios.post(`${apiUrl}/logout`, {}, { headers: { Authorization: `Bearer ${token}` } })
                .then(() => {
                    showAlert('Sesión cerrada exitosamente', 'success');
                    localStorage.removeItem('token');
                    setTimeout(() => window.location.href = 'login.html', 1000);
                })
                .catch(err => {
                    showAlert('Error al cerrar sesión', 'danger');
                    console.error(err);
                });
        });

        // -----------------------------
        // Inicialización
        // -----------------------------
        cargarSelects();
        fetchPacientes();