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
  <h2>Stacked form</h2>
  <form  onsubmit="login()">
    @csrf
  <div class="form-group">
    <label>Email</label>
    <input type="email" name="email" class="form-control p_input">
  </div>
  <div class="form-group">
    <label>Password *</label>
    <input type="password" name="password" class="form-control p_input">
  </div>

  <div class="text-center">
    <button type="submit" class="btn btn-primary btn-block enter-btn">Login</button>
  </div>
  </form>

  <p class="sign-up">Don't have an Account?<a href="{{ route('register') }}"> Sign Up</a></p>

</div>
<script>
function  login(){
    event.preventDefault();

       let form= document.querySelectorAll('input');
       let email = form[1].value;
       let password=form[2].value;

       axios.post('login_user', {
        email: email,
        password:password,
         })
           .then(function (response) {
          if(response.data.success==1){
            alert(response.data.error);
            window.location.href = "{{URL::to('dashboard')}}"
          }   
         alert(response.data.error);
        }) 
    }

</script>
</body>
</html>
