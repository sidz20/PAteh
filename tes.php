<?php
function callAPI($method, $url, $data){
    $curl = curl_init();
    switch ($method){
       case "POST":
          curl_setopt($curl, CURLOPT_POST, 1);
          if ($data)
             curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
          break;
       case "PUT":
          curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
          if ($data)
             curl_setopt($curl, CURLOPT_POSTFIELDS, $data);                          
          break;
       default:
          if ($data)
             $url = sprintf("%s?%s", $url, http_build_query($data));
    }
    // OPTIONS:
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
       'APIKEY: 111111111111111111111',
       'Content-Type: application/json',
    ));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    // EXECUTE:
    $result = curl_exec($curl);
    if(!$result){die("Connection Failure");}
    curl_close($curl);
    return $result;
}

$data_array = array(
    [855, 304, 299, 417, 810, 349],
    [837, 299, 297, 417, 893, 347],
    [806, 297, 304, 417, 911, 346],
);
$jsondata = json_encode($data_array);
$jsondataa = '{"data":' .$jsondata.'}';

$make_call = callAPI('POST', 'http://127.0.0.1:5000/enose_tea', $jsondataa);

$response = json_decode($make_call, true);
foreach ($response as $index => $row) {
    $label = $row['Label'];
    $score = $row['Score'];

    // Do something with the label and score
    echo "Label: $label<br>";
    echo "Score: $score<br>";
    echo "<br>";
}
?>