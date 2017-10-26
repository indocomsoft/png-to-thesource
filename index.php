<html>
<head>
<title>Contest 2.1 Generator</title>
</head>
<body>
<form method="POST" action="contest2.php" enctype="multipart/form-data">
Select image to upload: (must be png)
<input type="file" name="fileToUpload" id="fileToUpload" /><br />
Dithering strength(from 0 to 1):
<input type="text" name="strength" value="0.75"/><br />
<input type="submit" value="Upload Image" name="Submit" />
</form>
</body>

</html>