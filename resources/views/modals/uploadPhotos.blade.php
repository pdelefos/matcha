<?php
 if (isset($errorHandler))
        $error_fichier = $errorHandler->first('fichier');
?>
<div class="profile-modal">
    <div class="profile-modal__content profilpic-modal">
            @if (isset($error_fichier) && $error_fichier != "") 
                <div class="file-error">{{$error_fichier}}</div>
            @endif
        <a href="{{ route('root') }}/profil/user/me" class="modal-close"><div data-icon="ei-close-o" data-size="m"></div></a>
        <h2 class="profile-modal__title">Upload de photo</h2>
        <form action="{{ route('photo') }}" method="post" enctype="multipart/form-data">
        <div class="photo-frame">
            <img src="" class="photo"></img>
        </div>
        <input type="number" value="{{$photoNo}}" name="photoNo" hidden>
        <input id="my-pic" type="file" name="picture" onchange="previewFile()" class="inputfile">
        <label for="my-pic" class="btn-submit pic-upload">choisir un fichier</label>
        <input class="form__input btn-submit submit-picture" type="submit" name="submit" value="envoyer">
        </form>
    </div>
</div>
<script type="text/javascript">
    function previewFile() {
        const preview = document.querySelector('.photo')
        const file = document.querySelector('input[type=file]').files[0]
        const reader = new FileReader()

        console.log(file);

        reader.onloadend = function () {
            preview.src = reader.result
        }

        if (file)
            reader.readAsDataURL(file)
        else
            preview.style = ""
    }
</script>