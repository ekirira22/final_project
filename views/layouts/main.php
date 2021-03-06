<!--Main Application Layout-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nyeri PMS</title>

    <!-- Styles -->
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
<header style="display: flex">
    <div>
        <a href="/">
            <img src="assets/img/logo-240.png" alt="" style="width: 100px; height: 100px;">
        </a>
    </div>
    <div class="main-heading py-32" style="margin-left: 25%;"><h6>THE COUNTY GOVERNMENT OF NYERI</h6></div>
</header>
<nav class="navbar">
    <ul class="left-nav">
        <li class="nav-list">
            <a class="nav-link" href="/">
                <span class="light">The Nyeri County Project Management System</span>
            </a>
        </li>


        <div  style="margin-left: 80%; display: flex; justify-content: space-evenly" >
            <li class="nav-list">
                <a class="btn-danger" href="/login">
                    Login As Staff
                </a>
            </li>
        </div>

    </ul>
</nav>

<div class="container">

    {{content}}

</div>


</body>
</html>

