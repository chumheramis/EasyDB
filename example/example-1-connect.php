<?php
print_r('attempting to connect' . PHP_EOL);
if($edb->isConnected()){
    print_r('connection success' . PHP_EOL);
}else{
    print_r('connection failed' . PHP_EOL);
}