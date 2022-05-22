<?php
//db ���� 
session_start();
$db = new mysqli("localhost","root","Tkddyd@135","oss");
$db->set_charset("utf8");

if ($db->connect_error) {
  die("Fail : " .$db->connect_error); // ���� ���� �� ������ ����Ѵ�
} else {
  echo "OK"; // ���� ���� �� �� ������ �»�ܿ� ���� �����̶�� ������ ����Ѵ�
}

function query($query)
{
	global $db;
	return $db->query($query);
}
?>