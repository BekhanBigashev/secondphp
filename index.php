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
            $userTasks[$task['id']] = $task['title'];//если id пользователя равно id ответственного в задаче, то во временное хранилище загружается текущая задача         
        }
    }
    $totalTasks[$user['NAME']] = $userTasks;// добавляем данные из временного хранилища в список всех пользователей
    $userTasks = array();//очищаем временное хранилище для следующей итерации
}

arsort($totalTasks);

?>

<?php foreach ($totalTasks as $user => $tasks): ?>
    <div>
        <h1 class="user_name"><?= $user."Задач: ".count($tasks) ?></h1>
        <ul class="tasks_list">
            <?php foreach ($tasks as $task) { ?>
                <li style="list-style: none;"><?= $task ?></li>
           <?php } ?>
        </ul>
    </div>
<?php endforeach ?>

<style>
    body{
        background-color: #000;
        color: white;
    }
</style>