<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js" type="text/javascript" charset="utf-8"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.12/jquery-ui.min.js" type="text/javascript" charset="utf-8"></script>
<link rel="stylesheet" type="text/css" href="{{ route('root') }}/css/jquery-ui.css">
<link href="css/jquery.tagit.css" rel="stylesheet" type="text/css">
<script src="js/tag-it.js" type="text/javascript" charset="utf-8"></script>
<?php
if (isset($errorHandler)) {
    $error_sexe = $errorHandler->first('sexe');
    $error_search = $errorHandler->first('recherche');
	$error_desc = $errorHandler->first('description');
}
if (isset($prev_values)) {
	$prev_sexe = $prev_values->input('sexe');
    $prev_search = $prev_values->input('recherche');
    $prev_desc = $prev_values->input('description');
}
?>
<div id="complet-profile_modal" class="profile-modal">
    <div class="profile-modal__content">
        <h2 class="profile-modal__title">On a besoin de plus d'info !</h2>
        <form class="profile-form" action="#" method="post">
            <div class="form-row">
                <label class="form-label">Je suis</label>
                @if (isset($error_sexe) && $error_sexe != "")
                    <div class="form__error" data-error="{{ $error_sexe }}" >
                @else
                    <div>
                @endif
                        <div class="custom-radio">
                            <ul>
                                <li>
                                    @if (isset($prev_sexe) && $prev_sexe == "homme")
                                        <input type="radio" name="sexe" id="m-option" value="homme" checked>
                                    @else
                                        <input type="radio" name="sexe" id="m-option" value="homme">
                                    @endif
                                    <label for="m-option">homme</label>
                                    <div class="check"></div>
                                </li>
                                <li style="display: none;">
                                    @if (isset($prev_sexe) && ($prev_sexe == "homme" || $prev_sexe == "femme"))
                                        <input type="radio" name="sexe" id="d-option" value="">
                                    @else
                                        <input type="radio" name="sexe" id="d-option" value="" checked>
                                    @endif
                                    <div class="check"></div>
                                </li>
                                <li>
                                    @if (isset($prev_sexe) && $prev_sexe == "femme")
                                        <input type="radio" name="sexe" id="f-option" value="femme" checked>
                                    @else
                                        <input type="radio" name="sexe" id="f-option" value="femme">
                                    @endif
                                    <label for="f-option">femme</label>
                                    <div class="check"></div>
                                </li>
                            </ul>
                        </div>
                    </div>
            </div>
            <div class="form-row">
                <label class="form-label">Je cherche</label>
                @if (isset($error_search) && $error_search != "")
                    <div class="form__error" data-error="{{ $error_search }}" >
                @else
                    <div>
                @endif
                        <div class="custom-select">
                            <select name="recherche">
                                @if (isset($prev_search) && $prev_search == "")
                                    <option selected hidden style="color: #fff" value="">choisir</option>
                                @else
                                    <option hidden style="color: #fff" value="">choisir</option>
                                @endif
                                @if (isset($prev_search) && $prev_search == "homme")
                                    <option selected class="test" value="homme">un homme</option>
                                @else
                                    <option class="test" value="homme">un homme</option>
                                @endif
                                @if (isset($prev_search) && $prev_search == "femme")
                                    <option selected class="test" value="femme">une femme</option>
                                @else
                                    <option class="test" value="femme">une femme</option>
                                @endif
                                @if (isset($prev_search) && $prev_search == "indifferent")
                                    <option selected class="test" value="indifferent">indifférent</option>
                                @else
                                    <option class="test" value="indifferent">indifférent</option>
                                @endif
                            </select>
                            <span class="accent">V</span>
                        </div>
                    </div>
            </div>
            <div class="form-row">
                <label class="form-label">Ma date de naissance</label>
                <div class="custom-select">
                    <select class="date-input date-input__day" name="anniversaire[jour]">
                        @for ($i = 1; $i <= 31; $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                    <select class="date-input date-input__month" name="anniversaire[mois]">
                        @for ($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                    <select class="date-input date-input__year" name="anniversaire[annee]">
                        @for ($i = 1998; $i >= 1940; $i--)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </div>
            </div>
            <div class="form-row">
                <label class="form-label">Ma présentation</label>
                @if (isset($error_desc) && $error_desc != "")
                    <div class="form__error" data-error="{{ $error_desc }}" >
                @else
                    <div>
                @endif
                        <textarea rows="2" cols="3" class="form-textarea" name="description">{{ $prev_desc or '' }}</textarea>
                    </div>
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