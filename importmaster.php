<?php
require "bootstrap.php";
use Src\Controllers\CountryCurrencyController;
$tableName = "";
if (isset($_POST["table"])) {
    $tableName = $_POST["table"];
}
$countryCurrency = new CountryCurrencyController($dbConnection, $tableName);
if (isset($_POST["import"])) {
    $response = $countryCurrency->readRecords();
}

?>

<html>
<head>
<link href="style.css" rel="stylesheet" type="text/css" />
</head>
<body>
    <h2>Import CSV file</h2>
    <div class="outer-scontainer">
        <div class="row">
            <form class="form-horizontal" action="" method="post"
                name="frmCSVImport" id="frmCSVImport"
                enctype="multipart/form-data"
                onsubmit="return validateFile()">
                <div Class="input-row">
                    <input type="radio" name="table" value="currencies" checked>Currencies<br>
                    <input type="radio" name="table" value="countries">Countries<br><br>
                    <input type="file" name="file" id="file" class="file" accept=".csv,.xls,.xlsx">
                    <div class="import">
                        <button type="submit" id="submit" name="import"
                            class="btn-submit">Import</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div id="response"
        class="<?php if(!empty($response["type"])) { echo $response["type"] ; } ?>">
        <?php if(!empty($response["message"])) { echo $response["message"]; } ?>
    </div>
</body>
<script src="jquery.min.js"></script>
<script type="text/javascript">
function validateFile() {
    var csvInputFile = document.forms["frmCSVImport"]["file"].value;
    if (csvInputFile == "") {
      error = "No source found to import";
      $("#response").html(error).addClass("error");;
      return false;
    }
    return true;
  }

</script>
</html>