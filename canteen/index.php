<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>
<meta charset="UTF-8" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="initial-scale=1, maximum-scale=1" />
<meta name="viewport" content="width=device-width" />
<title>Canteen Management System</title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" href="css/reset.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/layout.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/jqueryslidemenu.css" type="text/css" media="screen" />

<!-- supersized -->
<link rel="stylesheet" href="css/supersized.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/supersized.shutter.css" type="text/css" media="screen" />
<!-- supersized -->

<link rel="stylesheet" href="css/carouFredSel.css" type="text/css" media="screen" />
<link rel="stylesheet" type="text/css" href="css/quicksand.css" />
<link rel="stylesheet" type="text/css" href="js/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
<link rel="stylesheet" href="style.css" type="text/css" media="screen" />
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/jqueryslidemenu.js"></script>
<script type="text/javascript" src="js/jquery.easing.min.js"></script>

<!-- supersized -->
<script type="text/javascript" src="js/supersized.3.2.7.js"></script>
<script type="text/javascript" src="js/supersized.shutter.js"></script>
<!-- supersized -->

<!-- fancybox -->
<script type="text/javascript" src="js/fancybox/jquery.fancybox-1.3.4.js"></script>
<script type="text/javascript" src="js/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<!-- fancybox -->

<!-- quicksand -->
<script type="text/javascript" src="js/portfolio_sortable.js"></script>
<script type="text/javascript" src="js/quicksand.js"></script>
<!-- quicksand -->

<script type="text/javascript" src="js/jquery.carouFredSel-6.0.6.js"></script>

<script type="text/javascript" src="js/contact.js"></script>
<script type="text/javascript" src="js/custom.js"></script>

            
<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<!--[if lt IE 9]>
	<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
<![endif]-->
<link href="http://fonts.googleapis.com/css?family=Oswald:400,300,600,700,300italic,400italic,600italic,700italic" rel="stylesheet" type="text/css">
</head>
<body>
<div id="page_wrapper">
<div id="dvLoading"></div>
<div id="bgOverlay"><a  href="#" class="page_close"><img src="images/close_button.png" alt="img" /></a></div>

<!--leftSide start --> 
<div id="leftSide">
    <div id="logo">
        <h1>
            <a href="index.php">
                <img src="images/logo.png" alt="logo" />
            </a>
        </h1>
    </div>
	<ul>
			<li style="border-bottom: 1px solid rgba(127, 127, 127, 0.3); position: relative;"><a href="store/generatetrans.php" style="color: #211C1B; display: block; font-family: 'Oswald',Arial; font-weight: 600; padding: 10px 25px; text-decoration: none; text-transform: uppercase; font-size:15px;">Take Orders</a></li>
		</ul>
    <nav id="sidebarmenu">
        <ul id="sidebarmenu1" class="menu">            
            <li><a href="#page_gallery">Available Menu</a></li>
			<li><a href="#adminlogin">Admin Panel</a></li>
        </ul>
		
    </nav>
    
    
</div>
<!--leftside end --> 


<!--Content Start-->
<div class="contWrapper">
<article id="content">



<ul id="ulcontent">



<!--Menu Start-->
<li id="page_gallery">
    <div class="title-wrapper">
        <h2>Available Menu</h2>
    </div>
    <div>
		
	<div class="wrapper">
		<table class="datatable">		 
		  <tr>
			<th scope="col">Item Name</th>
			<th scope="col">Rate</th>
			<th scope="col">Description</th>
		  </tr>
		 <?php
				include('connect.php');
				$result = mysqli_query("SELECT * FROM je_products");
				while($row = mysqli_fetch_array($result))
					{
						echo ' 
						  <tr>
							<td width="150px">'.$row['name'].'</td>
							<td width="100px">'.$row['price'].'</td>
							<td>'.$row['description'].'</td>
						  </tr>';
					}
				?> 
		  
		</table>
	 </div>
    </div>
   
</li>
<!--Menu End-->




<!--adminlogin Start-->
<li id="adminlogin">
   
    <div class="title-wrapper">
        <h2>Admin Login Form</h2>
    </div>
    <div class="contact_form">
        <form method="post" action="login.php" name="contact-form" id="contact-form">	
        <div id="main">
            <div class="one_third">
                <label style="color:black;">Username:</label>
                <p><input type="text" name="user" id="name" size="30" /></p>
            </div>
            <div class="one_third">
                <label style="color:black;">Password:</label>
                <p><input type="password" name="password" id="email" size="30" /></p>
            </div>
            <div class="one_third_last">
			<label>&nbsp;</label>
                <input  class="contact_button button" type="submit" name="submit" id="submit" value="Login" />
            </div>
        </div>
        </form>
    </div> 
</li>
<!--adminlogin End-->
                   
</ul>
</article>
</div>
<!--Content End-->

</div>
<!--Page wrapper End-->
</body>
</html>
<style>

.wrapper {
  width: 150%;
  margin: 20px auto 40px auto;
  font-color:black;
}

.datatable {
  width: 100%;
  border: 1px solid #d6dde6;
  border-collapse: collapse;
   background-color: white;
   font-color:black;
   font-size: 15px;
}

.datatable td {
  border: 1px solid #d6dde6;
  padding: 0.3em;
  font-color:black;
}

.datatable th {
  border: 1px solid #828282;
  background-color: #CAE8EA;
  font-family: "Oswald",sans-serif;
  font-size: 15px;
  text-align: left;
  padding-left: 0.3em;
  height: 30px;
  font-color:black;
}

.datatable tr:nth-child(odd) {
  background-color: #fff;
  color: #575a5e;
  font-color:black;
}

.datatable tr:nth-child(even) {
  background-color: #fff;
  color: #575a5e;
  font-color:black;
}
</style>