<?php

use Tygh\Tygh;

if (!defined('BOOTSTRAP')) { die('Access denied'); }

if ($mode === 'view') {
    $orders_status_history = fn_get_orders_status_history();
    Tygh::$app['view']->assign('orders_status_history', $orders_status_history);

    return array(CONTROLLER_STATUS_OK);
}
