<?php
require_once('db.php');
// include 'class.users.php';

// Format arrays
function formatcode($arr) {
    echo '<pre>';
    print_r($arr);
    echo '</pre>';
}

// SELECT statement
function selectAll(){
    // To use variable in all functions
    global $mysqli;
    $data = array();
    $stmt = $mysqli->prepare('SELECT * 
                                FROM users
                                RIGHT OUTER JOIN country
                                ON users.country = country.id
                                RIGHT OUTER JOIN stats
                                ON users.status = stats.id
                                ORDER BY users.id');
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 0) {
        echo 'No rows';
    }
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    $stmt->close();
    $id = 1;
    $all_users = [];
    foreach ($data as $user) {
        $user['id'] = $id;
        $id += 1;
        array_push($all_users,$user);
    }
    return $all_users;
}

// Method: POST, PUT, GET etc
// Data: array("param" => "value") ==> index.php?param=value

function callAPI($key,$value){
    $getdata = http_build_query(
        array(
            $key => $value,
         )
        );
        
        $opts = array('http' =>
         array(
            'method'  => 'GET',
            'header' =>
                "Content-Type: application/x-www-form-urlencoded\r\n".
                "Authorization: Bearer sdf541gs6df51gsd1bsb16etb16teg1etr1ge61g\n",
            'content' => $getdata
        )
        );
        
        $context  = stream_context_create($opts);

        return file_get_contents('https://pinkman.online/api/?'.$getdata, false, $context);
}

function convertMoney(){
    $html = file_get_contents('https://valuta.exchange/hr/usd-to-eur?amount=1');
    $start = stripos($html, 'class="Converter__ToContainer-ah6o35-3 iVEPxa"');
    $end = stripos($html, '€</div>', $offset = $start);
    $length = $end - $start;
    $htmlSection = substr($html, $start, $length);
    preg_match_all('@<input value="(.+)" aria-label@', $htmlSection, $matches);
    $conversionRate = $matches[1][0];
    // foreach($doc->getElementsByTagName('input') as $a) {
    //     if ($a->getAttribute('class') === 'CurrencyInput-sc-46bpxp-0 loGueB') {
    //         $part = $a->getAttribute('value');
    //     }
    // }
    return (float)$conversionRate;  
}

function userTransactions(){
    $users = selectAll();
    $transactions = callAPI('api-key','any');
    $transakcije = json_decode($transactions);
    $combined = array();
    foreach($users as $user) {
        foreach ($transakcije->data as $transaction) {
            $transaction = (array) $transaction;
            if ($user['id'] == $transaction['user_id']) {
                array_push($combined,array_merge($transaction,array_slice($user,1)));
            }
        }
    }
    // Sorting
    $price = array();
    foreach ($combined as $key => $row)
    {
        $price[$key] = $row['id'];
    }
    array_multisort($price, SORT_ASC, $combined);
    return $combined;
}

function eurTransactions(){
    $transactions = userTransactions();
    try {
        $rate = convertMoney();
    } catch (\Throwable $th) {
        $rate = 0.83;
        print_r($th);
    }
    $converted = array();
    foreach ($transactions as $transaction) {
        if ($transaction['currency'] == 'usd') {
            $transaction['amount'] = (double)$transaction['amount'] * $rate;
        }
        $transaction['currency'] = 'EUR';
        array_push($converted,$transaction);
    }
    return $converted;
}

function countrySum(){
    $transactions = eurTransactions();
    //  First Store data in $arr
    $arr = array();
    foreach ($transactions as $transaction) {
        array_push($arr,$transaction['code']);
    }
    $unique_data = array_unique($arr);
    
    $table = [];
    foreach ($unique_data as $code) {
        $sum = 0;
        $count = 0;
        $row = [];
        array_push($row,$code);
        foreach ($transactions as $transaction) {
            if ($code == $transaction['code']) {
                $sum += (double)$transaction['amount'];
                $count += 1;
            }
        }
        array_push($row,$sum);
        array_push($row,'EUR');
        array_push($row,$count);
        array_push($table,$row);
    }
    return $table;
}

function uniqueMonths(){
    $transactions = eurTransactions();
    $arr = array();
    foreach ($transactions as $transaction) {
        $date = strtotime($transaction['date']);
        array_push($arr,date('M',$date));
    }
    $unique_dates = array_unique($arr);
    return $unique_dates;
}

function uniqueUsers(){
    $transactions = eurTransactions();
    $arr2 = array();
    foreach ($transactions as $transaction) {
        array_push($arr2,$transaction['username']);
    }
    $unique_users = array_unique($arr2);
    return $unique_users;
}

function userMonth(){
    $transactions = eurTransactions();

    $unique_dates = uniqueMonths();

    $unique_users = uniqueUsers();
    
    $array = [];
    foreach ($unique_dates as $month) {
        $table = [];
        foreach ($unique_users as $user){
            $sum = 0;
            $count = 0;
            $row = [];
            array_push($row,$user);
            foreach ($transactions as $transaction) {
                if ($user == $transaction['username'] && 
                $month == date('M',strtotime($transaction['date']))) {
                    $sum += (double)$transaction['amount'];
                    $count += 1;
                }
            }
            array_push($row,$sum);
            array_push($row,'EUR');
            array_push($row,$count);
            array_push($table,$row);
        }
        array_push($array,$table);
    }
    return $array;
}