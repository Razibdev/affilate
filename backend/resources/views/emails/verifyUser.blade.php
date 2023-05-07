<!DOCTYPE html>
<html>
  <head>
    <title>Welcome Email</title>
  </head>
  <body>
    <h2>Welcome to the site {{$affliate['name']}}</h2>
    <br/>
    Your registered email-id is {{$affliate['email']}} , Please click on the below link to verify your email account
    <br/>
   
    <a href="{{url('affliate/verify', $affliate->verifyAffliate->token)}}">Verify Email</a>
  </body>
</html>