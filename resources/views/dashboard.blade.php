<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

</head>
<body>

<div class="container">
@if(Auth::check())
  
@else 
  <script>window.location = "/login";</script>
@endif
  <h1>Employee List</h1>
  <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Add Employee</button>

<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
  <div class="modal-dialog">
  
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-body">
      <form  onsubmit="create_new_user()" enctype="multipart/form-data" >
    @csrf
    <div class="form-group">
    <label>name</label>
    <input type="text" name="name" class="form-control p_input">
  </div>

  <div class="form-group">
    <label>Email</label>
    <input type="email" name="email" class="form-control p_input">
  </div>
  <div class="form-group">
    <label>image *</label>
    <input type="file" name="file" id="input_files" class="form-control p_input">
  </div>

  <div class="text-center">
    <button type="submit" class="btn btn-primary btn-block enter-btn">submit</button>
  </div>
  </form>


  </div>

</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
    
  </div>
</div>

</div>
<p class="sign-up"><a href="{{ route('logout') }}"> Logout</a></p>

<table class="table" id ="tab_le"   onclick="delete_id()" >
    <thead>
      <tr>
        <th>Firstname</th>
        <th>Lastname</th>
        <th>Email</th>
      </tr>
    </thead>
    <tbody id ="new"  > 
      <tr >
       <td></td>
      </tr>
    </tbody>
  </table>
</div>

<script>

function employe_list(){
  axios.get('employe_list')
  .then(function (response) {
    let row="";
    const tab= document.getElementById('tab_le');
  
    for(let i=0; i<response.data.data.length; i++){
       row+='<tr>';   
     row+= '<td>'+response.data.data[i].id 
     +'</td>'+ '<td>'+response.data.data[i].name +'</td>'
     
      + '<td>' +response.data.data[i].email +'</td>'
      + '<td>' + '<img src="' + response.data.data[i]['image']  + '"  width="100" height="100"/>' +'</td>'
    
       '</tr>'
    }
    document.getElementById("tab_le").innerHTML = row; 
  })
  .catch(function (error) {
    // handle error
    console.log(error);
  })
  .then(function () {
    // always executed
  });

}




function  create_new_user(){
    event.preventDefault();

       let form= document.querySelectorAll('input');
       let file = document.getElementById("input_files").files[0]
       let name = form[1].value;
       let email=form[2].value;

       let data = new FormData();
       data.append('file', file, file.name)
       data.append('name', name)
       data.append('email', email)
      
       let settings = { headers: { 'content-type': 'multipart/form-data' } }
       axios.post('employee_create', data, settings)
      .then(response => {
        alert(response.data.error);
      }).catch(response => {
      console.log(response)
      })
           
      employe_list();
    }


    employe_list();

</script>
</body>
</html>
