<!-- Test Oracle file for UBC CPSC304
  Created by Jiemin Zhang
  Modified by Simona Radu
  Modified by Jessica Wong (2018-06-22)
  Modified by Jason Hall (23-09-20)
  This file shows the very basics of how to execute PHP commands on Oracle.
  Specifically, it will drop a table, create a table, insert values update
  values, and then query for values
  IF YOU HAVE A TABLE CALLED "demoTable" IT WILL BE DESTROYED

  The script assumes you already have a server set up All OCI commands are
  commands to the Oracle libraries. To get the file to work, you must place it
  somewhere where your Apache server can run it, and you must rename it to have
  a ".php" extension. You must also change the username and password on the
  oci_connect below to be your ORACLE username and password
-->

<?php
// The preceding tag tells the web server to parse the following text as PHP
// rather than HTML (the default)

// The following 3 lines allow PHP errors to be displayed along with the page
// content. Delete or comment out this block when it's no longer needed.
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Set some parameters

// Database access configuration
$config["dbuser"] = "ora_nelsonl1";			// change "cwl" to your own CWL
$config["dbpassword"] = "a32900045";		// change to 'a' + your student number
$config["dbserver"] = "dbhost.students.cs.ubc.ca:1522/stu";
$db_conn = null;	// login credentials are used in connectToDB()


// ADDED THIS : initializes db_conn
connectToDB();

$success = true;	// keep track of errors so page redirects only if there are no errors

$show_debug_alert_messages = False; // show which methods are being triggered (see debugAlertMessage())

// The next tag tells the web server to stop parsing the text as PHP. Use the
// pair of tags wherever the content switches to PHP

// ADDED THIS : Check if buttons have been clicked
if (isset($_POST['resetTablesRequest'])) {
    // The reset button was clicked, call the handleResetRequest function
    handleResetRequest();
	echo "Reset/Initialized Tables!";
} elseif (isset($_POST['insertQueryRequest'])) {
	// The insert button was clicked, call the handleResetRequest function
	handleInsertRequest();
	echo "Inserted values into table!";
} elseif (isset($_POST['updateQueryRequest'])) {
	// The update button was clicked, call the handleUpdateRequest function
    handleUpdateRequest();
	echo "Updated query!";
} elseif (isset($_POST['countTupleRequest'])) {
	// The count button was clicked, call the handleCountRequest function
	handleCountRequest();
	echo "Counted tuples!!";
} elseif (isset($_POST['displayTuplesRequest'])) {
	// The display button was clicked, call the handleDisplayRequest function
	handleDisplayRequest();
	echo "Displaying tuples!!";
}


?>

<html>

<head>
	<title>CPSC 304 - PC Parts Database Project</title>
</head>

