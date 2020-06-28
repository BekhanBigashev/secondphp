<?

$queryUrl = 'https://kapmaniyamechty.bitrix24.kz/rest/1/tvhrfsm1tp1gp1q3/batch.json';
$queryData = http_build_query(array("cmd" => array(

    "get_users" => 'user.search?'.http_build_query(array(
            "select" => array("*"),
        )),
    "get_tasks" => 'tasks.task.list?'.http_build_query(array(
            "select" => array("*"),
        )),
)));

$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_SSL_VERIFYPEER => 0,
    CURLOPT_POST => 1,
    CURLOPT_HEADER => 0,
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => $queryUrl,
    CURLOPT_POSTFIELDS => $queryData,
));

$result = curl_exec($curl);
curl_close($curl);

echo "<pre>";
$result = json_decode($result, true);
// print_r($result);
echo "</pre>";
$totalTasks = array();
$userTasks = array();
foreach ($result['result']['result']['get_users'] as $user) {
    foreach ($result['result']['result']['get_tasks']['tasks'] as $task) {
        if ($user['ID'] == $task['responsible']['id']){
            $userTasks[$task['title']] = 'Статус: '.$task['status'];
             
        }
        
    }
    $totalTasks[$user['NAME']] = $userTasks;
}
echo "<pre>";
print_r($totalTasks);
echo "</pre>"; 

?>
