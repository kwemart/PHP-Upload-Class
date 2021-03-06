<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Reich\Upload;

if(Upload::submitted()) {
  // give the constructor the name of the html input field
  $upload = new Upload('file');

  $upload->setDirectory('images')->create(true);

  $upload->addRules([
            'size' => 1500,
            'extensions' => 'jpg|png',
          ])->customErrorMessages([
            'size' => 'Please upload files that are less than 2MB size',
            'extensions' => 'Please upload only jpg, png or pdf'
          ]);

  $upload->encryptFileNames(true)->only('png|png');

  $upload->start();

  $upload->success(function($file) {
    // handle successful uploads.
  });

  $upload->error(function($file) {
    // handle faliure uploads.
  });
}

?><!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8" />
	<title>Files Uploader</title>
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
</head>
<?php

if (Upload::submitted()) {
  if ($upload->unsuccessfulFilesHas()) {
    $upload->displayErrors();
  }
  elseif ($upload->successfulFilesHas()) {
    $upload->displaySuccess();
  }
}

?>
<body>
  <br/>
  <div class="container">
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
      <div class="form-group">
    		<input type="file" name="file[]" class="form-control-file" multiple required>
  		</div>
      <div class="form-group">
        <input type="submit" value="Upload" class="btn btn-primary">
  	 </div>
    </form>
</div>
</body>
</html>
