<head>
    <link href="style.css" type="text/css" rel="stylesheet">
</head>
<body>
<div class="wrapper">
    <form class="login" method="post" action="">
        <h2 class="loginHead">Please login</h2>
        <input type="text" class="formControl" name="username" placeholder="Email Address" required="" autofocus="" ><br>
        <input type="password" class="formControl" name="password" placeholder="Password" required=""><br>

        <button class="btnLogin" type="submit">Login</button>
    </form>
</div>
</body>
<?php
if(isset($_POST['username']) && isset($_POST['password'])){
    $name = str_replace("'","",trim($_POST['username']));
    $name = str_replace("<","",$name);
    $name = str_replace(">","",$name);

    $password = str_replace("'","",trim($_POST['password']));
    $password = str_replace("<","",$password);
    $password = str_replace(">","",$password);

   $password = md5($password);


}

try{
    $client = new SoapClient("https://nemanjadevelop.000webhostapp.com/opis.wsdl");
    $result = $client->login($name,$password);
    if(!$result){
        echo "Pogresni podaci";
    }
    else{echo $result;}
}catch(SoapFault $fault){
    trigger_error("FAULT: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})",E_USER_ERROR);
}



