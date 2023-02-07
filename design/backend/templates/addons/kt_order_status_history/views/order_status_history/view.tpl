{capture name="mainbox"}

    {$order_status_descr = $smarty.const.STATUSES_ORDER|fn_get_simple_statuses:true:true}
    {$order_statuses = $smarty.const.STATUSES_ORDER|fn_get_statuses:$statuses:true:true}
    {$page_title=__("kt_order_status_history_menu")}

    <div class="table-responsive-wrapper">
        <table width="100%" class="table table-middle table--relative table-responsive">
            <thead>
            <tr>
                <th width="15%">
                    {include file="common/table_col_head.tpl" text=__("id")}
                </th>
                <th width="15%">
                    {include file="common/table_col_head.tpl" text=__("kt_status_old")}
                </th>
                <th width="15%">
                    {include file="common/table_col_head.tpl" text=__("kt_status_new")}
                </th>
                <th width="28%">
                    {include file="common/table_col_head.tpl" text=__("kt_changed_by")}
                </th>
                <th width="17%">
                    {include file="common/table_col_head.tpl" text=__("date")}
                </th>
            </tr>
            </thead>

            {foreach from=$orders_status_history item="o_status"}
                <tr>
                    <td width="15%">
                        <a href="{"orders.details?order_id=`$o_status.order_id`"|fn_url}" class="underlined">{__("order")} <bdi>#{$o_status.order_id}</bdi></a>
                    </td>
                    <td width="15%">
                        {assign var="status_value_old" value=$o_status.status_old}
                        <p class="btn o-status-{$o_status.status_old|lower} dropdown-toggle dropdown-toggle--text-wrap">{$order_status_descr["$status_value_old"]}</p>
                    </td>
                    <td width="15%">
                        {assign var="status_value_new" value=$o_status.status_new}
                        <p class="btn o-status-{$o_status.status_new|lower} dropdown-toggle dropdown-toggle--text-wrap">{$order_status_descr["$status_value_new"]}</p>
                    </td>
                    <td width="28%">
                        {if $o_status.changed_by_id == 0}
                            {__("kt_none_auth_user")}
                        {else}
                            <a href="{"profiles.update?user_id=`$o_status.changed_by_id`"|fn_url}">{$o_status.lastname} {$o_status.firstname}</a>
                        {/if}
                    </td>
                    <td width="17%" class="nowrap">{$o_status.date|date_format:"`$settings.Appearance.date_format`, `$settings.Appearance.time_format`"}</td>
                </tr>
            {/foreach}
        </table>
    </div>
{/capture}

{include file="common/mainbox.tpl"
    title=$page_title
    content=$smarty.capture.mainbox
    content_id="view_orders_status_history"
}