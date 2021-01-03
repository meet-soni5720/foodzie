<?php include('dbh.php'); 

    $post_id = $_GET['id'];
    $sql = "SELECT * FROM post WHERE id=$post_id";
    $res = mysqli_query($conn, $sql);

    if(mysqli_num_rows($res) > 0){
        $post = mysqli_fetch_assoc($res);

        $feat_img = $post['featured_img'];

        $sql = "DELETE FROM post WHERE id=$post_id";
        $res = mysqli_query($conn, $sql);
        if($res){
            $image = end(explode('/',$feat_img));
            unlink("includes/uploads/" . $image);
            header('Location:dashboard.php');
        }else{
            echo "error deleting the post";
            header('Location:dashboard.php');
        }
    }
    else{
        echo "error deleting the post";
        header('Location:dashboard.php');
    }