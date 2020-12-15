<?php

require __DIR__ . '/vendor/autoload.php';
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Orders\OrdersGetRequest;

// Creating an environment
$clientId = getenv("CLIENT_ID");
$clientSecret = getenv("SECRET");

$environment = new SandboxEnvironment($clientId, $clientSecret);
$client = new PayPalHttpClient($environment);

$data=json_decode(file_get_contents('php://input'), true);

$request = new OrdersGetRequest($data["order_id"]);

try {
    // Call API with your client and get a response for your call
    $response = $client->execute($request);

    //header("Content-Type: application/json");
    
    // If call returns body in response, you can get the deserialized version from the result attribute of the response
    echo jsonToTable($response->result);
}catch (HttpException $ex) {
    echo $ex->statusCode;
    print_r($ex->getMessage());
}

function jsonToTable ($data)
{
    $table = '
    <div class="text-center>
    <table class="json-table" width="100%">
    ';
    foreach ($data as $key => $value) {
        $table .= '
        <tr valign="top">
        ';
        if ( ! is_numeric($key)) {
            $table .= '
            <td>
                <strong>'. ucwords(str_replace("_", " ", $key)) .':</strong>
            </td>
            <td>
            ';
        } else {
            $table .= '
            <td colspan="2">
            ';
        }
        if (is_object($value) || is_array($value)) {
            $table .= jsonToTable($value);
        } else {
            $table .= $value;
        }
        $table .= '
            </td>
        </tr>
        ';
    }
    $table .= '
    </table>
    </div>
    ';
    return $table;
}

?>