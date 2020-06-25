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
        $params = ['select'=> ['ID', 'NAME', 'LAST']
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


        function delete_www($id, $param){
            $queryUrl = 'https://'.$_REQUEST['DOMAIN'].'/rest/crm.company.update.json';
            $params = [
                "id"     => $id,
                "fields" => [$param['VALUE'] => " aezakmi"],
            

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
        }

?>


    <style>
        table{
            border-collapse: collapse;
        }
    </style>
<table border="1">
    <?php foreach ($result['result'] as $company) {?>
    <tr>
        <td><?=$company['ID'] ?></td>
        <td><?=$company['TITLE'] ?></td>
        <td><?php if(isset($company['PHONE'])) foreach ($company['PHONE'] as $phone) {echo $phone['VALUE'];} ?></td>

        
        <td><?php if(isset($company['EMAIL'])) foreach ($company['EMAIL'] as $email) {echo $email['VALUE'];} ?></td>
        <td><?php if(isset($company['WEB'])) foreach ($company['WEB'] as $web) {
            echo $web['VALUE'];
            if ($web['VALUE'] == 'www.' or $web['VALUE'] == 'нет'){
                delete_www($company['ID'], $web);
            }
        } ?></td>
    </tr>
    <?php } ?>
</table>


</div>
</body>
</html>

    