<?php 

if (disconnected()) {

    session_destroy();

    header("location:".PROJECT."customer/login");
}
