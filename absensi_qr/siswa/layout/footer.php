<!-- JQuery -->

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- Bootstrap -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- ChartJS -->

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- SweetAlert -->

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- DataTables -->

<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>

<script>

$(document).ready(function(){

$('.datatable').DataTable({

responsive:true,

pageLength:10,

language:{

search:"Cari :",

lengthMenu:"Tampilkan _MENU_ data",

zeroRecords:"Data tidak ditemukan",

info:"Menampilkan _START_ sampai _END_ dari _TOTAL_ data",

paginate:{

previous:"←",

next:"→"

}

}

});

});

/* ===========================
   LOGOUT
=========================== */

function logout(){

Swal.fire({

title:'Logout?',

text:'Apakah Anda yakin ingin keluar dari sistem?',

icon:'question',

showCancelButton:true,

confirmButtonColor:'#dc3545',

cancelButtonColor:'#6c757d',

confirmButtonText:'Ya, Logout',

cancelButtonText:'Batal'

}).then((result)=>{

if(result.isConfirmed){

window.location='../logout.php';

}

});

}

</script>

</body>

</html>