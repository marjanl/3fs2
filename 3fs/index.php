<html>
    <head>
        <meta charset="UTF-8">
    </head> 
    <body>
        <form name="input" action="index.php" method="post">
            išči številko: <input type="text" name="phoneno"><br>
            <input type="submit" value="išči"><br>
        </form>     

        <?php
        
        if (isset($_POST['phoneno']) && strlen($_POST['phoneno']) > 5) {
            $server = 'http://'.$_SERVER['SERVER_ADDR'].'/server.php';

            $request = xmlrpc_encode_request("searchPhone", array($_POST['phoneno']));
            $context = stream_context_create(array('http' => array(
                    'method' => "POST",
                    'header' => "Content-Type: text/xml\r\nUser-Agent: PHPRPC/1.0\r\n",
                    'content' => $request
            )));
            $file = file_get_contents($server, false, $context);
            echo "file=<i>$file</i><br>\n";
            $response = xmlrpc_decode($file);
            echo "<br>dobu response<b>$response</b><br>";
        }
        ?>
    </body>
</html>