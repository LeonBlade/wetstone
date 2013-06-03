<?php

Route::get("/", function () {
	echo "This is the default route!";
});

Route::get("/sample/test", function () {
	echo "I'm at sample!";
});

Route::get("/testing/:sample", function ($sample) {
	echo "testing tests is fun~";
	echo "sample is \"$sample\"";
});

Route::post("/office", function () {
	echo "i shouldn't get here with a normal GET request!";
});

Route::controller("loli");

//

Route::get("/lolis/:id/test", function ($id) {
	View::wet("loli", array('id' => $id));
});

?>
