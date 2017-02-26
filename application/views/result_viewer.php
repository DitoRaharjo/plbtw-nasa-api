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
   			foreach($rovers as $things=> $value)
			{

		?>

				<li>

					<h2><?php echo 'Rover Name (Mission Status) : ' . $value['name']. ' ( '.$value['status'].' )';?></h2>
					<p><?php echo 'Launch Date - Landing Date (Length of Journey) : ' . $value['launch_date']. '  -  ' . $value['landing_date'].' ( ' .$value['days'].' day )'; ?></p>
					<p><?php echo 'Recent Communication Date : ' . $value['recent_photo_taken']; ?></p>
					<p><?php echo 'Days in Mars : ' . $value['active_days']. ' day'; ?></p>
					<p><?php echo 'Total Photo Taken : ' . $value['total_photo']; ?></p>
					<p><?php echo 'Cameras (Photo for Mars Day-Sol = 100) : '; ?></p>
					<?php
						for ($index=0;$index<count($value['cameras']);$index++) {
					?>
						<?php
							if( $index<(count($value['cameras'])-1) ) {
						?>
						<ul>
							<li>
								<a href="
								<?php
									echo "http://localhost:81/plbtw/index.php/service/photoindex/".$value['name']."/".$value['cameras'][$index];
								?>">
									<?php
								 		echo $value['cameras'][$index+1];
								 	?>
								</a>
						 </li>
						</ul>
						<?php
							$index++;
							}
						 ?>
					<?php
						}
					?>


				</li>
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
