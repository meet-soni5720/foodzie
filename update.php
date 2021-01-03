<?php include('dbh.php'); ?>

<?php
    $post_id = $_POST['id'];
    $feat_img = $_POST['feat_img'];
    $title = $_POST['title'];
    $desc = $_POST['desc'];
    $body = $_POST['body'];

	if($_FILES['t_image']['size'] > 0){
        //echo "in";
		if($title != '' && $body != '' && $desc != ''){
			$upload_ok = 1;
			$file_name = $_FILES['t_image']['name'];
			$file_size = $_FILES['t_image']['size'];
			$file_tmp = $_FILES['t_image']['tmp_name'];
			$file_type = $_FILES['t_image']['type'];
			$target_dir = "includes/uploads";

			$target_file = $target_dir . basename($_FILES['t_image']['name']);
			$check = getimagesize($_FILES['t_image']['tmp_name']);

			$file_ext = strtolower(end(explode('.', $_FILES['t_image']['name'])));
			echo $file_ext;

			$extensions = array("jpeg","jpg","png");
			if(in_array($file_ext,$extensions) == false){
                $msg = "please insert image in jpeg,jpg or png format!";
                //echo "$msg";
                header('Location:post_update.php?id='. $post_id . "&msg=" . $msg);
			}

			if(file_exists($target_file)){
                $msg = "Sorry file already exists!";
                // echo "$msg";
                header('Location:post_update.php?id='. $post_id . "&msg=" . $msg);
			}

			if($check == false){
                $msg = "file is not an image!";
                // echo "$msg";
                header('Location:post_update.php?id='. $post_id . "&msg=" . $msg);
			}

			if(empty($msg)){
				move_uploaded_file($file_tmp, "includes/uploads/" . $file_name);

				$url = $_SERVER['HTTP_REFERER'];
				$seg = explode('/',$url);
				$path = $seg[0] . '/' . $seg[1] . '/' . $seg[2] . '/' . $seg[3];
                $full_url = $path . '/' . 'includes/uploads/' . $file_name;
                
                $image_path = explode('/',$feat_img);
                $image = end($image_path);

                $que = "UPDATE post
                        SET title = '$title', description = '$desc', body = '$body', featured_img = '$full_url'
                        WHERE id=$post_id";
                $res = mysqli_query($conn, $que) or die(mysqli_error($conn));
                
                // echo "includes/uploads/" . $image;
                unlink("includes/uploads/" . $image);

				if($res){
					$checkbox = $_POST['ing'];
					if(empty($checkbox)){
                        $msg = "please select atleast one ingredient!";
                        echo "$msg";
					}
					else{
                    $arr = array();
                    $q = "SELECT ingredient_id FROM pi_relation WHERE post_id = $post_id";
                    $r = mysqli_query($conn, $q) or die(mysqli_error($conn));
                    while($i = mysqli_fetch_assoc($r)){
                        array_push($arr,$i['ingredient_id']);
                    }

					foreach($checkbox as $ing){
						$q1 = "SELECT ing_id from ingredients where name = '$ing'";
						$r = mysqli_query($conn, $q1);
						$ing_id = mysqli_fetch_array($r);
                        $i_id = $ing_id['ing_id'];
                        
                        if(!in_array($i_id,$arr)){
						$que = "INSERT INTO pi_relation(post_id, ingredient_id) VALUES($post_id, $i_id)";

						$res = mysqli_query($conn, $que);
						if($res){
							header("Location:dashboard.php");
						}
						else{
                            $msg = "error adding ingredients";
                            header('Location:post_update.php?id='. $post_id . "&msg=" . $msg);
                            // echo "$msg";
                        }
                    }
				}
				}
			}
		}

			
		}
		else{
            $msg = "Please fill all the details!";
            header('Location:post_update.php?id='. $post_id . "&msg=" . $msg);
		}
	}
	else{
        //echo "in2";
        if($title != '' && $body != '' && $desc != ''){
            $sql = "UPDATE post
                    SET title = '$title', description = '$desc', body = '$body'
                    WHERE id = $post_id";
            $res = mysqli_query($conn, $sql) or die("initial " . mysqli_error($conn));

            if($res){
                $checkbox = $_POST['ing'];
					if(empty($checkbox)){
                        $msg = "please select atleast one ingredient!";
                        header('Location:post_update.php?id='. $post_id . "&msg=" . $msg);
					}
					else{
                    $arr = array();
                    $q = "SELECT ingredient_id FROM pi_relation WHERE post_id = $post_id";
                    $r = mysqli_query($conn, $q) or die("checkbox " . mysqli_error("checkbox" . $conn));
                    while($i = mysqli_fetch_assoc($r)){
                        array_push($arr,$i['ingredient_id']);
                    }

					foreach($checkbox as $ing){
						$q1 = "SELECT ing_id from ingredients where name = '$ing'";
						$r = mysqli_query($conn, $q1);
						$ing_id = mysqli_fetch_array($r);
                        $i_id = $ing_id['ing_id'];
                        
                        if(!in_array($i_id,$arr)){
						$que = "INSERT INTO pi_relation(post_id, ingredient_id) VALUES($post_id, $i_id)";

						$res = mysqli_query($conn, $que);
						if($res){
							header("Location:dashboard.php");
						}
						else{
                            $msg = "error adding ingredients";
                            header('Location:post_update.php?id='. $post_id . "&msg=" . $msg);
                        }
                    }
                    }
                    
                    header('Location:dashboard.php');
				}
            }
        }
    }

?> 