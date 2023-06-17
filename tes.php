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

$data_array =  array(
   [855, 304, 299, 417, 810, 349],
   [837, 299, 297, 417, 893, 347],
   [806, 297, 304, 417, 911, 346],
    
);
print_r($data_array);
$jsondata = json_encode($data_array);
$jsondataa = '{"data":' .$jsondata.'}';
echo $jsondataa;
$make_call = callAPI('POST', 'http://127.0.0.1:5000/enose_tea', $jsondataa);
echo $make_call;

#$response = json_decode($make_call, true);
#$errors   = $response['response']['errors'];
#$data     = $response['response']['data :'][0];
#echo $data;
?>