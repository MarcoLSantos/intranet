<html>
<head><title>Oracle demo</title></head>
<body>
    <?php 
    $conn=oci_connect("dbamv","dbamv","172.16.8.180/hml");
    If (!$conn)
        echo 'Failed to connect to Oracle';
    else
        echo 'Succesfully connected with Oracle DB';
 
oci_close($conn);
?>
 
</body>
</html>