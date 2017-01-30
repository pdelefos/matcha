<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js" type="text/javascript" charset="utf-8"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.12/jquery-ui.min.js" type="text/javascript" charset="utf-8"></script>
<link rel="stylesheet" type="text/css" href="{{ route('root') }}/css/jquery-ui.css">
<link href="css/jquery.tagit.css" rel="stylesheet" type="text/css">
<script src="js/tag-it.js" type="text/javascript" charset="utf-8"></script>
<div class="profile-modal">
    <div class="profile-modal__content modal-search">
        <a href="{{ route('home') }}" class="modal-close"><div data-icon="ei-close-o" data-size="m"></div></a>
        <h2 class="profile-modal__title">recherche</h2>
        <form class="profile-form" action="{{route('recherche')}}" method="post">
             <div class="form-row">
                <label class="form-label">age :</label>
                <section class="range-slider filter-slider">
                    <span class="rangeValues"></span> ans
                    <input name="age['min']"type="range" min="0" max="99" value="0">
                    <input name="age['max']"type="range" min="0" max="99" value="99">
                </section>
             </div>
             <div class="form-row">
                <label class="form-label">score :</label>
                <section id="score-slider" class="range-slider filter-slider">
                    <span class="rangeValues"></span> pts
                    <input name="score['min']" type="range" min="0" max="100" value="0">
                    <input name="score['max']" type="range" min="0" max="100" value="100">
                </section>
             </div>
             <div class="form-row">
                <label class="form-label">localisation :</label>
                <input size="50" type="text" name="adresse" id="adresse-input" class="form__input form-input__profile" value="">
             </div>
             <div class="form-row">
                <label class="form-label">interets :</label>
                <ul id="myTags" class="tags-input">
                
                </ul>
             </div>
            <input class="form__input btn-submit profile-submit" type="submit" name="submit" value="chercher">
        </form>
    </div>
</div>
<script src="js/doubleSlider.js"></script>
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