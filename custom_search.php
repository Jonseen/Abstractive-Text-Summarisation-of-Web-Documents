<?php
    //A PHP implementation of google's programmable search engine.
    //author: anendahpromise@yahoo.com
    
    /** 
        Search Google's programmable search engine using the provided query.
        Parameters:
            query:          This is the query or search terms to search
            pageOffset:     Use this to get other results, for example 1 means get page 1 content while 10 means get page 10 result. Maximum pages: 50
        returns: string     Returns a json_string containing the status_code and message.
    **/
    function customSearch($query, $pageOffset=1){
        define("MAX_PAGE", 50);
        define("MIN_PAGE", 1);
        // prevent invalid pages
        if($pageOffset < MIN_PAGE){
            $pageOffset = MIN_PAGE;
        }else if($pageOffset > MAX_PAGE){
            $pageOffset = MAX_PAGE;
        }

        define("NUM_RESULT_PER_PAGE", 10);
        define("FIRST_PAGE_OFFSET", 1);
        $start = NUM_RESULT_PER_PAGE * ($pageOffset - 1) + FIRST_PAGE_OFFSET;
        $query = urlencode($query);
        $url = "https://customsearch.googleapis.com/customsearch/v1?key=AIzaSyD_C8sT1q4fJnRaC0lvUvJWFt-7pNq3ga4&cx=943ee1f0248af9858&q=$query&start=$pageOffset&alt=json";
        
        $result = ['maxPage' => MAX_PAGE];
        $response = file_get_contents($url);
        if($response != false){
            $obj = json_decode($response);
            $result['query'] = $obj->queries->request[0]->searchTerms;
            $result['totalResults'] = $obj->searchInformation->totalResults;

            $items = $obj->items;
            $result['items'] = [];

            foreach($items as $item){
                $result['items'][] = ['title'=>$item->title, 'link'=>$item->link];
            }
            return json_encode(["status_code"=>200, "message"=>$result]);
        }else{
            return json_encode(["status_code"=>200, "message"=>"Error! Failed to process request."]);
        }
    }   
?>