<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
	<title>Email</title>
</head>
<body class="container-fluid p-4">
	<div class="card">
	   <h5 class="card-header text-center">Account create successfully</h5>
	   <h6 class="card-header text-justify">
		   Dear patient,
		   welcome to our hospital, we create your account successfully. Now you can login and update your full profile from setting. Otherwise you cann't take any appointment and booking any room/ward. 
	   </h6>
	   <div class="card-body">  
		   <table class="table table-bordered">
			   <tr>
				   <td>Email :</td>
				   <td>{{ $mailData['email'] ?? 'No email found'}}</td>
			   </tr>
			   <tr>
				   <td>Password:</td>
				   <td>{{ $mailData['password'] ?? 'No password fount'}}</td>
			   </tr>
			   <tr>
				   <td>Website link:</td>
				   <td><a href="{{ $mailData['website'] ?? 'No link found'}}">{{ $mailData['website'] ?? 'No link found'}}</a></td>
			   </tr>
		   </table>
		   <h6 class="text-center m-0">copyright © {{ date('Y')}} all rights reserved</h6>
	   </div>
	</div>
</body>
</html>
