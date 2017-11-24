<?php

function get_session_user()
{
    return session('user');
}

function get_session_user_id()
{
    $user = session('user');
    return $user ? $user->id : 0;
}