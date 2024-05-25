<?php
include "query.php";
?>
<!doctype html>
<html lang="en">
  <head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>
      <div class="container p-5">
        <input type="text" placeholder="Search Here" id="val_inp" name="searchInp" class="form-control">
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Password</th>
                </tr>
            </thead>
            <tbody>
            
            </tbody>
        </table>
      </div>
</body>

<script src="https://code.jquery.com/jquery-3.7.1.js" ></script>
<script>

$(document).ready(function(){
    function selectAllUsers(){
        $.ajax({
            url: "config.php",
            type: "Post",
            success: function(data){
                $('tbody').html(data);
            }
        })
    }
    selectAllUsers();

    $("#val_inp").keyup(function(){
        let inputVal = $(this).val();
        if(inputVal != ""){
            $.ajax({
                url: "query.php",
                type: "post",
                data : {searchInp:inputVal}, 
                success : function(data){
                    $('tbody').html(data);
                }
            })
        }
        else{
            selectAllUsers();
        }
    })
})
</script>
</html>