<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script>
    $(document).ready(function(){
        $('#NewModal').on('click', function(){
          $('#SubmitForm')[0].reset();
          $('#id').val('');

        });

        $('#SubmitForm').on('submit', function(e) {  // Fix syntax error
            e.preventDefault();
            var data = $('#SubmitForm').serialize();

            $.ajax({
              url: "savedata",
              type: "POST",
              data: {
                "_token":"{{ csrf_token() }}",
                data:data
              },
              success: function (response) {
                $('#respanel').html(response);
                $('#SubmitForm')[0].reset();
                $('#myModal').modal('hide');
                fetchrecord();
              }
            });

        });

        $(document).on('click', '.btn-warning', function(e){
          e.preventDefault();
          var id=$(this).val();
          
          $.ajax({
            type: "POST",
            url: "editdata",
            data: {
                "_token":"{{ csrf_token() }}",
                id:id
              },
            success: function (response) {
              $('#SubmitForm')[0].reset();
              $('#id').val(response.id);
              $('#username').val(response.username);
              $('#email').val(response.email);
              $('.btn-success').text('Update');
              $('#myModal').modal('show');
              
            }
          });

        });
        

        $(document).on('click', '.btn-danger', function(e){
          e.preventDefault();
          var id=$(this).val();
          
          $.ajax({
            type: "POST",
            url: "deletedata",
            data: {
                "_token":"{{ csrf_token() }}",
                id:id
              },
            success: function (response) {
              $('#respanel').html(response);
              fetchrecord();
            }
          });

        });

        function fetchrecord(){
          $.ajax({
            type: "get",
            url: "getdata",
            success: function (response) {
              var tr='';
              for(var i=0; i<response.length; i++){
                var id=response[i].id;
                var username=response[i].username;
                var email=response[i].email;

                tr += '<tr>';
                tr += '<td>'+ id +'</td>';
                tr += '<td>'+ username +'</td>';
                tr += '<td>'+ email +'</td>';
                tr += '<td><button value="'+id+'" class="btn btn-warning">Edit</button></td>';
                tr += '<td><button value="'+id+'" class="btn btn-danger">Delete</button></td>';
                tr += '</tr>';
              }
              $('#employee_data').html(tr);
            }
          });
        }

        fetchrecord();

    });
  </script>
</head>
<body>

<div class="container mt-3">
  <h3>Modal Example</h3>
  <p id="respanel">Click on the button to open the modal.</p>
  
  <button id="NewModal" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
    Open modal
  </button>
</div>

<!-- The Modal -->
<div class="modal" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Modal Heading</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <form id="SubmitForm">
            <div class="mb-3 mt-3">
              <input type="hidden" id="id" name="id">
              <label for="username" class="form-label">Username:</label>
              <input type="text" class="form-control" id="username" placeholder="Enter username" name="username">
            </div>
            <div class="mb-3">
              <label for="pwd" class="form-label">Password:</label>
              <input type="text" class="form-control" id="email" placeholder="Enter email" name="email">
            </div>
            <div class="form-check mb-3">
              <label class="form-check-label">
                <input class="form-check-input" type="checkbox" name="remember"> Remember me
              </label>
            </div>
            <button type="submit" class="btn btn-success" id="btnsuccess">Submit</button>
          </form>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button  type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>

<div class="container">
  <div class="row justify-content-center mt-10">
    <div class="col-md-12">
      <div class="table-responsive">
        <table class="table table-striped table-bordered">
          <thead class="table-success">
            <th>SL No</th>
            <th>Username</th>
            <th>email</th>
            <th colspan="2" align="center">Action</th>
          </thead>
          <tbody id="employee_data">

          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

</body>
</html>