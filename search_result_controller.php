<?php
    set_time_limit(0);
    require_once("custom_search.php");

    if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['search_query'])){
        $page = 1;
        if(isset($_GET['page'])){
            $page = htmlentities($_GET['page']);
        }

        $searchQuery = htmlentities($_GET['search_query']);
        if(empty($searchQuery)){
            echo("invalid query, query cannot be empty");
        }else{
            $response = customSearch($searchQuery, $page);
            //echo($response);
            $searchResult = json_decode($response);
            if($searchResult->status_code == 200){
                $searchQuery = $searchResult->message->query;
                $resultItems = $searchResult->message->items;              
                // get the summary of all the content
                $summaries = [];
                foreach($resultItems as $item){
                    $url = $item->link;
                    $arg = escapeshellcmd($url);
                    $url = shell_exec("python summarizer.py $arg");
                    if($url != NULL){
                        $url = "NAN";
                    }
                    $summaries[] = $url;
                }
            }else{
                echo("Query Failed!");
            }
        }
    }else{
        echo("received post request");
    }
?>