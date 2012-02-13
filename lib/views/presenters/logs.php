<div class="tab-content global-tab" tab_content_id="logs">
    <ul id="tabs" class="nav-tabs">
        <a href="#" class="log-tab-link" tab_id="live_logging"><li>Server Log</li></a>
        <a href="#" class="log-tab-link" tab_id="drop_log"><li>Drop Log</li></a>
        <a href="#" class="log-tab-link" tab_id="money_log"><li>Money Log</li></a>
    </ul>
    <div class="tab-content log-tab" tab_content_id="live_logging">
        <h2>Live Logging</h2>
        <div class="log-console" id="log-console">

        </div>
    </div>
    <div class="tab-content log-tab" tab_content_id="drop_log">
        <h2>Drop Log</h2>
        <?=$drop_log?>
    </div>
    <div class="tab-content log-tab" tab_content_id="money_log">
        <h2>Money Log</h2>
        <?=$money_log?>
    </div>
</div>