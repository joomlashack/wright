<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
?>
<?php if ( ( $this->params->get( 'address_check' ) > 0 ) &&  ( $this->contact->address || $this->contact->suburb  || $this->contact->state || $this->contact->country || $this->contact->postcode ) ) : ?>
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<?php if ( $this->params->get( 'address_check' ) > 0 ) : ?>
<tr>
	<td rowspan="6" width="30%" valign="top" width="30%">
		<?php echo $this->params->get( 'marker_address' ); ?>
	</td>
</tr>
<?php endif; ?>
<?php if ( $this->contact->address && $this->params->get( 'show_street_address' ) ) : ?>
<tr>
	<td valign="top">
		<?php echo nl2br($this->escape($this->contact->address)); ?>
	</td>
</tr>
<?php endif; ?>
<?php if ( $this->contact->suburb && $this->params->get( 'show_suburb' ) ) : ?>
<tr>
	<td valign="top">
		<?php echo $this->escape($this->contact->suburb); ?>
	</td>
</tr>
<?php endif; ?>
<?php if ( $this->contact->state && $this->params->get( 'show_state' ) ) : ?>
<tr>
	<td valign="top">
		<?php echo $this->escape($this->contact->state); ?>
	</td>
</tr>
<?php endif; ?>
<?php if ( $this->contact->postcode && $this->params->get( 'show_postcode' ) ) : ?>
<tr>
	<td valign="top">
		<?php echo $this->escape($this->contact->postcode); ?>
	</td>
</tr>
<?php endif; ?>
<?php if ( $this->contact->country && $this->params->get( 'show_country' ) ) : ?>
<tr>
	<td valign="top">
		<?php echo $this->escape($this->contact->country); ?>
	</td>
</tr>
<?php endif; ?>
</table>
<br />
<?php endif; ?>
<?php if ( ($this->contact->email_to && $this->params->get( 'show_email' )) ||
			($this->contact->telephone && $this->params->get( 'show_telephone' )) ||
			($this->contact->fax && $this->params->get( 'show_fax' )) ||
			($this->contact->mobile && $this->params->get( 'show_mobile' )) ||
			($this->contact->webpage && $this->params->get( 'show_webpage' )) ) : ?>
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<?php if ( $this->contact->email_to && $this->params->get( 'show_email' ) ) : ?>
<tr>
	<td width="30%">
		<?php echo $this->params->get( 'marker_email' ); ?>
	</td>
	<td>
		<?php echo $this->contact->email_to; ?>
	</td>
</tr>
<?php endif; ?>
<?php if ( $this->contact->telephone && $this->params->get( 'show_telephone' ) ) : ?>
<tr>
	<td width="30%">
		<?php echo $this->params->get( 'marker_telephone' ); ?>
	</td>
	<td>
		<?php echo nl2br($this->escape($this->contact->telephone)); ?>
	</td>
</tr>
<?php endif; ?>
<?php if ( $this->contact->fax && $this->params->get( 'show_fax' ) ) : ?>
<tr>
	<td width="30%">
		<?php echo $this->params->get( 'marker_fax' ); ?>
	</td>
	<td>
		<?php echo nl2br($this->escape($this->contact->fax)); ?>
	</td>
</tr>
<?php endif; ?>
<?php if ( $this->contact->mobile && $this->params->get( 'show_mobile' ) ) :?>
<tr>
	<td width="30%">
	<?php echo $this->params->get( 'marker_mobile' ); ?>
	</td>
	<td>
		<?php echo nl2br($this->escape($this->contact->mobile)); ?>
	</td>
</tr>
<?php endif; ?>
<?php if ( $this->contact->webpage && $this->params->get( 'show_webpage' )) : ?>
<tr>
	<td width="30%">
	</td>
	<td>
		<a href="<?php echo $this->escape($this->contact->webpage); ?>" target="_blank">
			<?php echo $this->escape($this->contact->webpage); ?></a>
	</td>
</tr>
<?php endif; ?>
</table>
<?php endif; ?>
<br />
<?php if ( $this->contact->misc && $this->params->get( 'show_misc' ) ) : ?>
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td width="30%" valign="top" >
		<?php echo $this->params->get( 'marker_misc' ); ?>
	</td>
	<td>
		<?php echo nl2br($this->contact->misc); ?>
	</td>
</tr>
</table>
<br />
<?php endif; ?>