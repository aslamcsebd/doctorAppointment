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
	<h4 class="card">
	   <p class="card-header text-center">Your appointment request accept successfully.</p>
	   <p class="card-header text-justify">
		   Dear patient,
		   welcome to our hospital, we create your account successfully. Now you can login and update your full profile from setting. Otherwise you can't take any appointment and booking any room/ward. 
	   </p>
	   <div class="card-body">  
		   <table class="table table-bordered">
			   <tr>
				   <td>Email :</td>
				   <td>{{ $mailData['email'] ?? 'No email found' }}</td>
			   </tr>
			   <tr>
				   <td>Password :</td>
				   <td>{{ $mailData['password'] ?? 'No password fount' }}</td>
			   </tr>
			   <tr>
				   <td>Website link :</td>
				   <td><a href="{{ $mailData['website'] ?? 'No link found'}}">{{ $mailData['website'] ?? 'No link found'}}</a></td>
			   </tr>
		   </table>
		   <p class="text-center m-0">Copyright © {{ date('Y')}} all rights reserved</p>
	   </div>
	</h4>
</body>
</html>
