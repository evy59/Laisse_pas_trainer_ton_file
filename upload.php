<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Error</title>
    <link type="text/css" rel="stylesheet" href="style.css">
</head>
<?php
if (!empty($_FILES['files']['name'][0])){
    $files = $_FILES['files'];
    $uploaded = array();
    $failed = array();
    $allowed = array('jpg', 'png', 'gif');
    foreach ($files['name'] as $position =>$file_name){
        $file_tmp = $files['tmp_name'][$position];
        $file_size = $files['size'][$position];
        $file_error = $files['error'][$position];
        $file_ext = explode('.', $file_name);
        $file_ext = strtolower(end($file_ext));
        if(in_array($file_ext, $allowed)){
            if($file_error === 0){
                if($file_size <=1000000){
                    $file_name_new = uniqid('image', false). '.'.$file_ext;
                    $file_destination = 'uploads/'. $file_name_new;
                    if(move_uploaded_file($file_tmp, $file_destination)){
                        $uploaded[$position] = $file_destination;
                    } else {
                        $failed[$position] = "[{$file_name}] L'Image n'a pas réussi à être envoyé";
                    }
                } else {
                    $failed[$position] = "[{$file_name}] L'Image est trop volumineux.";
                }
            } else {
                $failed[$position] = "[{$file_name}] Erreur lors du chargement{$file_error}.";
            }
        } else {
            $failed[$position]="[{$file_name}] L'extension de fichier '{$file_ext}' n'est pas permise.";
        }
    }
    if(!empty($uploaded)){

        header('Location: index.php');
    }
    elseif(!empty($failed)){

        echo
            "<h2 class='text-center'>Nooooooon, ça ne marche pas! Mais vous pouvais réessayer.</h2>".
            "</br>".
            "<img src='https://mvistatic.com/photosmvi/2018/08/08/P17952300D3505652G_px_640_.jpg' class='col-md-4 col-md-offset-4'>".
            "</br>".
            "<a href='index.php' class='btn btn-info text-center'>Revenir à la galerie d'Images.</a>";
    }
}

