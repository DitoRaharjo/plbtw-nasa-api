<!DOCTYPE html>
<html>
<head>
	<title>PLBTW - NASA's Mars Exploration Rover Program Data</title>

	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.2/jquery.mobile-1.4.2.min.css" />
	<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
	<script src="http://code.jquery.com/mobile/1.4.2/jquery.mobile-1.4.2.min.js"></script>
</head>
<body>

<div data-role="page" data-theme="a">

	<div data-role="header">
		<h1>PLBTW - NASA's Mars Exploration Rover Program Data</h1>
	</div><!-- /header -->

	<div role="main" class="ui-content">
		<ul data-role="listview" data-filter="true" data-inset="true">
		<?php
   			foreach($photos as $things=> $value)
			{
		?>
				<?php
				 	if($value['error'] != NULL) {
				 ?>
				 	<h1><?php echo $value['error'];?></h1>
				 <?php
			 		} else {
				  ?>
				<li>
					<h2><?php echo 'Date : ' . $value['date'];?></h2>
					<a href="<?php echo $value['img_src']  ?>" target="_blank">
						<img width="88" height="88" src="<?php echo $value['img_src'] ?>"/>
					</a>
				</li>
				<?php
					}
				?>
		<?php
			}
		?>

		</ul>
	</div><!-- /content -->

	<div data-role="footer">
		<h4>&copy; PLBTW 2016 by YSP</h4>
	</div><!-- /footer -->
</div><!-- /page -->

</body>
</html>
