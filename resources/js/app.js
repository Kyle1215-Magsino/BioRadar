import './bootstrap';

// Import jQuery
import $ from 'jquery';
window.$ = window.jQuery = $;

// Import dependencies for DataTables buttons BEFORE DataTables
import JSZip from 'jszip';
window.JSZip = JSZip;

import pdfMake from 'pdfmake/build/pdfmake';
import pdfFonts from 'pdfmake/build/vfs_fonts';
pdfMake.vfs = pdfFonts.pdfMake.vfs;
window.pdfMake = pdfMake;

// Import DataTables core
import DataTable from 'datatables.net-dt';

// Import DataTables extensions
import 'datatables.net-responsive-dt';
import 'datatables.net-buttons-dt';
import 'datatables.net-buttons/js/buttons.html5.mjs';
import 'datatables.net-buttons/js/buttons.print.mjs';

// Make DataTable available globally
window.DataTable = DataTable;

// Import SweetAlert2
import Swal from 'sweetalert2';
window.Swal = Swal;
