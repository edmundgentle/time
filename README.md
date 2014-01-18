Time
====

Plugin to allow you to display the time since an event. PHP formats the dates on the backend, then jQuery updates the times within the browser.


PHP Usage
---------

    <?php
        include('src/jquery.time.php');
        
        //create a time variable, then send it to the function
        $time=strtotime("-3 weeks");
        echo "<p>".jquery_time($time)."</p>";
    
    ?>

jQuery Usage
------------

    $.time();

More settings include:

    $.time({
        langFile:'../src/langs/en.json', //the location of the relevant language JSON file (in the src/langs directory)
        refreshRate:60000 //how often (in ms) to refresh the times, 0 is no refresh
    });

Examples
--------

You can find all the examples live at http://www.edmundgentle.com/snippets/time/examples/
