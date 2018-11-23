<?php

function gerar($user){
    echo "<br><b>".$user.':</b> ';
    echo password_hash($user, PASSWORD_DEFAULT);
}

gerar('root');
gerar('admin');
gerar('user');
gerar('trainee');
