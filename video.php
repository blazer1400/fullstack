<?php
$output = mysqli_query($sql, $query);
if ($output) {
    while ($data = mysqli_fetch_assoc($output)) {
        echo '
              <div class=videoContainer>
                <img src=http://localhost/joetoep2.0/'.$data['thumbnailpath'].'>
                <a href=../../'.$data['path'].'><h4>'.$data['name'].'</h4></a>
                <a href=http://localhost/joetoep2.0/account/' . $data['accountid'] . '>' . $data['videousername']. '</a>
              </div>
              ';
    }
}
?>