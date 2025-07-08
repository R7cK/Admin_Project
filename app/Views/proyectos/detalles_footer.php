<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- Tus otros scripts (Bootstrap JS, etc.) -->
<!-- ... -->

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.0.7/js/dataTables.bootstrap5.js"></script>

<!-- TU SCRIPT DE INICIALIZACIÓN (ESTÁ PERFECTO) -->
<script>
$(document).ready(function() {
    const projectId = <?= json_encode($proyecto['id_proyecto']) ?>;

    $('#tabla-tareas-proyecto').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "<?= site_url('proyectos/ajax_get_tareas_datatable/') ?>" + projectId,
            "type": "POST"
        },
        "columns": [
            { "data": "tar_nom" },
            { "data": "stat_nom", "orderable": false },
            { "data": "vencimiento", "orderable": false }
        ],
        "order": [], // Le dice a DataTables que no aplique un orden inicial.

        "createdRow": function( row, data, dataIndex ) {
            $(row).find('td:eq(0)').attr('data-label', 'Tarea');
            $(row).find('td:eq(1)').attr('data-label', 'Estado');
            $(row).find('td:eq(2)').attr('data-label', 'Vencimiento');
        },
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/2.0.7/i18n/es-MX.json"
        },
        "pageLength": 5,
        "lengthMenu": [ [5, 10, 25, -1], [5, 10, 25, "Todos"] ],
        "searching": true,
        "ordering": true,
        "info": true,
        "paging": true
    });
});
</script>

</body>
</html>