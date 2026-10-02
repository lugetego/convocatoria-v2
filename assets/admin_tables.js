/*
 * Entry point exclusivo de las 2 páginas admin con tablas (listado y consulta).
 * No se carga en el resto del sitio: evita duplicar jQuery en páginas que no lo necesitan.
 */
import 'datatables.net-bs5/css/dataTables.bootstrap5.min.css';
import 'datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css';
import $ from 'jquery';

// DataTables busca window.jQuery para adjuntarse como plugin ($.fn.DataTable). Los imports
// estáticos de arriba/abajo se "hoistean" antes que cualquier otra línea del módulo, así que
// esta asignación por sí sola NO alcanza a correr antes de ellos: por eso los módulos de
// datatables.net se cargan con import() dinámico, que sí respeta el orden real de ejecución.
window.jQuery = window.$ = $;

await import('datatables.net-bs5');
await import('datatables.net-buttons-bs5');

$(function () {
    $('#example').DataTable({
        dom: 'Bfrtip',
        lengthMenu: [
            [25, 50, -1],
            ['25', '50', 'Mostrar todos'],
        ],
        pagingType: 'full_numbers',
        language: {
            url: 'https://cdn.datatables.net/plug-ins/2.1.8/i18n/es-ES.json',
        },
        buttons: [
            { extend: 'pageLength' },
        ],
    });
});