<body>
	<h2>Reset</h2>
	<p>To reset the tables to the original values, please click the "Reset" button below. If this is the first time you're running this page, please click "Reset" to initialize the tables</p>

	<form method="POST" action="template.php">
		<!-- "action" specifies the file or page that will receive the form data for processing. As with this example, it can be this same file. -->
		<input type="hidden" id="resetTablesRequest" name="resetTablesRequest">
		<p><input type="submit" value="Reset" name="reset"></p>
	</form>

	<!-- ADDED THIS -->
	<style>
		.form-block {
			display: flex;
			justify-content: space-between;
			height: 500px;
		}
		.form-section {
			display: inline-block;
			width: 30%;
			/* height: 300px;  */
			margin-right: 2%;
		}
	</style>

	<div class="form-container">
		<div class="form-section">
			<hr />
			<h2>Insert Values into CPU Cooler Table</h2>
			<p>This will insert a new row into the currect CPU Cooler Table. (*) fields must be entered.</p>
			<form method="POST" action="template.php">
				<input type="hidden" id="insertQueryRequest" name="insertQueryRequest">
				Model (*): <input type="text" name="insModel"> <br /><br />
				CPUCooler_Size (*): <input type="text" name="insSize"> <br /><br />
				Price : <input type="text" name="insSize"> <br /><br />
				CPU_Model : <input type="text" name="insSize"> <br /><br />

				<input type="submit" value="Insert" name="insertSubmit"></p>
			</form>
			<hr />
		</div>

		<div class="form-section">
			<hr />
			<h2>Delete Row in CPU Cooler Table</h2>
			<p>This delete a row in the CPU Cooler Table. Specify the row by stating its Model and Size.</p>
			<form method="POST" action="template.php">
				<input type="hidden" id="updateQueryRequest" name="updateQueryRequest">
				Model : <input type="text" name="delModel"> <br /><br />
				CPUCooler_Size : <input type="text" name="delSize"> <br /><br />

				<input type="submit" value="Delete" name="deleteSubmit"></p>
			</form>
			<hr />
		</div>

		<div class="form-section">
			<hr />
			<h2>Update Name in CPU Cooler Table</h2>
			<p>This will change all the names that are currently the old name to the new name in the table. The values are case sensitive and if you enter in the wrong case, the update statement will not do anything.</p>
			<form method="POST" action="template.php">
				<input type="hidden" id="updateQueryRequest" name="updateQueryRequest">
				Model : <input type="text" name="upModel"> <br /><br />
				CPUCooler_Size : <input type="text" name="upSize"> <br /><br />
				Column to Change: <input type="text" name="upCol"> <br /><br />
				New Value: <input type="text" name="newVal"> <br /><br />

				<input type="submit" value="Update" name="updateSubmit"></p>
			</form>
			<hr />
		</div>
	</div>

	<!-- ADDED THIS -->
	<style>
        .table-container {
            display: inline-block;
            margin-right: 20px;
        }
    </style>

	<div>
		<div class="table-continer">
			<h2>CPU Cooler Table</h2>

			<?php
			$sql = "SELECT * FROM CPUCooler_On";
			$result = executePlainSQL($sql);
			echo "<table border='5'>";
			printCPUCoolerTable($result);
			echo "</table>";
			?>
		</div>

		<div class="table-continer">
			<h2>CPU Table</h2>

			<?php
			$sql = "SELECT * FROM CPU_On";
			$result = executePlainSQL($sql);
			echo "<table border='5'>";
			printCPUCoolerTable($result);
			echo "</table>";
			?>
		</div>
    </div>


	<!-- <h2>Count the Tuples in DemoTable</h2>
	<form method="GET" action="template.php">
		<input type="hidden" id="countTupleRequest" name="countTupleRequest">
		<input type="submit" name="countTuples"></p>
	</form>

	<hr /> -->

	<h2>Display Tuples in DemoTable</h2>
	<form method="GET" action="template.php">
		<input type="hidden" id="displayTuplesRequest" name="displayTuplesRequest">
		<input type="submit" name="displayTuples"></p>
	</form>


	<?php
	// The following code will be parsed as PHP

	function debugAlertMessage($message)
	{
		global $show_debug_alert_messages;

		if ($show_debug_alert_messages) {
			echo "<script type='text/javascript'>alert('" . $message . "');</script>";
		}
	}

	function executePlainSQL($cmdstr)
	{ //takes a plain (no bound variables) SQL command and executes it
		//echo "<br>running ".$cmdstr."<br>";
		global $db_conn, $success;

		$statement = oci_parse($db_conn, $cmdstr);
		//There are a set of comments at the end of the file that describe some of the OCI specific functions and how they work

		if (!$statement) {
			echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
			$e = OCI_Error($db_conn); // For oci_parse errors pass the connection handle
			echo htmlentities($e['message']);
			$success = False;
		}

		$r = oci_execute($statement, OCI_DEFAULT);
		if (!$r) {
			echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
			$e = oci_error($statement); // For oci_execute errors pass the statementhandle
			echo htmlentities($e['message']);
			$success = False;
		}

		return $statement;
	}

	function executeBoundSQL($cmdstr, $list)
	{
		/* Sometimes the same statement will be executed several times with different values for the variables involved in the query.
		In this case you don't need to create the statement several times. Bound variables cause a statement to only be
		parsed once and you can reuse the statement. This is also very useful in protecting against SQL injection.
		See the sample code below for how this function is used */

		global $db_conn, $success;
		$statement = oci_parse($db_conn, $cmdstr);

		if (!$statement) {
			echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
			$e = OCI_Error($db_conn);
			echo htmlentities($e['message']);
			$success = False;
		}

		foreach ($list as $tuple) {
			foreach ($tuple as $bind => $val) {
				//echo $val;
				//echo "<br>".$bind."<br>";
				oci_bind_by_name($statement, $bind, $val);
				unset($val); //make sure you do not remove this. Otherwise $val will remain in an array object wrapper which will not be recognized by Oracle as a proper datatype
			}

			$r = oci_execute($statement, OCI_DEFAULT);
			if (!$r) {
				echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
				$e = OCI_Error($statement); // For oci_execute errors, pass the statementhandle
				echo htmlentities($e['message']);
				echo "<br>";
				$success = False;
			}
		}
	}

	// ADDED THIS
	function printCPUCoolerTable($result)
	{
		echo "<tr>";
		for ($i = 1; $i <= oci_num_fields($result); $i++) {
			$col_name = oci_field_name($result, $i);
			echo "<th>$col_name</th>";
		}
		echo "</tr>";

		while ($row = oci_fetch_assoc($result)) {
			echo "<tr>";
			foreach ($row as $column => $value) {
				echo "<td>$value</td>";
			}
			echo "</tr>";
		}
	}


	function printResult($result)
	{ //prints results from a select statement
		echo "<br>Retrieved data from table demoTable:<br>";
		echo "<table>";
		echo "<tr><th>ID</th><th>Name</th></tr>";

		while ($row = OCI_Fetch_Array($result, OCI_ASSOC)) {
			echo "<tr><td>" . $row["ID"] . "</td><td>" . $row["NAME"] . "</td></tr>"; //or just use "echo $row[0]"
		}

		echo "</table>";
	}

	function connectToDB()
	{
		global $db_conn;
		global $config;

		// Your username is ora_(CWL_ID) and the password is a(student number). For example,
		// ora_platypus is the username and a12345678 is the password.
		// $db_conn = oci_connect("ora_cwl", "a12345678", "dbhost.students.cs.ubc.ca:1522/stu");
		$db_conn = oci_connect($config["dbuser"], $config["dbpassword"], $config["dbserver"]);

		if ($db_conn) {
			debugAlertMessage("Database is Connected");
			return true;
		} else {
			debugAlertMessage("Cannot connect to Database");
			$e = OCI_Error(); // For oci_connect errors pass no handle
			echo htmlentities($e['message']);
			return false;
		}
	}

	function disconnectFromDB()
	{
		global $db_conn;

		debugAlertMessage("Disconnect from Database");
		oci_close($db_conn);
	}

	function handleUpdateRequest()
	{
		global $db_conn;

		$old_name = $_POST['oldName'];
		$new_name = $_POST['newName'];

		// you need the wrap the old name and new name values with single quotations
		executePlainSQL("UPDATE demoTable SET name='" . $new_name . "' WHERE name='" . $old_name . "'");
		oci_commit($db_conn);
	}

	function handleResetRequest()
	{
		global $db_conn;

		// Create new table
		echo "<br> Reseting / Initializing tables for PC parts <br>";
		// executePlainSQL("start pc_project.sql");

		$scriptContents = file_get_contents("../cs304/project_a0b7q_a1s7u_s8i3z/pc_project.sql");
		$commands = explode(";", $scriptContents);

		foreach ($commands as $command) {
			$command = trim($command);
			$statement = oci_parse($db_conn, $command);

            if (!$statement) {
                echo "<br>Cannot parse the following command: " . $command . "<br>";
                $e = OCI_Error($db_conn);
                echo htmlentities($e['message']);
                $success = false;
            } else {
                $r = oci_execute($statement, OCI_DEFAULT);
                if (!$r && oci_error($statement)['code'] != 942) {
					// Ignore error code 942, which indicates the table does not exist
                    echo "<br>Cannot execute the following command: " . $command . "<br>";
                    $e = oci_error($statement);
                    echo htmlentities($e['message']);
                    $success = false;
                }
            }
        }
		oci_commit($db_conn);
	}

	function handleInsertRequest()
	{
		global $db_conn;

		//Getting the values from user and insert data into the table
		$tuple = array(
			":bind1" => $_POST['insNo'],
			":bind2" => $_POST['insName']
		);

		$alltuples = array(
			$tuple
		);

		executeBoundSQL("insert into demoTable (id, name) values (:bind1, :bind2)", $alltuples);
		oci_commit($db_conn);
	}

	function handleDisplayRequest()
	{
		global $db_conn;
		$result = executePlainSQL("SELECT * FROM demoTable");
		printResult($result);
	}

	// HANDLE ALL POST ROUTES
	// A better coding practice is to have one method that reroutes your requests accordingly. It will make it easier to add/remove functionality.
	function handlePOSTRequest()
	{
		if (connectToDB()) {
			if (array_key_exists('resetTablesRequest', $_POST)) {
				handleResetRequest();
			} else if (array_key_exists('updateQueryRequest', $_POST)) {
				handleUpdateRequest();
			} else if (array_key_exists('insertQueryRequest', $_POST)) {
				handleInsertRequest();
			}

			disconnectFromDB();
		}
	}

	// HANDLE ALL GET ROUTES
	// A better coding practice is to have one method that reroutes your requests accordingly. It will make it easier to add/remove functionality.
	function handleGETRequest()
	{
		if (connectToDB()) {
			if (array_key_exists('countTuples', $_GET)) {
				handleCountRequest();
			} elseif (array_key_exists('displayTuples', $_GET)) {
				handleDisplayRequest();
			}

			disconnectFromDB();
		}
	}

	if (isset($_POST['reset']) || isset($_POST['updateSubmit']) || isset($_POST['insertSubmit'])) {
		handlePOSTRequest();
	} else if (isset($_GET['countTupleRequest']) || isset($_GET['displayTuplesRequest'])) {
		handleGETRequest();
	}

	// End PHP parsing and send the rest of the HTML content
	?>
</body>

</html>
