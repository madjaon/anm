<?php 
	$posPc = isset($posPc)?$posPc:null;
	$postMobile = isset($postMobile)?$postMobile:null;
?>
@if(getDevice2() == MOBILE)
	{!! CommonQuery::getAdByPosition($postMobile) !!}
@else
	{!! CommonQuery::getAdByPosition($posPc) !!}
@endif