Add the following (change the path to domocron scripts) to your crontab and restart it:

*/1 * * * * root /root/domotique/cron/domocron-1min /dev/null 2>&1
*/5 * * * * root /root/domotique/cron/domocron-5min /dev/null 2>&1
*/15 * * * * root /root/domotique/cron/domocron-15min /dev/null 2>&1
* */1 * * * root /root/domotique/cron/domocron-1h /dev/null 2>&1
* * */1 * * root /root/domotique/cron/domocron-1d /dev/null 2>&1 