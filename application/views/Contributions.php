<?php

$this->session->set_userdata(array ('current_page' => uri_string()));
$this->session->set_userdata(array ('current_page_title' => $h1));


?>
<section id="intro">
      <hgroup>
      <h1 style = 'color: #000;display: inline;'><?php echo $h1; ?></h1>&nbsp;&nbsp;&nbsp;&nbsp;<a href = '<?php echo base_url(); ?>'>Home</a> > <?php echo $h1; ?>&nbsp;&nbsp;&nbsp;&nbsp;

	  <form style = 'display: inline; '>
		<select name = 'categories' id = 'categories' onchange="goToCategory(this.value)">
			<option value = ''>-- Change Category --</option>
			<?php foreach ($categories->result() as $category): ?>
				<option value = '<?php echo $category->url; ?>'><?php echo $category->title; ?></option>
			<?php endforeach; ?>
		</select>
	  </form>
	  <br>
	 
	<p><!--Intro Text--></p>
      </hgroup>
   </section>
   <!--end intro-->
   <!--start holder-->
   <div class="holder_content">
	<div style = 'clear: both; padding-top:10px;'></div>
	
	<style>
		table tr td {border:1px solid black;border-collapse:collapse;}
	</style>
	<table >
	<tr>
	<th>Date</th>
	<th>Details</th>
	<th>Income (Tshs.)</th>
	<th>Expenditure (Tshs.)</th>
	</tr>
	<?php $income = 0; $expenditure = 0; ?>
	<?php foreach($contributions->result() as $contribution): ?>
	<tr>
		<td><?php echo date('d-m-Y',strtotime($contribution->transaction_date)); ?></td>
		<td><?php echo strip_tags($contribution->particulars,'<a>'); ?></td>
		<?php if($contribution->transaction_type == 1): ?>
		<?php $income += $contribution->amount; ?>
		<td style='text-align:right'><?php echo number_format($contribution->amount); ?></td>
		<td></td>
		<?php else: ?>
		<?php $expenditure +=  $contribution->amount; ?>
		<td></td>
		<td style='text-align:right'><?php echo number_format($contribution->amount); ?></td></tr>
		<?php endif; ?>
		<?php endforeach; ?>
	<tr>
		<td><?php echo date('d-m-Y'); ?></td>
		<td style = 'font-weight: bold'>TOTALS</td>
		<td style = 'font-weight: bold;text-align:right'><?php echo number_format($income); ?></td>
		<td style = 'font-weight: bold;text-align:right'><?php echo number_format($expenditure); ?></td>
	</tr>
	</table>
	<br>
 	<h2 style = 'text-align: left'>Current Balance is <?php echo number_format($income - $expenditure); ?> </h2>
	<p>To Donate: +255 715 556 327 (Tigo Pesa), +255 753 400 183 (M-Pesa). Why Donate? <a target = '_blank' href = "http://word.office.live.com/wv/WordView.aspx?FBsrc=http%3A%2F%2Fwww.facebook.com%2Fdownload%2Ffile_preview.php%3Fid%3D454354444609482%26metadata&access_token=1466927454%3AAVJz2RsWNBSkWPF174zRilToiEt78zrwzTusqicfX2IV4w&title=TANGAZO+SWAHILIMUSIC.docx">Click Here to Learn More</a></p>

	
	
	<div style = 'clear: both; padding-top:20px;'></div>
	</div>