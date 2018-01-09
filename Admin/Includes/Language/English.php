<?php
function lang ($phrase){
    static $lang=array(
        
        // Navbar Link
        
        'Home_admin'   => 'Home',
        'CATEGORIES'   => 'Categories',
        'ITEMS'        => 'Items',
        'MEMBERS'      => 'Members',
        'COMMENTS'     => 'Comments',
        'STATISTICS'   => 'Statistics',
        'LOGS'         => 'Logs',
        
        '' => '',
        '' => '',
        '' => ''
        
        
    
        
        // Settings
        
    );
    
    return $lang[$phrase];
}

?>