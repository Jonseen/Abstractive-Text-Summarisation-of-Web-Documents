<?php 
    require_once("search_result_controller.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="font-awesome-4.7.0\css\font-awesome.min.css">
    <link rel="stylesheet" href="search_result.css">
    <title>Dakmas Search Engine</title>
</head>
<body>
    <div class="block">
        <div class="top-header">
       <a class="nameHead" href="#" >Dakmas Search Engine</a> 
            <div class="search-b">
                <form method="GET">
                    <input  type="text" name="search_query" id="search" placeholder="Search Everything...">
                    <input type="submit" value="Search">
                </form>
            </div>
            <div class="nav">
               <a href=""> <div class="All"><i class="fa fa-search"></i> All</div></a>
                <a href=""><div class="Images"><i class="fa fa-picture-o"></i> Images</div></a>
                <a href=""><div class="Videos"><i class="fa fa-video-camera"></i> Videos</div></a>
                <a href=""><div class="News"><i class="fa fa-newspaper-o"></i> News</div></a>
                <a href=""><div class="More"><i class="fa fa-dot-circle-o"></i> More</div></a>
            </div>
        </div><hr/>
                <?php
                    if(isset($resultItems)){
                        $index = 0;
                        foreach($resultItems as $item){
                            $summary = $summaries[$index];

                            echo("<div class='snippet-block'>");
                            echo("<a href='$item->link' class='doc-title'>$item->title</a><br>");
                            echo("<a href='$item->link' class='doc-link'>$item->link</a><br>");
                            echo("<a href='#' class='summary'>");
                            echo("<!-- <div class='summary'> -->$summary<!-- </div> -->");
                            echo("</a>");
                            echo("</div>");
                        }
                    }                    
                ?>
            </div>
            <br/>
            
    </div>
    <div class="pagination">
        <?php 
            $links = "<a href=search_result.php?search_query=$searchQuery&page=1>1</a>";
            $links .= "<a href=search_result.php?search_query=$searchQuery&page=2>2</a>";
            $links .= "<a href=search_result.php?search_query=$searchQuery&page=3>3</a>";
            $links .= "<a href=search_result.php?search_query=$searchQuery&page=4>4</a>";
            $links .= "<a href=search_result.php?search_query=$searchQuery&page=5>5</a>";

            echo($links);
        ?>
        
    </div>
    <div class="copyright">
        <h4>Copyright. Johnson Onaji 2021. Benue State University, Makurdi</h4>
    </div>
</body>
</html>
<script src="./index.js"></script>