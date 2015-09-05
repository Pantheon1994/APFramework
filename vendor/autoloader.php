<?php

function __autoload($class_name) {
    include 'logic/controller/'. $class_name . ".php";
}