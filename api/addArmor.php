<?php
require_once __DIR__.'/../core.php';

if(!isset($_POST['type'])){
	die(json_encode(array('error'=>true,'message'=>'Missing Armor Type')));
}
/*Check to see if there is a name and a value, and that the value is > 0*/
if(!isset($_POST['name'])){
	die(json_encode(array('error'=>true,'message'=>'Missing Armor Name')));

/*Needed to change the && used previously*/
if(!isset($_POST['value']) || $_POST['value'] < 0){
	die(json_encode(array('error'=>true,'message'=>'Missing Armor Value or Value is not greater than 0')));
}

/*If value is > 0, check to see that value is in ARMOR:gettypeLabes(), value < 6 should work - TODO find better way?*/
if($_POST['value'] < 6){
	die(json_encode(array('error'=>true,'message'=>'Value is not a valid Armor Type')));
}

/*If name is set check to see that there are no armors of the same name*/
/*TODO check that Storage::getInventorytype is implemented properly ALSO its only used here look for a better way to implement it?
Though function could be useful for future expansions*/
if(Storage::getInventory($_POST['name']) && Storage::getInventoryType($_POST['type'])){
	die(json_encode(array('error'=>true,'message'=>'Armor has same name and type as armor that already exists.')));
}
	
$armor = Armor::createArmor($_POST['type']);
$armor->setName($_POST['name'])->setValue($_POST['value']);

Storage::addInventory($armor);


echo json_encode(array('error'=>false,'message'=>'Armor Added Successfully'));
