<?php
$name=$_FILES['foo']['name'];  //���ε��� ���� �̸� �޾ƿ���
$size=$_FILES['foo']['size'];
$date = date("Y-m-d H:i:s");
$new_filename = uniqid();
require 'vendor/autoload.php'; //���
$storage = new \Upload\Storage\FileSystem('saveFile'); //���¼ҽ� -> ���� ����� ����
$file = new \Upload\File('foo', $storage); // ���¼ҽ� -> ���� ���� �޾ƿ���

//db ���� 
$con = new mysqli("localhost","root","Tkddyd@135","oss");
$con->set_charset("utf8");

if ($con->connect_error) {
  die("Fail : " .$con->connect_error); // ���� ���� �� ������ ����Ѵ�
} else {
  echo "OK"; // ���� ���� �� �� ������ �»�ܿ� ���� �����̶�� ������ ����Ѵ�
}
$number_query = "select * from FileDownload where name;";
$number = mysqli_query($con,$number_query);
$number_count = count($number);

echo $number;
$query = "
	INSERT INTO FileDownload
    	(number,name,uname,date,size)
    VALUES('$number','$name','$new_filename','$date','$size');";
mysqli_query($con,$query);

$file->setName($new_filename);
if ($result === false) { // false�� ���Դٸ� ���� �������� ����Ѵ�(29�� ����  �±׸� �ּ� �ľ� ����� �� �� �ִ�)
    echo mysqli_error($con);
}

$file->addValidations(array(
    new \Upload\Validation\Mimetype('image/png'),     #�̹������� ���ε� ����
    new \Upload\Validation\Size('5M') #5�ް� ���� ���尡�� 
));

$data = array(
    'name'       => $file->getNameWithExtension(),
    'extension'  => $file->getExtension(),
    'mime'       => $file->getMimetype(),
    'size'       => $file->getSize()
);

try {
    $file->upload();
} catch (\Exception $e) {
    $errors = $file->getErrors();
}
?>