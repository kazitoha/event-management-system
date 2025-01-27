<?php
//There are more complex encryption methods out there, but I use this for simple understanding.
function encode($data)
{
    $dataWithKey = $data . '|' . APP_SECRET_KEY;
    return base64_encode($dataWithKey);
}

function decode($encodedData)
{
    $decodedData = base64_decode($encodedData, true);

    if ($decodedData === false) {
        return null;
    }
    $parts = explode('|', $decodedData);

    if (count($parts) !== 2 || $parts[1] !== APP_SECRET_KEY) {
        return null;
    }
    return $parts[0];
}
