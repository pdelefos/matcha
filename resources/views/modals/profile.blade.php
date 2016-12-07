<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<div id="complet-profile_modal" class="profile-modal">
    <div class="profile-modal__content">
        <h2 class="profile-modal__title">On a besoin de plus d'info !</h2>
        <form class="profile-form">
            <div class="custom-radio form-row">
                <label class="form-label">Je suis :</label>
                <ul class="select-choice">
                    <li>
                        <input type="radio" name="gender" id="m-option">
                        <label for="m-option">homme</label>
                        <div class="check"></div>
                    </li>
                    <li>
                        <input type="radio" name="gender" id="f-option">
                        <label for="f-option">femme</label>
                        <div class="check"></div>
                    </li>
                </ul>
            </div>
            <div class="form-row">
                <label class="form-label">Je cherche :</label>
                <div class="custom-select">
                    <span class="accent">V</span>
                    <select>
                        <option value="" disabled selected hidden style="color: #fff">choisir</option>
                        <option value="">un homme</option>
                        <option value="">une femme</option>
                        <option value="">les deux</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <label class="form-label">Date de naissance :</label>
                <div class="date-select">
                    <input type="number" name="" value="" class="date-input" placeholder="jour">
                    <input type="number" name="" value="" class="date-input" placeholder="mois">
                    <input type="number" name="" value="" class="date-input date-input__year" placeholder="année">
                </div>
            </div>
            <div class="form-row">
                <label class="form-label">Ma présentation :</label>
                <textarea rows="2" cols="3" class="form-textarea"></textarea>
            </div>
            <div class="form-row">
                <label class="form-label">Interêts :</label>
                <select id="custom-tags" multiple="true">
                    <option value="">test 1</option>
                    <option value="">test 2</option>
                    <option value="">test 3</option>
                </select>
            </div>
            <input class="form__input btn-submit" type="submit" name="submit" value="Je suis pret">
        </form>
    </div>
</div>
<script>
    $("#custom-tags").select2({
        tags: true
    }) 
</script>