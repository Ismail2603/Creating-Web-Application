<footer>
        <p>Email or contact us for more information:103845097@student.swin.edu.au</p>
        <br>
        <a>Contact Number: 0173823277</a>
</footer>
<script>
  $(function () {
    $('#example1').DataTable();
    
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false,
      "order": [[ 1, "desc" ]]
    });

  
  });

