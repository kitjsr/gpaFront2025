<?php
require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
//require_once("models/header.php");

// Fetch All Discipline Details
$allDetails=fetchAllNotice();

// load library
require 'php-excel.class.php';

// create a simple 2-dimensional array
$data = array(
        1 => array ('Name', 'Surname'),
        array('Schwarz', 'Oliver'),
        array('Test', 'Peter')
        );
// Create a multi-dimessional array
$dataTitle = array(
        1 => array ('ID', 'TITLE', 'DESCRIPTION', 'NEW', 'HOME', 'DATE')
        );
$dataFooter = array(
        1 => array ('', '', '', ''),
		array('Note:', '1(Yes), 2(No)', '', '')
        );
// generate file (constructor parameters are optional)
$xls = new Excel_XML('UTF-8', false, 'notices');
$xls->addArray($dataTitle);
$xls->addArray($allDetails);
$xls->addArray($dataFooter);
$xls->generateXML('notice_details');