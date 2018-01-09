<?php
/*
 ** Get Categories Function v1.0
 ** Function To Get Categories From Database 
 */

function getCat() {
    
    global $con;
    
    $getCat = $con->prepare("SELECT * FROM categories ORDER BY ID ASC");
    
    $getCat->execute();
    
    $cats = $getCat->fetchAll();
    
    return $cats;
    
}
/*
 ** Get Items Function v1.0
 ** Function To Get Items From Database
 */

function getItems($CatID) {
    
    global $con;
    
    $getItems = $con->prepare("SELECT * FROM items Where Cat_ID = ? ORDER BY Item_ID DESC");
    
    $getItems->execute(array($CatID));
    
    $Items = $getItems->fetchAll();
    
    return $Items;
    
}

/*
** Title Function v1.0
** Title Function That Echo The Page Title In Case The Page
** Has The Variable $PageTitle And Echo Defult Title For Other Pages
*/

function getTitle() {
    
    global $pageTitle;
    
    if (isset($pageTitle)) {
        
        echo $pageTitle;
       
    } else {
        
        echo 'Default';
    }
}

/*
** Home Redirect Function v2.0
** This Function Accept Parameters 
** $theMsg = Echo The Message [ Error | Success | Warning ]
** $url = The Link You Want To Redirect To 
** $seconds = Seconds Before Redirecting 
*/

function redirectHome ($theMsg, $url = NULL, $seconds = 3) {
    
    if ($url === NULL) {
        
        $url ='index.php';
        $link ='Home Page';
    } else {
        if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== '') {
            
            $url =  $_SERVER['HTTP_REFERER'] ;
            $link ='Previous Page';
        } else {
            $url ='index.php';
            $link ='Home Page';
        }
       
    }
    
    echo $theMsg;
    echo "<div class='alert alert-info'>You Will Be Redirected to $link After $seconds Seconds.</div>";
    
    header("refresh:$seconds;url=$url");
    exit();
    
}

/*
 ** Check Items Function v1.0
 ** Function to Check Item In Database [ Function Accept Parameters ]
 ** $select = The Item To Select [ Example: user, Item, category ]
 ** $from = The Table To Select From [ Example: users, items, categories ]
 ** $value = The Value Of Select [ Example: ABDElhamid, Box, Electronics ]
 */

Function checkItem($select, $from, $value) {
    
    global $con;
    
    $statement = $con->prepare("Select $select from $from Where $select = ?");
    
    $statement->execute(array($value));
    
    $count =$statement->rowCount();
    
    return $count;
}

/*
 ** Count Number Of Items Function v1.0
 ** Function To Count Number Of Items Rows
 ** $item = The Item To Count 
 ** $table = The Table To Choose From 
 */

Function CountItems($item, $table) {
    
    global $con;
    
    $stmt2 =$con->prepare("select COUNT($item) FROM $table");
    
    $stmt2->execute();
    
    return $stmt2->fetchColumn();
}

/*
 ** Get Latest Records Function v1.0
 ** Function To Get Latest Items From Database [ Users, Items, Comments ]
 ** $select = Field To Select
 ** $table = The Table To Choose From
 ** $order = The Desc Ordering
 ** $limit = Number Of Records To Get
 **
 */

function getLatest($select, $table, $order, $limit = 5 ) {
    
    global $con;
    
    $getStmt = $con->prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit");
    
    $getStmt->execute();
    
    $rows = $getStmt->fetchAll();
    
    return $rows;
    
}




























 
