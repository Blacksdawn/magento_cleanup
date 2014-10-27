magento_cleanup
===============

[Created by Boson](http://www.bosonhuang.com)

Clean up your Magento store cache files or database log files.

Need help? Email [Boson](mailto:boson@bosonhuang.com)

USAGE
=====

1. Put this script to root of you Magento installation folder.
2. Run file in browser: http://www.yourStoreURL.com/cleanup.php?clean=log or http://www.yourStoreURL.com/cleanup.php?clean=var
3. URL query `clean` takes 2 values: `log` for cleaning up database log files and `var` for cleaning up temp folder

Logs to be cleaned up in database:
----------------------------------

    `dataflow_batch_export`
    `dataflow_batch_import`
    `log_customer`
    `log_visitor`
    `log_visitor_info`
    `log_url`
    `log_url_info`
    `log_summary`
    `log_summary_type`
    `log_quote`
    `log_visitor_online`
    `report_event`

Temp folder to be cleaned up:
-----------------------------

    `downloader/pearlib/cache/*`
    `downloader/pearlib/download/*`
    `var/cache/*`
    `var/log/*`
    `var/report/*`
    `var/tmp/*`
