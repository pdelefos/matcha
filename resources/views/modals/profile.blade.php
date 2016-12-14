<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js" type="text/javascript" charset="utf-8"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.12/jquery-ui.min.js" type="text/javascript" charset="utf-8"></script>
<link rel="stylesheet" type="text/css" href="{{ route('root') }}/css/jquery-ui.css">
<link href="css/jquery.tagit.css" rel="stylesheet" type="text/css">
<script src="js/tag-it.js" type="text/javascript" charset="utf-8"></script>
<?php

if (isset($errorHandler)) {
    $error_sexe = $errorHandler->first('sexe');
    $error_search = $errorHandler->first('recherche');
    $error_date = $errorHandler->first('anniversaire');
	$error_desc = $errorHandler->first('description');
    $error_tags = $errorHandler->first('interets');
    $error_adresse = $errorHandler->first('adresse');
}
if (isset($prev_values)) {
	$prev_sexe = $prev_values->input('sexe');
    $prev_search = $prev_values->input('recherche');
    $prev_date = $prev_values->input('anniversaire');
    $prev_desc = $prev_values->input('description');
    $prev_tags = $prev_values->input('interets');
    $prev_adresse = $prev_values->input('adresse');
}

?>
<div id="complet-profile_modal" class="profile-modal">
    <div class="profile-modal__content">
        <h2 class="profile-modal__title">On a besoin de plus d'info !</h2>
        <form class="profile-form" action="#" method="post">
            <div class="form-row">
                <label class="form-label">Je suis</label>
                @if (isset($error_sexe) && $error_sexe != "")
                    <div class="form__error form_error-profile" data-error="{{ $error_sexe }}" >
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
                    <div class="form__error form_error-profile" data-error="{{ $error_search }}" >
                @else
                    <div>
                @endif
                        <div class="custom-select">
                            <select name="orientation">
                                @if (isset($prev_search) && $prev_search == "")
                                    <option selected hidden style="color: #fff" value="">choisir</option>
                                @else
                                    <option hidden style="color: #fff" value="">choisir</option>
                                @endif
                                @if (isset($prev_search) && $prev_search == "homme")
                                    <option selected value="homme">un homme</option>
                                @else
                                    <option value="homme">un homme</option>
                                @endif
                                @if (isset($prev_search) && $prev_search == "femme")
                                    <option selected value="femme">une femme</option>
                                @else
                                    <option value="femme">une femme</option>
                                @endif
                                @if (isset($prev_search) && $prev_search == "indifferent")
                                    <option selected value="indifferent">indifférent</option>
                                @else
                                    <option value="indifferent">indifférent</option>
                                @endif
                            </select>
                            <span class="accent">V</span>
                        </div>
                    </div>
            </div>
            <div class="form-row">
                <label class="form-label">Ma date de naissance</label>
                @if (isset($error_date) && $error_date != "")
                    <div class="form__error form_error-profile" data-error="{{ $error_date }}" >
                @else
                    <div>
                @endif
                        <div class="custom-select">
                            <select class="date-input date-input__day" name="anniversaire[jour]">
                                <option selected hidden style="color: #fff" value="{{$prev_date['jour'] or ''}}">
                                    @if (isset($prev_date) && $prev_date['jour'] != "")
                                        {{ $prev_date['jour'] }}
                                    @else
                                        jour
                                    @endif
                                </option>
                                @for ($i = 1; $i <= 31; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                            <select class="date-input date-input__month" name="anniversaire[mois]">
                                <option selected hidden style="color: #fff" value="{{$prev_date['mois'] or ''}}">
                                    @if (isset($prev_date) && $prev_date['mois'] != "")
                                        {{ $prev_date['mois'] }}
                                    @else
                                        mois
                                    @endif
                                </option>
                                @for ($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                            <select class="date-input date-input__year" name="anniversaire[annee]">
                                <option selected hidden style="color: #fff" value="{{$prev_date['annee'] or ''}}">
                                    @if (isset($prev_date) && $prev_date['annee'] != "")
                                        {{ $prev_date['annee'] }}
                                    @else
                                        annee
                                    @endif
                                </option>
                                @for ($i = 1998; $i >= 1940; $i--)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
            </div>
            <div class="form-row">
                <label class="form-label">Mon adresse <a href="#" class="form-localise-link" id="localize-me">me localiser</a></label>
                @if (isset($error_adresse) && $error_adresse != "")
                    <div class="form__error form_error-profile" data-error="{{ $error_adresse }}" >
                @else
                    <div>
                @endif
                        <input type="text" name="adresse" id="adresse-input" class="form__input form-input__profile" value="{{ $prev_adresse or ''}}">
                    </div>
            </div>
            <div class="form-row">
                <label class="form-label">Ma présentation</label>
                @if (isset($error_desc) && $error_desc != "")
                    <div class="form__error form_error-profile" data-error="{{ $error_desc }}" >
                @else
                    <div>
                @endif
                        <textarea rows="2" cols="3" class="form-textarea" name="presentation">{{ $prev_desc or '' }}</textarea>
                    </div>
            </div>
            <div class="form-row">
                <label class="form-label">Mes interêts</label>
                @if (isset($error_tags) && $error_tags != "")
                    <div class="form__error form_error-profile" data-error="{{ $error_tags }}" >
                @else
                    <div>
                @endif
                        <ul id="myTags" class="tags-input">
                            @if (isset($prev_tags))
                                @foreach ($prev_tags as $tags)
                                    <li>{{ $tags }}</li>
                                @endforeach
                            @else
                                <li>cinéma</li>
                            @endif
                        </ul>
                    </div>
            </div>
            <input class="form__input btn-submit profile-submit" type="submit" name="submit" value="Je suis pret">
        </form>
    </div>
</div>
<script type="text/javascript" src="js/tags-settings.js"></script>
<script type="text/javascript" src="js/geolocalisation.js"></script>