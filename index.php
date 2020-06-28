<?

$queryUrl = 'https://kapmaniyamechty.bitrix24.kz/rest/1/tvhrfsm1tp1gp1q3/batch.json';
$queryData = http_build_query(array("cmd" => array(
// Вызов необходимых методов одним batch запросом 
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
echo "</pre>";
$totalTasks = array();//список всех пользователей и их задач
$userTasks = array();//временное хранилище задач для каждого пользователя
foreach ($result['result']['result']['get_users'] as $user) {
    foreach ($result['result']['result']['get_tasks']['tasks'] as $task) {
        if ($user['ID'] == $task['responsible']['id']){
            $userTasks[$task['title']] = 'Статус: '.$task['status'];//если id польователя равно id ответственного в задаче, то во временное хранилище загружаются все задачи для одного пользователя         
        }
    }
    $totalTasks[$user['NAME']] = $userTasks;// добавляем пользователя и его задачи в список
    $userTasks = array();//очищаем временное хранилище для следующей итерации
}
echo "<pre>";
// print_r($totalTasks);
echo "</pre>"; 
echo "Количество задач Бекхана" . count($totalTasks['Bekhan']);
echo "<br>";
echo "Количество задач Ивана" . count($totalTasks['Иван']);
echo "<br>";
echo "Количество задач Беки" . count($totalTasks['Beka']);
echo "<br>";
// foreach ($totalTasks as $user => $tasks) {
//     echo "<br>";
//     echo $user;
//     echo "<br>";
// }
?>

<?php foreach ($totalTasks as $user => $tasks): ?>
    <div>
        <h1><?= $user ?></h1>
        <ul>
            <li><?= foreach ($tasks as $task) {
                echo $task;
            } ?></li>
        </ul>
    </div>
<?php endforeach ?>