<footer>
<footer class="bg-gray-900 py-4">
    <div class="container mx-auto flex justify-center items-center">
        <p class="text-white text-sm">&copy; 2024 Todos los derechos reservados</p>
    </div>
</footer>

<!-- Bibliotecas de JavaScript de Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>

<!-- Script para DataTable -->
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Tailwind CSS -->
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">


<script>
    $(document).ready(function() {
        if ($.fn.DataTable.isDataTable('#tabla_id')) {
            $('#tabla_id').DataTable().destroy();
        }

        $("#tabla_id").dataTable({
            "pageLength": 3,
            "lengthMenu": [
                [3, 10, 25, 50],
                [3, 10, 25, 50]
            ],
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.13.1/i18n/es-ES.json"
            }
        });

        // Función para obtener parámetros de la URL
        function getParameterByName(name, url) {
            if (!url) url = window.location.href;
            name = name.replace(/[\[\]]/g, "\\$&");
            var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
                results = regex.exec(url);
            if (!results) return null;
            if (!results[2]) return '';
            return decodeURIComponent(results[2].replace(/\+/g, " "));
        }

        // Obtener el mensaje de éxito de la URL
        var successMessage = getParameterByName('mensaje');
        if (successMessage) {
            // Mostrar el mensaje de éxito usando SweetAlert2
            Swal.fire({
                icon: 'success',
                title: successMessage,
                showConfirmButton: false,
                timer: 1500
            });
        }
    });

    function borrar(id) {   
        Swal.fire({
            title: "¿Desea borrar el registro?",
            showCancelButton: true,
            confirmButtonText: "Sí, borrar",
        }).then((result) => {
            if (result.isConfirmed) {
                window.location = "index.php?txtID=" + id;
            }
        });
    }
</script>
</body>
</html>
</footer>

