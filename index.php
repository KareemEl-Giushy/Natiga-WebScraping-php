<?php
    require_once 'connect.php';
    require_once 'simple_html_dom.php';

    $fields = [
        'seating_no' => 399993
    ];
    $fp = fopen("cookie.txt", "w");
    fclose($fp);

    for ($i=0; $i < 20; $i++) { 

        $fields['seating_no'] -= 1;
        echo $fields['seating_no'];
    

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        curl_setopt($ch, CURLOPT_COOKIEJAR, "cookie.txt");
        curl_setopt($ch, CURLOPT_COOKIEFILE, "cookie.txt");
        curl_setopt($ch, CURLOPT_TIMEOUT, 40000);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($fields));
        curl_setopt($ch, CURLOPT_URL, "https://natega.youm7.com/");

        $response = curl_exec($ch);
        curl_close($ch);
         echo $response;

        $html = new simple_html_dom;
        $html->load($response);

        foreach ($html->find('div.all') as $natiga) {
            echo $natiga . '<br/>';
        }
        echo '<br/><hr/>';

        $arr = [];
        foreach ($html->find('div.full-result .nav .nav-item span') as $s) {
            // echo $s . '<br>';
            if(strpos($s->class, 'formatt') == false) {
                // echo $s . '<br>';
                $arr[] = (string)$s;

            }
            
        }
        
        foreach ($html->find('.nav .nav-item h1') as $m) {
            $arr[] = (string)$m;
            
        }
        

        // echo '<pre>';
        // var_dump($arr);
        // echo '<pre>';

        // echo $arr[0];

        $conn->exec("INSERT INTO students (`name`, school, manage, `fail`, `status`, `spz`, `number`, `totalnumber`, per) VALUES ($arr[0], $arr[1], $arr[2], $arr[3], $arr[4], $arr[6], $arr[7], $arr[8], $arr[9])");
    }