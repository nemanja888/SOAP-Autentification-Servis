<?php


function login($userName, $userPass){
    $dom = new DOMDocument();
    $dom->load("users.xml");

    $users = $dom->getElementsByTagName("user");

//    print_r($users->item(1)->nodeValue);



    foreach ($users as $user){
        $name = $user->getElementsByTagName("name")->item(0)->nodeValue;
        $pass = $user->getElementsByTagName("password")->item(0)->nodeValue;
        if($name == $userName && $pass == $userPass){
            $token = $user->getElementsByTagName("token")->item(0);
            if($token){
                $user->removeChild($token);
                $token = $dom->createElement("token",bin2hex(openssl_random_pseudo_bytes(16)));
                $user->appendChild($token);
                $dom->save("users.xml");
                return $user->getElementsByTagName("token")->item(0)->nodeValue;
            }
            else{
                $token = $dom->createElement("token",bin2hex(openssl_random_pseudo_bytes(16)));
                $user->appendChild($token);
                $dom->save("users.xml");
                return $user->getElementsByTagName("token")->item(0)->nodeValue;
            }
        }
        else{
            $status = false;
        }
    }
    if(isset($status)){
        return $status;
    }

}


    ini_set("soap.wsdl_cache_enabled","0");

    $server = new SoapServer("opis.wsdl");

    $server->addFunction("login");

    $server->handle();





