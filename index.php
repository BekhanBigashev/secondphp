<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<div id="name">

    <?

     
        $queryUrl = 'https://'.$_REQUEST['DOMAIN'].'/rest/crm.contact.list.json';
        $params = ['select'=> ['ID', 'NAME', 'LAST_NAME']
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


    <style>
        table{
            border-collapse: collapse;
        }
    </style>
<table border="1">
    <?php foreach ($result['result'] as $contact) {?>
    <tr>
        <td><?=$contact['ID']?></td>
        <td><?=$contact['NAME'] ?></td>
        <td><?=$contact['LAST_NAME']?></td>

    </tr>
    <?php } ?>
</table>


</div>
</body>
</html>

    