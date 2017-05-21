<?php

class Car{
	public $ID;
	public $model;
	public $productionYear;
	public $trademark;
	public $engineSize;
	function __construct($model,$productionYear,$trademark,$engineSize,$ID){
	$this->model=$model;
	$this->productionYear=$productionYear;
	$this->trademark=$trademark;
	$this->engineSize=$engineSize;
	$this->ID=$ID;
	}
}

$securityQuestions=array(1=>"Where were you born?",2=>"Who is your favourite author?", 3=>"What is your mother\'s maiden name?",4=>"What is your favourite musical genre?");

function uploadValid($info)
{
	if($info["name"]==="")return false;
	$targetPosition=basename($info["name"]);
	$imageFileType = pathinfo($targetPosition,PATHINFO_EXTENSION);
	$uploadOk = true;

    	if(getimagesize($info["tmp_name"])===false)
		$uploadOk = false;
	if (file_exists($targetPosition) && filesize($targetPosition)!= $info["size"]) {
	    	print 'Sorry, file with same name and different size already exists.';
	    	$uploadOk = false;
	}
	
	$mime=explode("/",mime_content_type($info['tmp_name']));
	if ($mime[0]!='image' && ($mime[1]==='jpg' || $mime[1]==='png' || $mime[1]==='jpeg' || $mime==='gif'))
	{
		print "File is not a jpg/png/gif image.";
	$uploadOk=false;
	}
	return $uploadOk;
}

$names=array(1=>"MartinMirchev",2=>"KiroIvanov");
$pictures='pictures/';

$insertUser="INSERT INTO User (FirstName, FamilyName, Age, Sex,PictureName,Password,SecurityAnswer,Email,SecondEmail,SecretQuestion_ID,IsAdministrator) 
				VALUES (:firstName, :familyName, :age, :sex,:pictureName,:password,:securityAnswer,:email,:secondEmail,:secretQuestion_ID,:isAdministrator)";
				
$insertWorker="INSERT INTO WorkMan (Profession, PaymentPerHour,User_ID) VALUES (:profession, :paymentPerHour, :user_ID)";

$insertComment="INSERT INTO Comment (Text,User_ID,WorkMan_ID,WorkMan_USER_ID,ApprovalType_ID) VALUES (:text,:user_ID,:workMan_ID,:workMan_User_ID,:approvalType_ID)";

$insertReply="INSERT INTO Reply (Text,Comment_ID) VALUES (:text,:comment_ID)";

$insertText="INSERT INTO Text (Text,User_ID) VALUES (:text,:user_ID)";


include 'DB.php';

function Login($type,$firstName,$familyName,$password)
{
	return FetchAll("Select * FROM ". $type. " Where FirstName=:firstName and FamilyName=:familyName and Password=:password" ,
					array(":firstName"=>$firstName,":familyName"=>$familyName,":password"=>$password))[0];
	}	
	
function ValidUser($ID,$firstName,$familyName,$password)
{
	$user=Find($ID,"User");
	if($user!=null) return $user->firstName===$firstName && $user->familyName===$familyName && $user->password===$password;
	else return false;
	}
	
function PrintComments($User_ID)
{
	foreach(FindAllFiltered("Comment","User_ID=".$User_ID) as $comment){
		$replies=FindAllFiltered("Reply","Comment_ID=".$comment['ID']);			
		print $comment['Text']."<br>";
		foreach($replies as $reply)
		print $reply['Text']."<br>";
		}
	}
function PrintTexts($User_ID)
{
	foreach(FindAllFiltered("Text","User_ID=".$User_ID) as $text)
		print $text['Text']."<br>";
	
}
function InsertCars($cars,$userID)
{
	foreach($cars as $car){
	InsertCar($car,$userID);
	}
}

function InsertCar($car,$userID)
{
	$values=array(":model"=>$car->model,":engineSize"=>$car->engineSize, ":trademark"=>$car->trademark,":productionYear"=>$car->productionYear);
	Execute("INSERT INTO Car (Model, Trademark, EngineSize, ProductionYear) VALUES (:model,:trademark,:engineSize,:productionYear)",$values);
	
	$carID=FindAllFiltered("Car", "Model=:model AND Trademark=:trademark AND EngineSize=:engineSize AND ProductionYear=:productionYear",$values)[0]['ID'];
	Execute("INSERT INTO CarOwnership (User_ID,Car_ID) VALUES (:user_ID,:car_ID)",array(":user_ID"=>$userID,":car_ID"=>$carID));
	}

function CreateCars($User_ID)
{
	$arr=array();

	foreach(FindAllFiltered("CarOwnership","User_ID=".$User_ID) as $ownership)
			array_push($arr,CreateCar(Find($ownership['Car_ID'],"Car")[0]));
			return $arr;
}
function CreateCar($info)
{
	return new Car($info['Model'],$info['Trademark'],$info['EngineSize'],$info['ProductionYear'],$info['ID']);
	}

function RemoveOwnership($carID,$userID)
{
	Execute("Delete From CarOwnership WHERE Car_ID=:carID AND User_ID=:userID",array(":carID"=>$carID,":userID"=>$userID));
}

function UpdateUser($user,$ID)
{
		Execute("UPDATE User SET Age = :age , Password = :password , SecurityAnswer=:securityAnswer WHERE ID=".$ID,
					array(":age"=>$user['Age'],":password"=>$user['Password'],":securityAnswer"=>$user['SecurityAnswer']));
	}

function UpdateWorker($worker,$User_ID,$Worker_ID)
{
	Execute("UPDATE WorkMan SET Profession = :profession , PaymentPerHour = :paymentPerHour WHERE ID=".$Worker_ID,
				array(":profession"=>$worker['Profession'], ":paymentPerHour"=>$worker['PaymentPerHour']));
	UpdateUser($worker,$User_ID);
	 }

function ToDecimal($input)
{
	return str_replace(",",".",$input);
}

function ErrorCheck(&$errors,$type)
{
		$errors=array();

	if(!uploadValid($_FILES["Profile_Picture"]))
	array_push($errors,'Sorry, there was an error uploading your file. The worker is not created');
	if(!emailValid($_POST['email']))
	array_push($errors,'Invalid first email');
	if(!emailValid($_POST['secondEmail']))
	array_push($errors,'Invalid second email');

	$type=isset($_POST['Worker'])? "Worker": "User";
	
	if(FindAllFiltered($type, "FirstName='".$_POST['firstName']."' AND FamilyName='".$_POST['familyName']."'") || FindAllFiltered($type, "Email='".$_POST['email']."'"))
		array_push($errors,"EXISTING". $type . " by name or email");
	
}
function emailValid($email)
{
	if(filter_var($email,FILTER_VALIDATE_EMAIL))
		return true;
	else return false;
}

?>
