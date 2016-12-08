<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js" type="text/javascript" charset="utf-8"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.12/jquery-ui.min.js" type="text/javascript" charset="utf-8"></script>
<link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/flick/jquery-ui.css">
<link href="css/jquery.tagit.css" rel="stylesheet" type="text/css">
<script src="js/tag-it.js" type="text/javascript" charset="utf-8"></script>

<div id="complet-profile_modal" class="profile-modal">
    <div class="profile-modal__content">
        <h2 class="profile-modal__title">On a besoin de plus d'info !</h2>
        <form class="profile-form" action="#" method="post">
            <div class="form-row">
                <label class="form-label">Je suis</label>
                <div class="custom-radio">
                    <ul>
                        <li>
                            <input type="radio" name="sexe" id="m-option" value="homme">
                            <label for="m-option">homme</label>
                            <div class="check"></div>
                        </li>
                        <li>
                            <input type="radio" name="sexe" id="f-option" value="femme">
                            <label for="f-option">femme</label>
                            <div class="check"></div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="form-row">
                <label class="form-label">Je cherche</label>
                <div class="custom-select">
                    <select name="recherche">
                        <option disabled selected hidden style="color: #fff" class="mojo">choisir</option>
                        <option class="test" value="homme">un homme</option>
                        <option class="test" value="femme">une femme</option>
                        <option class="test" value="indifferent">indifférent</option>
                    </select>
                    <span class="accent">V</span>
                </div>
            </div>
            <div class="form-row">
                <label class="form-label">Ma date de naissance</label>
                <div class="date-select">
                    <input type="number" name="anniversaire[jour]" value="jour" class="date-input date-input__day" placeholder="jour">
                    <input type="number" name="anniversaire[mois]" value="mois" class="date-input date-input__month" placeholder="mois">
                    <input type="number" name="anniversaire[annee]" value="annee" class="date-input date-input__year" placeholder="année">
                </div>
            </div>
            <div class="form-row">
                <label class="form-label">Ma présentation</label>
                <textarea rows="2" cols="3" class="form-textarea"></textarea>
            </div>
            <div class="form-row">
                <label class="form-label">Mes interêts</label>
                <ul id="myTags" class="tags-input">
                    <li>chaise roulante</li>
                </ul>
            </div>
            <input class="form__input btn-submit profile-submit" type="submit" name="submit" value="Je suis pret">
        </form>
    </div>
</div>
<script>
    $(document).ready(function() {
        $("#myTags").tagit({
            itemName: 'item',
            fieldName: 'tags[]',
            availableTags: ["c++", "java", "php", "javascript", "ruby", "python", "c"]
        })
    });
</script>