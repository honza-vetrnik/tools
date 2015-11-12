<?php

try {

    $socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
    if ($socket === false) {
        echo socket_strerror(socket_last_error()) . PHP_EOL;
        exit(1);
    }

    $sBind = socket_bind($socket, getHostByName(getHostName()), 9999);
    if ($sBind === false) {
        echo socket_strerror(socket_last_error($socket)) . PHP_EOL;
        socket_close($socket);
        exit(1);
    }

    while (true) {

        $buf = "";
        $remoteName = NULL;
        $remotePort = NULL;

        $recvBytes = socket_recvfrom($socket, $buf, 4096, 0, $remoteName, $remotePort);
        if ($recvBytes === false) {
            echo socket_strerror(socket_last_error($socket)) . PHP_EOL;
            socket_close($socket);
            exit(1);
        }
        if ($recvBytes !== 0) {
            echo $buf . PHP_EOL;
        }
    }

} catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
    exit(1);
}

?>