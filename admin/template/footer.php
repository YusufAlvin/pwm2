<!-- Main Footer -->
<footer class="main-footer">
    
</footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="asset/plugins/jquery/jquery.min.js"></script>
<!-- Datatables -->
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>
<!-- Bootstrap 4 -->
<script src="asset/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="asset/dist/js/adminlte.min.js"></script>
<!-- Page Spesific script -->
<script>
  $(document).ready( function () {
    let t = $('#item').DataTable({
      dom: 'Bfrtip',
      lengthMenu: [
        [ 10, 25, 50, -1 ],
        [ '10 rows', '25 rows', '50 rows', 'Show all' ]
      ],
      buttons: [
        'pageLength', 
        {
          extend: 'excelHtml5',
          exportOptions: {
              columns: [0,1,2,3,4,5,6,7]
          }
        }
      ],
      columnDefs: [ {
        "searchable": false,
        "orderable": false,
        "targets": 0
      } ],
      order: [[ 1, 'asc' ]]
    });
    t.on( 'order.dt search.dt', function () {
      t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
          cell.innerHTML = i+1;
          t.cell(cell).invalidate('dom');
      } );
    } ).draw();

    let material = $('#material').DataTable({
      dom: 'Bfrtip',
      lengthMenu: [
        [ 10, 25, 50, -1 ],
        [ '10 rows', '25 rows', '50 rows', 'Show all' ]
      ],
      buttons: [
        'pageLength',
        {
          extend: 'excelHtml5',
          exportOptions: {
              columns: [0,1,2,3,4]
          }
        }
      ],
      columnDefs: [ {
        "searchable": false,
        "orderable": false,
        "targets": 0
      } ],
      order: [[ 1, 'asc' ]]
    });
    material.on( 'order.dt search.dt', function () {
      material.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
          cell.innerHTML = i+1;
          material.cell(cell).invalidate('dom');
      } );
    } ).draw();

    let bom = $('#bom').DataTable({
      dom: 'Bfrtip',
      lengthMenu: [
        [ 10, 25, 50, -1 ],
        [ '10 rows', '25 rows', '50 rows', 'Show all' ]
      ],
      buttons: [
        'pageLength',
        // {
        //   extend: 'excelHtml5',
        //   exportOptions: {
        //       columns: [0,1,2,3,4]
        //   }
        // }
      ],
      columnDefs: [ {
        "searchable": false,
        "orderable": false,
        "targets": 0
      } ],
      order: [[ 1, 'asc' ]]
    });
    bom.on( 'order.dt search.dt', function () {
      bom.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
          cell.innerHTML = i+1;
          bom.cell(cell).invalidate('dom');
      } );
    } ).draw();

    let bomDetail = $('#bom-detail').DataTable({
      dom: 'Bfrtip',
      lengthMenu: [
        [ 10, 25, 50, -1 ],
        [ '10 rows', '25 rows', '50 rows', 'Show all' ]
      ],
      buttons: [
        'pageLength',
        {
          extend: 'excelHtml5',
          exportOptions: {
              columns: [0,1,2,3,4,5,6]
          }
        }
      ],
      columnDefs: [ {
        "searchable": false,
        "orderable": false,
        "targets": 0
      } ],
      order: [[ 1, 'asc' ]]
    });
    bomDetail.on( 'order.dt search.dt', function () {
      bomDetail.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
          cell.innerHTML = i+1;
          bomDetail.cell(cell).invalidate('dom');
      } );
    } ).draw();

    let so = $('#so').DataTable({
      dom: 'Bfrtip',
      lengthMenu: [
        [ 10, 25, 50, -1 ],
        [ '10 rows', '25 rows', '50 rows', 'Show all' ]
      ],
      buttons: [
        'pageLength',
        // {
        //   extend: 'excelHtml5',
        //   exportOptions: {
        //       columns: [0,1,2,3,4,5,6]
        //   }
        // }
      ],
      columnDefs: [ {
        "searchable": false,
        "orderable": false,
        "targets": 0
      } ],
      order: [[ 1, 'asc' ]]
    });
    so.on( 'order.dt search.dt', function () {
      so.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
          cell.innerHTML = i+1;
          so.cell(cell).invalidate('dom');
      } );
    } ).draw();

    let soExcel = $('#so-excel').DataTable({
      dom: 'Bfrtip',
      lengthMenu: [
        [ 10, 25, 50, -1 ],
        [ '10 rows', '25 rows', '50 rows', 'Show all' ]
      ],
      buttons: [
        'pageLength',
        {
          extend: 'excelHtml5',
          exportOptions: {
              columns: [0,1,2,3,4,5,6,7,8,9,10,11,12]
          }
        }
      ],
      columnDefs: [ {
        "searchable": false,
        "orderable": false,
        "targets": 0
      } ],
      order: [[ 1, 'asc' ]]
    });
    soExcel.on( 'order.dt search.dt', function () {
      soExcel.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
          cell.innerHTML = i+1;
          soExcel.cell(cell).invalidate('dom');
      } );
    } ).draw();

    let uom = $('#uom-table').DataTable({
      dom: 'Bfrtip',
      lengthMenu: [
        [ 10, 25, 50, -1 ],
        [ '10 rows', '25 rows', '50 rows', 'Show all' ]
      ],
      buttons: [
        'pageLength',
        {
          extend: 'excelHtml5',
          exportOptions: {
              columns: [0,1]
          }
        }
      ],
      columnDefs: [ {
        "searchable": false,
        "orderable": false,
        "targets": 0
      } ],
      order: [[ 1, 'asc' ]]
    });
    uom.on( 'order.dt search.dt', function () {
      uom.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
          cell.innerHTML = i+1;
          uom.cell(cell).invalidate('dom');
      } );
    } ).draw();

} );
</script>
</body>
</html>