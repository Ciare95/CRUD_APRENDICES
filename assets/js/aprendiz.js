// Función para eliminar un aprendiz
function eliminarAprendiz(id, nombre) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: `¿Deseas eliminar al aprendiz ${nombre}?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Realizar la petición AJAX para eliminar
            fetch(`controller/AprendizController.php?action=eliminar&id=${id}`)
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        Swal.fire(
                            '¡Eliminado!',
                            'El aprendiz ha sido eliminado correctamente.',
                            'success'
                        ).then(() => {
                            window.location.reload();
                        });
                    } else {
                        Swal.fire(
                            'Error',
                            data.message || 'Hubo un error al eliminar el aprendiz',
                            'error'
                        );
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire(
                        'Error',
                        'Hubo un error en la comunicación con el servidor',
                        'error'
                    );
                });
        }
    });
}

// Función para crear o actualizar un aprendiz
function guardarAprendiz(formId, esEdicion = false) {
    const form = document.getElementById(formId);
    if (!form) {
        console.error('Formulario no encontrado:', formId);
        return false;
    }

    // Validar el formulario antes de enviar
    if (!form.checkValidity()) {
        form.classList.add('was-validated');
        return false;
    }

    const formData = new FormData(form);
    
    // Mostrar loading
    Swal.fire({
        title: 'Guardando...',
        text: 'Por favor espere',
        allowOutsideClick: false,
        showConfirmButton: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    // Construir la URL correcta según la ubicación actual
    const controllerUrl = form.getAttribute('action') || 
                         (window.location.pathname.includes('/view/') ? 
                         '../../controller/AprendizController.php' : 
                         'controller/AprendizController.php');

    // Realizar la petición AJAX
    fetch(controllerUrl, {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Error en la respuesta del servidor');
        }
        return response.json();
    })
    .then(data => {
        if (data.status === 'success') {
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: esEdicion ? 'Aprendiz actualizado correctamente' : 'Aprendiz creado correctamente',
                confirmButtonText: 'OK'
            }).then(() => {
                // Redirigir a la página principal
                window.location.href = window.location.pathname.includes('/view/') ? 
                                     '../../index.php' : 
                                     'index.php';
            });
        } else {
            throw new Error(data.message || 'Error al procesar la solicitud');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: error.message || 'Hubo un error en la comunicación con el servidor'
        });
    });

    return false; // Prevenir el envío normal del formulario
} 