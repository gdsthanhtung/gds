<?php
    if($id){
        echo "<h1>slider form in view: EDIT $id -- $name</h1>";
    }else{
        echo "<h1>slider form in view: NEW</h1>";
    }


    $slider_list = route($ctrl);
    $slider_new = route("$ctrl/form");
    $slider_edit = route("$ctrl/form", ['id' => 3333]);
    $slider_delete = route("$ctrl/delete", ['id' => 1111]);
    $slider_change_status = route("$ctrl/change-status", ['id' => 2222, 'status' => 'active']);

    echo "<h1>slider index in view</h1>";
    echo "<a href='$slider_list'>List</a> = ";
    echo "<a href='$slider_new'>New</a> = ";
    echo "<a href='$slider_edit'>Edit</a> = ";
    echo "<a href='$slider_delete'>Delete</a> = ";
    echo "<a href='$slider_change_status'>ChangeStatus</a>";
?>
