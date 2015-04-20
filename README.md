   
    ================
     Initialization
    ================

Create report for current month

    $ php report.php create

=================================================================
    NOTICE: In order to create report for previous month you 
            need to set what month you want with 'set' function,
            and than use '-C' or 'CREATE' option.
=================================================================

Enter new tasks:

    $ php report.php


Create fee report for current month

    $ php report.php fees-create

   =========
    Options
   =========

Insert personal data:

    personal

Edit personal data:

    personal -e or edit

Status:
    
    status

Visual overview of tasks:

    -v or visual

Edit specific task:

    -e or edit [task_number]

Delete specific task:

    -d or delete [task_number]

Reset report:

    reset

Visual overview of fees:

    fees -v or visual

Edit specific fee:

    fees -e or edit [fee_number]

Delete specific fee:

    fees -d or delete [fee_number]

Reset fee report:

    fees-reset

Set current month:

    set -m [month-name or number] -y [year-number] (optional)

Create PDF document with report data:

    dump-pdf
