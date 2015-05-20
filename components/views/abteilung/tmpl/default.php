<?php
defined('_JEXEC') or die('Restricted access');

?>


<h1><?php echo $this->abteilung->name; ?></h1>

<style type="text/css">
<!--
tr.row0 td
{
background-color: #f0f0f0;
}

tr.row1 td
{
background-color: #ffffff;
}
table
{
	border-spacing:0;
}

-->
</style>
<table class="contentpaneopen">

	<tr>
		<td valign="top">

			<?php
				echo $this->abteilung->description;
			?>
			<br />
			<?php if(is_array($this->abteilung->mitglieder)) {?>
			<h3>Namen</h3>
			<table class="adminlist" width="100%">
				<!-- tr>
					<th>Name</th>
				</tr-->
				<?php
				$count=0;
				$k=0;
				foreach($this->abteilung->mitglieder as $mitglied) {
				if ($count %2 == 0)
				{
				?>

				<tr class="<?php echo "row$k"; ?>">
				<?php
				}
				?>
					<td align="<?php echo ($count%2==0)?'left':'right'?>">
						<a href="index.php?option=com_mitglieder&layout=default&view=mitglied&id=<?php echo $mitglied->id;?>">
							<?php echo $mitglied->name . ", " . $mitglied->vorname;?>
						</a>&nbsp;
					</td>
				<?php
				if ($count %2 == 1)
				{
				?>

				</tr>


				<?php
				$k=1-$k;
				}
				else {
					?>
					<td>&nbsp;</td>
					<?php
				}
				$count++;
				}
				//Offene Zeile ggf. schließen
				if ($count %2 == 1)
				{
				?>
					<td>&nbsp;</td>
				</tr>


				<?php
				}



				?>

			</table>
			<?php
			}
			?>
		</td>
	</tr>
	<tr>
		<td>
			<span id="teamtabelle"></span>
		</td>
	</tr>
</table>
