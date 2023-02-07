<?php

/**
 * Save data about status history after order status is changed
 *
 * @param int    $order_id    Order identifier
 * @param string $status_old  Old order status (one char)
 * @param string $status_new  New order status (one char)
 * @param int    $user_by     User's identifier who changed status
 * @param string $user_type   User's type: admin - A, customer -C (one char)
 * @param string $date_change Change Date, UNIX timestamp
 *
 * @return void
 */
function fn_add_order_status_history(int $order_id, string $status_old, string $status_new, int $user_by, string $user_type, string $date_change)
{
    db_query(
        "INSERT INTO ?:kt_order_statuses_history (order_id, status_old, status_new, date, changed_by_id, user_type) 
                VALUES (?i, ?s, ?s, ?s, ?i, ?s)",
        $order_id, $status_old, $status_new, $date_change, $user_by, $user_type
    );
}

/**
 * Get data about order statuses
 *
 * @return array
 */
function fn_get_orders_status_history(): array
{
    return db_get_array(
        "SELECT order_id, 
               status_old, 
               status_new, 
               ?:kt_order_statuses_history.date, 
               changed_by_id, 
               lastname,  
               firstname, 
               ?:kt_order_statuses_history.user_type 
        FROM ?:kt_order_statuses_history
        LEFT JOIN ?:users ON changed_by_id = user_id
        ORDER BY ?:kt_order_statuses_history.date DESC;"
    );
}

/**
 * Hook for get order statuses and add them to the database in a separate table;
 * Executes after order status is changed
 *
 * @param int    $order_id           Order identifier
 * @param string $status_to          New order status (one char)
 * @param string $status_from        Old order status (one char)
 * @param array  $force_notification Array with notification rules
 * @param bool   $place_order        True, if this function have been called inside of fn_place_order function
 * @param array  $order_info         Order information
 * @param array  $edp_data           Downloadable products data
 */
function fn_kt_order_status_history_change_order_status_post($order_id, $status_to, $status_from, $force_notification, $place_order, $order_info, $edp_data)
{
    $date_change = (string)time();
    $placed_by_user = (int)$_SESSION['auth']['user_id'];
    $user_area = $_SESSION['auth']['area'];

    fn_add_order_status_history($order_id, $status_from, $status_to, $placed_by_user, $user_area, $date_change);

}