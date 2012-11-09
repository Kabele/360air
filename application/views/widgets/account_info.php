<div class="ui-widget-content ui-corner-all">
Welcome <?=$this->session->userdata('email')?> to 360-air.com!<br />
<?=anchor('accounts/manage', 'Manage Account')?><br />
<?=anchor('accounts/logout', 'Logout')?>
</div>