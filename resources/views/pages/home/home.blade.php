<?php
$page_need = array(
    'url_app' => route('root')
);
?>
@extends('layouts.default')

@section('script')
<?php if (!isset($interests)) $interests = ""; ?>

<script>
    const str_interets = "<?= $interests ?>"
    const array_interets = str_interets.split(",")
    $(document).ready(function() {
        $("#myTags").tagit({
            itemName: 'item',
            fieldName: 'interets[]',
            availableTags: array_interets
        })
    });
</script>
@stop

@section('content')
@include('modals.profile')
<script type="text/javascript" src="js/loca-autocomplete.js"></script>
<script type="text/javascript" src="js/geolocalisation.js"></script>
<div class="app-wrap home-page">

</div>
@stop