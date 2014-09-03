<?php
    require_once('model.php');
    
    $error_msg = "";
    
    // displays each value for the dropdown within option tags
    function echo_options_for_field($field){
        $values = get_values_of_field($field);
        for($i = 0; $i < count($values); $i++){
            echo "<option value = \"$values[$i]\">$values[$i]</option>\n";
        }
    }
    
    // Validates that the query
    function validate_query($query_array){
        global $error_msg;
        
        if(intval($query_array['from_year']) > intval($query_array['to_year'])
            && $query_array['from_year'] != "default" 
            && $query_array['to_year'] != "default"){
            $error_msg = "The from year must be less than or equal to the to year.";
        } elseif(intval($query_array['min_stock']) <= 0 && $query_array['min_stock'] != ""){
            $error_msg = "Minimum stock must be a positive integer.";
        } elseif(intval($query_array['min_ordered']) <= 0 && $query_array['min_ordered'] != ""){
            $error_msg = "Minimum ordered must be a positive integer.";
        } elseif(intval($query_array['min_cost']) <= 0 && $query_array['min_cost'] != ""){
            $error_msg = "Minimum cost must be a positive integer.";
        } elseif((intval($query_array['min_cost']) > intval($query_array['max_cost'])
                 || intval($query_array['max_cost']) <= 0)
                 && $query_array['max_cost'] != ""){
            $error_msg = "Maximum cost must be an integer greater " .
                          "than or equal to minimum cost. If minimum cost" .
                          " isn't specified, maximum cost must be greater than zero.";
        }
        return $error_msg == "";
    }
    
    /* If count($_GET) == 11 then the request was sent.
     * The only other thing that count($_GET) would equal is 1
     * which is when there is an error message returned. 
     */
    if(count($_GET) == 11){
        if(validate_query($_GET))
            get_results($_GET);
    }
?>