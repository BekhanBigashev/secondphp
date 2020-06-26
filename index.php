<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<div id="name">

    <?

     
        $queryUrl = 'https://'.$_REQUEST['DOMAIN'].'/rest/user.current.json';
        $params = ['select'=> ['NAME', 'LAST_NAME', 'EMAIL' ]
        ];

        $queryData = http_build_query(array_merge($params, array("auth" => $_REQUEST['AUTH_ID'])));
            
        

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_POST => 1,
            CURLOPT_HEADER => 0,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $queryUrl,
            CURLOPT_POSTFIELDS => $queryData,
        ));

        $result = json_decode(curl_exec($curl), true);
        curl_close($curl);
       
        out($result);

        function out($var, $var_name = ''){
            echo '<pre style="outline: 1px dashed red; padding: 5px;margin: 10px;color: white; background: black;">';
            if (is_string($var)){
                $var = htmlspecialchars($var);

            }
            print_r($var);
            echo '</pre>';
        }




?>

<table style="border-collapse: collapse;" border="1">
    <?php foreach ($result['result'] as $user) {?>
    <tr>
        <td><?=$user['NAME']?></td>
        <td><?=$user['LAST_NAME'] ?></td>
        <td><?=$user['EMAIL']?></td>
    </tr>
    <?php } ?>
</table>


</div>
</body>
</html>

    