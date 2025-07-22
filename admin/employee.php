<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>

<body class="hold-transition skin-blue sidebar-mini" >
  <style>
    .qrCode {
      padding: 5px;
      background: white;
      width: 68px;
    }
  </style>
  <div class="wrapper">

    <?php include 'includes/navbar.php'; ?>
    <?php include 'includes/menubar.php'; ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <section class="content-header">
        <h1>
          Lista de Empleado
        </h1>
        <ol class="breadcrumb">
          <li><a href="home.php"><i class="fa fa-dashboard"></i> Principal</a></li>
          <li>Empleados</li>
          <li class="active">Lista de Empleados</li>
        </ol>
      </section>
      <!-- Main content -->
      <section class="content">
        <?php
        if (isset($_SESSION['error'])) {
          echo "
            <div class='alert alert-danger alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-warning'></i> Error!</h4>
              " . $_SESSION['error'] . "
            </div>
          ";
          unset($_SESSION['error']);
        }
        if (isset($_SESSION['success'])) {
          echo "
            <div class='alert alert-success alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-check'></i> Exito!</h4>
              " . $_SESSION['success'] . "
            </div>
          ";
          unset($_SESSION['success']);
        }
        ?>
        <div class="row">

          <div class="col-xs-12">
            <div class="box">
              <div class="box-header with-border">
                <a href="#addnew" data-toggle="modal" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-plus"></i> Nuevo</a>
              </div>
              <div class="box-body">
                <table id="example1" class="table table-bordered">
                  <thead>
                    <th>DNI Empleado</th>
                    <th>QR</th>
                    <th>Foto</th>
                    <th>Nombre</th>
                    <th>Posición</th>
                    <th>Calendario</th>
                    <th>Miembro desde</th>
                    <th>Opciones</th>
                  </thead>
                  <tbody>
                    <?php
                    $sql = "SELECT *, employees.id AS empid FROM employees LEFT JOIN position ON position.id=employees.position_id LEFT JOIN schedules ON schedules.id=employees.schedule_id";
                    $query = $conn->query($sql);
                    while ($row = $query->fetch_assoc()) {
                    ?>
                      <tr class="boxbody">
                        <td><?php echo $row['employee_id']; ?></td>
                        <td>
                          <div class="qrCode"></div>
                        </td>
                        <td><img src="<?php echo (!empty($row['photo'])) ? '../images/' . $row['photo'] : '../images/profile.jpg'; ?>" width="30px" height="30px"> <a href="#edit_photo" data-toggle="modal" class="pull-right photo" data-id="<?php echo $row['empid']; ?>"><span class="fa fa-edit"></span></a></td>
                        <td><?php echo $row['firstname'] . ' ' . $row['lastname']; ?></td>
                        <td><?php echo $row['description']; ?></td>
                        <td><?php echo date('h:i A', strtotime($row['time_in'])) . ' - ' . date('h:i A', strtotime($row['time_out'])); ?></td>
                        <td><?php echo date('M d, Y', strtotime($row['created_on'])) ?></td>
                        <td>
                          <button class="btn btn-success btn-sm edit btn-flat" data-id="<?php echo $row['empid']; ?>"><i class="fa fa-edit"></i> Editar</button>
                          <button class="btn btn-danger btn-sm delete btn-flat" data-id="<?php echo $row['empid']; ?>"><i class="fa fa-trash"></i> Eliminar</button>
                        </td>
                      </tr>
                    <?php
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>

    <?php include 'includes/footer.php'; ?>
    <?php include 'includes/employee_modal.php'; ?>
  </div>
  <?php include 'includes/scripts.php'; ?>
  <script type="text/javascript" src="https://hovertree.com/texiao/html5/index/hovertreewelcome.js"></script>
  <script>
    $(function() {
      $('.edit').click(function(e) {
        e.preventDefault();
        $('#edit').modal('show');
        var id = $(this).data('id');
        getRow(id);
      });

      $('.delete').click(function(e) {
        e.preventDefault();
        $('#delete').modal('show');
        var id = $(this).data('id');
        getRow(id);
      });

      $('.photo').click(function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        getRow(id);
      });

    });

    function getRow(id) {
      $.ajax({
        type: 'POST',
        url: 'employee_row.php',
        data: {
          id: id
        },
        dataType: 'json',
        success: function(response) {
          $('.empid').val(response.empid);
          $('.employee_id').html(response.employee_id);
          $('.del_employee_name').html(response.firstname + ' ' + response.lastname);
          $('#employee_name').html(response.firstname + ' ' + response.lastname);
          $('#edit_firstname').val(response.firstname);
          $('#edit_lastname').val(response.lastname);
          $('#edit_address').val(response.address);
          $('#datepicker_edit').val(response.birthdate);
          $('#edit_contact').val(response.contact_info);
          $('#gender_val').val(response.gender).html(response.gender);
          $('#position_val').val(response.position_id).html(response.description);
          $('#schedule_val').val(response.schedule_id).html(response.time_in + ' - ' + response.time_out);
        }
      });
    }
  </script>
  <script>
    $(document).ready(function() {
      // Generar códigos QR para los datos existentes en la tabla
      $('.qrCode').each(function(index, element) {
        var codigo = $(this).closest('tr').find('td:first-child').text();
        generarQRCode(element, codigo);
      });
    });

    function agregarFila() {
      var codigo = document.getElementById("codigo").value;
      var nombre = document.getElementById("nombre").value;

      var tabla = document.getElementById("miTabla");
      var fila = tabla.insertRow();

      var celdaCodigo = fila.insertCell();
      var celdaCodigoQR = fila.insertCell();
      var celdaNombre = fila.insertCell();

      celdaCodigo.innerHTML = codigo;
      celdaCodigoQR.innerHTML = '<div class="qrCode"></div>';
      celdaNombre.innerHTML = nombre;

      generarQRCode(celdaCodigoQR.firstChild, codigo);
    }

    function generarQRCode(elemento, codigo) {
      var qrCode = new QRCode(elemento, {
        text: codigo,
        width: 58,
        height: 58
      });
    }
  </script>
</body>

</html>